if($.cookie('pmenu') != null) {
	if($.cookie('pmenu') == "on") {
		$('#planet_menu_content').show();
		$('#menu').css('padding-bottom', '98px');
		$('#content').css('padding-bottom', '98px');
	} else {
		$('#planet_menu_content').hide();
		$('#menu').css('padding-bottom', '26px');
		$('#content').css('padding-bottom', '26px');
	}
}

function PlanetMenu() {
	$.each(planetmenu, function(index, val) {
		if(val.length != 0 && val[0] < serverTime.getTime() / 1000)
			val.shift();
	
		if(val.length == 0)
			$('#planet_'+index).text(Ready);
		else	
			$('#planet_'+index).text(getFormatedTime(val[0] - serverTime.getTime() / 1000));
	});
	window.setTimeout('PlanetMenu()', 1000);
}

function ShowPlanetMenu() {
	$('#planet_menu_content').slideToggle(500);
	if($('#menu').css('padding-bottom') == '98px') {
		$.cookie('pmenu', 'off');
		$('#menu').animate({'padding-bottom' :'26px'}, 500);
		$('#content').animate({'padding-bottom': '26px'}, 500);
	} else {
		$.cookie('pmenu', 'on');
		$('#menu').animate({'padding-bottom': '98px'}, 500);
		$('#content').animate({'padding-bottom': '98px'}, 500);
	}
}