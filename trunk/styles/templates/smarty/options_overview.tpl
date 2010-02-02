{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content">
    <form action="?page=options&amp;mode=change" method="post">
    <table width="519" align="center">
    <tbody>
	{if $user_authlevel > 0}
	<tr>
		<td class="c" colspan="2">{$op_admin_title_options}</td>
	</tr><tr>
		<th>{$op_admin_planets_protection}</th>
		<th><input name="adm_pl_prot" type="checkbox" {if $adm_pl_prot_data > 0}checked="checked"{/if}></th>
	</tr>
	{/if}
    <tr>
        <td class="c" colspan="2">{$op_user_data}</td>
    </tr><tr>
        <th>{$op_username}</th>
        <th style="height:22px;">{if $uctime}<input name="db_character" size="20" value="{$opt_usern_data}" type="text">{else}{$opt_usern_data}{/if}</th>
    </tr><tr>
        <th>{$op_old_pass}</th>
        <th><input name="db_password" size="20" type="password" class="autocomplete"></th>
    </tr><tr>
        <th>{$op_new_pass}</th>
        <th><input name="newpass1" size="20" maxlength="40" type="password"></th>
    </tr><tr>
        <th>{$op_repeat_new_pass}</th>
        <th><input name="newpass2" size="20" maxlength="40" type="password"></th>
    </tr><tr>
        <th><a title="{$op_email_adress_descrip}">{$op_email_adress}</a></th>
        <th><input name="db_email" maxlength="100" size="20" value="{$opt_mail1_data}" type="text"></th>
    </tr><tr>
        <th style="height:22px;">{$op_permanent_email_adress}</th>
        <th>{$opt_mail2_data}</th>
    </tr><tr>
        <td class="c" colspan="2">{$op_general_settings}</td>
    </tr><tr>
        <th>{$op_sort_planets_by}</th>
        <th>
			{html_options name=settings_sort options=$Selectors.Sort selected=$planet_sort}
        </th>
    </tr><tr>
		<th>{$op_sort_kind}</th>
        <th>
            {html_options name=settings_order options=$Selectors.SortUpDown selected=$planet_sort_order}
        </th>
    </tr><tr>
        <th>{$op_skin_example}</th>
        <th><input name="dpath" maxlength="80" size="40" value="{$opt_dpath_data}" type="text"></th>
    </tr><tr>
        <th>{$op_show_skin}</th>
        <th><input name="design" type="checkbox" {if $opt_sskin_data == 1}checked="checked"{/if}></th>
    </tr><tr>
		<th>{$op_active_build_messages}</th>
		<th><input name="hof" type="checkbox" {if $opt_hof == 1}checked="checked"{/if}></th>
	</tr><tr>
        <th><a title="{$op_deactivate_ipcheck_descrip}">{$op_deactivate_ipcheck}</a></th>
        <th><input name="noipcheck" type="checkbox" {if $opt_noipc_data == 1}checked="checked"{/if}></th>
    </tr><tr>
        <td class="c" colspan="2">{$op_galaxy_settings}</td>
    </tr><tr>
        <th><a title="{$op_spy_probes_number_descrip}">{$op_spy_probes_number}</a></th>
        <th><input name="spio_anz" maxlength="2" size="2" value="{$opt_probe_data}" type="text"></th>
    </tr><tr>
        <th>{$op_toolt_data}</th>
        <th><input name="settings_tooltiptime" maxlength="2" size="2" value="{$opt_toolt_data}" type="text"> {$op_seconds}</th>
    </tr><tr>
        <th>{$op_max_fleets_messages}</th>
        <th><input name="settings_fleetactions" maxlength="2" size="2" value="{$opt_fleet_data}" type="text"></th>
    </tr><tr>
        <th>{$op_show_planetmenu}</th>
        <th><input name="settings_planetmenu" type="checkbox" {if $opt_allyl_data == 1}checked="checked"{/if}></th>
    </tr><tr>
        <td align="center" class="c">{$op_shortcut}</td>
        <td align="center" class="c">{$op_show}</td>
    </tr><tr>
        <th><img src="{$dpath}img/e.gif" alt="">{$op_spy}</th>
        <th><input name="settings_esp" type="checkbox" {if $user_settings_esp == 1}checked="checked"{/if}></th>
    </tr><tr>
        <th><img src="{$dpath}img/m.gif" alt="">{$op_write_message}</th>
        <th><input name="settings_wri" type="checkbox" {if $user_settings_wri == 1}checked="checked"{/if}></th>
    </tr><tr>
        <th><img src="{$dpath}img/b.gif" alt="">{$op_add_to_buddy_list}</th>
        <th><input name="settings_bud" type="checkbox" {if $user_settings_bud == 1}checked="checked"{/if}></th>
    </tr><tr>
        <th><img src="{$dpath}img/r.gif" alt="">{$op_missile_attack}</th>
        <th><input name="settings_mis" type="checkbox" {if $user_settings_mis == 1}checked="checked"{/if}></th>
    </tr><tr>
        <th><img src="{$dpath}img/s.gif" alt="">{$op_send_report}</th>
        <th><input name="settings_rep" type="checkbox" {if $user_settings_rep == 1}checked="checked"{/if}></th>
    </tr><tr>
        <td class="c" colspan="2">{$op_vacation_delete_mode}</td>
    </tr><tr>
        <th><a title="{$op_activate_vacation_mode_descrip}">{$op_activate_vacation_mode}</a></th>
        <th><input name="urlaubs_modus" type="checkbox" {if $opt_modev_data == 1}checked="checked"{/if}></th>
    </tr><tr>
        <th><a title="{$op_dlte_account_descrip}">{$op_dlte_account}</a></th>
        <th><input name="db_deaktjava" type="checkbox" {if $opt_delac_data > 0}checked="checked"{/if}></th>
    </tr><tr>
        <th colspan="2"><input value="{$op_save_changes}" type="submit"></th>
    </tr>
    </tbody>
    </table>
    </form>
</div>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}