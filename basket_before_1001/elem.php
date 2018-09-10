<?
ini_set('max_execution_time', 0);
set_time_limit(0);
ini_set('memory_limit', '1536M');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arSelect = Array("ID,NAME");
$arFilter = Array("IBLOCK_ID"=>IntVal(2), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>5000), $arSelect);
$prods=array();
while($ob = $res->GetNext())
{
 array_push($prods,$ob['ID']);
}

$el = new CIBlockElement;  
$arTransParams = array(
   "max_len" => 200,
   "change_case" => 'L', // 'L' - toLower, 'U' - toUpper, false - do not change
   "replace_space" => '-',
   "replace_other" => '-',
   "delete_repeat_replace" => true
);
foreach($prods as $item){
$transName = CUtil::translit($item["NAME"], "ru", $arTransParams);
$arLoadProductArray = Array(
  "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
  "ACTIVE"         => "Y",
  "CODE"=>$transName
);

$PRODUCT_ID = $item;  // изменяем элемент с кодом (ID) 2
/*$res = $el->Update($PRODUCT_ID, $arLoadProductArray);
if ($res) echo $item."\r\n";
*/
echo $transName."\r\n";
}
echo 'final';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>