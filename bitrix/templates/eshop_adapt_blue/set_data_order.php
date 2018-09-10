<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>
<?
if (!isset($_SESSION['ORDER_ID_UPDATE']['ORDERS']))
{
	$sql = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"),array(),false,false,array('ID'));
	$_SESSION['ORDER_ID_UPDATE']['TOTAL_COUNT']=$sql->SelectedRowsCount();
	$_SESSION['ORDER_ID_UPDATE']['SHAG']=ceil ($_SESSION['ORDER_ID_UPDATE']['TOTAL_COUNT']/3);
	$_SESSION['ORDER_ID_UPDATE']['POSITION']=1;
	while ($arSales = $sql->GetNext())
	{
		$_SESSION['ORDER_ID_UPDATE']['ORDERS'][$arSales['ID']]=$arSales['ID'];
	}
}
$second=time ();
if ($_SESSION['ORDER_ID_UPDATE']['POSITION']==1)
{
	$second-=86400*3;
}
elseif($_SESSION['ORDER_ID_UPDATE']['POSITION']==2)
{
	$second-=86400*2;
}
else
{
	$second-=86400;
}
$data=date('d.m.Y H:i:s',$second);



$z=0;
$ids=array();


foreach ($_SESSION['ORDER_ID_UPDATE']['ORDERS'] as $key=>$val)
{
	CSaleOrder::Update($val,array ('DATE_INSERT'=>$data));

	if( isset($_SESSION['ORDER_ID_UPDATE']['ORDERS'][$key])  )
	{
	  unset($_SESSION['ORDER_ID_UPDATE']['ORDERS'][$key]);
	}
	if ($_SESSION['ORDER_ID_UPDATE']['SHAG']<$z){break;}
$z++;
}

$_SESSION['ORDER_ID_UPDATE']['POSITION']++;

if ($_SESSION['ORDER_ID_UPDATE']['POSITION']>3){unset($_SESSION['ORDER_ID_UPDATE']);}
if (count($_SESSION['ORDER_ID_UPDATE']['ORDERS'])>0)
{
 echo 'Еще не все заказы обновлены <br>для продолжения обновите страницеу<br> Осталось:'.count($_SESSION['ORDER_ID_UPDATE']['ORDERS']);
}


?><pre><?print_r($_SESSION['ORDER_ID_UPDATE']);?></pre><?


/*CSaleOrder::Update(
  int ID,
  array arFields
  bDateUpdate
);*/
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>