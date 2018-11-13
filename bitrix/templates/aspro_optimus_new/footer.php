<?if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest") die();?>
<?IncludeTemplateLangFile(__FILE__);?>
							<?if(!COptimus::IsMainPage()):?>
								</div> <?// .container?>
							<?endif;?>
						</div>
					<?if(!COptimus::IsOrderPage() && !COptimus::IsBasketPage()):?>
						</div> <?// .right_block?>
					<?endif;?>
				</div> <?// .wrapper_inner?>				
			</div> <?// #content?>
		</div><?// .wrapper?>
		<footer id="footer">
			<div class="footer_inner <?=strtolower($TEMPLATE_OPTIONS["BGCOLOR_THEME_FOOTER_SIDE"]["CURRENT_VALUE"]);?>">

				<?if($APPLICATION->GetProperty("viewed_show")=="Y" || defined("ERROR_404")):?>
					<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
						array(
							"COMPONENT_TEMPLATE" => ".default",
							"PATH" => SITE_DIR."include/footer/comp_viewed.php",
							"AREA_FILE_SHOW" => "file",
							"AREA_FILE_SUFFIX" => "",
							"AREA_FILE_RECURSIVE" => "Y",
							"EDIT_TEMPLATE" => "standard.php"
						),
						false
					);?>					
				<?endif;?>
				<div class="wrapper_inner">
					<div class="footer_bottom_inner">

<?php if($_SERVER['HTTP_HOST']=='gipfel.kz') {  ?>


					<div class="left_block">
							<span class="pay_system_icons">
	<i title="MasterCard" class="mastercard"></i>
<i title="Maestro" class="maestro"></i>
<i title="Visa" class="visa"></i>
<i title="МИР" class="mir"></i>

    

<p style="
    font-weight: bold;
    text-transform: uppercase;
    color: #1d2029 !important;
    margin-bottom: 2px;
">Доставка по KZ:</p>
<ul class="wedel">
    <li>СДЭК</li>
</ul>





	




<!--<i title="Yandex" class="yandex_money"></i>
<i title="WebMoney" class="webmoney"></i>
<i title="Qiwi" class="qiwi"></i>--></span>
<div class="copyright">
	2018

 © GIPFEL.KZ</div>							
							<div id="bx-composite-banner"></div>
						</div>

<?php } else { ?>


	<div class="left_block">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/footer/copyright.php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "standard.php"
								),
								false
							);?>							
							<div id="bx-composite-banner"></div>
						</div>



<?php	} ?>


						<div class="right_block">
							<div class="middle">
								<div class="rows_block">
									<div class="item_block col-75 menus">
										<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom_submenu_top", 
	array(
		"ROOT_MENU_TYPE" => "bottom",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "bottom_submenu_top",
		"CHILD_MENU_TYPE" => "left"
	),
	false
);?>
										<div class="rows_block">
											<div class="item_block col-4">
												<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom_submenu", 
	array(
		"ROOT_MENU_TYPE" => "bottom_company",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "bottom_submenu",
		"CHILD_MENU_TYPE" => "left"
	),
	false
);?>
											</div>
											<div class="item_block col-4">
												<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom_submenu", 
	array(
		"ROOT_MENU_TYPE" => "bottom_info",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "bottom_submenu",
		"CHILD_MENU_TYPE" => "left"
	),
	false
);?>
											</div>
											<div class="item_block col-4">
												<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom_submenu", 
	array(
		"ROOT_MENU_TYPE" => "bottom_help",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "bottom_submenu",
		"CHILD_MENU_TYPE" => "left"
	),
	false
);?>
											</div>
											<div class="item_block col-4 lastcon">
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
										</div>
									</div>
									<div class="item_block col-4 soc">
										<div class="soc_wrapper">
											<div class="phones">
												<div class="phone_block">
													<span class="phone_wrap">
														<span class="icons fa fa-phone"></span>
														<span>
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
														<span class="callback_btn"><?=GetMessage('CALLBACK')?></span>
													</span>
												</div>
											</div>
											<div class="social_wrapper">
												<div class="social">
													<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
														array(
															"COMPONENT_TEMPLATE" => ".default",
															"PATH" => SITE_DIR."include/footer/social.info.optimus.default.php",
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
										<div class="clearfix"></div>
										<!--<div style="font-size: 13px;margin-top: 10px;">Продвижение сайта <a rel="nofollow" target = "blank" href="http://afonico.ru">Afonico M&D</a></div> -->
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="mobile_copy">
						<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
							array(
								"COMPONENT_TEMPLATE" => ".default",
								"PATH" => SITE_DIR."include/footer/copyright.php",
								"AREA_FILE_SHOW" => "file",
								"AREA_FILE_SUFFIX" => "",
								"AREA_FILE_RECURSIVE" => "Y",
								"EDIT_TEMPLATE" => "standard.php"
							),
							false
						);?>
					</div>
					<?$APPLICATION->IncludeFile(SITE_DIR."include/bottom_include1.php", Array(), Array("MODE" => "text", "NAME" => GetMessage("ARBITRARY_1"))); ?>
					<?$APPLICATION->IncludeFile(SITE_DIR."include/bottom_include2.php", Array(), Array("MODE" => "text", "NAME" => GetMessage("ARBITRARY_2"))); ?>
				</div>
			</div>

<style>
	#deferred-products-widget-container .deferred-products__modal {
		background: #e3e3e3;
	}
	#deferred-products-widget-opener.deferred-products__opener {
		background: url('https://media.leadhit.ru/upload/eyes/opener-icon12.png') no-repeat left center #002663;
	}

