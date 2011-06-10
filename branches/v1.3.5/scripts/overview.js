$(document).ready(function(){
	$('#dialog').dialog({ autoOpen: false, width: 450, height: 220, modal: true,
		buttons: {
			"OK": function() {
				var mode	= $('#tabs').tabs('option', 'selected');
				if(mode	== 0) {
					checkrename();
				} else if(mode == 1) {
					checkcancel();
				}
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});
	$('#tabs').tabs();
});
function checkrename()
{
	if($('#newname').val() == '') {
		return false;
	} else {
		$.get('ajax.php?action=renameplanet&lang='+Lang+'&newname='+$('#newname').val(), function(response){
			$('#dialog').dialog('close');
			if(response == '')
				$('.planetname').text($.trim($('#newname').val()));
			else
				Dialog.alert(response);
		});
	}
}

function checkcancel()
{
	if($('#password').val() == '') {
		return false;
	} else {
		$.getJSON('ajax.php?action=deleteplanet&lang='+Lang+'&password='+$('#password').val(), function(response){
			$('#dialog').dialog('close');
			Dialog.alert(response.mess, function(){Dialog.close();document.location.href = 'game.php?page=overview'});
		});
	}
}

function cancel()
{
	$('#submit-rename').hide();
	$('#submit-cancel').show();
	$('#label').text(ov_password);
	$('#newname').hide();
	$('#password').show();
}

function BuildTime() {
	var s	= (buildtime - serverTime.getTime()) / 1000 + ServerTimezoneOffset;
	if(s <= 0) {
		window.location.href = "game.php?page=overview";
		return;
	}
	$('#blc').text(GetRestTimeFormat(s));
	window.setTimeout('BuildTime()', 1000);
}

function FleetTime() {
	$.each(Fleets, function(id, time) {
		var s		= (time - (serverTime.getTime() / 1000) + ServerTimezoneOffset);
		if(s <= 0) {
			$('#fleettime_'+id).text('-');
		} else {
			$('#fleettime_'+id).text(GetRestTimeFormat(s));
		}
	});
	window.setTimeout('FleetTime()', 1000);
}

function GetFleets(init) {
	$.getJSON('ajax.php?action=getfleets&lang='+Lang, function (data) {
		if(data.length == 0) {
			window.setTimeout('GetFleets()', 60000);
			return;
		}
		
		Fleets		= {};
		var HTML	= '';
		$.each(data, function(index, val) {
			HTML	+= '<tr class="fleet">';
			HTML	+= '<td id="fleettime_'+index+'">-</td>';
			HTML	+= '<td colspan="2">'+val.fleet_descr+'</td></tr>';
			Fleets[index]	=  val.fleet_return;
		});
		if(HTML != '') {
			$('.fleet').detach();
			$('tr#fleets').before(HTML);		
		}
		
		if(typeof init != "undefined")
			FleetTime();
			
		window.setTimeout('GetFleets()', 60000);
	});
}

function UhrzeitAnzeigen() {
   $("#servertime").text(getFormatedDate(serverTime.getTime(), '[M] [D] [d] [H]:[i]:[s]'));
}

UhrzeitAnzeigen();
setInterval(UhrzeitAnzeigen, 1000);