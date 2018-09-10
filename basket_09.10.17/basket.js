    $(document).ready(function() {
	    	    
        SetDelId();
        var refreshIntervalId = setInterval(fuckleadhit2, 500);

        $('#delvar').on('click', 'div', function(e) {
	        $('#delvar div input').prop("checked", false);
	        $('#delvar div input').removeAttr('checked');
            $(this).find('input').prop("checked", true);
            $(this).find('input').attr('checked','');
            $('#delvar > div').removeClass('act');
            $(this).addClass('act'); 
            var dld = $(this).attr('del_id');
            var IDE = $('#PTID').val();	
            prop_id(IDE,dld);
            var delp = $(this).find('.toright b').text();
            var delp = $(this).find('.toright b').text();
            itog(delp);
        });
        
        $('#delvar').on('click', 'div', function(e) {
	        $('#ONC').val($(this).find('a').attr('onclick'));
        });
        $('#buyer').on('hover', '[name="ADDRESS_PVZ"]', function(e) {
	       $(this).attr('onclick',$("#ONC").val());
	       //$(this).click();
        });
        
        $('#paysystem').on('click', 'div', function() {
	        $('#paysystem div input').prop("checked", false);
	        $('#paysystem div input').removeAttr('checked');
            $(this).find('input').prop("checked", true);
            $(this).find('input').attr('checked','');
            $('#paysystem > div').removeClass('act');
            $(this).addClass('act');
        });

        function fuckleadhit2() {
            if ($("div").is("#lhdiv")) {
                $('#lhdiv').remove();
                clearInterval(refreshIntervalId);
            }
        }

        $('.whou').click(function() {
            $('.whou').removeClass('active');
            $(this).addClass('active');
            $('#PTID').val($(this).attr('idt'));
            pay($(this).attr('idt'));
        });

    }); 

function SetDelId() {
        var city = $('.bx-ui-sls-fake').attr('title');
        var price = parseInt($('#allSum_FORMATED').text().replace(/\D+/g, ""));
        //alert(price);
        $.get(
            "/basket/delivery.php", {
                city: city,
                price: price
            },
            onAjaxSuccess
        );

        function onAjaxSuccess(data) {
            $('#delvar').html(data);
        }
        pay($('.whou').attr('idt'));
        var delp = 0+' руб.';
        itog(delp);
    }
function itog(delid){
	$.get(
        "/basket/itog.php", {
            DEL_PRICE: delid
        },
        onAjaxSuccess4
    );
    
    function onAjaxSuccess4(data) {
        $('#itog').html(data);
    }
}   
    
function prop_id(IDE,delid){
	 $.get(
        "/basket/props.php", {
	        ID:IDE,
            del_id: delid
        },
        onAjaxSuccess5
    );

    function onAjaxSuccess5(data) {
        $('#buyer').html(data);
        $('.half .rowalex').each(function(){
			    var inw = $(this).find('input').outerWidth();
			    $('.lrow').width(inw);
		    });
    }
}
    
function pay(id) {
	var cit = $('.bx-ui-sls-fake').attr('title');
    $.get(
        "/basket/paysystem.php", {
            ID: id,
            city: cit
        },
        onAjaxSuccess2
    );

    $.get(
        "/basket/props.php", {
            ID: id,
            del_id: 1
        },
        onAjaxSuccess3
    );
    

    function onAjaxSuccess2(data) {
        $('#paysystem').html(data);
    }

    function onAjaxSuccess3(data) {
        $('#buyer').html(data);
        $('.half .rowalex').each(function(){
			    var inw = $(this).find('input').outerWidth();
			    $('.lrow').width(inw);
		    });
    }

}