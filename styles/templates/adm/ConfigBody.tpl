{include file="adm/overall_header.tpl"}
<center>
<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="70%" cellpadding="2" cellspacing="2">
<tr>
	<td class="c" colspan="2">{$se_server_parameters}</td>
	<td class="c" colspan="1" width="5%">(?)</td>
</tr><tr>
	<th>{$se_name}</th>
	<th><input name="game_name"  value="{$game_name}" type="text" maxlength="60"></th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_lang}</th>
	<th>{html_options name=lang options=$Selector.langs selected=$lang}</th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_general_speed}</th>
	<th><input name="game_speed" value="{$game_speed}" type="text" maxlength="5"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_normal_speed}", CENTER, OFFSETX, -150, OFFSETY, -10, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
	<th>{$se_fleet_speed}</th>
	<th><input name="fleet_speed" value="{$fleet_speed}" type="text" maxlength="5"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_normal_speed_fleet}", CENTER, OFFSETX, -150, OFFSETY, -10, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
	<th>{$se_resources_producion_speed}</th>
	<th><input name="resource_multiplier" value="{$resource_multiplier}" type="text"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_normal_speed_resoruces}", CENTER, OFFSETX, -150, OFFSETY, -10, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
	<th>{$se_forum_link}</th>
	<th><input name="forum_url" size="60" maxlength="254" value="{$forum_url}" type="text"></th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_server_op_close}<br></th>
	<th><input name="closed"{if $game_disable == '1'} checked="checked"{/if} type="checkbox"></th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_server_status_message}<br></th>
	<th><textarea name="close_reason" cols="80" rows="5">{$close_reason}</textarea></th>
	<th>&nbsp;</th>
</tr><tr>
	<td class="c" colspan="2">{$se_server_planet_parameters}</td><td class="c">&nbsp;</td>
</tr><tr>
	<th>{$se_initial_fields}</th>
	<th><input name="initial_fields" maxlength="10" size="10" value="{$initial_fields}" type="text"> {$se_fields} </th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_metal_production}</th>
	<th><input name="metal_basic_income" maxlength="10" size="10" value="{$metal_basic_income}" type="text"> {$se_per_hour}</th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_crystal_production}</th>
	<th><input name="crystal_basic_income" maxlength="10" size="10" value="{$crystal_basic_income}" type="text"> {$se_per_hour}</th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_deuterium_production}</th>
	<th><input name="deuterium_basic_income" maxlength="10" size="10" value="{$deuterium_basic_income}" type="text"> {$se_per_hour}</th>
	<th>&nbsp;</th>
</tr><tr>
	<td class="c" colspan="2">{$se_several_parameters}</td><td class="c">&nbsp;</td>
</tr><tr>
	<th>{$se_min_build_time}</th>
	<th><input name="min_build_time" maxlength="2" size="5" value="{$min_build_time}" type="text"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_min_build_time_info}", CENTER, OFFSETX, -150, OFFSETY, -10, WIDTH, 250);' onMouseOut='return nd();'/></th>
</tr><tr>
	<th>{$se_reg_closed}<br></th>
	<th><input name="reg_closed"{if $reg_closed} checked="checked"{/if} type="checkbox"></th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_verfiy_mail}<br></th>
	<th><input name="user_valid"{if $user_valid} checked="checked"{/if} type="checkbox"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_verfiy_mail_info}", CENTER, OFFSETX, -150, OFFSETY, -10, WIDTH, 250);' onMouseOut='return nd();'/></th>
</tr><tr>
	<th>{$se_admin_protection}</th>
    <th><input name="adm_attack"{if $adm_attack} checked="checked"{/if} type="checkbox"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_title_admins_protection}", CENTER, OFFSETX, -150, OFFSETY, -10, WIDTH, 250);' onMouseOut='return nd();'/></th>
</tr><tr>
	<th>{$se_debug_mode}</th>
	<th><input name="debug"{if $debug} checked="checked"{/if} type="checkbox"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_debug_message}", CENTER, OFFSETX, -150, OFFSETY, -10, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
	<th>{$se_ships_cdr}</th>
	<th><input name="Fleet_Cdr" maxlength="3" size="3" value="{$shiips}" type="text"> %</th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_ships_cdr_message}", CENTER, OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
	<th>{$se_def_cdr}</th>
	<th><input name="Defs_Cdr" maxlength="3" size="3" value="{$defenses}" type="text"> %</th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_def_cdr_message}", CENTER,OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
	<th>{$se_noob_protect}</th>
	<th><input name="noobprotection"{if $noobprot} checked="checked"{/if} type="checkbox"></th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_noob_protect2}</th>
	<th><input name="noobprotectiontime" value="{$noobprot2}" type="text"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_noob_protect_e2}", CENTER, OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
	<th>{$se_noob_protect3}</th>
	<th><input name="noobprotectionmulti" value="{$noobprot3}" type="text"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_noob_protect_e3}", CENTER, OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
	<td class="c" colspan="2">{$se_news_head}</td><td class="c">&nbsp;</td>
