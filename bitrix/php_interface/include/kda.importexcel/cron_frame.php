<?
@set_time_limit(0);
if(!ini_get('date.timezone') && function_exists('date_default_timezone_set')){@date_default_timezone_set("Europe/Moscow");}
$_SERVER["DOCUMENT_ROOT"] = str_replace('\\', '/', dirname(__FILE__)).'/../../../..';
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule('catalog');
CModule::IncludeModule("currency");
$module_id = 'kda.importexcel';
CModule::IncludeModule($module_id);
$PROFILE_ID = $argv[1];
if(strlen($PROFILE_ID)==0)
{
	echo date('Y-m-d H:i:s').": profile id is not set\r\n";
	die();
}

$oProfile = new CKDAImportProfile();
$oProfile->Apply($SETTINGS_DEFAULT, $SETTINGS, $PROFILE_ID);
$oProfile->ApplyExtra($EXTRASETTINGS, $PROFILE_ID);
$params = array_merge($SETTINGS_DEFAULT, $SETTINGS);
$params['MAX_EXECUTION_TIME'] = 0;

$needCheckSize = (bool)(COption::GetOptionString($module_id, 'CRON_NEED_CHECKSIZE', 'N')=='Y');
$nameCheckSize = 'CRON_LOADED_CHECKSIZE_'.$PROFILE_ID;
$needImport = true;
if($needCheckSize)
{
	$checkSize = COption::GetOptionString($module_id, $nameCheckSize, 0);
}

$fileSize = 0;
$DATA_FILE_NAME = $params['URL_DATA_FILE'];
if($params['EXT_DATA_FILE'])
{
	if(substr($params['EXT_DATA_FILE'], 0, 1)=='/')
	{
		$params['EXT_DATA_FILE'] = $_SERVER["DOCUMENT_ROOT"].$params['EXT_DATA_FILE'];
		$fileSize = filesize($params['EXT_DATA_FILE']);
	}
	else
	{
		$client = new \Bitrix\Main\Web\HttpClient();
		if($headers = $client->head($params['EXT_DATA_FILE']))
		{
			$fileSize = (int)$headers->get('content-length');
		}
	}
	
	if($needCheckSize && $fileSize && $checkSize==$fileSize)
	{
		$needImport = false;
	}
	else
	{
		$arFile = CKDAImportUtils::MakeFileArray($params['EXT_DATA_FILE']);
		if($arFile['tmp_name'])
		{
			copy($arFile['tmp_name'], $_SERVER["DOCUMENT_ROOT"].$DATA_FILE_NAME);
		}
	}
}

if(!file_exists($_SERVER["DOCUMENT_ROOT"].$DATA_FILE_NAME))
{
	if(defined("BX_UTF")) $DATA_FILE_NAME = $APPLICATION->ConvertCharsetArray($DATA_FILE_NAME, LANG_CHARSET, 'CP1251');
	else $DATA_FILE_NAME = $APPLICATION->ConvertCharsetArray($DATA_FILE_NAME, LANG_CHARSET, 'UTF-8');
}
if(!file_exists($_SERVER["DOCUMENT_ROOT"].$DATA_FILE_NAME))
{
	echo date('Y-m-d H:i:s').": file not exists\r\n";
	die();
}

$arParams = array();
$pid = false;
if(COption::GetOptionString($module_id, 'CRON_CONTINUE_LOADING', 'N')=='Y')
{
	$pid = $PROFILE_ID;
	$oProfile = new CKDAImportProfile();
	$arParams = $oProfile->GetProccessParamsFromPidFile($PROFILE_ID);
	if($arParams===false)
	{
		echo date('Y-m-d H:i:s').": import in process\r\n";
		die();
	}
}
if(!is_array($arParams)) $arParams = array();
if(empty($arParams) && !$needImport)
{
	echo date('Y-m-d H:i:s').": file is loaded\r\n";
	die();
}

if($needCheckSize)
{
	COption::SetOptionString($module_id, $nameCheckSize, $fileSize);
}

$ie = new CKDAImportExcel($DATA_FILE_NAME, $params, $EXTRASETTINGS, $arParams, $pid);
$arResult = $ie->Import();

if(COption::GetOptionString($module_id, 'CRON_REMOVE_LOADED_FILE', 'N')=='Y')
{
	if(file_exists($_SERVER["DOCUMENT_ROOT"].$DATA_FILE_NAME))
	{
		unlink($_SERVER["DOCUMENT_ROOT"].$DATA_FILE_NAME);
	}
	
	if($params['EXT_DATA_FILE'] && is_file($params['EXT_DATA_FILE']))
	{
		unlink($params['EXT_DATA_FILE']);
	}
}
echo date('Y-m-d H:i:s').": import complete\r\n".CUtil::PhpToJSObject($arResult)."\r\n";
?>