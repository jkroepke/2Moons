$(function(){
  $(".containerPlus").buildContainers({
	containment:"document",
	elementsPath:"styles/css/mbContainer/",
	effectDuration:500,
	slideTimer:300,
	autoscroll:true,
  });
});

function checkrename()
{
	if($('#newname').val() == '') {
		return false;
	} else {
		$.get('ajax.php?action=renameplanet&lang='+Lang+'&'+$('#rename').serialize(), function(response){
			if(response == '') {
				$('.planetname').text($('#newname').val());
				$('#demoContainer').mb_close();
			} else {
				alert(response);
			}
		});
		return false;
	}
}

function checkcancel()
{
	if($('#password').val() == '') {
		return false;
	} else {
		$.getJSON('ajax.php?action=deleteplanet&lang='+Lang+'&'+$('#rename').serialize(), function(response){
			if(response.ok) {
				alert(response.mess);
				document.location.href = 'game.php?page=overview';
			} else {
				alert(response.mess);
			}
		});
		return false;
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
			HTML	+= '<td colspan="3">'+val.fleet_descr+'</td></tr>';
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