<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<h2>Посуда «Гипфел»: каталог официального сайта</h2>
<p>Продукция Gipfel славится отменным качеством и идеальным стилем. Если вы желаете выгодно приобрести изделия этого немецкого бренда, приглашаем ознакомиться с каталогом официального сайта «Гипфел». У нас представлен широкий ассортимент кухонной утвари разного назначения. Здесь могут найти все необходимое и хозяйки, и профессиональные повара, и компании, предоставляющие услуги в сфере гостеприимства.</p>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"sections_list_custom",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
		"SHOW_SECTIONS_LIST_PREVIEW" => $arParams["SHOW_SECTIONS_LIST_PREVIEW"],
		"SECTIONS_LIST_PREVIEW_PROPERTY" => $arParams["SECTIONS_LIST_PREVIEW_PROPERTY"],
		"SECTIONS_LIST_PREVIEW_DESCRIPTION" => $arParams["SECTIONS_LIST_PREVIEW_DESCRIPTION"],
		"SHOW_SECTION_LIST_PICTURES" => $arParams["SHOW_SECTION_LIST_PICTURES"],
		"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],		
	),
	$component
);?>
<h2>Что мы предлагаем</h2>
<p>Посуда «Гипфел» каталога официального сайта, — это сертифицированные изделия. Они выполнены из высокотехнологичных материалов: чугуна, термостойкого пластика, нержавеющей стали.</p>
<p>Каждое из них отличается такими преимуществами:</p>
<ul>
 <li>способность сохранять полезные свойства и вкусовые качества продуктов;</li>
 <li>возможность использования с разными видами плит — обычными газовыми, электрическими, индукционными, сенсорными;</li>
 <li>устойчивость к повреждениям, длительный срок службы (несколько десятилетий);</li>
 <li>экологическая безопасность, гипоаллергенность;</li>
 <li>разнообразие моделей — можно найти как бюджетные варианты, так и посуду категории делюкс;</li>
 <li>презентабельный вид — кухонные принадлежности данного бренда станут достойным украшением любого интерьера.</li>
</ul>
<br>
<h3>Разделы каталога</h3>
<p>Для удобства пользования каталогом официального сайта «Гипфел» мы объединили товары по категориям:</p>
<ul>
 <li>наборы посуды;</li>
 <li>посуда для приготовления (кастрюли и ковши, все для жарки, тушения и запекания, заваривания чая и кофе);</li>
 <li>кухонный инвентарь (принадлежности повара, инструменты, соковыжималки и другое);</li>
 <li>посуда для хранения продуктов, в том числе в путешествии;</li>
 <li>все для сервировки стола.</li>
</ul>
<p>Кроме того, у нас вы можете ознакомиться с новинками ассортимента, а также с действующими скидками на товары. Оптимальный выбор поможет удобная система фильтрации товара по диаметру, высоте стенок, объему, наличию антипригарного покрытия и другим параметрам.</p>
