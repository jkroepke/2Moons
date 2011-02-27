function FleetTime() {
	$.each(Fleets, function(id, time) {
		var s		= (time - (serverTime.getTime() / 1000) + ServerTimezoneOffset);
		if(s <= 0) {
			$('#fleettime_'+id).text('-');
		} else {
			$('#fleettime_'+id).text(GetRestTimeFormat(s));
		}
	});
}