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

function setLNG(LNG, Query) {
	$.cookie('lang', LNG);
	if(typeof Query === "undefined")
		document.location.reload();
	else
		document.location.href = document.location.href+Query;
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
					var errormes = '';
					$.each(data.message, function(i, mes) {
						showRecaptcha();
						errormes	+= mes[1]+"\n";
						if(mes[0] === 'captcha')
							$('#recaptcha_response_field').addClass('error');
						else
							$('#reg_'+mes[0]).addClass('error');
					});
					alert(errormes);
				}
			});
		break;
		case 'lost':
			form =	$('#lost');
			$.post(form.attr('action'), form.serialize(), function(data) {
				alert($.parseJSON(data).message);
			});
		break;
	}
	return false;
}

function init(){
	initLangs();
	if(document.location.search == '?fb=reg')
		FBRegister();
}

function initLangs() {
	$.each(CONF['Lang'], function(key, name) {
		$('#lang').prepend('<li><a href="javascript:setLNG(\''+key+'\')"><span class="flags '+key+'" title="'+name+'"></span></a></li>');
		$('select.lang').append('<option value="'+key+'">'+name+'</option>');
		CONF['avaLangs'].push(key);
	});
}

/** FB Functions **/


function FBinit() {
	FB.init({appId: CONF['FBKey'], status: false, cookie: true});
}

function FBlogin() {
	FBUniverse	= $('#universe').val();
	FB.getLoginStatus(function(response) {
		if (response.session) {
			FBCheckRegister(response.session.uid);
		} else {
			FB.login(function(login) {
				if (login.session && login.perms) {
					FBCheckUser();
				}
			}, {perms:'read_stream,publish_stream,offline_access,email'});
		}
	});
}

function FBCheckRegister(ID){
	$.getJSON('?uni='+FBUniverse+'&page=reg&action=check&mode=fbid&value='+ID, function(data) {
		if(data.exists === true) {
			document.location.href = '?uni='+FBUniverse+'&page=fblogin';
		} else {
			FBCheckUser();
		}
	});
}

function FBCheckUser(user) {
	if(typeof user !== "object") {
		FBgetUser(FBCheckUser);
		return;
	}
	
	FBUniverse	= $('#universe').val();
	$.getJSON('?uni='+FBUniverse+'&page=reg&action=check&mode=email&value='+user.email, function(data) {
		if(data.exists) {
			document.location.href = '?uni='+FBUniverse+'&page=fblogin&mode=register';
		} else {
			if(user.locale.substr(0, 2) != CONF['lang'] && $.inArray(user.locale.substr(0, 2), CONF['avaLangs']) !== -1)
				setLNG(user.locale.substr(0, 2), '?fb=reg');
			else
				FBRegister(user);
		}
	});
}

function FBRegister(data) {
	if(typeof data !== "object") {
		FBgetUser(FBRegister);
		return;
	}
	Content('register');
	$('.fb_login').remove();
	$('#fb_id').val(data.id);
	$('#reg_email').val(data.email);
	$('#reg_email_2').val(data.email);
}

function FBgetUser(callback) {
	FB.api('/me', callback);
}

function FBHandler(data, UNI) {
	$.getJSON('?uni='+UNI+'page=reg&action=check&mode=fbid&value='+data.id, function(data) {
		if(data.exists) {
			return;
		} else {
			if($.inArray(data.locale.substr(0, 2), CONF['avaLangs']) !== -1)
				setLNG(data.locale.substr(0, 2), '?fb=reg');
		}
	});
}