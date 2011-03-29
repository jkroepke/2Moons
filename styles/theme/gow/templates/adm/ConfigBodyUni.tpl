{include file="adm/overall_header.tpl"}
<center>
<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="70%" cellpadding="2" cellspacing="2">
<tr>
	<th colspan="2">{$se_server_parameters}</th>
	<th colspan="1" width="5%">(?)</th>
</tr><tr>
	<td>{$se_uni_name}</td>
	<td><input name="uni_name" value="{$uni_name}" type="text" maxlength="60"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$se_lang}</td>
	<td>{html_options name=lang options=$Selector.langs selected=$lang}</td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$se_general_speed}</td>
	<td><input name="game_speed" value="{$game_speed}" type="text" maxlength="5"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_normal_speed}"></td>
</tr><tr>
	<td>{$se_fleet_speed}</td>
	<td><input name="fleet_speed" value="{$fleet_speed}" type="text" maxlength="5"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_normal_speed_fleet}"></td>
</tr><tr>
	<td>{$se_resources_producion_speed}</td>
	<td><input name="resource_multiplier" value="{$resource_multiplier}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_normal_speed_resoruces}"></td>
</tr><tr>
	<td>{$se_halt_speed}</td>
	<td><input name="halt_speed" value="{$halt_speed}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_normal_speed_halt}"></td>
</tr><tr>
	<td>{$se_forum_link}</td>
	<td><input name="forum_url" size="60" maxlength="254" value="{$forum_url}" type="text"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$se_server_op_close}<br></td>
	<td><input name="closed"{if $game_disable == '1'} checked="checked"{/if} type="checkbox"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$se_server_status_message}<br></td>
	<td><textarea name="close_reason" cols="80" rows="5">{$close_reason}</textarea></td>
	<td>&nbsp;</td>
</tr><tr>
	<th colspan="2">{$se_server_planet_parameters}</th><th>&nbsp;</th>
</tr><tr>
	<td>{$se_initial_fields}</td>
	<td><input name="initial_fields" maxlength="10" size="10" value="{$initial_fields}" type="text"> {$se_fields} </td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$se_metal_production}</td>
	<td><input name="metal_basic_income" maxlength="10" size="10" value="{$metal_basic_income}" type="text"> {$se_per_hour}</td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$se_crystal_production}</td>
	<td><input name="crystal_basic_income" maxlength="10" size="10" value="{$crystal_basic_income}" type="text"> {$se_per_hour}</td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$se_deuterium_production}</td>
	<td><input name="deuterium_basic_income" maxlength="10" size="10" value="{$deuterium_basic_income}" type="text"> {$se_per_hour}</td>
	<td>&nbsp;</td>
</tr><tr>
	<th colspan="2">{$se_several_parameters}</th><th>&nbsp;</th>
</tr><tr>
	<td>{$se_min_build_time}</td>
	<td><input name="min_build_time" maxlength="2" size="5" value="{$min_build_time}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_min_build_time_info}"/></td>
</tr><tr>
	<td>{$se_reg_closed}<br></td>
	<td><input name="reg_closed"{if $reg_closed} checked="checked"{/if} type="checkbox"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$se_verfiy_mail}<br></td>
	<td><input name="user_valid"{if $user_valid} checked="checked"{/if} type="checkbox"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_verfiy_mail_info}"/></td>
</tr><tr>
	<td>{$se_admin_protection}</td>
    <td><input name="adm_attack"{if $adm_attack} checked="checked"{/if} type="checkbox"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_title_admins_protection}"/></td>
</tr><tr>
	<td>{$se_debug_mode}</td>
	<td><input name="debug"{if $debug} checked="checked"{/if} type="checkbox"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_debug_message}"></td>
</tr><tr>
	<td>{$se_ships_cdr}</td>
	<td><input name="Fleet_Cdr" maxlength="3" size="3" value="{$shiips}" type="text"> %</td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_ships_cdr_message}"></td>
</tr><tr>
	<td>{$se_def_cdr}</td>
	<td><input name="Defs_Cdr" maxlength="3" size="3" value="{$defenses}" type="text"> %</td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_def_cdr_message}"></td>
</tr><tr>
	<td>{$se_max_galaxy}</td>
	<td><input name="max_galaxy" maxlength="3" size="3" value="{$max_galaxy}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_max_galaxy_info}"></td>
</tr><tr>
	<td>{$se_max_system}</td>
	<td><input name="max_system" maxlength="5" size="5" value="{$max_system}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_max_system_info}"></td>
</tr><tr>
	<td>{$se_max_planets}</td>
	<td><input name="max_planets" maxlength="3" size="3" value="{$max_planets}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_max_planets_info}"></td>
</tr><tr>
	<td>{$se_min_player_planets}</td>
	<td><input name="min_player_planets" maxlength="3" size="3" value="{$min_player_planets}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_max_player_planets_info}"></td>
</tr><tr>
	<td>{$se_max_player_planets}</td>
	<td><input name="max_player_planets" maxlength="3" size="3" value="{$max_player_planets}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_min_player_planets_info}"></td>
</tr><tr>
	<td>{$se_planet_factor}</td>
	<td><input name="planet_factor" maxlength="3" size="3" value="{$planet_factor}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_planet_factor_info}"></td>
