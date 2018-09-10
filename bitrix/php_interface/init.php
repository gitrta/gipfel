<?
	include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/constants.php');
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/test.php")) require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/test.php");


$curDir = $APPLICATION->GetCurDir();
$arDirs = array_diff(explode('/', $curDir), array(''));

$isIndex = $APPLICATION->GetCurPage(false) == SITE_DIR;
$isConfirm = $arDirs[1] == 'personal' && $arDirs[2] == 'order' && $arDirs[3] == 'make' && isset($_GET['ORDER_ID']);


function plural_form($n, $forms) {
  return $n%10==1&&$n%100!=11?$forms[0]:($n%10>=2&&$n%10<=4&&($n%100<10||$n%100>=20)?$forms[1]:$forms[2]);
}


//ALEX AFONICO

AddEventHandler("sale", "OnBeforeOrderAdd", "OnBeforeOrderAddHandler");

function OnBeforeOrderAddHandler(&$arFields) {
	
	if(intval($arFields['PRICE'])>1001) {
		CModule::IncludeModule("sale");
		$arLocs = CSaleLocation::GetByID($arFields['DELIVERY_LOCATION'], LANGUAGE_ID);
		$city=$arLocs["CITY_NAME"];
		
$c1=array('Москва','Апрелевка','Балашиха','Бронницы','Верея','Видное','Волоколамск','Воскресенск','Высоковск','Голицыно','Дедовск','Дзержинский','Дмитров','Долгопрудный','Домодедово','Дрезна','Дубна','Егорьевск','Жуковский','Зарайск','Звенигород','Ивантеевка','Истра','Кашира','Клин','Коломна','Королёв','Котельники','Красноармейск','Красногорск','Краснозаводск','Краснознаменск','Кубинка','Куровское','Ликино-Дулёво','Лобня','Лосино-Петровский','Луховицы','Лыткарино','Люберцы','Можайск','Мытищи','Наро-Фоминск','Ногинск','Одинцово','Озёры','Орехово-Зуево','Павловский Посад','Пересвет','Подольск','Протвино','Пушкино','Пущино','Раменское','Реутов','Рошаль','Руза','Сергиев Посад','Серпухов','Солнечногорск','Старая Купавна','Ступино','Талдом','Фрязино','Химки','Хотьково','Черноголовка','Чехов','Шатура','Щёлково','Электрогорск','Электросталь','Электроугли','Яхрома');

$c2=array('Санкт-Петербург','Бокситогорск','Волосово','Волхов','Всеволожск','Выборг','Высоцк','Гатчина','Ивангород','Каменногорск','Кингисепп','Кириши','Кировск','Коммунар','Лодейное Поле','Луга','Любань','Никольское','Новая Ладога','Отрадное','Пикалёво','Подпорожье','Приморск','Приозерск','Светогорск','Сертолово','Сланцы','Сосновый Бор','Сясьстрой','Тихвин','Тосно','Шлиссельбург');

$c3=array('Екатеринбург','Новосибирск');

$cities = array_merge($c1,$c2,$c3);
if (in_array($city, $cities)) {
	$arFields['PRICE'] = $arFields['PRICE'] - $arFields['PRICE_DELIVERY'];
    $arFields['PRICE_DELIVERY']=0; 
	$arFields['DELIVERY_ID'] = 81;
}

file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logorder.txt', serialize($arFields));	
		//die;
	}
	return $arFields;
}

