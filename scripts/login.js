soundManager.flashVersion = 9;
soundManager.url = 'scripts';
soundManager.debugMode = false;
soundManager.useHighPerformance = true;
soundManager.defaultOptions.volume = 33;
soundManager.onload = function() {
  var loginbgm = soundManager.createSound({
    id: 'aSound',
    url: 'scripts/bgm_login.mp3',
    volume: 50
  });
loginbgm.play();
}

function music() {
	var loginbgm = soundManager.getSoundById('aSound');
	var idmusic = $('#music');
	if(idmusic.text() != "Music: ON")
	{
		loginbgm.play();
		idmusic.text("Music: ON");
	}
	else
	{
		loginbgm.stop();
		idmusic.text("Music: OFF");
	}
}

function ajax(url){
	if(url == '?page=reg&getajax=1'){
		if(IsRegActive == 1){
			alert(lang_reg_closed);  
		} else {
			$.get(url, function(data){
				$('#background-content').html(data);
			});
		}
	} else {
		$.get(url, function(data){
			$('#background-content').html(data);
		});
	}
}

$(document).ready(function(){
	$("#background-content").ajaxStart(function () {
		$("#body").mask("Loading...");
	});
				
	$("#background-content").ajaxStop(function () {
		$("#body").unmask();
	});
});

function changeAction(type) {
    if ($('#Uni').val() == '') {
        alert($("#Uni :selected").text());
		return false;
    } else {
        switch(type){
			case "login":
				document.login.action = $('#Uni').val();
			break;
			case "reg":
				document.reg.action = $('#Uni').val() + "?page=reg&mode=send";
			break;
			case "lostpassword":
				document.lostpassword.action = $('#Uni').val() + "?page=lostpassword&mode=send";
			break;
		}
		return true;
    }
}