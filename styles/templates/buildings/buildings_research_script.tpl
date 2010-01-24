<div id="brp" class="z"></div>
<script   type="text/javascript">
v = new Date();
var brp = document.getElementById('brp');
function t(){
	n  = new Date();
	ss = {tech_time};
	s  = ss - Math.round( (n.getTime() - v.getTime()) / 1000.);
	m  = 0;
	h  = 0;
	if ( s < 0 ) {
		brp.innerHTML = '{bd_ready}<br><a href=game.php?page=buildings&mode=research&cp={tech_home}>{bd_continue}</a>';
		document.title = 'Fertig - {tech_lang} - {game_name}';
		document.location.href = "game.php?page=buildings&mode=research";
	} else {
		if ( s > 59 ) { m = Math.floor( s / 60 ); s = s - m * 60; }
		if ( m > 59 ) { h = Math.floor( m / 60 ); m = m - h * 60; }
		if ( s < 10 ) { s = "0" + s }
		if ( m < 10 ) { m = "0" + m }
		brp.innerHTML = h + ':' + m + ':' + s + '<br><a href=game.php?page=buildings&mode=research&cmd=cancel&tech={tech_id}>{bd_cancel}<br>{tech_name}</a>';
		document.title = h + ':' + m + ':' + s + ' - {tech_lang} - {game_name}';
	}
	window.setTimeout("t();",1000);
}
window.onload=t;
</script>