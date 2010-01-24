<tr>
	<td class="c" width="60px">{$st_position}</td>
	<td class="c">{$st_player}</td>
	<td class="c">&nbsp;</td>
	<td class="c">{$st_alliance}</td>
	<td class="c">{$st_points}</td>
</tr>
{foreach name=RangeList item=RangeInfo from=$RangeList}
<tr>
	<th><a href="#" onmouseover='return overlib("{if $RangeList.ranking == 0}<font color=&#39;#87CEEB&#39;>*</font>{elseif $RangeList.ranking < 0}<font color=&#39;red&#39;>-{$RangeList.ranking}</font>{elseif $RangeList.ranking > 0}<font color=&#39;green&#39;>+{$RangeList.ranking}</font>{/if}", WIDTH, 10);' onmouseout='return nd();'>{$smarty.foreach.RangeList.iteration}</a></th>
	<th align="left"><a href="javascript:playercard('game.php?page=playercard&amp;id={$RangeInfo.id}')">{if $RangeInfo.id == $CUser_id}<font color="lime">{$RangeInfo.name}</font>{else}{$RangeInfo.name}{/if}</a></th>
	<th><a href="javascript:f('game.php?page=messages&amp;mode=write&amp;id={$RangeInfo.id}','');"><img src="{$dpath}img/m.gif" border="0" title="{$st_write_message}" alt="{$st_write_message}"></a></th>
	<th align="left"><a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$RangeInfo.allyid}">{if $RangeInfo.allyid == $CUser_ally}<font color="#33CCFF">{$RangeInfo.allyname}</font>{else}{$RangeInfo.allyname}{/if}</a></th>
	<th align="right">{$RangeInfo.points}</th>
</tr>
{/foreach}