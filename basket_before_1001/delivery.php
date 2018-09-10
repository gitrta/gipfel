<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$c = explode(',',$_GET['city']);
$city = trim($c[0]);

$parameters['filter']['PHRASE'] = $city;
use Bitrix\Sale\Location;
use Bitrix\Sale\Location\Admin\LocationHelper;
$result = Location\Search\Finder::find($parameters, array('FALLBACK_TO_NOINDEX_ON_NOTFOUND' => true, 'USE_INDEX' => true, 'USE_ORM' => true));
while($item = $result->fetch())
		{
			$ID = $item['ID'];
		}

$Z = CSaleLocation::GetLocationZIP($ID)->Fetch();
$ZIP = $Z['ZIP'];
$arResult["DELIVERY"] = Array();
$arResult["DELIVERY_LOCATION"] = $ID;
$arResult["ORDER_PRICE"] = $_GET['price'];
$arResult["DELIVERY_LOCATION_ZIP"] = $ZIP;
//$arResult["BASE_LANG_CURRENCY"] = "RUB";
//print_r($ID);
//print_r($city);
$FINALDESTINATIONS =array();
$SDEK_ID = file_get_contents('http://api.cdek.ru/city/getListByTerm/jsonp.php?q='.$city);
$city_SDEK_ID = json_decode($SDEK_ID)->geonames;
$SCID = $city_SDEK_ID[0]->id;
$ctk=0;
    global $DB;
	$res2 = $DB->Query("SELECT ID  FROM `b_sale_delivery_srv` WHERE `PARENT_ID` = 28", false, $err_mess.__LINE__);
	$add = array();
	while($r = $res2->Fetch()){
		array_push($add,$r);
	}
	
	$SD_CODES=array();
	$SP2 = array();
	
	foreach($add as $SDONE){	
		$arDeliv = \Bitrix\Sale\Delivery\Services\Manager::getById($SDONE['ID']);
		if ($arDeliv)
		{
		$SD_CODES[$arDeliv['CONFIG']['MAIN']['PROFILE_TYPE']]=$arDeliv;
		array_push($SP2,$arDeliv['CONFIG']['MAIN']['PROFILE_TYPE']);
		}
	}

if($SCID){
		include_once("CalculatePriceDeliveryCdek.php");
	foreach ($SD_CODES as $key=>$it):
	try {

	//создаём экземпляр объекта CalculatePriceDeliveryCdek
	$calc = new CalculatePriceDeliveryCdek();
	
    //Авторизация. Для получения логина/пароля (в т.ч. тестового) обратитесь к разработчикам СДЭК -->
    $calc->setAuth('e277dc556e3a88f8e99aa1014c48ce59', '14326bcc08d6707f909734dbdbb443ad');
	
	//устанавливаем город-отправитель
	$calc->setSenderCityId(44);
	//устанавливаем город-получатель
	$calc->setReceiverCityId($SCID);
	//устанавливаем дату планируемой отправки
	$calc->setDateExecute(date('Y-m-d'));
	
	//задаём список тарифов с приоритетами
   
    $calc->addTariffPriority($key); // Рассчитать для всех
	
	//устанавливаем тариф по-умолчанию
	$calc->setTariffId($key);
		
	//устанавливаем режим доставки
	//$calc->setModeDeliveryId(3);
	//добавляем места в отправление
	$calc->addGoodsItemBySize(0.5, 20, 30, 20);
	//$calc->addGoodsItemByVolume($_REQUEST['weight2'], $_REQUEST['volume2']);
	
	if ($calc->calculate() === true) {$ctk++;
		
		$res = $calc->getResult();
		$FINALDESTINATIONS[$key]=$res['result'];
		$FINALDESTINATIONS[$key][]=$it;
		
		
		/*echo 'Цена доставки: ' . $res['result']['price'] . 'руб.<br />';
		echo 'Срок доставки: ' . $res['result']['deliveryPeriodMin'] . '-' . 
								 $res['result']['deliveryPeriodMax'] . ' дн.<br />';
		echo 'Планируемая дата доставки: c ' . $res['result']['deliveryDateMin'] . ' по ' . $res['result']['deliveryDateMax'] . '.<br />';
		echo 'id тарифа, по которому произведён расчёт: ' . $res['result']['tariffId'] . '.<br />';
        if(array_key_exists('cashOnDelivery', $res['result'])) {
            echo 'Ограничение оплаты наличными, от (руб): ' . $res['result']['cashOnDelivery'] . '.<br />';
        }*/
	} else {
		/*$err = $calc->getError();
		if( isset($err['error']) && !empty($err) ) {
			//var_dump($err);
			foreach($err['error'] as $e) {
				echo 'Код ошибки: ' . $e['code'] . '.<br />';
				echo 'Текст ошибки: ' . $e['text'] . '.<br />';
			}
		}*/
	}
    
    //раскомментируйте, чтобы просмотреть исходный ответ сервера
    // var_dump($calc->getResult());
    // var_dump($calc->getError());

} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage() . "<br />";
}

