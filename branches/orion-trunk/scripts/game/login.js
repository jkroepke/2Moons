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
		case 'register_fast':
			showRecaptcha();
			$('#regbox').show();
			$('.contentbox').css({width: '560px', height: CONF['IsCaptchaActive'] == 0 ? '341px' : '417px'});		
			$('.contentbox label').css('width', '257px');
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
		case 'reg':
			form =	$('#reg');
			$('.error').removeClass('error');
			$.post(form.attr('action'), form.serialize(), function(data) {
				data	= $.parseJSON(data);
				if(data.error === false) {
					if(data.message == 'done') {
						document.location.href = 'game.php';
					} else {
						$('#reg').remove()
						$('#regbox .fb_login').remove()
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
			}).fail(function(data) {
				alert($(data.responseText).find("td.left").html(function(i, old) {
					return old.replace(/<br>/g, "\n");
				}).text());
			});
		break;
		case 'lost':
			form =	$('#lost');
			$.post(form.attr('action'), form.serialize(), function(data) {
				data	= $.parseJSON(data);
				alert(data.message);
				if(data.error === false)
					form.find('input:text').val('');
			});
		break;
	}
	return false;
}

function initFormHandler() {
	$('input:not(:button)').each(function(i, val){
		$(this).keydown(function(event) {
			if (event.keyCode == '13')
				Submit($(this).parent().attr('id'));
		});
	});
}

function initLangs() {
	$.each(CONF['Lang'], function(key, name) {
		$('#lang').prepend('<li><a href="javascript:setLNG(\''+key+'\')"><span class="flags '+key+'" title="'+name+'"></span></a></li>');
		$('select.lang').append('<option value="'+key+'">'+name+'</option>');
		CONF['avaLangs'].push(key);
	});
}

function initCloseReg() {
	$('#reg_universe option').text(function(i, name) {
		return (CONF.RegClosedUnis[$(this).val()] == 1 && name.search(LANG['uni_closed']) == -1) ? name+' '+LANG['uni_closed'] : name;
	});
}

function changeUni(uni) {
	$.cookie('uni', uni);
	document.location.reload();
}

function RefRegister() {
	Content('register_fast');
	$('.fb_login').remove();
}

/** FB Functions **/


function FBinit() {
    FB.init({
		appId      : CONF['FBKey'],
		status     : false,
		cookie     : true,
		xfbml      : false
    });
	
	if(document.location.search == '?extauth=facebook') {
		FBlogin();
	}
}
function FBlogin() {
	FBUniverse	= $('#universe').val();
	FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {
			FBCheckIfKnownUser();
		} else {
			FB.login(function(response) {
				if (response.authResponse) {
					FBCheckIfKnownUser();
				}
			}, {scope:'email'});
		}
	});
}

function FBCheckIfKnownUser() {
	$.getJSON('?uni='+FBUniverse+'&page=reg&action=check&mode=fbid&value='+response.authResponse.userID, function(data) {
		if(data.exists === true) {
			FBRediectToGame();
		} else {
			FBRegUser();
		}
	});
}

function FBRediectToGame() {
	document.location.href = '?uni='+FBUniverse+'&page=extauth&method=facebook';
}

function FBRegUser() {
	FB.api('/me', function(response) {
		FBUniverse	= $('#universe').val();
		$.getJSON('?uni='+FBUniverse+'&page=reg&action=check&mode=email&value='+response.email, function(data) {
			if(data.exists) {
				document.location.href = '?uni='+FBUniverse+'&page=fblogin&mode=register';
			} else {
				if(response.locale.substr(0, 2) != CONF['lang'] && $.inArray(response.locale.substr(0, 2), CONF['avaLangs']) !== -1)
					setLNG(response.locale.substr(0, 2), '?fb=reg');
				else
					FBRegister(response);
			}
		});
	});
}

function FBRegister(data) {
	console.log(data);
	Content('register_fast');
	$('.fb_login').remove();
	$('#fb_id').val(data.id);
	$('#reg_email').val(data.email);
	$('#reg_email_2').val(data.email);
}

$(function() {
	initFormHandler();
	initLangs();
	initCloseReg();
	if(CONF['ref_active'] == 1 && document.location.search.search('/?ref=') !== -1) {
		RefRegister();
	}
	
	if(CONF.htaccess) {
		$('select[name=uni]').each(function() {
			var $this	= $(this);
			$this.parents('form').attr('action', function(i, old) {
				return old.replace(/.*index\.php/, '../uni'+$this.val()+'/index.php');
			});
		}).on('change', function() {
			var $this	= $(this);
			$this.parents('form').attr('action', function(i, old) {
				return old.replace(/.*index\.php/, '../uni'+$this.val()+'/index.php');
			});
		});
	}
});