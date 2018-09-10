<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$picHeight = 164;

if (!empty($arResult['ITEMS']))
{

	$templateData = array(
		'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
		'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
	);

	CJSCore::Init(array("popup"));
	$arSkuTemplate = array();
	if (!empty($arResult['SKU_PROPS']))
	{
		foreach ($arResult['SKU_PROPS'] as &$arProp)
		{
			ob_start();
			if ('TEXT' == $arProp['SHOW_MODE'])
			{
				if (5 < $arProp['VALUES_COUNT'])
				{
					$strClass = 'bx_item_detail_size full';
					$strWidth = ($arProp['VALUES_COUNT']*20).'%';
					$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'bx_item_detail_size';
					$strWidth = '100%';
					$strOneWidth = '20%';
					$strSlideStyle = 'display: none;';
				}
				?><div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
				foreach ($arProp['VALUES'] as $arOneValue)
				{
					?><li
						data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID']; ?>"
						data-onevalue="<? echo $arOneValue['ID']; ?>"
						style="width: <? echo $strOneWidth; ?>;"
					><i></i><span class="cnt"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></span></li><?
				}
?></ul></div>
		<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
		<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
	</div>
</div><?
			}
			elseif ('PICT' == $arProp['SHOW_MODE'])
			{
				if (5 < $arProp['VALUES_COUNT'])
				{
					$strClass = 'bx_item_detail_scu full';
					$strWidth = ($arProp['VALUES_COUNT']*20).'%';
					$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'bx_item_detail_scu';
					$strWidth = '100%';
					$strOneWidth = '20%';
					$strSlideStyle = 'display: none;';
				}
				?><div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
				foreach ($arProp['VALUES'] as $arOneValue)
				{
					?><li
						data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID'] ?>"
						data-onevalue="<? echo $arOneValue['ID']; ?>"
						style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"
						><i title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"></i>
						<span class="cnt"><span class="cnt_item"
						style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');"
						title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"
					></span></span></li><?
				}
?></ul></div>
		<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
		<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
	</div>
</div><?
			}
			$arSkuTemplate[$arProp['CODE']] = ob_get_contents();
			ob_end_clean();
		}
		unset($arProp);
	}
?>

<?
	if ($arParams["DISPLAY_TOP_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}

	$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
	$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
	$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
?><div class="catalog_list list bx_catalog_list_home col<? echo $arParams['LINE_ELEMENT_COUNT']; ?> <? echo $templateData['TEMPLATE_CLASS']; ?>"><?
if ($arParams['AJAX_MODE']=="Y") $APPLICATION->RestartBuffer();
foreach ($arResult['ITEMS'] as $key => $arItem)
{
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
	$strMainID = $this->GetEditAreaId($arItem['ID']);

$renderImage = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], Array("width" => 222, "height" => $picHeight),BX_RESIZE_IMAGE_EXACT);
$arItem['PREVIEW_PICTURE']['SRC'] = $renderImage['src'];

	$arItemIDs = array(
		'ID' => $strMainID,
		'PICT' => $strMainID.'_pict',
		'SECOND_PICT' => $strMainID.'_secondpict',

		'QUANTITY' => $strMainID.'_quantity',
		'QUANTITY_DOWN' => $strMainID.'_quant_down',
		'QUANTITY_UP' => $strMainID.'_quant_up',
		'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
		'BUY_LINK' => $strMainID.'_buy_link',
		'SUBSCRIBE_LINK' => $strMainID.'_subscribe',

		'PRICE' => $strMainID.'_price',
		'DSC_PERC' => $strMainID.'_dsc_perc',
		'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',

		'PROP_DIV' => $strMainID.'_sku_tree',
		'PROP' => $strMainID.'_prop_',
		'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
		'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
	);

	$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

	$strTitle = (
		isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
		? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
		: $arItem['NAME']
	);
	?><div class="catalog_item grid <? echo ($arItem['SECOND_PICT'] ? 'bx_catalog_item double' : 'bx_catalog_item'); ?>"><div class="bx_catalog_item_container" id="<? echo $strMainID; ?>">
                            <div class="catalog_item_grid_short">
							<?
	if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT'])
	{
	?>
			<div
				id="<? echo $arItemIDs['DSC_PERC']; ?>"
				class="bx_stick_disc right top"
				style="display:<? echo (0 < $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ? '' : 'none'); ?>;">-<? echo $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%</div>
	<?
	}
	if ($arItem['LABEL'])
	{
	?>
			<div class="bx_stick average left top" title="<? echo $arItem['LABEL_VALUE']; ?>"><? echo $arItem['LABEL_VALUE']; ?></div>
	<?
	}							
							?>
                                <div class="product_big_photo">
								    <div class="ribbons">
                                        <?if($arItem['PROPERTIES']['NOVINKA']['VALUE']=="НОВИНКА"){?>							                            														
                            		    <span class="novinka"></span>
								         <?}?>
                                        <?if($arItem['PROPERTIES']['NOVINKA']['VALUE']!="НОВИНКА" and $arItem['PROPERTIES']['AKCII']['VALUE']=="Акция 1+1"){?>							                            														
                            		    <span class="a11"></span>
								         <?}?>		

						             </div>		
                                    <img src="<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="">
                                </div>
                                <div class="catalog_item_title"><?=$arItem['NAME']?></div>
<div id="<? echo $arItemIDs['PRICE']; ?>" class="catalog_item_grid_short_price bx_price"><?
	if (!empty($arItem['MIN_PRICE']))
	{
		if ('N' == $arParams['PRODUCT_DISPLAY_MODE'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
		{
			echo GetMessage(
				'CT_BCS_TPL_MESS_PRICE_SIMPLE_MODE',
				array(
					'#PRICE#' => $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
					'#MEASURE#' => GetMessage(
						'CT_BCS_TPL_MESS_MEASURE_SIMPLE_MODE',
						array(
							'#VALUE#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
							'#UNIT#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_NAME']
						)
					)
				)
			);
		}
		else
		{?>
			<div class="product_price">		
		<?
			echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
			?>
			</div>
			<?
		}
		if ((int)$arItem['MIN_PRICE']['VALUE'] < (int)$arItem['PROPERTIES']['OLD_PRICE']['VALUE'] && !empty($arItem['PROPERTIES']['OLD_PRICE']['VALUE']))
		{
			?>                                     <div class="product_old_price"><? echo number_format($arItem['PROPERTIES']['OLD_PRICE']['VALUE'], 0, ' ', ' ')?> руб.</div><?
		}
	}
	?></div>
<?
	if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS']))
	{
		?><div class="bx_catalog_item_controls"><?
		if ($arItem['CAN_BUY'])
		{
			if ('Y' == $arParams['USE_PRODUCT_QUANTITY'])
			{
			?>
		<div class="bx_catalog_item_controls_blockone"><div style="display: inline-block;position: relative;">
			<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
			<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
			<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
			<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo $arItem['CATALOG_MEASURE_NAME']; ?></span>
		</div></div>
			<?
			}
			?>
		<div class="bx_catalog_item_controls_blocktwo">
			<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium product_buy" href="javascript:void(0)" rel="nofollow"><?
			echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
			?></a>
		</div>
			<?
		}
		else
		{
			?><div class="bx_catalog_item_controls_blockone"><span class="bx_notavailable"><?
			echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));
			?></span></div><?
			if ('Y' == $arParams['PRODUCT_SUBSCRIPTION'] && 'Y' == $arItem['CATALOG_SUBSCRIPTION'])
			{
			?>
			<div class="bx_catalog_item_controls_blocktwo">
				<a
					id="<? echo $arItemIDs['SUBSCRIBE_LINK']; ?>"
					class="bx_bt_button_type_2 bx_medium"
					href="javascript:void(0)"><?
					echo ('' != $arParams['MESS_BTN_SUBSCRIBE'] ? $arParams['MESS_BTN_SUBSCRIBE'] : GetMessage('CT_BCS_TPL_MESS_BTN_SUBSCRIBE'));
					?>
				</a>
			</div><?
			}
		}
		?><div style="clear: both;"></div></div><?
		if (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']))
		{
/*?>
			<div class="bx_catalog_item_articul">
<?
			foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp)
			{
				?><br><strong><? echo $arOneProp['NAME']; ?></strong> <?
					echo (
						is_array($arOneProp['DISPLAY_VALUE'])
						? implode('<br>', $arOneProp['DISPLAY_VALUE'])
						: $arOneProp['DISPLAY_VALUE']
					);
			}
?>
			</div>
<?*/
		}
		$emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
		if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
		{
?>
		<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
<?
			if (!empty($arItem['PRODUCT_PROPERTIES_FILL']))
			{
				foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
				{
?>
					<input
						type="hidden"
						name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
						value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>"
						>
<?
					if (isset($arItem['PRODUCT_PROPERTIES'][$propID]))
						unset($arItem['PRODUCT_PROPERTIES'][$propID]);
				}
			}
			$emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
			if (!$emptyProductProperties)
			{
?>
				<table>
<?
					foreach ($arItem['PRODUCT_PROPERTIES'] as $propID => $propInfo)
					{
?>
						<tr><td><? echo $arItem['PROPERTIES'][$propID]['NAME']; ?></td>
							<td>
<?
								if(
									'L' == $arItem['PROPERTIES'][$propID]['PROPERTY_TYPE']
									&& 'C' == $arItem['PROPERTIES'][$propID]['LIST_TYPE']
								)
								{
									foreach($propInfo['VALUES'] as $valueID => $value)
									{
										?><label><input
										type="radio"
										name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
										value="<? echo $valueID; ?>"
										<? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>
										><? echo $value; ?></label><br><?
									}
								}
								else
								{
									?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
									foreach($propInfo['VALUES'] as $valueID => $value)
									{
										?><option
										value="<? echo $valueID; ?>"
										<? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>
										><? echo $value; ?></option><?
									}
									?></select><?
								}
?>
							</td></tr>
<?
					}
?>
				</table>
<?
			}
?>
		</div>
<?
		}

		$arJSParams = array(
			'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_ADD_BASKET_BTN' => false,
			'SHOW_BUY_BTN' => true,
			'SHOW_ABSENT' => true,
			'PRODUCT' => array(
				'ID' => $arItem['ID'],
				'NAME' => $arItem['~NAME'],
				'PICT' => ('Y' == $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE']),
				'CAN_BUY' => $arItem["CAN_BUY"],
				'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
				'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
				'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
				'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
				'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
				'ADD_URL' => $arItem['~ADD_URL'],
				'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL']
			),
			'BASKET' => array(
				'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
				'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
				'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
				'EMPTY_PROPS' => $emptyProductProperties
			),
			'VISUAL' => array(
				'ID' => $arItemIDs['ID'],
				'PICT_ID' => ('Y' == $arItem['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
				'QUANTITY_ID' => $arItemIDs['QUANTITY'],
				'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
				'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
				'PRICE_ID' => $arItemIDs['PRICE'],
				'BUY_ID' => $arItemIDs['BUY_LINK'],
				'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV']
			),
			'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
		);
		unset($emptyProductProperties);
		?><script type="text/javascript">
		var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
		</script><?
	}
	else
	{
		if ('Y' == $arParams['PRODUCT_DISPLAY_MODE'])
		{
			?>
		<div class="bx_catalog_item_controls no_touch">
			<?
			if ('Y' == $arParams['USE_PRODUCT_QUANTITY'])
			{
			?>
		<div class="bx_catalog_item_controls_blockone">
			<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
			<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
			<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
			<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"></span>
		</div>
			<?
			}
			?>
		<div class="bx_catalog_item_controls_blocktwo">
			<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium" href="javascript:void(0)" rel="nofollow"><?
			echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
			?></a>
		</div>
				<div style="clear: both;"></div>
			</div>
			<?
		}
		else
		{
			?>
		<div class="bx_catalog_item_controls no_touch">
			<a class="bx_bt_button_type_2 bx_medium" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><?
			echo ('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('CT_BCS_TPL_MESS_BTN_DETAIL'));
			?></a>
		</div>
			<?
		}
		?>
		<div class="bx_catalog_item_controls touch">
			<a class="bx_bt_button_type_2 bx_medium" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><?
			echo ('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('CT_BCS_TPL_MESS_BTN_DETAIL'));
			?></a>
		</div>
		<?
		$boolShowOfferProps = ('Y' == $arParams['PRODUCT_DISPLAY_MODE'] && $arItem['OFFERS_PROPS_DISPLAY']);
		$boolShowProductProps = (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']));
		if ($boolShowProductProps || $boolShowOfferProps)
		{
?>
			<div class="bx_catalog_item_articul">
<?
			if ($boolShowProductProps)
			{
				foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp)
				{
				?><br><strong><? echo $arOneProp['NAME']; ?></strong> <?
					echo (
						is_array($arOneProp['DISPLAY_VALUE'])
						? implode(' / ', $arOneProp['DISPLAY_VALUE'])
						: getSymbol($arOneProp)
                    );
				}
			}
			if ($boolShowOfferProps)
			{
?>
				<span id="<? echo $arItemIDs['DISPLAY_PROP_DIV']; ?>" style="display: none;"></span>
<?
			}
?>
			</div>

<?
		}
		if ('Y' == $arParams['PRODUCT_DISPLAY_MODE'])
		{
			if (!empty($arItem['OFFERS_PROP']))
			{
				$arSkuProps = array();
				?><div class="bx_catalog_item_scu" id="<? echo $arItemIDs['PROP_DIV']; ?>"><?
				foreach ($arSkuTemplate as $code => $strTemplate)
				{
					if (!isset($arItem['OFFERS_PROP'][$code]))
						continue;
					echo '<div>', str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $strTemplate), '</div>';
				}
				foreach ($arResult['SKU_PROPS'] as $arOneProp)
				{
					if (!isset($arItem['OFFERS_PROP'][$arOneProp['CODE']]))
						continue;
					$arSkuProps[] = array(
						'ID' => $arOneProp['ID'],
						'SHOW_MODE' => $arOneProp['SHOW_MODE'],
						'VALUES_COUNT' => $arOneProp['VALUES_COUNT']
					);
				}
				foreach ($arItem['JS_OFFERS'] as &$arOneJs)
				{
					if (0 < $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'])
						$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
				}
				unset($arOneJs);
				?></div><?
				if ($arItem['OFFERS_PROPS_DISPLAY'])
				{
					foreach ($arItem['JS_OFFERS'] as $keyOffer => $arJSOffer)
					{
						$strProps = '';
						if (!empty($arJSOffer['DISPLAY_PROPERTIES']))
						{
							foreach ($arJSOffer['DISPLAY_PROPERTIES'] as $arOneProp)
							{
								$strProps .= '<br>'.$arOneProp['NAME'].' <strong>'.(
									is_array($arOneProp['VALUE'])
									? implode(' / ', $arOneProp['VALUE'])
									: $arOneProp['VALUE']
								).'</strong>';
							}
						}
						$arItem['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
					}
				}
				$arJSParams = array(
					'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
					'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
					'SHOW_ADD_BASKET_BTN' => false,
					'SHOW_BUY_BTN' => true,
					'SHOW_ABSENT' => true,
					'SHOW_SKU_PROPS' => $arItem['OFFERS_PROPS_DISPLAY'],
					'SECOND_PICT' => $arItem['SECOND_PICT'],
					'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
					'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
					'DEFAULT_PICTURE' => array(
						'PICTURE' => $arItem['PRODUCT_PREVIEW'],
						'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
					),
					'VISUAL' => array(
						'ID' => $arItemIDs['ID'],
						'PICT_ID' => $arItemIDs['PICT'],
						'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
						'QUANTITY_ID' => $arItemIDs['QUANTITY'],
						'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
						'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
						'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
						'PRICE_ID' => $arItemIDs['PRICE'],
						'TREE_ID' => $arItemIDs['PROP_DIV'],
						'TREE_ITEM_ID' => $arItemIDs['PROP'],
						'BUY_ID' => $arItemIDs['BUY_LINK'],
						'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
						'DSC_PERC' => $arItemIDs['DSC_PERC'],
						'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
						'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
					),
					'BASKET' => array(
						'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
						'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
						'SKU_PROPS' => $arItem['OFFERS_PROP_CODES']
					),
					'PRODUCT' => array(
						'ID' => $arItem['ID'],
						'NAME' => $arItem['~NAME']
					),
					'OFFERS' => $arItem['JS_OFFERS'],
					'OFFER_SELECTED' => $arItem['OFFERS_SELECTED'],
					'TREE_PROPS' => $arSkuProps,
					'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
				);
				?>
<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
</script>
				<?
			}
		}
	}
?>
                            </div>
                            <div class="catalog_item_grid_long">
                                <div class="product_photos">
                                    <div class="product_small_photo active">


                                        <a href="<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>"><img src="<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt=""></a>
                                    </div>
<?if($arItem['PROPERTIES']['MORE_PHOTO']['VALUE']):?>	
<?foreach($arItem['PROPERTIES']['MORE_PHOTO']['VALUE'] as $v):

$renderImage = CFile::ResizeImageGet($v, Array("width" => 222, "height" => $picHeight),BX_RESIZE_IMAGE_EXACT);
$src=  $renderImage['src']; //CFile::GetPath($v);?>							
                                    <div class="product_small_photo">
                                        <a href="<?=$src?>"><img src="<?=$src?>" alt=""></a>
                                    </div>
<?endforeach?>									
<?endif?>
                                </div>
                                <div class="catalog_item_grid_long_right">
                                <div class="product_big_photo">
                                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt=""></a>
                                </div>
                                    <div class="catalog_item_title"><?=$arItem['NAME']?></div>
<div id="<? echo $arItemIDs['PRICE']; ?>" class="catalog_item_grid_short_price bx_price"><?
	if (!empty($arItem['MIN_PRICE']))
	{
		if ('N' == $arParams['PRODUCT_DISPLAY_MODE'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
		{
			echo GetMessage(
				'CT_BCS_TPL_MESS_PRICE_SIMPLE_MODE',
				array(
					'#PRICE#' => $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
					'#MEASURE#' => GetMessage(
						'CT_BCS_TPL_MESS_MEASURE_SIMPLE_MODE',
						array(
							'#VALUE#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
							'#UNIT#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_NAME']
						)
					)
				)
			);
		}
		else
		{
			?>
			<div class="product_price">		
		<?
			echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
			?>
			</div>
			<?
		}
		if ((int)$arItem['MIN_PRICE']['VALUE'] < (int)$arItem['PROPERTIES']['OLD_PRICE']['VALUE'] && !empty($arItem['PROPERTIES']['OLD_PRICE']['VALUE']))
		{
			?>                                     <div class="product_old_price"><? echo number_format($arItem['PROPERTIES']['OLD_PRICE']['VALUE'], 0, ' ', ' ')?> руб.</div><?
		}
	}
	?></div>
	
 <?$APPLICATION->IncludeComponent(
	"tarakud:sale.order.oneclick",
	"",
	Array(
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CONFIRM_ORDER" => "Спасибо. Ваш заказ принят.",
		"DELIVERY" => "1",
		"DELIVERY_SHOW" => "N",
		"EVENT_MESSAGE_ID" => array("18"),
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "catalog",
		"IMAGE_HEIGHT" => "130",
		"IMAGE_WIDTH" => "130",
		"IS_JQUERY" => "Y",
		"OFFERS_PROPERTY_CODE" => array("", ""),
		"OFFERS_SHOW" => "all",
		"ORDER_PRODUCT" => "2",
		"ORDER_STATUS" => "N",
		"PAYSYSTEM" => "1",
		"PERSON_TYPE" => "1",
		"PERSON_TYPE_PROPS" => array("3"),
		"PRICE_CODE" => "BASE",
		"PRODUCT_ID" => $arItem['ID'],
		"TITLE_POPUP" => "Оформление заказа в один клик",
		"USER_ID" => "",
		"USE_CAPTCHA" => "N",
		"USE_COMMENT" => "N",
		"USE_COUNT" => "Y",
		"USE_USER" => "Y"
	)
);?>	
	
<div class="bx_catalog_item_controls"><?
		if ($arItem['CAN_BUY'])
		{
			if ('Y' == $arParams['USE_PRODUCT_QUANTITY'])
			{
			?>
		<div class="bx_catalog_item_controls_blockone"><div style="display: inline-block;position: relative;">
			<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
			<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
			<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
			<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo $arItem['CATALOG_MEASURE_NAME']; ?></span>
		</div></div>
			<?
			}
			?>
		<div class="bx_catalog_item_controls_blocktwo">
			<a data-buy="id=<?=$arItem['ID']?>&action=buy" id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium0 js-action-buy product_buy list" href="" rel="nofollow" onclick="SendAnalyticsGoal('kupit_katalog')"><?
			echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
			?></a>
		</div>
			<?
		}
		else
		{
			?><div class="bx_catalog_item_controls_blockone"><span class="bx_notavailable"><?
			echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));
			?></span></div><?
			if ('Y' == $arParams['PRODUCT_SUBSCRIPTION'] && 'Y' == $arItem['CATALOG_SUBSCRIPTION'])
			{
			?>
			<div class="bx_catalog_item_controls_blocktwo">
				<a
					id="<? echo $arItemIDs['SUBSCRIBE_LINK']; ?>"
					class="bx_bt_button_type_2 bx_medium"
					href="javascript:void(0)"><?
					echo ('' != $arParams['MESS_BTN_SUBSCRIBE'] ? $arParams['MESS_BTN_SUBSCRIBE'] : GetMessage('CT_BCS_TPL_MESS_BTN_SUBSCRIBE'));
					?>
				</a>
			</div><?
			}
		}
		?><div style="clear: both;"></div></div>
		
		
		
                                    <?if($arItem['PROPERTIES']['COLOR_REF']['VALUE']):?>
                                        <div class="product_icons">
                                            <?foreach($arItem['PROPERTIES']['COLOR_REF']['VALUE'] as $v): $v=$arResult['ICONS'][$v];?>
                                                <img alt="<?=$v['UF_NAME']?>"  src="<?=$v['IMAGE']?>">
                                            <?endforeach?>
                                        </div>
                                    <?endif?>
                                    <?
                                    $boolShowOfferProps = ('Y' == $arParams['PRODUCT_DISPLAY_MODE'] && $arItem['OFFERS_PROPS_DISPLAY']);
                                    $boolShowProductProps = (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']));
                                    if ($boolShowProductProps || $boolShowOfferProps)
                                    {
                                    ?>
                                    <div class="product_code">
                                    <div class="bx_catalog_item_articul">
                                        <?
                                        if ($boolShowProductProps) {
                                            foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp) {
                                                ?><br><? echo $arOneProp['NAME']; ?> <?
                                                echo(
                                                is_array($arOneProp['DISPLAY_VALUE'])
                                                    ? implode(' / ', $arOneProp['DISPLAY_VALUE'])
                                                    : getSymbol($arOneProp)
                                                );
                                            }
                                        }
                                        }
                                        ?>
                                        </div>
                                        </div>
                                    <div class="product_options">
                                        <a href="#" data-link="action=favorites&amp;id=<?=$arItem['ID']?>" class="product_fav js-action-fav">В закладки / отложить</a>
                                        <a href="#" class="product_compare"><label><input style="position:absolute;left:-10000px;" type="checkbox" id="compare_<?=$arItem['ID']?>" onchange="docompare(<?=$arItem['ID']?>)"/><span class="js-c-add">Сравнить</span><span class="js-c-added">Добавлено к сравнению</span></label></a>
                                    </div>
                                </div>                                
                            </div>
						
</div></div>

 
<?
/*echo "<pre>";
print_r($arItem);
echo "</pre>";
break;*/
}
if ($arParams['AJAX_MODE']=="Y")  exit;
?><div style="clear: both;"></div>
</div>
<?
	if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}?>
<?if (\Bitrix\Main\Loader::includeModule('synpaw.seofilter') &&
$model = CSynPawSeoFilter::getInstance()->getModel()) { ?>
<div class="seo-text">
<?=$model['CONTENT']?>
</div>
<? } else { ?>
<?if($arResult['DESCRIPTION']):?>
                    <div class="catalog_text">
					<?=$arResult['DESCRIPTION']?>
					</div>
					<?endif?>
<? } ?>
<script type="text/javascript">
BX.message({
	MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCS_TPL_MESS_BTN_BUY')); ?>',
	MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',
	MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE')); ?>',
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
	BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
	ADD_TO_BASKET_OK: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS') ?>',
	TITLE_SUCCESSFUL: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE') ?>'
});
$(function(){
	$(".catalog_item.grid .product_big_photo img").css("height","<?=$picHeight?>px");
});
</script>
<?
} else {?>
<?if($arResult['DESCRIPTION']):?>
                    <div class="catalog_text">
					<?=$arResult['DESCRIPTION']?>
					</div>
					<?endif?>
<?}
?>