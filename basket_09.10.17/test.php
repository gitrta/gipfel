<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->IncludeComponent(
	"bitrix:sale.export.1c", 
	"", 
	array(
		"SITE_LIST" => "s1",
		"IMPORT_NEW_ORDERS" => "N",
		"1C_SITE_NEW_ORDERS" => "s1",
		"CHANGE_STATUS_FROM_1C" => "N",
		"EXPORT_PAYED_ORDERS" => "N",
		"EXPORT_ALLOW_DELIVERY_ORDERS" => "N",
		"EXPORT_FINAL_ORDERS" => "N",
		"REPLACE_CURRENCY" => "руб.",
		"GROUP_PERMISSIONS" => array(
			0 => "1",
		),
		"USE_ZIP" => "Y",
		"INTERVAL" => "30",
		"FILE_SIZE_LIMIT" => "204800"
	),
	false
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

?>