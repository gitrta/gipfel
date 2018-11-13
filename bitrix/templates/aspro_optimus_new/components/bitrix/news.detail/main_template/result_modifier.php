<?
if(isset($arResult["DETAIL_PICTURE"]) && isset($arResult["DETAIL_PICTURE"]["SRC"]))
	$GLOBALS['SetOgImage'] = "https://".$_SERVER['HTTP_HOST']."".$arResult["DETAIL_PICTURE"]["SRC"];


if(isset($arResult["PREVIEW_TEXT"]) && strlen($arResult["PREVIEW_TEXT"])){
	$GLOBALS["SetOgDescription"] = $arResult["PREVIEW_TEXT"];
}

$arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL", "DETAIL_PICTURE");
$arFilter = Array("IBLOCK_ID"=>7, "ACTIVE"=>"Y", "ID"=>$arResult["PROPERTIES"]["LINK"]["VALUE"]);

$res = CIBlockElement::GetList(array("SORT" => "ASC"), $arFilter, false, Array("nPageSize"=>PHP_INT_MAX), $arSelect);

$related = array();
while($ob = $res->GetNextElement())
{
  $arFields = $ob->GetFields();
	$rsFile = CFile::GetByID($arFields["DETAIL_PICTURE"]);
  $arFile = $rsFile->Fetch();
	$arFields["DETAIL_PICTURE"] = $arFile;
  $related[] = $arFields;
}

$arResult["RELATED"] = $related;
