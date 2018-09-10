<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if($GET["debug"] == "y"){
	error_reporting(E_ERROR | E_PARSE);
}
if($_SERVER['HTTP_HOST']=='gipfel.by'):
Header( "HTTP/1.1 403 Restricted Content" );
Header( "Location: https://gipfel.ru" ); 
endif;

IncludeTemplateLangFile(__FILE__);
global $APPLICATION, $TEMPLATE_OPTIONS, $arSite;
$arSite = CSite::GetByID(SITE_ID)->Fetch();
$htmlClass = ($_REQUEST && isset($_REQUEST['print']) ? 'print' : false);
?>

<!DOCTYPE html>
<!--<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>" xmlns="https://www.w3.org/1999/xhtml" <?=($htmlClass ? 'class="'.$htmlClass.'"' : '')?>>-->

<html lang="ru">
<head>
	<title><?$APPLICATION->ShowTitle()?></title>
	<?$APPLICATION->ShowMeta("viewport");?>
	<meta name="cmsmagazine" content="80ec8917da5ef485b2b56bb185de73b2" />
	<meta name="yandex-verification" content="993f7933fccbe131" />
	<?$APPLICATION->ShowMeta("HandheldFriendly");?>
	<?$APPLICATION->ShowMeta("apple-mobile-web-app-capable", "yes");?>
	<?$APPLICATION->ShowMeta("apple-mobile-web-app-status-bar-style");?>
	<?$APPLICATION->ShowMeta("SKYPE_TOOLBAR");?>
	<?$APPLICATION->ShowHead();?>
	<?$APPLICATION->AddHeadString('<script>BX.message('.CUtil::PhpToJSObject( $MESS, false ).')</script>', true);?>
	<?if(CModule::IncludeModule("aspro.optimus")) {COptimus::Start(SITE_ID);}?>
	<!--[if gte IE 9]><style type="text/css">.basket_button, .button30, .icon {filter: none;}</style><![endif]-->
	<link href='<?=CMain::IsHTTPS() ? 'https' : 'https'?>://fonts.googleapis.com/css?family=Ubuntu:400,500,700,400italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KV344BW');</script>
<!-- End Google Tag Manager -->
</head>
<body id="main">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KV344BW" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <div id="mobile_checker"></div>
 <!--   <script type="text/javascript" language="javascript"> 
      if ($('#mobile_checker').is(":visible")!=true) {
        var _lh_params = {"popup": false}; lh_clid="5835b505e694aa725ebaa1fb"; (function() { var lh = document.createElement('script'); lh.type = 'text/javascript'; lh.async = true; lh.src = ('https:' == document.location.protocol ? 'https://' : 'https://') + 'track.leadhit.io/track.js?ver=' + Math.floor(Date.now()/100000).toString(); var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lh, s); })();
      }
    </script>-->
<?//Leadhit END?>



	<? if($_SERVER['REQUEST_URI']=='/bitrix/urlrewrite.php') { 
header('Location: /');
exit;
	} ?>	


	<? if($_SERVER['HTTP_HOST']=='www.gipfel.by') { 
header('Location: https://gipfel.ru/');
exit;
	} ?>	


	<? if($_SERVER['REQUEST_URI']=='/company/news/') { 
header('Location: /news/');
exit;
	} ?>	


	<? 


$p = parse_url($_SERVER['REQUEST_URI']);
$f = explode('/', $p['path']);

	if($f[1] == 'company' && $f[2] == 'news') { 
header('Location: /news/');
exit;
	} ?>	




	<? if($_SERVER['REQUEST_URI']=='/catalog/nabor-posudy-werner-0667-ingrid-8pr/') { ?>


<style>
#product_reviews_tab {
display: none !important;
}
</style>

	<? } ?>	


		<div id="panel"><?$APPLICATION->ShowPanel();?></div>
		<?if(!CModule::IncludeModule("aspro.optimus")){?><center><?$APPLICATION->IncludeFile(SITE_DIR."include/error_include_module.php");?></center></body></html><?die();?><?}?>
		<?$APPLICATION->IncludeComponent("aspro:theme.optimus", ".default", array("COMPONENT_TEMPLATE" => ".default"), false);?>
		<?COptimus::SetJSOptions();?>
		<div class="wrapper <?=(COptimus::getCurrentPageClass());?> basket_<?=strToLower($TEMPLATE_OPTIONS["BASKET"]["CURRENT_VALUE"]);?> <?=strToLower($TEMPLATE_OPTIONS["MENU_COLOR"]["CURRENT_VALUE"]);?> banner_auto">
			<div class="header_wrap <?=strtolower($TEMPLATE_OPTIONS["HEAD_COLOR"]["CURRENT_VALUE"])?>">
				<?if($TEMPLATE_OPTIONS["BASKET"]["CURRENT_VALUE"]=="NORMAL"){?>
					<div class="top-h-row">
						<div class="wrapper_inner">
							<div class="top_inner">
								<div class="content_menu">
									<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
										array(
											"COMPONENT_TEMPLATE" => ".default",
											"PATH" => SITE_DIR."include/topest_page/menu.top_content_row.php",
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "",
											"AREA_FILE_RECURSIVE" => "Y",
											"EDIT_TEMPLATE" => "standard.php"
										),
										false
									);?>
								</div>
								<div class="phones">
									<div class="phone_block">
										<span class="phone_wrap">
											<span class="icons fa fa-phone"></span>
											<span class="phone_text">
												<?
