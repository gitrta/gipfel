<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!isset($arParams["CACHE_TIME"])) {
	$arParams["CACHE_TIME"] = 3600;
}

CPageOption::SetOptionString("main", "nav_page_in_session", "N");

if($arParams["IBLOCK_ID"] < 1) {
	ShowError("IBLOCK_ID IS NOT DEFINED");
	return false;
}

if(!isset($arParams["ITEMS_LIMIT"])) {
	$arParams["ITEMS_LIMIT"] = 10;
}

$arNavParams = array();

if ($arParams["ITEMS_LIMIT"] > 0) {
	$arNavParams = array(
		"nPageSize" => $arParams["ITEMS_LIMIT"],
	);
}

$file = $_SERVER['DOCUMENT_ROOT']."/watching.now";
$all = file($file);

$arNavigation = CDBResult::GetNavParams($arNavParams);

if($this->StartResultCache(false, array($arNavigation)))
{

	if(!CModule::IncludeModule("iblock")) {
		$this->AbortResultCache();
		ShowError("IBLOCK_MODULE_NOT_INSTALLED");
		return false;
	}	

	$arSort= array("SORT" => "ASC", "DATE_ACTIVE_FROM" => "DESC", "ID" => "DESC");
	$arFilter = array("ID"=>$all, "IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y", "ACTIVE_DATE" => "Y");
	$arSelect = array("ID", "IBLOCK_ID","DETAIL_PAGE_URL","DETAIL_PICTURE",  "CATALOG_GROUP_1","IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "PREVIEW_TEXT", "PREVIEW_PICTURE");

	$rsElement = CIBlockElement::GetList($arSort, $arFilter, false, $arNavParams, $arSelect);

	if ($arParams["DETAIL_URL"]) {
		$rsElement->SetUrlTemplates($arParams["DETAIL_URL"]);
	}

	while($obElement = $rsElement->GetNextElement()) {

		$arElement = $obElement->GetFields();
		//$arElement['PROPERTIES'] = $obElement->GetProperties();
		if ($arElement["PREVIEW_PICTURE"]) {
			$arElement["PREVIEW_PICTURE"] = CFile::GetFileArray($arElement["PREVIEW_PICTURE"]);
		} 
		if ($arElement["DETAIL_PICTURE"]) {
			$arElement["DETAIL_PICTURE"] = CFile::GetFileArray($arElement["DETAIL_PICTURE"]);
		} 		
		//$arElement["PROPERTIES"] = $obElement->GetProperties();

		$arResult["ITEMS"][] = $arElement;
	}

	$arResult["NAV_STRING"] = $rsElement->GetPageNavStringEx($navComponentObject, "Страницы", "", "");

	$this->SetResultCacheKeys(array(
		"ID",
		"IBLOCK_ID",
		"NAV_CACHED_DATA",
		"NAME",
		"IBLOCK_SECTION_ID",
		"IBLOCK",
		"LIST_PAGE_URL", 
		"~LIST_PAGE_URL",
		"SECTION",
		"PROPERTIES",
	));

	$this->IncludeComponentTemplate();

}

?>