$(function(){
  $(".containerPlus").buildContainers({
	containment:"document",
	elementsPath:"styles/css/mbContainer/",
	onClose:function(o){},
	effectDuration:500,
	slideTimer:300,
	autoscroll:true,
  });
});

function checkrename()
{
	if($('#newname').val() == '') {
		return false;
	} else {
		$.post('game.php?page=overview&mode=renameplanet&ajax=1', $('#rename').serialize(), function(response){
			if(response == '') {
				$('.planetname').text($('#newname').val());
				$('#demoContainer').mb_close();
			} else {
				alert(response);
			}
		});
		return false;
	}
}

function checkcancel()
{
	if($('#password').val() == '') {
		return false;
	} else {
		$.getJSON('game.php?page=overview&mode=deleteplanet&ajax=1'+$('#rename').serialize(), function(response){
			if(response.ok) {
				alert(response.mess);
				document.location.href = 'game.php?page=overview';
			} else {
				alert(response.mess);
			}
		});
		return false;
	}
}

function cancel()
{
	$('#submit-rename').hide();
	$('#submit-cancel').show();
	$('#label').text(ov_password);
	$('#newname').hide();
	$('#password').show();
}

function BuildTime() {
	var s	= (buildtime - serverTime.getTime()) / 1000;
	if(s <= 0) {
		document.location.href = "game.php?page=overview";
		return;
	}
	$('#blc').text(GetRestTimeFormat(s));
	window.setTimeout('BuildTime()', 1000);
}