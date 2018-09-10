<?
ini_set('max_execution_time', 0);
set_time_limit(0);
ini_set('memory_limit', '1536M');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (!CModule::IncludeModule("iblock"))
    return;


$prods_FRID = array();
global $DB;
$addparams = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/BF/art.txt'); //  ФАЙЛ С НОВЫМИ ТОВАРАМИ
$r1 = explode("\n", $addparams);


foreach ($r1 as $item) {
	$r2=$item;	
	 $strSql = "SELECT * FROM `b_iblock_element_property` WHERE IBLOCK_PROPERTY_ID = 7 AND VALUE = '" . $item . "' ORDER BY `b_iblock_element_property`.`ID` ASC";
    $res    = $DB->Query($strSql, false, $err_mess . __LINE__)->Fetch();
    $PID    = $res['IBLOCK_ELEMENT_ID'];
	//print_r($PID."<br>");
	!empty($PID) ? array_push($prods_FRID,$PID):"";
}
print_r($prods_FRID);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>