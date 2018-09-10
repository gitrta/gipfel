<?
function rip_tags($string) { 

	// ----- remove HTML TAGs ----- 
	$string = preg_replace ('/<[^>]*>/', ' ', $string); 
	
	// ----- remove control characters ----- 
	$string = str_replace("\r", '', $string);    // --- replace with empty space
	$string = str_replace("\n", ' ', $string);   // --- replace with space
	$string = str_replace("\t", ' ', $string);   // --- replace with space
	
	// ----- remove multiple spaces ----- 
	$string = trim(preg_replace('/ {2,}/', ' ', $string));
	
	return $string; 

}
if($arResult["ITEMS"]){
	foreach($arResult["ITEMS"] as $arItem){
		if($arItem["PROPERTIES"]["BANNER_SIZE"]["VALUE_XML_ID"]){
			$arResult["OTHER_BANNERS_VIEW"]="Y";
		}
	}
}

	$newart2 = array();
	foreach($arResult["ITEMS"] as $arItem){
        $rif = CFile::ResizeImageFile( // уменьшение картинки для превью
            $sourceFile = $_SERVER["DOCUMENT_ROOT"].$arItem['DETAIL_PICTURE']['SRC'],
            $destinationFile = $_SERVER["DOCUMENT_ROOT"].'/upla/'.$arItem['DETAIL_PICTURE']['FILE_NAME'],
            $arSize = array('width'=>576, 'height'=>276),
            $resizeType = BX_RESIZE_IMAGE_PROPORTIONAL,
            $arWaterMark = array(),
            $jpgQuality=85,
            $arFilters =false
        );
       $arItem['PREVIEW_PICTURE']['SRC'] = '/upla/'.$arItem['DETAIL_PICTURE']['FILE_NAME'];
       $arItem['DETAIL_PICTURE']['SRC'] = '/upla/'.$arItem['DETAIL_PICTURE']['FILE_NAME'];
       array_push($newart2,$arItem);
	}
	
	$arResult["ITEMS"] = $newart2;
