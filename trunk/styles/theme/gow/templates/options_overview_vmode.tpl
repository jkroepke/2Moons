{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <form action="game.php?page=options&amp;mode=exit" method="post">
        <table class="table519">
            <tr>
                <th colspan="2">{$op_vacation_mode_active_message} {$vacation_until}</th>
            </tr>
            <tr>
                <td>{$op_end_vacation_mode}</td>
                <td><input type="checkbox" name="exit_modus" {if !$is_deak_vacation}disabled{/if}></td>
            </tr><tr>
				<td><a title="{$op_dlte_account_descrip}">{$op_dlte_account}</a></td>
				<td><input name="db_deaktjava" type="checkbox" {if $opt_delac_data > 0}checked="checked"{/if}></td>
			</tr>
            <tr>
                <td colspan="2"><input type="submit" value="{$op_save_changes}"></td>
            </tr>
        </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}