endforeach;

}
	//print_r($FINALDESTINATIONS);

//стоимость товаров в корзине

$arID = array();

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
     array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS")
             );
while ($arItems = $dbBasketItems->Fetch())
{
     if ('' != $arItems['PRODUCT_PROVIDER_CLASS'] || '' != $arItems["CALLBACK_FUNC"])
     {
          CSaleBasket::UpdatePrice($arItems["ID"],
                                 $arItems["CALLBACK_FUNC"],
                                 $arItems["MODULE"],
                                 $arItems["PRODUCT_ID"],
                                 $arItems["QUANTITY"],
                                 "N",
                                 $arItems["PRODUCT_PROVIDER_CLASS"]
                                 );
          $arID[] = $arItems["ID"];
     }
}
if (!empty($arID))
     {
     $dbBasketItems = CSaleBasket::GetList(
     array(
          "NAME" => "ASC",
          "ID" => "ASC"
          ),
     array(
          "ID" => $arID,
        "ORDER_ID" => "NULL"
          ),
        false,
        false,
        array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE", "WEIGHT", "PRODUCT_PROVIDER_CLASS", "NAME")
                );
while ($arItems = $dbBasketItems->Fetch())
{	
if ($arItems['CAN_BUY']=='Y') $arBasketItems[] = $arItems['PRICE']*$arItems['QUANTITY'];
}
}

$priceof = array_sum($arBasketItems);
//print_r($priceof);


if (IntVal($arResult["DELIVERY_LOCATION"]) > 0)
		{
			// if your custom services needs something else, ex. cart content, you may put it here or get it from your services using API
			$arFilter = array(
				"COMPABILITY" => array(
					"WEIGHT" => 0,
					"PRICE" => $arResult["ORDER_PRICE"],
					"LOCATION_FROM" => COption::GetOptionString('sale', 'location', false, SITE_ID),
					"LOCATION_TO" => $arResult["DELIVERY_LOCATION"],
					"LOCATION_ZIP" => $arResult["DELIVERY_LOCATION_ZIP"],
				)
			);

			$rsDeliveryServicesList = CSaleDeliveryHandler::GetList(array("SORT" => "ASC"), $arFilter);
			$arDeliveryServicesList = array();
			while ($arDeliveryService = $rsDeliveryServicesList->Fetch())
			{
				$arDeliveryServicesList[] = $arDeliveryService;
			}

			//$numDelivery = count($arDeliveryServicesList);

			$curOneDelivery = false;

			$numDelivery = 0;
			foreach ($arDeliveryServicesList as $key => $arDelivery)
			{
				if (!empty($arDelivery['PROFILES']) && is_array($arDelivery['PROFILES']))
				{
					foreach ($arDelivery['PROFILES'] as $pkey => $arProfile)
					{
						if ($arProfile['ACTIVE'] != 'Y')
						{
							unset($arDeliveryServicesList[$key]['PROFILES'][$pkey]);
						}
					}
				}

				$cnt = count($arDeliveryServicesList[$key]["PROFILES"]);
				if ($cnt <= 0)
					unset($arDeliveryServicesList[$key]);
				else
				{
					$numDelivery += $cnt;
					if($cnt == 1 && empty($curOneDelivery))
					{
						foreach ($arDeliveryServicesList[$key]["PROFILES"] as $pkey => $arProfile)
							$curOneDelivery = array($arDeliveryServicesList[$key]['SID'], $pkey);
					}
				}
			}

			$dbDelivery = CSaleDelivery::GetList(
					array(),
					array(
							"LID" => SITE_ID,
							"+<=WEIGHT_FROM" => 0,
							"+>=WEIGHT_TO" => 0,
							"+<=ORDER_PRICE_FROM" => $arResult["ORDER_PRICE"],
							"+>=ORDER_PRICE_TO" => $arResult["ORDER_PRICE"],
							"ACTIVE" => "Y",
							"LOCATION" => $arResult["DELIVERY_LOCATION"],
						)
				);
			while ($arDelivery = $dbDelivery->Fetch())
			{
				$arDeliveryDescription = CSaleDelivery::GetByID($arDelivery["ID"]);
				$arDelivery["DESCRIPTION"] = $arDeliveryDescription["DESCRIPTION"];

				$numDelivery++;
				if ($numDelivery >= 2)
					break;

				if (!is_array($curOneDelivery) || count($curOneDelivery) <= 0 || $curOneDelivery <= 0)
				{
					$curOneDelivery = $arDelivery["ID"];
				}
			}

			if ($numDelivery < 2)
			{
				$arResult["SKIP_THIRD_STEP"] = "Y";
				$arResult["CurrentStep"] = 4;
				$arResult["DELIVERY_ID"] = $curOneDelivery;
			}
		}
		
