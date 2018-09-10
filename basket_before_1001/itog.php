<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$arID = array();

CBitrixComponent::includeComponentClass('bitrix:sale.basket.basket');
$basket = new CBitrixBasketComponent();
$basket->onIncludeComponentLang();
$basket->columns = $arColumns;
$basket->offersProps = $strOffersProps;
$basket->quantityFloat = (isset($_POST['quantity_float']) && $_POST['quantity_float'] == 'Y') ? 'Y' : 'N';
$basket->countDiscount4AllQuantity = (isset($_POST['count_discount_4_all_quantity']) && $_POST['count_discount_4_all_quantity'] == 'Y') ? 'Y' : 'N';
$basket->priceVatShowValue = (isset($_POST['price_vat_show_value']) && $_POST['price_vat_show_value'] == 'Y') ? 'Y' : 'N';
$basket->hideCoupon = (isset($_POST['hide_coupon']) && $_POST['hide_coupon'] == 'Y') ? 'Y' : 'N';
$basket->usePrepayment = (isset($_POST['use_prepayment']) && $_POST['use_prepayment'] == 'Y') ? 'Y' : 'N';
$res = $basket->recalculateBasket($_POST);
foreach ($res as $key => $value)
{
   $arRes[$key] = $value;
}
$arBasketItems = array();
$arRes['BASKET_DATA'] = $basket->getBasketItems();
foreach ($arRes['BASKET_DATA']['ITEMS']['AnDelCanBuy'] as $arItems){
	$arBasketItems[] = $arItems['PRICE']*$arItems['QUANTITY'];
}



//print_r($DEP);

if ($GLOBALS["MCUR"]=="KZT"):
$DEP = preg_replace('/[^0-9,]/', '', $_GET['DEL_PRICE']);
$DEP = round($DEP);

if ($_GET['DEL_PRICE']==0){
	$itog = array_sum($arBasketItems);
	//$itog = round(CCurrencyRates::ConvertCurrency($itog, "RUB", $GLOBALS["MCUR"]),2);
	$itog = FormatCurrency($itog,'KZT');
} else {
	$itog = array_sum($arBasketItems)+$DEP;
	//$itog = round(CCurrencyRates::ConvertCurrency($itog, "RUB", $GLOBALS["MCUR"]),2);
	$itog = FormatCurrency($itog,'KZT');
}

$price = FormatCurrency(array_sum($arBasketItems),'KZT');
else:
$DEP = preg_replace('/[^0-9,]/', '', $_GET['DEL_PRICE']);
$DEP = round(CCurrencyRates::ConvertCurrency($DEP, $GLOBALS["MCUR"], "RUB"));
if ($_GET['DEL_PRICE']==0){
	$itog = array_sum($arBasketItems);
	$itog = round(CCurrencyRates::ConvertCurrency($itog, "RUB", $GLOBALS["MCUR"]),2);
	$itog = FormatCurrency($itog,$GLOBALS["MCUR"]);
} else {
	$itog = array_sum($arBasketItems)+$DEP;
	$itog = round(CCurrencyRates::ConvertCurrency($itog, "RUB", $GLOBALS["MCUR"]),2);
	$itog = FormatCurrency($itog,$GLOBALS["MCUR"]);
}

$price = FormatCurrency(CCurrencyRates::ConvertCurrency(array_sum($arBasketItems), "RUB", $GLOBALS["MCUR"]),$GLOBALS["MCUR"]);
endif;

$dost = $_GET['DEL_PRICE'];
?>
<div id = "itcont">
	<div class = "vych">
		<div class = "frow">
			<text>Товаров на сумму: </text><span><?=$price;?></span>
			<text>Доставка: </text><span><?=$dost; ?></span>
		</div>
		
		<div class = "srow">
			<text>Итого к оплате:  </text><span><?=$itog; ?></span>
		</div>
	</div>
	<div class = "finalbutton">
	<input type = "hidden" value = "<?=$itog; ?>" name = "SUMITOG"><input type = "hidden" name = "CURITOG" value = "<?=$GLOBALS["MCUR"]; ?>">
	<input type = "submit" value = "Оформить заказ">
	</div>
</div>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>