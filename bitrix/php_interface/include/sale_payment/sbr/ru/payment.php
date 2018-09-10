<?
global $MESS;

$MESS["SBR_DTITLE"]    = "Сбербанк эквайринг";
$MESS["SBR_DDESCR"]    = "Интернет эквайринг Сбербанк";

$MESS["SBR_MODE"]   = "Режим работы";
$MESS["SBR_MODE_DESCR"]   = "Для тестирования работы выберите режим Тестовый";
$MESS["SBR_MODE_TEST"]   = "Тестовый";
$MESS["SBR_MODE_WORK"]   = "Рабочий";

$MESS["SBR_PAYMODE"]   = "Режим проведения оплаты";
$MESS["SBR_PAYMODE_DESCR"]   = "Шлюз сбербанка поддерживает два режима оплаты. Подробнее смотрите в документации.";
$MESS["SBR_PAYMODE_TYPE1"]   = "Одностадийный платеж";
$MESS["SBR_PAYMODE_TYPE2"]   = "Двустадийный платеж";

$MESS["SBRT_USER"]			= "Тестовый логин";
$MESS["SBRT_USER_DESCR"]		= " ";
$MESS["SBRT_PASS"]			= "Тестовый пароль";
$MESS["SBRT_PASS_DESCR"]		= " ";
$MESS["SBRT_URL"]			= "Теcтовый URL";
$MESS["SBRT_URL_DESCR"]			= "В тестовом режиме Сбербанк не возвращает id заказа, из за этого платеж не пройдет. Для отладки укажите боевой сервер(минимальная оплата 1 копейка)"; 

$MESS["SBR_USER"]			= "Логин";
$MESS["SBR_USER_DESCR"]			= "Выдается при заключении договора эквайрига.";
$MESS["SBR_PASS"]			= "Пароль";
$MESS["SBR_PASS_DESCR"]			= "Выдается при заключении договора эквайрига. Обязательно смените перед началом работы!";
$MESS["SBR_URL"]			= "URL";
$MESS["SBR_URL_DESCR"]			= " ";

$MESS["SBR_CURRENCY"]			= "Номер валюты";
$MESS["SBR_CURRENCY_DESCR"]		= "643 - это рубли";

$MESS["SBR_RETURN_URL"]       = "URL возврата после оплаты";
$MESS["SBR_RETURN_URL_DESCR"] = "Страница должна содержать компонент <a href=\"http://dev.1c-bitrix.ru/user_help/store/sale/components_2/order/sale_order_payment_receive.php\" target=\"_blank\">sale.order.payment.receive</a>";

$MESS["SBR_ORDER_ID"] 	    = "ID заказа";
	
$MESS["SBR_LANGUAGE"]       = "Язык";
$MESS["SBR_LANGUAGE_DESCR"] = "ru/en...";

$MESS["IS_TEST"]		= "Тестовый режим(отображение дополнительной информации)";
$MESS["IS_TEST_DESCR"]		= "Если пустое значение - магазин будет работать в обычном режиме";

//result
$MESS["SBR_ERROR_PAY1"]				= "Ошибка оплаты";
$MESS["SBR_ERROR_PAY1_DESCRIPTION"]		= "Платеж не выполнен";
$MESS["SBR_ERROR_PAY2"]				= "Ошибка оплаты";
$MESS["SBR_ERROR_PAY2_DESCRIPTION"]		= "Не найден заказ";

$MESS["SBR_OK_PAY"]			= "Оплата произведена успешно";
$MESS["SBR_OK_PAY_DESCRIPTION"] 	= "Платеж прошел успешно. Ваш заказ переведен в статус оплачен.";

$MESS["SBR_PAYED"]			= "Даный заказ уже оплачен";
$MESS["SBR_PAYED_DESCRIPTION"]		= "Повторная оплата заказа не возможна. Повторите заказ.";

$MESS["SBR_ERROR_PAY3"]			= "Ошибка оплаты";

$MESS["SBRT_URL_TO_PAY"]			= "Перейти к оплате";
$MESS["SBRT_URL_TO_SB"]			= "На сайт сбербанка";

$MESS["SHOULD_PAY"] = "Сумма заказа";
$MESS["SHOULD_PAY_DESCR"] = "Сумма к оплате";

$MESS["USER_DESCRIPTION"]         = "Комментарий к заказу";
$MESS["USER_DESCRIPTION_DESCR"]   = "Комментарий к заказу";

$MESS["SBR_EXPIRATION_DAY"]         = "Время жизни заказа в днях";
$MESS["SBR_EXPIRATION_DAY_DESCR"]   = "Количество суток, в течение которых покупатель может оплатить заказ";

$MESS["SBR_ACCEPT_STATUS"]         = "Код статуса подтвежденного заказа";
$MESS["SBR_ACCEPT_STATUS_DESCR"]   = "Укажите символьный код статуса заказа, после установки которого пользователь сможет оплатить заказ. По умолчанию N - принят.";
$MESS["SBR_NOTACCEPTED_STATUS"]         = "Ваш заказ обрабатывается. Дождитесь подтверждения заказа менеджером, после этого Вы сможете оплатить заказ.";

$MESS["SBR_CONNECT_TYPE"]   = "Способ подключения к шлюзу";
$MESS["SBR_CONNECT_TYPE_DESCR"]   = "Используйте в зависимости от настроек хостинга сайта. Подробнее в инструкции по подключению.";
$MESS["SBR_CONNECT_TYPE_FGC"]   = "file_get_contents";
$MESS["SBR_CONNECT_TYPE_CURL"]   = "cURL";

$MESS["SBR_ERROR"]   = "При оплате возникла ошибка";

$MESS["SBR_GOTOPAY"]   = "Перейти к оплате";
$MESS["SBR_ORDER_CANCELED"]   = "Заказ отменен по причине: ";

?>
