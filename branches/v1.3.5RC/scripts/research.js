var brp = $('#research');

function reseachtime(){
	var s  = data.tech_time - (serverTime.getTime() / 1000) + ServerTimezoneOffset;
	var m  = 0;
	var h  = 0;
	if ( s < 0 ) {
		brp.html(data.bd_ready+'<br><a href=game.php?page=buildings&amp;mode=research&amp;cp='+data.tech_home+'>'+data.bd_continue+'</'+'a>');
		document.title = data.bd_ready+' - '+data.tech_lang+' - '+Gamename;
		window.location.href = "game.php?page=buildings&mode=research";
	} else {
		var time	= GetRestTimeFormat(s);
		brp.html(time + '<br><a href="game.php?page=buildings&amp;mode=research&amp;cmd=cancel">'+data.bd_cancel+'<br>'+data.tech_name+'</'+'a>');
		document.title = time + ' - '+data.tech_lang+' - '+Gamename;
	}
}

$(document).ready(function() {
	reseachtime();
	window.setInterval("reseachtime();",1000);
});