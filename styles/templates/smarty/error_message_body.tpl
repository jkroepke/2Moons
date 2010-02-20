{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content">
    <table width="519" align="center">
		<tr>
            <td class="c">{$fcm_info}</td>
        </tr>
		<tr>
            <th class="errormessage">{$mes}</th>
        </tr>
    </table>
</div>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}