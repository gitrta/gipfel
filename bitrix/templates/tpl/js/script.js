var today = new Date();
var orderChange = false;
var tomorrow = new Date();
tomorrow.setDate(today.getDate() + 1);


function __alert(s) {
	$("body").append('<div id=alert style="position:fixed;width:200px; padding:10px 20px 20px; z-index:9999; background:#eee; border:1px solid #ccc;left:50%; margin-left:-100px;top:50%; margin-top:-150px; text-align:center;">'+s+'</div>');
	setTimeout("$('#alert').fadeOut(function(){$('#alert').remove();});",2000);
}


function noSundays(date) {
      return [date.getDay() != 0, ''];
}

function loadMore() {
	var tik;
	var all=0;
	var allActive=3;
	$(".pagination li").each(function(i,el){
		all++;
		if($(el).hasClass('active')) { tik=i; allActive++;}
	});
	if (all==allActive) {
		$(".js-pager-more").hide();
		$(".catalog_right .pagination").fadeOut();
	}

	$(".pagination li").each(function(i,el){
		if((tik+1)==i) {
			url = $(el).find("a").attr("href");
			url = url + "&AJAX_CALL=Y";
			$.post(url,function(data){

				$(".catalog_list").append(data);
				$(".catalog_list .grid").each(function(i,el){
					if ((i+1)%3==0) $(el).css("margin-right","0px");
					else $(el).css("margin-right","");
				});
			});
			$(el).addClass("active");
			$(el).find("a").removeAttr("href");

		}
	});
	return false;
}