if ($GLOBALS["MCUR"]=='RUB') {$fff = 'phone.php';} 													
if ($GLOBALS["MCUR"]=='KZT') {$fff = 'phonekz.php';} 
if ($GLOBALS["MCUR"]=='BYN') {$fff = 'phoneby.php';} 
if ($GLOBALS["MCUR"]=='UAH') {$fff = 'phoneua.php';} 

													$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
													array(
														"COMPONENT_TEMPLATE" => ".default",
														"PATH" => SITE_DIR."include/".$fff,
														"AREA_FILE_SHOW" => "file",
														"AREA_FILE_SUFFIX" => "",
														"AREA_FILE_RECURSIVE" => "Y",
														"EDIT_TEMPLATE" => "standard.php"
													),
													false
												);?>
											</span>
										</span>
										<span class="order_wrap_btn">
											<span onclick="upravel_track_event('event','29300000072','call','2');" class="callback_btn"><?=GetMessage("CALLBACK")?></span>
										</span>
									</div>
								</div>
								<div class="h-user-block" id="personal_block">
									<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
										array(
											"COMPONENT_TEMPLATE" => ".default",
											"PATH" => SITE_DIR."include/topest_page/auth.top.php",
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "",
											"AREA_FILE_RECURSIVE" => "Y",
											"EDIT_TEMPLATE" => "standard.php"
										),
										false
									);?>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				<?}?>
				<header id="header">
					<div class="wrapper_inner">
						<div class="top_br"></div>
						<table class="middle-h-row">
							<tr>
								<td class="logo_wrapp">
									<div class="logo nofill_<?=strtolower(\Bitrix\Main\Config\Option::get('aspro.optimus', 'NO_LOGO_BG', 'N'));?>">
										<?COptimus::ShowLogo();?>
									</div>
								</td>
								<!--<td class="text_wrapp">
									<div class="slogan">
										<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
											array(
												"COMPONENT_TEMPLATE" => ".default",
												"PATH" => SITE_DIR."include/top_page/slogan.php",
												"AREA_FILE_SHOW" => "file",
												"AREA_FILE_SUFFIX" => "",
												"AREA_FILE_RECURSIVE" => "Y",
												"EDIT_TEMPLATE" => "standard.php"
											),
											false
										);?>	
									</div>
									


								</td>-->
								<td  class="center_block">																	
									<div class="search">
										<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
											array(
												"COMPONENT_TEMPLATE" => ".default",
												"PATH" => SITE_DIR."include/top_page/search.title.catalog.php",
												"AREA_FILE_SHOW" => "file",
												"AREA_FILE_SUFFIX" => "",
												"AREA_FILE_RECURSIVE" => "Y",
												"EDIT_TEMPLATE" => "standard.php"
											),
											false
										);?>
									</div>
									<? 
										//$countries = array('RU'=>'Россия|gipfel.ru','KZ'=>'Казахстан|gipfel.kz','BY'=>'Белоруссия|gipfel.by','UAH'=>'Украина|gipfel.ua');
										$countries = array('RU'=>'Россия|gipfel.ru','KZ'=>'Казахстан|gipfel.kz','UAH'=>'Украина|gipfel.ua');
										//if(isset($_GET['geo'])):?>
									<div class = "geo">
										<select class="inputtext " required="" name="ygeo" value="" aria-required="true" >
										<? foreach($countries as $key=>$country){ $p=explode('|',$country)?>
											<option <? if ($key==$_SESSION['RR'] or $p[1]==$_SERVER['HTTP_HOST']) echo 'selected'; ?> value = "<? echo $key ?>"><? echo $p[0];?></option>	
										<?	}?>
										</select>
										<script>
										$('.geo select').on('change', function() {
											var gval = $(this).val();
											$.ajax({
  url: "/langredirect.php",
  type: "GET",
  data: "MYGEO="+gval,
  success: function(data){
    if (data.indexOf('http') != -1){
	    //alert(data);
	    location.replace(data);
    }
  }
});

										})	
										</script>
									</div>
									<?// endif; ?>
								</td>
								<td class="basket_wrapp">
									<?if($TEMPLATE_OPTIONS["BASKET"]["CURRENT_VALUE"] == "NORMAL"){?>
										<div class="wrapp_all_icons">
											<div class="header-compare-block icon_block iblock" id="compare_line" >
												<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
													array(
														"COMPONENT_TEMPLATE" => ".default",
														"PATH" => SITE_DIR."include/top_page/catalog.compare.list.compare_top.php",
														"AREA_FILE_SHOW" => "file",
														"AREA_FILE_SUFFIX" => "",
														"AREA_FILE_RECURSIVE" => "Y",
														"EDIT_TEMPLATE" => "standard.php"
													),
													false
												);?>
											</div>
											<div class="header-cart" id="basket_line">
												<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
													array(
														"COMPONENT_TEMPLATE" => ".default",
														"PATH" => SITE_DIR."include/top_page/comp_basket_top.php",
														"AREA_FILE_SHOW" => "file",
														"AREA_FILE_SUFFIX" => "",
														"AREA_FILE_RECURSIVE" => "Y",
														"EDIT_TEMPLATE" => "standard.php"
													),
													false
												);?>												
											</div>
										</div>
									<?}else{?>
										<div class="header-cart fly" id="basket_line">
											<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
												array(
													"COMPONENT_TEMPLATE" => ".default",
													"PATH" => SITE_DIR."include/top_page/comp_basket_top.php",
													"AREA_FILE_SHOW" => "file",
													"AREA_FILE_SUFFIX" => "",
													"AREA_FILE_RECURSIVE" => "Y",
													"EDIT_TEMPLATE" => "standard.php"
												),
												false
											);?>											
										</div>
										<div class="middle_phone">
											<div class="phones">
												<span class="phone_wrap">
													<span class="phone">
														<span class="icons fa fa-phone"></span>
														<span class="phone_text">
															<?