//СОБЫТИЕ

	AddEventHandler("sale", "OnOrderNewSendEmail", "ModifyOrderSaleMails");

	function ModifyOrderSaleMails($orderID, &$eventName, &$arFields)

	{

	   if(CModule::IncludeModule("sale") && CModule::IncludeModule("iblock"))

	   {

	 //СОСТАВ ЗАКАЗА РАЗБИРАЕМ SALE_ORDER НА ЗАПЧАСТИ

	      $strOrderList = "";

	      $dbBasketItems = CSaleBasket::GetList(

	                 array("NAME" => "ASC"),

	                 array("ORDER_ID" => $orderID),

	                 false,

	                 false,

	                 array("PRODUCT_ID", "ID", "NAME", "DETAIL_PAGE_URL", "QUANTITY", "PRICE", "CURRENCY")

	               );
$strCustomOrderList = '<div style="background-image:url(http://afonico-test.ru/mails/gipfel/background-3.jpg); background-position: left top; background-repeat: repeat repeat; " width="100%">
				<!--[if !mso 15]><!--><table width="600" cellspacing="0" cellpadding="0" class="layout-block-wrapping-table" background="http://afonico-test.ru/mails/gipfel/background-3.jpg" bgcolor="#ffffff" style="mso-hide:all; min-width: 600px; ">
					<tbody><tr>
						<td width="10" style="font-size: 1px; min-width: 10px; ">&nbsp;</td>
						<td height="10" background="http://afonico-test.ru/mails/gipfel/box-bg-11.jpg" bgcolor="#f4f4f5" width="580" style="min-width: 580px; ">
							<div class="spacer"></div>
						</td>
						<td width="10" style="font-size: 1px; min-width: 10px; ">&nbsp;</td>
					</tr>
				</tbody></table>
			<!--<![endif]--><!--[if gte mso 9]><table cellspacing="0" cellpadding="0" class="layout-block-wrapping-table" width="600">
<tr><td width="10" class="layout-block-padding-left" style="font-size:0"><v:rect style="width:10px;height:10px;" stroke="f"><v:fill type="tile" src="http://afonico-test.ru/mails/gipfel/background-3.jpg" color="#ffffff"></v:fill>&nbsp; </v:rect></td><td class="layout-block-content-cell" style="font-size:0;" width="580" height="10"><v:rect style="width:580px;height:10px;" stroke="f"><v:fill type="tile" src="http://afonico-test.ru/mails/gipfel/box-bg-11.jpg" color="#f6f6f8"></v:fill><div class="spacer"></div></v:rect></td><td width="10" class="layout-block-padding-right" style="font-size:0"><v:rect style="width:10px;height:10px;" stroke="f"><v:fill type="tile" src="http://afonico-test.ru/mails/gipfel/background-3.jpg" color="#ffffff"></v:fill>&nbsp; </v:rect></td>
</tr></table><![endif]--></div>';

	 while ($arProps = $dbBasketItems->Fetch())

	  {

  //ПЕРЕМНОЖАЕМ КОЛИЧЕСТВО НА ЦЕНУ

      $summ = $arProps['QUANTITY'] * $arProps['PRICE'];

	  //СОБИРАЕМ В СТРОКУ ТАБЛИЦЫ

	       //$strCustomOrderList .= "<tr><td>".$arProps['NAME']."</td><td>".$arProps['QUANTITY']."</td><td>".$arProps['PRICE']."</td><td>".$arProps['CURRENCY']."</td><td>".$summ."</td><tr>";
	       $strCustomOrderList .= '<div style="background-image:url(http://afonico-test.ru/mails/gipfel/background-3.jpg); background-position: left top; " width="100%">
				<!--[if !mso 15]><!--><table width="600" cellspacing="0" cellpadding="0" class="layout-block-wrapping-table" background="http://afonico-test.ru/mails/gipfel/background-3.jpg" bgcolor="#ffffff" style="mso-hide:all; min-width: 600px; ">
					<tbody><tr>
						<td width="10" style="min-width: 10px; ">&nbsp;</td>
						<td width="560" valign="top" align="left" background="http://afonico-test.ru/mails/gipfel/box-bg-11.jpg" style="padding-left: 10px; padding-right: 10px; min-width: 560px; " bgcolor="#f4f4f5">
							<table cellspacing="0" cellpadding="0" class="layout-block-box-padding" width="560" style="min-width: 560px; ">
								<tbody><tr class="layout-block-vertical-spacer" style="display:none; height:0px; ">
									<td width="560" style="min-width: 560px; "><div class="spacer"></div></td>
								</tr>
								<tr>
									<td width="560" align="left" class="layout-block-padded-column" style="min-width: 560px; ">
										<table width="340" cellspacing="0" cellpadding="0" align="left" class="layout-block-padded-column" style="min-width: 340px; ">
											<tbody><tr>
												<td align="left" valign="top" class="layout-block-padded-column" width="340" style="min-width: 340px; ">
													<div class="text" style="font-size: 16px; font-family: "Lucida Grande"; "><font face="Verdana, sans-serif" style="font-size: 14px; "><span style="color: rgb(51, 51, 102); font-variant-ligatures: normal; orphans: 2; widows: 2; ">•</span> </font><b style="font-size: 14px; font-family: Verdana, sans-serif; color: rgb(0, 32, 83); "><a href="'.$arProps["DETAIL_PAGE_URL"].'" style="color: rgb(0, 32, 83); text-decoration: none; ">'.$arProps["NAME"].'</a></b></div>
												</td>
											</tr>
										</tbody></table>
										<table cellspacing="0" cellpadding="0" align="left" class="layout-block-horizontal-spacer" width="10" style="min-width: 10px; ">
											<tbody><tr>
												<td width="10" class="layout-block-horizontal-spacer" style="line-height: 1px; min-width: 10px; ">&nbsp;</td>
											</tr>
										</tbody></table>
										<table width="100" cellspacing="0" cellpadding="0" align="left" class="layout-block-padded-column" style="min-width: 100px; ">
											<tbody><tr class="layout-block-vertical-spacer" style="display:none; height:0px; ">
												<td width="100" style="min-width: 100px; "><div class="spacer"></div></td>
											</tr>
											<tr>
												<td align="left" valign="top" width="100" style="min-width: 100px; ">
													<div class="text" style="text-align: center; font-size: 16px; font-family: "Lucida Grande"; "><span style="color: rgb(178, 178, 178); font-family: Verdana, sans-serif; font-size: 14px; ">'.$arProps["QUANTITY"].'</span></div>
												</td>
											</tr>
										</tbody></table>
										<table cellspacing="0" cellpadding="0" align="left" class="layout-block-horizontal-spacer" width="10" style="min-width: 10px; ">
											<tbody><tr>
												<td width="10" class="layout-block-horizontal-spacer" style="line-height: 1px; min-width: 10px; ">&nbsp;</td>
											</tr>
										</tbody></table>
										<table width="100" cellspacing="0" cellpadding="0" align="left" class="layout-block-padded-column" style="min-width: 100px; ">
											<tbody><tr class="layout-block-vertical-spacer" style="display:none; height:0px; ">
												<td width="100" style="min-width: 100px; "><div class="spacer"></div></td>
											</tr>
											<tr>
												<td align="left" valign="top" class="layout-block-padded-column" width="100" style="min-width: 100px; ">
													<div class="text" style="font-size: 16px; font-family: "Lucida Grande"; text-align: center; "><b style="text-align: right; color: rgb(66, 66, 66); font-family: Verdana, sans-serif; font-size: 14px; ">'.$summ.' '.$arProps['CURRENCY'].'</b></div>
												</td>
											</tr>
										</tbody></table>
									</td>
								</tr>
							</tbody></table>
						</td>
						<td width="10" style="min-width: 10px; ">&nbsp;</td>
					</tr>
				</tbody></table>
			<!--<![endif]--><!--[if gte mso 9]><table cellspacing="0" cellpadding="0" class="layout-block-wrapping-table" width="600">
<tr><td width="10" class="layout-block-padding-left" bgcolor="#ffffff">&nbsp; </td><td width="580" valign="top" align="left" class="layout-block-content-cell"><v:rect style="width:580px;" stroke="f"><v:fill type="tile" src="http://afonico-test.ru/mails/gipfel/box-bg-11.jpg" color="#f6f6f8"></v:fill><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><div><div style="font-size:0"><table cellspacing="0" cellpadding="0" class="layout-block-box-padding">
<tr><td style="font-size:1px;" width="10">&nbsp; </td><td align="left" valign="top" class="layout-block-padded-column" width="340"><div class="text" style="font-size: 16px; font-family: sans-serif;"><font face="Verdana, sans-serif" style="font-size: 14px;"><span style="color: rgb(51, 51, 102); font-variant-ligatures: normal; orphans: 2; widows: 2;">•</span> </font><b style="font-size: 14px; font-family: Verdana, sans-serif; color: rgb(0, 32, 83);"><a href="'.$arProps["DETAIL_PAGE_URL"].'" style="color: rgb(0, 32, 83); text-decoration: none;">'.$arProps["NAME"].'</a></b></div></td><td class="layout-block-horizontal-spacer" width="10">&nbsp; </td><td width="100" align="left" valign="top"><div class="text" style="text-align: center; font-size: 16px; font-family: sans-serif;"><span style="color: rgb(178, 178, 178); font-family: Verdana, sans-serif; font-size: 14px;">'.$arProps["QUANTITY"].'</span></div></td><td width="10" class="layout-block-horizontal-spacer">&nbsp; </td><td width="100" align="left" valign="top" class="layout-block-padded-column"><div class="text" style="font-size: 16px; font-family: sans-serif; text-align: center;"><b style="text-align: right; color: rgb(66, 66, 66); font-family: Verdana, sans-serif; font-size: 14px;">'.$summ.' '.$arProps['CURRENCY'].'</b></div></td><td style="font-size:1px;" width="10">&nbsp; </td>
</tr></table></div></div></v:textbox></v:rect></td><td width="10" class="layout-block-padding-right" bgcolor="#ffffff">&nbsp; </td>
</tr></table><![endif]--></div>';

	  }

	  //ОБЪЯВЛЯЕМ ПЕРЕМЕННУЮ ДЛЯ ПИСЬМА

	  $arFields["ORDER_TABLE_ITEMS"] = $strCustomOrderList; 

} 

}








 AddEventHandler("main", "OnBeforeProlog", "CheckSectionOrder");
   function CheckSectionOrder()
   {
      global $USER;
      global $APPLICATION;
      if((strpos($APPLICATION->GetCurDir(), "/basket/order/") !== false) && (!$USER->IsAuthorized()))
      {
         $USER->Authorize(2);
      } else {
         if(($USER->IsAuthorized()) && ($USER->GetID() == 2) && (strpos($APPLICATION->GetCurDir(), "/basket/order/") === false))
         {
            $USER->Logout();
         }
      }
   }





