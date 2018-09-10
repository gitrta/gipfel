<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
    <div class="advantages">
        <div class="wrapper">
            <ul class="advantages_list">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
                <li class="advantages_list_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <div class="advantages_list_item_image">
                        <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="">
                    </div>
                    <div class="advantages_list_item_title"><?echo $arItem["NAME"]?></div>
                    <div class="advantages_list_item_text"><?echo $arItem["PREVIEW_TEXT"];?></div>
                </li>
<?endforeach;?>
            </ul>
        </div>
    </div>
