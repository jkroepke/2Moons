<script>document.body.style.overflow = "auto";</script> 
<style>a.big{color:#00CCFF;font-size:14px;}a.big:hover{color:#FFFFFF;font-size:14px;}</style>
<body>
<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="70%" cellpadding="2" cellspacing="2">
<tr>
	<td class="c" colspan="2">{se_server_parameters}</td>
</tr><tr>
	<th>{se_name}</th>
	<th><input name="game_name"  size="16" value="{game_name}" type="text" maxlength="60">&nbsp;&nbsp;&nbsp;
	<a href="#" onMouseOver='return overlib("{se_server_naame}", CENTER, OFFSETX, 120, OFFSETY, -40, WIDTH, 250);' onMouseOut='return nd();' class="big">[?]</a></th>
</tr><tr>
	<th>{se_cookie_name}</th>
	<th><input name="cookie_name" maxlength="15" size="16" value="{cookie}" type="text">&nbsp;&nbsp;&nbsp;
	<a href="#" onMouseOver='return overlib("{se_cookie_advert}", CENTER, OFFSETX, 120, OFFSETY, -40, WIDTH, 250);' onMouseOut='return nd();' class="big">[?]</a></th>
</tr><tr>
	<th>{se_lang}</th>
	<th><select name="language">{language_settings}</select></th>
</tr><tr>
	<th>{se_general_speed}</th>
	<th><input name="game_speed" size="5" value="{game_speed}" type="text" maxlength="5">&nbsp;&nbsp;&nbsp;
	<a href="#" onMouseOver='return overlib("{se_normal_speed}", CENTER, OFFSETX, 120, OFFSETY, -40, WIDTH, 250);' onMouseOut='return nd();' class="big">[?]</a></th>
</tr><tr>
	<th>{se_fleet_speed}</th>
	<th><input name="fleet_speed" size="5" value="{fleet_speed}" type="text" maxlength="5">&nbsp;&nbsp;&nbsp;
	<a href="#" onMouseOver='return overlib("{se_normal_speed_fleett}", CENTER, OFFSETX, 120, OFFSETY, -40, WIDTH, 250);' onMouseOut='return nd();' class="big">[?]</a></th>
</tr><tr>
	<th>{se_resources_producion_speed}</th>
	<th><input name="resource_multiplier" size="5" value="{resource_multiplier}" type="text">&nbsp;&nbsp;&nbsp;
	<a href="#" onMouseOver='return overlib("{se_normal_speed_resoruces}", CENTER, OFFSETX, 120, OFFSETY, -40, WIDTH, 250);' onMouseOut='return nd();' class="big">[?]</a></th></th>
</tr><tr>
	<th>{se_forum_link}</th>
	<th><input name="forum_url" size="60" maxlength="254" value="{forum_url}" type="text"></th>
</tr><tr>
	<th>{se_server_op_close}<br /></th>
	<th><input name="closed"{closed} type="checkbox" /></th>
</tr><tr>
	<th>{se_server_status_message}<br /></th>
	<th><textarea name="close_reason" cols="80" rows="5" size="80" >{close_reason}</textarea></th>
</tr><tr>
    <th>News aktivieren<br /></th>
    <th><input name="newsframe"{newsframe} type="checkbox" /></th>
</tr><tr>
    <th>News</th>
    <th colspan="2"><textarea name="NewsText" cols="80" rows="5" size="80" >{NewsTextVal}</textarea></th>
</tr><tr>
	<td class="c" colspan="2">{se_server_planet_parameters}</td>
</tr><tr>
	<th>{se_initial_fields}</th>
	<th><input name="initial_fields" maxlength="5" size="5" value="{initial_fields}" type="text"> {se_fields} </th>
</tr><tr>
	<th>{se_metal_production}</th>
	<th><input name="metal_basic_income" maxlength="5" size="5" value="{metal_basic_income}" type="text"> {se_per_hour}</th>
</tr><tr>
	<th>{se_crystal_production}</th>
	<th><input name="crystal_basic_income" maxlength="5" size="5" value="{crystal_basic_income}" type="text"> {se_per_hour}</th>
</tr><tr>
	<th>{se_deuterium_production}</th>
	<th><input name="deuterium_basic_income" maxlength="5" size="5" value="{deuterium_basic_income}" type="text"> {se_per_hour}</th>
</tr><tr>
	<td class="c" colspan="2">{se_several_parameters}</td>
</tr><tr>
	<th>{se_min_build_time}</th>
	<th><input name="min_build_time" maxlength="2" size="5" value="{min_build_time}" type="text">min</th>
</tr><tr>
	<th>{se_reg_closed}<br></th>
	<th><input name="reg_closed"{reg_closed} type="checkbox" /></th>
</tr><tr>
	<th>UserVail Funktion<br></th>
	<th><input name="user_valid"{user_valid} type="checkbox" /></th>
</tr><tr>
	<th>{se_admin_protection}&nbsp;&nbsp;&nbsp;
	<a href="#" onMouseOver='return overlib("{se_title_admins_protection}", CENTER, OFFSETX, 120, OFFSETY, -40, WIDTH, 250);' onMouseOut='return nd();' class="big">[?]</a></th>
    <th><input name="adm_attack" {adm_attack} type="checkbox" />
	</th>
</tr><tr>
	<th>{se_debug_mode}&nbsp;&nbsp;&nbsp;
	<a href="#" onMouseOver='return overlib("{se_debug_message}", CENTER, OFFSETX, 120, OFFSETY, -40, WIDTH, 250);' onMouseOut='return nd();' class="big">[?]</a></th>
	<th><input name="debug"{debug} type="checkbox" /></th>
</tr><tr>
	<th>{se_ships_cdr}</th>
	<th><input name="Fleet_Cdr" maxlength="3" size="3" value="{shiips}" type="text"> %&nbsp;&nbsp;&nbsp;
	<a href="#" onMouseOver='return overlib("{se_ships_cdr_message}", CENTER, OFFSETX, 120, OFFSETY, -40, WIDTH, 250);' onMouseOut='return nd();' class="big">[?]</a></th>
</tr><tr>
	<th>{se_def_cdr}</th>
	<th><input name="Defs_Cdr" maxlength="3" size="3" value="{defenses}" type="text"> %&nbsp;&nbsp;&nbsp;
	<a href="#" onMouseOver='return overlib("{se_def_cdr_message}", CENTER, OFFSETX, 120, OFFSETY, -40, WIDTH, 250);' onMouseOut='return nd();' class="big">[?]</a></th>
</tr><tr>
	<th>{se_noob_protect}</th>
	<th><input name="noobprotection"{noobprot} type="checkbox" /></th>
</tr><tr>
	<th>{se_noob_protect2}</th>
	<th><input name="noobprotectiontime" maxlength="5" size="5" value="{noobprot2}" type="text">&nbsp;&nbsp;&nbsp;
	<a href="#" onMouseOver='return overlib("{se_noob_protect_e2}", CENTER, OFFSETX, 120, OFFSETY, -40, WIDTH, 250);' onMouseOut='return nd();' class="big">[?]</a></th>
</tr><tr>
	<th>{se_noob_protect3}</th>
	<th><input name="noobprotectionmulti" maxlength="5" size="5" value="{noobprot3}" type="text">&nbsp;&nbsp;&nbsp;
	<a href="#" onMouseOver='return overlib("{se_noob_protect_e3}", STICKY, CENTER, OFFSETX, 120, MOUSEOFF, OFFSETY, -40, DELAY, 100, WIDTH, 200);' onMouseOut='return nd();' class="big">[?]</a></th>
</tr><tr>
	<td class="c" colspan="2">{se_head_recaptcha}</td>
</tr><tr>
	<th>{se_whats_recaptcha}</th>
	<th>{se_desc_recaptcha}</th>
</tr><tr>
	<th>reCAPTCHA aktivieren<br></th>
    <th><input name="capaktiv" {capaktiv} type="checkbox" /></th>
</tr><tr>
	<th>Public Key</th>
	<th><input name="cappublic" maxlength="40" size="60" value="{cappublic}" type="text"></th>
</tr><tr>
	<th>Private Key:</th>
	<th><input name="capprivate" maxlength="40" size="60" value="{capprivate}" type="text"></th>
</tr>
<tr>
	<td class="c" colspan="2">SMTP-Einstellungen</td>
</tr><tr>
	<th colspan="2">Bei 2Moons werden Mails &uuml;ber einen SMTP-Server gesendet. Trage hier bitte deine Einstellungen für deinen SMTP-Server ein.</th>
</tr><tr>
	<th>SMTP Host:</th>
	<th><input name="smtp_host" size="10" value="{smtp_host}" type="text" autocomplete="off"></th>
</tr><tr>
	<th>SMTP SSL/TLS ?:</th>
	<th><select name="smtp_ssl"><option value="" {smtp_ssl0}>Keine Verschl&uuml;sselung</option><option value="ssl" {smtp_ssl1}>SSL</option><option value="tls" {smtp_ssl2}>TLS</option></select></th>
</tr><tr>
	<th>SMTP Port:</th>
	<th><input name="smtp_port" size="10" value="{smtp_port}" type="text" autocomplete="off"></th>
</tr><tr>
	<th>SMTP User:</th>
	<th><input name="smtp_user" size="10" value="{smtp_user}" type="text" autocomplete="off"></th>
</tr><tr>
	<th>SMTP Pass:</th>
	<th><input name="smtp_pass" size="10" value="{smtp_pass}" type="password" autocomplete="off"></th>
</tr><tr>
	<th colspan="3"><input value="{se_save_parameters}" type="submit"></th>
</tr>
</table>
</form>
</body>