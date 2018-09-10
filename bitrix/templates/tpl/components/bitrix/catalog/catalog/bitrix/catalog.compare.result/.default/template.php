<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$count = count($arResult["ITEMS"]);
if ($count>6) $count=6;
switch ($count) {
	case 2: $ctop=428; break;
	case 3: $ctop=313; break;
	case 4: $ctop=252; break;
	case 5: $ctop=216; break;
}
?>
            <h1 class="product_title">Сравнение товаров</h1>
<div class="catalog-compare-result">
<a name="compare_table"></a>

<div class="compare-left">
<div class="cell-top">
<div class="catalog_left_block gray" style="margin-right:21px;">


<!--
	<noindex><p>
	<?if($arResult["DIFFERENT"]):
		?><a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("DIFFERENT=N",array("DIFFERENT")))?>" rel="nofollow"><?=GetMessage("CATALOG_ALL_CHARACTERISTICS")?></a><?
	else:
		?><?=GetMessage("CATALOG_ALL_CHARACTERISTICS")?><?
	endif
	?>&nbsp;|&nbsp;<?
	if(!$arResult["DIFFERENT"]):
		?><a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("DIFFERENT=Y",array("DIFFERENT")))?>" rel="nofollow"><?=GetMessage("CATALOG_ONLY_DIFFERENT")?></a><?
	else:
		?><?=GetMessage("CATALOG_ONLY_DIFFERENT")?><?
	endif?>
	</p></noindex> -->

	<?if(count($arResult["SHOW_PROPERTIES"])>0):?>
		
		<form class="js-del-prop" action="<?=$APPLICATION->GetCurPage()?>" method="get">
		<div class="catalog_left_block_title">
                            <?=GetMessage("CATALOG_REMOVE_FEATURES")?>
                        </div>
<div class="catalog_left_block_content"><div class="filter_content">
	<?if(!empty($arResult["DELETED_PROPERTIES"]) || !empty($arResult["DELETED_OFFER_FIELDS"]) || !empty($arResult["DELETED_OFFER_PROPS"])):?>
		<noindex>
		
		<?foreach($arResult["DELETED_PROPERTIES"] as $arProperty):?>
			<label class="check active"><a class="1" href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=ADD_FEATURE&pr_code=".$arProperty["CODE"],array("op_code","of_code","pr_code","action")))?>" rel="nofollow"><?=$arProperty["NAME"]?></a></label>
		<?endforeach?>
		<?foreach($arResult["DELETED_OFFER_FIELDS"] as $code):?>
			<a class="2" href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=ADD_FEATURE&of_code=".$code,array("op_code","of_code","pr_code","action")))?>" rel="nofollow"><?=GetMessage("IBLOCK_FIELD_".$code)?></a>
		<?endforeach?>
		<?foreach($arResult["DELETED_OFFER_PROPERTIES"] as $arProperty):?>
			<a class="3" href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=ADD_FEATURE&op_code=".$arProperty["CODE"],array("op_code","of_code","pr_code","action")))?>" rel="nofollow"><?=$arProperty["NAME"]?></a>
		<?endforeach?>
		</noindex>
	<?endif?>
		<?foreach($arResult["SHOW_PROPERTIES"] as $arProperty): if(!$arProperty["NAME"]) continue?>
			<label class="check"><input class="js-check" type="checkbox" name="pr_code[]" value="<?=$arProperty["CODE"]?>" /><?=$arProperty["NAME"]?></label>
		<?endforeach?>
		<?foreach($arResult["SHOW_OFFER_FIELDS"] as $code):?>
			<input type="checkbox" name="of_code[]" value="<?=$code?>" /><?=GetMessage("IBLOCK_FIELD_".$code)?><br />
		<?endforeach?>
		<?foreach($arResult["SHOW_OFFER_PROPERTIES"] as $arProperty):?>
			<input type="checkbox" name="op_code[]" value="<?=$arProperty["CODE"]?>" /><?=$arProperty["NAME"]?><br />
		<?endforeach?>
		<input type="hidden" name="action" value="DELETE_FEATURE" />
		<input type="hidden" name="IBLOCK_ID" value="<?=$arParams["IBLOCK_ID"]?>" />
		<!-- <input type="submit" value="<?=GetMessage("CATALOG_REMOVE_FEATURES")?>"> -->
		</form>
</div>


	</div>	
<script>
$(function(){

	$(document).on({
		click: function(){
			if ($(this).prop("checked")==true) {
				$(this).closest("label").addClass("active");
				$(".js-del-prop").submit();
			}
			else $(this).closest("label").removeClass("active");
		}
	},".js-check");
});
</script>
	<?endif?>

