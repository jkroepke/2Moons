function doit (order, galaxy, system, planet, planettype, shipcount) {
	$.getJSON("game.php?page=fleetajax&ajax=1&mission="+order+"&galaxy="+galaxy+"&system="+system+"&planet="+planet+"&planettype="+planettype+"&ships="+shipcount, function(data){
		$('#slots').text(data.slots);
		$('#probes').text(number_format(data.ship210));
		$('#recyclers').text(number_format(data.ship209));
		$('#grecyclers').text(number_format(data.ship219));

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