AddEventHandler("main", "OnSendUserInfo", "MyOnSendUserInfoHandler"); 
function MyOnSendUserInfoHandler(&$arParams) 
{ 
   $message='
'.$arParams['USER_FIELDS']['NAME'].' '.$arParams['USER_FIELDS']['LAST_NAME'].'

'.$arParams['FIELDS']['MESSAGE'].'

Ваша регистрационная информация:

ID пользователя: '.$arParams['FIELDS']['USER_ID'].'
Login: '.$arParams['FIELDS']['LOGIN'].'

Для смены пароля перейдите по следующей ссылке:
https://gipfel.ru/auth/?lang=ru&change_password=yes&USER_CHECKWORD='.$arParams['FIELDS']['CHECKWORD'].'&USER_LOGIN='.$arParams['FIELDS']['LOGIN'].'

                 
Сообщение сгенерировано автоматически.
';
//printr($arParams['FIELDS']['EMAIL']);
   if (mail($arParams['FIELDS']['EMAIL'], 'Восстановление пароля gipfel.ru', $message)) echo '1';
  // die;
} 


AddEventHandler("iblock", "OnAfterIBlockElementSetPropertyValues", Array("theGift", "fixGift"));
AddEventHandler("sale", "OnOrderAdd", Array(/*"theGift",*/ "OnOrderAdd"));

