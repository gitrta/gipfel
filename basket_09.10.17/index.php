<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");

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
			/*6 => "PRICE",*/
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
		"AUTO_CALCULATION" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"USE_GIFTS" => "Y",
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
		"GIFTS_HIDE_NOT_AVAILABLE" => "N"
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
  text: 'Ошибка регистрации нового пользователя: Email '+data+' уже используется',
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