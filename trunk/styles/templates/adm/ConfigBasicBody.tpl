{include file="adm/overall_header.tpl"}
<center>
<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="70%" cellpadding="2" cellspacing="2">
<tr>
	<th colspan="2">{lang}se_server_parameters{/lang}</th>
	<th colspan="1" width="5%">(?)</th>
</tr><tr>
	<td>{lang}se_game_name{/lang}</td>
	<td><input name="game_name" value="{$game_name}" type="text" maxlength="60"></td>
	<td>&nbsp;</td>
</tr><tr>
    <td>{lang}se_ttf_file{/lang}</td>
    <td><input name="ttf_file" size="40" value="{$ttf_file}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{lang}se_ttf_file_info{/lang}"></td>
</tr><tr>
    <td>{lang}se_timzone{/lang}</td>
	<td>{html_options name=timezone options=$Selector.timezone selected=$timezone}</td>
	<td>&nbsp;</td>
</tr><tr>
	<th colspan="2">{lang}se_player_settings{/lang}</th><th>&nbsp;</th>
</tr><tr>
	<td>{lang}se_del_oldstuff{/lang}</td>
	<td><input name="del_oldstuff" maxlength="3" size="2" value="{$del_oldstuff}" type="text"> {lang}se_days{/lang}</td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{lang}se_del_oldstuff_info{/lang}"></td>
</tr><tr>
	<td>{lang}se_del_user_manually{/lang}</td>
	<td><input name="del_user_manually" maxlength="3" size="2" value="{$del_user_manually}" type="text"> {lang}se_days{/lang}</td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{lang}se_del_user_manually_info{/lang}"></td>
</tr><tr>
	<td>{lang}se_del_user_automatic{/lang}</td>
	<td><input name="del_user_automatic" maxlength="3" size="2" value="{$del_user_automatic}" type="text"> {lang}se_days{/lang}</td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{lang}se_del_user_automatic_info{/lang}"></td>
</tr><tr>
	<td>{lang}se_sendmail_inactive{/lang}<br></td>
    <td><input name="sendmail_inactive"{if $sendmail_inactive} checked="checked"{/if}  type="checkbox"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{lang}se_del_user_sendmail{/lang}</td>
	<td><input name="del_user_sendmail" maxlength="3" size="2" value="{$del_user_sendmail}" type="text"> {lang}se_days{/lang}</td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{lang}se_del_user_sendmail_info{/lang}"></td>
</tr><tr>
	<th colspan="2">{lang}se_recaptcha_head{/lang}</th><th>&nbsp;</th>
</tr><tr>
	<td>{lang}se_recaptcha_active{/lang}<br></td>
    <td><input name="capaktiv"{if $capaktiv} checked="checked"{/if}  type="checkbox"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{lang}se_recaptcha_desc{/lang}"></td>
</tr><tr>
	<td>{lang}se_recaptcha_public{/lang}</td>
	<td><input name="cappublic" maxlength="40" size="60" value="{$cappublic}" type="text"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{lang}se_recaptcha_private{/lang}</td>
	<td><input name="capprivate" maxlength="40" size="60" value="{$capprivate}" type="text"></td>
	<td>&nbsp;</td>
</tr><tr>
	<th colspan="2">{lang}se_smtp{/lang}</th>
	<th><center><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{lang}se_smtp_info{/lang}"></center></th>
</tr><tr>
	<td>{lang}se_mail_active{/lang}</td>
	<td><input name="mail_active"{if $mail_active} checked="checked"{/if}  type="checkbox"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{lang}se_mail_use{/lang}</td>
	<td>{html_options name=mail_use options=$Selector.mail selected=$mail_use}</td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{lang}se_smtp_sendmail{/lang}</td>
	<td><input name="smtp_sendmail" size="20" value="{$smtp_sendmail}" type="text" autocomplete="off"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{lang}se_smtp_sendmail_info{/lang}"></td>
</tr><tr>
	<td>{lang}se_smail_path{/lang}</td>
	<td><input name="smail_path" size="20" value="{$smail_path}" type="text"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{lang}se_smtp_host{/lang}</td>
	<td><input name="smtp_host" size="20" value="{$smtp_host}" type="text" autocomplete="off"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{lang}se_smtp_host_info{/lang}"></td>
</tr><tr>
	<td>{lang}se_smtp_ssl{/lang}</td>
	<td>{html_options name=smtp_ssl options=$Selector.encry selected=$smtp_ssl}</td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{lang}se_smtp_ssl_info{/lang}"></td>
</tr><tr>
	<td>{lang}se_smtp_port{/lang}</td>
	<td><input name="smtp_port" size="20" value="{$smtp_port}" type="text" autocomplete="off"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{lang}se_smtp_port_info{/lang}"></td>
</tr><tr>
	<td>{lang}se_smtp_user{/lang}</td>
	<td><input name="smtp_user" size="20" value="{$smtp_user}" type="text" autocomplete="off"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{lang}se_smtp_pass{/lang}</td>
	<td><input name="smtp_pass" size="20" value="{$smtp_pass}" type="password" autocomplete="off"></td>
	<td>&nbsp;</td>
</tr><tr>
	<th colspan="2">{lang}se_google{/lang}</th><th>&nbsp;</th>
</tr><tr>
    <td>{lang}se_google_active{/lang}</td>
    <td><input name="ga_active"{if $ga_active} checked="checked"{/if}  type="checkbox"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{lang}se_google_info{/lang}"></td>
</tr><tr>
    <td>{lang}se_google_key{/lang}</td>
    <td><input name="ga_key" size="20" maxlength="15" value="{$ga_key}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{lang}se_google_key_info{/lang}"></td>
</tr><tr>
	<th colspan="2">{lang}se_bgm_login{/lang}</th><th>&nbsp;</th>
</tr>
<tr>
	<td colspan="3"><input value="{lang}se_save_parameters{/lang}" type="submit"></td>
</tr>
</table>
</form>
</center>
{include file="adm/overall_footer.tpl"}