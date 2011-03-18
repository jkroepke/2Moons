function instant(event){
	if (event.keyCode == '13') {
		event.preventDefault();
	}

	if($('#searchtext').val().length < 3) {
		$('#result').html('');
		return;
	}
	$.getJSON('game.php?page=search&type='+$('#type').val()+'&searchtext='+$('#searchtext').val(), function(data){
		if($('#type').val() == 'playername' || $('#type').val() == 'planetname') {
			var HTML	= '<table style="width:50%"><tr><th>'+LNG['sh_name']+'</th><th>&nbsp;</th><th>'+LNG['sh_alliance']+'</th><th>'+LNG['sh_planet']+'</th><th>'+LNG['sh_coords']+'</th><th>'+LNG['sh_position']+'</th></tr>'
			$.each(data, function(i, row){
				HTML	+= '<tr>';
				HTML	+= '<td><a href="#" onclick="return Dialog.Playercard('+row.userid+', \''+row.username+'\');">'+row.username+'</a></td>';
				HTML	+= '<td><a href="#" onclick="return Dialog.PM('+row.userid+');" title="'+LNG['sh_write_message']+'"><img src="'+Skin+'img/m.gif"/></a>&nbsp;<a href="javascript:OpenPopup(\'game.php?page=buddy&amp;mode=2&amp;u='+row.userid+'\',\'\', 720, 300);" title="'+LNG['sh_buddy_request']+'"><img src="'+Skin+'img/b.gif" border="0"></a></td>';
				HTML	+= '<td>';
				if (row.allyname)
					HTML	+= '<a href="game.php?page=alliance&amp;mode=ainfo&amp;a='+row.allyid+'">'+row.allyname+'</a>';
				else
					HTML	+= '-';
					
				HTML	+= '</td>';
				HTML	+= '<td>'+row.planetname+'</td>';
				HTML	+= '<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy='+row.galaxy+'&amp;system='+row.system+'">['+row.galaxy+':'+row.system+':'+row.planet+']</a></td>';
				HTML	+= '<td>'+row.rank+'</td>';
				HTML	+= '</tr>';
			});
			HTML	+= '</table>';
		} else {
			var HTML	= '<table style="width:50%"><tr><th>'+LNG['sh_tag']+'</th><th>'+LNG['sh_name']+'</th><th>'+LNG['sh_members']+'</th><th>'+LNG['sh_points']+'</th></tr>';
			$.each(data, function(i, row){			
				HTML	+= '<tr>';
				HTML	+= '<td><a href="game.php?page=alliance&amp;mode=ainfo&amp;tag='+row.allytag+'">'+row.allytag+'</a></td>';
				HTML	+= '<td>'+row.allyname+'</td>';
				HTML	+= '<td>'+row.allymembers+'</td>';
				HTML	+= '<td>'+row.allypoints+'</td>';
				HTML	+= '</tr>';
			});
			HTML	+= '</table>';
		}
		$('#result').html(HTML);	
	});
}
$('#searchtext').keyup(instant);
$('#type').change(instant);