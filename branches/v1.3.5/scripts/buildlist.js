function ReBuildView() {
	var HTML	= '<table style="width:80%">';
	$.each(data.build, function(index, val) {
		HTML	+= '<tr>';
		if (index == 0) {
			HTML	+= '<td style="width:70%" class="left">'+(index+1)+'.: '+val.name+' '+val.level+' '+val.mode+'<br><br><div id="progressbar"></div></td>';
			HTML	+= '<td><div id="time"></div><div id="command"><a href="game.php?page=buildings&amp;cmd=cancel" class="post">'+data.bd_cancel+'</a></div>';
		} else {
			HTML	+= '<td style="width:70%" class="left">'+(index+1)+'.: '+val.name+' '+val.level+' '+val.mode+'</td>';
			HTML	+= '<td><a href="game.php?page=buildings&amp;cmd=remove&amp;listid='+(index+1)+'" class="post">'+data.bd_cancel+'</a>';
		}
		HTML	+= '<br><span style="color:lime">'+getFormatedDate(val.endtime * 1000, '[d]. [M] [y] [H]:[i]:[s]')+'</span>';
		HTML	+= '</td>';
		HTML	+= '</tr>';
	});
	HTML	+= '</table>';
	$('#buildlist').html(HTML).show();
	$('#progressbar').progressbar({value: ((data.build[0].time != 0) ? 100 - ((data.build[0].endtime - (serverTime.getTime() / 1000) + ServerTimezoneOffset) / data.build[0].time) * 100 :100)});
	$('.ui-progressbar-value').addClass('ui-corner-right').animate({width: "100%" }, data.build[0].endtime * 1000 - serverTime.getTime() + ServerTimezoneOffset * 1000, "linear");
	return true;
}

function Buildlist() {
	var h		= 0;
	var	m		= 0;
	var s		= (data.build[0].endtime - (serverTime.getTime() / 1000) + ServerTimezoneOffset);
	
	if ( s <= 0 ) {
		$('#time').text(Ready);
		$('#command').text(data.bd_continue);
		document.title	= Ready + ' - ' + Gamename;
		window.setTimeout(function() {window.location.href = 'game.php?page=buildings'}, 1000);
		return true;
	}
	
	var time = GetRestTimeFormat(s);
	$('#time').text(time);
	document.title	= time + ' - ' + data.build[0].name + ' - ' + Gamename;
	window.setTimeout('Buildlist();', 1000);
}