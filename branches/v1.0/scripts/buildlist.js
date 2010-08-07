function Buildlist() 
{
	v           = new Date();
	var timeout = 1;
	n           = new Date();
	ss          = pp;
	aa          = Math.round( (n.getTime() - v.getTime() ) / 1000);
	s           = ss - aa;
	m           = 0;
	h           = 0;
	
	if ( s < 0 ) {
		document.location.href = 'game.php?page='+loc;
		$('#blc').html(bd_finished + '<br><a href=?page='+loc+'>'+bd_continue+'</a>');
		return;
	}
	
	if ( s > 59) {
		m = Math.floor( s / 60);
		s = s - m * 60;
	}
	
	if ( m > 59) {
		h = Math.floor( m / 60);
		m = m - h * 60;
	}
	
	if ( s < 10 ) {
		s = "0" + s;
	}
	if ( m < 10 ) {
		m = "0" + m;
	}
	$('#blc').html(h + ':' + m + ':' + s + '<br><a href=?page=buildings&cmd=cancel>' + bd_cancel + '</a>');
	document.title	= h + ':' + m + ':' + s + ' - ' + ne + ' - ' + gamename;
	pp = pp - 1;
	window.setTimeout('Buildlist();', 1000);
}