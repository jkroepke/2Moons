{block name="title" prepend}{$LNG.lm_research}{/block}
{block name="content"}
<table>
	<tr>
		<th>{$LNG.Version}</th>
		<th>{$LNG.Description}</th>
	</tr>
{foreach key=version_number item=description from=$ChangelogList}
<tr>
	<td style="width:42px">{$version_number}</th>
	<td class="left">{$description}</td>
</tr>
{/foreach}
</table>
{/block}