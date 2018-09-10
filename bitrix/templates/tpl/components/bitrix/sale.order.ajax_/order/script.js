var phone=false;

var TimeDevCost;

$(function(){

    //DeliveryCost();


    $('#ORDER_FORM').keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });


	initTel();
	$(document).on({
		change: function(){
			initSteps();
		}
	},"#ORDER_FORM input[type=text]");
	if ($("#complete").val()!="Y") {
		initSteps();
		initAutocompleteStreet();
	}
});




function initTel() {
	$("#ORDER_PROP_3").mask("+7(999) 999-99-99",{completed:function(){ phone=true; $("#ORDER_PROP_3").trigger("change"); }});
}
function initSteps() {
	if ($("#complete").val()=="Y") return true;
	if ($("#prop_NAME input").val()=="undefined") return false;
	var stepForm=0;
	if( $("#prop_NAME input").val().length>1 && phone==true) {
		$(".propWrapEMAIL,.blockCity, .blockDelivery").slideDown("fast");
		stepForm=1;
	}
	if (stepForm==1 && ($("#ORDER_PROP_6_val").val()>2 || $("#ORDER_PROP_6").val()>0) ) {
		$(".hide").removeClass("hide");
		if ($("#ORDER_PROP_6").val()!=671) $(".propWrapF_METRO").show().css("visibility","hidden");
	}
}
function initAutocompleteStreet() {
	if ($("#ORDER_PROP_6").val()=="undefined") return false;
	if ($("#ORDER_PROP_6").val()!=671) return false;
	$("#prop_STREET input").autocomplete({
	serviceUrl: '/street.php',
	minChars:2,
	delimiter: /(,|;)\s*/, // regex or character
	maxHeight:200,
	width:300,
	zIndex: 9999,
	deferRequestBy: 0, //miliseconds
	params: { metro:'Yes' }, //aditional parameters
	noCache: false, //default is false, set to true to disable caching
	// callback function:
	onSelect: function(value, data){  }
	});
	autoCompleteMetro();
}
 BX.addCustomEvent('onAjaxSuccess', function() {
	if ($("#complete")=="Y") return;
	initTel();
	initSteps();
	initAutocompleteStreet();
    if ($(".datepicker" ).length){
		$(".datepicker" ).datepicker({
		  closeText: 'Закрыть', 
		  prevText: '&#x3c;Пред', 
		  nextText: 'След&#x3e;', 
		  currentText: 'Сегодня', 
		  monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь', 
		  'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], 
		  monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн', 
		  'Июл','Авг','Сен','Окт','Ноя','Дек'], 
		  dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'], 
		  dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'], 
		  dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'], 
		  dateFormat: 'dd.mm.yy', 
		  firstDay: 1, 
		  minDate: new Date(),
beforeShowDay: noSundays,
		  isRTL: false 
		});	
	}
    $('.radioblock').find('.radio').each(function(){
      $(this).click(function(){
        var valueRadio = $(this).html();
        $(this).parent().find('.radio').removeClass('active');
        $(this).addClass('active');
        $(this).parent().find('input').val(valueRadio);
      });
    });		
 });