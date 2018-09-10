<?
ini_set('max_execution_time', 0);
set_time_limit(0);
ini_set('memory_limit', '1536M');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


if(isset($_GET['MYGEO'])){
	if ($_GET['MYGEO']=='RU'){
	echo 'http://gipfel.ru?MYGEO='.$_GET['MYGEO'];
	}
if ($_GET['MYGEO']=='KZ'){
	echo 'http://gipfel.kz?MYGEO='.$_GET['MYGEO'];
	}
if ($_GET['MYGEO']=='BY'){
	echo 'http://gipfel.by?MYGEO='.$_GET['MYGEO'];
	}
if ($_GET['MYGEO']=='UAH'){
	echo 'http://gipfel.ua?MYGEO='.$_GET['MYGEO'];
	}
} else {
	
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


$file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/KZ.csv'); //ОСНОВНОЙ CSV ФАЙЛ
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


//print_r($YES);
function full_trim($str)                            
{                                                  
    return trim(preg_replace('/\s{2,}/', ' ', $str));                                                    
}
/*
foreach($YES as $item){$dp++;
	
	$strSql = "SELECT * FROM `b_iblock_element_property` WHERE IBLOCK_PROPERTY_ID = 7 AND VALUE = '".$item[0]."' ORDER BY `b_iblock_element_property`.`ID` ASC";
	$res = $DB->Query($strSql, false, $err_mess.__LINE__)->Fetch();
	
	$PID = $res['IBLOCK_ELEMENT_ID']; //ELEMENT_ID
	
	$PRODUCT_ID = $res['IBLOCK_ELEMENT_ID']; 
	$PRICE_TYPE_ID = 2;
	$price = str_replace(" ","",full_trim($item[3]));
	$qty = $item[5];
	$rs = CCatalogStoreProduct::GetList(false, array('PRODUCT_ID'=> $PRODUCT_ID, 'STORE_ID' => 2));


$arFields = Array(
"PRODUCT_ID" => $PRODUCT_ID,
"STORE_ID" => 2,
"AMOUNT" => $qty,
);
//$ID = CCatalogStoreProduct::Add($arFields);	
	$arFields = Array(
	    "PRODUCT_ID" => $PRODUCT_ID,
	    "CATALOG_GROUP_ID" => $PRICE_TYPE_ID,
	    "PRICE" => $price,
	    "CURRENCY" => "KZT",
	);
	
	$res = CPrice::GetList(
	        array(),
	        array(
	                "PRODUCT_ID" => $PRODUCT_ID,
	                "CATALOG_GROUP_ID" => $PRICE_TYPE_ID
	            )
	    );
	

	  $drr =  CPrice::Update($arr["ID"], $arFields);
	echo $drr.'|||||'.$item[0].' - '.$PID.' - '.$price.' kz'."\r\n";
	//print_r($item);
}
*/

/*require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>7000), $arSelect);
while($ob = $res->GetNext())
{
	$rand = rand(4,5);
	$str1 = "INSERT INTO `u474277_gipfel`.`b_iblock_element_property` (`ID`, `IBLOCK_PROPERTY_ID`, `IBLOCK_ELEMENT_ID`, `VALUE`, `VALUE_TYPE`, `VALUE_ENUM`, `VALUE_NUM`, `DESCRIPTION`) VALUES (NULL, '197', '".$ob['ID']."', '".$rand."', 'text', '".$rand."', '".$rand."', NULL);";
	$str2 = "INSERT INTO `u474277_gipfel`.`b_iblock_element_property` (`ID`, `IBLOCK_PROPERTY_ID`, `IBLOCK_ELEMENT_ID`, `VALUE`, `VALUE_TYPE`, `VALUE_ENUM`, `VALUE_NUM`, `DESCRIPTION`) VALUES (NULL, '198', '".$ob['ID']."', '".$rand."', 'text', '".$rand."', '".$rand."', NULL);";
	$str3 = "INSERT INTO `u474277_gipfel`.`b_iblock_element_property` (`ID`, `IBLOCK_PROPERTY_ID`, `IBLOCK_ELEMENT_ID`, `VALUE`, `VALUE_TYPE`, `VALUE_ENUM`, `VALUE_NUM`, `DESCRIPTION`) VALUES (NULL, '199', '".$ob['ID']."', '".$rand."', 'text', '".$rand."', '".$rand."', NULL);";
	echo $str1.'<br>';
	echo $str2.'<br>';
	echo $str3.'<br>';
}
*/

	
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");