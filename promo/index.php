<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Подарки любимым");
?><style>
	.right_block{
		padding-left: 0;
	}
	.product-item-big-card{
		box-sizing: border-box;
	}
	.row{
		margin:0 !important;
	}
	.product-item-list-col-3{
		
	}
</style> 
<img src="/upload/iblock/26c/26c5be0de3e5f516dbd3b5d36ecc7238.png" style="width:100%;">
<ul>
<?
	GLOBAL $arrFilteralex;
$arts = array(0 => '0349',
	1 => '0429',
	2 => '0684',
	3 => '0699',
	4 => '0728',
	5 => '0779',
	6 => '1202',
	7 => '1203',
	8 => '1440',
	9 => '1503',
	10 => '1509',
	11 => '1536',
	12 => '1537',
	13 => '1539',
	14 => '1757',
	15 => '1788',
	16 => '1899',
	17 => '1960',
	18 => '2004',
	19 => '2005',
	20 => '2006',
	21 => '2007',
	22 => '2008-S',
	23 => '2015',
	24 => '2016',
	25 => '2030',
	26 => '2084',
	27 => '2115',
	28 => '2703-S',
	29 => '2705',
	30 => '2707',
	31 => '2709',
	32 => '2710',
	33 => '2712',
	34 => '2725',
	35 => '2913',
	36 => '2914',
	37 => '3449',
	38 => '3743',
	39 => '3744',
	40 => '3745',
	41 => '5372',
	42 => '5378',
	43 => '5393',
	44 => '5397',
	45 => '5574',
	46 => '5583',
	47 => '5681',
	48 => '5736-S',
	49 => '5794-S',
	50 => '5844',
	51 => '5845',
	52 => '5906',
	53 => '5907',
	54 => '5908',
	55 => '5922',
	56 => '5927',
	57 => '5928',
	58 => '5929',
	59 => '5932',
	60 => '5933',
	61 => '5935',
	62 => '5936',
	63 => '5937',
	64 => '5938',
	65 => '5939',
	66 => '5940',
	67 => '5942',
	68 => '5943',
	69 => '5946',
	70 => '5947',
	71 => '6076',
	72 => '6115',
	73 => '6187',
	74 => '6191',
	75 => '6198',
	76 => '6317-S',
	77 => '7127',
	78 => '7149',
	79 => '7810',
	80 => '7811',
	81 => '7843',
	82 => '7901',
	83 => '7902',
	84 => '8137',
	85 => '8180',
	86 => '8187',
	87 => '8188',
	88 => '8189',
	89 => '8193',
	90 => '8433',
	91 => '8473',
	92 => '8483',
	93 => '9151',
	94 => '9212',
	95 => '9220',
	96 => '9413',
	97 => '9414',
	98 => '9621',
	99 => '9625',
	100 => '9626',
	101 => '9629',
	102 => '9630',
	103 => '9631',
	104 => '9636',
	105 => '9702',
	106 => '9856',
	107 => '9912',
);
	$arrFilteralex = Array("IBLOCK_ID"=>2, array("PROPERTY"=>array("7"=>$arts)));
	$APPLICATION->IncludeComponent(
	"bitrix:catalog.top",
	"d2",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/basket.php",
		"BRAND_PROPERTY" => "BRAND_REF",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
		"COMPARE_PATH" => "",
		"COMPATIBLE_MODE" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => $GLOBALS["MCUR"],
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"OR\",\"True\":\"True\"},\"CHILDREN\":[]}",
		"DATA_LAYER_NAME" => "dataLayer",
		"DETAIL_URL" => "",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"DISPLAY_COMPARE" => "N",
		"ELEMENT_COUNT" => "600",
		"ELEMENT_SORT_FIELD" => "catalog_PRICE_1",
		"ELEMENT_SORT_FIELD2" => "catalog_PRICE_1",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "asc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "arrFilteralex",
		"HIDE_NOT_AVAILABLE" => "L",
		"HIDE_NOT_AVAILABLE_OFFERS" => "L",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "aspro_optimus_catalog",
		"LABEL_PROP" => array(),
		"LABEL_PROP_MOBILE" => array(),
		"LABEL_PROP_POSITION" => "top-left",
		"LINE_ELEMENT_COUNT" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_COMPARE" => "Сравнить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"MESS_RELATIVE_QUANTITY_FEW" => "мало",
		"MESS_RELATIVE_QUANTITY_MANY" => "много",
		"MESS_SHOW_MAX_QUANTITY" => "Наличие",
		"OFFERS_CART_PROPERTIES" => array("COLOR_REF","SIZES_SHOES","SIZES_CLOTHES"),
		"OFFERS_FIELD_CODE" => array("",""),
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => array("SIZES_SHOES","SIZES_CLOTHES","MORE_PHOTO",""),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
		"OFFER_TREE_PROPS" => array("COLOR_REF","SIZES_SHOES"),
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array("BASE"),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array("MATERIAL","MANUFACTURER",""),
		"PROPERTY_CODE_MOBILE" => array(),
		"RELATIVE_QUANTITY_FACTOR" => "5",
		"ROTATE_TIMER" => "30",
		"SECTION_URL" => "",
		"SEF_MODE" => "N",
		"SEF_RULE" => "",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_MAX_QUANTITY" => "M",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PAGINATION" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "Y",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y",
		"VIEW_MODE" => "SECTION"
	)
);?>

</ul><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>