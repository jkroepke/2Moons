{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
    <form action="?page=options&amp;mode=change" method="post">
    <table style="min-width:519px;width:519px;">
    <tbody>
	{if $user_authlevel > 0}
	<tr>
		<th colspan="2">{lang}op_admin_title_options{/lang}</th>
	</tr><tr>
		<td>{lang}op_admin_planets_protection{/lang}</td>
		<td><input name="adm_pl_prot" type="checkbox" {if $adm_pl_prot_data > 0}checked="checked"{/if}></td>
	</tr>
	{/if}
    <tr>
        <th colspan="2">{lang}op_user_data{/lang}</th>
    </tr><tr>
        <td>{lang}op_username{/lang}</td>
        <td style="height:22px;">{if $uctime}<input name="db_character" size="20" value="{$opt_usern_data}" type="text">{else}{$opt_usern_data}{/if}</td>
    </tr><tr>
        <td>{lang}op_old_pass{/lang}</td>
        <td><input name="db_password" size="20" type="password" class="autocomplete"></td>
    </tr><tr>
        <td>{lang}op_new_pass{/lang}</td>
        <td><input name="newpass1" size="20" maxlength="40" type="password"></td>
    </tr><tr>
        <td>{lang}op_repeat_new_pass{/lang}</td>
        <td><input name="newpass2" size="20" maxlength="40" type="password"></td>
    </tr><tr>
        <td><a title="{lang}op_email_adress_descrip{/lang}">{lang}op_email_adress{/lang}</a></td>
        <td><input name="db_email" maxlength="64" size="20" value="{$opt_mail1_data}" type="text"></td>
    </tr><tr>
        <td style="height:22px;">{lang}op_permanent_email_adress{/lang}</td>
        <td>{$opt_mail2_data}</td>
    </tr><tr>
        <th colspan="2">{lang}op_general_settings{/lang}</th>
    </tr><tr>
        <td>{lang}op_lang{/lang}</td>
        <td>
			{html_options name=langs options=$Selectors.lang selected=$langs}
        </td>
    </tr><tr>
        <td>{lang}op_sort_planets_by{/lang}</td>
        <td>
			{html_options name=settings_sort options=$Selectors.Sort selected=$planet_sort}
        </td>
    </tr><tr>
		<td>{lang}op_sort_kind{/lang}</td>
        <td>
            {html_options name=settings_order options=$Selectors.SortUpDown selected=$planet_sort_order}
        </td>
    </tr><tr>
        <td>{lang}op_skin_example{/lang}</td>
        <td><select name="dpath" id="dpath">{html_options options=$Selectors.Skins selected=$opt_dpath_data}</select></td>
    </tr><tr>
		<td>{lang}op_active_build_messages{/lang}</td>
		<td><input name="hof" type="checkbox" {if $opt_hof == 1}checked="checked"{/if}></td>
	</tr><tr>
        <td><a title="{lang}op_deactivate_ipcheck_descrip{/lang}">{lang}op_deactivate_ipcheck{/lang}</a></td>
        <td><input name="noipcheck" type="checkbox" {if $opt_noipc_data == 1}checked="checked"{/if}></td>
    </tr><tr>
        <td>{lang}op_show_planetmenu{/lang}</td>
        <td><input name="settings_planetmenu" type="checkbox" {if $opt_allyl_data == 1}checked="checked"{/if}></td>
    </tr><tr>
        <td>{lang}op_timezone{/lang}</td>
        <td>{html_options name=timezone options=$Selectors.timezones selected=$opt_timezone}</td>
    </tr><tr>
        <td>{lang}op_dst_mode{/lang}</td>
        <td>{html_options name=dst options=$Selectors.dst selected=$opt_dst_mode}</td>
    </tr><tr>
        <th colspan="2">{lang}op_galaxy_settings{/lang}</th>
    </tr><tr>
        <td><a title="{lang}op_spy_probes_number_descrip{/lang}">{lang}op_spy_probes_number{/lang}</a></td>
        <td><input name="spio_anz" maxlength="2" size="2" value="{$opt_probe_data}" type="text"></td>
    </tr><tr>
        <td>{lang}op_toolt_data{/lang}</td>
        <td><input name="settings_tooltiptime" maxlength="2" size="2" value="{$opt_toolt_data}" type="text"> {lang}op_seconds{/lang}</td>
    </tr><tr>
        <td>{lang}op_max_fleets_messages{/lang}</td>
        <td><input name="settings_fleetactions" maxlength="2" size="2" value="{$opt_fleet_data}" type="text"></td>
    </tr><tr>
        <th>{lang}op_shortcut{/lang}</th>
        <th>{lang}op_show{/lang}</th>
    </tr><tr>
        <td><img src="{$dpath}img/e.gif" alt="">{lang}op_spy{/lang}</td>
        <td><input name="settings_esp" type="checkbox" {if $user_settings_esp == 1}checked="checked"{/if}></td>
    </tr><tr>
        <td><img src="{$dpath}img/m.gif" alt="">{lang}op_write_message{/lang}</td>
        <td><input name="settings_wri" type="checkbox" {if $user_settings_wri == 1}checked="checked"{/if}></td>
    </tr><tr>
        <td><img src="{$dpath}img/b.gif" alt="">{lang}op_add_to_buddy_list{/lang}</td>
        <td><input name="settings_bud" type="checkbox" {if $user_settings_bud == 1}checked="checked"{/if}></td>
    </tr><tr>
        <td><img src="{$dpath}img/r.gif" alt="">{lang}op_missile_attack{/lang}</td>
        <td><input name="settings_mis" type="checkbox" {if $user_settings_mis == 1}checked="checked"{/if}></td>
    </tr><tr>
        <td><img src="{$dpath}img/s.gif" alt="">{lang}op_send_report{/lang}</td>
        <td><input name="settings_rep" type="checkbox" {if $user_settings_rep == 1}checked="checked"{/if}></td>
    </tr><tr>
        <th colspan="2">{lang}op_vacation_delete_mode{/lang}</th>
    </tr><tr>
        <td><a title="{lang}op_activate_vacation_mode_descrip{/lang}">{lang}op_activate_vacation_mode{/lang}</a></td>
        <td><input name="urlaubs_modus" type="checkbox"></td>
    </tr><tr>
        <td><a title="{lang}op_dlte_account_descrip{/lang}">{lang}op_dlte_account{/lang}</a></td>
        <td><input name="db_deaktjava" type="checkbox" {if $opt_delac_data > 0}checked="checked"{/if}></td>
    </tr><tr>
        <td colspan="2"><input value="{lang}op_save_changes{/lang}" type="submit"></td>
    </tr>
    </tbody>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}