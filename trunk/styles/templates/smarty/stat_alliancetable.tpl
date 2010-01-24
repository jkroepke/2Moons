<tr>
	<td class="c" width="60">{$st_position}</td>
	<td class="c">{$st_alliance}</td>
	<td class="c">&nbsp;</td>
	<td class="c">{$st_members}</td>
	<td class="c">{$st_points}</td>
	<td class="c">{$st_per_member}</td>
</tr>
{foreach name=RangeList item=RangeInfo from=$RangeList}
<tr>
	<th><a href="#" onmouseover='return overlib("{if $RangeList.ranking == 0}<font color=&#34;#87CEEB"&#34;>*</font>{elseif $RangeList.ranking < 0}<font color=&#34;red&#34;>-{$RangeList.ranking}</font>{elseif $RangeList.ranking > 0}<font color=&#34;green&#34;>+{$RangeList.ranking}</font>{/if}");' onmouseout='return nd();'>{$smarty.foreach.RangeList.iteration}</a></th>
	<th><a href="game.php?page=alliance&mode=ainfo&a={$RangeInfo.id}" target="ally">{if $RangeInfo.id == $CUser_ally}<font color="lime">{$RangeInfo.name}</font>{else}{$RangeInfo.name}{/if}</a></th>
	<th></th>
	<th>{$RangeInfo.members}</th>
	<th>{$RangeInfo.points}</th>
	<th>{$RangeInfo.mppoints}</th>
</tr>
{/foreach}