if ($GLOBALS["MCUR"]=='RUB') {$fff = 'phone.php';} 													
if ($GLOBALS["MCUR"]=='KZT') {$fff = 'phonekz.php';} 
if ($GLOBALS["MCUR"]=='BYN') {$fff = 'phoneby.php';} 
if ($GLOBALS["MCUR"]=='UAH') {$fff = 'phoneua.php';} 

																$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
																array(
																	"COMPONENT_TEMPLATE" => ".default",
																	"PATH" => SITE_DIR."include/".$fff,
																	"AREA_FILE_SHOW" => "file",
																	"AREA_FILE_SUFFIX" => "",
																	"AREA_FILE_RECURSIVE" => "Y",
																	"EDIT_TEMPLATE" => "standard.php"
																),
																false
															);?>
														</span>
													</span>


<a class="sdfsdf" href="/auth/?backurl=/personal/" style="cursor:pointer;"><img style="height:40px;margin-left:30px;position:absolute;" src="<?=SITE_TEMPLATE_PATH ?>/images/businessman64.png"></a>

	<span class="order_wrap_btn">
														<span>info@gipfel.ru</span>
													</span>

													<!--<span class="order_wrap_btn">
														<span onclick="upravel_track_event('event','29300000072','call','2');"  class="callback_btn"><?=GetMessage("CALLBACK")?></span>
													</span>-->



												</span>
											</div>
										</div>
									<?}?>




									<div class="clearfix"></div>
								</td>



								<td class="center_block" style="margin-left:40px;">
									<div class="soc2" style="left:40px;position:relative;">
										<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
											array(
												"COMPONENT_TEMPLATE" => ".default",
												"PATH" => SITE_DIR."include/top_page/soc.php",
												"AREA_FILE_SHOW" => "file",
												"AREA_FILE_SUFFIX" => "",
												"AREA_FILE_RECURSIVE" => "Y",
												"EDIT_TEMPLATE" => "standard.php"
											),
											false
										);?>	
									</div>
								</td>




							</tr>
						</table>
					</div>
					<div class="catalog_menu menu_<?=strToLower($TEMPLATE_OPTIONS["MENU_COLOR"]["CURRENT_VALUE"]);?>">
						
						<div class="wrapper_inner">
						<a href="/">	<img class = "fixlogo" src = "<?=SITE_TEMPLATE_PATH ?>/images/whl.png"></a>
							<div class="wrapper_middle_menu wrap_menu">
								<ul class="menu adaptive">
									<li class="menu_opener"><div class="text">
										<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
											array(
												"COMPONENT_TEMPLATE" => ".default",
												"PATH" => SITE_DIR."include/menu/menu.mobile.title.php",
												"AREA_FILE_SHOW" => "file",
												"AREA_FILE_SUFFIX" => "",
												"AREA_FILE_RECURSIVE" => "Y",
												"EDIT_TEMPLATE" => "standard.php"
											),
											false
										);?>
								</div></li>
								</ul>				
								<?/*<div class="catalog_menu_ext">
									<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
										array(
											"COMPONENT_TEMPLATE" => ".default",
											"PATH" => SITE_DIR."include/menu/menu.catalog.php",
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "",
											"AREA_FILE_RECURSIVE" => "Y",
											"EDIT_TEMPLATE" => "standard.php"
										),
										false
									);?>
								</div>
								<div class="inc_menu">
									<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
										array(
											"COMPONENT_TEMPLATE" => ".default",
											"PATH" => SITE_DIR."include/menu/menu.top_content_multilevel.php",
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "",
											"AREA_FILE_RECURSIVE" => "Y",
											"EDIT_TEMPLATE" => "standard.php"
										),
										false
									);?>
								</div>*/?>
                <div class="inc_menu">
									<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
										array(
											"COMPONENT_TEMPLATE" => ".default",
											"PATH" => SITE_DIR."include/menu/menu.top_catalog_menu.php",
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "",
											"AREA_FILE_RECURSIVE" => "Y",
											"EDIT_TEMPLATE" => "standard.php"
										),
										false
									);?>
								</div>
							</div>
						</div>
						<div class = "mobile_search">
					<div class="wrapper_inner">



