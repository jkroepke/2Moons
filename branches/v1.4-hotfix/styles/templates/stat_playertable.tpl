<tr>
	<th style="width:60px;">{$st_position}</th>
	<th>{$st_player}</th>
	<th>&nbsp;</th>
	<th>{$st_alliance}</th>
	<th>{$st_points}</th>
</tr>
{foreach name=RangeList item=RangeInfo from=$RangeList}
<tr>
	<td><a class="tooltip" name="{if $RangeInfo.ranking == 0}<span style='color:#87CEEB'>*</span>{elseif $RangeInfo.ranking < 0}<span style='color:red'>-{$RangeInfo.ranking}</span>{elseif $RangeInfo.ranking > 0}<span style='color:green'>+{$RangeInfo.ranking}</span>{/if}">{$RangeInfo.rank}</a></td>
	<td><a href="#" onclick="return Dialog.Playercard({$RangeInfo.id}, '{$RangeInfo.name}');"{if $RangeInfo.id == $CUser_id} style="color:lime"{/if}>{$RangeInfo.name}</a></td>
	<td>{if $RangeInfo.id != $CUser_id}<a href="#" onclick="return Dialog.PM({$RangeInfo.id});"><img src="{$dpath}img/m.gif" title="{$st_write_message}" alt="{$st_write_message}"></a>{/if}</td>
	<td>{if $RangeInfo.allyid != 0}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$RangeInfo.allyid}">{if $RangeInfo.allyid == $CUser_ally}<span style="color:#33CCFF">{$RangeInfo.allyname}</span>{else}{$RangeInfo.allyname}{/if}</a>{/if}</td>
	<td>{$RangeInfo.points}</td>
</tr>
{/foreach}