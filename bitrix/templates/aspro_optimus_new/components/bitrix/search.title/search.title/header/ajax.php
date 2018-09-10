<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$phr = array();
if (!CModule::IncludeModule("iblock"))
{
    exit;
}

  if($_REQUEST["q"])
  {
	  $zapros = $_REQUEST["q"];
  }
/*
  if(CModule::IncludeModule("search"))
  {
	   $dbStatistic = CSearchStatistic::GetList(array("RESULT_COUNT"=>"DESC"),array("PHRASE"=>$zapros."%"),false);
	   $dbStatistic->NavStart(1000);
	   while($arStatistic = $dbStatistic->Fetch())
	   {

		  $phr[] = $arStatistic["PHRASE"];

	   }
  }

   $i=0;
   $phr = array_map('strtolower', $phr);
   $phrase = array_unique($phr);


    if(count($phrase)>0){
	echo "<div>что искали другие:</div>";
    }
 	foreach($phrase as $ph)
	{
		if($i<9){
	     echo '<div class="strok">'.$ph.'</div>';
	     $i++;
		}
	} 
*/
if(mb_strlen($zapros)>2)
{

    $arFilter["NAME"] = "%".$zapros."%";
    $arFilter["IBLOCK_ID"] = 2;
    $arGroupBy = array("NAME");

    $arSelect = array(
        "ID",
        "NAME",
		"IBLOCK_ID",
		"DETAIL_PAGE_URL",
    );
    $arNav = array(
        "nPageSize" => 3,
    );

    $arGroupBy = array("NAME");

    $db_list = CIBlockSection::GetList(Array("NAME" => "ASC"), $arFilter);
    $result = array();
    while ($ar_result = $db_list->GetNext())
    {
        $result2[] = $ar_result;
    }


    $arFilter["NAME"] = "%".$zapros."%";
    $arFilter["IBLOCK_ID"] = 2;
    $arGroupBy = array("NAME");

    $arSelect = array(
        "ID",
        "NAME",
		"IBLOCK_ID",
		"DETAIL_PAGE_URL",
		"PREVIEW_PICTURE",
		"CATALOG_GROUP_1"
    );
    $arNav = array(
        "nPageSize" => 6,
    );

    $arGroupBy = array("NAME");

    $db_list = CIBlockElement::GetList(Array("NAME" => "ASC"), $arFilter, false, $arNav, $arSelect);
    $result = array();
    while ($ar_result = $db_list->GetNext())
    {
        $result[] = $ar_result;
    }
    if(count($result)>0)
	{
	//echo "<div>быстрый поиск:</div>";
    }
	else{
	echo "<div>быстрый поиск: 0 товаров найдено</div>";
	}
	
    if(count($result2)>0){
	echo "группы:";
	}
	foreach($result2 as $group)
	{
    ?>
    <div class="strok_tov" style="font-size:16px;">
	 <a href="<?=$group["SECTION_PAGE_URL"]?>"><?=$group["NAME"]?></a>
	</div>	
	<?
    }


	echo "<br>товары:";	
	foreach($result as $tovar)
	{
	?>
    <div class="strok_tov">
		<div style="float:left;width:55px;min-height:50px;">	 
	<?
	  if($tovar["PREVIEW_PICTURE"])
	  {
	  	$url = CFile::GetPath($tovar["PREVIEW_PICTURE"]);
	  ?>
	  <img src="<?=$url?>" width="50" />
	  <?
	  }
	?>
	 </div>
	 <div style="float:left;max-width:275px;">
	 <a href="<?=$tovar["DETAIL_PAGE_URL"]?>"><?=$tovar["NAME"]?></a>
	 <div style="font-weight: 600;line-height: 15px;font-size:16px;"><?=$tovar["CATALOG_PRICE_1"]?> руб.</div>

	 </div>
	 <div style="clear: both;"></div>
	</div>
	   
	<?
	}
 }
?>
<?
if(!empty($arResult["CATEGORIES"])):?>
	<table class="title-search-result">
		<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
			<tr>
				<th class="title-search-separator">&nbsp;</th>
				<td class="title-search-separator">&nbsp;</td>
			</tr>
			<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
			<tr>
				<?if($i == 0):?>
					<th>&nbsp;<?echo $arCategory["TITLE"]?></th>
				<?else:?>
					<th>&nbsp;</th>
				<?endif?>

				<?if($category_id === "all"):?>
					<td class="title-search-all"><a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></td>
				<?elseif(isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]])):
					$arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];
				?>
					<td class="title-search-item"><a href="<?echo $arItem["URL"]?>"><?
						if (is_array($arElement["PICTURE"])):?>
							<img align="left" src="<?echo $arElement["PICTURE"]["src"]?>" width="<?echo $arElement["PICTURE"]["width"]?>" height="<?echo $arElement["PICTURE"]["height"]?>">
						<?endif;?><?echo $arItem["NAME"]?></a>
						<p class="title-search-preview"><?echo $arElement["PREVIEW_TEXT"];?></p>
						<?foreach($arElement["PRICES"] as $code=>$arPrice):?>
							<?if($arPrice["CAN_ACCESS"]):?>
								<p class="title-search-price"><?=$arResult["PRICES"][$code]["TITLE"];?>:&nbsp;&nbsp;
								<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
									<s><?=$arPrice["PRINT_VALUE"]?></s> <span class="catalog-price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span>
								<?else:?><span class="catalog-price"><?=$arPrice["PRINT_VALUE"]?></span><?endif;?>
								</p>
							<?endif;?>
						<?endforeach;?>
					</td>
				<?elseif(isset($arItem["ICON"])):?>
					<td class="title-search-item"><a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></td>
				<?else:?>
					<td class="title-search-more"><a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></td>
				<?endif;?>
			</tr>
			<?endforeach;?>
		<?endforeach;?>
		<tr>
			<th class="title-search-separator">&nbsp;</th>
			<td class="title-search-separator">&nbsp;</td>
		</tr>
	</table><div class="title-search-fader"></div>
<?endif;
?>