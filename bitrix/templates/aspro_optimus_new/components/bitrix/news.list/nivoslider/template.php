<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div id="slider" class="nivoSlider">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$cnt++;
	$link = $arItem['PROPERTIES']['LINK']['VALUE'];
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
            <?if($link):?><a href='<?=$link?>'><?endif?>
				<img data-transition1="<?=$cnt%2==0?"sliceDownLeft":"sliceDown"?>" src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" class="nivo-img"/>
            <?if($link):?></a><?endif?>
<?endforeach;?>
</div>
<script type="text/javascript">
$(window).load(function() {
	$('#slider').nivoSlider({
		effect: 'fade',               // Specify sets like: 'fold,fade,sliceDown'
		slices: 15,                     // For slice animations
		boxCols: 12,                     // For box animations
		boxRows: 8,                     // For box animations
		animSpeed: 500,                 // Slide transition speed
		pauseTime: 5000,                // How long each slide will show
		startSlide: 0,                  // Set starting Slide (0 index)
		directionNav: true,             // Next & Prev navigation
		controlNav: true,               // 1,2,3... navigation
		controlNavThumbs: false,        // Use thumbnails for Control Nav
		pauseOnHover: true,             // Stop animation while hovering
		manualAdvance: false,           // Force manual transitions
		prevText: 'Prev',               // Prev directionNav text
		nextText: 'Next',               // Next directionNav text
		randomStart: false,             // Start on a random slide
		beforeChange: function(){},     // Triggers before a slide transition
		afterChange: function(){},      // Triggers after a slide transition
		slideshowEnd: function(){},     // Triggers after all slides have been shown
		lastSlide: function(){},        // Triggers when last slide is shown
		afterLoad: function(){}         // Triggers when slider has loaded
	});
});
</script>