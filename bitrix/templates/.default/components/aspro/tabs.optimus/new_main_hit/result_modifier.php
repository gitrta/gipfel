<?
$newart3 = array();
	foreach($arResult["ITEMS"] as $arItem){
		//print_r($arItem);
        $rif = CFile::ResizeImageFile( // уменьшение картинки для превью
            $sourceFile = $_SERVER["DOCUMENT_ROOT"].$arItem['PREVIEW_PICTURE']['SRC'],
            $destinationFile = $_SERVER["DOCUMENT_ROOT"].'/upla/'.$arItem['PREVIEW_PICTURE']['FILE_NAME'],
            $arSize = array('width'=>465, 'height'=>340),
            $resizeType = BX_RESIZE_IMAGE_PROPORTIONAL,
            $arWaterMark = array(),
            $jpgQuality=91,
            $arFilters =false
        );
		
		//print_r($rif);
		
       $arItem['PREVIEW_PICTURE']['SRC'] = '/upla/'.$arItem['PREVIEW_PICTURE']['FILE_NAME'];
       $arItem['DETAIL_PICTURE']['SRC'] = '/upla/'.$arItem['PREVIEW_PICTURE']['FILE_NAME'];
       array_push($newart3,$arItem);
	}
	$arResult["ITEMS"] = $newart3;