</div>

<a class="btn back2catalog" onclick="history.go(-1);return false;" href="/catalog/">Вернуться в каталог</a>

</div>
<div class="compare-features">
	<table class="data-table compare-table" cellspacing="0" cellpadding="0" border="0">
		<thead>

		<tr>
			<th valign="top" class="table-cell-title" nowrap>Характеристики</th>
		</tr>
		</thead>

		<?foreach($arResult["SHOW_PROPERTIES"] as $code=>$arProperty):
			$arCompare = Array();
			foreach($arResult["ITEMS"] as $arElement)
			{
				$arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
				if(is_array($arPropertyValue))
				{
					sort($arPropertyValue);
					$arPropertyValue = implode(" / ", $arPropertyValue);
				}
				$arCompare[] = $arPropertyValue;
			}
			$diff = (count(array_unique($arCompare)) > 1 ? true : false);
			if($diff || !$arResult["DIFFERENT"]):?>
				<tr>
					<th valign="top" class="feature" nowrap>&nbsp;<?=$arProperty["NAME"]?>&nbsp;</th>
				</tr>
			<?endif?>
		<?endforeach?>
	</table>
</div>
</div>
<div class="compare-right">
<form action="<?=$APPLICATION->GetCurPage()?>" method="get" class="js-remove-form">
	<table  width="730" class="data-table compare-table" cellspacing="0" cellpadding="0" border="0">
		<thead>

		<?foreach($arResult["ITEMS"][0]["FIELDS"] as $code=>$field):?>
		<tr>
			
			<?foreach($arResult["ITEMS"] as $arElement):?>
				<td valign="top" style="width:<?=floor(100/$count)?>%;padding-right:23px;"><div class="wrap-td wrap-<?=$code?>">
					<?switch($code):
						case "NAME":
							?><a style="text-decoration:none;color:#000;text-transform:uppercase;" href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement[$code]?></a><?
							if($arElement["CAN_BUY"]):
								?><?
							elseif((count($arResult["PRICES"]) > 0) || is_array($arElement["PRICE_MATRIX"])):
								/*?><br /><?=GetMessage("CATALOG_NOT_AVAILABLE")?><?*/
							endif;
							break;
						case "PREVIEW_PICTURE":
						case "DETAIL_PICTURE": $w = floor(731/$count)-23;
							?>
								<label class="delete-compare"><input class="js-remove" type="checkbox" name="ID[]" value="<?=$arElement["ID"]?>" /></label><a style="width:100%; display:inline-block;background:url(<?=$arElement["FIELDS"][$code]["SRC"]?>) no-repeat center;background-size:contain;" href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img style="border:1px solid #eee;" src="/bitrix/images/1.gif" width="<?=$w?>" height="<?=$w?>" alt="<?=$arElement["FIELDS"][$code]["ALT"]?>" /></a>
							<?
							break;
						default:
							echo $arElement["FIELDS"][$code];
							break;
					endswitch;
					?>
				</div></td>
			<?endforeach?>
		</tr>
		<?endforeach;?>
		</thead>
		<?foreach($arResult["ITEMS"][0]["PRICES"] as $code=>$arPrice):?>
			<?if($arPrice["CAN_ACCESS"]):?>
			<tr>
				
				<?foreach($arResult["ITEMS"] as $arElement):?>
					<td valign="top" class="td-price">
						<?if($arElement["PRICES"][$code]["CAN_ACCESS"]):?>
							<span class="product_price"><?=$arElement["PRICES"][$code]["PRINT_DISCOUNT_VALUE"]?></span>
