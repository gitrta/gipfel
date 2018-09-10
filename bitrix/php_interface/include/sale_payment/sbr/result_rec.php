<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
include(GetLangFileName(dirname(__FILE__) . "/", "/payment.php"));
// ok

if (isset($_REQUEST['orderId'])) {

	$arParam = array();

	if ($arParams["PAY_SYSTEM_ID_NEW"] != ''){
		$pms = CSalePaySystemAction::GetList(array(), array("PAY_SYSTEM_ID" =>$arParams["PAY_SYSTEM_ID_NEW"]),false,false,array("PARAMS"));
	} else {
		$pms = CSalePaySystemAction::GetList(array(), array("PERSON_TYPE_ID" => $arParams["PERSON_TYPE_ID"],"PAY_SYSTEM_ID" =>$arParams["PAY_SYSTEM_ID"]),false,false,array("PARAMS"));
	}

	while ($pm = $pms->GetNext()){
		$arParam = unserialize(htmlspecialchars_decode($pm["PARAMS"]));
	}

    if ($arParam["SBR_MODE"]['VALUE'] == "TEST") {
        $url = "https://3dsec.sberbank.ru/payment/rest/getOrderStatus.do";
    } else {
        $url = "https://securepayments.sberbank.ru/payment/rest/getOrderStatus.do";
    }

    $params = array(
        'orderId' => $_REQUEST["orderId"],
        'password' => $arParam['SBR_PASS']['VALUE'],
        'userName' => $arParam['SBR_USER']['VALUE']
    );

    $opts = array(
        'http' => array(
            'method' => 'POST',
            'header' => "Content-type: application/x-www-form-urlencoded",
            'content' => http_build_query($params),
            'timeout' => 60
        )
    );	

    if ($arParam["SBR_CONNECT_TYPE"]['VALUE'] == "file_get_contents") {
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

    $arSbrfResult = (array)json_decode($result);

    if (!isset($arSbrfResult["errorCode"])) {
        $arOrder = CSaleOrder::GetByID($arSbrfResult['OrderNumber']);
        if ($arOrder['PAYED'] == "N") {
            $arFields = array(
                "PAYED" => "Y",
                "STATUS_ID" => "P",
                "PS_STATUS" => "Y",
                "DATE_PAYED" => Date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG))),
                "USER_ID" => $arOrder["USER_ID"],
                "EMP_PAYED_ID" => $USER->GetID(),
                "COMMENTS" => $result,
            );

            CSaleOrder::PayOrder($arSbrfResult['OrderNumber'], "Y");
            /*CSaleOrder::Update($arSbrfResult['OrderNumber'], $arFields);
            CSaleOrder::StatusOrder($arSbrfResult['OrderNumber'], "P");*/
            ?>


            <h1><?= GetMessage('SBR_OK_PAY') ?></h1>
            <p><?= GetMessage('SBR_OK_PAY_DESCRIPTION') ?></p>

            <?
        } else if ($arOrder['PAYED'] == "Y") { ?>
            <h1><?= GetMessage('SBR_PAYED') ?></h1>
            <p><?= GetMessage('SBR_PAYED_DESCRIPTION') ?></p>

            <?
        } else { ?>
            <h1><?= GetMessage('SBR_ERROR_PAY2') ?></h1>
            <p><?= GetMessage('SBR_ERROR_PAY2_DESCRIPTION') ?></p>
            <?
        }
    } else {
        ?>
        <h1><?= GetMessage('SBR_ERROR_PAY3') ?></h1>
        <? if ($arSbrfResult['errorCode'] == 0) {
            ?>
            <p><?= $arSbrfResult['actionCodeDescription'] ?></p>
            <?
        } else {
            ?>
            <p><?= $arSbrfResult['errorMessage'] ?></p>
            <?
        } ?>
        <?
    }

    if ($arParam["SBR_MODE"]['VALUE'] == "TEST") {
        ?>
        <h1>Test mode!</h1>
        <pre>
		  <? print_r($arSbr) ?>

          <? print_r($_REQUEST["orderId"]) ?>

          <? print_r($arSbrfResult) ?>

		</pre>
        <?
    }

} else {
    ?>
    <h1><?= GetMessage('SBR_ERROR_PAY1') ?></h1>
    <p><?= GetMessage('SBR_ERROR_PAY1_DESCRIPTION') ?></p>
<? } ?>
