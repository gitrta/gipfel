<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="catalog-compare-list">
<?if($_REQUEST['renew']) $APPLICATION->RestartBuffer();?>
<a name="compare_list"></a>
<?if(count($arResult)>0):?>
	<form action="<?=$arParams["COMPARE_URL"]?>" method="get">
	<table class="data-table" width="100%" cellspacing="0" cellpadding="0" border="0">
		<thead>
		<tr>
			<td align="center" colspan="2"><?=GetMessage("CATALOG_COMPARE_ELEMENTS")?></td>
		</tr>
		</thead>
		<?foreach($arResult as $arElement):?>
		<tr>
			<td><input type="hidden" name="ID[]" value="<?=$arElement["ID"]?>" /><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></td>
			<td><noindex><a href="<?=$arElement["DELETE_URL"]?>" rel="nofollow"><?=GetMessage("CATALOG_DELETE")?></a></noindex></td>
		</tr>
		<?endforeach?>
	</table>
	<?if(count($arResult)>=2):?>
		<br /><input type="submit"  class="js-compare" value="<?=GetMessage("CATALOG_COMPARE")?>" />
		<input type="hidden" name="action" value="COMPARE" />
		<input type="hidden" name="IBLOCK_ID" value="<?=$arParams["IBLOCK_ID"]?>" />
	<?endif;?>
	</form>
<?endif;?>
<?if($_REQUEST['renew']) exit;?>
</div>
<script>

$(function(){
	<?foreach($arResult as $arElement):?>
		$("#compare_<?=$arElement['ID']?>").prop("checked",true);
	<?endforeach?>
});


function docompare(ID) {
var id = ID;
if ( $("#compare_"+ID).prop("checked")==true) {
$.ajax({type: 'POST', url: "<?$_SERVER['REQUEST_URL']?>", data: { id: ID, action: "ADD_TO_COMPARE_LIST", renew:1 }, success:function(result){ $(".catalog-compare-list").html(result);
	 $("#compare_"+ID).siblings(".js-c-add").hide();
	 $("#compare_"+ID).siblings(".js-c-added").show();
 }}); //добавить товар к сравнению
} else {
$.ajax({type: 'POST', url: "<?$_SERVER['REQUEST_URL']?>", data: { id: ID, action: "DELETE_FROM_COMPARE_LIST", renew:1 }, success:function(result){ $(".catalog-compare-list").html(result);
	 $("#compare_"+ID).siblings(".js-c-added").hide();
	 $("#compare_"+ID).siblings(".js-c-add").show(); 
 
 } //удаление товара из сравнения
});
}

}
</script>