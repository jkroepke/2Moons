{block name="content"}
<table style="width:760px" id="resulttable">
	<tr>
		<th>{$LNG.sh_tag}</th>
		<th>{$LNG.sh_name}</th>
		<th>{$LNG.sh_members}</th>
		<th>{$LNG.sh_points}</th>
	</tr>
	{foreach $searchList as $searchRow}
	<tr>
		<td><a href="game.php?page=alliance&amp;mode=info&amp;tag={$searchRow.allytag}">{$searchRow.allytag}</a></td>
		<td>{$searchRow.allyname}</td>
		<td>{$searchRow.allymembers}</td>
		<td>{$searchRow.allypoints}</td>
	</tr>
	{/foreach}
</table>
{/block}