<?php if(!$_GET) { ?>
	
						<div class="search">
										<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
											array(
												"COMPONENT_TEMPLATE" => ".default",
												"PATH" => SITE_DIR."include/top_page/search.title.catalog.php",
												"AREA_FILE_SHOW" => "file",
												"AREA_FILE_SUFFIX" => "",
												"AREA_FILE_RECURSIVE" => "Y",
												"EDIT_TEMPLATE" => "standard.php"
											),
											false
										);?>
						</div>




<?}?>



					</div>
					</div>
					</div>
					
				</header>
			</div>
			<div class="wraps" id="content">
				<div class="wrapper_inner <?=(COptimus::IsMainPage() ? "front" : "");?> <?=((COptimus::IsOrderPage() || COptimus::IsBasketPage()) ? "wide_page" : "");?>">
					<?if(!COptimus::IsOrderPage() && !COptimus::IsBasketPage() && !COptimus::IsMainPage()){?>
						<div class="left_block">
							<?if (strpos($_SERVER['REQUEST_URI'],'/catalog/')!==0)
              $APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/left_block/menu.left_menu.php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "standard.php"
								),
								false
							);?>					

							<?$APPLICATION->ShowViewContent('left_menu');?>
							<?/*$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/left_block/comp_banners_left.php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "standard.php"
								),
								false
							);?>
							<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/left_block/comp_subscribe.php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "standard.php"
								),
								false
							);*/ ?>
							<?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"PATH" => SITE_DIR."include/left_block/comp_news.php",
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "",
		"AREA_FILE_RECURSIVE" => "Y",
		"EDIT_TEMPLATE" => "standard.php",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
							<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/left_block/comp_news_articles.php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "standard.php"
								),
								false
							);?>
						</div>
						<div class="right_block">
					<?}?>
						<div class="middle">
							<?if(!COptimus::IsMainPage()):?>
								<div class="container">
									<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "optimus", array(
										"START_FROM" => "0",
										"PATH" => "",
										"SITE_ID" => "-",
										"SHOW_SUBSECTIONS" => "N"
										),
										false
									);?>
									<h1 id="pagetitle"><?=$APPLICATION->ShowTitle(false);?></h1>								
							<?endif;?>
<?if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest") $APPLICATION->RestartBuffer();?>
	