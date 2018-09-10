<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
        <div class="news_block">
            <div class="wrapper">                
                <div class="page_title">Новости</div>
                <div class="page_title_capt">Наши последние новости и обьявления</div>
                <div class="news_list">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
                    <div class="news_list_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
				<div class="news_list_item_date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></div>
			<?endif?>
	                        <div class="news_list_item_title"><?echo $arItem["NAME"]?></div>
			<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
				<div class="news_list_item_text"><?echo $arItem["PREVIEW_TEXT"];?></div>
			<?endif;?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="news_list_item_more">Подробнее</a>
			<?endif;?>
                    </div>
<?endforeach;?>
                </div>
            </div>
        </div>
