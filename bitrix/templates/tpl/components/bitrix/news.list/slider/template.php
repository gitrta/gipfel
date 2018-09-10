<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
    <div class="slider">
        <ul class="bx-slider">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
            <li id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="background-image:url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>')">
		<?if($arItem['PROPERTIES']['TITLE']['VALUE']
			|| $arItem['PROPERTIES']['SUBTITLE']['VALUE']
			|| $arItem['PROPERTIES']['PRICE']['VALUE']
			|| $arItem['PROPERTIES']['BUY']['VALUE']
		):?>
                <div class="slide_cont">                
                    <div class="slide_title"><?=$arItem['PROPERTIES']['TITLE']['VALUE']?></div>
                    <div class="slide_hr"></div>
                    <div class="slide_text">
                        <div class="slide_subtitle"><?=$arItem['PROPERTIES']['SUBTITLE']['VALUE']?></div>
                        <?echo $arItem["PREVIEW_TEXT"];?>
                    </div>
		<?if($arItem['PROPERTIES']['PRICE']['VALUE']):?>
                    <div class="slide_bottom">
                        <div class="slide_price"><?=$arItem['PROPERTIES']['PRICE']['VALUE']?> <span>руб</span></div>
                        <a href="<?=$arItem['PROPERTIES']['BUY']['VALUE']?>" class="slide_button">купить сейчас</a>
                    </div>
		<?endif?>
                </div><?endif?>
            </li>
<?endforeach;?>
        </ul>
    </div>