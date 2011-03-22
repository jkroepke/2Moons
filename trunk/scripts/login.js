function showRecaptcha() 
{
	if(CONF['IsCaptchaActive'] == 0)
		return;
		
	Recaptcha.create(CONF['cappublic'], 'display_captcha', {
		theme: 'custom',
		lang: $.cookie('lang'),
		tabindex: '6',
		custom_theme_widget: 'display_captcha'
	});
}

function setLNG(uni) {
	$.cookie('uni', uni);
	document.location.reload();
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
			$('.contentbox').animate({width: '360px', height: '205px'}, 300);
			$('.contentbox label').css('width', '100px');
		break;
		case 'register':
			showRecaptcha();
			$('#regbox').show();
			$('.contentbox').animate({width: '560px', height: CONF['IsCaptchaActive'] == 0 ? '341px' : '417px'}, 300);		
			$('.contentbox label').animate({width: '257px'}, 300);
		break;
		case 'lost':
			$('#lostbox').show();
			$('.contentbox').animate({width: '360px', height: '175px'}, 300);
			$('.contentbox label').css('width', '100px');
		break;
	}
	return false;
}

function Submit(action) {
	switch(action) {
		case 'login':
			form =	$('#login');
			$.post(form.attr('action'), form.serialize(), function(data) {
				data	= $.parseJSON(data);
				if(data.error === false)
					document.location.href = 'game.php';
				else
					alert(data.message);
			});
		break;
		case 'register':
			form =	$('#reg');
			$('.error').removeClass('error');
			$.post(form.attr('action'), form.serialize(), function(data) {
				data	= $.parseJSON(data);
				if(data.error === false) {
					if(data.message == 'done') {
						document.location.href = 'game.php';
					} else {
						$('#reg').remove()
						$('#regbox').append(data.message)
						$('.contentbox').css({height: '205px'}, 300);
					}
				} else {
					$.each(data.message, function(i, mes) {
						console.log(mes);
						$('#reg_'+mes[0]).addClass('error');
					});
				}
			});
		break;
		case 'lost':
			form =	$('#lost');
			$.post(form.attr('action'), form.serialize(), function(data) {
			
			});
		break;
	}
	return false;
}