$(document).ready(function(){


	$(document).on('mouseleave', '.catalog_item_grid_long', function() {
		$(this).find('.product_photos .product_small_photo').first().mouseenter();
	});

	$(document).on({
		click: function(){
			history.go(-1);
			return false;
		}
	},".js-back");
	
	$('a').not(".product_buy, .product_left a, .product_small_photo a, .select *, #bx-panel a,.bx-ios .catalog_item a,.bx-android .catalog_item a").on('click', function(e) {
		var el = $(this);
		var link = el.attr('href');
		window.location = link;
	});
	
	
	
	$(document).on({
		click: function() {
			
			NavPageNomer++;
			if (NavPageNomer >= NavPageCount) {
				$('.js-pager-more').hide();
			}
			
			var url = '?PAGEN_' + NavNum + '=' + NavPageNomer + '&SIZEN_' + NavNum + '=' + NavPageSize + '&AJAX_CALL=Y';
			$.post(url, function(data) {
				$('.catalog_list').append(data);
				$('.catalog_list .grid').each(function(i, el) {
					if ((i + 1) % 3 == 0) {
						$(el).css('margin-right', '0px');
					} else {
						$(el).css('margin-right', '');
					}
				});
			});
			$('a[id="PAGEN_' + NavNum + '_' + NavPageNomer + '"]').each(function(i, el) {
				$(this).removeAttr('href').parent().addClass('active');
			});
			return false;
		}
	}, '.js-pager-more');
	
	
	
	
	$(document).on({
		click: function (){
			if($(this).data('href')!="undefined") top.location.href=$(this).data('href');
			return false;
		}
	},".js-link");

	$(document).on({
		click: function(){
			url = "/add.php";
			data = $(this).data('buy');
			var id = $(this).attr('id');

			$.post(url,data,function(data){
				$(".cart_block").html(data);
				$("#notice").fadeIn(function(){
					setTimeout('$("#notice").fadeOut()',2000);
				});

			});
			return false;
		}
	},".js-action-buy");

	$(document).on({
		click: function(){
			url = "/add.php";
			data = $(this).data('link');
			$.post(url,data,function(data){
				notice = $("#notice").html();
				$("#notice").html("Добавлено в закладки");
				$("#notice").fadeIn(function(){
					setTimeout('$("#notice").fadeOut(function(){$("#notice").html(notice);})',2000);

				});

			});
			return false;
		}
	},".js-action-fav");

	$('[placeholder]').focus(function() {
	var input = $(this);
	  if (input.val() == input.attr('placeholder')) {
		input.val('');
		input.removeClass('placeholder');
	  }
	}).blur(function() {
	  var input = $(this);
	  if (input.val() == '' || input.val() == input.attr('placeholder')) {
		input.addClass('placeholder');
		input.val(input.attr('placeholder'));
	  }
	}).blur().parents('form').submit(function() {
	  $(this).find('[placeholder]').each(function() {
		var input = $(this);
		if (input.val() == input.attr('placeholder')) {
		  input.val('');
		}
	  })
	});
	nav_resize();
	if ($('.bx-slider').length){
	  $('.bx-slider').bxSlider();
	}

	$('.gotop').click(function(){
	  $('body, html').animate({scrollTop : 0});
	  return false;
	});
	$('.product_small_photo a').click(function(){return false;})



	// Select
  $('.slct').click(function(){

  });
	$(document).on({
		click: function(){
			var dropBlock = $(this).parent().find('.drop');
			if( dropBlock.is(':hidden') ) {
			  dropBlock.slideDown();
			  $(this).addClass('active');
			  $('.drop').find('li').click(function(){
				//return false;
				var selectResult = $(this);
				$(this).parent().parent().find('input').val(selectResult.attr('href'));
				$(this).parent().parent().find('.slct').removeClass('active').html(selectResult.text());
				dropBlock.slideUp();
				//top.location.href = selectResult.find("a").attr('href');
				return false;
			  });
			} else {
			  $(this).removeClass('active');
			  dropBlock.slideUp();
			}
			return false;
		}
	},".slct");

	if ($('.datepicker').length){
        var currentDate = $('.datepicker').datepicker({
		altField: '.datepicker',
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
		defaultDate: +2,
        firstDay: 1, 
        isRTL: false ,
        beforeShowDay:noSundays,		
		minDate: 1.5,
		maxDate: 7
      });
    }

	$('.radioblock').find('.radio').each(function(){
	  $(this).click(function(){
		var valueRadio = $(this).html();
		$(this).parent().find('.radio').removeClass('active');
		$(this).addClass('active');
		$(this).parent().find('.hideradio').prop('checked', false);
		$(this).find('input').prop('checked', true);
	  });
	});



	var item_count = 0;
	$('.catalog_item.grid').each(function(){
	  item_count++;
	  if ((item_count % 3) == 0){
		$(this).css('margin-right',0)
	  }
	});


	var timer;
	$(document).on({
		mouseenter : function(){
			var $this = $(this),
				$bigPhoto = $this.find('img'),
				$thisItem = $this.closest(".catalog_item"),
				$photos = false,
				$activePhoto = false,
				index = false,
				maxIndex = false;

			if ($thisItem.is('.grid')) {
				$photos = $thisItem.find('.catalog_item_grid_long .product_small_photo');
			}
			else {
				$photos = $thisItem.find('.catslog_item_photo .product_small_photo');
			}
			index = $photos.index($activePhoto);
			maxIndex = $photos.length - 1;
			$activePhoto = $photos.filter('.active')
			timer = setInterval(function(){
				index = (index+1 > maxIndex) ? 0 : index + 1;
				$activePhoto = $photos.removeClass('active').eq(index).addClass('active');
				$bigPhoto.attr('src', $activePhoto.find('a').attr('href'));
			}, 1000);
		},
		mouseleave : function(){
			clearInterval(timer);
		}
	}, '.catalog_item .product_big_photo');

	$(document).on({
		mouseenter : function() {
			var $this = $(this),
				$thisItem = $this.closest(".catalog_item"),
				$photos = false,
				$bigPhoto = $this.closest('.catalog_item').find('.product_big_photo img'),
				url = $this.find('a').attr('href');
			if ($thisItem.is('.grid')) {
			    $photos = $thisItem.find('.catalog_item_grid_long .product_small_photo');
			}
			else {
			    $photos = $thisItem.find('.catslog_item_photo .product_small_photo');
			}
			$photos.removeClass('active');
			$this.addClass('active');
			$bigPhoto.attr({
				src : url
			});
		}
	}, '.catalog_item .product_small_photo');

	$(document).on('mouseenter', '.product_icons img', function() {
	  $('body').append('<div id="title">'+$(this).attr('alt')+'</div>');
	  $('#title').css({
		'position' : 'absolute',
		'top' : ($(this).offset().top+$(this).height()+5),
		'left' :  $(this).offset().left
	  });
	});
	$(document).on('mouseleave', '.product_icons img', function() {
	  $('#title').remove()
	});
});


