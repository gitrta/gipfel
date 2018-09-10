<script>
	$(document).ready(function(){
		$( ".adm-list-table span:contains('Доставляется')" ).each(function(){
			$(this).css( "color", "white" );
			$(this).parent().css('background','#78f178');
		});
		$( ".adm-list-table span:contains('Согласован')" ).each(function(){
			$(this).css( "color", "black" );
			$(this).parent().css('background','yellow');
		});
	});

</script>
