<?
	AddEventHandler("main", "OnBeforeProlog", "Chkd");
function Chkd()
{
	//if($GLOBALS["USER"]->IsAuthorized()) {
	   $URL = $_SERVER['HTTP_HOST'];

	   //$lcur = CCurrency::GetList(($by="name"), ($order="asc"), LANGUAGE_ID);

	   function CBR_XML_Daily_Ru() {
    		$json_daily_file = __DIR__.'/daily.json';
    		if (!is_file($json_daily_file) || filemtime($json_daily_file) < time() - 60*60*24) { //3600 wtf
			 //не работает на шаред хостинге
        /*if ($json_daily = file_get_contents('https://www.cbr-xml-daily.ru/daily_json.js')) {
          file_put_contents($json_daily_file, $json_daily);
        }*/
				$ch = curl_init();
  			curl_setopt($ch, CURLOPT_URL, "https://www.cbr-xml-daily.ru/daily_json.js");
 				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  			$json_daily = curl_exec($ch);
 				curl_close($ch);
				if(strlen($json_daily)){
					file_put_contents($json_daily_file, $json_daily);
				}
    }
    return json_decode(file_get_contents($json_daily_file));
}


$URL = $_SERVER['HTTP_HOST'];
/*
function alexGeo(){
	$ip = $_SERVER["REMOTE_ADDR"];
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://freegeoip.net/json/'.$ip);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $arr = json_decode(curl_exec($ch));
    curl_close($ch);
	$country = $arr->country_code;
	return $country;
}
$c = alexGeo();

if ($c=='RU' and !isset($_SESSION['RR']) and !isset($_GET['MYGEO'])){
	//header('Location: http://gipfel.ru');
	$_SESSION['RR']= $c;
}
if ($c=='KZ' and !isset($_SESSION['RR']) and !isset($_GET['MYGEO'])){
	header('Location: http://gipfel.kz');
	$_SESSION['RR']= $c;
}
/*
if ($c=='BY' and !isset($_SESSION['RR']) and !isset($_GET['MYGEO'])){
	header('Location: http://gipfel.by');
	$_SESSION['RR']= $c;
}

if ($c=='UA' and !isset($_SESSION['RR']) and !isset($_GET['MYGEO'])){
	header('Location: http://gipfel.ua');
	$_SESSION['RR']= $c;
}
*/
$data = CBR_XML_Daily_Ru();

	   global $CUR;
	   $GLOBALS["MCUR"] = 'RUB';
	   if ($URL =='gipfel.ru'){
		   $GLOBALS["MCUR"] = 'RUB';
		   $GLOBALS["KFC"] = 1;
	   }

	   if ($URL =='gipfel.kz'){
		   $GLOBALS["MCUR"] = 'KZT';
		   $k = $data->Valute->KZT->Value/100;
		   $GLOBALS["KFC"] = $k;
	   }

	  /* if ($URL =='gipfel.by'){
		   $GLOBALS["MCUR"] = 'BYN';
		   $k = $data->Valute->BYN->Value;
		   $GLOBALS["KFC"] = $k;
	   }
	   */

	   if ($URL =='gipfel.ua'){
		   $GLOBALS["MCUR"] = 'UAH';
		   $k = $data->Valute->UAH->Value;
		   $GLOBALS["KFC"] = $k/10;
	   }
	  //print_r($data);
}
