<?
	$newart1 = array();
	foreach($arResult["ITEMS"] as $arItem){
		$file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], /*array('width'=>578, 'height'=>277)*/ false, BX_RESIZE_IMAGE_PROPORTIONAL, true, array(),false,20);                
        $arItem['PREVIEW_PICTURE']['SRC'] = $file['src'];
        array_push($newart1,$arItem);
	}
	
	$arResult["ITEMS"] = $newart1;