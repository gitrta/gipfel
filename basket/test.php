<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$order = CSaleOrder::GetByID(9929);
$itog = round($order['PRICE']);
$price = FormatCurrency(CCurrencyRates::ConvertCurrency($itog, "RUB", $GLOBALS["MCUR"]),$GLOBALS["MCUR"]);
print_r($order);
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");

