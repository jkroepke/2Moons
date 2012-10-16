$(document).ready(function(){
	FleetTime();
});

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