<?if($arElement["CAN_BUY"]):?><a data-buy="id=<?=$arElement['ID']?>&amp;action=buy" class="bx_bt_button bx_medium0 js-action-buy product_buy" href="javascript:void(0)" rel="nofollow">Купить</a><?else:?><?=GetMessage("CATALOG_NOT_AVAILABLE")?><?endif?>
						<?endif;?>
					</td>
				<?endforeach?>
			</tr>
			<?endif;?>
		<?endforeach;?>
		<?foreach($arResult["SHOW_PROPERTIES"] as $code=>$arProperty):
			$arCompare = Array();
			foreach($arResult["ITEMS"] as $arElement)
			{
				$arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
				if(is_array($arPropertyValue))
				{
					sort($arPropertyValue);
					$arPropertyValue = implode(" / ", $arPropertyValue);
				}
				$arCompare[] = $arPropertyValue;
			}
			$diff = (count(array_unique($arCompare)) > 1 ? true : false);
			if($diff || !$arResult["DIFFERENT"]):?>
				<tr>
					
					<?foreach($arResult["ITEMS"] as $arElement):?>
						<?if($diff):?>
						<td class="feature" valign="top"><div class="compare-value">&nbsp;
							<?=(is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
						</div></td>
						<?else:?>
						<th class="feature" valign="top"><div class="compare-value">&nbsp;
							<?=(is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
						</div></th>
						<?endif?>
					<?endforeach?>
				</tr>
			<?endif?>
		<?endforeach;?>
		<?foreach($arResult["SHOW_OFFER_FIELDS"] as $code):
			$arCompare = Array();
			foreach($arResult["ITEMS"] as $arElement)
			{
				$Value = $arElement["OFFER_FIELDS"][$code];
				if(is_array($Value))
				{
					sort($Value);
					$Value = implode(" / ", $Value);
				}
				$arCompare[] = $Value;
			}
			$diff = (count(array_unique($arCompare)) > 1 ? true : false);
			if($diff || !$arResult["DIFFERENT"]):?>
				<tr>
					<th valign="top" nowrap>&nbsp;<?=GetMessage("IBLOCK_FIELD_".$code)?>&nbsp;</th>
					<?foreach($arResult["ITEMS"] as $arElement):?>
						<?if($diff):?>
						<td valign="top">&nbsp;
							<?=(is_array($arElement["OFFER_FIELDS"][$code])? implode("/ ", $arElement["OFFER_FIELDS"][$code]): $arElement["OFFER_FIELDS"][$code])?>
						</td>
						<?else:?>
						<th valign="top">&nbsp;
							<?=(is_array($arElement["OFFER_FIELDS"][$code])? implode("/ ", $arElement["OFFER_FIELDS"][$code]): $arElement["OFFER_FIELDS"][$code])?>
						</th>
						<?endif?>
					<?endforeach?>
				</tr>
			<?endif?>
		<?endforeach;?>
		<?foreach($arResult["SHOW_OFFER_PROPERTIES"] as $code=>$arProperty):
			$arCompare = Array();
			foreach($arResult["ITEMS"] as $arElement)
			{
				$arPropertyValue = $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["VALUE"];
				if(is_array($arPropertyValue))
				{
					sort($arPropertyValue);
					$arPropertyValue = implode(" / ", $arPropertyValue);
				}
				$arCompare[] = $arPropertyValue;
			}
			$diff = (count(array_unique($arCompare)) > 1 ? true : false);
			if($diff || !$arResult["DIFFERENT"]):?>
				<tr>
					<th valign="top" nowrap>&nbsp;<?=$arProperty["NAME"]?>&nbsp;</th>
					<?foreach($arResult["ITEMS"] as $arElement):?>
						<?if($diff):?>
						<td valign="top">&nbsp;
							<?=(is_array($arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
						</td>
						<?else:?>
						<th valign="top">&nbsp;
							<?=(is_array($arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
						</th>
						<?endif?>
					<?endforeach?>
				</tr>
			<?endif?>
		<?endforeach;?>
	</table>
	<br />
	<!-- <input type="submit" class="" value="<?=GetMessage("CATALOG_REMOVE_PRODUCTS")?>" /> -->
	<input type="hidden" name="action" value="DELETE_FROM_COMPARE_RESULT" />
	<input type="hidden" name="IBLOCK_ID" value="<?=$arParams["IBLOCK_ID"]?>" />
</form>
<script>
$(function(){
	$(document).on({
		click: function(){
			if ($(this).prop("checked")==true) {
				
				$(".js-remove-form").submit();
			}
			
		}
	},".js-remove");
});
</script>
<br />
<?if(count($arResult["ITEMS_TO_ADD"])>0):?>
<p>
<form action="<?=$APPLICATION->GetCurPage()?>" method="get">
	<input type="hidden" name="IBLOCK_ID" value="<?=$arParams["IBLOCK_ID"]?>" />
	<input type="hidden" name="action" value="ADD_TO_COMPARE_RESULT" />
	<select name="id">
	<?foreach($arResult["ITEMS_TO_ADD"] as $ID=>$NAME):?>
		<option value="<?=$ID?>"><?=$NAME?></option>
	<?endforeach?>
	</select>
	<input type="submit" value="<?=GetMessage("CATALOG_ADD_TO_COMPARE_LIST")?>" />
</form>
</p>
<?endif?>
</div><div style="clear:both" class="clearfix"></div>
</div>
<style>
<?if($ctop):?>
.cell-top { height: <?=$ctop?>px; }
<?endif?>
.compare-value {
	width: <?=floor(731/$count)-1?>px;
}
.product_price {
	width: <?=floor(731/$count)-($count==2?125:1)?>px;
}




</style>