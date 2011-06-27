{include file="overall_header.tpl"}
{if !$Fatal}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
{/if}
<div id="content">
    <table class="table519">
		<tr>
            <th>{$fcm_info}</th>
        </tr>
		<tr>
            <td>{$mes}</td>
        </tr>
    </table>
</div>
{if !$Fatal}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}