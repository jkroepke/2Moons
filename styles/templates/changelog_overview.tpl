{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
    <table >
		<tr>
			<th>{$Version}</th>
			<th>{$Description}</th>
		</tr>
	{foreach key=version_number item=description from=$ChangelogList}
    <tr>
        <td style="width:42px">{$version_number}</th>
        <td class="left">{$description}</td>
    </tr>
	{/foreach}
    </table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}