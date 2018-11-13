<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?if( !empty( $arResult ) ){?>
	<ul class="menu top menu_top_catalog catalogfirst visible_on_ready">
		<li class = "gspot"><img src = "/upload/gip.png"></li>
		<?foreach( $arResult as $key => $arItem ){
			if(isset($arItem["PARAMS"]["NOT_VISIBLE"]) && $arItem["PARAMS"]["NOT_VISIBLE"]=="Y")
				continue;?>
			<li class="menu_top_catalog_li <?=($arItem["SELECTED"] ? "current" : "");?> <?=($arItem['PARAMS']['CLASS'] ? $arItem['PARAMS']['CLASS'] : "");?> <?=($arItem["CHILD"] ? "has-child" : "");?>">
				<a class="<?=($arItem["CHILD"] ? "icons_fa parent" : "");?>" href="<?=$arItem["LINK"]?>" ><?=$arItem["TEXT"]?></a>
				<?if($arItem["CHILD"]){?>
					<div class="dropmenu">
            <ul class="inner-menu">
              <?foreach($arItem["CHILD"] as $arChildItem){
                $strImg = '';
                if(intval($arChildItem["PARAMS"]["PICTURE"])>0){
                  $img = CFile::ResizeImageGet($arChildItem["PARAMS"]["PICTURE"], array('width'=>100, 'height'=>100),
                  BX_RESIZE_IMAGE_PROPORTIONAL, false);
                  $strImg = '<a href = "'.$arChildItem["LINK"].'"><img alt="'.$arChildItem["TEXT"].'" src="'.$img['src'].'" /></a>';
                }
                ?>
              	<li class="<?=($arChildItem["CHILD"] ? "has-child" : "");?> <?if($arChildItem["SELECTED"]){?> current <?}?>">
                  <?=$strImg?>
                  <a class="<?=($arChildItem["CHILD"] ? "icons_fa parent" : "");?>" href="<?=$arChildItem["LINK"];?>"><?=$arChildItem["TEXT"];?></a>
                  <?if($arChildItem["CHILD"]){?>
                    <ul class="submenu">
                      <?foreach($arChildItem["CHILD"] as $arChildItem1){?>
                        <li class="<?if($arChildItem1["SELECTED"]){?> current <?}?>">
                          <a href="<?=$arChildItem1["LINK"];?>"><span class="text"><?=$arChildItem1["TEXT"];?></span></a>
                        </li>
                      <?}?>
                    </ul>
                  <?}?>
                </li>
              <?}?>
            </ul>
					</div>
				<?}?>
			</li>
		<?}?>
	</ul>
	<div class="mobile_menu_wrapper">
		<ul class="mobile_menu">
			<?foreach( $arResult as $key => $arItem ){?>
				<li class="icons_fa <?=($arItem["CHILD"] ? "has-child" : "");?> <?=($arItem["SELECTED"] ? "current" : "");?>">
					<a class="dark_link <?=($arItem["CHILD"] ? "parent" : "");?>" href="<?=$arItem["LINK"]?>" ><?=$arItem["TEXT"]?></a>
					<?if($arItem["CHILD"]){?>
						<ul class="dropdown">
							<?foreach($arItem["CHILD"] as $arChildItem){?>
								<li class="full <?if($arChildItem["SELECTED"]){?> current <?}?>">
									<a class="icons_fa <?=($arChildItem["CHILD"] ? "parent" : "");?>" href="<?=($arChildItem["SECTION_PAGE_URL"] ? $arChildItem["SECTION_PAGE_URL"] : $arChildItem["LINK"] );?>"><?=($arChildItem["NAME"] ? $arChildItem["NAME"] : $arChildItem["TEXT"] );?></a>
								</li>
							<?}?>
						</ul>
					<?}?>
				</li>
			<?}?>
			<!--<li class="search">
				<div class="search-input-div">
					<input class="search-input" type="text" autocomplete="off" maxlength="50" size="40" placeholder="<?=GetMessage("CT_BST_SEARCH_BUTTON")?>" value="" name="q">
				</div>
				<div class="search-button-div">
					<button class="button btn-search btn-default" value="<?=GetMessage("CT_BST_SEARCH2_BUTTON")?>" name="s" type="submit"><?=GetMessage("CT_BST_SEARCH2_BUTTON")?></button>
				</div>
			</li>-->
		</ul>
	</div>
<?}?>
