<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$arID = array();

$arBasketItems = array();

$dbBasketItems = CSaleBasket::GetList(
     array(
                "NAME" => "ASC",
                "ID" => "ASC"
             ),
     array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => "NULL"
             ),
     false,
     false,
     array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS")
             );
while ($arItems = $dbBasketItems->Fetch())
{
     if ('' != $arItems['PRODUCT_PROVIDER_CLASS'] || '' != $arItems["CALLBACK_FUNC"])
     {
          CSaleBasket::UpdatePrice($arItems["ID"],
                                 $arItems["CALLBACK_FUNC"],
                                 $arItems["MODULE"],
                                 $arItems["PRODUCT_ID"],
                                 $arItems["QUANTITY"],
                                 "N",
                                 $arItems["PRODUCT_PROVIDER_CLASS"]
                                 );
          $arID[] = $arItems["ID"];
     }
}
if (!empty($arID))
     {
     $dbBasketItems = CSaleBasket::GetList(
     array(
          "NAME" => "ASC",
          "ID" => "ASC"
          ),
     array(
          "ID" => $arID,
        "ORDER_ID" => "NULL"
          ),
        false,
        false,
        array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE", "WEIGHT", "PRODUCT_PROVIDER_CLASS", "NAME")
                );
while ($arItems = $dbBasketItems->Fetch())
{	
if ($arItems['CAN_BUY']=='Y') $arBasketItems[] = $arItems['PRICE']*$arItems['QUANTITY'];
}
}

$DEP = preg_replace('/[^0-9,]/', '', $_GET['DEL_PRICE']);
$DEP = round(CCurrencyRates::ConvertCurrency($DEP, $GLOBALS["MCUR"], "RUB"));
//print_r($DEP);

if ($_GET['DEL_PRICE']==0){;
	$itog = array_sum($arBasketItems);
	$itog = round(CCurrencyRates::ConvertCurrency($itog, "RUB", $GLOBALS["MCUR"]),2);
	$itog = FormatCurrency($itog,$GLOBALS["MCUR"]);
} else {
	$itog = array_sum($arBasketItems)+$DEP;
	$itog = round(CCurrencyRates::ConvertCurrency($itog, "RUB", $GLOBALS["MCUR"]),2);
	$itog = FormatCurrency($itog,$GLOBALS["MCUR"]);
}
$price = FormatCurrency(CCurrencyRates::ConvertCurrency(array_sum($arBasketItems), "RUB", $GLOBALS["MCUR"]),$GLOBALS["MCUR"]);
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