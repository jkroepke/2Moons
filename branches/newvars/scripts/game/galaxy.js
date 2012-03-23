function doit(missionID, planetID, shipData) {

	var shipDetail	= decodeURIComponent($.param({"ship": shipData}));
	
	$.getJSON("game.php?page=fleetAjax&ajax=1&mission="+missionID+"&planetID="+planetID+"&"+shipDetail, function(data){
		$('#slots').text(data.slots);
		$('#probes').text(number_format(data.ship[210]));
		$('#recyclers').text(number_format(data.ship[209]));
		$('#grecyclers').text(number_format(data.ship[219]));

		var statustable	= $('#fleetstatusrow');
		var messages	= statustable.find("~tr");
		if(messages.length == MaxFleetSetting) {
			console.log(messages.get(MaxFleetSetting - 1));
			messages.filter(':last').remove();
		}
		var element		= $('<td />').attr('colspan', 8).attr('class', data.code == 600 ? "success" : "error").text(data.mess).wrap('<tr />').parent();
		statustable.removeAttr('style').after(element);
	});
}

function galaxy_submit(value) {
	$('#auto').attr('name', value);
	$('#galaxy_form').submit();
}