class theGift {
	function fixGift($ID, $ib, $values, $code) {
		$val = $values['GIFT'];
		if (!$val) return;
		CModule::IncludeModule('iblock');
		$arSelect = Array("ID", "NAME", "PROPERTY_GIFT");
		$arFilter = Array("IBLOCK_ID"=>$ib, "PROPERTY_GIFT"=>$val);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNextElement())
		{
			$arFields = $ob->GetFields();
			$ELEMENT_ID = $arFields['ID'];  
			$PROPERTY_CODE = "GIFT";  
			$PROPERTY_VALUE = "";
			CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
		}
	}

	function OnOrderAdd($ORDER_ID, $arFields, $arParams) {
		
		return true;
		
		CModule::IncludeModule('sale');
		CModule::IncludeModule('iblock');
		$p = $arFields['PRICE'];
		if ($p<5000) $val = 17;
		elseif ($p<10000) $val = 18;
		elseif ($p<15000) $val = 19;
		else $val = 20;
		$arSelect = Array("ID", "NAME", "PROPERTY_GIFT","DETAIL_PAGE_URL");
		$arFilter = Array("IBLOCK_ID"=>2, "PROPERTY_GIFT"=>$val);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		if ($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$ID = $arFields['ID'];
			/*****************************/
			$arFields = array(
			    "PRODUCT_ID" => $ID,
			    "PRODUCT_PRICE_ID" => 0,
			    "PRICE" => 0,
			    "CURRENCY" => "RUB",
			    "QUANTITY" => 1,
			    //"ORDER_ID" => $ORDER_ID,
			    "LID" => SITE_ID,
			    "DELAY" => "N",
			    "CAN_BUY" => "Y",
			    "NAME" => $arFields['NAME'],
			    "DETAIL_PAGE_URL" => $arFields['DETAIL_PAGE_URL'],
			    "PRODUCT_PROVIDER_CLASS" => ""
			  );
			
			  $arProps = array();
			
			  $arFields["PROPS"] = $arProps;
			  
			  
			
			  $new = CSaleBasket::Add($arFields);
if (!$new) die("some went wrong");
			/*****************************/
		}
	}
}







AddEventHandler("main", "OnBeforeEventAdd", "OnSaleDeliveryOrderSendEmail");
function OnSaleDeliveryOrderSendEmail (&$event, &$lid, &$arFields, &$message_id) {
    if ($event=="SALE_NEW_ORDER") {
        if ($arFields['ORDER_ID']>0) {

	        $order = getOrderVars($arFields['ORDER_ID']);

	          $message='
				Новый заказ № '.$arFields['ORDER_ID'].':
				Дата заказа: '.$order['ORDER_DATE'].'
				Имя: '.$order['USER_LAST_NAME'].'
				Email: '.$order['USER_LOGIN'].'
				Телефон: '.$order['PROP_PHONE'].'
				Товар: '.$order['ORDER_LIST'].'
				Цена товара: '.round($order['PRODUCTS'][0]['PRICE']). ' ' .$order['PRODUCTS'][0]['CURRENCY'].'
				Кол-во: '.$order['PRODUCTS'][0]['QUANTITY'].'
				Время доставки: '.$order['PROP_F_TIME'].'
				Город доставки: '.$order['PROP_CITY'].'
				Улица: '.$order['PROP_STREET'].'
				Дом: '.$order['PROP_HOUSE'].'
				';

	       	mail('order@gipfel.net', 'Новый заказ на сайте', $message);
        
        }
    }
}











