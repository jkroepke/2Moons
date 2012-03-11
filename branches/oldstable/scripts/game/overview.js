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
	FleetTime();
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

	var s	= buildtime - (serverTime.getTime() - startTime) / 1000;
	if(s <= 0) {
		window.location.href = "game.php?page=overview";
		return;
	}
	$('#blc').text(GetRestTimeFormat(s));
	window.setTimeout('BuildTime()', 1000);
}

function FleetTime() {
	$('.fleets').each(function() {
		var s		= $(this).data('fleet-time') - (serverTime.getTime() - startTime) / 1000;
		if(s <= 0) {
			$(this).text('-');
		} else {
			$(this).text(GetRestTimeFormat(s));
		}
	});
	window.setTimeout('FleetTime()', 1000);
}

function UhrzeitAnzeigen() {
   $(".servertime").text(getFormatedDate(serverTime.getTime(), tdformat));
}

UhrzeitAnzeigen();
setInterval(UhrzeitAnzeigen, 1000);