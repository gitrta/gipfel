<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
/*$el = new CIBlockElement;



*/
if ($_POST['NAME']!=''&&$_POST['EMAIL']!=''&&$_POST['PREVIEW_TEXT']!='')
{
CModule::IncludeModule("iblock");
$el = new CIBlockElement;
$PROP[47]=$_POST['EMAIL'];
$arLoadProductArray = Array(
  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
  "IBLOCK_ID"      => 9,
  "PROPERTY_VALUES"=> $PROP,
  "NAME"           => $_POST['NAME'],
  "ACTIVE"         => "N",            // активен
  "PREVIEW_TEXT"   => $_POST['PREVIEW_TEXT']
  );

if($PRODUCT_ID = $el->Add($arLoadProductArray))
  echo "<p><font class='notetext'>Отзыв добавлен и появится после проверки модератором.</font></p>";
else
	echo "<p data-error='1' style='color:#990000;'>Error: ".$el->LAST_ERROR.'</p>';

}
?>