$(window).resize(function(){
	nav_resize();
})

$(window).scroll(function(){
  if ($(window).scrollTop()>300){
	if ($('.gotop').css('display')=='none'){
	  $('.gotop').fadeIn();
	}
  }else{
	if ($('.gotop').css('display')=='block'){
	  $('.gotop').fadeOut();
	}
  }

})

function nav_resize(){
	var menu_length = $('.menu').width() - $('.menu_item.catalog_menu').width();
	var menu_l = 0;
	$('.menu_item').not('.catalog_menu').each(function(){
		menu_l += $(this).children('a').width();
	})
	$('.menu_item').not('.catalog_menu').css({
		'padding-left': (menu_length-menu_l) /22-1,
		'padding-right': (menu_length-menu_l) /22-1
	})


  var menu_length = $('.menu').width() - $('.footer_copyright').width();
  var menu_l = 0;
  $('.footer_menu_item').each(function(){
	menu_l += $(this).children('a').width();
  })
  $('.footer_menu_item').css({
	'padding-left': (menu_length-menu_l) /24-2,
	'padding-right': (menu_length-menu_l) /24-2
  })
}

$(window).scroll(function(){
	var leftright = ($(document).width() - 1000)/2 - 170;
  if ($(window).scrollTop()>180){
	$('#Flash').css({'position':'fixed', 'top':'0', 'left':leftright+'px'});
	$('#Flash2').css({'position':'fixed', 'top':'0', 'right':leftright+'px'});
  }else{
	$('#Flash').css({'position':'absolute', 'top':'180px', 'left':'-170px'});
	$('#Flash2').css({'position':'absolute', 'top':'180px', 'right':'-170px'});
  }
});
$(document).ready(function() {

    $('.bx-ios .catalog_item a,.bx-android .catalog_item a').on('click',function(e){
        var item = $(this).parents('.catalog_item');
            isActive = item.hasClass('active');

        if(!isActive){
            e.preventDefault();
            item.siblings().removeClass('active');
            item.addClass('active');
        }
    });
	$('body').on('submit','#add_reviev_form',function(){
	var element=$(this);
	if ($(this).find('input[name=NAME]').val()!=''&&$(this).find('input[name=EMAIL]').val()!=''&&$(this).find('[name=PREVIEW_TEXT]').val()!='')
	{
		SendAnalyticsGoal('otprav_otziv');	
		var data=$(this).serialize();
	
		$.ajax({
		  type: "POST",
		  url:$(this).attr('action'),
		  data: data,
			success: function(rez)
			{
				element.find('#rezult').html(rez);
				if (element.find('#rezult').find('p').data('error')!='1')
				{
					element.find('input, textarea').each(function(){
						if ($(this).attr('name')!='iblock_submit'){
							$(this).val('');
						}
					});
				}
			}
		
		});
	}
	else
	{element.find('#rezult').html('<p style="color:#990000;">Не все поля заполнены</p>');}



		return false;


	});
    $(document).on('change','#ORDER_PROP_11, #ORDER_PROP_12',function(){
        DeliveryCost();
        orderChange = true;
    });
    
    
    goalCheck = setInterval(function(){
        if ($('.popup_leadhit_wrapper_discount_btn').length) {
            $('.popup_leadhit_wrapper_discount_btn').click(function(){
                if ($(this).hasClass('active')) {
                    SendAnalyticsGoal('vspliv_okno');
                }
            });
            clearInterval(goalCheck);
        }
    }, 500);
    $('#deferred-products__form-submit').click(function(){
        if ($('.deferred-products__input_email').val() != '' && !$('.deferred-products__input_email').hasClass('deferred-products__input_error')) {
            SendAnalyticsGoal('vspliv_okno');
        }
    });
});


