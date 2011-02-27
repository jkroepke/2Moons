<tr>
	<th style="width:60px;">{$st_position}</th>
	<th>{$st_alliance}</th>	
	<th>{$st_members}</th>
	<th>{$st_points}</th>
	<th>{$st_per_member}</th>
</tr>
{foreach name=RangeList item=RangeInfo from=$RangeList}
<tr>
	<td><a href="#" onmouseover='return overlib("{if $RangeInfo.ranking == 0}<span style=&#39;color:#87CEEB&#39;>*</span>{elseif $RangeInfo.ranking < 0}<span style=&#39;color:red&#39;>-{$RangeInfo.ranking}</span>{elseif $RangeInfo.ranking > 0}<span style=&#39;color:green&#39;>+{$RangeInfo.ranking}</span>{/if}", WIDTH, 10);' onmouseout='return nd();'>{$RangeInfo.rank}</a></td>
	<td><a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$RangeInfo.id}" target="ally"{if $RangeInfo.id == $CUser_ally} style="color:lime"{/if}>{$RangeInfo.name}</a></td>
	<td>{$RangeInfo.members}</td>
	<td>{$RangeInfo.points}</td>
	<td>{$RangeInfo.mppoints}</td>
</tr>
{/foreach}