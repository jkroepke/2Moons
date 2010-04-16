{include file="overall_header.tpl"}
{if !$Fatal}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
{/if}
<div id="content" class="content">
    <table width="519" align="center">
		<tr>
            <td class="c">{$fcm_info}</td>
        </tr>
		<tr>
            <th class="errormessage">{$mes}</th>
        </tr>
    </table>
</div>
{if !$Fatal}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}