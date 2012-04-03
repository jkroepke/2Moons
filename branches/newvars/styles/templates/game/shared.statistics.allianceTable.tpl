<tr>
	<th style="width:60px;">{$LNG.st_position}</th>
	<th>{$LNG.st_alliance}</th>	
	<th>{$LNG.st_members}</th>
	<th>{$LNG.st_points}</th>
	<th>{$LNG.st_per_member}</th>
</tr>
{foreach name=RangeList item=RangeInfo from=$RangeList}
<tr>
	<td><a class="tooltip" data-tooltip-content="{if $RangeInfo.ranking == 0}<span style='color:#87CEEB'>*</span>{elseif $RangeInfo.ranking < 0}<span style='color:red'>{$RangeInfo.ranking}</span>{elseif $RangeInfo.ranking > 0}<span style='color:green'>+{$RangeInfo.ranking}</span>{/if}">{$RangeInfo.rank}</a></td>
	<td><a href="game.php?page=alliance&amp;mode=info&amp;id={$RangeInfo.id}" target="ally"{if $RangeInfo.id == $CUser_ally} style="color:lime"{/if}>{$RangeInfo.name}</a></td>
	<td>{$RangeInfo.members}</td>
	<td>{$RangeInfo.points}</td>
	<td>{$RangeInfo.mppoints}</td>
</tr>
{/foreach}