<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule('sale');
CModule::includeModule('ws.projectsettings'); 
CUtil::InitJSCore();
CJSCore::Init(array("fx"));
$curPage = $APPLICATION->GetCurPage(true);
?><!doctype html>
<html lang="en-US">
<head>
<!-- Yandex.Metrika counter --><script type="text/javascript">var yaParams = {/*Здесь параметры визита*/};</script><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter25847225 = new Ya.Metrika({id:25847225, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true,params:window.yaParams||{ }}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/25847225" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
    <!-- normalize css -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/normalize.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/jquery.bxslider.css">
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/jquery-ui-1.10.4.custom.min.css">
    <!-- main css -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/style.css">
    <!-- jquery -->
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery-1.10.2.min.js"></script>
    <!--[if IE]><script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/css/PIE/PIE.js"></script><![endif]-->
    <!--[if lt IE 9]><script src="<?=SITE_TEMPLATE_PATH?>/js/html5.js"></script><![endif]-->
    <!--[if IE 8]><link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/ie/style-for-8.css"><script src="js/ie8fix.js"></script><![endif]-->
    <!--[if IE 9]><link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/ie/style-for-9.css"><script src="js/ie9fix.js"></script><![endif]-->
    <!-- fonts css -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,800italic,400,600,700,800&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link href="<?=SITE_TEMPLATE_PATH?>/css/fonts/fonts.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/font-awesome/css/font-awesome.min.css">
    <!-- custom js -->
    <script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.bxslider.min.js"></script>


	<?//$APPLICATION->ShowHead();
	echo '<meta http-equiv="Content-Type" content="text/html; charset='.LANG_CHARSET.'"'.(true ? ' /':'').'>'."\n";
	$APPLICATION->ShowMeta("robots", false, true);
	$APPLICATION->ShowMeta("keywords", false, true);
	$APPLICATION->ShowMeta("description", false, true);
	$APPLICATION->ShowCSS(true, true);
	$APPLICATION->ShowHeadStrings();
	$APPLICATION->ShowHeadScripts();
	?>
<script src="<?=SITE_TEMPLATE_PATH?>/js/script.js"></script>

 <!--    <script src="https://dl.dropboxusercontent.com/u/12766560/gipfelru/js/script.js"></script>  -->

	<title><?$APPLICATION->ShowTitle()?></title>
	
	<?if (!$USER->IsAdmin()) {?>
		<script type="text/javascript">
			var message = '';
			function clickIE() {
				if (document.all) {
					(message);
					return false;
				}
			}
			function clickNS(e) {
				if  (document.layers || (document.getElementById && !document.all)) {
					if (e.which==2) {
						(message);
						return false;
					}
				}
			}
			if (document.layers) {
				document.captureEvents(Event.MOUSEDOWN);
				document.onmousedown = clickNS;
			} else {
				document.onmouseup = clickNS;
				document.oncontextmenu = clickIE;
			}
			document.oncontextmenu = new Function('return false');
		</script>
		
	<?}?>
	
</head>
<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<?$APPLICATION->IncludeComponent("bitrix:eshop.banner", "", array());?>
<?$APPLICATION->IncludeComponent("itlogic:copy.disable", "", array(
	
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);?>
	<header>
    	<div class="wrapper">
			<?$curdir = $APPLICATION->GetCurDir();
			if (strpos($curdir, 'catalog___')){?>
			<object id="Flash" width="160" height="400" style="position:absolute; left:-170px; top:180px; z-index:900;" data="/catalog/1_GIPFEL-GROUP2.swf">
			  <param name="movie" value="/catalog/1_GIPFEL-GROUP2.swf">
			  <param name="quality" value="high">
			<param name="wmode" value="transparent" />
			</object>

			<object id="Flash2" width="160" height="400" style="position:absolute; right:-170px; top:180px; z-index:900;" data="/catalog/2_GIPFEL-GROUP2.swf">
			  <param name="movie" value="/catalog/2_GIPFEL-GROUP2.swf">
			  <param name="quality" value="high">
			<param name="wmode" value="transparent" />
			</object>
			<?}?>
            <div class="clearfix">                
                <div class="logo">
                    <a href="/">
                        <div><img src="<?=SITE_TEMPLATE_PATH?>/images/logo.png" alt=""></div>
                        <div class="logo_capt"><?=WS_PSettings::getFieldValue('NAME', false)?></div>
                    </a>
                </div>
                <div class="header_left">
                    <div class="header_phone_block">
                        <div class="header_phone_city">Москва:</div>
                        <div class="header_phone">+7 (495) <span>222-15-15</span> </div>
                    </div>
                   
                    <div class="search">
<?$APPLICATION->IncludeComponent("bitrix:search.title", "header", array(
	"NUM_CATEGORIES" => "1",
	"TOP_COUNT" => "5",
	"ORDER" => "date",
	"USE_LANGUAGE_GUESS" => "N",
	"CHECK_DATES" => "N",
	"SHOW_OTHERS" => "N",
	"PAGE" => "#SITE_DIR#search/index.php",
	"CATEGORY_0_TITLE" => "",
	"CATEGORY_0" => array(
		0 => "iblock_offers",
	),
	"SHOW_INPUT" => "Y",
	"INPUT_ID" => "title-search-input",
	"CONTAINER_ID" => "title-search"
	),
	false
);?>
                    </div>
                </div>
                <div class="header_mid">
                    <div class="header_time">
                        <div class="header_time_title">МЫ РАБОТАЕМ:</div>
                       <?=WS_PSettings::getFieldValue('TIME', false)?>
                    </div>
                    <div class="header_mail"><a href="mailto:<?=WS_PSettings::getFieldValue('EMAIL', false)?>"><?=WS_PSettings::getFieldValue('EMAIL', false)?></a></div>
                </div>
                <div class="cart_block">
<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "topline", Array(
	"PATH_TO_BASKET" => "/personal/cart/",	// Страница корзины
	"PATH_TO_ORDER" => "/personal/order/make/",	// Страница оформления заказа
	"SHOW_DELAY" => "Y",	// Показывать отложенные товары
	"SHOW_NOTAVAIL" => "Y",	// Показывать товары, недоступные для покупки
	"SHOW_SUBSCRIBE" => "Y",	// Показывать товары, на которые подписан покупатель
	),
	false
);?>
                </div>
            </div>
    	</div> 
</header>
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"top", 
	array(
		"ROOT_MENU_TYPE" => "top",
		"MENU_THEME" => "site",
		"MENU_CACHE_TYPE" => "Y",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "top"
	),
	false
);?>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "page",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => ""
	)
);?>
	<?
		$ur = $_SERVER['REQUEST_URI'];
		$url = explode("/", $ur);
		$ua_s = explode("(", $_SERVER['HTTP_USER_AGENT']);
		$ua_os = explode(";", $ua_s[1]);
		//print_r($ua_os[0]);
	?>
    <div id="content">		
    	<div class="wrapper main" >
		
<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "template1", array(
	"START_FROM" => "1",
	"PATH" => "",
	"SITE_ID" => "-"
	),
	false
);?>
