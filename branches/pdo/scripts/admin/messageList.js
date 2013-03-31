function gotoPage(page) {
	$('#side').val(page);
	$('form').submit();
}

$(function() {
	$('#sender, #receiver').autocomplete({
		'source': 'admin.php?page=autocomplete',
	});
	
	$('.toggle').on('click', function(e) {
		e.preventDefault();
		var messageID = $(this).parent().parent().data('messageid');
		$('#contentID'+messageID).toggle();
		return false;
	});
});