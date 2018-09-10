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
$price = CCurrencyRates::ConvertCurrency(array_sum($arBasketItems), "RUB", "RUB");

function OnOrderAdd($sum) {
		
		//return true;
		
		CModule::IncludeModule('sale');
		CModule::IncludeModule('iblock');
		$p = $sum;
		//print_r($sum);
		if ($p<=5000) $val = 17;
		elseif ($p>5000 and $p<=10000) $val = 18;
		elseif ($p>10000 and $p<15000) $val = 19;
		else $val = 20;
		//echo '<br><br>'.$val."<br>";
		$arSelect = Array("ID", "NAME", "PROPERTY_GIFT","DETAIL_PAGE_URL","DETAIL_PICTURE");
		$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE"=>'Y', "PROPERTY_GIFT"=>$val);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		$prods = array();
		while ($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$ID = $arFields['ID'];
			/*****************************/
			$arFields = array(
			    "PRODUCT_ID" => $ID,
			    "PRODUCT_PRICE_ID" => 0,
			    "DETAIL_PICTURE"=> CFile::GetPath($arFields['DETAIL_PICTURE']),
			    "PRICE" => 0,
			    "CURRENCY" => "RUB",
			    "QUANTITY" => 1,
			    //"ORDER_ID" => $ORDER_ID,
			    "LID" => SITE_ID,
			    "DELAY" => "N",
			    "CAN_BUY" => "Y",
			    "NAME" => $arFields['NAME'],
			    "DETAIL_PAGE_URL" => $arFields['DETAIL_PAGE_URL'],
			    "PRODUCT_PROVIDER_CLASS" => ""
			  );
			
			  $arProps = array();
			
			  $arFields["PROPS"] = $arProps;
			  array_push($prods,$arFields);
			  //print_r($ID);

			//  $new = CSaleBasket::Add($arFields);
//if (!$new) die("some went wrong");
			/*****************************/
			}
		return $prods;
	}
$sum = $price;
$prods = OnOrderAdd($sum);
//print_r($prods);
//echo 'final';
?>
<div class="ajax_load table">
	<table class="module_products_list">
		<tbody>
			<? foreach($prods as $pr): ?>
			<tr class="item" id="bx_3966226736_5266">
				<td class="foto-cell">
					<div class="image_wrapper_block">
						<a class="popup_image fancy" href="/upload/iblock/34c/34c711cfe5bc5be4fb5b06522d8e3624.jpg" title="<?=$pr['NAME'];?>">
						<img src="/upload/resize_cache/iblock/cfc/50_50_0/cfcde7ca1fb7f7845314aeb11fb9acd4.jpg" alt="<?=$pr['NAME'];?>" title="<?=$pr['NAME'];?>">
						</a>
					</div>
				</td>
				<td class="item-name-cell">
						<div class="title"><a href="/catalog/0228-GIPFEL-Sitechko-VITA/"><?=$pr['NAME'];?></a></div>
						<div class="item-stock"><span class="icon stock"></span><span class="value"><?=$pr['NAME'];?></span></div>						
				</td>
				<td class="price-cell">
						<div class="cost prices clearfix">
							<div class="price"> <span> </span></div>
						</div>
						<div class="basket_props_block" id="bx_basket_div_5266" style="display: none;">
						</div>
					<div class="adaptive_button_buy">
							<!--noindex-->
					<span class="small to-cart button transition_bg" data-item="5266" data-float_ratio="" data-ratio="1" data-bakset_div="bx_basket_div_5266" data-props="" data-part_props="Y" data-add_props="Y" data-empty_props="Y" data-offers="" data-iblockid="2" data-quantity="1"><i></i><span>Выбрать</span></span><a rel="nofollow" href="/basket/" class="small in-cart button transition_bg" data-item="5266" style="display:none;"><i></i><span></span></a>							<!--/noindex-->
						</div>				
					</td>
					<td class="but-cell item_5266">
						<div class="counter_wrapp">
							<div class="counter_block" data-item="5266">
									<span class="minus">-</span>
									<input type="text" class="text" name="count_items" value="1">
									<span class="plus" data-max="497">+</span>
						</div>
					<div class="button_block ">
								<!--noindex-->
									<span class="small to-cart button transition_bg" data-item="5266" data-float_ratio="" data-ratio="1" data-bakset_div="bx_basket_div_5266" data-props="" data-part_props="Y" data-add_props="Y" data-empty_props="Y" data-offers="" data-iblockid="2" data-quantity="1"><i></i><span>В корзину</span></span><a rel="nofollow" href="/basket/" class="small in-cart button transition_bg" data-item="5266" style="display:none;"><i></i><span>В корзине</span></a>								<!--/noindex-->
							</div>
						</div>
					</td>
					<td class="like_icons  full">
						<div class="wrapp_stockers">
							<div class="like_icons">
																														<div class="wish_item_button">
												<span title="Отложить" class="wish_item to" data-item="5266" data-iblock="2"><i></i></span>
												<span title="В отложенных" class="wish_item in added" style="display: none;" data-item="5266" data-iblock="2"><i></i></span>
											</div>
																																																	<div class="compare_item_button">
												<span title="Сравнить" class="compare_item to" data-iblock="2" data-item="5266"><i></i></span>
												<span title="В сравнении" class="compare_item in added" style="display: none;" data-iblock="2" data-item="5266"><i></i></span>
											</div>
																											</div>
							</div>
						</td>
					</tr>
				<? endforeach; ?>
			</tbody>
	</table>
</div>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>