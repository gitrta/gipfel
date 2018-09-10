<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
if ($arResult["ERROR_MESSAGE"]!="Ваша корзина пуста") echo ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;

if ($normalCount > 0):

?>
<div id="basket_items_list">
	<div class="bx_ordercart_order_table_container cart_table">
		<table id="basket_items">
			<thead>
				<tr>
					<td class="margin"></td>
					<?
					foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

						$arHeaders[] = $arHeader["id"];

						// remember which values should be shown not in the separate columns, but inside other columns
						if (in_array($arHeader["id"], array("TYPE")))
						{
							$bPriceType = true;
							continue;
						}
						elseif ($arHeader["id"] == "PROPS")
						{
							$bPropsColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELAY")
						{
							$bDelayColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELETE")
						{
							$bDeleteColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "WEIGHT")
						{
							$bWeightColumn = true;
						}

						if ($arHeader["id"] == "NAME"):
						?>
							<td class="item" colspan="2" id="col_<?=getColumnId($arHeader)?>">
						<?
						elseif ($arHeader["id"] == "PRICE"):
						?>
							<td class="price" id="col_<?=getColumnId($arHeader)?>">
						<?
						else:
						?>
							<td class="custom" id="col_<?=getColumnId($arHeader)?>">
						<?
						endif;
						?>
							<?=getColumnName($arHeader)?>
							</td>
					<?
					endforeach;

					if ($bDeleteColumn || $bDelayColumn):
					?>
						<td class="custom">Действие</td>
					<?
					endif;
					?>
						<td class="margin"></td>
				</tr>
			</thead>

			<tbody>
				<?

				foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):
					if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
				?>
				
				
					<tr id="<?=$arItem["ID"]?>">
						<td class="margin"></td>
						<?
						foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

							if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE"))) // some values are not shown in the columns in this template
								continue;

							if ($arHeader["id"] == "NAME"):
							?>
								<td class="itemphoto">								
									<div class="bx_ordercart_photo_container">
									
									
								    <div class="ribbons">
                                        <?if($arItem['OLD_PRICE']['PROPERTY_NOVINKA_VALUE']=="НОВИНКА"){?>							                            														
                            		    <span class="novinka"></span>
								         <?}?>
                                        <?if($arItem['OLD_PRICE']['PROPERTY_NOVINKA_VALUE']!="НОВИНКА" and $arItem['OLD_PRICE']['PROPERTY_AKCII_VALUE']=="Акция 1+1"){?>							                            														
                            		    <span class="a11"></span>
								         <?}?>		
						             </div>										
									
										<?
										if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
											$url = $arItem["PREVIEW_PICTURE_SRC"];
										elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
											$url = $arItem["DETAIL_PICTURE_SRC"];
										else:
											$url = $templateFolder."/images/no_photo.png";
										endif;
										?>

										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
											<div class="bx_ordercart_photo" style="background-size:contain; background-image:url('<?=$url?>')"></div>
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
									</div>
									<?
									if (!empty($arItem["BRAND"])):
									?>
									<div class="bx_ordercart_brand">
										<img alt="" src="<?=$arItem["BRAND"]?>" />
									</div>
									<?
									endif;
									?>
								</td>
								<td class="item">
									<div class="cart_table_item_product_info_title">
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
											<?=$arItem["NAME"]?>
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
									</div>
									<div class="cart_table_item_product_description">
										<?
										if ($bPropsColumn):
											foreach ($arItem["PROPS"] as $val):

												if (is_array($arItem["SKU_DATA"]))
												{
													$bSkip = false;
													foreach ($arItem["SKU_DATA"] as $propId => $arProp)
													{
														if ($arProp["CODE"] == $val["CODE"])
														{
															$bSkip = true;
															break;
														}
													}
													if ($bSkip)
														continue;
												}

												echo $val["NAME"].":&nbsp;<span>".$val["VALUE"]."<span><br/>";
											endforeach;
										endif;
										?>
									</div>
									<?
									if (is_array($arItem["SKU_DATA"]) && !empty($arItem["SKU_DATA"])):
										foreach ($arItem["SKU_DATA"] as $propId => $arProp):

											// if property contains images or values
											$isImgProperty = false;
											if (array_key_exists('VALUES', $arProp) && is_array($arProp["VALUES"]) && !empty($arProp["VALUES"]))
											{
												foreach ($arProp["VALUES"] as $id => $arVal)
												{
													if (isset($arVal["PICT"]) && !empty($arVal["PICT"]))
													{
														$isImgProperty = true;
														break;
													}
												}
											}

											$full = (count($arProp["VALUES"]) > 5) ? "full" : "";

											if ($isImgProperty): // iblock element relation property
											?>
												<div class="bx_item_detail_scu_small_noadaptive <?=$full?>">

													<span class="bx_item_section_name_gray">
														<?=$arProp["NAME"]?>:
													</span>

													<div class="bx_scu_scroller_container">

														<div class="bx_scu">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
																style="width: 200%; margin-left:0%;"
																class="sku_prop_list"
																>
																<?
																foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																	$selected = "";
																	foreach ($arItem["PROPS"] as $arItemProp):
																		if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																		{
																			if ($arItemProp["VALUE"] == $arSkuValue["NAME"] || $arItemProp["VALUE"] == $arSkuValue["XML_ID"])
																				$selected = "bx_active";
																		}
																	endforeach;
																?>
																	<li style="width:10%;"
																		class="sku_prop <?=$selected?>"
																		data-value-id="<?=$arSkuValue["XML_ID"]?>"
																		data-element="<?=$arItem["ID"]?>"
																		data-property="<?=$arProp["CODE"]?>"
																		>
																		<a href="javascript:void(0);">
																			<span style="background-image:url(<?=$arSkuValue["PICT"]["SRC"]?>)"></span>
																		</a>
																	</li>
																<?
																endforeach;
																?>
															</ul>
														</div>

														<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
														<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
													</div>

												</div>
											<?
											else:
											?>
												<div class="bx_item_detail_size_small_noadaptive <?=$full?>">

													<span class="bx_item_section_name_gray">
														<?=$arProp["NAME"]?>:
													</span>

													<div class="bx_size_scroller_container">
														<div class="bx_size">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
																style="width: 200%; margin-left:0%;"
																class="sku_prop_list"
																>
																<?
																foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																	$selected = "";
																	foreach ($arItem["PROPS"] as $arItemProp):
																		if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																		{
																			if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
																				$selected = "bx_active";
																		}
																	endforeach;
																?>
																	<li style="width:10%;"
																		class="sku_prop <?=$selected?>"
																		data-value-id="<?=$arSkuValue["NAME"]?>"
																		data-element="<?=$arItem["ID"]?>"
																		data-property="<?=$arProp["CODE"]?>"
																		>
																		<a href="javascript:void(0);"><?=$arSkuValue["NAME"]?></a>
																	</li>
																<?
																endforeach;
																?>
															</ul>
														</div>
														<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
														<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
													</div>

												</div>
											<?
											endif;
										endforeach;
									endif;
									?>
								</td>
							<?
							elseif ($arHeader["id"] == "QUANTITY"):
							?>
								<td class="custom">
									<span><?=getColumnName($arHeader)?>:</span>
                            <div class="cart_table_item_count_input">
													<?
													$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
													$max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
													$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
													$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
													?>
													<input
														type="text"
														size="3"
														id="QUANTITY_INPUT_<?=$arItem["ID"]?>"
														name="QUANTITY_INPUT_<?=$arItem["ID"]?>"
														size="2"
														maxlength="18"
														min="0"
														<?=$max?>
														step="<?=$ratio?>"
														style="max-width: 50px"
														value="<?=$arItem["QUANTITY"]?>"
														onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', <?=$ratio?>, <?=$useFloatQuantityJS?>)"
													>
                            </div>
                            <div class="cart_table_item_count_control">
								<a href="javascript:void(0);" class="cart_table_item_count_control_up" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up', <?=$useFloatQuantityJS?>);"></a>
								<a href="javascript:void(0);" class="cart_table_item_count_control_down" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down', <?=$useFloatQuantityJS?>);"></a>
                            </div>									
												<?
												if (!isset($arItem["MEASURE_RATIO"]))
												{
													$arItem["MEASURE_RATIO"] = 1;
												}

												if (
													floatval($arItem["MEASURE_RATIO"]) != 0
												):
												?>
													<span id="basket_quantity_control">
														<span class="basket_quantity_control">
														</span>
													</span>
												<?
												endif;
												if (isset($arItem["MEASURE_TEXT"]))
												{
													?>
														<span style="text-align: left"><?=$arItem["MEASURE_TEXT"]?></span>
													<?
												}
												?>
									<?
									echo getMobileQuantityControl(
										"QUANTITY_SELECT_".$arItem["ID"],
										"QUANTITY_SELECT_".$arItem["ID"],
										$arItem["QUANTITY"],
										$arItem["AVAILABLE_QUANTITY"],
										$useFloatQuantityJS,
										$arItem["MEASURE_RATIO"],
										$arItem["MEASURE_TEXT"]
									);
									?>
									<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
								</td>
							<?
							elseif ($arHeader["id"] == "PRICE"):
							?>
								<td class="price">
										<div class="current_price" id="current_price_<?=$arItem["ID"]?>">
											<?=$arItem["PRICE_FORMATED"]?>
										</div>
										
										<div class="old_price" id="old_price_<?=$arItem["ID"]?>">
											<?if ((int)$arItem['PRICE'] < (int)$arItem['OLD_PRICE']['PROPERTY_OLD_PRICE_VALUE'] && !empty($arItem['OLD_PRICE']['PROPERTY_OLD_PRICE_VALUE'])) {?>
												<? echo number_format($arItem['OLD_PRICE']['PROPERTY_OLD_PRICE_VALUE'], 0, ' ', ' ')?> руб.
											<?}?>
										</div>
									<?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
										<div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
										<div class="type_price_value"><?=$arItem["NOTES"]?></div>
									<?endif;?>
								</td>
							<?
							elseif ($arHeader["id"] == "DISCOUNT"):
							?>
								<td class="custom">
									<span><?=getColumnName($arHeader)?>:</span>
									<div id="discount_value_<?=$arItem["ID"]?>"><?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></div>
								</td>
							<?
							elseif ($arHeader["id"] == "WEIGHT"):
							?>
								<td class="custom">
									<span><?=getColumnName($arHeader)?>:</span>
									<?=$arItem["WEIGHT_FORMATED"]?>
								</td>
							<?
							else:
							?>
								<td class="custom">
									<span><?=getColumnName($arHeader)?>:</span>
									<?
									if ($arHeader["id"] == "SUM"):
									?>
										<div class="sum" id="sum_<?=$arItem["ID"]?>" style='white-space:nowrap;'><b>
									<?
									endif;

									echo $arItem[$arHeader["id"]];

									if ($arHeader["id"] == "SUM"):
									?>
										</b></div>
									<?
									endif;
									?>
								</td>
							<?
							endif;
						endforeach;

						if ($bDelayColumn || $bDeleteColumn):
						?>
							<td class="cart_table_item_options" style="display:table-cell;padding-left:23px;">
								<? 
								if ($bDeleteColumn):
								?>
									<div><a class="product_del" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>">Удалить из списка</a></div>
								<?
								endif;
								if ($bDelayColumn):
								?>
									<div><a class="product_fav" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>">В закладки/отложить</a></div>
								<?
								endif;
								?>
								<div><a href="#" class="product_compare">Сравнить</a></div>
							</td>
						<?
						endif;
						?>
							<td class="margin"></td>
					</tr>
					<?
					endif;
				endforeach;
				?>
<?/*<tr>
						<td class="margin"></td>
														<td class="itemphoto">
									<div class="bx_ordercart_photo_container">
										
										<a href="#">
	<div class="bx_ordercart_photo" style="background-image:url('<?=SITE_TEMPLATE_PATH?>/images/data/10.jpg')"></div>
										</a>									</div>
																	</td>
								<td class="item">
									<div class="cart_table_item_product_info_title">
										<a href="#" class="js-back">Ваша корзина пуста										</a>									</div>
									<div class="cart_table_item_product_description">
									Бесплатная доставка
																			</div>
																	</td>
															<td class="price">
										<div class="current_price" id="current_price_gift">
											бесплатно								</div>


																	</td>
															<td class="custom">
									<span>Количество:</span>
                            <div class="cart_table_item_count_input">1 шт.</div>
                            	<span style="text-align: left">шт</span>
								
								</td>
															<td class="custom">
									<span>Сумма:</span>
																			<div id="sum_20"><b>
									бесплатно</b></div>
																	</td>
														<td class="cart_table_item_options" style="display:table-cell;padding-left:23px;"> 																	
							</td>
													<td class="margin"></td>
					</tr>*/?>
			</tbody>
		</table>
	</div>
	<input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
	<input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ","))?>" />
	<input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
	<input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
	<input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="coupon_approved" value="N" />
	<input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />

	<div class="bx_ordercart_order_pay">

		<div class="bx_ordercart_order_pay_left">
			<div class="bx_ordercart_coupon">
				<?
				if ($arParams["HIDE_COUPON"] != "Y"):

					$couponClass = "";
					if (array_key_exists('COUPON_VALID', $arResult))
					{
						$couponClass = ($arResult["COUPON_VALID"] == "Y") ? "good" : "bad";
					}elseif (array_key_exists('COUPON', $arResult) && strlen($arResult["COUPON"]) > 0)
					{
						$couponClass = "good";
					}

				?>
					<span><?=GetMessage("STB_COUPON_PROMT")?></span>
					<input type="text" id="coupon" name="COUPON" value="<?=$arResult["COUPON"]?>" onchange="enterCoupon();" size="21" class="<?=$couponClass?>">
				<?else:?>
					&nbsp;
				<?endif;?>
			</div>
		</div>
		
		
                <div class="cart_bottom">
                    <!--<div class="cart_price_block">
                        ОБЩАЯ СУММА: <span class="cart_price"><?=str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"])?></span></span>
                    </div>
                    <div class="cart_deliv_price_block">
                        СТОИМОСТЬ ДОСТАВКИ: <span class="cart_deliv_price">350<span>руб</span></span>
                    </div>-->
					
				
					<?if (floatval($arResult["DISCOUNT_PRICE_ALL"]) > 0):?>
						<div class="cart_total_price_block">	
							 <div class="cart_total_price_block_wrap">СКИДКА ПО АКЦИИ:	<span id="allSum_FORMATED" class="cart_total_price"><?=str_replace(" ", "&nbsp;", FormatCurrency($arResult["DISCOUNT_PRICE_ALL"],"RUB"))?>
							 </span></div>
						</div>						
					<?endif;?>					

					
                    <div class="cart_total_price_block">
                        <div class="cart_total_price_block_wrap">ИТОГО: <span id="allSum_FORMATED" class="cart_total_price"><?=str_replace(" ", "&nbsp;", FormatCurrency($arResult["allSum"],"RUB"))?></span></div>
                    </div>
                    <div class="cart_bottom_buttons">                    
                       <!-- <a href="/catalog/" onclick="history.go(-1); return false;" class="recount">ПРОДОЛЖИТЬ ПОКУПКИ</a>
