<?
ini_set('max_execution_time', 0);
set_time_limit(0);
ini_set('memory_limit', '1536M');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (!CModule::IncludeModule("iblock"))
    return;


$prods = array();
global $DB;
$addparams = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/basket_res/PRODNEW.txt'); //  ФАЙЛ С НОВЫМИ ТОВАРАМИ
$r1        = explode("\n", $addparams);

foreach ($r1 as $item) {
    $r2 = str_replace('New ID: ', '', $item);
    //echo $r2."\r\n";
    
    $db_props                  = CIBlockElement::GetProperty(2, trim($r2), array(
        "sort" => "asc"
    ), Array(
        "CODE" => "CML2_ARTICLE"
    ));
    $ar_props                  = $db_props->Fetch();
    $prods[$ar_props["VALUE"]] = $r2;
}

$YES = array();
$NO  = array();

$file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/basket_res/uaprice.csv');
$r1   = explode("\r", $file);
array_shift($r1);
foreach ($r1 as $item) {
    $r2 = explode(';', $item);
    $r2[0] = iconv("CP1251","UTF8",$r2[0]);							  // ИЩЕМ АРТИКУЛ КАЖДОГО ТОВАРА ИЗ CSV ($r2[0]) В МАССИВЕ ВСЕХ НА САЙТЕ $prods
    	$r2[1] = iconv("CP1251","UTF8",$r2[1]);
    	$r2[3] = iconv("CP1251","UTF8",$r2[3]);
    	$r2[4] = iconv("CP1251","UTF8",$r2[4]);
    	$r2[6] = iconv("CP1251","UTF8",$r2[6]);
    	$r2[7] = iconv("CP1251","UTF8",$r2[7]);
    	$r2[8] = iconv("CP1251","UTF8",$r2[8]);
    if (array_key_exists($r2[0], $prods)) {
        array_push($YES, $r2);
    } else {
        array_push($NO, $r2);
    }
    
}


foreach ($YES as $item) {
    $strSql = "SELECT * FROM `b_iblock_element_property` WHERE IBLOCK_PROPERTY_ID = 7 AND VALUE = '" . $item[0] . "' ORDER BY `b_iblock_element_property`.`ID` ASC";
    $res    = $DB->Query($strSql, false, $err_mess . __LINE__)->Fetch();
    $PID    = $res['IBLOCK_ELEMENT_ID'];
    
    //ID разделов 
    if ($item[8] == 'Акция -30%')
        $SID = 247;
    if ($item[8] == 'Акция -40%')
        $SID = 244;
    if ($item[8] == 'Акция -50%')
        $SID = 248;
    if ($item[8] == 'Распродажа')
        $SID = 253;
    if ($item[8] == 'Новинки')
        $SID = 254;
    
    // Добавляем к секциям
    
    $strSql2 = "SELECT *  FROM `b_iblock_section_element` WHERE `IBLOCK_ELEMENT_ID` = " . $PID . " AND IBLOCK_SECTION_ID = " . $SID . "";
    $res2    = $DB->Query($strSql2, false, $err_mess . __LINE__)->Fetch();
    if (empty($res2)) {
        $secup = "INSERT INTO `b_iblock_section_element`(`IBLOCK_SECTION_ID`, `IBLOCK_ELEMENT_ID`, `ADDITIONAL_PROPERTY_ID`) VALUES (" . $SID . "," . $PID . ",NULL)";
        //$DB->Query($secup, false, $err_mess.__LINE__);
    }
    
    //Проставляем старую цену по новой
    $oldprice  = $item[2];
    $formprice = str_replace(",", ".", $item[5]);
    
    $strSql3 = "UPDATE `b_iblock_element_property` SET `VALUE` = '" . $oldprice . "' WHERE `IBLOCK_ELEMENT_ID` = " . $PID . " AND `IBLOCK_PROPERTY_ID` = 90";
    //$res3 = $DB->Query($strSql3, false, $err_mess.__LINE__);
    
    //echo $strSql3."\r\n";
    
    //Проставляем новую цену
    
    $strSql4 = "UPDATE  `b_catalog_price` SET `PRICE` =  '" . $formprice . "' WHERE  `PRODUCT_ID` = " . $PID . "";
    //echo $strSql4 . "\r\n";
    //$DB->Query($strSql4, false, $err_mess . __LINE__);
    
    $arFields = array(
        "ID" => $PID,
        "VAT_ID" => 0, //выставляем тип ндс (задается в админке)  
        "VAT_INCLUDED" => "N", //НДС входит в стоимость
        "PRICE" => $formprice,
        "QUANTITY" => $item[9],
        "CURRENCY" => "RUB"
    );
   
	//die;
    
    if (CCatalogProduct::Add($arFields))
        echo "Добавили параметры товара к элементу каталога " . $PID. "\r\n";
    else
        echo 'Ошибка добавления параметров<br>';
    
    
    
    ////////////////////////////////////////////////////////////
    
    
    $arFields = Array(
        "PRODUCT_ID" => $PID,
        "CATALOG_GROUP_ID" => 1,
        "PRICE" => $formprice,
        "CURRENCY" => "RUB"
    );
    print_r($arFields);
    /*
    $res = CPrice::GetList(array(), array(
        "PRODUCT_ID" => $PID,
        "CATALOG_GROUP_ID" => 1
    ));
    
    if ($arr = $res->Fetch()) {
        CPrice::Update($arr["ID"], $arFields);
        echo 'Добавлена: ' . $PID . "\r\n";
    } else {
        CPrice::Add($arFields);
    }
    
    */
    //Обновляем количество товара
    
    $strSql5 = "UPDATE `b_catalog_product` SET `QUANTITY` = '" . $item[9] . "', `VAT_INCLUDED` = '" . $item[10] . "' WHERE `b_catalog_product`.`ID` = " . $PID . "";
    //echo $strSql5."\r\n";
    //$DB->Query($strSql5, false, $err_mess.__LINE__);
}

echo 'end';

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>