/*********************************************************************/

		$deliv = $arResult["DELIVERY_ID"];
		if(is_array($arResult["DELIVERY_ID"]))
			$deliv = $arResult["DELIVERY_ID"][0].":".$arResult["DELIVERY_ID"][1];

		$dbDelivery = CSaleDelivery::GetList(
					array("SORT"=>"ASC", "NAME"=>"ASC"),
					array(
							"LID" => SITE_ID,
							"+<=WEIGHT_FROM" => 0,
							"+>=WEIGHT_TO" => 0,
							"+<=ORDER_PRICE_FROM" => $arResult["ORDER_PRICE"],
							"+>=ORDER_PRICE_TO" => $arResult["ORDER_PRICE"],
							"ACTIVE" => "Y",
							"LOCATION" => $arResult["DELIVERY_LOCATION"]
						)
			);

		$bFirst = True;
		while ($arDelivery = $dbDelivery->GetNext())
		{
			$arDelivery["FIELD_NAME"] = "DELIVERY_ID";
			if (IntVal($arResult["DELIVERY_ID"]) == IntVal($arDelivery["ID"])
				|| IntVal($arResult["DELIVERY_ID"]) <= 0 && $bFirst)
				$arDelivery["CHECKED"] = "Y";
			if (IntVal($arDelivery["PERIOD_FROM"]) > 0 || IntVal($arDelivery["PERIOD_TO"]) > 0)
			{
				$arDelivery["PERIOD_TEXT"] = GetMessage("SALE_DELIV_PERIOD");
				if (IntVal($arDelivery["PERIOD_FROM"]) > 0)
					$arDelivery["PERIOD_TEXT"] .= " ".GetMessage("SALE_FROM")." ".IntVal($arDelivery["PERIOD_FROM"]);
				if (IntVal($arDelivery["PERIOD_TO"]) > 0)
					$arDelivery["PERIOD_TEXT"] .= " ".GetMessage("SALE_TO")." ".IntVal($arDelivery["PERIOD_TO"]);
				if ($arDelivery["PERIOD_TYPE"] == "H")
					$arDelivery["PERIOD_TEXT"] .= " ".GetMessage("SALE_PER_HOUR")." ";
				elseif ($arDelivery["PERIOD_TYPE"]=="M")
					$arDelivery["PERIOD_TEXT"] .= " ".GetMessage("SALE_PER_MONTH")." ";
				else
					$arDelivery["PERIOD_TEXT"] .= " ".GetMessage("SALE_PER_DAY")." ";
			}
			$arDelivery["PRICE_FORMATED"] = SaleFormatCurrency($arDelivery["PRICE"], $arDelivery["CURRENCY"]);
			$arResult["DELIVERY"][] = $arDelivery;
			$bFirst = false;
		}

		if (is_array($arDeliveryServicesList))
		{
			$bFirst = true;
			foreach ($arDeliveryServicesList as $arDeliveryInfo)
			{
				$delivery_id = $arDeliveryInfo["SID"];

				if (!is_array($arDeliveryInfo) || !is_array($arDeliveryInfo["PROFILES"])) continue;

				foreach ($arDeliveryInfo["PROFILES"] as $profile_id => $arDeliveryProfile)
				{
					$arProfile = array(
						"SID" => $profile_id,
						"TITLE" => $arDeliveryProfile["TITLE"],
						"DESCRIPTION" => $arDeliveryProfile["DESCRIPTION"],
						//"CHECKED" => $bFirst ? "Y" : "N",
						"FIELD_NAME" => "DELIVERY_ID",
					);

					if ($arResult['DELIVERY_ID'])
						if(strpos($deliv, ":") !== false &&
							$deliv == $delivery_id.":".$profile_id
							|| empty($arResult["DELIVERY_ID"]) && $bFirst
						)
						$arProfile["CHECKED"] = "Y";

					if (!is_array($arResult["DELIVERY"][$delivery_id]))
					{
						$arResult["DELIVERY"][$delivery_id] = array(
							"SID" => $delivery_id,
							"TITLE" => $arDeliveryInfo["NAME"],
							"DESCRIPTION" => $arDeliveryInfo["DESCRIPTION"],
							"PROFILES" => array(),
						);
					}

					$arResult["DELIVERY"][$delivery_id]["PROFILES"][$profile_id] = $arProfile;

					$bFirst = false;
				}
			}
		}

		if(CModule::IncludeModule("statistic"))
		{
			$event1 = "eStore";
			$event2 = "Step4_3";
			$event3 = "";

			foreach($arProductsInBasket as $ar_prod)
			{
				$event3 .= $ar_prod["PRODUCT_ID"].", ";
			}
			$e = $event1."/".$event2."/".$event3;

			if(!is_array($_SESSION["ORDER_EVENTS"]) || (is_array($_SESSION["ORDER_EVENTS"]) && !in_array($e, $_SESSION["ORDER_EVENTS"]))) // check for event in session
			{
					CStatistic::Set_Event($event1, $event2, $event3);
					$_SESSION["ORDER_EVENTS"][] = $e;
			}
		}
		?>

			<? use Bitrix\Sale\Delivery; //print_r($arResult["DELIVERY"]);
				foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery)
				{//print_r($arDelivery);
					if ($delivery_id !== 0 && intval($delivery_id) <= 0):

						foreach ($arDelivery["PROFILES"] as $profile_id => $arProfile)
						{
$arDeliveryServiceAll = Delivery\Services\Manager::getActiveList();

if (!empty($arDeliveryServiceAll)) {
    reset($arDeliveryServiceAll);
    foreach($arDeliveryServiceAll as $AOL){
	    if($AOL['CODE']==$delivery_id.":".$profile_id){
		    $DID = $AOL['ID'];
		    //print_r($AOL);
		    }
		 }
	}
	if ($DID!=='66'):
							?>
					
						<div del_id = "<?=$DID;?>" <?=$arProfile["CHECKED"] == "Y" ? "class = \"act\"" : "";?>>
						<input required type="radio" id="ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>" name="<?=$arProfile["FIELD_NAME"]?>" value="<?=$delivery_id.":".$profile_id;?>" <?=$arProfile["CHECKED"] == "Y" ? "checked=\"checked\"" : "";?> />
							<label for="ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>">
							<span><?=$arDelivery["TITLE"] ?></span>
								<small><b><?=$arProfile["TITLE"]?></b><?if (strlen($arProfile["DESCRIPTION"]) > 0):?>
								<?//=nl2br($arProfile["DESCRIPTION"])?><?endif;?></small>
							</label>
							<span class="toright">
						<?
							$APPLICATION->IncludeComponent('bitrix:sale.ajax.delivery.calculator', '', array(
								"NO_AJAX" => 'Y',
								"DELIVERY" => $delivery_id,
								"PROFILE" => $profile_id,
								"ORDER_WEIGHT" => $arResult["ORDER_WEIGHT"],
								"ORDER_PRICE" => $arResult["ORDER_PRICE"],
								"LOCATION_TO" => $arResult["DELIVERY_LOCATION"],
								"LOCATION_ZIP" => $arResult['DELIVERY_LOCATION_ZIP'],
								"CURRENCY" => $arResult["BASE_LANG_CURRENCY"],
								"PRICE" => $priceof,
								"ITEMS" => $arResult["BASKET_ITEMS"],
							));
							
							//print_r();
						?>
						<?if ($arParams["SHOW_AJAX_DELIVERY_LINK"] == 'N'):?>
						<script type="text/javascript">deliveryCalcProceed({STEP:1,DELIVERY:'<?=CUtil::JSEscape($delivery_id)?>',PROFILE:'<?=CUtil::JSEscape($profile_id)?>',WEIGHT:'<?=CUtil::JSEscape($arResult["ORDER_WEIGHT"])?>',PRICE:'<?=CUtil::JSEscape($arResult["ORDER_PRICE"])?>',LOCATION:'<?=intval($arResult["DELIVERY_LOCATION"])?>',CURRENCY:'<?=CUtil::JSEscape($arResult["BASE_LANG_CURRENCY"])?>'})</script>
						<?endif;?>
						</span>
						</div>
						
							<?
endif;
						} // endforeach
					else:
?>
					
						<div del_id = "<?= $arDelivery["ID"] ?>" <?=$arDelivery["CHECKED"] == "Y" ? "class = \"act\"" : "";?>>
							<input required type="radio" id="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>" name="<?=$arDelivery["FIELD_NAME"]?>" value="<?= $arDelivery["ID"] ?>"<?if ($arDelivery["CHECKED"]=="Y") echo " checked";?>>
					
							<label for="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>">
							<span><?= $arDelivery["NAME"] ?></span>
							</label>
							<span class="toright">
							<b><? echo FormatCurrency(CCurrencyRates::ConvertCurrency($arDelivery['PRICE'], "RUB", $GLOBALS["MCUR"]),$GLOBALS["MCUR"]); ?></b>
							<text><?=$arDelivery["PERIOD_TEXT"]?> день.</text>
							</span>
							
							<?
								//print_r($arDelivery);
							/*if (strlen($arDelivery["PERIOD_TEXT"])>0)
							{
								echo $arDelivery["PERIOD_TEXT"];
								?><?
							}
							?>
							<?=GetMessage("SALE_DELIV_PRICE");?> <?=$arDelivery["PRICE_FORMATED"]?>
							<?
							if (strlen($arDelivery["DESCRIPTION"])>0)
							{
								?>
								<?=$arDelivery["DESCRIPTION"]?>
								<?
							}*/
							?>
							
						</div>
					
					<?
					endif;

				} // endforeach
			//endif;
			
foreach($FINALDESTINATIONS as $key=>$item){ //echo $item['price'];
			?>
		<div del_id="<?=$item[0]['ID'];?>">
	<input required="" type="radio" id="ID_DELIVERY_<?=$item[0]['ID'];?>" name="DELIVERY_ID" value="<?=$item[0]['ID'];?>">
		<label for="ID_DELIVERY_<?=$item[0]['ID'];?>">
			<span>СДЭК</span>
			<small><b><?=$item[0]['NAME'];?></b></small>
		</label>
		<span class="toright">
							<b><? echo FormatCurrency(CCurrencyRates::ConvertCurrency($item['price'], "RUB", $GLOBALS["MCUR"]),$GLOBALS["MCUR"]); ?></b>
							<text>Срок доставки: <?
if ($item['deliveryPeriodMin']==$item['deliveryPeriodMax']) echo $item['deliveryPeriodMax'].' дн.'; else echo $item['deliveryPeriodMin'] . '-' . $item['deliveryPeriodMax'] . ' дн.';
?>
</text>
		</span>
</div>
<?}?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>