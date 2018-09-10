<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!empty($arResult["ORDER"]))
{
	$arOrder = $arResult['ORDER'];
	$vars = getOrderVars($arOrder['ID']);
	$SESSION_FLAG = $APPLICATION->get_cookie("SESSION_FLAG");
	if ($_SESSION['flag']!=$arOrder['ID'] && $SESSION_FLAG!=$arOrder['ID']){
		if (CModule::IncludeModule("sozdavatel.sms")){ 
			$phone = $vars["PROP_PHONE"];  
			
			// если телефон указан, отправить клиенту смс  
			if ($phone)  
			{
				$message =  $vars["PROP_NAME"]." ".$vars["PROP_LASTNAME"].", Ваш заказ обработан! Номер заказа: ".$arOrder['ID'].". Сумма ".$vars['PRICE']." Доставка Бесплатно (".$vars["PROP_F_DATE"]." ".$vars["PROP_F_TIME"].") Курьер за час с Вами свяжется. Ваш код на скидку при следующем заказе 179364".$arOrder['ID'].". gipfel-group.ru";

			    if (CSMS::Send($message, $phone))  
				{  
					// отправлено 
				}  
				else  
				{  
					// ошибка 
				}
			}  
		}
	}
	$_SESSION['flag']=$arOrder['ID'];
	$APPLICATION->set_cookie("SESSION_FLAG", $arOrder['ID'], time()+60*60*24*30);
	?>
            <h1 class="product_title">Заказ сформирован</h1>
			<input id="complete" value="Y" type="hidden">
            <div class="order_done_block clearfix">
                <div class="order_done_block_left">
                    <img src="<?=SITE_TEMPLATE_PATH?>/images/icons/done.jpg" alt="">
                </div>
                <div class="order_done_block_right">
                    <h2>благодарим за заказ</h2>
                    <h2>Запомните его и получите скидку при последующей покупке</h2>
                    <div class="order_done_top">                        
                        Уважаемый <strong><?=$vars['PROP_NAME']?> <?=$vars['PROP_LASTNAME']?></strong>, благодарим Вас за заказ в Gipfel-group!<br/>
                        Номер Вашего заказа: <strong><?=$arResult['ORDER']['ID']?></strong> от <?=$arOrder['DATE_INSERT_FORMAT']?><br/>
                        Способ доставки: <strong><?=$vars['ALL_DELIVERY']['NAME']?></strong><br/>
                        Стоимость доставки: <strong><?=CurrencyFormat($vars['PROP_DELIVERY_COST'], $vars["CURRENCY"])?></strong><br/>
                        <?if($vars['PROP_F_DATE'] || $vars['PROP_F_TIME']):?>Дата и время доставки: <strong><?=$vars['PROP_F_DATE']?> <?=$vars['PROP_F_TIME']?></strong><br/><?endif?>
                        Состав заказа:<br/>
                    </div>	
                    <div class="order_block order_done_block_table">
                        <div class="cart_table">
                            <div class="cart_table_item title_row">
                                <div class="cart_table_item_product">
                                    ТОВАР
                                </div>
                                <div class="cart_table_item_count">
                                    Кол-во
                                </div>
                                <div class="cart_table_item_price">
                                    Цена
                                </div>
                                <div class="cart_table_item_total">
                                    СУММА
                                </div>
                            </div>
							<?foreach($vars['PRODUCTS'] as $arItem):
							$src="";
							if ($arItem['PRODUCT']['PREVIEW_PICTURE']) $src = CFile::GetPath($arItem['PRODUCT']['PREVIEW_PICTURE']);
							elseif($arItem['PRODUCT']['DETAIL_PICTURE']) $src = CFile::GetPath($arItem['PRODUCT']['DETAIL_PICTURE']); 
							?>
                            <div class="cart_table_item">
                                <div class="cart_table_item_product">
                                    <div class="cart_table_item_product_photo">
                                        <img src="/bitrix/images/1.gif"  alt="" style="background:url(<?=$src?>) no-repeat center; background-size:contain;">
                                    </div>
                                    <div class="cart_table_item_product_info">
                                        <div class="cart_table_item_product_info_title"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></div>
                                    </div>
                                </div>
                                <div class="cart_table_item_count">
                                    <span><?=(int)$arItem['QUANTITY']?> шт.</span>
                                </div>
                                <div class="cart_table_item_price">
                                    <?if($arItem['PRICE']<0.01):?>Бесплатно<?else:?><?=FormatCurrency($arItem['PRICE'],$arItem['CURRENCY'])?><?endif?>
                                </div>
                                <div class="cart_table_item_total">
                                    <?if($arItem['PRICE']<0.01):?>Бесплатно<?else:?><?=FormatCurrency($arItem['PRICE']*$arItem['QUANTITY'],$arItem['CURRENCY'])?><?endif?>
                                </div>
                            </div>							
							<?endforeach?>
                            <?/*<div class="cart_table_item">
                                <div class="cart_table_item_product">
                                    <div class="cart_table_item_product_photo">
                                        <img src="<?=SITE_TEMPLATE_PATH?>/images/data/10.jpg" alt="">
                                    </div>
                                    <div class="cart_table_item_product_info">
                                        <div class="cart_table_item_product_info_title"><a href="/surprize.html">Ваш подарок-сюрприз от Gipfel</a></div>
                                        <div class="cart_table_item_product_description">
                                            Оформите заказ и получите подарок
                                        </div>
                                    </div>
                                </div>
                                <div class="cart_table_item_count">
                                    <span>1шт.</span>
                                </div>
                                <div class="cart_table_item_price">
                                    бесплатно
                                </div>
                                <div class="cart_table_item_total">
                                    бесплатно
                                </div>
                            </div>*/?>							
						</div>
                        <div class="order_done_block_table_total">
                            Общая сумма заказа: <?=FormatCurrency($vars['PRICE'] + $vars['PROP_DELIVERY_COST'],$vars['CURRENCY'])?>
                        </div>						
					</div>
				</div>
			</div>
            <div class="recommend clearfix">
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "page",
		"AREA_FILE_SUFFIX" => "gift",
		"EDIT_TEMPLATE" => ""
	)
);?>
			</div>
	<?
	if (!empty($arResult["PAY_SYSTEM"]) && $arResult["ORDER"]['PAY_SYSTEM_ID']!=1)
	{
		?>


		<table class="sale_order_full_table">
			<tr>
				<td class="ps_logo">
					<div class="pay_name"><?=GetMessage("SOA_TEMPL_PAY")?></div>
					<?=CFile::ShowImage($arResult["PAY_SYSTEM"]["LOGOTIP"], 100, 100, "border=0", "", false);?>
					<div class="paysystem_name"><?= $arResult["PAY_SYSTEM"]["NAME"] ?></div><br>
				</td>
			</tr>
			<?
			if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
			{
				?>
				<tr>
					<td>
						<?
						if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
						{
							?>
							<script language="JavaScript">
								window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>');
							</script>
							<?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))))?>
							<?
							if (CSalePdf::isPdfAvailable() && CSalePaySystemsHelper::isPSActionAffordPdf($arResult['PAY_SYSTEM']['ACTION_FILE']))
							{
								?><br />
								<?= GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y")) ?>
								<?
							}
						}
						else
						{
							if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
							{
								include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
							}
						}
						?>
					</td>
				</tr>
				<?
			}
			?>
		</table>
		<?
	}
}
else
{
	?>
	<b><?=GetMessage("SOA_TEMPL_ERROR_ORDER")?></b><br /><br />

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
			</td>
		</tr>
	</table>
	<?
}
?>
