$(function() {
	$('.trade_input').each(function(event) {
		$('#'+$(this).attr('id')+'Shortly').html(function(i, old) {
			return 0;
		});
	}).keyup(function(event) {
		$('#'+$(this).attr('id')+'Shortly').html(function(i, old) {
			return shortly_number($(event.currentTarget).val());
		});
		
		var needResource	= 0;
		
		$('.trade_input').each(function() {
			needResource	+= parseFloat($(this).val()) * charge[$(this).data('resource')];
		});
		if (isNaN(needResource))
		{
			$("#ress").text(0);
		}
		else
		{
			$("#ress").text(NumberGetHumanReadable(needResource));
		}
		return true;
	});
	$('#trader').submit(function() {
		$('.trade_input').val(function(i, old) {
			return old.replace(/[^[0-9]|\.]/g, '');
		});
	});
});