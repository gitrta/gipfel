<!-- Костыль для мерчанта Google -->
<?
 if($_SESSION['GA_ON']==true){ // метка в сессии, добавляем данные в dataLayer если разрешено
?>
<script>
window.dataLayer = window.dataLayer || []
dataLayer.push({
    'transactionId': '<?=$arResult["ORDER"]['ID']?>', // номер заказа
    'transactionTotal': '<?=$arResult["ORDER"]['PRICE']?>', // сумма заказа
    'transactionTax': '<?=$arResult["ORDER"]['TAX_VALUE']?>', // сумма налога
    'transactionShipping': '<?=$arResult["ORDER"]['PRICE_DELIVERY']?>', // стоимость доставки
    'transactionProducts': [
     <?
        $arItems=array();
        $arIds=array();
        $basItems=CSaleBasket::GetList(array(),array('ORDER_ID'=>$arResult["ORDER"]['ID'])); // достаем информацию о товарах в корзине
        while($basItem=$basItems->Fetch()){?>
    {
        'sku': '<?=$basItem['PRODUCT_ID']?>', // артикул товара
        'name': '<?=str_replace("'",'"',$basItem['NAME'])?>', // название товара
        'category': '', // тут категория, если есть
        'price': '<?=$basItem['PRICE']?>', // стоимость товара
        'quantity': '<?=$basItem['QUANTITY']?>' // количество единиц товара
    },
          <?}?>
]
});
</script>
<?}
    unset($_SESSION['GA_ON']); // удаляем метку разрешения отсылки транзакции, чтобы не было дублей
?>
<!-- End костыль для мерчанта Google -->


<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y")
{
	$APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
?>

<? if (!empty($arResult["ORDER"])): ?>

<script type="text/javascript">
if ($('#mobile_checker').is(":visible")!=true) {
(function () {
    function readCookie(name) {
        if (document.cookie.length > 0) {
            offset = document.cookie.indexOf(name + "=");
            if (offset != -1) {
                offset = offset + name.length + 1;
                tail = document.cookie.indexOf(";", offset);
                if (tail == -1) tail = document.cookie.length;
                return unescape(document.cookie.substring(offset, tail));
            }
        }
        return null;
    }

    var order_id = '<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>'; // код заказа 
    var cart_sum = '<?=$arResult["ORDER"]["PRICE"]?>'; // сумма заказа

    var uid = readCookie('_lhtm_u');
    var vid = readCookie('_lhtm_r').split('|')[1];
    var url = encodeURIComponent(window.location.href);
    var path = "https://track.leadhit.io/stat/lead_form?f_orderid=" + order_id + "&url=" + url + "&action=lh_orderid&uid=" + uid + "&vid=" + vid + "&ref=direct&f_cart_sum=" + cart_sum + "&clid=5835b505e694aa725ebaa1fb";

    var sc = document.createElement("script");
    sc.type = 'text/javascript';
    var headID = document.getElementsByTagName("head")[0];
    sc.src = path;
    headID.appendChild(sc);
})();
}





</script>




	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=Loc::getMessage("SOA_ORDER_SUC", array(
					"#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"],
					"#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
				))?>
				<? if (!empty($arResult['ORDER']["PAYMENT_ID"])): ?>
					<?=Loc::getMessage("SOA_PAYMENT_SUC", array(
						"#PAYMENT_ID#" => $arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER']
					))?>
				<? endif ?>
				<br /><br />
				<?=Loc::getMessage("SOA_ORDER_SUC1", array("#LINK#" => $arParams["PATH_TO_PERSONAL"]))?>
			</td>
		</tr>
	</table>

	<?
	if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y')
	{
		if (!empty($arResult["PAYMENT"]))
		{
			foreach ($arResult["PAYMENT"] as $payment)
			{
				if ($payment["PAID"] != 'Y')
				{
					if (!empty($arResult['PAY_SYSTEM_LIST'])
						&& array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
					)
					{
						$arPaySystem = $arResult['PAY_SYSTEM_LIST'][$payment["PAY_SYSTEM_ID"]];

						if (empty($arPaySystem["ERROR"]))
						{
							?>
							<br /><br />

							<table class="sale_order_full_table">
								<tr>
									<td class="ps_logo">
										<div class="pay_name"><?=Loc::getMessage("SOA_PAY") ?></div>
										<?=CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"width:100px\"", "", false) ?>
										<div class="paysystem_name"><?=$arPaySystem["NAME"] ?></div>
										<br/>
									</td>
								</tr>
								<tr>
									<td>
										<? if (strlen($arPaySystem["ACTION_FILE"]) > 0 && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
											<?
											$orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
											$paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
											?>
											<script>
												window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
											</script>
										<?=Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&PAYMENT_ID=".$paymentAccountNumber))?>
										<? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
										<br/>
											<?=Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&pdf=1&DOWNLOAD=Y"))?>
										<? endif ?>
										<? else: ?>
											<?=$arPaySystem["BUFFERED_OUTPUT"]; //print_r($arPaySystem);?>
										<? endif ?>
									</td>
								</tr>
							</table>

							<?
						}
						else
						{
							?>
							<span style="color:red;"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
							<?
						}
					}
					else
					{
						?>
						<span style="color:red;"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
						<?
					}
				}
			}
		}
	}
	else
	{
		?>
		<br /><strong><?=$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']?></strong>
		<?
	}
	?>

<? else: ?>

	<b><?=Loc::getMessage("SOA_ERROR_ORDER")?></b>
	<br /><br />

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST", array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?>
			</td>
		</tr>
	</table>

<? endif ?>


<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
window.criteo_q.push(
 { event: "setAccount", account: 47912}, // Это значение остается неизменным
 { event: "setEmail", email: "" }, // Может быть пустой строкой
 { event: "setSiteType", type: deviceType},
 { event: "trackTransaction", id: <?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>}
);
</script> 
<!-- Конец тэга продажи Criteo OneTag -->