// все данные о заказе, включая значения свойств и список позиций
function getOrderVars($ORDER_ID) {

	CModule::IncludeModule("sale");
	CModule::IncludeModule("iblock");
	/////////////////////////////////////////////////
	// товары
	$arID = array();
	$arBasketItems = array();
	
	$dbBasketItems = CSaleBasket::GetList(
	     array(
			"NAME" => "ASC",
			"ID" => "ASC"
		),
		array(
	
			"ORDER_ID" => $ORDER_ID
		),
		false,
		false,
		array()
	);
	
	
	while ($arItems = $dbBasketItems->Fetch())
	{

		$tmp = explode("#",$arItems['PRODUCT_XML_ID']);
		if ($tmp[1]) {  $arItems['PARENT_XML_ID'] = $tmp[0]; $arItems['PRODUCT_XML_ID'] = $tmp[1];  }
		$intElementID = $arItems['PRODUCT_ID']; // ID предложения


		if (!$arItems['PRODUCT_XML_ID']) {
			$res = CIBlockElement::GetByID($intElementID);
			if($ar_res = $res->GetNext())
			  $arItems['PRODUCT_XML_ID'] = $ar_res['XML_ID'];	
		}


		// данные о основном товаре
	
		$res = CIBlockElement::GetByID($intElementID);
		$arProduct = $res->GetNext();
	
	
		$arFilter = Array("IBLOCK_ID"=>$arProduct['IBLOCK_ID'], "ID"=>$intElementID);
		$res = CIBlockElement::GetList(Array(), $arFilter, false,false,
		array("ID","IBLOCK_ID","NAME","PREVIEW_PICTURE","DETAIL_PICTURE","DETAIL_PAGE_URL"));
		while($ob = $res->GetNextElement())
		{
		  $arProduct= $ob->GetFields();
		}
	
		$arItems['PRODUCT'] = $arProduct;
	
	
		$db_res = CSaleBasket::GetPropsList(
		        array(
		                "SORT" => "ASC",
		                "NAME" => "ASC"
		            ),
		        array("BASKET_ID" => $arItems['ID'])
		    );
		while ($ar_res = $db_res->Fetch())
		{
		   $arItems['PROP'][] = $ar_res;
		}

	    	$arBasketItems[] = $arItems;
		$modif = "";
		foreach ($arItems['PROP'] as $v) {
			$val = $v['VALUE'];
		}
		$PRODUCTS[] = $arItems;
		$products.=''.$arItems['NAME'].' x '.$arItems['QUANTITY'].' ('.$arItems['PRICE'].')	'.($modif?'['.$modif.'] ':'').'
';
	}
	//echo ($products); exit;
	/////////////////////////////////////////////////
	$result = CSaleOrder::GetByID($ORDER_ID);
	$result['PRODUCTS'] = $PRODUCTS;
	$result['ORDER_LIST'] = $products;
	$result['SALE_EMAIL'] = COption::GetOptionString('sale','order_email');
	
	$result['ORDER_DATE'] = $result['DATE_INSERT_FORMAT'];
	
	if ($arPaySys = CSalePaySystem::GetByID($result['PAY_SYSTEM_ID'], $result['PERSON_TYPE_ID']))
	{
	   $result['PAY_SYSTEM'] = $arPaySys["PSA_NAME"];
	}
	
	$db_vars = CSaleOrderPropsVariant::GetList(
	     array("SORT" => "ASC")
	);
	while ($vars = $db_vars->Fetch())
	{
	     $arVariants[$vars['ORDER_PROPS_ID']][$vars['VALUE']] = $vars['NAME'];
	}
	
	$arDeliv = CSaleDelivery::GetByID($result['DELIVERY_ID']);
	if ($arDeliv)
	{
		$result['ALL_DELIVERY'] = $arDeliv;
	   $result['DELIVERY'] =  "\"".$arDeliv["NAME"]."\" стоит ".CurrencyFormat($arDeliv["PRICE"], $arDeliv["CURRENCY"]);
	}
	$tmp = explode(":",$result['DELIVERY_ID']);
	$dbResult = CSaleDeliveryHandler::GetBySID($tmp[0]);
	
	if ($arResult = $dbResult->GetNext())
	{
	  foreach ($arResult['PROFILES'] as $profile_id => $arProfile)
	  {
	    if ($tmp[1]==$profile_id) $result['DELIVERY'] = $arResult['NAME'] . ": " . $arProfile['TITLE'];
	  }
	}
	//print_r($arVariants);
	
	$db_vals = CSaleOrderPropsValue::GetList(
		array("SORT" => "ASC"),
		array(
			"ORDER_ID" => $ORDER_ID,
		)
	);
	while ($arVal=$db_vals->GetNext()) { 
		$ret[$arVal['ORDER_PROPS_ID']] = $arVal['VALUE'];
	}
	
	
	$db_props = CSaleOrderProps::GetList(
	        array("SORT" => "ASC"),
	        array(),
	        false,
	        false,
	        array()
	    );
	while($props = $db_props->Fetch()) {
		$id = $props['ID'];
		$code = $props['CODE'];
		$value = $ret[$id];
		if ($arVariants[$id][$value]) $value = $arVariants[$id][$value];
		$result["PROP_$code"] = $value;
	}

	if ($result['DELIVERY_ID']==3) {
		$dlt = array("STREET","HOUSE","KOD_DOM","FLOOR","PORCH","ROOM","TYPE_ENTER");
		foreach ($dlt as $v) $result["PROP_$v"]="";
	}

	return $result;
}

function getImgStyle($src,$h) {
	$is = getimagesize($_SERVER['DOCUMENT_ROOT'].$src);
	$height = floor(($is[1]/$is[0])*$h);
	$ret = floor(($h-$height)/2)+4;
	$ret2 = $h-$ret-$height + 3; $ret2=$ret2>0?$ret2:0; 
	return " style=\"padding:{$ret}px 0 ".$ret2."px 0;\" ";
}

function pre($var, $die = false)
{
    global $USER;

    if ($USER->IsAdmin()) {
        echo '<pre>Дэбаг только для разработчиков<br>' . var_export($var, 1) . '</pre>';
        if ($die) die;
    }
}

function getSymbol($prop){

    $arSym = array(
        'DIAMETR' => ' см.',
        'VOLUME' => ' л.'
    );
    if(isset($arSym[$prop['CODE']]))

        return $prop['DISPLAY_VALUE'] . $arSym[$prop['CODE']];
    else
        return $prop['DISPLAY_VALUE'];

}


