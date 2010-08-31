function ajax(url){
	if(url == '?page=reg&getajax=1'){
		if(IsRegActive == 1){
			alert(lang_reg_closed);  
		} else {
			$('#background-content').load(url);
		}
	} else {
		$('#background-content').load(url);
	}
}

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
				document.reg.action = $('#Uni').val() + "?page=reg&mode=send&lang="+lang;
			break;
			case "lostpassword":
				document.lostpassword.action = $('#Uni').val() + "?page=lostpassword&mode=send&lang="+lang;
			break;
		}
		return true;
    }
}

function showRecaptcha(element) 
{
	if(IsCaptchaActive == 0)
		return;
		
	Recaptcha.create(cappublic, 'display_captcha', {
		theme: 'custom',
		lang: 'de',
		tabindex: '6',
		custom_theme_widget: 'display_captcha'
	});
}

function fbLogincheck() {
	FB.Connect.requireSession(function() {
		FB.Facebook.apiClient.users_hasAppPermission('email', function (permsare) { 
			if(!permsare){
				FB.Connect.showPermissionDialog('email', function(perms) {
					if (perms) {
						document.location = $('#Uni').val()+"index.php?page=facebook";
					} else {
						alert(fb_permissions);
					}
				});
			} else {
				document.location = $('#Uni').val()+"index.php?page=facebook";
			}
		});
	});
}

function buttonOver(obj)
{
	if($(obj).hasClass('button-important'))
		$(obj).toggleClass('button-important-over');
	else if($(obj).hasClass('button-normal'))
		$(obj).toggleClass('button-normal-over');
}

function buttonOut(obj){
	if($(obj).hasClass('button-important'))
		$(obj).toggleClass('button-important-over');
	else if($(obj).hasClass('button-normal'))
		$(obj).toggleClass('button-normal-over');
}
