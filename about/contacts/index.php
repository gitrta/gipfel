<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Задайте вопрос");
?><h1 class="product_title"><?$APPLICATION->ShowTitle(1)?></h1>
<div class="bx_page">
<p>
 <b>Телефон:</b> <a href="tel:+74952221515"> +7 (495) 222-15-15<br>
 </a> 
	</p>
	<table border="1" cellspacing="2" cellpadding="2">
	<tbody>
	<tr>
		<td>
			<p>
				 Наименование организации
			</p>
		</td>
		<td>
			<p>
				 ООО «ФОРИНТ»
			</p>
		</td>
	</tr>
	<tr>
		<td>
			<p>
				 ИНН/КПП
			</p>
		</td>
		<td>
			<p>
				 7733270699/773301001
			</p>
		</td>
	</tr>
	<tr>
		<td>
			<p>
				 ОГРН/Дата регистрации
			</p>
		</td>
		<td>
			<p>
				 1167746171702 /от 16.02.2016 г.
			</p>
		</td>
	</tr>
	<tr>
		<td>
			<p>
				 Юридический адрес
			</p>
		</td>
		<td>
			<p>
				 125363, г. Москва, Цветочный проезд, д. 13А, стр. 2
			</p>
		</td>
	</tr>
	</tbody>
	</table>
	<p>
 <br>
	</p>
	<p>
	</p>
	<h2>Задать вопрос</h2>
</div>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback",
	"eshop_adapt",
	Array(
		"EMAIL_TO" => "sale@gipfel",
		"EVENT_MESSAGE_ID" => array(),
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"REQUIRED_FIELDS" => array(),
		"USE_CAPTCHA" => "Y"
	)
);?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>