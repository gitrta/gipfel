</div>
			
		</div>
<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "page",
		"AREA_FILE_SUFFIX" => "inc2",
		"EDIT_TEMPLATE" => ""
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);?>

    </div>


 	<footer>
        <div class="footer_top">    
            <div class="wrapper clearfix">                            
<?$APPLICATION->IncludeFile("/inc/footer_contacts.php",array(),array("MODE"=>"php"))?>
            </div>
        </div>
        <div class="wrapper">
            <div class="footer_bottom clearfix">                
                <div class="footer_copyright"><?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
	"AREA_FILE_SHOW" => "file",
	"PATH" => "/inc/copy.php",
	"EDIT_TEMPLATE" => ""
	),
	false
);?></div>
<?$APPLICATION->IncludeComponent("bitrix:menu", "bottom_menu", array(
	"ROOT_MENU_TYPE" => "top",
	"MENU_CACHE_TYPE" => "A",
	"MENU_CACHE_TIME" => "36000000",
	"MENU_CACHE_USE_GROUPS" => "Y",
	"MENU_CACHE_GET_VARS" => array(
	),
	"MAX_LEVEL" => "1",
	"CHILD_MENU_TYPE" => "left",
	"USE_EXT" => "Y",
	"DELAY" => "N",
	"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?>

            </div>
        </div> 
     </footer>
<div id="notice">Добавлено в корзину</div>

<!--      <a href="#" class="gotop"></a> -->

</body>
</html>