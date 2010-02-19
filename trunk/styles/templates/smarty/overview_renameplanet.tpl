{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content">
	<form action="game.php?page=overview&amp;mode=renameplanet" method="POST">
    <table width="519" align="center">
    <tr>
        <td class="c" colspan=3>{$ov_your_planet}</td>
    </tr><tr>
        <th>{$ov_coords}</th>
        <th>{$ov_planet_name}</th>
        <th>{$ov_actions}</th>
    </tr><tr>
        <th>{$galaxy}:{$system}:{$planet}</th>
        <th>{$planetname}</th>
        <th><input type="button" value="{$ov_abandon_planet}" onclick="document.location.href = 'http://localhost/framework/game.php?page=overview&amp;mode=deleteplanet';"></th>
    </tr><tr>
        <th>{$ov_planet_rename}</th>
        <th><input type="text" name="newname" size="25" maxlength="20"></th>
        <th><input type="submit" value="{$ov_planet_rename_action}"></th>
    </tr>
    </table>
    </form>
</div>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}