
</div></div>
</td></tr></table>
</div>
<div id="fb-root"></div>
<script type="text/javascript" src="scripts/base.js"></script>
<script type="text/javascript" src="scripts/login.js"></script>
<script type="text/javascript">
IsCaptchaActive 	= {$game_captcha};
IsRegActive 		= {$reg_close};
lang_reg_closed		= "{$register_closed}";
cappublic			= "{$cappublic}";
fb_permissions		= "{$fb_perm}";
lang				= "{$lang}";

{if $code}
alert("{$code}");
{/if}
</script>
{if $game_captcha}
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<script type="text/javascript">
if(typeof recaptchaload != "undefined" && recaptchaload == true) {
	showRecaptcha();
}
</script>
{/if}
{if $ga_active}
<script type="text/javascript" src="http://www.google-analytics.com/ga.js"></script>
<script type="text/javascript">
try{
var pageTracker = _gat._getTracker("{$ga_key}");
pageTracker._trackPageview();
} catch(err) {}</script>
{/if}
{if $fb_active}
<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">	
initFB("{$fb_key}");
</script>
{/if}
{if $bgm_active}
<script type="text/javascript" src="scripts/soundmanager2.js"></script>	
<script type="text/javascript">	
 
soundManager.url = 'scripts';
soundManager.flashVersion = 8;
soundManager.onready(function() {
	if (soundManager.supported()) {
		var loginbgm = soundManager.createSound({
			id: 'aSound',
			url: '{$bgm_file}',
			volume: 50
		});
		if($.cookie('music') == null || $.cookie('music') == "on"){
			loginbgm.play();
			$('#music').text("{$music_on}");
		}
	} else {
		alert('SoundManager failed to load');
	}
});

function music() {
	var loginbgm = soundManager.getSoundById('aSound');
	var idmusic = $('#music');
	if(idmusic.text() != "{$music_on}")
	{
		loginbgm.play();
		idmusic.text("{$music_on}");
		$.cookie('music', 'on');
	}
	else
	{
		loginbgm.stop();
		idmusic.text("{$music_off}");
		$.cookie('music', 'off');
	}
}
</script>
{/if}
</body>
</html>