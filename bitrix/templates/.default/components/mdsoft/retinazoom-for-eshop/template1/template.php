<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<span class="bx_bigimages_aligner">
<a rel='gal1' href="<? echo $arFirstPhoto['SRC']; ?>" class="jqzoom">
<img id="<?=$arParams['IMAGE_ID']; ?>" class="a" src="<?= $arParams['ELEMENT_URL']; ?>" alt="<?= $arParams['IMAGE_ALT']; ?>" title="<?= $arParams['IMAGE_TITLE']; ?>" itemprop="image" width="<?= $arParams['IMAGE_WIDTH']; ?>" height="<?= $arParams['IMAGE_HEIGHT']; ?>"/>
</a>
</span>


<script type="text/javascript">
	$(function(){
	$('#<?=$arParams['IMAGE_ID']; ?>').zoome({hoverEf:'',showZoomState:true,defaultZoom:<?=$arParams['ZOOM']?>,magnifierSize:[<?=$arParams["BOX_SIZE"];?>,<?=$arParams["BOX_SIZE"];?>]});
});
	function destroyZoome(obj){
		if(obj.parent().hasClass('zm-wrap'))
		{
			obj.unwrap().next().remove();
		}
	}
</script>	