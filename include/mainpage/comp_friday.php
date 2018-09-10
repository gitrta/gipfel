<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<? //unset($_SESSION["FRIDAY"]) ?>
<div class = "myover"></div>
<img src = "/include/mainpage/blackfriday.png" class = "frban">
<style>
	#black_friday{
	background: #1f0000;
    padding: 20px;
    box-sizing: border-box;
    border: 8px solid #4ead01;
	}
	#black_friday .image_wrapper_block > a{
		box-shadow: 0px 0px 14px 4px white;
	}
	#black_friday .prices{
		text-align: center !important;
	}
	#black_friday a,#black_friday .prices .price{
		color:white !important;
	}
	#black_friday .catalog_item{
    display: inline-block;
    vertical-align: top;
    width: 24.7%;
    padding: 6px 10px;
    float: none;
    margin: 0px;
    box-sizing: border-box;
    position: relative;
    white-space: normal;
	}
	#black_friday .item_info {
    padding: 0px 20px;
    margin-top: 15px;
	}
	.frban{
		position: fixed;
    z-index: 234;
    left: 0;
    right: 0;
    margin: auto;
    top: 16%;
	}
	.myover{
    height: 100%;
    width: 100%;
    position: fixed;
    left: 0px;
    top: 0px;
        z-index: 223;
    background: rgba(0,0,0, .7);
	}
	.myover,.frban{ <? if(!empty($_SESSION["FRIDAY"])) echo 'display:none;'; ?> }
	 <? if(empty($_SESSION["FRIDAY"])): ?>
	.wrapper, .wrapper_inner, .wrapp {
    position: static;
    }
    <? endif; ?>
</style>
<?
	if (!CModule::IncludeModule("iblock"))
    return;


$prods_FRID = array();
$prods_ART = array();
global $DB;
$addparams = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/BF/art.txt'); //  ФАЙЛ С НОВЫМИ ТОВАРАМИ
$r1 = explode("\n", $addparams);

foreach ($r1 as $item) {
	$r2=$item;	
	 $strSql = "SELECT * FROM `b_iblock_element_property` WHERE IBLOCK_PROPERTY_ID = 7 AND VALUE = '" . $item . "' ORDER BY `b_iblock_element_property`.`ID` ASC";
    $res    = $DB->Query($strSql, false, $err_mess . __LINE__)->Fetch();
    $PID    = $res['IBLOCK_ELEMENT_ID'];
	//print_r($PID."<br>");
	!empty($PID) ? array_push($prods_FRID,$PID):"";
	!empty($PID) ? array_push($prods_ART,$item):"";
}
/*$str = "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"OR\",\"True\":\"True\"},\"CHILDREN\":[";
foreach($prods_ART as $item){
	$str .= '{\"CLASS_ID\":\"CondIBProp:2:7\",\"DATA\":{\"logic\":\"Equal\",\"value\":\"'.$item.'\"}},';
}
$str = substr($str, 0, -1);
$str .="]}";
$par = $str;*/

$GLOBALS['corvus'] = array("ID" => $prods_FRID);
//print_r($corvus); die;
?>
<script>
	$('.myover,.frban').click(function(){
		$('.myover,.frban').hide();
	});
</script>
<h1 style = "text-align: center;" >АКЦИИ ЧЕРНОЙ ПЯТНИЦЫ</h1>
<div id = "black_friday">
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.top",
	"main_friday",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/basket.php",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
		"COMPATIBLE_MODE" => "Y",
		"CONVERT_CURRENCY" => "N",
		//"CUSTOM_FILTER" => $par,
		"DETAIL_URL" => "",
		"DISPLAY_COMPARE" => "N",
		"ELEMENT_COUNT" => "8",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "corvus",
		"HIDE_NOT_AVAILABLE" => "L",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "aspro_optimus_catalog",
		"INIT_SLIDER" => "N",
		"LABEL_PROP" => array(),
		"LINE_ELEMENT_COUNT" => "4",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_COMPARE" => "Сравнить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"OFFERS_LIMIT" => "5",
		"OUR_NEED" => $prods_FRID,
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array("BASE"),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array("", ""),
		"PROPERTY_CODE_MOBILE" => array(),
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SEF_MODE" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_MEASURE" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"VIEW_MODE" => "SECTION"
	)
);?><br>
</br></div>
<?	$_SESSION["FRIDAY"]='Y' ?>