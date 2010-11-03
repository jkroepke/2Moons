{if !$getajax}{include file="public/index_header.tpl"}{/if}
{if $game_captcha}<script type="text/javascript">if(typeof $ == "undefined") 
{
        recaptchaload = true;
} else { 
        $(document).ready(function(){ showRecaptcha(); });
}</script>{/if}
<table id='registration' class='box-complex box box-full box1'><tr><td><table class='box1_box-header box-header'><tr><td class='box1_box-header-left box-header-left'>&nbsp;</td><td class='box1_box-header-center box-header-center'>&nbsp;</td><td class='box1_box-header-right box-header-right'>&nbsp;</td></tr></table></td></tr><tr><td><table class='box1_box-content box-content'><tr><td class='box1_box-content-left box-content-left'>&nbsp;</td><td class='box1_box-content-center box-content-center'><div class='box1_content'><center>
<div id='logo_v2'></div>
<br>
<br></center><table id='registration-inside' class='box-complex box box-compact box5' style="width:80%"><tr><td><table class='box5_box-header box-header'><tr><td class='box5_box-header-left box-header-left'>&nbsp;</td><td class='box5_box-header-center box-header-center'><div class='box5_box-title-wrapper box-title-wrapper'><div class='box5_box-title-container box-title-container'><table class='box5_box-title box-title'><tr><td class='box5_box-title-left box-title-left'>&nbsp;</td>
<td class='box5_box-title-center box-title-center'>{$register}</td><td class='box5_box-title-right box-title-right'>&nbsp;</td></tr></table></div></div></td><td class='box5_box-header-right box-header-right'>&nbsp;</td></tr></table></td></tr><tr><td><table class='box5_box-content box-content'><tr><td class='box5_box-content-left box-content-left'>&nbsp;</td><td class='box5_box-content-center box-content-center'><div class='box5_content'><div class='box5_box-title-pad box-title-pad'>&nbsp;</div><table class='layout' cellpadding='5'><tr><th colspan='2'>
<form name="reg" action="" method="post" onsubmit="return changeAction('reg');">
<br>
<br>
<table style="width:100%;text-align:center;padding-top:3px;" align="center">
	<tr>
		<td>{$uni_reg}:</td>
		<td><select name="Uni" id="Uni" style="width: 188px; position: relative; left: 4px;">
            <option value="">{$chose_a_uni}</option>
			{foreach item=Universe key=ID from=$AvailableUnis}<option value="{$ID}">{$Universe.game_name}{if $Universe.game_disable == 0} {$uni_closed}{/if}</option>{/foreach}
			</select></td> 
	</tr>
	<tr>
		<td>{$user_reg}:</td>
		<td><input name="character" size="30" maxlength="20" type="text" tabindex="0" class="input-text"></td> 
	</tr>
	<tr>
		<td>{$pass_reg}:</td>
		<td><input name="password" size="30" maxlength="20" type="password" tabindex="1" class="input-text"></td>
	</tr>
	<tr>
		<td>{$pass2_reg}:</td>
		<td><input name="password2" size="30" maxlength="20" type="password" tabindex="2" class="input-text"></td>
	</tr>
	<tr>
		<td>{$email_reg}:</td>
		<td><input name="email" size="30" maxlength="40" type="text" tabindex="3" class="input-text"></td>
	</tr>
	<tr>
		<td>{$email2_reg}:</td>
		<td><input name="email2" size="30" maxlength="40" type="text" tabindex="4" class="input-text"></td>
	</tr>
	<tr>
		<td>{$planet_reg}:</td>
		<td><input name="planet" size="30" maxlength="40" type="text" tabindex="5" class="input-text"></td>
	</tr>
	<tr>
		<td>{$lang_reg}:</td>
		<td><select name="lang" style="width: 206px;" tabindex="6">{html_options options=$AvailableLangs selected=$lang}</select></td>
	</tr>
	{if $game_captcha}
	<tr>
		<td style="vertical-align:top;"><br>{$captcha_reg}:<br><br><div><a href="javascript:Recaptcha.reload()">{$captcha_reload}</a></div>
	<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">{$captcha_get_audio}</a></div>
	<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">{$captcha_get_image}</a></div>
	<div><a href="javascript:Recaptcha.showhelp()">{$captcha_help}</a></div>
	</td>
		<td><br><center><div id="display_captcha" style="display:none"><div id="recaptcha_image"></div><input type="text" id="recaptcha_response_field" size="30" maxlength="40" tabindex="7" name="recaptcha_response_field" class="input-text"></div></center></td>
	</tr>
	{/if}
	<tr>
		<td colspan="2"><input name="rgt" type="checkbox">{$accept_terms_and_conditions}</td>
	</tr>
	<tr>
		<th colspan="2"><input class="input-button" type="submit" value="{$send}"></th>
	</tr>
</table>
</form></th></tr>
</table>
</div></td><td class='box5_box-content-right box-content-right'>&nbsp;</td></tr></table></td></tr><tr><td><table class='box5_box-footer box-footer'><tr><td class='box5_box-footer-left box-footer-left'>&nbsp;</td><td class='box5_box-footer-center box-footer-center'>&nbsp;</td><td class='box5_box-footer-right box-footer-right'>&nbsp;</td></tr></table></td></tr></table><div class='box1_box-status-pad box-status-pad'>&nbsp;</div></div></td><td class='box1_box-content-right box-content-right'>&nbsp;</td></tr></table></td></tr><tr><td><table class='box1_box-footer box-footer'><tr><td class='box1_box-footer-left box-footer-left'>&nbsp;</td><td class='box1_box-footer-center box-footer-center'><div class='box1_box-status-wrapper box-status-wrapper'><div class='box1_box-status-container box-status-container'><table class='box1_box-status box-status'><tr><td class='box1_box-status-left box-status-left'>&nbsp;</td><td class='box1_box-status-center box-status-center'></td>
<td class='box1_box-status-right box-status-right'>&nbsp;</td></tr></table></div></div></td><td class='box1_box-footer-right box-footer-right'>&nbsp;</td></tr></table>
<table class='box1_box-footer box-footer'><tr><td class='box1_box-footer-left box-footer-left'>&nbsp;</td><td class='box1_box-footer-center box-footer-center'><div class='box1_box-status-wrapper box-status-wrapper'><div class='box1_box-status-container box-status-container'><table class='box1_box-status box-status'><tr><td class='box1_box-status-left box-status-left'>&nbsp;</td>
<td class='box1_box-status-center box-status-center'>&nbsp;</td>
<td class='box1_box-status-right box-status-right'>&nbsp;</td></tr></table></div></div></td><td class='box1_box-footer-right box-footer-right'>&nbsp;</td></tr></table></td></tr></table>
{if !$getajax}{include file="public/index_footer.tpl"}{/if}