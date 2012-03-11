$(document).ready(function(){
	FleetTime();
});

function buildTimeTicker() {

	var s	= buildEndTime - (serverTime.getTime() - startTime) / 1000;
	if(s <= 0) {
		window.location.href = "game.php?page=overview";
		return;
	}
	$('#blc').text(GetRestTimeFormat(s));
	window.setTimeout('buildTimeTicker()', 1000);
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