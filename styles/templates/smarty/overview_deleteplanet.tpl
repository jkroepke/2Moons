{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content">
    <form action="game.php?page=overview&mode=deleteplanet" method="POST">
        <table width="519" align="center">
        <tr>
            <td colspan="3" class="c">{$ov_security_request}</td>
        </tr><tr>
            <th colspan="3" style="height: 20px;">{$ov_security_confirm} {$name} [{$galaxy}:{$system}:{$planet}] {$ov_with_pass}</th>
        </tr><tr>
            <th>{$ov_password}</th>
            <th><input type="password" name="password"></th>
            <th><input type="submit" value="{$ov_delete_planet}"></th>
        </tr>
        </table>
    </form>
</div>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}