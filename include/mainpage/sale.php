<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<div style = "margin-top: -36px;margin-bottom: 40px;" class="tab_slider_wrapp specials s_EQHgCoksuy mysales best_block clearfix">
	<ul class="tabs_content">
		<li style= "display: block;" class="tab" data-col="4">
			<div class="tabs_slider wr">
				<div class="top_wrapper">
    <div class="catalog_block items salesmain">
<?
  $rsParentSection = CIBlockSection::GetByID(28);
if ($arParentSection = $rsParentSection->GetNext())
{
   $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'ACTIVE'=>'Y','>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
   $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
   while ($arSect = $rsSect->GetNext())
   { //print_r($arSect['SECTION_PAGE_URL']);?>
        <div class="catalog_item_wrapp col-4 item" data-col="4">
            <div class="catalog_item item_wrap">
                <div class="inner_wrap">
                    <div class="image_wrapper_block">
                        <div class="like_icons">

                            <div class="compare_item_button"></div>
                        </div><a href="<? echo $arSect['SECTION_PAGE_URL']; ?>" class="thumb">
	                        <img class="noborder" src="<? echo CFile::GetPath($arSect['PICTURE']); ?>" alt="<? echo $arSect['NAME']; ?>" title="<? echo $arSect['NAME']; ?>"></a>
                    </div>
                </div>
            </div>
        </div>

<?  } 
}  ?>
</div> 
</div>
</div>  
</li>  
</ul>
</div>
</div>

