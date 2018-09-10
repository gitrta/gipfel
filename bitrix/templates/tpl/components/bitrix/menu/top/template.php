<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);

if (empty($arResult["ALL_ITEMS"]))
	return;

if (file_exists($_SERVER["DOCUMENT_ROOT"].$this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css'))
	$APPLICATION->SetAdditionalCSS($this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css');

$menuBlockId = "catalog_menu_".$this->randString();
?>
    <nav>
        <div class="wrapper" id="<?=$menuBlockId?>">
            <ul class="menu" id="ul_<?=$menuBlockId?>">
	<?foreach($arResult["MENU_STRUCTURE"] as $itemID => $arColumns): $cnt++?>     <!-- first level-->
		<li class="menu_item <?if($cnt==2):?>first <?endif?><?if($arResult["ALL_ITEMS"][$itemID]["SELECTED"]):?>current selected<?endif?><?if ((is_array($arColumns) && count($arColumns) > 0) || $cnt==1):?> catalog_menu<?endif?>">
			<a href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>"  <?if (is_array($arColumns) && count($arColumns) > 0 && $existPictureDescColomn):?>onmouseover="menuCatalogChangeSectionPicure(this);"<?endif?>>
				<?=$arResult["ALL_ITEMS"][$itemID]["TEXT"]?>
			</a>
		<?if (is_array($arColumns) && count($arColumns) > 0):?>
				<ul class="cathegories menu_inner">			
				<?foreach($arColumns as $key=>$arRow):?>

					<?foreach($arRow as $itemIdLevel_2=>$arLevel_3):?>  <!-- second level-->
						<li class="parent">
							<a href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>">
								<div class="cathegories_image">
									<img src="<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["PARAMS"]["picture_src"]?>" alt="">
								</div>							
								<div class="cathegories_title"><?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["TEXT"]?></div>
							</a>
						
						</li>			
					
					<?endforeach;?>
				<?endforeach;?>
				</ul>
		<?endif?>
		</li>
	<?endforeach;?>
	</ul>
	</div>
</nav>

<script>
	window.catalogMenuFirstWidth_<?=$menuBlockId?> = 0;

	BX.ready(function () {
		window.catalogMenuFirstWidth_<?=$menuBlockId?> = menuCatalogResize("<?=$menuBlockId?>") + 20;
		if (window.catalogMenuFirstWidth_<?=$menuBlockId?> > 640)
			menuCatalogAlign("<?=$menuBlockId?>");
		else
			menuCatalogPadding("<?=$menuBlockId?>");

		menuCatalogResize("<?=$menuBlockId?>", window.catalogMenuFirstWidth_<?=$menuBlockId?>);

		if (!window.catalogMenuIDs)
			window.catalogMenuIDs = [{'<?=$menuBlockId?>' : window.catalogMenuFirstWidth_<?=$menuBlockId?>}];
		else
			window.catalogMenuIDs.push({'<?=$menuBlockId?>' : window.catalogMenuFirstWidth_<?=$menuBlockId?>});
	});
</script>