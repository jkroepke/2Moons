$(function() {
	$('.trade_input').each(function() {
		$('#'+$(this).attr('id')+'Shortly').html(function(i, old) {
			return shortly_number($(event.currentTarget).val());
		});
	}).keyup(function(event) {
		$('#'+$(this).attr('id')+'Shortly').html(function(i, old) {
			return shortly_number($(event.currentTarget).val());
		});
		return;
		var ress1   = $(".trade_input:eq(0)").val().replace(/[^[0-9]|\.]/g, '');
		var ress2	= $(".trade_input:eq(1)").val().replace(/[^[0-9]|\.]/g, '');

		var ress 	= ress1 * ress1charge + ress2 * ress2charge

		if (isNaN(ress))
		{
			$("#ress").text(0);
		}
		else
		{
			$("#ress").text(NumberGetHumanReadable(ress));
		}
	});
	$('#trader').submit(function() {
		$('.trade_input').val(function(i, old) {
			return old.replace(/[^[0-9]|\.]/g, '');
		});
	});
});