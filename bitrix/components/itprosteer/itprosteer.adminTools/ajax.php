<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
use \Bitrix\Sale\Order; //get Order
use \Bitrix\Sale\Internals;//get dlivery services
if($_REQUEST["createNewOrder"]){
    if(CModule::IncludeModule("sale")){
        $dbRes = CSaleOrderProps::GetList(
            array("SORT" => "ASC"),
            array(
                "PERSON_TYPE_ID"=>1
            ),
            false,
            false,
            array()
        );
        while($prop = $dbRes->Fetch()){
            if(strpos($prop["CODE"],"NEWPOST")!==false ){
                $needlProps[$prop["CODE"]] = $prop["ID"];
            }

        }

        echo json_encode($needlProps);
    }

}
if($_REQUEST["request"]=="start") {
    $APPLICATION->IncludeComponent(
        "itprosteer:itprosteer.adminTools",
        "",
        Array()
    );
}
if($_REQUEST["table"] == "city" && $_REQUEST["ajax"] == "y"){
    $strSql = "
        SELECT
           DESCRIPTION_RU,REF
        FROM itprosteer_newpost_city
       
       WHERE DESCRIPTION_RU
        LIKE '".$_REQUEST["value"]."%'
        
        ";
    $res = $DB->Query($strSql, false, $err_mess.__LINE__);
    while($el=$res->Fetch()){
        $arEl[$el["DESCRIPTION_RU"]]=$el["REF"];
    }
    echo json_encode($arEl);
}
if($_REQUEST["table"] == "warehouse" && $_REQUEST["ajax"] == "y"){
    $strSql = "
        SELECT
           DESCRIPTION_RU,REF
        FROM itprosteer_newpost_werehouse
       
       WHERE CITY_REF='".$_REQUEST["city"]."' AND DESCRIPTION_RU
        LIKE '%".$_REQUEST["value"]."%'
        
        ";
    $res = $DB->Query($strSql, false, $err_mess.__LINE__);
    while($el=$res->Fetch()){
        $arEl[$el["DESCRIPTION_RU"]]=$el["REF"];
    }
    echo json_encode($arEl);
}
if($_REQUEST["table"] == "street" && $_REQUEST["ajax"] == "y"){
    $strSql = "
        SELECT
           DESCRIPTION,REF
        FROM itprosteer_newpost_street
       
       WHERE CITY_REF='".$_REQUEST["city"]."' AND DESCRIPTION
        LIKE '%".$_REQUEST["value"]."%'
        
        ";
    $res = $DB->Query($strSql, false, $err_mess.__LINE__);
    while($el=$res->Fetch()){
        $arEl[$el["DESCRIPTION"]]=$el["REF"];
    }
    if(!isset($arEl)){
        include_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/itprosteer.newpost/classes/general/newpost.php";
        if ($_REQUEST["city"]) {

            $api_key = COption::GetOptionString("itprosteer.newpost","API_KEY",false,false,false);
            $post = new NewPost($api_key);
            $res = $post->getStreet(trim($_REQUEST["city"]));

            if(count($res)>0){
                for($i=0;$i<count($res);$i++){
                    $result[$res[$i]->Ref] =  $res[$i]->StreetsType . " " . $res[$i]->Description;
                    $arEl[$res[$i]->StreetsType . " " . $res[$i]->Description] =  $res[$i]->Ref;

                    $arFields=array(
                        "DESCRIPTION"=>"'".$res[$i]->StreetsType . " " .addslashes($res[$i]->Description)."'",
                        "REF"=>"'".addslashes($res[$i]->Ref)."'",
                        "CITY_REF"=>"'".addslashes($city)."'",
                        "UPDATE_STREET"=>"'".time()."'"
                    );
                    $resDb =$DB->Insert("itprosteer_newpost_street", $arFields, $err_mess.__LINE__);
                }
            }
        }
    }
    echo json_encode($arEl);
}
if($_REQUEST["save"] == "y" && $_REQUEST["ajax"] == "y"){
    $arFieldsVals= array();
    if($_REQUEST["city"]){
        $arFieldsVals["NEWPOST_REF_CITY"]=$_REQUEST["cityRef"];
    }
    if($_REQUEST["warehouseRef"]){
        $arFieldsVals["NEWPOST_REF_WAREHOUSE"]=$_REQUEST["warehouseRef"];
    }
    if($_REQUEST["streetRef"]){
        $arFieldsVals["NEWPOST_DELIVERY_STREET"]=$_REQUEST["streetRef"];
    }
    if($_REQUEST["house"]){
        $arFieldsVals["NEWPOST_DELIVERY_HOUSE"]=$_REQUEST["house"];
    }
    if($_REQUEST["flat"]){
        $arFieldsVals["NEWPOST_DELIVERY_FLAT"]=$_REQUEST["flat"];
    }

    $arFieldsVals["NEWPOST_REF_ADDRESS"] = $_REQUEST["city"];

    if(isset($_REQUEST["warehouse"]) && strlen($_REQUEST["warehouse"]) > 0)
        $arFieldsVals["NEWPOST_REF_ADDRESS"] .= ", ".$_REQUEST["warehouse"];

    if(isset($_REQUEST["street"]) && strlen($_REQUEST["street"]) > 0)
        $arFieldsVals["NEWPOST_REF_ADDRESS"] .= ", ".$_REQUEST["street"];

    if(isset($_REQUEST["house"]) && strlen($_REQUEST["house"]) > 0)
        $arFieldsVals["NEWPOST_REF_ADDRESS"] .= ", ".GetMessage("ITPR_HOUSE").$_REQUEST["house"];

    if(isset($_REQUEST["flat"]) && strlen($_REQUEST["flat"]) > 0)
        $arFieldsVals["NEWPOST_REF_ADDRESS"] .= ", ".GetMessage("ITPR_FLAT").$_REQUEST["flat"];

    \Bitrix\Main\Loader::includeModule("sale");

    $order = Order::load($_REQUEST["orderId"]);
    $shipmentCollection=$order->getShipmentCollection();
    foreach($shipmentCollection as $shipment){
        if($shipment->isSystem()){
            continue;
        }
        $data = array(
            'select'=>array('*'),
            'filter'=>array("ID"=>COption::GetOptionString("itprosteer.newpost","DELIVERY_ID",false,false,false))
        );
        $arDeliveryServices = Internals\DeliveryServiceTable::getRow($data);
        $data = array(
            "DELIVERY_ID"=>$arDeliveryServices["ID"],
            "DELIVERY_NAME"=>$arDeliveryServices["NAME"],
            "BASE_PRICE_DELIVERY"=>0.01
        );
        $shipment->setFields($data);

    }
    $properties = $order->getPropertyCollection();
    foreach($properties as $prop){
        if(strpos($prop->getField("CODE"),"NEWPOST")!==false && $prop->getField("CODE") !== "NEWPOST_DELIVERY_PAY"){
            if(isset($arFieldsVals[$prop->getField("CODE")])){
                $prop->setValue($arFieldsVals[$prop->getField("CODE")]);
            }else{
                $prop->setValue("");
            }
        }
    }

    $order->save();


}
if($_REQUEST["template"]=="form"){
    ?>

    <style>
        #itpr_delivery-to-warehouse,#itpr_delivery-to-home{
            display:inline-block;
            width:40.8%;
            padding-top:15px;
            padding-bottom:8px;
            padding-left:20px;


        }
        .itpr_active{
            background:#fff;
        }
        #itpr_delivery-to-home{

        }
        .itpr_newpost {
            width: 318px;
            height: 250px;
            position: fixed;
            top: 200px;
            z-index: 999;
            right: -240px;
        }
        .itpr_handler{
            float:left;
            width:78px;
            height:50px;
            background: url("/upload/itprosteer/np.png") no-repeat;
            background-size:cover;
            box-shadow:0 0 10px #9f9f9f;
            z-index: 600;
        }
        #itpr_tabs{
            width:240px;
            float:right;
            background:#eee;
            position:relative;
            z-index: 999;

        }
        .itpr_error{
            color:#f00;
        }
        .itpr_form{
            width:200px;
            float:right;
            padding:20px;
            background:#fff;
            box-shadow:0 0 15px #222;
            padding-top:9px;

        }
        .itpr_input{
            height:30px;
            -webkit-border-radius:5px;
            -moz-border-radius:5px;
            border-radius:5px;
            margin:3px;
            width:100%;
            border:2px solid #9b1618;
            padding:5px;

        }
        .itpr_newpost_active{
            right: 0;
        }
        #itpr_save, #itpr_reset{
            display:inline-block;
            height:20px;
            border: solid 1px;
            text-shadow: 0 1px rgba(0,0,0,0.1);
            -webkit-font-smoothing: antialiased;
            padding: 0px 13px 2px;
            font-weight:bold;
            padding-top:5px;
            border-radius: 5px;
        }
        #itpr_save{
            background-color: #86ad00!important;
            -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.25), inset 0 1px 0 #cbdc00;
            box-shadow: 0 1px 1px rgba(0,0,0,.25), inset 0 1px 0 #cbdc00;
            border-color: #97c004 #7ea502 #648900;
            background-image: -webkit-linear-gradient(bottom, #729e00, #97ba00)!important;
            background-image: -moz-linear-gradient(bottom, #729e00, #97ba00)!important;
            background-image: -ms-linear-gradient(bottom, #729e00, #97ba00)!important;
            background-image: -o-linear-gradient(bottom, #729e00, #97ba00)!important;
            background-image: linear-gradient(bottom, #729e00, #97ba00)!important;
            color: #fff;
            cursor:pointer;
            margin-top:10px;
            margin-left:4px;
        }
        .itpr_hide{
            display:none;
        }

    </style>
    <div class="itpr_newpost">
        <div class="itpr_handler"></div>
        <div id="itpr_tabs">
            <span id="itpr_delivery-to-warehouse" class="itpr_active">В отделение</span>
            <span id="itpr_delivery-to-home">Адресная</span>
        </div>
        <div class="itpr_form">
            <form action="">

                <span class="itpr_label">Выберите город</span>
                <input type="text" autocomplete="off" name="itpr_city" id="itpr_city" class="itpr_input">
                <div class="itpr_to-warehouse">
                    <span class="itpr_label">Выберите отделение</span>
                    <input type="text" autocomplete="off" name="itpr_warehouse" id="itpr_warehouse" class="itpr_input">
                </div>

                <div class="itpr_to-address itpr_hide">
                    <span class="itpr_label">Выберите улицу</span>
                    <input type="text" autocomplete="off" name="itpr_street" id="itpr_street" class="itpr_input ">
                    <span class="itpr_label">Введите дом</span>
                    <input type="text" autocomplete="off" name="itpr_house" id="itpr_house" class="itpr_input ">
                    <span class="itpr_label">введите квартиру</span>
                    <input type="text" autocomplete="off" name="itpr_flat" id="itpr_flat" class="itpr_input ">
                </div>
                <span class="itpr_error"></span>
                <span id="itpr_save">Сохранить</span>
            </form>
            <br>
            <hr>
            <br>

            <a href="https://itprosteer.com"><img src="//<?=$_SERVER['SERVER_NAME']?>/upload/itprosteer/logo.png" alt="ITprosteer"></a>
            <p>
                +380 (63) 243 65 65<br>
				+380 (96) 243 65 65<br>
				+380 (95) 243 65 65<br>
                support@itprosteer.com
            </p>
        </div>
    </div>
<?};?>