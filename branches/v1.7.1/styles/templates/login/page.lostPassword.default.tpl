{block name="title" prepend}{$LNG.siteTitleLostPassword}{/block}
{block name="content"}
<p>{$LNG.passwordInfo}</p>
<form action="index.php?page=lostPassword" method="post" data-action="index.php?page=lostPassword" >
<input type="hidden" value="send" name="mode">
<div class="formRow">
	<label for="universe">{$LNG.universe}</label>
	<select name="uni" class="changeAction" id="universe">{html_options options=$universeSelect selected=$UNI}</select>
</div>
<div class="formRow">
	<label for="username">{$LNG.passwordUsername}</label>
	<input type="text" name="username" id="username">
</div>
<div class="formRow">
	<label for="mail">{$LNG.passwordMail}</label>
	<input type="text" name="mail" id="mail">
</div>
{if $recaptchaEnable}
<div class="formRow">
	<div id="recaptcha_widget">
		<label for="recaptcha_response_field">{$LNG.registerCaptcha}<p class="captchaButtons"><a href="javascript:Recaptcha.reload()">{$LNG.registerCaptchaReload}</a></p></label>
		<div id="recaptcha_input_wrap"><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="input"></div>
		<span class="inputDesc">{$LNG.registerCaptchaDesc}</span>		
		<div id="recaptcha_image"></div>
	</div>
	<div class="clear"></div>
</div>
{/if}
<div class="formRow">
	<input type="submit" class="submitButton" value="{$LNG.passwordSubmit}">
</div>
</form>
{/block}
{block name="script" append}
{if $recaptchaEnable}
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<script type="text/javascript">
var RecaptchaOptions = {
	lang : '{$lang}',
};

var recaptchaPublicKey = "{$recaptchaPublicKey}";

Recaptcha.create(recaptchaPublicKey, 'display_captcha', {
	theme: 'custom',
	tabindex: '6',
	custom_theme_widget: 'display_captcha'
});

</script>
{/if}
{/block}