<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?
include(GetLangFileName(dirname(__FILE__) . "/", "/payment.php"));

$arSbr = Array();

$arSbr["user"] = CSalePaySystemAction::GetParamValue("SBR_USER");
$arSbr["pass"] = CSalePaySystemAction::GetParamValue("SBR_PASS");

if (CSalePaySystemAction::GetParamValue("SBR_MODE") == "TEST") {
    $arSbr["url"] = "https://3dsec.sberbank.ru/payment";
} else {
    $arSbr["url"] = "https://securepayments.sberbank.ru/payment";
}

$arSbr["url_st"] = $arSbr["url"] . "/rest/getOrderStatus.do";

if (CSalePaySystemAction::GetParamValue("SBR_PAYMODE") == "ONE") {
    $arSbr["url"] = $arSbr["url"] . "/rest/register.do";
} else {
    $arSbr["url"] = $arSbr["url"] . "/rest/registerPreAuth.do";
}

$arSbr["currency"] = CSalePaySystemAction::GetParamValue("SBR_CURRENCY");
$arSbr["lang"] = CSalePaySystemAction::GetParamValue("SBR_LANGUAGE");
$arSbr["returnUrl"] = CSalePaySystemAction::GetParamValue("SBR_RETURN_URL");
$arSbr['ID'] = CSalePaySystemAction::GetParamValue("ORDER_ID");
$arSbr['status'] = CSalePaySystemAction::GetParamValue("SBR_ACCEPT_STATUS");

$arSbr['expday'] = CSalePaySystemAction::GetParamValue("SBR_EXPIRATION_DAY");

$arParams['shouldPay'] = (strlen(CSalePaySystemAction::GetParamValue("SHOULD_PAY")) > 0) ? CSalePaySystemAction::GetParamValue("SHOULD_PAY") : $GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["SHOULD_PAY"];
$arParams['userDescription'] = (strlen(CSalePaySystemAction::GetParamValue("USER_DESCRIPTION")) > 0) ? CSalePaySystemAction::GetParamValue("ORDER_ID") : $GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["USER_DESCRIPTION"];

$order = CSaleOrder::GetByID($arSbr['ID']);

$date = strtotime("now +".$arSbr['expday']." days");
$expDate = date('Y-m-d', $date).'T'.date('H:i:s', $date);

if ($order['STATUS_ID'] != $arSbr['status']) {

    echo GetMessage("SBR_NOTACCEPTED_STATUS");

} else {

	if ($arSbr['expday']>0){
		$params = Array(
			'amount' => $arParams['shouldPay'] * 100,
			'currency' => $arSbr["currency"],
			'orderNumber' => $arSbr['ID'],
			'orderId' => $arSbr['ID'],
			'password' => $arSbr['pass'],
			'userName' => $arSbr['user'],
			'returnUrl' => $arSbr['returnUrl'],
			'description' => $arParams['userDescription'],
			'expirationDate' => $expDate
		);
	}
	else {
		$params = Array(
			'amount' => $arParams['shouldPay'] * 100,
			'currency' => $arSbr["currency"],
			'orderNumber' => $arSbr['ID'],
			'orderId' => $arSbr['ID'],
			'password' => $arSbr['pass'],
			'userName' => $arSbr['user'],
			'returnUrl' => $arSbr['returnUrl'],
			'description' => $arParams['userDescription']
		);
	}
    $url = $arSbr['url'];
    if (CSalePaySystemAction::GetParamValue("SBR_CONNECT_TYPE") == "file_get_contents") {
        $opts = Array(
            'http' => Array(
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded",
                'content' => http_build_query($params),
                'timeout' => 60
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
    } else {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla / 5.0 (Windows NT 6.3; Win64; x64) AppleWebKit / 537.36 (KHTML, like Gecko) Chrome / 39.0.2171.95 Safari / 537.36");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_SSLVERSION, 6);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        $result = curl_exec($curl);
        curl_close($curl);
    }

	if (!$result){
		echo 'Sberbank service unavailiable';
	} else {

		$arSbrfResult = (array)json_decode($result);


		if (!isset($arSbrfResult["errorCode"])) {

			$arFields = array(
			  "COMMENTS" => $arSbrfResult['formUrl'],
			  "ADDITIONAL_INFO" => $arSbrfResult['orderId']
		   );
	
			CSaleOrder::Update($arSbr['ID'], $arFields);
	
			LocalRedirect($arSbrfResult['formUrl'], true);
	
		} else if($arSbrfResult["errorCode"] == 1){
	
			$arOrder = CSaleOrder::GetByID($arSbr['ID']);
	
			$params = array(
			  'orderId'     => $arOrder["ADDITIONAL_INFO"],
			  'password'    => $arSbr['pass'],
			  'userName'    => $arSbr['user']
			);
	
			$opts = array(
			  'http' => array(
				  'method'   => 'POST',
				  'header'   => "Content-type: application/x-www-form-urlencoded",
				  'content'   => http_build_query($params),
				  'timeout'   => 60
			  )
			);
	
			$url = $arSbr['url_st'];
			if (CSalePaySystemAction::GetParamValue("SBR_CONNECT_TYPE") == "file_get_contents") {
				$opts = Array(
					'http' => Array(
						'method' => 'POST',
						'header' => "Content-type: application/x-www-form-urlencoded",
						'content' => http_build_query($params),
						'timeout' => 60
					)
				);
				$context = stream_context_create($opts);
				$result = file_get_contents($url, false, $context);
			} else {
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla / 5.0 (Windows NT 6.3; Win64; x64) AppleWebKit / 537.36 (KHTML, like Gecko) Chrome / 39.0.2171.95 Safari / 537.36");
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
				$result = curl_exec($curl);
				curl_close($curl);
			}
	
			$arSbrfResult2 = (array)json_decode($result);
	
			if($arSbrfResult2['ErrorCode'] == 0 ){?>
				<a href="<?=$arOrder['COMMENTS']?>"><?= GetMessage("SBR_GOTOPAY") ?></a>
	
			<?}else{
				CSaleOrder::Update($arSbr['ID'], Array(
						"CANCELED"		=> "Y"
					)
				);
				echo GetMessage("SBR_ORDER_CANCELED") . $arSbrfResult2['ErrorMessage'];
			}
		
		}
		else
		{
	
			echo GetMessage("SBR_ERROR") . ": " . $arSbrfResult["errorMessage"];
		}
	}
}

?>
