{if $isadmin}
{include file="adm/overall_header.tpl"}
{else}
{include file="overall_header.tpl"}
{if !$Fatal}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
{/if}
{/if}
<div id="content" class="content">
    <table class="table519">
		<tr>
            <th>{$fcm_info}</th>
        </tr>
		<tr>
            <td>{$mes}</td>
        </tr>
    </table>
</div>
{if $isadmin}
{include file="adm/overall_footer.tpl"}
{else}
{if !$Fatal}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}
{/if}