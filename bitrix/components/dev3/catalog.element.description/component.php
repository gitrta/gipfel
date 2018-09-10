<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


global $APPLICATION;

if (!isset($arParams['CACHE_TIME']))
    $arParams['CACHE_TIME'] = 36000000;

$arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);
$arParams['ELEMENT_ID'] = intval($arParams['ELEMENT_ID']);

if ($this->StartResultCache()) {
    if (!CModule::IncludeModule('iblock')) {
        $this->AbortResultCache();
    } else {

        $arFilter = array(
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'ACTIVE' => 'Y',
            'ACTIVE_DATE' => 'Y',
            'GLOBAL_ACTIVE' => 'Y',
            'IBLOCK_ACTIVE' => 'Y',
            'PROPERTY_PRODUCTS' => $arParams['ELEMENT_ID']
        );


        $arOrder = array(
            'sort' => 'ASC',
        );
        $arSelect = array(
            'NAME',
            'PREVIEW_PICTURE',
            'PREVIEW_TEXT'
        );

        $arPropCodes = array('LEFT', 'SERIA');

        foreach ($arPropCodes as $code)
            $arSelect[] = 'PROPERTY_' . $code;


        $rsDesc= CIBlockElement::GetList($arOrder, $arFilter, false, $count, $arSelect);

        while($arItem = $rsDesc->Fetch()){
            $arElement = array();
            if($arItem['PREVIEW_PICTURE'] > 0) {

                $arElement = array(
                    'NAME' => $arItem['NAME'],
                    'PREVIEW_PICTURE' => CFile::GetPath($arItem['PREVIEW_PICTURE']),
                    'PREVIEW_TEXT' => $arItem['PREVIEW_TEXT']
                );
                foreach($arPropCodes as $code){
                    $arElement['PROPERTIES'][$code] = $arItem['PROPERTY_' . $code . '_VALUE'];
                }

                $arResult['ITEMS'][] = $arElement;
            }
        }


        $this->EndResultCache();
    }
}
$this->IncludeComponentTemplate();
?>