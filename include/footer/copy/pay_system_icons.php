<i title="MasterCard" class="mastercard"></i>
<i title="Maestro" class="maestro"></i>
<i title="Visa" class="visa"></i>
<i title="МИР" class="mir"></i>

<?php if($_SERVER['HTTP_HOST'] == 'gipfel.ru' || $_SERVER['HTTP_HOST'] == 'gipfel.ua') { ?>	


<p style="
    font-weight: bold;
    text-transform: uppercase;
    color: #1d2029 !important;
    margin-bottom: 2px;
">Доставка по РФ:</p>
<ul class="wedel">
	<li>Курьерская служба</li>
	<li>СДЭК</li>
	<li>DALLI Service</li>
	<li>Наши курьеры</li>
</ul>




<?php } else if($_SERVER['HTTP_HOST'] == 'gipfel.kz') {?>    

<p style="
    font-weight: bold;
    text-transform: uppercase;
    color: #1d2029 !important;
    margin-bottom: 2px;
">Доставка по KZ:</p>
<ul class="wedel">
    <li>СДЭК</li>
</ul>





<?php } else {?>	

<p style="
    font-weight: bold;
    text-transform: uppercase;
    color: #1d2029 !important;
    margin-bottom: 2px;
">Доставка по РФ:</p>
<ul class="wedel">
	<li>СДЭК</li>
</ul>






<?}?>	




<!--<i title="Yandex" class="yandex_money"></i>
<i title="WebMoney" class="webmoney"></i>
<i title="Qiwi" class="qiwi"></i>-->