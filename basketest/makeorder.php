<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


$dd = preg_replace('/[^0-9,]/', '', $_POST['sumdost']);
$_POST['sumdost'] = round(CCurrencyRates::ConvertCurrency($dd, $GLOBALS["MCUR"], "RUB"));
$SUMZAK = preg_replace('/[^0-9,]/', '', $_POST["SUMITOG"]);
$CURZAK = $_POST['CURITOG'];
	
use Bitrix\Main,
	Bitrix\Main\Loader,
	Bitrix\Main\Context,
	Bitrix\Currency\CurrencyManager,
	Bitrix\Main\Config\Option,
	Bitrix\Main\Web\Json,
	Bitrix\Main\Localization\Loc,
	Bitrix\Sale,
	Bitrix\Sale\Order,
	Bitrix\Sale\PersonType,
	Bitrix\Sale\Shipment,
	Bitrix\Sale\PaySystem,
	Bitrix\Sale\Payment,
	Bitrix\Sale\Delivery,
	Bitrix\Sale\Location\LocationTable,
	Bitrix\Sale\Result,
	Bitrix\Sale\DiscountCouponsManager,
	Bitrix\Sale\Services\Company;

CModule::IncludeModule("catalog");
$arLocs = CSaleLocation::GetByID($_POST['LOCATION'], LANGUAGE_ID); //Получаем город
$r_deli = $request['DELIVERY_ID'];

///////////////////


$c1=array('Москва','Апрелевка','Балашиха','Бронницы','Верея','Видное','Волоколамск','Воскресенск','Высоковск','Голицыно','Дедовск','Дзержинский','Дмитров','Долгопрудный','Домодедово','Дрезна','Дубна','Егорьевск','Жуковский','Зарайск','Звенигород','Ивантеевка','Истра','Кашира','Клин','Коломна','Королёв','Котельники','Красноармейск','Красногорск','Краснозаводск','Краснознаменск','Кубинка','Куровское','Ликино-Дулёво','Лобня','Лосино-Петровский','Луховицы','Лыткарино','Люберцы','Можайск','Мытищи','Наро-Фоминск','Ногинск','Одинцово','Озёры','Орехово-Зуево','Павловский Посад','Пересвет','Подольск','Протвино','Пушкино','Пущино','Раменское','Реутов','Рошаль','Руза','Сергиев Посад','Серпухов','Солнечногорск','Старая Купавна','Ступино','Талдом','Фрязино','Химки','Хотьково','Черноголовка','Чехов','Шатура','Щёлково','Электрогорск','Электросталь','Электроугли','Яхрома');

$c2=array('Санкт-Петербург','Бокситогорск','Волосово','Волхов','Всеволожск','Выборг','Высоцк','Гатчина','Ивангород','Каменногорск','Кингисепп','Кириши','Кировск','Коммунар','Лодейное Поле','Луга','Любань','Никольское','Новая Ладога','Отрадное','Пикалёво','Подпорожье','Приморск','Приозерск','Светогорск','Сертолово','Сланцы','Сосновый Бор','Сясьстрой','Тихвин','Тосно','Шлиссельбург');

$c3=array('Екатеринбург','Новосибирск');

$cities = array_merge($c1,$c2,$c3);
if (in_array($arLocs["CITY_NAME"], $cities) and $SUMZAK>1001) {
	$r_deli = 81;
	$_POST['sumdost']=0;
}



///////////////////

global $USER;

Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var $APPLICATION CMain
 * @var $USER CUser
 */ 

Loc::loadMessages(__FILE__);

if (!Loader::includeModule("sale"))
{
	ShowError(Loc::getMessage("SOA_MODULE_NOT_INSTALL"));
	return;
}

// Допустим некоторые поля приходит в запросе
$request = Context::getCurrent()->getRequest();
$PTID = $request["PTID"];
$name = $request["NAME"];
$email = $request['EMAIL'];
$phone = $request["PHONE"];
$street = $request['STREET'];
$comment = $request["comzak"];

$siteId = Context::getCurrent()->getSite();
$currencyCode = CurrencyManager::getBaseCurrency();

if ($USER->isAuthorized()){
	$UID = $USER->GetID();
} else {
	$user = new CUser;

$arFieldss = Array(
  "NAME"              => $name,
  "EMAIL"             => $email,
  "PERSONAL_PHONE"	  => $phone,
  "LOGIN"             => 'user_'.preg_replace("/[^0-9]/", '', $phone).'_'.rand(0,1000),
  "LID"               => "s1",
  "ACTIVE"            => "Y",
  "GROUP_ID"          => array(5),
  "PASSWORD"          => "123456",
  "PERSONAL_CITY"	  => $arLocs["CITY_NAME"],
  "PERSONAL_STREET"	  => $street,
  "CONFIRM_PASSWORD"  => "123456",
);
	
$UID = $user->Add($arFieldss);
}
if (empty($UID)) {echo $email; die; } else{
	$USER->Authorize($UID);
}
//print_r($arFieldss);die;
$siteId = \Bitrix\Main\Context::getCurrent()->getSite();
$currencyCode = Option::get('sale', 'default_currency', 'RUB');
DiscountCouponsManager::init();
$order = Order::create($siteId, $UID);
$order->setPersonTypeId($PTID);
$basket = Sale\Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), $siteId)->getOrderableItems();
if($GLOBALS["MCUR"] == 'RUB' || $_SESSION['RR'] = 'BY') {$prid = 1; $crts = 'RUB';}
if($GLOBALS["MCUR"] == 'KZT') {$prid = 2; $crts = 'KZT';}
foreach ($basket as $basketItem) {
	
$db_res = CPrice::GetListEx(array(),array("PRODUCT_ID" => $basketItem->getField('PRODUCT_ID'),"CATALOG_GROUP_ID" => $prid));
if ($ar_res = $db_res->Fetch())
	{
		if($crts=='KZT') $ar_res["PRICE"] = CCurrencyRates::ConvertCurrency($ar_res["PRICE"], "KZT", "RUB");
	   //print_r($ar_res);
	   $basketItem->setField('CURRENCY',$crts);
	   $basketItem->setField('PRODUCT_PROVIDER_CLASS','CCatalogProductProvider');
	   $basketItem->setField('PRICE',$ar_res["PRICE"]);
	   $basketItem->setField('BASE_PRICE',$ar_res["PRICE"]);
	   $basketItem->setField('CUSTOM_PRICE','Y');
	   $basketItem->setField('IGNORE_CALLBACK_FUNC','Y');
	
	}
}
//print_r($basket); echo $prid.'||'.$crts;
$basket->save();

