<?php

/*			$poakcii=0;
				$mincen=0;
				$mcen =100000;
				
				foreach ($arResult["GRID"]["ROWS"] as $k => $arItem){
								
				
                    $arSelect = Array("ID", "NAME", "PROPERTY_AKCII");
				
					$rs = CIBlockElement::GetList (
					   Array("RAND" => "ASC"),
					   Array("IBLOCK_ID" => 2,"ID" => $arItem["PRODUCT_ID"]),
					   false,
					   false,
					   $arSelect
					);
									 
					while($ob = $rs->GetNextElement())
					{
					 $arFields = $ob->GetFields();
					  if($arFields['PROPERTY_AKCII_VALUE']=="Акция 1+1")
					  {
					   $poakcii++;
					   if($arItem["PRICE"]<$mcen)
					    {
						 $mcen = $arItem["PRICE"];
						 $mincid = $arItem;
						}
					  
					  }
					}	
								
				}


				//pre($poakcii);
				
				
	if($poakcii>2)
    {
	 CSaleBasket::Delete($mincid["ID"]);
	 	 
	  $arFields = array(
		"PRODUCT_ID" => $mincid["PRODUCT_ID"],
		"PRODUCT_PRICE_ID" => 0,
		"PRICE" => 0,
		"CURRENCY" => "RUB",
		"WEIGHT" => 0,
		"QUANTITY" => 1,
		"LID" => LANG,
		"DELAY" => "N",
		"CAN_BUY" => "Y",
		"NAME" => $mincid["NAME"],
		"CALLBACK_FUNC" => "",
		"MODULE" => "my_module",
		"NOTES" => "",
		"ORDER_CALLBACK_FUNC" => "",
		"DETAIL_PAGE_URL" => $mincid["DETAIL_PAGE_URL"]
	  );


	  CSaleBasket::Add($arFields);	 	 

	}	

*/

foreach($arResult["GRID"]["ROWS"] as $key => $val) {
	$arResult["GRID"]["ROWS"][$key]['OLD_PRICE'] = CIBlockElement::GetList(
		array(),
		array(
			"IBLOCK_ID" => 2,
			"ID" => $val['PRODUCT_ID']
		),
		false,
		false,
		array(
			"PROPERTY_OLD_PRICE",
            "PROPERTY_NOVINKA",
            "PROPERTY_AKCII",
		)
	) -> Fetch();
}