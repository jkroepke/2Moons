{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table width="668" align="center">
		<tr>
			<td class="c">{$Version}</td>
			<td class="c">{$Description}</td>
		</tr>
	{foreach key=version_number item=description from=$ChangelogList}
    <tr>
        <th width="42">{$version_number}</th>
        <td style="text-align:left" class="b">{$description}</td>
    </tr>
	{/foreach}
    </table>
</div>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}