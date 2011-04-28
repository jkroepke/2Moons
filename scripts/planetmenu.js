function initPlanetMenu(){
	if($.cookie('pmenu') != null) {
		if($.cookie('pmenu') == "on") {
			$('#planet_menu_content').show();
			$('nav').css('padding-bottom', '112px');
			$('#content').css('padding-bottom', '117px');
		} else {
			$('#planet_menu_content').hide();
			$('nav').css('padding-bottom', '21px');
			$('#content').css('padding-bottom', '26px');
		}
	} else {
		if($("#planet_menu_content:visible").length == 1) {
			$.cookie('pmenu', 'on');
			$('nav').css('padding-bottom', '112px');
			$('#content').css('padding-bottom', '117px');
		} else {
			$.cookie('pmenu', 'off');
			$('nav').css('padding-bottom', '21px');
			$('#content').css('padding-bottom', '26px');
		}	
	}
	PlanetMenu();
	window.setTimeout(PlanetMenu, 1000);
}

function PlanetMenu() {
	$.each(planetmenu, function(index, val) {
		if(val.length != 0 && val[0] < serverTime.getTime() / 1000 + ServerTimezoneOffset)
			val.shift();
	
		if(val.length == 0)
			$('#planet_'+index).text(Ready);
		else	
			$('#planet_'+index).text(getFormatedTime(val[0] - serverTime.getTime() / 1000 + ServerTimezoneOffset));
	});
}

function ShowPlanetMenu() {
	if($("#planet_menu_content:visible").length == 1) {
		$.cookie('pmenu', 'off');
		$('nav').animate({'padding-bottom' :'26px'}, 500);
		$('#content').animate({'padding-bottom': '26px'}, 500);
	} else {
		$.cookie('pmenu', 'on');
		$('nav').animate({'padding-bottom': '112px'}, 500);
		$('#content').animate({'padding-bottom': '117px'}, 500);
	}
	$('#planet_menu_content').slideToggle(500);
}