<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
global $APPLICATION;
if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateData['TEMPLATE_THEME']);
}
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/jqzoom-master/css/jquery.jqzoom.css");
$APPLICATION->AddHeadString('<script src="'.SITE_TEMPLATE_PATH.'/jqzoom-master/js/jquery.jqzoom-core.js" type="text/javascript"></script>

<script type="text/javascript">

$(document).ready(function() {
	$(".jqzoom").jqzoom({
            zoomType: "standard",
            lens:true,
            preloadImages: false,
            alwaysOn:false,
	    zoomWidth: 305,
            zoomHeight: 305
        });
	
});


</script>

');
if (isset($templateData['JS_OBJ']))
{
?>
<script type="text/javascript">
BX.ready(
	BX.defer(function(){
		if (!!window.<? echo $templateData['JS_OBJ']; ?>)
		{
			window.<? echo $templateData['JS_OBJ']; ?>.allowViewedCount(true);
		}
	})
);
</script>
<?
}
$file = $_SERVER['DOCUMENT_ROOT']."/watching.now";
$all = file($file);
if (count($all)>9) unset($all[0]);
if (!in_array($arResult['ID'],$all)) {
	foreach ($all as $k=>$v) if($v>0 && $arResult['ID']!=$v) $to[]=intval($v);
	$to[] = $arResult['ID'];
	$to = array_unique($to);
	$fp = fopen($file,"w");
	fwrite($fp,join("\n",$to));
	fclose($fp);
}

// вы смотрели
$arViewed = unserialize($APPLICATION->get_cookie("VIEWED"));
if (!in_array($arResult['ID'],$arViewed)) {
	if(count($arViewed)>10) array_shift($arViewed);
	$arViewed[]=$arResult['ID'];
}
$APPLICATION->set_cookie("VIEWED",serialize($arViewed));


?>