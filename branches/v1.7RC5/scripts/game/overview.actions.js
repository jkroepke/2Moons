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
	if($('#password').val() == '') {
		return false;
	} else {
		$.getJSON('game.php?page=overview&mode=delete&password='+$('#password').val(), function(response){
			alert(response.message);
			if(response.ok){
				parent.location.reload();
			}
		});
	}
}