function setPrice(result){
    if($('.cart_price_block').length > 0) {
        var cost;
        if (result.value > 0 || result.value2 > 0) {

            var costAll = parseInt($('#ORDER_PRICE').val()),
                formated = ' <span>руб.</span>';
            cost = costAll > 5000 ? result.value : result.value+350;

            costAll = String(costAll + cost);
            costAll = costAll.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
            $('.cart_total_price').html(costAll + formated);
            $('#devCost .cart_price').html(cost + formated);
            $('#ORDER_PROP_17').val(cost);
            $('#DELIVERY_PRICE').val(cost);
            $('#devCost').show();

        } else {
            $('#devCost').hide();
            $('#ORDER_PROP_17').val('');
			$('#DELIVERY_PRICE').val('');
        }

    }
}




function setLocation(coord){

    if(!orderChange) {
        $.ajax({
            url: "https://geocode-maps.yandex.ru/1.x/?format=json&kind=house&results=1&geocode=" + coord[1] + "," + coord[0],
            success: function (data) {


                console.log(data.response.GeoObjectCollection);
                var issetAddress = data.response.GeoObjectCollection.featureMember.length > 0;

                if (issetAddress) {
                    var address = data.response.GeoObjectCollection.featureMember[0].GeoObject.metaDataProperty.GeocoderMetaData;

                    if(address.AddressDetails.Country.AdministrativeArea.hasOwnProperty('Locality'))
                        var city = address.AddressDetails.Country.AdministrativeArea.Locality;
                    else
                        var city = address.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality;


                    if(city.hasOwnProperty('Thoroughfare')) {
                        var street = city.Thoroughfare.ThoroughfareName,
                            house = city.Thoroughfare.Premise.PremiseNumber;
                    }

                    else if(city.hasOwnProperty('DependentLocality')) {
                        var street = city.DependentLocality.Thoroughfare.ThoroughfareName,
                            house = city.DependentLocality.Thoroughfare.Premise.PremiseNumber;
                    }

                    else {
                        var street = city.SubAdministrativeAreaName,
                            house = city.Premise.PremiseNumber;
                    }

                    $('#ORDER_PROP_6_val').val(city.LocalityName);
                    $('#ORDER_PROP_11').val(street);
                    $('#ORDER_PROP_12').val(house);
                } else {
                    $('#ORDER_PROP_11').val("");
                    $('#ORDER_PROP_12').val("");
                }
            }
        });
    }
}




function DeliveryCost(){
    TimeDevCost = setTimeout( function() {

        var street = $('#ORDER_PROP_11').val(),
            city = $('#ORDER_PROP_6_val').val(),
            dom = $('#ORDER_PROP_12').val();
        if (street.length > 0 && dom.length) {
            $('.ymaps-b-form-input__input').val(city + ', ' +street + ', ' + dom);
          //  $('.ymaps-b-form-input__input').change();
            $('.ymaps-b-search__button .ymaps-b-form-button__text').click();
            clearTimeout(TimeDevCost);
        }

    }, 5000);
}

function SendAnalyticsGoal(event) {
   	ga('send', 'event', event, document.URL);
	yaCounter39898360.reachGoal(event);
	console.log(event); 
}
