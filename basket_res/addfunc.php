<?
ini_set('max_execution_time', 0);
set_time_limit(0);
ini_set('memory_limit', '1536M');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

function translit($s) {
  $s = (string) $s; // преобразуем в строковое значение
  $s = strip_tags($s); // убираем HTML-теги
  $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
  $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
  $s = trim($s); // убираем пробелы в начале и конце строки
  $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
  $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
  $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
  $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
  return $s; // возвращаем результат
}

global $DB;
$el = new CIBlockElement;  
$YES = array();
$NO=array();

	$arSelect = Array('ID','NAME');
	$arFilter = Array("IBLOCK_ID"=>IntVal(2));
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>5000), $arSelect);
	$prods=array();
	while($ob = $res->GetNext())
	{
		
		$db_props = CIBlockElement::GetProperty(2, $ob['ID'], array("sort" => "asc"), Array("CODE"=>"CML2_ARTICLE"));
		$ar_props = $db_props->Fetch();	
		$prods[$ar_props["VALUE"]]=$ob;
	}
/*
$prods - массив с товарами вида 
	[0200] => Array
        (
            [ID] => 6458
            [~ID] => 6458
            [NAME] => 0200 GIPFEL Подставка под горячее ECO
            [~NAME] => 0200 GIPFEL Подставка под горячее ECO
        )
*/


$file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/basket_res/KZ.csv'); //ОСНОВНОЙ CSV ФАЙЛ
$r1 = explode("\r",$file);
//array_shift($r1);


foreach ($r1 as $item){
	$r2 = explode(';',$item);
	$art = (string)trim($r2[0]);
	//echo $art."\n";
	if (array_key_exists($art, $prods)) {
    	array_push($YES,$r2);												  // YES содержит в себе те товары которые уже есть на сайте
	} else{
		array_push($NO,$r2);												  // NO содержит в себе НОВЫЕ ТОВАРЫ
	}
	
}

echo 'Кол-во существующих товаров: '.count($YES)."\r\n";
echo 'Кол-во НОВЫХ: '.count($NO)."\r\n";


////////////////////////// ПЕРВЫМ ДЕЛОМ ОБНОВЛЯЕМ СУЩЕСТВУЮЩИЕ (массив $YES), затем уже добавляем те, что в массиве $NO --------------------------------
ksort($prods);
print_r($prods); 
//print_r($NO);
die;


