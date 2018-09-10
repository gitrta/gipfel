<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);?>
<? if(count($arResult['ITEMS']) > 0):?>
    <div class="desc-wrap">
    <? foreach($arResult['ITEMS'] as &$arItem) { ?>
        <? if ($arItem['PROPERTIES']['SERIA'] == 'Y'):?>

            <div class="desc-item-white">
                <p class="title"><?=$arItem['NAME']?></p>
                <div class="info">
                    <?=$arItem['PREVIEW_TEXT']?>
                </div>
                <img src="<?=$arItem['PREVIEW_PICTURE']?>" alt="<?=$arItem['NAME']?>">
            </div>

        <? else :?>
            <div class="desc-item <?=($arItem['PROPERTIES']['LEFT'] == 'Y' ? 'left' : '')?>">
                <div class="img" style="background-image: url(<?=$arItem['PREVIEW_PICTURE']?>)">
                </div>
                <div class="info">
                    <p class="title"><?=$arItem['NAME']?></p>
                    <?=$arItem['PREVIEW_TEXT']?>
                </div>
            </div>
        <? endif?>
    <? } ?>
    </div>
<?endif?>