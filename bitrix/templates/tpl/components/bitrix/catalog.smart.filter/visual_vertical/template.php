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

CJSCore::Init(array("fx"));

?>

<div class="bx_filter_vertical catalog_left_block gray">
    <div class="preloader"></div>
    <div class="catalog_left_block_title">
        Фильтры товаров
    </div>
    <div class="bx_filter_section m4 catalog_left_block_content">
        <form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
            <div class="catalog_filter_count"><span class="chosen" style="<?if(!$arResult["ELEMENT_COUNT"]):?>display:none;<?endif?>"> Отобрано <span><?=intval($arResult["ELEMENT_COUNT"])?></span> товаров </span></div>
            <input class="clear_filters" type="submit" id="del_filter" name="del_filter" value="Сбросить фильтры" />

            <?foreach($arResult["HIDDEN"] as $arItem):?>
                <input
                    type="hidden"
                    name="<?echo $arItem["CONTROL_NAME"]?>"
                    id="<?echo $arItem["CONTROL_ID"]?>"
                    value="<?echo $arItem["HTML_VALUE"]?>"
                    />
            <?endforeach;?>
            <?foreach($arResult["ITEMS"] as $key=>$arItem):
                $key = md5($key);
                ?>
                <?if(isset($arItem["PRICE"])):?>
                <?
                if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
                    continue;
                if (!$arItem["VALUES"]["MIN"]["HTML_VALUE"]) $arItem["VALUES"]["MIN"]["HTML_VALUE"]=$arItem["VALUES"]["MIN"]["VALUE"]*1;
                if (!$arItem["VALUES"]["MAX"]["HTML_VALUE"]) $arItem["VALUES"]["MAX"]["HTML_VALUE"]=$arItem["VALUES"]["MAX"]["VALUE"]*1;
                ?><div class="filter_title">Цена</div>
                <div class="bx_filter_container price">
                    <span class="bx_filter_container_title"><span class="bx_filter_container_modef"></span></span>

                    <div class="bx_ui_slider_track" id="drag_track_<?=$key?>">
                        <div class="bx_ui_slider_range" style="left: 0; right: 0%;"  id="drag_tracker_<?=$key?>"></div>
                        <a class="bx_ui_slider_handle left"  href="javascript:void(0)" style="left:0;" id="left_slider_<?=$key?>"></a>
                        <a class="bx_ui_slider_handle right" href="javascript:void(0)" style="right:0%;" id="right_slider_<?=$key?>"></a>
                    </div>
                    <div class="bx_filter_param_area" style="display:none;">
                        <div class="bx_filter_param_area_block" id="curMinPrice_<?=$key?>"><?=$arItem["VALUES"]["MIN"]["VALUE"]?></div>
                        <div class="bx_filter_param_area_block" id="curMaxPrice_<?=$key?>"><?=$arItem["VALUES"]["MAX"]["VALUE"]?></div>
                        <div style="clear: both;"></div>
                    </div>
                    <div class="bx_filter_param_area price_slider_inputs">
                        от
                        <input
                            class="min-price ot"
                            type="text"
                            name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                            id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                            value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                            size="5"
                            onkeyup="smartFilter.keyup(this)"
                            />

                        до
                        <input
                            class="max-price do"
                            type="text"
                            name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                            id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                            value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                            size="5"
                            onkeyup="smartFilter.keyup(this)"
                            />

                        <a href="<?echo $arResult["FILTER_URL"]?>" class="price_slider_button js-init-price">ок</a>
                    </div>
                </div>

                <script type="text/javascript">
                    var DoubleTrackBar<?=$key?> = new cDoubleTrackBar('drag_track_<?=$key?>', 'drag_tracker_<?=$key?>', 'left_slider_<?=$key?>', 'right_slider_<?=$key?>', {
                        OnUpdate: function(){
                            BX("<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>").value = this.MinPos;
                            BX("<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>").value = this.MaxPos;
                        },
                        Min: parseFloat(<?=$arItem["VALUES"]["MIN"]["VALUE"]?>),
                        Max: parseFloat(<?=$arItem["VALUES"]["MAX"]["VALUE"]?>),
                        MinInputId : BX('<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>'),
                        MaxInputId : BX('<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>'),
                        FingerOffset: 10,
                        MinSpace: 1,
                        RoundTo: 0.01,
                        Precision: 2
                    });
                </script>
            <?endif?>
            <?endforeach?>

            <?foreach($arResult["ITEMS"] as $key=>$arItem):?>
                <?if($arItem["PROPERTY_TYPE"] == "N" ):?>
                    <?$key = md5($key);?>
                        <?
                        if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
                            continue;
                        if (!$arItem["VALUES"]["MIN"]["HTML_VALUE"]) $arItem["VALUES"]["MIN"]["HTML_VALUE"]=$arItem["VALUES"]["MIN"]["VALUE"]*1;
                        if (!$arItem["VALUES"]["MAX"]["HTML_VALUE"]) $arItem["VALUES"]["MAX"]["HTML_VALUE"]=$arItem["VALUES"]["MAX"]["VALUE"]*1;
                        ?><div class="filter_title"><?=$arItem["NAME"]?></div>
                        <div class="bx_filter_container price">
                            <span class="bx_filter_container_title"><span class="bx_filter_container_modef"></span></span>

                            <div class="bx_ui_slider_track" id="drag_track_<?=$key?>">
                                <div class="bx_ui_slider_range" style="left: 0; right: 0%;"  id="drag_tracker_<?=$key?>"></div>
                                <a class="bx_ui_slider_handle left"  href="javascript:void(0)" style="left:0;" id="left_slider_<?=$key?>"></a>
                                <a class="bx_ui_slider_handle right" href="javascript:void(0)" style="right:0%;" id="right_slider_<?=$key?>"></a>
                            </div>
                            <div class="bx_filter_param_area" style="display:none;">
                                <div class="bx_filter_param_area_block" id="curMinPrice_<?=$key?>"><?=$arItem["VALUES"]["MIN"]["VALUE"]?></div>
                                <div class="bx_filter_param_area_block" id="curMaxPrice_<?=$key?>"><?=$arItem["VALUES"]["MAX"]["VALUE"]?></div>
                                <div style="clear: both;"></div>
                            </div>
                            <div class="bx_filter_param_area price_slider_inputs">
                                от
                                <input
                                    class="min-price ot"
                                    type="text"
                                    name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                    id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                    value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                    size="5"
                                    onkeyup="smartFilter.keyup(this)"
                                    />

                                до
                                <input
                                    class="max-price do"
                                    type="text"
                                    name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                    id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                    value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                    size="5"
                                    onkeyup="smartFilter.keyup(this)"
                                    />

                                <a href="<?echo $arResult["FILTER_URL"]?>" class="price_slider_button js-init-price">ок</a>

                            </div>
                        </div>

                        <script type="text/javascript">
                            var DoubleTrackBar<?=$key?> = new cDoubleTrackBar('drag_track_<?=$key?>', 'drag_tracker_<?=$key?>', 'left_slider_<?=$key?>', 'right_slider_<?=$key?>', {
                                OnUpdate: function(){
                                    BX("<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>").value = this.MinPos;
                                    BX("<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>").value = this.MaxPos;
                                },
                                Min: parseFloat(<?=$arItem["VALUES"]["MIN"]["VALUE"]?>),
                                Max: parseFloat(<?=$arItem["VALUES"]["MAX"]["VALUE"]?>),
                                MinInputId : BX('<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>'),
                                MaxInputId : BX('<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>'),
                                FingerOffset: 10,
                                MinSpace: 1,
                                RoundTo: 0.01,
                                Precision: 2
                            });
                        </script>
                <?elseif(!empty($arItem["VALUES"]) && !isset($arItem["PRICE"])):?>
                    <div class="bx_filter_container">
                        <span class="bx_filter_container_title filter_title" data-onchange="javascript:hideFilterProps(this)"><span class="bx_filter_container_modef"></span><?=$arItem["NAME"]?></span>
                        <div class="bx_filter_block filter_content">
                            <?foreach($arItem["VALUES"] as $val => $ar):?>
                                <label for="<?echo $ar["CONTROL_ID"]?>" class="check <?echo $ar["CHECKED"]? 'active': ''?> <?echo $ar["DISABLED"] ? 'disabled': ''?>">
									<?//echo $ar["VALUE"];?>
									<?php if (!isset($ar['SEO_URL'])): ?>
									<?=$ar["VALUE"];?>
									<?php else: ?>
									<a title="<?=$ar["SEO_TITLE"];?>" href="<?=$ar["SEO_URL"];?>"><?=$ar["VALUE"];?></a>
									<?php endif; ?>
                                    <input
                                        type="checkbox"
                                        value="<?echo $ar["HTML_VALUE"]?>"
                                        name="<?echo $ar["CONTROL_NAME"]?>"
                                        id="<?echo $ar["CONTROL_ID"]?>"
                                        <?echo $ar["CHECKED"]? 'checked="checked"': ''?>
                                        onchange="javascript:if($(this).prop('checked')==true) $(this).closest('label').addClass('active'); else $(this).closest('label').removeClass('active'); smartFilter.click(this);"
                                        <?if ($ar["DISABLED"]):?>disabled<?endif?>
                                        />
                                </label>
                            <?endforeach;?>
                        </div>
                    </div>
                <?endif;?>
            <?endforeach;?>
            <div style="clear: both;"></div>
            <div class="bx_filter_control_section">

                <span class="icon"></span><input class="bx_filter_search_button" type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
                <div class="catalog_filter_count bottom"><span class="chosen" style="<?if(!$arResult["ELEMENT_COUNT"]):?>display:none;<?endif?>"> Отобрано <span><?=intval($arResult["ELEMENT_COUNT"])?></span> товаров </span></div>
                <input class="clear_filters" type="submit" id="del_filter" name="del_filter" value="Сбросить фильтры" />



                <div class="bx_filter_popup_result right" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
                    <?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
                    <span class="arrow"></span>
                    <a href="<?echo $arResult["FILTER_URL"]?>"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
                </div>

            </div>

        </form>
        <div style="clear: both;"></div>
    </div>
</div>
<script>
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>');
    /****************************************/
    BX.addCustomEvent('onAjaxSuccess', afterFilterReload);
    function afterFilterReload() {
        $(".filter_content label").addClass("check");
        $(".filter_content input").each(function(i,el){
            if($(el).prop("checked")==true) $(el).parent().addClass("active");
        });

    }

</script>