$dp=0;
foreach($YES as $item){$dp++;
	
	$strSql = "SELECT * FROM `b_iblock_element_property` WHERE IBLOCK_PROPERTY_ID = 7 AND VALUE = '".$item[0]."' ORDER BY `b_iblock_element_property`.`ID` ASC";
	$res = $DB->Query($strSql, false, $err_mess.__LINE__)->Fetch();
	
	$PID = $res['IBLOCK_ELEMENT_ID']; //ELEMENT_ID
	
	//print_r($item);
	//ID разделов 
	if ($item[8]=='Акция -30%') $SID = 247;
	if ($item[8]=='Акция -40%') $SID = 244;
	if ($item[8]=='Акция -50%') $SID = 248;
	if ($item[8]=='Акция -70%') $SID = 245;
	if ($item[8]=='Распродажа') $SID = 253;
	if ($item[8]=='Новинки') 	$SID = 254;
	
	//$SID = 254; // ПРИПИСЫВАЕМ К НОВИНКАМ
	
	// Добавляем к секциям
	
	$strSql2 = "SELECT *  FROM `b_iblock_section_element` WHERE `IBLOCK_ELEMENT_ID` = ".$PID." AND IBLOCK_SECTION_ID = ".$SID."";
	//$res2 = $DB->Query($strSql2, false, $err_mess.__LINE__)->Fetch();
	if (empty($res2)){
		$secup = "INSERT INTO `b_iblock_section_element`(`IBLOCK_SECTION_ID`, `IBLOCK_ELEMENT_ID`, `ADDITIONAL_PROPERTY_ID`) VALUES (".$SID.",".$PID.",NULL)";
		//$DB->Query($secup, false, $err_mess.__LINE__);
		//echo $secup."\r\n";
	}
	
	//Проставляем старую цену по новой
	$oldprice = $item[2];
	$formprice = str_replace(",", ".", $item[4]); //CURRENT PRICE
	
	$strSql3 = "UPDATE `b_iblock_element_property` SET `VALUE` = '".$oldprice."' WHERE `IBLOCK_ELEMENT_ID` = ".$PID." AND `IBLOCK_PROPERTY_ID` = 90";
	//echo $strSql3."\r\n";
	//$res3 = $DB->Query($strSql3, false, $err_mess.__LINE__);
	
	//Проставляем новую цену
	
	$strSql4 = "UPDATE  `b_catalog_price` SET `PRICE` =  '".$formprice."' WHERE  `PRODUCT_ID` = ".$PID." AND `CURRENCY` = 'KZT'";
	//echo $strSql4."\r\n";
	//$DB->Query($strSql4, false, $err_mess.__LINE__);
	
	//Обновляем количество товара
	
	$QANT = preg_replace('/\s+/', '', $item[3]) ;
	
	$strSql5 = "UPDATE `b_catalog_product` SET `QUANTITY` = '".$QANT."', `VAT_INCLUDED` = 'N' WHERE `b_catalog_product`.`ID` = ".$PID."";
	//echo $strSql5."\r\n";
	//$DB->Query($strSql5, false, $err_mess.__LINE__);
	

        // Получим записи из таблицы остатков товара для склада с ID=1 
	$rs = CCatalogStoreProduct::GetList(false, array('PRODUCT_ID'=> $PID, 'STORE_ID' => 2));

	while($ar_fields = $rs->GetNext())
	{
		// Обновим значение остатка на складе из значения остатка количественного учёта
                $arFields = Array(
                "PRODUCT_ID" => $ar_fields["PRODUCT_ID"],
                "STORE_ID" => 1,
                "AMOUNT" => $item[3],
    	        );
		//$rtr = CCatalogStoreProduct::Update($ar_fields['ID'], $arFields);
		//echo $rtr."\r\n";
		print_r($item['']);
	}


}
//echo $dp;
echo "FINAL";

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
/*

foreach($NO as $item){
	//print_r($item);
	
	//ID разделов 
	if ($item[8]=='Акция -30%') $SID = 247;
	if ($item[8]=='Акция -40%') $SID = 244;
	if ($item[8]=='Акция -50%') $SID = 248;
	if ($item[8]=='Акция -70%') $SID = 245;
	if ($item[8]=='Распродажа') $SID = 253;
	if ($item[8]=='Новинки') 	$SID = 254;
	//$SID = 254;
	
	$oldprice = $item[2];
	$formprice = str_replace(",", ".", $item[5]);
	$name = $item[1];
	$transName = $item[0].'-'.strtolower(substr(translit($name),0,100)); 
	
$PROP = array();
//$PROP[90] = $oldprice;        // свойству с кодом 90 присваиваем значение $oldprice 
$PROP[7] = $item[0];          // Артикул


$arLoadProductArray = Array(
  "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
  "IBLOCK_SECTION_ID" => $SID,          // элемент лежит в корне раздела
  "IBLOCK_ID"      => 2,
  "PROPERTY_VALUES"=> $PROP,
  "NAME"           => $PROP[7].'-'.$name,
  "CODE"		   => $transName,
  "ACTIVE"         => "Y",            // активен
  "PREVIEW_TEXT"   => "",
  "DETAIL_TEXT"    => ""
  );

//print_r($arLoadProductArray);

$QANT = str_replace(" ", "", $item[6]);

if($PRODUCT_ID = $el->Add($arLoadProductArray)){
	echo "New ID: ".$PRODUCT_ID."\r\n";
	$arFieldstr= array(
        "ID" => $PRODUCT_ID,
        "VAT_ID" => 0, //выставляем тип ндс (задается в админке)  
        "VAT_INCLUDED" => "N", //НДС входит в стоимость
        "PRICE" => $formprice,									//CENA CURRENT
        "QUANTITY" => $QANT,
        "CURRENCY" => "RUB"
    );
	 if (CCatalogProduct::Add($arFieldstr))
        echo "Добавили параметры товара к элементу каталога " . $PRODUCT_ID. "\r\n";
    else
        echo 'Ошибка добавления параметров<br>';
	
	
	$arFieldsat = Array(
        "PRODUCT_ID" => $PRODUCT_ID,
        "CATALOG_GROUP_ID" => 1,
        "PRICE" => $formprice,
        "CURRENCY" => "RUB"
    );

	$res = CPrice::GetList(array(), array(
        "PRODUCT_ID" => $PRODUCT_ID,
        "CATALOG_GROUP_ID" => 1
		));
	
	if ($arr = $res->Fetch()) {
        CPrice::Update($arr["ID"], $arFieldsat);
        echo 'Добавлена: ' . $PRODUCT_ID . "\r\n";
    } else {
        CPrice::Add($arFieldsat);
    }
    
	} else{
	echo "Error: ".$el->LAST_ERROR;
  	}
	
	

}
*/

echo 'final';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>