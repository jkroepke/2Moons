{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
    <form action="game.php?page=options&amp;mode=exit" method="post">
        <table class="table519">
            <tr>
                <th colspan="2">{lang}op_vacation_mode_active_message{/lang} {$vacation_until}</th>
            </tr>
            <tr>
                <td>{lang}op_end_vacation_mode{/lang}</td>
                <td><input type="checkbox" name="exit_modus" {if !$is_deak_vacation}disabled{/if}></td>
            </tr><tr>
				<td><a title="{lang}op_dlte_account_descrip{/lang}">{lang}op_dlte_account{/lang}</a></td>
				<td><input name="db_deaktjava" type="checkbox" {if $opt_delac_data > 0}checked="checked"{/if}></td>
			</tr>
            <tr>
                <td colspan="2"><input type="submit" value="{lang}op_save_changes{/lang}"></td>
            </tr>
        </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}