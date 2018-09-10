<?php

foreach($arResult['GRID']['ROWS'] as $key => $val) {
	$arResult['GRID']['ROWS'][$key]['data']['OLD_PRICE'] = CIBlockElement::GetList(
		array(),
		array(
			"IBLOCK_ID" => 2,
			"ID" => $val['data']['PRODUCT_ID']
		),
		false,
		false,
		array(
			"PROPERTY_OLD_PRICE"
		)
	) -> Fetch();
}