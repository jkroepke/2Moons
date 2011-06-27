{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
    <form action="?page=options&amp;mode=change" method="post">
    <table style="min-width:519px;width:519px;">
    <tbody>
	{if $user_authlevel > 0}
	<tr>
		<th colspan="2">{$op_admin_title_options}</th>
	</tr><tr>
		<td>{$op_admin_planets_protection}</td>
		<td><input name="adm_pl_prot" type="checkbox" {if $adm_pl_prot_data > 0}checked="checked"{/if}></td>
	</tr>
	{/if}
    <tr>
        <th colspan="2">{$op_user_data}</th>
    </tr><tr>
        <td>{$op_username}</td>
        <td style="height:22px;">{if $uctime}<input name="db_character" size="20" value="{$opt_usern_data}" type="text">{else}{$opt_usern_data}{/if}</td>
    </tr><tr>
        <td>{$op_old_pass}</td>
        <td><input name="db_password" size="20" type="password" class="autocomplete"></td>
    </tr><tr>
        <td>{$op_new_pass}</td>
        <td><input name="newpass1" size="20" maxlength="40" type="password"></td>
    </tr><tr>
        <td>{$op_repeat_new_pass}</td>
        <td><input name="newpass2" size="20" maxlength="40" type="password"></td>
    </tr><tr>
        <td><a title="{$op_email_adress_descrip}">{$op_email_adress}</a></td>
        <td><input name="db_email" maxlength="64" size="20" value="{$opt_mail1_data}" type="text"></td>
    </tr><tr>
        <td style="height:22px;">{$op_permanent_email_adress}</td>
        <td>{$opt_mail2_data}</td>
    </tr><tr>
        <th colspan="2">{$op_general_settings}</th>
    </tr><tr>
        <td>{$op_lang}</td>
        <td>
			{html_options name=langs options=$Selectors.lang selected=$langs}
        </td>
    </tr><tr>
        <td>{$op_sort_planets_by}</td>
        <td>
			{html_options name=settings_sort options=$Selectors.Sort selected=$planet_sort}
        </td>
    </tr><tr>
		<td>{$op_sort_kind}</td>
        <td>
            {html_options name=settings_order options=$Selectors.SortUpDown selected=$planet_sort_order}
        </td>
    </tr><tr>
        <td>{$op_skin_example}</td>
        <td><select name="dpath" id="dpath">{html_options options=$Selectors.Skins selected=$opt_dpath_data}</select></td>
    </tr><tr>
        <td>{$op_show_skin}</td>
        <td><input name="design" type="checkbox" {if $opt_sskin_data == 1}checked="checked"{/if}></td>
    </tr><tr>
		<td>{$op_active_build_messages}</td>
		<td><input name="hof" type="checkbox" {if $opt_hof == 1}checked="checked"{/if}></td>
	</tr><tr>
        <td><a title="{$op_deactivate_ipcheck_descrip}">{$op_deactivate_ipcheck}</a></td>
        <td><input name="noipcheck" type="checkbox" {if $opt_noipc_data == 1}checked="checked"{/if}></td>
    </tr><tr>
        <td>{$op_show_planetmenu}</td>
        <td><input name="settings_planetmenu" type="checkbox" {if $opt_allyl_data == 1}checked="checked"{/if}></td>
    </tr><tr>
        <th colspan="2">{$op_galaxy_settings}</th>
    </tr><tr>
        <td><a title="{$op_spy_probes_number_descrip}">{$op_spy_probes_number}</a></td>
        <td><input name="spio_anz" maxlength="2" size="2" value="{$opt_probe_data}" type="text"></td>
    </tr><tr>
        <td>{$op_toolt_data}</td>
        <td><input name="settings_tooltiptime" maxlength="2" size="2" value="{$opt_toolt_data}" type="text"> {$op_seconds}</td>
    </tr><tr>
        <td>{$op_max_fleets_messages}</td>
        <td><input name="settings_fleetactions" maxlength="2" size="2" value="{$opt_fleet_data}" type="text"></td>
    </tr><tr>
        <th>{$op_shortcut}</th>
        <th>{$op_show}</th>
    </tr><tr>
        <td><img src="{$dpath}img/e.gif" alt="">{$op_spy}</td>
        <td><input name="settings_esp" type="checkbox" {if $user_settings_esp == 1}checked="checked"{/if}></td>
    </tr><tr>
        <td><img src="{$dpath}img/m.gif" alt="">{$op_write_message}</td>
        <td><input name="settings_wri" type="checkbox" {if $user_settings_wri == 1}checked="checked"{/if}></td>
    </tr><tr>
        <td><img src="{$dpath}img/b.gif" alt="">{$op_add_to_buddy_list}</td>
        <td><input name="settings_bud" type="checkbox" {if $user_settings_bud == 1}checked="checked"{/if}></td>
    </tr><tr>
        <td><img src="{$dpath}img/r.gif" alt="">{$op_missile_attack}</td>
        <td><input name="settings_mis" type="checkbox" {if $user_settings_mis == 1}checked="checked"{/if}></td>
    </tr><tr>
        <td><img src="{$dpath}img/s.gif" alt="">{$op_send_report}</td>
        <td><input name="settings_rep" type="checkbox" {if $user_settings_rep == 1}checked="checked"{/if}></td>
    </tr><tr>
        <th colspan="2">{$op_vacation_delete_mode}</th>
    </tr><tr>
        <td><a title="{$op_activate_vacation_mode_descrip}">{$op_activate_vacation_mode}</a></td>
        <td><input name="urlaubs_modus" type="checkbox"></td>
    </tr><tr>
        <td><a title="{$op_dlte_account_descrip}">{$op_dlte_account}</a></td>
        <td><input name="db_deaktjava" type="checkbox" {if $opt_delac_data > 0}checked="checked"{/if}></td>
    </tr><tr>
        <td colspan="2"><input value="{$op_save_changes}" type="submit"></td>
    </tr>
    </tbody>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}