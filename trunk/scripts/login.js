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
	if(url == '?page=reg&amp;getajax=1'){
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


var lastType = "";

function changeAction(type) {
    if (document.formular.Uni.value == '') {
        alert('Wählen Sie ein Universum aus!');
		return false;
    } else {
        if(type == "login" && lastType == "") {
            var url = document.formular.Uni.value;
            document.formular.action = url;
        } else {
            var url = document.formular.Uni.value + "index.php?page=reg";
            document.formular.action = url;
            document.formular.submit();
        }
		return true;
    }
}