<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
                    <div class="catalog_left_block">
                        <div class="catalog_left_block_title">
                            Выбор товара
                        </div>
                        <div class="catalog_left_block_content clearfix">
                            <ul class="faq_links">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
                                <li id="<?=$this->GetEditAreaId($arItem['ID']);?>"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></li>
<?endforeach;?>
                            </ul>
                            <a href="/articles/" class="faq_links_all">все статьи</a>
                        </div>                        
                    </div>
