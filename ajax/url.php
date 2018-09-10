<?require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
global $USER;

if ($_GET["ag"] == "") {
    header("HTTP/1.0 404 Not Found");
    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404", "Y");
    LocalRedirect("404.php");
}

/*
//поставить защиту на повторное сгорание бонусов и сделать уведомление
    CModule::IncludeModule("sale");
    $res = CSaleUserTransact::GetList(Array("ID" => "DESC"), array("DEBIT" => "Y","<TRANSACT_DATE"=>"07.06.2016 10:47:34"));
    while ($arFields = $res->Fetch())
    {    
	 $desc = substr($arFields["DESCRIPTION"], 0, 8);
	 if($desc == "За заказ")
     {
      echo $arFields["TRANSACT_DATE"]." ".$arFields["ID"]." ".$arFields["DEBIT"]." ".$arFields["USER_ID"]." ".$arFields["DESCRIPTION"]." ".$arFields["AMOUNT"];
     
	    if ($ar = CSaleUserAccount::GetByUserID($arFields["USER_ID"], "RUB")) 
	    {
		   echo " На счете ".$ar["CURRENT_BUDGET"]."<br />"; 
		   if($ar["CURRENT_BUDGET"]>=$arFields["AMOUNT"])
		   {
			 $snim = -$arFields["AMOUNT"];   
			   CSaleUserAccount::UpdateAccount(
					$arFields["USER_ID"],
					$snim,
					"RUB",
					"Бонусы сгорели"
				);
		   }
	    } 
	 }
    }
*/
    CModule::IncludeModule("iblock");
    CModule::IncludeModule("sale");	
	CModule::IncludeModule('catalog');
		 
	/*$arFilter["IBLOCK_ID"] = 21;	
	$arFilter["!PROPERTY_SKIDKA"] = false;	
	
	$arSelect = Array(
		"ID",
		"IBLOCK_ID",
		"CATALOG_GROUP_4",
		"NAME",
		"PROPERTY_SKIDKA",					
	);
		
    $db_list = CIBlockElement::GetList(Array("timestamp_x" => "asc"), $arFilter, false, false, $arSelect);
    $result = array();
    while ($ar_result = $db_list->GetNext())
    {	
	
	 echo $ar_result["NAME"]." ".$ar_result["CATALOG_PRICE_ID_4"]." ".$ar_result["PROPERTY_SKIDKA_VALUE"]."<br>"; 
	 
	 $PROPERTY_CODE = "SKIDKA"; 
	 $PROPERTY_VALUE = 0; 
	 CIBlockElement::SetPropertyValues($ar_result["ID"], 21, $PROPERTY_VALUE, $PROPERTY_CODE);
	
	}*/
	
	
	$arFilter["ACTIVE"] = "Y";	 
	$arFilter["IBLOCK_ID"] = 22;	
	$arFilter["!PROPERTY_TSENAPOAKTSII_1"] = false;	
	
	$arSelect = Array(
		"ID",
		"IBLOCK_ID",
		"CATALOG_GROUP_4",
		"NAME",
		"PROPERTY_TSENAPOAKTSII_1",					
	);
		
    $db_list = CIBlockElement::GetList(Array("timestamp_x" => "asc"), $arFilter, false, false, $arSelect);
    $result = array();
    while ($ar_result = $db_list->GetNext())
    {

     echo $ar_result["NAME"]." ".$ar_result["CATALOG_PRICE_ID_4"]." ".$ar_result["PROPERTY_TSENAPOAKTSII_1_VALUE"]."<br>"; 

	$aDiscountFields = array(
			'SITE_ID'
			=> SITE_ID,
			'ACTIVE'
			=> 'Y',
			'NAME'
			=> 'Скидка ПО акции на товар '.$ar_result["NAME"],
			'COUPON'
			=> null,
			/**
			 * Максимальная величина скидки
			 */
			'MAX_DISCOUNT'
			=> null,
			/**
			 * Тип скидки. P - значение задается в процентах, F - фиксированная величина
			 */
			'VALUE_TYPE'
			=> 'S',
			'VALUE'
			=> $ar_result["PROPERTY_TSENAPOAKTSII_1_VALUE"],
			'CURRENCY'
			=> 'RUB',
			'ACTIVE_FROM'
			=> null,
			'ACTIVE_TO'
			=> null,
			/**
			 * Массив идентификаторов товаров на которые распространяется скидка
			 */
			'PRODUCT_IDS'
			=> array($ar_result["ID"]),
			/**
			 * Массив идентификаторов разделов каталога (для ограничения по группе 
			товаров)
			 */
			'SECTION_IDS'
			=> null,
			/**
			 * Ограничение по группам пользователей
			 */
			'GROUP_IDS'
			=> null,
			/**
			 * Ограничение по типу цен
			 */
			'CATALOG_GROUP_IDS'
			=> null,
			'CATALOG_COUPONS'
			=> null,
			'NOTES'
			=> 'Скидка ПО акции на товар '.$ar_result["NAME"],
			);
	
	/*	$ID = CCatalogDiscount::Add($aDiscountFields);
		$res = $ID>0;
		if (!$res) { 
			$ex = $APPLICATION->GetException();  
			$ex->GetString(); 
        }*/
    }	

	$arFilter = array();
	$arFilter["IBLOCK_ID"] = 21;	
	$arFilter["!PROPERTY_TSENAPOAKTSII"] = false;	
	
	$arSelect = Array(
		"ID",
		"IBLOCK_ID",
		"CATALOG_GROUP_4",
		"NAME",
		"PROPERTY_TSENAPOAKTSII",					
	);
		
    $db_list = CIBlockElement::GetList(Array("timestamp_x" => "asc"), $arFilter, false, false, $arSelect);
    $result = array();
    while ($ar_result = $db_list->GetNext())
    {

    echo $ar_result["NAME"]." ".$ar_result["CATALOG_PRICE_ID_4"]." ".$ar_result["PROPERTY_TSENAPOAKTSII_VALUE"]."<br>"; 

	$aDiscountFields = array(
			'SITE_ID'
			=> SITE_ID,
			'ACTIVE'
			=> 'Y',
			'NAME'
			=> 'Скидка ПО акции на товар '.$ar_result["NAME"],
			'COUPON'
			=> null,
			'MAX_DISCOUNT'
			=> null,
			'VALUE_TYPE'
			=> 'S',
			'VALUE'
			=> $ar_result["PROPERTY_TSENAPOAKTSII_VALUE"],
			'CURRENCY'
			=> 'RUB',
			'ACTIVE_FROM'
			=> null,
			'ACTIVE_TO'
			=> null,
			'PRODUCT_IDS'
			=> array($ar_result["ID"]),
			'SECTION_IDS'
			=> null,
			'GROUP_IDS'
			=> null,
			'CATALOG_GROUP_IDS'
			=> null,
			'CATALOG_COUPONS'
			=> null,
			'NOTES'
			=> 'Скидка ПО акции на товар '.$ar_result["NAME"],
		);
	
		/*$ID = CCatalogDiscount::Add($aDiscountFields);
		$res = $ID>0;
		if (!$res) { 
			$ex = $APPLICATION->GetException();  
			$ex->GetString(); 
        }*/
    }	
	
    var_dump($USER->Authorize('1'));
    echo "11<br />";

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>