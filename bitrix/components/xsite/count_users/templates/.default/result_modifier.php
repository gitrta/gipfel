<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach((array)$arResult["USERS_AUTH"] as $v) {
	$ids[]=$v['ID'];
}
if ($ids) {
$filter = Array
(
    "ID"                  => join(" | ",$ids),
);
$rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $filter); // выбираем пользователей
while($f = $rsUsers->GetNext()) :
    $arResult['ONLINE'][] = $f;	
endwhile;
}
?>