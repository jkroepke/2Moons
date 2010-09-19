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
	$('#planet_menu_content').toggle('blind', {}, 500);
	if($('#menu').css('padding-bottom') == '98px') {
		$('#menu').animate({'padding-bottom' :'26px'}, 500);
		$('#content').animate({'padding-bottom': '26px'}, 500);
	} else {
		$('#menu').animate({'padding-bottom': '98px'}, 500);
		$('#content').animate({'padding-bottom': '98px'}, 500);
	}
}