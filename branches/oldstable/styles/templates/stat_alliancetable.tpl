<tr>
	<th style="width:60px;">{lang}st_position{/lang}</th>
	<th>{lang}st_alliance{/lang}</th>	
	<th>{lang}st_members{/lang}</th>
	<th>{lang}st_points{/lang}</th>
	<th>{lang}st_per_member{/lang}</th>
</tr>
{foreach name=RangeList item=RangeInfo from=$RangeList}
<tr>
	<td><a class="tooltip" name="{if $RangeInfo.ranking == 0}<span style='color:#87CEEB'>*</span>{elseif $RangeInfo.ranking < 0}<span style='color:red'>{$RangeInfo.ranking}</span>{elseif $RangeInfo.ranking > 0}<span style='color:green'>+{$RangeInfo.ranking}</span>{/if}">{$RangeInfo.rank}</a></td>
	<td><a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$RangeInfo.id}" target="ally"{if $RangeInfo.id == $CUser_ally} style="color:lime"{/if}>{$RangeInfo.name}</a></td>
	<td>{$RangeInfo.members}</td>
	<td>{$RangeInfo.points}</td>
	<td>{$RangeInfo.mppoints}</td>
</tr>
{/foreach}