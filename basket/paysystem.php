<?/*
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$c = explode(',',$_GET['city']);
$city = trim($c[0]);

$db_vars = CSaleLocation::GetList(
        array(
                "SORT" => "ASC",
                "COUNTRY_NAME_LANG" => "ASC",
                "CITY_NAME_LANG" => "ASC"
            ),
        array("LID" => LANGUAGE_ID,"CITY_NAME"=>$city),
        false,
        false,
        array()
    );
   while ($vars = $db_vars->Fetch()):
      $ID = $vars["ID"];
      $cntr = $vars['COUNTRY_ID']; //Country ID
   endwhile;



$db_ptype = CSalePaySystem::GetList($arOrder = Array("SORT"=>"ASC", "PSA_NAME"=>"ASC"), Array("LID"=>SITE_ID, "CURRENCY"=>"RUB", "ACTIVE"=>"Y", "PERSON_TYPE_ID"=>$_GET['ID'], "!ID"=>8));
$bFirst = True;
if ($cntr==8):
// print_r($cntr);
while ($ptype = $db_ptype->Fetch())
{if ($ptype["ID"]!=='1'): ?>
   <div <?if ($bFirst) echo  'class = "act"';?>><input required type="radio" name="PAY_SYSTEM_ID" value="<?echo $ptype["ID"] ?>"<?if ($bFirst) echo " checked";?>><img src="<?=CFile::GetPath($ptype['PSA_LOGOTIP'])?>"><b><?echo $ptype["PSA_NAME"] ?></b><br><text><?
   $bFirst = false;
   if (strlen($ptype["DESCRIPTION"])>0)
      echo $ptype["DESCRIPTION"]."</text>";
   ?></div><?endif;
}
else:
while ($ptype = $db_ptype->Fetch())
{ 
?>
   <div <?if ($bFirst) echo  'class = "act"';?>><input required type="radio" name="PAY_SYSTEM_ID" value="<?echo $ptype["ID"] ?>"<?if ($bFirst) echo " checked";?>><img src="<?=CFile::GetPath($ptype['PSA_LOGOTIP'])?>"><b><?echo $ptype["PSA_NAME"] ?></b><br><text><?
   $bFirst = false;
   if (strlen($ptype["DESCRIPTION"])>0)
      echo $ptype["DESCRIPTION"]."</text>";
   ?></div><? 
}
endif;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
*/?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$c = explode(',',$_GET['city']);
$city = trim($c[0]);

$db_vars = CSaleLocation::GetList(
        array(
                "SORT" => "ASC",
                "COUNTRY_NAME_LANG" => "ASC",
                "CITY_NAME_LANG" => "ASC"
            ),
        array("LID" => LANGUAGE_ID,"CITY_NAME"=>$city),
        false,
        false,
        array()
    );
   while ($vars = $db_vars->Fetch()):
      $ID = $vars["ID"];
      $cntr = $vars['COUNTRY_ID']; //Country ID
   endwhile;



$db_ptype = CSalePaySystem::GetList($arOrder = Array("SORT"=>"ASC", "PSA_NAME"=>"ASC"), Array("ACTIVE"=>"Y", "PERSON_TYPE_ID"=>$_GET['ID'], "!ID"=>8));
$bFirst = True;

while ($ptype = $db_ptype->Fetch())
{ 
?>
   <div <?if ($bFirst) echo  'class = "act"';?>><input required type="radio" name="PAY_SYSTEM_ID" value="<?echo $ptype["ID"] ?>"<?if ($bFirst) echo " checked";?>><img src="<?=CFile::GetPath($ptype['PSA_LOGOTIP'])?>"><b><?echo $ptype["PSA_NAME"] ?></b><br><text><?
   $bFirst = false;
   if (strlen($ptype["DESCRIPTION"])>0)
      echo $ptype["DESCRIPTION"]."</text>";
   ?></div><? 
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>