</tr><tr>
	<td>{$se_max_elements_build}</td>
	<td><input name="max_elements_build" maxlength="3" size="3" value="{$max_elements_build}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_max_elements_build_info}"></td>
</tr><tr>
	<td>{$se_max_elements_tech}</td>
	<td><input name="max_elements_tech" maxlength="3" size="3" value="{$max_elements_tech}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_max_elements_tech_info}"></td>
</tr><tr>
	<td>{$se_max_elements_ships}</td>
	<td><input name="max_elements_ships" maxlength="3" size="3" value="{$max_elements_ships}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_max_elements_ships_info}"></td>
</tr><tr>
	<td>{$se_max_fleet_per_build}</td>
	<td><input name="max_fleet_per_build" maxlength="20" size="15" value="{$max_fleet_per_build}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_max_fleet_per_build_info}"></td>
</tr><tr>
	<td>{$se_max_overflow}</td>
	<td><input name="max_overflow" maxlength="3" size="3" value="{$max_overflow}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_max_overflow_info}"></td>
</tr><tr>
	<td>{$se_moon_factor}</td>
	<td><input name="moon_factor" maxlength="3" size="3" value="{$moon_factor}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_moon_factor_info}"></td>
</tr><tr>
	<td>{$se_moon_chance}</td>
	<td><input name="moon_chance" maxlength="3" size="3" value="{$moon_chance}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_moon_chance_info}"></td>
</tr><tr>
	<td>{$se_darkmatter_cost_trader}</td>
	<td><input name="darkmatter_cost_trader" maxlength="11" size="11" value="{$darkmatter_cost_trader}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_darkmatter_cost_trader_info}"></td>
</tr><tr>
	<td>{$se_factor_university}</td>
	<td><input name="factor_university" maxlength="3" size="3" value="{$factor_university}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_factor_university_info}"></td>
</tr><tr>
	<td>{$se_max_fleets_per_acs}</td>
	<td><input name="max_fleets_per_acs" maxlength="3" size="3" value="{$max_fleets_per_acs}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_max_fleets_per_acs_info}"></td>
</tr><tr>
	<td>{$se_vmode_min_time}</td>
	<td><input name="vmode_min_time" maxlength="11" size="11" value="{$vmode_min_time}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_vmode_min_time_info}"></td>
</tr><tr>
	<td>{$se_gate_wait_time}</td>
	<td><input name="gate_wait_time" maxlength="11" size="11" value="{$gate_wait_time}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_gate_wait_time_info}"></td>
</tr><tr>
	<td>{$se_metal_start}</td>
	<td><input name="metal_start" maxlength="11" size="11" value="{$metal_start}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_metal_start_info}"></td>
</tr><tr>
	<td>{$se_crystal_start}</td>
	<td><input name="crystal_start" maxlength="11" size="11" value="{$crystal_start}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_crystal_start_info}"></td>
</tr><tr>
	<td>{$se_deuterium_start}</td>
	<td><input name="deuterium_start" maxlength="11" size="11" value="{$deuterium_start}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_deuterium_start_info}"></td>
</tr><tr>
	<td>{$se_darkmatter_start}</td>
	<td><input name="darkmatter_start" maxlength="11" size="11" value="{$darkmatter_start}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_darkmatter_start_info}"></td>
</tr><tr>
	<td>{$se_debris_moon}</td>
	<td><input name="debris_moon"{if $debris_moon} checked="checked"{/if} type="checkbox"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_debris_moon_info}"></td>
</tr><tr>
	<td>{$se_noob_protect}</td>
	<td><input name="noobprotection"{if $noobprot} checked="checked"{/if} type="checkbox"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$se_noob_protect2}</td>
	<td><input name="noobprotectiontime" value="{$noobprot2}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_noob_protect_e2}"></td>
</tr><tr>
	<td>{$se_noob_protect3}</td>
	<td><input name="noobprotectionmulti" value="{$noobprot3}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_noob_protect_e3}"></td>
</tr><tr>
	<th colspan="2">{$se_trader_head}</th><th>&nbsp;</th>
</tr><tr>
    <td>{$se_trader_ships}</td>
    <td><input name="trade_allowed_ships" maxlength="50" size="60" value="{$trade_allowed_ships}" type="text"></td>
	<td>&nbsp;</td>
</tr><tr>
    <td>{$se_trader_charge}</td>
    <td><input name="trade_charge" maxlength="5" size="10" value="{$trade_charge}" type="text"></td>
	<td></td>
</tr><tr>
	<th colspan="2">{$se_news_head}</th><th>&nbsp;</th>
</tr><tr>
    <td>{$se_news_active}</td>
    <td><input name="newsframe"{if $newsframe} checked="checked"{/if} type="checkbox"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_news_info}"></td>
</tr><tr>
    <td>{$se_news}</td>
    <td><textarea name="NewsText" cols="80" rows="5">{$NewsTextVal}</textarea></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$se_news_limit}"></td>
</tr>
<tr>
	<td colspan="3"><input value="{$se_save_parameters}" type="submit"></td>
</tr>
</table>
</form>
</center>
{include file="adm/overall_footer.tpl"}