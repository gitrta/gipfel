<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y")
{
	if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
	{
		if(strlen($arResult["REDIRECT_URL"]) > 0)
		{
			$APPLICATION->RestartBuffer();
			?>
			<script type="text/javascript">
				window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
			</script>
			<?
			die();
		}

	}
}
$stepForm = $_REQUEST['stepForm']>0?intval($_REQUEST['stepForm']):0;
$APPLICATION->SetAdditionalCSS($templateFolder."/style_cart.css");
$APPLICATION->SetAdditionalCSS($templateFolder."/style.css");

CJSCore::Init(array('fx', 'popup', 'window', 'ajax'));
?>

<a name="order_form"></a>

<div id="order_form_div" class="order-checkout">
<NOSCRIPT>
	<div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
</NOSCRIPT>

<?
if (!function_exists("getColumnName"))
{
	function getColumnName($arHeader)
	{
		return (strlen($arHeader["name"]) > 0) ? $arHeader["name"] : GetMessage("SALE_".$arHeader["id"]);
	}
}

if (!function_exists("cmpBySort"))
{
	function cmpBySort($array1, $array2)
	{
		if (!isset($array1["SORT"]) || !isset($array2["SORT"]))
			return -1;

		if ($array1["SORT"] > $array2["SORT"])
			return 1;

		if ($array1["SORT"] < $array2["SORT"])
			return -1;

		if ($array1["SORT"] == $array2["SORT"])
			return 0;
	}
}
?>

<div class="bx_order_make">
	<?
	if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
	{
		if(!empty($arResult["ERROR"]))
		{
			foreach($arResult["ERROR"] as $v)
				echo ShowError($v);
		}
		elseif(!empty($arResult["OK_MESSAGE"]))
		{
			foreach($arResult["OK_MESSAGE"] as $v)
				echo ShowNote($v);
		}

		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
	}
	else
	{
		if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
		{
			if(strlen($arResult["REDIRECT_URL"]) == 0)
			{
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
			}
		}
		else
		{
			?>
			<script type="text/javascript">
			function submitForm(val)
			{
				//if(val == 'Y') $("#ORDER_FORM").valid({errorLabelContainer: $("div.err")});
				if(val != 'Y')
					BX('confirmorder').value = 'N';

				var orderForm = BX('ORDER_FORM');
				BX.ajax.submitComponentForm(orderForm, 'order_form_content', true);
				BX.submit(orderForm);
				BX.closeWait();

				return true;
			}

			function SetContact(profileId)
			{
				BX("profile_change").value = "Y";
				submitForm();
			}
			</script>
            <h1 class="product_title">Оформление заказа</h1>
            <div class="order_block clearfix">
                			
			<?if($_POST["is_ajax_post"] != "Y")
			{
				?><form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
				<?=bitrix_sessid_post()?>
				<div id="order_form_content" class="order_form">
				<?
			}
			else
			{
				$APPLICATION->RestartBuffer();
			}
			?>

			<div class="order_block_left">
			<?
			if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
			{
				foreach($arResult["ERROR"] as $v)
					echo ShowError($v);
				?>
				<script type="text/javascript">
					top.BX.scrollToNode(top.BX('ORDER_FORM'));
				</script>
				<?
			}

			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");
			if ($arParams["DELIVERY_TO_PAYSYSTEM"] == "p2d")
			{
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
			}
			else
			{
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
			}
?>
		<div class="blockCity">
							<h2>Адрес доставки</h2>		
		<?
		PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_N"], $arParams["TEMPLATE_LOCATION"],ARRAY("LOCATION"));
		?>
		</div>
		<div class="blockAddress">
		<?
		PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_N"], $arParams["TEMPLATE_LOCATION"],ARRAY("F_METRO","STREET"),2);
		PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_N"], $arParams["TEMPLATE_LOCATION"],ARRAY("HOUSE","KORPUS","ROOM"),3);
		//PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"]);
		?>
		</div>
<?
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php");
			
			?>
			<div class="blockTime">
		<h2>УДОБНОЕ ВРЕМЯ ДОСТАВКИ</h2>
		<?PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_N"], $arParams["TEMPLATE_LOCATION"],ARRAY("F_DATE","F_TIME"));?>
			
</div>
<div class="blockComment">
                            <h2>Комментарии к заказу</h2>

                            <div class="order_col1">   
                                <div class="order_label">Оставте свой комментарий или дополнительную информацию</div>
                                <div class="order_input">
<textarea name="ORDER_DESCRIPTION" id="ORDER_DESCRIPTION"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea>
			<input type="hidden" name="" value="">
                                </div>
                            </div>
                            <div class="order_submit">
                                <input type="submit" value="Оформить заказ" onclick="submitForm('Y'); return false;">
                            </div>	
</div>							
			<?

			
			if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
				echo $arResult["PREPAY_ADIT_FIELDS"];
			?>
                </div>
                <div class="order_block_right">
				<?
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");
				?>
                </div>
			<?if($_POST["is_ajax_post"] != "Y")
			{
				?>
					</div>
					<input type="hidden" name="confirmorder" id="confirmorder" value="Y">
					<input type="hidden" name="profile_change" id="profile_change" value="N">
					<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
					<?/*
					<div class="bx_ordercart_order_pay_center"><a href="javascript:void();" onclick="submitForm('Y'); return false;" class="checkout"><?=GetMessage("SOA_TEMPL_BUTTON")?></a></div>
				*/?></form>

            </div>				
				<?
				if($arParams["DELIVERY_NO_AJAX"] == "N")
				{
					?>
					<div style="display:none;"><?$APPLICATION->IncludeComponent("bitrix:sale.ajax.delivery.calculator", "", array(), null, array('HIDE_ICONS' => 'Y')); ?></div>
					<?
				}
			}
			else
			{
				?>
				<script type="text/javascript">
					top.BX('confirmorder').value = 'Y';
					top.BX('profile_change').value = 'N';
				</script>
				<?
				die();
			}
		}
	}
	?>
	</div>
