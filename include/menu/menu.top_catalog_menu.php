<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"top_catalog_multilevel", 
	array(
		"ROOT_MENU_TYPE" => "top_catalog_multilevel",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "1",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "top_catalog_multilevel",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
