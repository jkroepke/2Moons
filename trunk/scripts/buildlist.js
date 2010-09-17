var Gamename	= document.title;

function ReBuildView() {
	var HTML	= '<table style="width:80%">';
	$.each(data.build, function(index, val) {
		HTML	+= '<tr>';
		if (index == 0) {
			HTML	+= '<td style="width:70%" class="left">'+(index+1)+'.: '+val.name+' '+val.level+' '+val.mode+'<br><br><div id="progressbar"></div></td>';
			HTML	+= '<td><div id="blc"><a href="game.php?page=buildings&amp;cmd=cancel">'+data.bd_cancel+'</a></div>';
		} else {
			HTML	+= '<td style="width:70%" class="left">'+(index+1)+'.: '+val.name+' '+val.level+' '+val.mode+'</td>';
			HTML	+= '<td><a href="game.php?page=buildings&amp;cmd=remove&amp;listid='+(index+1)+'">'+data.bd_cancel+'</a>';
		}
		HTML	+= '<br><span style="color:lime">'+getFormatedDate(val.endtime * 1000, '[d]. [M] [y] [H]:[i]:[s]')+'</span>';
		HTML	+= '</td>';
		HTML	+= '</tr>';
	});
	HTML	+= '</table>';
	$('#buildlist').html(HTML);
	$('#buildlist').fadeIn("fast");
	$('#progressbar').progressbar({value: ((data.build[0].time != 0) ? 100 - ((data.build[0].endtime - (serverTime.getTime() / 1000)) / data.build[0].time) * 100 :100)});
	$('.ui-progressbar-value').addClass('ui-corner-right').animate({width: "100%" }, data.build[0].endtime * 1000 - serverTime.getTime(), "linear");
	return true;
}

function Buildlist() {
	var h	= 0;
	var	m	= 0;
	var s	= (data.build[0].endtime - (serverTime.getTime() / 1000));
	if ( s <= 0 ) {
		if(data.build.length == 1){
			$('#blc').html(data.bd_finished + '<br><a href=?page=build>'+data.bd_continue+'</a>');
			document.location.href = 'game.php?page=buildings';
			return true;
		} else {
			data.build.shift();
			$('#buildlist').fadeOut("fast");
			ReBuildView();
			s	= (data.build[0].endtime - (serverTime.getTime() / 1000));
		}
	}
	
	if (s > 59) {
		m = Math.floor( s / 60);
		s = s - m * 60;
	}
	
	if (m > 59) {
		h = Math.floor( m / 60);
		m = m - h * 60;
	}
	
	$('#blc').html(dezInt(h, 2) + ':' + dezInt(m, 2) + ":" + dezInt(s, 2)+ '<br><a href="game.php?page=buildings&amp;cmd=cancel">'+data.bd_cancel+'</a>');
	document.title	= dezInt(h, 2) + ':' + dezInt(m, 2) + ":" + dezInt(s, 2) + ' - ' + data.build[0].name + ' - ' + Gamename;
	window.setTimeout('Buildlist();', 1000);
}