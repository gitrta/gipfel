<?
ini_set('max_execution_time', 0);
set_time_limit(0);
ini_set('memory_limit', '1536M');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arSelect = Array('ID','NAME','CODE');
	$arFilter = Array("IBLOCK_ID"=>IntVal(2), "ACTIVE"=>"Y",'!PROPERTY_YOUTVID'=>false);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>5000), $arSelect);
	$prods=array();
	while($ob = $res->GetNext())
	{
		echo 'http://gipfel.ru/catalog/'.$ob['CODE'].'/<br>';
	}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>