function showRecaptcha(element) 
{
	if(IsCaptchaActive == 0)
		return;
		
	Recaptcha.create(cappublic, 'display_captcha', {
		theme: 'custom',
		lang: $.cookie('lang'),
		tabindex: '6',
		custom_theme_widget: 'display_captcha'
	});
}

function setLNG(LNG) {
	$.cookie('lang', LNG);
	document.location.reload();
}

function initFB()
{
	$.getScript("http://connect.facebook.net/en_US/all.js", function() {
		$('body').append('<div id="fb-root"></div>');
		FB.init({appId: APIKey, status: false, cookie: true});
		loginFB();
	});
}

function loginFB()
{
	FB.login(function(response) {
		if (response.session) {
			if (response.perms) {
				window.location.href = 'index.php?page=facebook';
			} else {
			// user is logged in, but did not grant any permissions
			}
		} else {
			// user is not logged in
		}
	}, {perms:'read_stream,publish_stream,offline_access,email'});
}

function Content(action) {
	$('#regbox').hide();
	$('#loginbox').hide();
	$('#lostbox').hide();
	switch(action) {
		case 'login':
			$('#loginbox').show();
			$('#contentbox').animate({width: '360px', height: '205px'}, 300);
			$('#contentbox label').css('width', '100px');
		break;
		case 'register':
			$('#regbox').show();
			$('#contentbox').animate({width: '560px', height: '320px'}, 300);		
			$('#contentbox label').animate({width: '257px'}, 300);
		break;
		case 'lost':
			$('#lostbox').show();
			$('#contentbox').animate({width: '360px', height: '205px'}, 300);
			$('#contentbox label').css('width', '100px');
		break;
	}
	return false;
}

function Submit(action) {
	switch(action) {
		case 'login':
			$.post('?page=login&action=send', $('#login').serialize(), function(data) {
				data	= $.parseJSON(data);
				if(data.error === false)
					document.location.href = 'game.php';
				else
					alert(data.message);
			});
		break;
		case 'register':
			$.post('?page=login&action=send', $('#reg').serialize(), function(data) {
			
			});
		break;
		case 'lost':
			$.post('?page=login&action=send', $('#lost').serialize(), function(data) {
			
			});
		break;
	}
	return false;
}