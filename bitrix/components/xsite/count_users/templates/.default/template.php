<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$this->setFrameMode(true);
 // echo "<pre>"; print_r($arResult); echo "</pre>";


$u = count($arResult["USERS_AUTH"]);
$g = count($arResult["USERS"]);
/*$u = ($u?$u:1)*2;
$g = ($g?$g:1)*9;*/
$u = ($g?$g:1)*2;
$g = ($g?$g:1)*9;
if (count($arResult["ONLINE"])<$u) {
	$cnt=-1;
	$input = array("Neo", "Morpheus", "Trinity", "Cypher", "Tank","Rabbit","Snick","T00$$a","sexhxer","CBUHKC");
	$rand_keys = array_rand($input, ($u-count($arResult["ONLINE"])));
	for ($i=count($arResult["ONLINE"]); $i<$u; $i++) {
		$cnt++;
		$arResult['ONLINE'][] = array("LOGIN"=>$input[$cnt]);
	}
}
?>

                    <div class="catalog_left_block">
                        <div class="catalog_left_block_title">
                            Сейчас на сайте
                        </div>
                        <div class="catalog_left_block_content">
                            <div class="catalog_left_block_content_online">
                                Сейчас на сайте <strong><?=$u;?></strong> <?=plural_form($u,array("пользователь","пользователя","пользователей"))?> <br/>и <strong><?=$g?></strong> <?=plural_form($g,array('гость','гостя','гостей'))?>
                            </div>
                            <div class="filter_title">Пользователи на сайте</div>
                            <?if($arResult["ONLINE"]):?><div class="filter_content">
                                <ul class="users_online">
								<?foreach($arResult["ONLINE"] as $v):$cnt++;if ($cnt>10) break;?>
                                    <li><?=$v['LOGIN']?></li>
								<?endforeach?>
                                </ul>
                            </div> <?endif?>
                        </div>                        
                    </div>