</style>
<!--<script type="text/javascript"> 
imageDir = "http://gipfel.ru/snow/"; 
sflakesMax = 20; 
sflakesMaxActive = 20; 
svMaxX = 2; 
svMaxY = 6; 
ssnowStick = 0; 
ssnowCollect = 0; 
sfollowMouse = 0; 
sflakeBottom = 0; 
susePNG = 1; 
sflakeTypes = 2; 
sflakeWidth = 25; 
sflakeHeight = 25; 
</script> 
<script type="text/javascript" src="/snow.js"></script>-->


<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.10';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?//Для вывода leadhit только в десктопной версии?>


<script type="text/javascript">

$(document).ready(function() {
	
	$('#right_block_ajax .catalog_item .cost.prices .price.discount').each(function(){
		var dtxt = $(this).text().replace(/[^-0-9]/gim,'');
		console.log(dtxt);
		if(dtxt=='0'){
			$(this).hide();
		}
	});
		
	function myrep(){
		$('.basket_fly .price').each(function(){
			var ob = $(this);
			var txt = ob.text();
			var tg = txt.replace(/тг. тг./g,"тг.");
			var rub = txt.replace(/руб.руб./g,"руб.");
			var postg = txt.indexOf("тг. тг.");
			var posrub = txt.indexOf("руб.руб.");
			
			if ( postg != -1 ) {
				var newtxt = tg;
				ob.text(newtxt);
			}
			
			if ( posrub != -1 ) {
				var newtxt = rub;
				ob.text(newtxt);
			}
			
			//alert(newtxt);
		});
	}
	
	$('.basket_fly').on('click','.plus',function(){
		myrep();
	});
	
	$('.basket_fly').on('click','.minus',function(){
		myrep();
	});

$("#deferred-products-widget-email > img").remove();

// Удалить из корзины
$(document).on("mouseup", ".module-cart .remove, .remove_all_basket", function() {
setTimeout(function() {
	dataLayer.push({
	 'event': 'pixel-mg-event',
	 'pixel-mg-event-category': 'Enhanced Ecommerce',
	 'pixel-mg-event-action': 'Removing a Product from a Shopping Cart',
	 'pixel-mg-event-non-interaction': 'False',
	});
}, 2000);

});


// Купить в один клик
/*
var basketFlag = false,
	flag = false,
	myObj = arBasketAspro.BASKET,
	arrId = Object.values(myObj),
	itemCounter,
	allPrice;


$(document).on("click", "#basket_items_list .oneclickbuy", function() {
	basketFlag = true;
});
	
$(document).on("mouseup", "#one_click_buy_form_button", function() {
	allPrice = parseInt($("#allSum_FORMATED").text().replace(/\D+/g,""));
	if (flag == false) {
	    if (basketFlag != false) {
			setTimeout(function() {
				dataLayer.push({
				 'goods_id': arrId,
				 'goods_price': allPrice,
				 'event': 'pixel-mg-event',
				 'pixel-mg-event-category': 'Enhanced Ecommerce',
				 'pixel-mg-event-action': 'Purchase',
				 'pixel-mg-event-non-interaction': 'False',
				});
			}, 2000);
		} 
	} 
	flag = true;
});
*/
// Функция получения случайного числа . для ID
	  function randomInteger(min, max) {
	    var rand = min - 0.5 + Math.random() * (max - min + 1)
	    rand = Math.round(rand);
	    return rand;
	  }

	var  randomID = randomInteger(111, 111111),
	     prodArr = [],
	     itemCounter = 0,
	     prodId,
	     transId,
	     prodPrice,
	     prodBrand,
	     prodName,
	     prodQuantity;


// Покупка

	$("#basket_items tbody tr").each(function() {
	  if($(this)[0].hasAttribute("id")) {
		prodName = $(this).attr("data-item-name");
		prodId = arrId[itemCounter];
		prodPrice = $(this).attr("data-item-price");
		prodBrand = $(this).attr("data-item-brand");
		prodQuantity = $(this).find(".counter input").val();
		prodArr.push({  
			   'name': prodName,       // Обязательно  
			   'id': prodId,            // Обязательно   
			   'price': prodPrice,          // Цена за товар
			   'brand' : prodBrand,
			   'quantity': prodQuantity     // Количество
			  });
		itemCounter++; 
	  }
	});

var flag_purchase = false;



$(document).on("submit", "#order_alex", function() {
	allPrice = parseInt($("#allSum_FORMATED").text().replace(/\D+/g,""));
	setInterval(function(e) {
	  if ($(".swal2-content").length) {

        transId = $(".swal2-container #swal2-title").text();
		if(transId != "Увы") {

		transId = transId.replace(/\D+/g,"");
		if(transId == "") {
			transId = 2000000 + randomID;
		}
			if(!flag_purchase) {
		dataLayer.push({
		'ecommerce': {
		   'currencyCode': 'RUB',
		   'purchase': {
			 'actionField': {
			   'id': transId,            // уникальный идентификатор транзакции(обязательно)
			   'affiliation': 'GipFel - international', // магазин или филиал, в котором была совершена транзакция
			   'revenue': allPrice         // полная сумма транзакции, включая стоимость доставки и налог
			 },
			 'products': prodArr,
		   }
		 },
		 'goods_id': arrId,
		 'goods_price': allPrice,
		 'event': 'pixel-mg-event',
		 'pixel-mg-event-category': 'Enhanced Ecommerce',
		 'pixel-mg-event-action': 'Purchase',
		 'pixel-mg-event-non-interaction': 'False',
		});
		flag_purchase = true;
		console.log("Заявка отправлена");
		}

		return false;
		} else {
		console.log("Заявка не отправлена");
		return false;
		}

	  }
	}, 100);
});

});
</script>


		</footer>
		<?
		COptimus::setFooterTitle();
		COptimus::showFooterBasket();
		?>
	</body>
</html>