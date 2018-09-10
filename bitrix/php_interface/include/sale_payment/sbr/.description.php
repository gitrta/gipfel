<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?
include(GetLangFileName(dirname(__FILE__) . "/", "/payment.php"));

$psTitle = GetMessage("SBR_DTITLE");
$psDescription = GetMessage("SBR_DDESCR");
$arPSCorrespondence = array(
    "SBR_MODE" => array(
        "NAME" => GetMessage("SBR_MODE"),
        "DESCR" => GetMessage("SBR_MODE_DESCR"),
        "TYPE" => "SELECT",
        "VALUE" => array(
            "TEST" => array(
                "NAME" => GetMessage("SBR_MODE_TEST"),
            ),
            "WORK" => array(
                "NAME" => GetMessage("SBR_MODE_WORK"),
            ),
        ),
    ),
    "SBR_PAYMODE" => array(
        "NAME" => GetMessage("SBR_PAYMODE"),
        "DESCR" => GetMessage("SBR_PAYMODE_DESCR"),
        "TYPE" => "SELECT",
        "VALUE" => array(
            "ONE" => array(
                "NAME" => GetMessage("SBR_PAYMODE_TYPE1"),
            ),
            "TWO" => array(
                "NAME" => GetMessage("SBR_PAYMODE_TYPE2"),
            ),
        ),
    ),
    "SBR_ACCEPT_STATUS" => array(
        "NAME" => GetMessage("SBR_ACCEPT_STATUS"),
        "DESCR" => GetMessage("SBR_ACCEPT_STATUS_DESCR"),
        "VALUE" => "N",
        "TYPE" => ""
    ),
	"SBR_EXPIRATION_DAY" => array(
        "NAME" => GetMessage("SBR_EXPIRATION_DAY"),
        "DESCR" => GetMessage("SBR_EXPIRATION_DAY_DESCR"),
        "VALUE" => "0",
        "TYPE" => "NUMBER"
    ),
    "SBR_USER" => array(
        "NAME" => GetMessage("SBR_USER"),
        "DESCR" => GetMessage("SBR_USER_DESCR"),
        "VALUE" => "",
        "TYPE" => ""
    ),

    "SBR_PASS" => array(
        "NAME" => GetMessage("SBR_PASS"),
        "DESCR" => GetMessage("SBR_PASS_DESCR"),
        "VALUE" => "",
        "TYPE" => ""
    ),
    "SBR_CURRENCY" => array(
        "NAME" => GetMessage("SBR_CURRENCY"),
        "DESCR" => GetMessage("SBR_CURRENCY_DESCR"),
        "VALUE" => "643",
        "TYPE" => ""
    ),
    "SBR_LANGUAGE" => array(
        "NAME" => GetMessage("SBR_LANGUAGE"),
        "DESCR" => GetMessage("SBR_LANGUAGE_DESCR"),
        "VALUE" => "ru",
        "TYPE" => ""
    ),
    "SBR_RETURN_URL" => array(
        "NAME" => GetMessage("SBR_RETURN_URL"),
        "DESCR" => GetMessage("SBR_RETURN_URL_DESCR"),
        "VALUE" => "http://site_url/payment_receive.php",
        "TYPE" => ""
    ),
    "ORDER_ID" => array(
        "NAME" => GetMessage("SBR_ORDER_ID"),
        "DESCR" => "",
        "VALUE" => "ID",
        "TYPE" => "ORDER"
    ),
    "SHOULD_PAY" => array(
        "NAME" => GetMessage("SHOULD_PAY"),
        "DESCR" => GetMessage("SHOULD_PAY_DESCR"),
        "VALUE" => "SHOULD_PAY",
        "TYPE" => "ORDER"
    ),
    "USER_DESCRIPTION" => array(
        "NAME" => GetMessage("USER_DESCRIPTION"),
        "DESCR" => GetMessage("USER_DESCRIPTION_DESCR"),
        "VALUE" => "USER_DESCRIPTION",
        "TYPE" => "ORDER"
    ),
    "SBR_CONNECT_TYPE" => array(
        "NAME" => GetMessage("SBR_CONNECT_TYPE"),
        "DESCR" => GetMessage("SBR_CONNECT_TYPE_DESCR"),
        "TYPE" => "SELECT",
        "VALUE" => array(
            "file_get_contents" => array(
                "NAME" => GetMessage("SBR_CONNECT_TYPE_FGC"),
            ),
            "cURL" => array(
                "NAME" => GetMessage("SBR_CONNECT_TYPE_CURL"),
            ),
        ),
    )
);
?>
