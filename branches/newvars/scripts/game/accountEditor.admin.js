var Saved	= new Object();

$(function()
{
	$('.tabs').tabs();
	$('#content input:not(:button)').on('focusin', function() {
		Saved[$(this).attr('id')]	= $(this).val();
	}).on('focusout', function() {
		$this	= $(this);
		if(typeof Saved[$(this).attr('id')] !== "undefined" && Saved[$(this).attr('id')] != $(this).val())
		{
			$.getJSON('admin.php?page=account&mode=updateUser&id='+parseInt($('#userID').text())+'&'+$(this).attr('name')+'='+$(this).val(), function(response) {
				NotifyBox(response.message);
				$this.val(response.count);
			});
		}
		
		delete Saved[$(this).attr('id')];
	});
});