</div>
	<footer>
		<a href="index.php?page=disclamer">{$LNG.menu_disclamer}</a><br>Powered by <a href="http://2moons.cc" title="2Moons" target="copy">2Moons</a> 2009-2012
	</footer>
</div>
<div id="dialog" style="display:none;"></div>
<script type="text/javascript" src="scripts/base/jquery.js?v={$REV}"></script>
<script type="text/javascript" src="scripts/base/jquery.cookie.js?v={$REV}"></script>
<script type="text/javascript" src="scripts/base/jquery.fancybox.js?v={$REV}"></script>
<script type="text/javascript" src="scripts/game/login.js?v={$REV}"></script>
<script type="text/javascript">
var CONF			= {
	RegClosedUnis	: {if isset($RegClosedUnis)}{$RegClosedUnis}{else}[]{/if},
	IsCaptchaActive : {$game_captcha},
	ref_active		: {$ref_active},
	cappublic		: "{$cappublic}",
	FBActive		: {$fb_active},
	FBKey			: "{$fb_key}",
	Lang			: {$langs},
	MultiUniverse	: $('#universe').children().length !== 1 ? true : false,
	uni				: {$UNI},
	avaLangs		: new Array(),
	lang			: "{$lang}",
	htaccess		: {$htaccess}
};
var LANG			= {
	register		: "{$LNG.register_now}",
	login			: "{$LNG.login}",
	uni_closed		: "{$LNG.uni_closed}"
};

{if isset($code)}
alert("{$code}");
{/if}
</script>
{if $fb_active}
<div id="fb-root"></div>
<script>
	window.fbAsyncInit = FBinit;
	(function(d){
		var js, id = 'facebook-jssdk'; if (d.getElementById(id)) return;
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/en_US/all.js";
		d.getElementsByTagName('head')[0].appendChild(js);
	}(document));
</script>
{/if}
{if $game_captcha}
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
{/if}
{if $ga_active}
<script type="text/javascript" src="http://www.google-analytics.com/ga.js"></script>
<script type="text/javascript">
try{
var pageTracker = _gat._getTracker("{$ga_key}");
pageTracker._trackPageview();
} catch(err) {}</script>
{/if}
{block name="script"}{/block}
</body>
</html>