//AddEventHandler('sale', 'OnSaleComponentOrderOneStepProcess', Array('OnSaleComponentOrderOneStepProcessHandler'));
//function OnSaleComponentOrderOneStepProcessHandler($arResult,$arUserResult)
//{
   //AddMessage2Log(print_r($arResult,true), "my_module_id");
//}
/*
AddEventHandler('sale', 'OnBeforeBasketAdd', 'BeforeBasketAddHandler');

function BeforeBasketAddHandler(&$arFields)
{
    $arFields['PRODUCT_PROVIDER_CLASS'] = 'CCatalogProductProviderCust';
    $arFields['CUSTOM_PRICE'] = 'Y';
}
*/
CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");


AddEventHandler("sale", "OnBasketAdd", "AddToBasket");

function AddToBasket( $ID, $arFields )
{


	if ($_SERVER['SERVER_NAME'] == 'gipfel.ru' ) {


		$arBasketItems = array();

		$dbBasketItems = CSaleBasket::GetList(
			 array(
						"NAME" => "ASC",
						"ID" => "ASC"
					 ),
			 array(
						"FUSER_ID" => CSaleBasket::GetBasketUserID(),
						"LID" => SITE_ID,
						"ORDER_ID" => "NULL"
					 ),
			 false,
			 false,
			 array("ID", "PRICE", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS", "NAME")
					 );
					 
		while ($arItems = $dbBasketItems->Fetch())
		{
			$arBasketItems[] = $arItems;
		}

		$poakcii=0;
		$mcen = 100000;	
		$mname= "";			

       // AddMessage2Log(print_r($arBasketItems,true), "my_module_id");
		
		foreach($arBasketItems as $arItem){
		
			$arSelect = Array("ID", "NAME", "PROPERTY_AKCII", "CATALOG_GROUP_1","PROPERTY_NOVINKA");
		
			$rs = CIBlockElement::GetList (
			   Array("RAND" => "ASC"),
			   Array("IBLOCK_ID" => 2,"ID" => $arItem["PRODUCT_ID"]),
			   false,
			   false,
			   $arSelect
			);
							 
			while($ob = $rs->GetNextElement())
			{
			 $arFields2 = $ob->GetFields();


			  //AddMessage2Log(print_r($arFields2["CATALOG_PRICE_1"],true), "my_module_id2");
			 
			  if($arFields2['PROPERTY_AKCII_VALUE']=="Акция 1+1" and $arFields2['PROPERTY_NOVINKA_VALUE']!="НОВИНКА")
			  {
			   $poakcii = $poakcii + $arItem["QUANTITY"];

			   if($arItem["PRICE"]<1)
			   {
			     $arItem["PRICE"] = $arFields2["CATALOG_PRICE_1"];
				 $arFields["PRICE"] = $arItem["PRICE"];
				 CSaleBasket::Update($arItem["ID"], $arFields);
			   }
			   
			   if($arItem["PRICE"]<$mcen)
				{
				 $mcen = $arItem["PRICE"];
				 $mid = $arItem["ID"];
				 $arM = $arItem; 
				}			  
			  }
			}	
		 
		}	

  
		if($poakcii>2)
		{	
			//if($arFields["NAME"] == $mname)
			//{
		    $oldprice = $arFields["PRICE"];	
			
			 if($ID != $mid)
			 {
			 $arFields = $arM;           
			 }
			 $arFields["PRICE"] = 0;
			 $arFields["BASE_PRICE"] = 0;
			 $arFields["DISCOUNT_PRICE"] = 0;		
			 $arFields["CURRENCY"] = "RUB"; 
			 $arFields["CALLBACK_FUNC"] = ""; 
			 $arFields["IGNORE_CALLBACK_FUNC"] = "Y";
			 $arFields["PRODUCT_PROVIDER_CLASS"] = "";
			 $arFields["CALLBACK_FUNC"] = "";	

			//}
			
			if($arFields["QUANTITY"] > 1)
			{
			  $arProps[] = array(
				"NAME" => "Акция",
				"VALUE" => "1+1"
			  );

             $arFields["PROPS"] = $arProps;
             $oldquant =  $arFields["QUANTITY"]-1;			 
             $arFields["QUANTITY"]=1;			 
			 CSaleBasket::Update($mid, $arFields);	

			  $arFields2 = array(
				"PRODUCT_ID" => $arFields["PRODUCT_ID"],
				"PRODUCT_PRICE_ID" => 0,
				"PRICE" => $oldprice,
				"CURRENCY" => "RUB",
				"QUANTITY" => $oldquant,
				"LID" => "s1",
				"DELAY" => "N",
				"CAN_BUY" => "Y",
				"NAME" => $arFields["NAME"],
				"MODULE" => "my_module",
				"NOTES" => "",
				"DETAIL_PAGE_URL" => $arFields["DETAIL_PAGE_URL"],
			  );

			 CSaleBasket::Add($arFields2);	
			}
			else
			{					
			 CSaleBasket::Update($mid, $arFields);			 
			}
		}	


	} else {


		$arBasketItems = array();

		$dbBasketItems = CSaleBasket::GetList(
			 array(
						"NAME" => "ASC",
						"ID" => "ASC"
					 ),
			 array(
						"FUSER_ID" => CSaleBasket::GetBasketUserID(),
						"LID" => SITE_ID,
						"ORDER_ID" => "NULL"
					 ),
			 false,
			 false,
			 array("ID", "PRICE", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS", "NAME")
					 );
					 
		while ($arItems = $dbBasketItems->Fetch())
		{
			$arBasketItems[] = $arItems;
		}

		$poakcii=0;
		$mcen = 100000;	
		$mname= "";			

       // AddMessage2Log(print_r($arBasketItems,true), "my_module_id");
		
		foreach($arBasketItems as $arItem){
		
			$arSelect = Array("ID", "NAME", "PROPERTY_AKCII", "CATALOG_GROUP_1","PROPERTY_NOVINKA");
		
			$rs = CIBlockElement::GetList (
			   Array("RAND" => "ASC"),
			   Array("IBLOCK_ID" => 2,"ID" => $arItem["PRODUCT_ID"]),
			   false,
			   false,
			   $arSelect
			);
							 
			while($ob = $rs->GetNextElement())
			{
			 $arFields2 = $ob->GetFields();


			  //AddMessage2Log(print_r($arFields2["CATALOG_PRICE_1"],true), "my_module_id2");
			 
			  if($arFields2['PROPERTY_AKCII_VALUE']=="Акция 1+1" and $arFields2['PROPERTY_NOVINKA_VALUE']!="НОВИНКА")
			  {
			   $poakcii = $poakcii + $arItem["QUANTITY"];

			   if($arItem["PRICE"]<1)
			   {
			     $arItem["PRICE"] = $arFields2["CATALOG_PRICE_1"];
				 $arFields["PRICE"] = $arItem["PRICE"];
				 CSaleBasket::Update($arItem["ID"], $arFields);
			   }
			   
			   if($arItem["PRICE"]<$mcen)
				{
				 $mcen = $arItem["PRICE"];
				 $mid = $arItem["ID"];
				 $arM = $arItem; 
				}			  
			  }
			}	
		 
		}	

  
		if($poakcii>2)
		{	
			//if($arFields["NAME"] == $mname)
			//{
		    $oldprice = $arFields["PRICE"];	
			
			 if($ID != $mid)
			 {
			 $arFields = $arM;           
			 }
			 $arFields["PRICE"] = 0;
			 $arFields["BASE_PRICE"] = 0;
			 $arFields["DISCOUNT_PRICE"] = 0;		
			 $arFields["CURRENCY"] = "RUB"; 
			 $arFields["CALLBACK_FUNC"] = ""; 
			 $arFields["IGNORE_CALLBACK_FUNC"] = "Y";
			 $arFields["PRODUCT_PROVIDER_CLASS"] = "";
			 $arFields["CALLBACK_FUNC"] = "";	

			//}
			
			if($arFields["QUANTITY"] > 1)
			{
			  $arProps[] = array(
				"NAME" => "Акция",
				"VALUE" => "1+1"
			  );

             $arFields["PROPS"] = $arProps;
             $oldquant =  $arFields["QUANTITY"]-1;			 
             $arFields["QUANTITY"]=1;			 
			 CSaleBasket::Update($mid, $arFields);	

			  $arFields2 = array(
				"PRODUCT_ID" => $arFields["PRODUCT_ID"],
				"PRODUCT_PRICE_ID" => 0,
				"PRICE" => $oldprice,
				"CURRENCY" => "RUB",
				"QUANTITY" => $oldquant,
				"LID" => "s1",
				"DELAY" => "N",
				"CAN_BUY" => "Y",
				"NAME" => $arFields["NAME"],
				"MODULE" => "my_module",
				"NOTES" => "",
				"DETAIL_PAGE_URL" => $arFields["DETAIL_PAGE_URL"],
			  );

			 CSaleBasket::Add($arFields2);	
			}
			else
			{					
			 CSaleBasket::Update($mid, $arFields);			 
			}
		}	







	}



}


AddEventHandler("sale", "OnBasketAdd", "DeleteToBasket");

function DeleteToBasket($ID)
{

		$arBasketItems = array();

		$dbBasketItems = CSaleBasket::GetList(
			 array(
						"NAME" => "ASC",
						"ID" => "ASC"
					 ),
			 array(
						"FUSER_ID" => CSaleBasket::GetBasketUserID(),
						"LID" => SITE_ID,
						"ORDER_ID" => "NULL"
					 ),
			 false,
			 false,
			 array("ID", "PRICE", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS", "NAME")
					 );
					 
		while ($arItems = $dbBasketItems->Fetch())
		{
			$arBasketItems[] = $arItems;
		}

		$poakcii = 0;
		$mcen = 100000;	
		$mname = "";			
		 
		foreach($arBasketItems as $arItem){
		
			$arSelect = Array("ID", "NAME", "PROPERTY_AKCII");
		
			$rs = CIBlockElement::GetList (
			   Array("RAND" => "ASC"),
			   Array("IBLOCK_ID" => 2,"ID" => $arItem["PRODUCT_ID"]),
			   false,
			   false,
			   $arSelect
			);
							 
			while($ob = $rs->GetNextElement())
			{
			 $arFields2 = $ob->GetFields();
			  if($arFields2['PROPERTY_AKCII_VALUE']=="Акция 1+1")
			  {
			   $poakcii++;
			   if($arItem["PRICE"]<$mcen)
				{
				 $mcen = $arItem["PRICE"];
				 $mid = $arItem["ID"];
				 $arM = $arItem; 
				}			  
			  }
			}	
		 
		}	
		

		if($poakcii>2)
		{	

			 $arFields = $arM;           			 
			 $arFields["PRICE"] = 0;
			 $arFields["BASE_PRICE"] = 0;
			 $arFields["DISCOUNT_PRICE"] = 0;		
			 $arFields["CURRENCY"] = "RUB"; 
			 $arFields["CALLBACK_FUNC"] = ""; 
			 $arFields["IGNORE_CALLBACK_FUNC"] = "Y";
			 $arFields["PRODUCT_PROVIDER_CLASS"] = "";
			 $arFields["CALLBACK_FUNC"] = "";	
			 			
			 CSaleBasket::Update($mid, $arFields);
		}	
}


/*
class CCatalogProductProviderCust extends CCatalogProductProvider
{
   
    public static function GetProductData($arParams)
    {
        $arResult = CCatalogProductProvider::GetProductData($arParams);
		
				$arBasketItems = array();

				$dbBasketItems = CSaleBasket::GetList(
					 array(
								"NAME" => "ASC",
								"ID" => "ASC"
							 ),
					 array(
								"FUSER_ID" => CSaleBasket::GetBasketUserID(),
								"LID" => SITE_ID,
								"ORDER_ID" => "NULL"
							 ),
					 false,
					 false,
					 array("ID", "PRICE", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS", "NAME")
							 );
				while ($arItems = $dbBasketItems->Fetch())
				{
					$arBasketItems[] = $arItems;
				}



			$poakcii=0;
			$mcen =100000;	
            $mname="";			
			 
            foreach($arBasketItems as $arItem){
			
				$arSelect = Array("ID", "NAME", "PROPERTY_AKCII");
			
				$rs = CIBlockElement::GetList (
				   Array("RAND" => "ASC"),
				   Array("IBLOCK_ID" => 2,"ID" => $arItem["PRODUCT_ID"]),
				   false,
				   false,
				   $arSelect
				);
								 
				while($ob = $rs->GetNextElement())
				{
				 $arFields = $ob->GetFields();
				  if($arFields['PROPERTY_AKCII_VALUE']=="Акция 1+1")
				  {
				   $poakcii++;
				   if($arItem["PRICE"]<$mcen)
					{
					 $mcen = $arItem["PRICE"];
					 $mname = $arItem["NAME"];
					}
				  
				  }
				}	
			 
			}	
			
	  
			if($poakcii>2)
			{	
				if($arResult["NAME"]==$mname)
				{
				
			
				  // $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
				  //$basket->refreshData(); 
				  $arResult["PRICE"] = 0;
				  $arResult["BASE_PRICE"] = 0;
                  $arResult['DISCOUNT_PRICE'] = 0;		

					$arResult["CURRENCY"] = "RUB"; 
					$arResult["CALLBACK_FUNC"] = ""; 
					$arResult["IGNORE_CALLBACK_FUNC"] = "Y";				  
				}
			}		

        return $arResult;
    }
	
    public static function OrderProduct($arParams)
    {	
        $arResult = CCatalogProductProvider::GetProductData($arParams);
		
				$arBasketItems = array();

				$dbBasketItems = CSaleBasket::GetList(
					 array(
								"NAME" => "ASC",
								"ID" => "ASC"
							 ),
					 array(
								"FUSER_ID" => CSaleBasket::GetBasketUserID(),
								"LID" => SITE_ID,
								"ORDER_ID" => "NULL"
							 ),
					 false,
					 false,
					 array("ID", "PRICE", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS", "NAME")
							 );
				while ($arItems = $dbBasketItems->Fetch())
				{
					$arBasketItems[] = $arItems;
				}

			$poakcii=0;
			$mcen =100000;	
            $mname="";			
			 
            foreach($arBasketItems as $arItem){
			
				$arSelect = Array("ID", "NAME", "PROPERTY_AKCII");
			
				$rs = CIBlockElement::GetList (
				   Array("RAND" => "ASC"),
				   Array("IBLOCK_ID" => 2,"ID" => $arItem["PRODUCT_ID"]),
				   false,
				   false,
				   $arSelect
				);
								 
				while($ob = $rs->GetNextElement())
				{
				 $arFields = $ob->GetFields();
				  if($arFields['PROPERTY_AKCII_VALUE']=="Акция 1+1")
				  {
				   $poakcii++;
				   if($arItem["PRICE"]<$mcen)
					{
					 $mcen = $arItem["PRICE"];
					 $mname = $arItem["NAME"];
					}
				  
				  }
				}	
			 
			}	
			  
			if($poakcii>2)
			{	
				if($arResult["NAME"]==$mname)
				{
				  $arResult["PRICE"] = 0;
				  $arResult["BASE_PRICE"] = 0;
                  $arResult['DISCOUNT_PRICE'] = 0;				  
				}
			}		

        return $arResult;

    }	
 
} 
*/
?>