$(function() {
	$('#ress1, #ress2').keyup(function(event) {
		$(event.currentTarget).val(function(i, old) {
			return NumberGetHumanReadable(old.replace(/[^[0-9]|\.]/g, ''));
		});
		
		var ress1   = $("#ress1").val().replace(/[^[0-9]|\.]/g, '');
		var ress2	= $("#ress2").val().replace(/[^[0-9]|\.]/g, '');

		var ress 	= ress1 * ress1charge + ress2 * ress2charge

		if (isNaN(ress))
			$("#ress").text(0);
		else 
			$("#ress").text(NumberGetHumanReadable(ress));
	});
	$('#trader').submit(function() {
		$('#ress1, #ress2').val(function(i, old) {
			return old.replace(/[^[0-9]|\.]/g, '');
		});
	});
});