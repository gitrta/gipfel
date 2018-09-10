<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?><div id="komposit_frame"><?
$frame = $this->createFrame("komposit_frame", false)->begin();

if ($arResult["READY"]="Y" || $arResult["DELAY"]=="Y" || $arResult["NOTAVAIL"]=="Y" || $arResult["SUBSCRIBE"]=="Y")
{
?><?
	if ($arResult["READY"]="Y")
	{
		?><?
		$qty=0;
		$sum=0;
		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["DELAY"]=="N" && $v["CAN_BUY"]=="Y")
			{
			 	$qty+=$v["QUANTITY"];
				$sum+=$v["QUANTITY"]*$v["PRICE"];
				/*?><?
				if ('' != $v["DETAIL_PAGE_URL"])
				{
					?><a href="<?echo $v["DETAIL_PAGE_URL"]; ?>"><b><?echo $v["NAME"]?></b></a><?
				}
				else
				{
					?><b><?echo $v["NAME"]?></b><?
				}
				?>
				<?= GetMessage("TSBS_PRICE") ?>&nbsp;<b><?echo $v["PRICE_FORMATED"]?></b><br />
				<?= GetMessage("TSBS_QUANTITY") ?>&nbsp;<?echo $v["QUANTITY"]?>
				
				<?*/
			}
		}
		if (isset($v))
			unset($v);
		?>
                    <div class="cart_top js-link" data-href="<?=$arParams["PATH_TO_BASKET"]?>">                    
                        <div class="cart_block_title">Ваша корзина:</div>
                        <div class="cart_block_price"><span><?=number_format($sum,0,""," ")?></span> руб.</div>  
                    </div>
                    <div class="cart_block_mid js-link" data-href="<?=$arParams["PATH_TO_BASKET"]?>">
                        <div class="cart_block_link"><a href="<?= $arParams["PATH_TO_ORDER"] ?>">оформить заказ</a></div>
                        <div class="cart_block_count"><a href="<?=$arParams["PATH_TO_BASKET"]?>"><?=$qty?></a></div>
                    </div>
                    <div class="cart_block_bottom js-link" data-href="<?=$arParams["PATH_TO_ORDER"]?>">
                        Ваши Товары в Корзине!
                    </div>
		<?
		if ('' != $arParams["PATH_TO_BASKET0"])
		{
			?><form method="get" action="<?=$arParams["PATH_TO_BASKET"]?>">
			<input type="submit" value="<?= GetMessage("TSBS_2BASKET") ?>">
			</form><?
		}
		if ('' != $arParams["PATH_TO_ORDER0"])
		{
			?><form method="get" action="<?= $arParams["PATH_TO_ORDER"] ?>">
			<input type="submit" value="<?= GetMessage("TSBS_2ORDER") ?>">
			</form><?
		}
	}
	if ($arResult["DELAY"]=="Y" && 0)
	{
		?><tr><td align="center"><?= GetMessage("TSBS_DELAY") ?></td></tr>
		<tr><td><ul>
		<?
		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["DELAY"]=="Y" && $v["CAN_BUY"]=="Y")
			{
				?><li><?
				if ('' != $v["DETAIL_PAGE_URL"])
				{
					?><a href="<?echo $v["DETAIL_PAGE_URL"] ?>"><b><?echo $v["NAME"]?></b></a><?
				}
				else
				{
					?><b><?echo $v["NAME"]?></b><?
				}
				?><br />
				<?= GetMessage("TSBS_PRICE") ?>&nbsp;<b><?echo $v["PRICE_FORMATED"]?></b><br />
				<?= GetMessage("TSBS_QUANTITY") ?>&nbsp;<?echo $v["QUANTITY"]?>
				</li>
				<?
			}
		}
		if (isset($v))
			unset($v);
		?></ul></td></tr><?
		if ('' != $arParams["PATH_TO_BASKET"])
		{
			?><tr><td><form method="get" action="<?=$arParams["PATH_TO_BASKET"]?>">
			<input type="submit" value="<?= GetMessage("TSBS_2BASKET") ?>">
			</form></td></tr><?
		}
	}
	if ($arResult["SUBSCRIBE"]=="Y" && 0)
	{
		?><tr><td align="center"><?= GetMessage("TSBS_SUBSCRIBE") ?></td></tr>
		<tr><td><ul><?
		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["CAN_BUY"]=="N" && $v["SUBSCRIBE"]=="Y")
			{
				?><li><?
				if ('' != $v["DETAIL_PAGE_URL"])
				{
					?><a href="<?echo $v["DETAIL_PAGE_URL"] ?>"><b><?echo $v["NAME"]?></b></a><?
				}
				else
				{
					?><b><?echo $v["NAME"]?></b><?
				}
				?></li><?
			}
		}
		if (isset($v))
			unset($v);
		?></ul></td></tr><?
	}
	if ($arResult["NOTAVAIL"]=="Y" && 0)
	{
		?><tr><td align="center"><?= GetMessage("TSBS_UNAVAIL") ?></td></tr>
		<tr><td><ul><?
		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["CAN_BUY"]=="N" && $v["SUBSCRIBE"]=="N")
			{
				?><li><?
				if ('' != $v["DETAIL_PAGE_URL"])
				{
					?><a href="<?echo $v["DETAIL_PAGE_URL"] ?>"><b><?echo $v["NAME"]?></b></a><?
				}
				else
				{
					?><b><?echo $v["NAME"]?></b><?
				}
				?><br />
				<?= GetMessage("TSBS_PRICE") ?>&nbsp;<b><?echo $v["PRICE_FORMATED"]?></b><br />
				<?= GetMessage("TSBS_QUANTITY") ?>&nbsp;<?echo $v["QUANTITY"]?>
				</li><?
			}
		}
		if (isset($v))
			unset($v);
		?></ul></td></tr><?
	}
	?><?
}
?><?$frame->end();?></div>