-->
 <a href="#" onclick="checkOut();" class="order_button">ОФОРМИТЬ ЗАКАЗ</a>
                    </div>
                </div>
				
		<?/*<div class="bx_ordercart_order_pay_right">
			<table class="bx_ordercart_order_sum">
				<?if ($bWeightColumn):?>
					<tr>
						<td class="custom_t1"><?=GetMessage("SALE_TOTAL_WEIGHT")?></td>
						<td class="custom_t2" id="allWeight_FORMATED"><?=$arResult["allWeight_FORMATED"]?></td>
					</tr>
				<?endif;?>
				<?if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"):?>
					<tr>
						<td><?echo GetMessage('SALE_VAT_EXCLUDED')?></td>
						<td id="allSum_wVAT_FORMATED"><?=$arResult["allSum_wVAT_FORMATED"]?></td>
					</tr>
					<tr>
						<td><?echo GetMessage('SALE_VAT_INCLUDED')?></td>
						<td id="allVATSum_FORMATED"><?=$arResult["allVATSum_FORMATED"]?></td>
					</tr>
				<?endif;?>

					<tr>
						<td class="fwb"><?=GetMessage("SALE_TOTAL")?></td>
						<td class="fwb" id="allSum_FORMATED"><?=str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"])?></td>
					</tr>
					<tr>
						<td class="custom_t1"></td>
						<td class="custom_t2" style="text-decoration:line-through; color:#828282;" id="PRICE_WITHOUT_DISCOUNT">
							<?if (floatval($arResult["DISCOUNT_PRICE_ALL"]) > 0):?>
								<?=$arResult["PRICE_WITHOUT_DISCOUNT"]?>
							<?endif;?>
						</td>
					</tr>

			</table>
			<div style="clear:both;"></div>
		</div>
		<div style="clear:both;"></div>

		<div class="bx_ordercart_order_pay_center">

			<?if ($arParams["USE_PREPAYMENT"] == "Y" && strlen($arResult["PREPAY_BUTTON"]) > 0):?>
				<?=$arResult["PREPAY_BUTTON"]?>
				<span><?=GetMessage("SALE_OR")?></span>
			<?endif;?>

			<a href="javascript:void(0)" onclick="checkOut();" class="checkout"><?=GetMessage("SALE_ORDER")?></a>
		</div>*/?>
	</div>
</div>
<?
else:
?>
<div id="basket_items_list">
	<div class="bx_ordercart_order_table_container">
            <h1 class="product_title">ВАША КОРЗИНА</h1>
            <form>
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
                        <div class="cart_table_item_options">
                            Действие
                        </div>
                    </div>
                    <div class="cart_table_item">
                        <div class="cart_table_item_product">
                            <div class="cart_table_item_product_photo">
                                <img src="<?=SITE_TEMPLATE_PATH?>/images/data/10.jpg" alt="">
                            </div>
                            <div class="cart_table_item_product_info">
                                <div class="cart_table_item_product_info_title"><a href="#" class="js-back">Оформите заказ на сумму свыше 5000 рублей и получите в подарок Бесплатную Доставку</a></div>
                                <div class="cart_table_item_product_description">
                                    На заказы внутри мкад
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
                        <div class="cart_table_item_options">
                        </div>
                    </div>
				</div>
			</form>
	</div></div>
<?endif;
?>