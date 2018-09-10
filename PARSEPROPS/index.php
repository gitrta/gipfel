<?
ini_set('max_execution_time', 0);
set_time_limit(0);
ini_set('memory_limit', '1536M');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (!CModule::IncludeModule("iblock"))
    return;

$ALLPROPS = array();

$prods_FRID = array();
global $DB;
$addparams = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/PARSEPROPS/gipfel_char.csv'); //  ФАЙЛ С НОВЫМИ ТОВАРАМИ
$r1 = explode("\r", $addparams);

foreach ($r1 as $item){
$product = explode("||",$item);
array_pop($product);
$art =  trim(explode(':',$product[0])[1]);					///ARTICUL

	foreach ($product as $prop){
		$property = explode(':',$prop);
		$p_name = trim($property[0]);
		$p_value = trim($property[1]);
		array_push($ALLPROPS,$p_name);
	}

//echo $art."\n";
	$item = $art;
	//echo $item."\n";
	
	$strSql = "SELECT * FROM `b_iblock_element_property` WHERE IBLOCK_PROPERTY_ID = 7 AND VALUE = '" . $item . "' ORDER BY `b_iblock_element_property`.`ID` ASC";
    $res    = $DB->Query($strSql, false, $err_mess . __LINE__)->Fetch();
    $PID    = $res['IBLOCK_ELEMENT_ID'];
	if(!empty($PID)){
		$prods_FRID[$PID] = $product;
	}

}

$ALLP_UNIQUE = array_unique($ALLPROPS);

foreach($prods_FRID as $key => $it){
	
	foreach($it as $prop){
		$property = explode(':',$prop);
		$p_name = trim($property[0]);
		$p_value = trim($property[1]);
		
		$p_code = "";
		if($p_name == 'Коллекция') $p_code = 'COLLECT';
		if($p_name == 'Материал') $p_code = 'MATERIAL';
		if($p_name == 'Мытье в посудомоечной машине') $p_code = 'MVPM';
		if($p_name == 'Основной цвет') $p_code = 'maincolor';
		if($p_name == 'Размер (см)') $p_code = 'sizesm';
		if($p_name == 'Страна') $p_code = 'country';
		if($p_name == 'Вес (кг)') $p_code = 'Ves';
		if($p_name == 'Высота (см)') $p_code = 'vysotasm';
		if($p_name == 'Крышка в комплекте') $p_code = 'kryshvkom';
		if($p_name == 'Материал крышки') $p_code = 'matkrysh';
		if($p_name == 'Материал ручки') $p_code = 'matruch';
		if($p_name == 'Объем (л)') $p_code = 'VOLUME';
		if($p_name == 'Количество элементов') $p_code = 'quantel';
		if($p_name == 'Диаметр (см)') $p_code = 'DIAMETR';
		if($p_name == 'Можно использовать в духовке') $p_code = 'INWAVE';
		if($p_name == 'Тип покрытия') $p_code = 'tippokr';
		if($p_name == 'Толщина дна (мм)') $p_code = 'toldna';
		if($p_name == 'Толщина стенок (мм)') $p_code = 'tolsten';
		if($p_name == 'Клапан для пара') $p_code = 'klapanpar';
		if($p_name == 'Съемная ручка') $p_code = 'siomruch';
		if($p_name == 'Мощность') $p_code = 'POWER';
		if($p_name == 'Толщина стенок (мм)') $p_code = 'tolsten';
		if($p_name == 'Количество персон') $p_code = 'person_quant';
		
		if($p_code!==""){
			$ELEMENT_ID = $key;  // код элемента
			$PROPERTY_CODE = $p_code;  // код свойства
			$PROPERTY_VALUE = $p_value;  // значение свойства
			CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
			echo $key."\n";
		}

	}
	
	

}

echo "ENDED";

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>