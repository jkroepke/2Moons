$(function() {
    $('.maxShipCount').on('click', function(e) {
        e.preventDefault();
        $('#'+$(this).data('intoInput')).val($(this).data('amount'));
        return false;
    });

    $('.selectedAllShips').on('click', function(e) {
        $('.maxShipCount').trigger('click');
    });

    $('.removeSelectedShips').on('click', function(e) {
        $('.inputShipCount').val(0);
    });
});

window.setInterval(function() {
    $('.fleets').each(function() {
        var s = $(this).data('fleet-time') - (serverTime.getTime() - startTime) / 1000;
        if(s <= 0) {
            $(this).text('-');
        } else {
            $(this).text(GetRestTimeFormat(s));
        }
    })
}, 1000);