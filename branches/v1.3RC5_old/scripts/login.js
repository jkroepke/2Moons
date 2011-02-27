function ajax(url){
	$('#background-content').load(url);
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

function initFB(APIKey)
{
	FB.init({appId: APIKey, status: false, cookie: true});
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