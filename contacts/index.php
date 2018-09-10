<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?>
<style>
	.left_block{
		display:none;
	}
	.right_block{
		padding-left: 0;
	}
	.contacts_right .store_property {
    float: left;
    width: 50%;
    padding-right: 20px;
    box-sizing: border-box;
}
.fourb{
	    overflow: auto;
    padding: 0 20px;
    border-left: 3px solid #112755;
    margin-top: 40px;
}
</style>

<div class="flex">
	<div class="contacts_left">
		<div class="store_description">
			
			<div class="store_property">
				<script type="text/javascript" src="//vk.com/js/api/openapi.js?150"></script>

<!-- VK Widget -->
<div id="vk_groups"></div>
<script type="text/javascript">
VK.Widgets.Group("vk_groups", {mode: 3, width: 'auto'}, 54260214);
</script>
			</div>
			<div class="store_property">
			<div class="fb-page" data-href="https://www.facebook.com/gipfel.ru/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/gipfel.ru/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/gipfel.ru/">Gipfel</a></blockquote></div>
			</div>
			<div class="store_property">
				<div id="ok_group_widget"></div>
<script>
!function (d, id, did, st) {
  var js = d.createElement("script");
  js.src = "https://connect.ok.ru/connect.js";
  js.onload = js.onreadystatechange = function () {
  if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
    if (!this.executed) {
      this.executed = true;
      setTimeout(function () {
        OK.CONNECT.insertGroupWidget(id,did,st);
      }, 0);
    }
  }}
  d.documentElement.appendChild(js);
}(document,"ok_group_widget","54876916547597",'{"width":415,"height":335}');
</script>
			</div>
		</div>
	</div>
	<div class="contacts_right">
		<div class="contacts_map">
	<?$APPLICATION->IncludeComponent(
	"bitrix:map.google.view", 
	"map", 
	array(
		"INIT_MAP_TYPE" => "ROADMAP",
		"MAP_DATA" => "a:4:{s:10:\"google_lat\";d:55.723731050725;s:10:\"google_lon\";d:37.566440551270034;s:12:\"google_scale\";i:14;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:4:\"TEXT\";s:98:\"119048, Российская Федерация,  г.  Москва, ул. Ефремова, д.23\";s:3:\"LON\";d:37.566968584433;s:3:\"LAT\";d:55.721205883058;}}}",
		"MAP_WIDTH" => "100%",
		"MAP_HEIGHT" => "400",
		"CONTROLS" => array(
		),
		"OPTIONS" => array(
			0 => "ENABLE_DBLCLICK_ZOOM",
			1 => "ENABLE_DRAGGING",
		),
		"MAP_ID" => "",
		"ZOOM_BLOCK" => array(
			"POSITION" => "right center",
		),
		"COMPONENT_TEMPLATE" => "map",
		"API_KEY" => "",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
</div>
		<div class = "fourb">
			<div class="store_property">
				<div class="title">Адрес</div>
				<div class="value">
					<?$APPLICATION->IncludeFile(SITE_DIR."include/address.php", Array(), Array("MODE" => "html", "NAME" => "Адрес"));?>
				</div>
			</div>
			<div class="store_property">
				<div class="title">Телефон</div>
				<div class="value">
					<?
						if ($GLOBALS["MCUR"]=='KZT') {$fff = 'phonekz.php'; } else {$fff = 'phone.php';}
						$APPLICATION->IncludeFile(SITE_DIR."include/".$fff, Array(), Array("MODE" => "html", "NAME" => "Телефон"));?>
				</div>
			</div>
			<div class="store_property">
				<div class="title">Email</div>
				<div class="value">
					<?$APPLICATION->IncludeFile(SITE_DIR."include/email.php", Array(), Array("MODE" => "html", "NAME" => "Email"));?>
				</div>
			</div>
			<div class="store_property">
				<div class="title">Режим работы</div>
				<div class="value">
					<?$APPLICATION->IncludeFile(SITE_DIR."include/schedule.php", Array(), Array("MODE" => "html", "NAME" => "Время работы"));?>
				</div>
			</div>
		</div>
		<blockquote><?$APPLICATION->IncludeFile(SITE_DIR."include/contacts_text.php", Array(), Array("MODE" => "html", "NAME" => GetMessage("CONTACTS_TEXT")));?></blockquote>
		<?Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("form-feedback-block");?>
		<?$APPLICATION->IncludeComponent("bitrix:form.result.new", "inline",
			Array(
				"WEB_FORM_ID" => "3",
				"IGNORE_CUSTOM_TEMPLATE" => "N",
				"USE_EXTENDED_ERRORS" => "Y",
				"SEF_MODE" => "N",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600000",
				"LIST_URL" => "",
				"EDIT_URL" => "",
				"SUCCESS_URL" => "?send=ok",
				"CHAIN_ITEM_TEXT" => "",
				"CHAIN_ITEM_LINK" => "",
				"VARIABLE_ALIASES" => Array(
					"WEB_FORM_ID" => "WEB_FORM_ID",
					"RESULT_ID" => "RESULT_ID"
				)
			)
		);?>
		<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("form-feedback-block", "");?>
		<p> * Отправляя данную форму Вы даете свое согласие на <a href = "/obrabotka-personalnykh-dannykh/">обработку персональных данных</a></p>
	</div>
</div>
<div class="clearboth"></div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>