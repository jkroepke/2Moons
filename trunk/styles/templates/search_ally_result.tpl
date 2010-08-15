<table style="width:50%">
    <tr>
		<th>{$sh_tag}</th>
		<th>{$sh_name}</th>
		<th>{$sh_members}</th>
		<th>{$sh_points}</th>
    </tr>
	{foreach item=SearchInfo from=$SearchResult}
	<tr>
		<td><a href="game.php?page=alliance&amp;mode=ainfo&amp;tag={$SearchInfo.allytag}">{$SearchInfo.allytag}</a></td>
		<td>{$SearchInfo.allyname}</td>
		<td>{$SearchInfo.allymembers}</td>
		<td>{$SearchInfo.allypoints}</td>
	</tr>
	{/foreach}
</table>