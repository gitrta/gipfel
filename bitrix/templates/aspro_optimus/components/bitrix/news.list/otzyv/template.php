<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
                    <div class="reviews_title">
                        Отзывы
                        <div class="reviews_title_count"><?=(int)$arResult['NAV_RESULT']->NavRecordCount?></div>
                    </div>
<div class="reviews_list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
                        <div class="reviews_list_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                            <div class="reviews_list_item_info">
                                <div class="reviews_list_item_name"><?echo $arItem["NAME"]?></div>
				<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                                <div class="reviews_list_item_date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></div>
				<?endif?>
                            </div>
                            <div class="reviews_list_item_text">
                                <?echo $arItem["PREVIEW_TEXT"];?>
                            </div>
                        </div>

<?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