//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
//die;
$order->setBasket($basket);

// РЎРѕР·РґР°РЅРёРµ РѕС‚РіСЂСѓР·РєРё
$shipmentCollection = $order->getShipmentCollection();
foreach ($shipmentCollection as $shipment) {
	if (!$shipment->isSystem()) { 
		$shipment->allowDelivery();
	}
}
$shipment = $shipmentCollection->createItem(
	\Bitrix\Sale\Delivery\Services\Manager::getObjectById(1)
);
$shipmentItemCollection = $shipment->getShipmentItemCollection();

/** @var \Bitrix\Sale\BasketItem $basketItem */
foreach ($basket as $basketItem) {
	$item = $shipmentItemCollection->createItem($basketItem);
	$item->setQuantity($basketItem->getQuantity());
}
$arDeliveryServiceAll = Delivery\Services\Manager::getActiveList();

if (!empty($arDeliveryServiceAll)) {
    reset($arDeliveryServiceAll);
    foreach($arDeliveryServiceAll as $AOL){
	    if($AOL['CODE']==$r_deli){
		    $named = $AOL['NAME'];
		    $DID = $AOL['ID'];
	    }
	}
	if (empty($DID)){
		
	$arDeliv = \Bitrix\Sale\Delivery\Services\Manager::getById($r_deli);
	$DID = $arDeliv['ID'];
	$named = $arDeliv['NAME'];
	}

    $shipment->setFields(array(
        'DELIVERY_ID' => $DID ,
        'DELIVERY_NAME' => $named,
        'BASE_PRICE_DELIVERY' => $_POST['sumdost'],
        'PRICE_DELIVERY' => $_POST['sumdost'],
        'CURRENCY' => $order->getCurrency()
    ));
    //print_r($shipment);die;
/*
   print_r(array(
        'DELIVERY_ID' => $DID ,
        'DELIVERY_NAME' => $named,
        'CURRENCY' => $order->getCurrency()
    )); die;
*/
    $shipmentCollection->calculateDelivery();
}

// РЎРѕР·РґР°РЅРёРµ РѕРїР»Р°С‚С‹
$paymentCollection = $order->getPaymentCollection();
$payment = $paymentCollection->createItem(
	\Bitrix\Sale\PaySystem\Manager::getObjectById($request['PAY_SYSTEM_ID'])
);
$payment->setField("SUM", $order->getPrice());
$payment->setField("CURRENCY", $order->getCurrency());

/*print_r($_POST);

die;*/
$sumost = $_POST['sumdost'];

/******************************* Лепим свойства заказа */

$propertyCollection = $order->getPropertyCollection();
$propertyCollection2 = $order->getPropertyCollection()->getArray();
$PROPS = array();
foreach($propertyCollection2['properties'] as $p){
	if (array_key_exists($p['CODE'], $_POST)) {
    	$PROPS[$p['CODE']]=$p['ID'];
	}
}

$final = array();
foreach($_POST as $key=>$item){
	foreach($PROPS as $key2=>$p){
		if ($key2 == $key and !empty($item)) $final[$p]=$item;
	}
}
foreach ($final as $key => $val){
	$somePropValue = $propertyCollection->getItemByOrderPropertyId($key);
	$somePropValue->setValue($val);
}
/*print_r($_POST);
die;*/

/*******************************/

$order->save();
$orderId = $order->GetId();
$arFields = array(
   "LID" => "s1",
   "PERSON_TYPE_ID" => $PTID,
   "PAYED" => "N",
   "CANCELED" => "N",
   "STATUS_ID" => "N",
   "CURRENCY" => "RUB",
   "USER_ID" => $UID,
   "ALLOW_DELIVERY"=>"Y",
   "PRICE_DELIVERY" => $sumost,
   "USER_DESCRIPTION" => $comment

);
CSaleOrder::Update($orderId, $arFields);
$insZAK = "INSERT INTO `custom_order_sum` (`ID`, `ORDER_ID`, `SUM`, `CUR`) VALUES (NULL, '".$orderId."', '".$SUMZAK."', '".$CURZAK ."');";
$DB->Query($insZAK, false, $err_mess.__LINE__);
echo $orderId;
//print_r($_POST);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>