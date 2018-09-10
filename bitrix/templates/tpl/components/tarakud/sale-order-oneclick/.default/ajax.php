<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arData = array();
$arData["STATUS"] = $arResult["AJAX_STATUS"];
$arData["DATA"] = $arResult["AJAX_DATA"];

$APPLICATION->RestartBuffer();
echo CUtil::PhpToJSObject($arData);
define("PUBLIC_AJAX_MODE", true);
die();
?>