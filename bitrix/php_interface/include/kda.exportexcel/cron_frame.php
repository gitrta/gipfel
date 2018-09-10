<?
@set_time_limit(0);
if(!ini_get('date.timezone') && function_exists('date_default_timezone_set')){@date_default_timezone_set("Europe/Moscow");}
$_SERVER["DOCUMENT_ROOT"] = str_replace('\\', '/', dirname(__FILE__)).'/../../../..';
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule('catalog');
CModule::IncludeModule("currency");
$module_id = 'kda.exportexcel';
CModule::IncludeModule($module_id);
$PROFILE_ID = $argv[1];
if(strlen($PROFILE_ID)==0)
{
	echo date('Y-m-d H:i:s').": profile id is not set\r\n";
	die();
}

$oProfile = new CKDAExportProfile();
$oProfile->Apply($SETTINGS_DEFAULT, $SETTINGS, $PROFILE_ID);
$oProfile->ApplyExtra($EXTRASETTINGS, $PROFILE_ID);
$params = array_merge($SETTINGS_DEFAULT, $SETTINGS);
$params['MAX_EXECUTION_TIME'] = 0;

$arParams = array();
$ee = new CKDAExportExcel($params, $EXTRASETTINGS, array(), $PROFILE_ID);
$arResult = $ee->Export();

echo date('Y-m-d H:i:s').": export complete\r\n".CUtil::PhpToJSObject($arResult)."\r\n";
?>