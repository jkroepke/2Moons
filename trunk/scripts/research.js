var brp = $('#research');

function reseachtime(){
	var s  = data.tech_time - (serverTime.getTime() / 1000);
	var m  = 0;
	var h  = 0;
	if ( s < 0 ) {
		brp.html(data.bd_ready+'<br><a href=game.php?page=buildings&amp;mode=research&amp;cp='+data.tech_home+'>'+data.bd_continue+'</'+'a>');
		document.title = data.bd_ready+' - '+data.tech_lang+' - '+data.game_name;
		document.location.href = "game.php?page=buildings&mode=research";
	} else {
		if ( s > 59 ) { m = Math.floor( s / 60 ); s = s - m * 60; }
		if ( m > 59 ) { h = Math.floor( m / 60 ); m = m - h * 60; }
		brp.html(h + ':' + dezInt(m, 2) + ':' + dezInt(s, 2) + '<br><a href="game.php?page=buildings&amp;mode=research&amp;cmd=cancel">'+data.bd_cancel+'<br>'+data.tech_name+'</'+'a>');
		document.title = h + ':' + dezInt(m, 2) + ':' + dezInt(s, 2) + ' - '+data.tech_lang+' - '+data.game_name;
	}
}

$(document).ready(function() {
	reseachtime();
	window.setInterval("reseachtime();",1000);
});