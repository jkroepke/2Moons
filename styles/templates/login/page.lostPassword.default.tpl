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
<div class="formRow" id="captchaRow">
	<div>
		<label>{$LNG.registerCaptcha}<p class="captchaButtons"></p></label>
		<div class="g-recaptcha" data-sitekey="{$recaptchaPublicKey}"></div>
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
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl={$lang}"></script>
{/if}
{/block}