</tr><tr>
    <th>{$se_news_active}</th>
    <th><input name="newsframe"{if $newsframe} checked="checked"{/if} type="checkbox"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_news_info}", CENTER, OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
    <th>{$se_news}</th>
    <th><textarea name="NewsText" cols="80" rows="5">{$NewsTextVal}</textarea></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_news_limit}", CENTER, OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
	<td class="c" colspan="2">{$se_recaptcha_head}</td><td class="c">&nbsp;</td>
</tr><tr>
	<th>{$se_recaptcha_active}<br></th>
    <th><input name="capaktiv"{if $capaktiv} checked="checked"{/if}  type="checkbox"></th>
	<th><a href="http://www.recaptcha.net/whyrecaptcha.html" target="_blank"><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_recaptcha_desc}", CENTER, OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></a></th>
</tr><tr>
	<th>{$se_recaptcha_public}</th>
	<th><input name="cappublic" maxlength="40" size="60" value="{$cappublic}" type="text"></th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_recaptcha_private}</th>
	<th><input name="capprivate" maxlength="40" size="60" value="{$capprivate}" type="text"></th>
	<th>&nbsp;</th>
</tr>
<tr>
	<td class="c" colspan="2">{$se_smtp}</td>
	<td class="c"><center><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_smtp_info}", CENTER, OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></center></td>
</tr><tr>
	<th>{$se_smtp_host}</th>
	<th><input name="smtp_host" size="20" value="{$smtp_host}" type="text" autocomplete="off"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_smtp_host_info}", CENTER, OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
	<th>{$se_smtp_ssl}</th>
	<th>{html_options name=smtp_ssl options=$Selector.mail selected=$smtp_ssl}</th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_smtp_ssl_info}", CENTER, OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
	<th>{$se_smtp_port}</th>
	<th><input name="smtp_port" size="20" value="{$smtp_port}" type="text" autocomplete="off"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_smtp_port_info}", CENTER, OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
	<th>{$se_smtp_user}</th>
	<th><input name="smtp_user" size="20" value="{$smtp_user}" type="text" autocomplete="off"></th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_smtp_pass}</th>
	<th><input name="smtp_pass" size="20" value="{$smtp_pass}" type="password" autocomplete="off"></th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_smtp_sendmail}</th>
	<th><input name="smtp_sendmail" size="20" value="{$smtp_sendmail}" type="text" autocomplete="off"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_smtp_sendmail_info}", CENTER, OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
	<td class="c" colspan="2">{$se_ftp}</td>
	<td class="c"><center><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_ftp_info}", CENTER, OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></center></td>
</tr><tr>
	<th>{$se_ftp_host}</th>
	<th><input name="ftp_server" size="20" value="{$ftp_server}" type="text" autocomplete="off"></th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_ftp_user}</th>
	<th><input name="ftp_user_name" size="20" value="{$ftp_user_name}" type="text" autocomplete="off"></th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_ftp_pass}</th>
	<th><input name="ftp_user_pass" size="20" value="{$ftp_user_pass}" type="password" autocomplete="off"></th>
	<th>&nbsp;</th>
</tr><tr>
	<th>{$se_ftp_dir}</th>
	<th><input name="ftp_root_path" size="20" value="{$ftp_root_path}" type="text" autocomplete="off"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_ftp_dir_info}", CENTER, OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
	<td class="c" colspan="2">{$se_google}</td><td class="c">&nbsp;</td>
</tr><tr>
    <th>{$se_google_active}</th>
    <th><input name="ga_active"{if $ga_active} checked="checked"{/if}  type="checkbox"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_google_info}", CENTER, OFFSETX, -150, OFFSETY, -120, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr><tr>
    <th>{$se_google_key}</th>
    <th><input name="ga_key" size="20" maxlength="15" value="{$ga_key}" type="text"></th>
	<th><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onMouseOver='return overlib("{$se_google_key_info}", CENTER, OFFSETX, -150, OFFSETY, -20, WIDTH, 250);' onMouseOut='return nd();'></th>
</tr>
<tr>
	<th colspan="3"><input value="{$se_save_parameters}" type="submit"></th>
</tr>
</table>
</form>
</center>
{include file="adm/overall_footer.tpl"}