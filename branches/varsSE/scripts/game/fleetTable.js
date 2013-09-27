$(function() {
	window.setInterval(function() {
		$('.fleets').each(function() {
			var s		= $(this).data('fleet-time') - (serverTime.getTime() - startTime) / 1000;
			if(s <= 0) {
				$(this).text('-');
			} else {
				$(this).text(GetRestTimeFormat(s));
			}
		})
	}, 1000);

    $('.maxShipCount').on('click', function(e) {
        e.preventDefault();
        $('#'+$(this).data('intoInput')).val($(this).data('amount'));
        return false;
    });
});

function maxShips() {
    $('.maxShipCount').trigger('click');
}

function noShips() {
    $('.inputShipCount').val(function() {
        return 0;
    });
}