<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
?>
<?if(count($arResult['ITEMS'])):?>
                    <div class="catalog_left_block">
                        <div class="catalog_left_block_title">
                            сейчас смотрят
                        </div>
                        <div class="catalog_left_block_content">
                            <ul class="catalog_left_products">
	<?foreach($arResult['ITEMS'] as $arItem):?>
                                <li>
                                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                                        <div class="catalog_left_products_image">
                                            <img style="background:url(<?=$arItem['DETAIL_PICTURE']['SRC']?>) no-repeat center; background-size:contain;" src="/bitrix/images/1.gif" alt="">
                                        </div>
                                        <div class="catalog_left_products_info">
                                            <div class="catalog_left_products_title">
                                                <?=$arItem['NAME']?>
                                            </div>
                                            <div class="catalog_left_products_price">
                                                <?=FormatCurrency($arItem['CATALOG_PRICE_1'],$arItem['CATALOG_CURRENCY_1'])?> 
                                            </div>
                                        </div>
                                    </a>
                                </li>	
	<?endforeach?>
                            </ul>
                        </div>                       
                    </div>							
<?endif?>