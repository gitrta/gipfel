<?$APPLICATION->IncludeComponent(
	"bitrix:search.title",
	"optimus",
	Array(
		"CATEGORY_0" => array("iblock_aspro_optimus_catalog"),
		"CATEGORY_0_TITLE" => GetMessage("CATEGORY_PRODUСTCS_SEARCH_NAME"),
		"CATEGORY_0_iblock_aspro_optimus_catalog" => array("2"),
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CONTAINER_ID" => "title-search",
		"CONVERT_CURRENCY" => "N",
		"INPUT_ID" => "title-searchs-input",
		"NUM_CATEGORIES" => "1",
		"ORDER" => "date",
		"PAGE" => SITE_DIR."catalog/",
		"PREVIEW_HEIGHT" => "38",
		"PREVIEW_TRUNCATE_LEN" => "50",
		"PREVIEW_WIDTH" => "38",
		"PRICE_CODE" => array("BASE"),
		"PRICE_VAT_INCLUDE" => "Y",
		"SHOW_ANOUNCE" => "N",
		"SHOW_INPUT" => "Y",
		"SHOW_OTHERS" => "N",
		"SHOW_PREVIEW" => "Y",
		"TOP_COUNT" => "5",
		"USE_LANGUAGE_GUESS" => "Y"
	),
false,
Array(
	'ACTIVE_COMPONENT' => 'Y'
)
);?>