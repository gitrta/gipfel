<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$arID = array();

CBitrixComponent::includeComponentClass('bitrix:sale.basket.basket');
$basket = new CBitrixBasketComponent();
$basket->onIncludeComponentLang();
$basket->columns = $arColumns;
$basket->offersProps = $strOffersProps;
$basket->quantityFloat = (isset($_POST['quantity_float']) && $_POST['quantity_float'] == 'Y') ? 'Y' : 'N';
$basket->countDiscount4AllQuantity = (isset($_POST['count_discount_4_all_quantity']) && $_POST['count_discount_4_all_quantity'] == 'Y') ? 'Y' : 'N';
$basket->priceVatShowValue = (isset($_POST['price_vat_show_value']) && $_POST['price_vat_show_value'] == 'Y') ? 'Y' : 'N';
$basket->hideCoupon = (isset($_POST['hide_coupon']) && $_POST['hide_coupon'] == 'Y') ? 'Y' : 'N';
$basket->usePrepayment = (isset($_POST['use_prepayment']) && $_POST['use_prepayment'] == 'Y') ? 'Y' : 'N';
$res = $basket->recalculateBasket($_POST);
foreach ($res as $key => $value)
{
   $arRes[$key] = $value;
}
$arBasketItems = array();
$arRes['BASKET_DATA'] = $basket->getBasketItems();
foreach ($arRes['BASKET_DATA']['ITEMS']['AnDelCanBuy'] as $arItems){
	$arBasketItems[] = $arItems['PRICE']*$arItems['QUANTITY'];
}


$flg = 0;
//print_r($DEP);

if ($GLOBALS["MCUR"]=="KZT"):
$DEP = preg_replace('/[^0-9,]/', '', $_GET['DEL_PRICE']);
$DEP = round($DEP);

////////////////////

if(CCurrencyRates::ConvertCurrency(array_sum($arBasketItems), "RUB", $GLOBALS["MCUR"])>1001){
$c1=array('Москва','Апрелевка','Балашиха','Бронницы','Верея','Видное','Волоколамск','Воскресенск','Высоковск','Голицыно','Дедовск','Дзержинский','Дмитров','Долгопрудный','Домодедово','Дрезна','Дубна','Егорьевск','Жуковский','Зарайск','Звенигород','Ивантеевка','Истра','Кашира','Клин','Коломна','Королёв','Котельники','Красноармейск','Красногорск','Краснозаводск','Краснознаменск','Кубинка','Куровское','Ликино-Дулёво','Лобня','Лосино-Петровский','Луховицы','Лыткарино','Люберцы','Можайск','Мытищи','Наро-Фоминск','Ногинск','Одинцово','Озёры','Орехово-Зуево','Павловский Посад','Пересвет','Подольск','Протвино','Пушкино','Пущино','Раменское','Реутов','Рошаль','Руза','Сергиев Посад','Серпухов','Солнечногорск','Старая Купавна','Ступино','Талдом','Фрязино','Химки','Хотьково','Черноголовка','Чехов','Шатура','Щёлково','Электрогорск','Электросталь','Электроугли','Яхрома');

$c2=array('Санкт-Петербург','Бокситогорск','Волосово','Волхов','Всеволожск','Выборг','Высоцк','Гатчина','Ивангород','Каменногорск','Кингисепп','Кириши','Кировск','Коммунар','Лодейное Поле','Луга','Любань','Никольское','Новая Ладога','Отрадное','Пикалёво','Подпорожье','Приморск','Приозерск','Светогорск','Сертолово','Сланцы','Сосновый Бор','Сясьстрой','Тихвин','Тосно','Шлиссельбург');

$c3=array('Екатеринбург','Новосибирск');
	$cities = array_merge($c1,$c2,$c3);
	if (in_array($_GET['city'], $cities)) {
	    $DEP=0;
	    $flg = 1;
	}
}

/////////////////////

if ($_GET['DEL_PRICE']==0){
	$itog = array_sum($arBasketItems);
	//$itog = round(CCurrencyRates::ConvertCurrency($itog, "RUB", $GLOBALS["MCUR"]),2);
	$itog = FormatCurrency($itog,'KZT');
} else {
	$itog = array_sum($arBasketItems)+$DEP;
	//$itog = round(CCurrencyRates::ConvertCurrency($itog, "RUB", $GLOBALS["MCUR"]),2);
	$itog = FormatCurrency($itog,'KZT');
}