</div>
<?
$arMetro = array(
	'Авиамоторная',
	'Автозаводская',
	'Академическая',
	'Александровский сад',
	'Алексеевская',
	'Алтуфьево',
	'Аннино',
	'Арбатская [глуб.]',
	'Арбатская [мелк.]',
	'Аэропорт',
	'Бабушкинская',
	'Багратионовская',
	'Баррикадная',
	'Бауманская',
	'Беговая',
	'Белорусская',
	'Белорусская',
	'Беляево',
	'Бибирево',
	'Библиотека имени В. И. Ленина',
	'Битцевский парк',
	'Боровицкая',
	'Ботанический сад',
	'Братиславская',
	'Бульвар Адмирала Ушакова-',
	'Бульвар Дмитрия Донского',
	'Бунинская Аллея-',
	'Варшавская',
	'ВДНХ',
	'Владыкино',
	'Водный стадион',
	'Войковская',
	'Волгоградский проспект',
	'Волжская',
	'Воробьёвы горы',
	'Выхино',
	'Деловой центр',
	'Динамо',
	'Дмитровская',
	'Добрынинская',
	'Домодедовская',
	'Достоевская',
	'Дубровка',
	'Измайловская',
	'Калужская',
	'Кантемировская',
	'Каховская',
	'Каширская',
	'Каширская',
	'Киевская',
	'Киевская [глуб.]',
	'Киевская [мелк.]',
	'Китай-город',
	'Китай-город',
	'Кожуховская',
	'Коломенская',
	'Комсомольская',
	'Комсомольская - радиальная',
	'Коньково',
	'Красногвардейская',
	'Краснопресненская',
	'Красносельская',
	'Красные ворота',
	'Крестьянская застава',
	'Кропоткинская',
	'Крылатское',
	'Кузнецкий мост',
	'Кузьминки',
	'Кунцевская',
	'Кунцевская',
	'Курская',
	'Курская [глуб.]',
	'Кутузовская',
	'Ленинский проспект',
	'Лубянка',
	'Люблино',
	'Марксистская',
	'Марьина Роща *',
	'Марьино',
	'Маяковская',
	'Медведково',
	'Менделеевская',
	'Митино',
	'Молодежная',
	'Нагатинская',
	'Нагорная',
	'Нахимовский проспект',
	'Новогиреево',
	'Новокузнецкая',
	'Новослободская',
	'Новокосино',
	'Новые Черемушки',
	'Октябрьская',
	'Октябрьская - радиальная',
	'Октябрьское поле',
	'Орехово',
	'Отрадное',
	'Охотный ряд',
	'Павелецкая',
	'Павелецкая',
	'Парк культуры',
	'Парк культуры - радиальная',
	'Парк Победы',
	'Партизанская',
	'Первомайская',
	'Перово',
	'Петровско-Разумовская',
	'Печатники',
	'Пионерская',
	'Планерная',
	'Площадь Ильича',
	'Площадь Революции',
	'Полежаевская',
	'Полянка',
	'Пражская',
	'Преображенская площадь',
	'Пролетарская',
	'Проспект Вернадского',
	'Проспект Мира',
	'Проспект Мира - радиальная',
	'Профсоюзная',
	'Пушкинская',
	'Речной вокзал',
	'Рижская',
	'Римская',
	'Рязанский проспект',
	'Савеловская',
	'Свиблово',
	'Севастопольская',
	'Семеновская',
	'Серпуховская',
	'Славянский бульвар',
	'Смоленская [глуб.]',
	'Смоленская [мелк.]',
	'Сокол',
	'Сокольники',
	'Спортивная',
	'Сретенский бульвар',
	'Строгино',
	'Студенческая',
	'Сухаревская',
	'Сходненская',
	'Таганская',
	'Таганская - радиальная',
	'Тверская',
	'Театральная',
	'Текстильщики',
	'Теплый Стан',
	'Тимирязевская',
	'Третьяковская',
	'Третьяковская',
	'Трубная',
	'Тульская',
	'Тургеневская',
	'Тушинская',
	'Улица 1905 года',
	'Улица Академика Янгеля',
	'Улица Горчакова-',
	'Улица Подбельского',
	'Улица Скобелевская-',
	'Улица Старокачаловская-',
	'Университет',
	'Филевский парк',
	'Фили',
	'Фрунзенская',
	'Царицыно',
	'Цветной бульвар',
	'Черкизовская',
	'Чертановская',
	'Чеховская',
	'Чистые пруды',
	'Чкаловская',
	'Шаболовская',
	'Шипиловская *',
	'Шоссе Энтузиастов',
	'Щелковская',
	'Щукинская',
	'Электрозаводская',
	'Юго-Западная',
	'Южная',
	'Ясенево',
);
?>
<script>
function autoCompleteMetro() {
	$("#prop_F_METRO input").autocomplete({
		minChars:2,
		delimiter: /(,|;)\s*/, // regex or character
		maxHeight:200,
		width:300,
		zIndex: 9999,
		deferRequestBy: 0, //miliseconds
		params: { metro:'Yes' }, //aditional parameters
		noCache: false, //default is false, set to true to disable caching
		// callback function:
		onSelect: function(value, data){  },
		// local autosugest options:
		lookup: ['<?=join("', '",$arMetro)?>'] //local lookup values
	});
}
$(function(){
	$(document).on({
		keyup: function(){
			if ($(this).val().length>1) $(this).removeClass("error");
		}
	},"input.error");
	autoCompleteMetro();
});
</script>
<?
$APPLICATION->AddHeadString('    <script src="'.SITE_TEMPLATE_PATH.'/js/datepicker.js"></script>
<script type="text/javascript" src="'.SITE_TEMPLATE_PATH.'/js/jquery.autocomplete.min.js"></script>
    <link rel="stylesheet" href="'.SITE_TEMPLATE_PATH.'/css/autocomplete.css">
    ');
?>