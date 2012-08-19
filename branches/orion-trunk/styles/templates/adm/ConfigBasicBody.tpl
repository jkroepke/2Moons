{include file="overall_header.tpl"}
<center>
<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="70%" cellpadding="2" cellspacing="2">
<tr>
	<th colspan="2">{$LNG.se_server_parameters}</th>
	<th colspan="1" width="5%">(?)</th>
</tr><tr>
	<td>{$LNG.se_game_name}</td>
	<td><input name="game_name" value="{$game_name}" type="text" maxlength="60"></td>
	<td>&nbsp;</td>
</tr><tr>
    <td>{$LNG.se_ttf_file}</td>
    <td><input name="ttf_file" size="40" value="{$ttf_file}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.se_ttf_file_info}"></td>
</tr><tr>
    <td>{$LNG.se_timzone}</td>
	<td>{html_options name=timezone options=$Selector.timezone selected=$timezone}</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<th colspan="2">{$LNG.se_player_settings}</th><th>&nbsp;</th>
</tr><tr>
	<td>{$LNG.se_del_oldstuff}</td>
	<td><input name="del_oldstuff" maxlength="3" size="2" value="{$del_oldstuff}" type="text"> {$LNG.se_days}</td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.se_del_oldstuff_info}"></td>
</tr><tr>
	<td>{$LNG.se_del_user_manually}</td>
	<td><input name="del_user_manually" maxlength="3" size="2" value="{$del_user_manually}" type="text"> {$LNG.se_days}</td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.se_del_user_manually_info}"></td>
</tr><tr>
	<td>{$LNG.se_del_user_automatic}</td>
	<td><input name="del_user_automatic" maxlength="3" size="2" value="{$del_user_automatic}" type="text"> {$LNG.se_days}</td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.se_del_user_automatic_info}"></td>
</tr><tr>
	<td>{$LNG.se_sendmail_inactive}<br></td>
    <td><input name="sendmail_inactive"{if $sendmail_inactive} checked="checked"{/if}  type="checkbox"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$LNG.se_del_user_sendmail}</td>
	<td><input name="del_user_sendmail" maxlength="3" size="2" value="{$del_user_sendmail}" type="text"> {$LNG.se_days}</td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.se_del_user_sendmail_info}"></td>
</tr><tr>
	<th colspan="2">{$LNG.se_recaptcha_head}</th><th>&nbsp;</th>
</tr><tr>
	<td>{$LNG.se_recaptcha_active}<br></td>
    <td><input name="capaktiv"{if $capaktiv} checked="checked"{/if}  type="checkbox"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.se_recaptcha_desc}"></td>
</tr><tr>
	<td>{$LNG.se_recaptcha_public}</td>
	<td><input name="cappublic" maxlength="40" size="60" value="{$cappublic}" type="text"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$LNG.se_recaptcha_private}</td>
	<td><input name="capprivate" maxlength="40" size="60" value="{$capprivate}" type="text"></td>
	<td>&nbsp;</td>
</tr><tr>
	<th colspan="2">{$LNG.se_smtp}</th>
	<th><center><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.se_smtp_info}"></center></th>
</tr><tr>
	<td>{$LNG.se_mail_active}</td>
	<td><input name="mail_active"{if $mail_active} checked="checked"{/if}  type="checkbox"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$LNG.se_mail_use}</td>
	<td>{html_options name=mail_use options=$Selector.mail selected=$mail_use}</td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$LNG.se_smtp_sendmail}</td>
	<td><input name="smtp_sendmail" size="20" value="{$smtp_sendmail}" type="text" autocomplete="off"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.se_smtp_sendmail_info}"></td>
</tr><tr>
	<td>{$LNG.se_smail_path}</td>
	<td><input name="smail_path" size="20" value="{$smail_path}" type="text"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$LNG.se_smtp_host}</td>
	<td><input name="smtp_host" size="20" value="{$smtp_host}" type="text" autocomplete="off"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.se_smtp_host_info}"></td>
</tr><tr>
	<td>{$LNG.se_smtp_ssl}</td>
	<td>{html_options name=smtp_ssl options=$Selector.encry selected=$smtp_ssl}</td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.se_smtp_ssl_info}"></td>
</tr><tr>
	<td>{$LNG.se_smtp_port}</td>
	<td><input name="smtp_port" size="20" value="{$smtp_port}" type="text" autocomplete="off"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.se_smtp_port_info}"></td>
</tr><tr>
	<td>{$LNG.se_smtp_user}</td>
	<td><input name="smtp_user" size="20" value="{$smtp_user}" type="text" autocomplete="off"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$LNG.se_smtp_pass}</td>
	<td><input name="smtp_pass" size="20" value="{$smtp_pass}" type="password" autocomplete="off"></td>
	<td>&nbsp;</td>
</tr><tr>
	<th colspan="2">{$LNG.se_google}</th><th>&nbsp;</th>
</tr><tr>
    <td>{$LNG.se_google_active}</td>
    <td><input name="ga_active"{if $ga_active} checked="checked"{/if}  type="checkbox"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.se_google_info}"></td>
</tr><tr>
    <td>{$LNG.se_google_key}</td>
    <td><input name="ga_key" size="20" maxlength="15" value="{$ga_key}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.se_google_key_info}"></td>
</tr><tr>
	<td colspan="3"><input value="{$LNG.se_save_parameters}" type="submit"></td>
</tr>
</table>
</form>
</center>
{include file="overall_footer.tpl"}