$price = FormatCurrency(array_sum($arBasketItems),'KZT');
else:
$DEP = preg_replace('/[^0-9,]/', '', $_GET['DEL_PRICE']);
$DEP = round(CCurrencyRates::ConvertCurrency($DEP, $GLOBALS["MCUR"], "RUB"));

////////////////////

if(CCurrencyRates::ConvertCurrency(array_sum($arBasketItems), "RUB", $GLOBALS["MCUR"])>1001){
$c1=array('Москва','Апрелевка','Балашиха','Бронницы','Верея','Видное','Волоколамск','Воскресенск','Высоковск','Голицыно','Дедовск','Дзержинский','Дмитров','Долгопрудный','Домодедово','Дрезна','Дубна','Егорьевск','Жуковский','Зарайск','Звенигород','Ивантеевка','Истра','Кашира','Клин','Коломна','Королёв','Котельники','Красноармейск','Красногорск','Краснозаводск','Краснознаменск','Кубинка','Куровское','Ликино-Дулёво','Лобня','Лосино-Петровский','Луховицы','Лыткарино','Люберцы','Можайск','Мытищи','Наро-Фоминск','Ногинск','Одинцово','Озёры','Орехово-Зуево','Павловский Посад','Пересвет','Подольск','Протвино','Пушкино','Пущино','Раменское','Реутов','Рошаль','Руза','Сергиев Посад','Серпухов','Солнечногорск','Старая Купавна','Ступино','Талдом','Фрязино','Химки','Хотьково','Черноголовка','Чехов','Шатура','Щёлково','Электрогорск','Электросталь','Электроугли','Яхрома');

$c2=array('Санкт-Петербург','Бокситогорск','Волосово','Волхов','Всеволожск','Выборг','Высоцк','Гатчина','Ивангород','Каменногорск','Кингисепп','Кириши','Кировск','Коммунар','Лодейное Поле','Луга','Любань','Никольское','Новая Ладога','Отрадное','Пикалёво','Подпорожье','Приморск','Приозерск','Светогорск','Сертолово','Сланцы','Сосновый Бор','Сясьстрой','Тихвин','Тосно','Шлиссельбург');

$c3=array('Екатеринбург','Новосибирск');
	$cities = array_merge($c1,$c2,$c3);
	if (in_array($_GET['city'], $cities)) {
	    $DEP=0;
	    $flg = 1;
	}
}

/////////////////////

if ($_GET['DEL_PRICE']==0){
	$itog = array_sum($arBasketItems);
	$itog = round(CCurrencyRates::ConvertCurrency($itog, "RUB", $GLOBALS["MCUR"]),2);
	$itog = FormatCurrency($itog,$GLOBALS["MCUR"]);
} else {
	$itog = array_sum($arBasketItems)+$DEP;
	$itog = round(CCurrencyRates::ConvertCurrency($itog, "RUB", $GLOBALS["MCUR"]),2);
	$itog = FormatCurrency($itog,$GLOBALS["MCUR"]);
}

$price = FormatCurrency(CCurrencyRates::ConvertCurrency(array_sum($arBasketItems), "RUB", $GLOBALS["MCUR"]),$GLOBALS["MCUR"]);
endif;

$dost = FormatCurrency(CCurrencyRates::ConvertCurrency($DEP, "RUB", $GLOBALS["MCUR"]),$GLOBALS["MCUR"]);

//////////

?>
<? if ($flg==1):?><span class = "flg" style="color: red;text-transform: uppercase;font-size: 16px;font-style: italic;text-align: center;display: block;margin-top: 8px;">Доставка для Вас бесплатна!</span><?endif;?>
<div id = "itcont">
	<div class = "vych">
		<div class = "frow">
			<text>Товаров на сумму: </text><span><?=$price;?></span>
			<text>Доставка: </text><span><?=$dost; ?></span>
		</div>
		
		<div class = "srow">
			<text>Итого к оплате:  </text><span><?=$itog; ?></span>
		</div>
	</div>
	<div class = "finalbutton">
	<input type = "hidden" value = "<?=$itog; ?>" name = "SUMITOG"><input type = "hidden" name = "CURITOG" value = "<?=$GLOBALS["MCUR"]; ?>">
	<input type = "submit" value = "Оформить заказ">
	</div>
</div>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>