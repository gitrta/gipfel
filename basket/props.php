<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	$arResult["ORDER_PROPS_PRINT"] = Array();
		$propertyGroupID = -1;
		$arResult["PERSON_TYPE"] = $_GET['ID'];
		$arFilter = array("PERSON_TYPE_ID" => $arResult["PERSON_TYPE"], "ACTIVE" => "Y", "UTIL" => "N");
		if(!empty($arParams["PROP_".$arResult["PERSON_TYPE"]]))
			$arFilter["!ID"] = $arParams["PROP_".$arResult["PERSON_TYPE"]];

		$dbProperties = CSaleOrderProps::GetList(
				array(
						"GROUP_SORT" => "ASC",
						"PROPS_GROUP_ID" => "ASC",
						"SORT" => "ASC",
						"NAME" => "ASC"
					),
				$arFilter,
				false,
				false,
				array()
			);
		global $DB;
		$relat='';
		while ($arProperties = $dbProperties->GetNext())
		{	
			$n=array();
			$res2 = $DB->Query("SELECT * FROM  `b_sale_order_props_relation` where PROPERTY_ID='".$arProperties['ID']."' AND ENTITY_TYPE = 'D' ", false, $err_mess.__LINE__);
			while($r = $res2->Fetch()){
				//print_r($arProperties['ID']);
				if (!empty($r)) {
					array_push($n, $r['ENTITY_ID']);
					$relat[$arProperties['ID']] = $n;	
					}
			}
			
			if (IntVal($arProperties["PROPS_GROUP_ID"]) != $propertyGroupID)
			{
				$arProperties["SHOW_GROUP_NAME"] = "Y";
				$propertyGroupID = $arProperties["PROPS_GROUP_ID"];
			}
			$curVal = $arResult["POST"]["ORDER_PROP_".$arProperties["ID"]];
			if ($arProperties["TYPE"] == "CHECKBOX")
			{
				if ($curVal == "Y")
					$arProperties["VALUE_FORMATED"] = GetMessage("SALE_YES");
				else
					$arProperties["VALUE_FORMATED"] = GetMessage("SALE_NO");
			}
			elseif ($arProperties["TYPE"] == "TEXT" || $arProperties["TYPE"] == "TEXTAREA")
			{
				$arProperties["VALUE_FORMATED"] = $curVal;
			}
			elseif ($arProperties["TYPE"] == "SELECT" || $arProperties["TYPE"] == "RADIO")
			{
				$arVal = CSaleOrderPropsVariant::GetByValue($arProperties["ID"], $curVal);
				$arProperties["VALUE_FORMATED"] = htmlspecialcharsEx($arVal["NAME"]);
			}
			elseif ($arProperties["TYPE"] == "MULTISELECT")
			{
				$countCurVal = count($curVal);
				for ($i = 0; $i < $countCurVal; $i++)
				{
					$arVal = CSaleOrderPropsVariant::GetByValue($arProperties["ID"], $curVal[$i]);
					if ($i > 0)
						$arProperties["VALUE_FORMATED"] .= ", ";
					$arProperties["VALUE_FORMATED"] .= htmlspecialcharsEx($arVal["NAME"]);
				}
			}
			elseif ($arProperties["TYPE"] == "LOCATION")
			{
				$arVal = CSaleLocation::GetByID($curVal, LANGUAGE_ID);
				/*
				$arProperties["VALUE_FORMATED"] = htmlspecialcharsEx($arVal["COUNTRY_NAME"]);
				if (strlen($arVal["COUNTRY_NAME"]) > 0 && strlen($arVal["CITY_NAME"]) > 0)
					$arProperties["VALUE_FORMATED"] .= " - ";
				$arProperties["VALUE_FORMATED"] .= htmlspecialcharsEx($arVal["CITY_NAME"]);
				*/

				$locationName = "";

				if(CSaleLocation::isLocationProMigrated())
				{
					if(intval($arVal['ID']))
						$locationName = \Bitrix\Sale\Location\Admin\LocationHelper::getLocationStringById($arVal['ID']);
				}
				else
				{
					$locationName .= ((strlen($arVal["COUNTRY_NAME"])<=0) ? "" : $arVal["COUNTRY_NAME"]);

					if (strlen($arVal["COUNTRY_NAME"])>0 && strlen($arVal["REGION_NAME"])>0)
						$locationName .= " - ".$arVal["REGION_NAME"];
					elseif (strlen($arVal["REGION_NAME"])>0)
						$locationName .= $arVal["REGION_NAME"];

					if (strlen($arVal["COUNTRY_NAME"])>0 || strlen($arVal["REGION_NAME"])>0)
						$locationName .= " - ".$arVal["CITY_NAME"];
					elseif (strlen($arVal["CITY_NAME"])>0)
						$locationName .= $arVal["CITY_NAME"];
				}

				$arProperties["VALUE_FORMATED"] .= htmlspecialcharsEx($locationName);
			}
			$arResult["ORDER_PROPS_PRINT"][] = $arProperties;
		}
		$c = 0;
		global $USER;
		/*$arResult["ORDER_PROPS_PRINT_ALEX"] = array();
		foreach ($arResult["ORDER_PROPS_PRINT"] as $item){
			foreach ($relat as $key=>$val){
				if ($item['ID']==$key){
					if(in_array($_GET['del_id'], $val)){
						array_push($arResult["ORDER_PROPS_PRINT_ALEX"],$item);
						$item['ALEX_DELID']=$_GET['del_id'];
						print_r($val);
					} else{
						$item['ALEX_DELID']='Y';
					}
				}
			}
		}*/
		foreach ($arResult["ORDER_PROPS_PRINT"] as $item){
			$item['ALEX_DELID'] = array();
			foreach ($relat as $key=>$val){
				if ($item['ID']==$key){
					if(in_array($_GET['del_id'], $val)){
						//array_push($arResult["ORDER_PROPS_PRINT_ALEX"],$item);
						$item['ALEX_DELID']="Y";
						//print_r($val);
					} else{
						$item['ALEX_DELID']='N';
					}
				}
			}
			//print_r($item['ALEX_DELID'].'|'.$item['NAME']."\r\n");
			$tp=0;
			if ($item['ID']!=='6' && $item['ID']!=='5'): $c++;
			if ($item['ALEX_DELID']!=='N'){
			if ($c<=4):
			if ($c==1) echo '<div class = "half">';
			?>
			<div class = "rowalex"><span class = "lrow"><label for = "<?=$item['CODE'].'_'.$item['ID']?>"><?=$item['NAME']?></label><?if ($item['REQUIED']=='Y'){?> <span class="sof-req">*</span> <br><?} ?></span>
			<input value = "<? if ($item['CODE']=='PHONE') {$arUser = CUser::GetByID($USER->GetID())->Fetch(); echo $arUser['PERSONAL_PHONE'];} /*echo !empty($USER->GetParam($item['CODE']))?$USER->GetParam($item['CODE']):'';*/ ?>" <? if ($item['REQUIED']=='Y'){?>required<?} ?> id = "<?=$item['CODE'].'_'.$item['ID']?>" type = "text" name = "<?=$item['CODE']?>"></div>
			<? 
				if ($c==4) echo '</div><div class = "fullman">';
				endif;
			
			if ($c>4 && $item['TYPE']=='TEXT'):
			?>
			<div class = "another pr_<?=$c?>"><span class = "lrow"><label for = "<?=$item['CODE'].'_'.$item['ID']?>"><?=$item['NAME']?></label><?if ($item['REQUIED']=='Y'){?> <span class="sof-req">*</span> </span><br><?} ?>
			<input <? if ($item['CODE']=='ADDRESS_PVZ') {?>placeholder = "нажмите для выбора" <? } ?> <?if ($item['REQUIED']=='Y'){?>required<?} ?> id = "<?=$item['CODE'].'_'.$item['ID']?>" type = "text" name = "<?=$item['CODE']?>"></div>
			<? 
			endif;
			if ($item['TYPE']=='DATE'):
			$tp++;
			if ($tp==1) echo '</div>';
			?><div style = "clear:left"><span class = "lrow"><label class = "timed" for = "<?=$item['CODE']?>"><?=$item['NAME']?></label></span></div>
			<!--<input type="text" name="<?=$item['CODE']?>" id="<?=$item['CODE']?>" size="15" value="<?= date("d.m.Y", strtotime("+1 day"));?>" class="soa-property-container input-group">-->
			<?
			echo CalendarDate("".$item['CODE']."", "".date("d.m.Y", strtotime("+1 day"))."", "order_alex", "15", "class=\"soa-property-container input-group\"");
			//echo Calendar("F_DATE", "order_alex");
			endif;
			if ($item['TYPE']=='RADIO'):
			
			$arVal1 = CSaleOrderPropsVariant::GetByValue($item['ID'], 1);
			$arVal2 = CSaleOrderPropsVariant::GetByValue($item['ID'], 2);
			?>
			<div class = "selects" ><label class = "timed" ><?=$item['NAME']?></label><?if ($item['REQUIED']=='Y'){?> <span class="sof-req">*</span><?} ?>
			<input class = "radio" <?if ($item['REQUIED']=='Y'){?>required<?} ?> id = "<?=$item['CODE'].'_'.$arVal1['VALUE']?>" checked type = "radio" name = "<?=$item['CODE'];?>" value = "<?=$arVal1['VALUE']?>"><label for = "<?=$item['CODE'].'_'.$arVal1['VALUE']?>">с 10-00 до 17-00</label><br>
			<input class = "radio" <?if ($item['REQUIED']=='Y'){?>required<?} ?> id = "<?=$item['CODE'].'_'.$arVal2['VALUE']?>" type = "radio" name = "<?=$item['CODE'];?>" value = "<?=$arVal2['VALUE']?>"><label for = "<?=$item['CODE'].'_'.$arVal2['VALUE']?>">с 17-00 до 22-00</label>
			</div>
			<? endif;
				}
				endif;
				
		}
		?>
		<br>
		<label for = "comzak">Комментарий к заказу</label>
		<textarea id = "comzak" name ="comzak"></textarea>
		<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");