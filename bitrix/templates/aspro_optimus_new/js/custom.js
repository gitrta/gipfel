/*
You can use this file with your scripts.
It will not be overwritten when you upgrade solution.
*/
$(document).ready(function(){
	var refreshIntervalId = setInterval(fuckleadhit, 500);
	var refreshIntervalId2 = setInterval(tvoumat, 1000);
	
	function tvoumat(){
		if($("p").is(".copytxt")==false){
			$('#reviews_content').append('<p class = "copytxt"> * Отправляя данную форму Вы даете свое согласие на <a href = "/obrabotka-personalnykh-dannykh/">обработку персональных данных</a></p>');
		} else{
			clearInterval(refreshIntervalId2);
		}
	}
	
	function fuckleadhit(){
		var el = $('.tabs_section').next();
		if (el.attr('id')=='lhdiv'){
			var tk = el.remove();
			$('#reviews_content').after(tk);
				clearInterval(refreshIntervalId);	
		}
		
	}
	
});