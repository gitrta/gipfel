<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
            <div class="sales">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	$arProp = $arItem['PROPERTIES'];
	?>
                <div class="sales_block <?=$arProp['CSS']['VALUE']?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <a href="<?=$arProp['LINK']['VALUE']?>">                        
                        <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="">
                        <div class="sales_block_inner">
                            <div class="sales_block_title"><span><?echo $arItem["NAME"]?></span></div>
                            <?if($arProp['PERCENT']['VALUE']):?><div class="sales_block_persent"><?=$arProp['PERCENT']['VALUE']?></div><?endif?>
                            <?/*if($arProp['SUBTITLE']['VALUE']):?><div class="sales_block_text"><?=nl2br($arItem['PROPERTIES']['SUBTITLE']['~VALUE'])?></div><?endif*/?>
                            <?if($arProp['PRICE']['VALUE']):?><div class="sales_block_price"><?=$arProp['PRICE']['VALUE']?> <span>руб</span></div><?endif?>
                        </div>
                    </a>
                </div>
<?endforeach;?>
            </div>