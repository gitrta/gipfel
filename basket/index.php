<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Посуда Gipfel не перестает удивлять покупателей своим разнообразием и индивидуальностью.Флагманский интернет магазин Gipfel");
$APPLICATION->SetTitle("Корзина");
if($_SERVER['HTTP_HOST']=='gipfel.by'){
	echo '
	<style>
	#paysystem > div:last-child{
	display:none;	
	}
	#paysystem > div{
	width:100% !important;	
	}
	</style>
	';
}


//$GLOBALS["MCUR"] = 'UAH';
//$GLOBALS["KFC"] = 19.598/10;
		   
	$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket", 
	".default", 
	array(
		"COLUMNS_LIST" => array(
			0 => "NAME",
			1 => "DISCOUNT",
			2 => "PROPS",
			3 => "DELETE",
			4 => "DELAY",
			5 => "TYPE",
			6 => "QUANTITY",
			7 => "SUM",
		),
		"OFFERS_PROPS" => array(
			0 => "SIZES",
			1 => "COLOR_REF",
		),
		"PATH_TO_ORDER" => SITE_DIR."order/",
		"HIDE_COUPON" => "N",
		"PRICE_VAT_SHOW_VALUE" => "Y",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"USE_PREPAYMENT" => "N",
		"SET_TITLE" => "N",
		"AJAX_MODE_CUSTOM" => "Y",
		"SHOW_MEASURE" => "Y",
		"PICTURE_WIDTH" => "100",
		"PICTURE_HEIGHT" => "100",
		"SHOW_FULL_ORDER_BUTTON" => "Y",
		"SHOW_FAST_ORDER_BUTTON" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"QUANTITY_FLOAT" => "N",
		"ACTION_VARIABLE" => "action",
		"TEMPLATE_THEME" => "blue",
		"AUTO_CALCULATION" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"USE_GIFTS" => "N",
		"GIFTS_PLACE" => "BOTTOM",
		"GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
		"GIFTS_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_TEXT_LABEL_GIFT" => "Подарок",
		"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "undefined",
		"GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
		"GIFTS_SHOW_OLD_PRICE" => "Y",
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
		"GIFTS_SHOW_NAME" => "Y",
		"GIFTS_SHOW_IMAGE" => "Y",
		"GIFTS_MESS_BTN_BUY" => "Выбрать",
		"GIFTS_MESS_BTN_DETAIL" => "Подробнее",
		"GIFTS_PAGE_ELEMENT_COUNT" => "10",
		"GIFTS_CONVERT_CURRENCY" => "Y",
		"GIFTS_HIDE_NOT_AVAILABLE" => "N",
		"DEFERRED_REFRESH" => "N",
		"USE_DYNAMIC_SCROLL" => "Y",
		"SHOW_FILTER" => "Y",
		"SHOW_RESTORE" => "Y",
		"COLUMNS_LIST_EXT" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DISCOUNT",
			2 => "DELETE",
			3 => "DELAY",
			4 => "TYPE",
			5 => "SUM",
		),
		"COLUMNS_LIST_MOBILE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DISCOUNT",
			2 => "DELETE",
			3 => "DELAY",
			4 => "TYPE",
			5 => "SUM",
		),
		"TOTAL_BLOCK_DISPLAY" => array(
			0 => "top",
		),
		"DISPLAY_MODE" => "compact",
		"PRICE_DISPLAY_MODE" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"PRODUCT_BLOCKS_ORDER" => "props,sku,columns",
		"USE_PRICE_ANIMATION" => "Y",
		"LABEL_PROP" => array(
		),
		"CORRECT_RATIO" => "Y",
		"COMPATIBLE_MODE" => "Y",
		"LABEL_PROP_MOBILE" => "",
		"LABEL_PROP_POSITION" => "",
		"ADDITIONAL_PICT_PROP_2" => "-",
		"ADDITIONAL_PICT_PROP_28" => "-",
		"ADDITIONAL_PICT_PROP_29" => "-",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"USE_ENHANCED_ECOMMERCE" => "N"
	),
	false
);
CJSCore::Init(array("jquery","date"));
?>





<link href="/basket/basket.css?<?=rand(0,100000)?>" type="text/css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.min.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/basket/basket.js?<?=rand(0,100000)?>"></script>
<script type="text/javascript" src="/bitrix/js/main/cphttprequest.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.min.js"></script>
<script>
function afonico_alex(){

	    $('input[type="submit"]').hide();

		     var msg   = $('#order_alex').serialize();
		     var sumdost = $('#delvar .act .toright b').text().replace(" руб.","");
		     msg = 'sumdost='+sumdost+'&'+msg;

		     /*console.log(msg);
		     return false;*/
        $.ajax({
          type: 'POST',
          url: 'makeorder.php',
          data: msg,
          success: function(data) {
            //$('#results').html(data);
            if (parseInt(data)>0){

            	window.location = "/order/?ORDER_ID="+parseInt(data)

	            swal({
				  type: 'success',
				  title: 'Ваш заказ '+data+' успешно оформлен!',
				  showConfirmButton: true,
				  confirmButtonColor: '#13245e',
				}).then(function () {

				window.location = "/order/?ORDER_ID="+parseInt(data)

				})

            } else{
swal({
  title: 'Увы',
  text: 'Ошибка регистрации нового пользователя: '+data,
  type: 'error',
  confirmButtonColor: '#13245e',
}
)

            }
          },
          error:  function(xhr, str){
	    alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });
 
	    }
	function deliveryCalcProceed(arParams)
{
	var delivery_id = arParams.DELIVERY_ID;
	var getExtraParamsFunc = arParams.EXTRA_PARAMS_CALLBACK;

	function __handlerDeliveryCalcProceed(data)
	{
		var obContainer = document.getElementById('delivery_info_' + delivery_id);
		if (obContainer)
		{
			obContainer.innerHTML = data;
		}

		PCloseWaitMessage('wait_container_' + delivery_id, true);
	}

	PShowWaitMessage('wait_container_' + delivery_id, true);
	
	var url = '/bitrix/components/bitrix/sale.ajax.delivery.calculator/templates/.default/ajax.php';
	
	var TID = CPHttpRequest.InitThread();
	CPHttpRequest.SetAction(TID, __handlerDeliveryCalcProceed);

	if(!getExtraParamsFunc)
	{
		CPHttpRequest.Post(TID, url, arParams);
	}
	else
	{
		eval(getExtraParamsFunc);

		BX.addCustomEvent('onSaleDeliveryGetExtraParams', function(params){
			arParams.EXTRA_PARAMS = params;
			CPHttpRequest.Post(TID, url, arParams);
		});
	}
}


</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>