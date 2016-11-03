$(function() {
	$('#tabs').tabs();
});

function checkrename()
{
	if($.trim($('#name').val()) == '') {
		return false;
	} else {
		$.getJSON('game.php?page=overview&mode=rename&name='+$('#name').val(), function(response){
			alert(response.message);
			if(!response.error) {
				parent.location.reload();
			}
		});
	}
}

function checkcancel()
{
	var password = $('#password').val();
	if(password == '') {
		return false;
	} else {
		$.post('game.php?page=overview', {'mode' : 'delete', 'password': password}, function(response) {
			alert(response.message);
			if(response.ok){
				parent.location.reload();
			}
		}, "json");
	}
}