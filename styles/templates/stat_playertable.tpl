<tr>
	<th style="width:60px;">{$st_position}</th>
	<th>{$st_player}</th>
	<th>&nbsp;</th>
	<th>{$st_alliance}</th>
	<th>{$st_points}</th>
</tr>
{foreach name=RangeList item=RangeInfo from=$RangeList}
<tr>
	<td><a href="#" onmouseover='return overlib("{if $RangeInfo.ranking == 0}<span style=&#39;color:#87CEEB&#39;>*</span>{elseif $RangeInfo.ranking < 0}<span style=&#39;color:red&#39;>-{$RangeInfo.ranking}</span>{elseif $RangeInfo.ranking > 0}<span style=&#39;color:green&#39;>+{$RangeInfo.ranking}</span>{/if}", WIDTH, 10);' onmouseout='return nd();'>{$RangeInfo.rank}</a></td>
	<td><a href="javascript:OpenPopup('game.php?page=playercard&amp;id={$RangeInfo.id}', '', 640, 510)"{if $RangeInfo.id == $CUser_id} style="color:lime"{/if}>{$RangeInfo.name}</a></td>
	<td>{if $RangeInfo.id != $CUser_id}<a href="javascript:OpenPopup('game.php?page=messages&amp;mode=write&amp;id={$RangeInfo.id}','', 720, 300);"><img src="{$dpath}img/m.gif" title="{$st_write_message}" alt="{$st_write_message}"></a>{/if}</td>
	<td>{if $RangeInfo.allyid != 0}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$RangeInfo.allyid}">{if $RangeInfo.allyid == $CUser_ally}<span style="color:#33CCFF">{$RangeInfo.allyname}</span>{else}{$RangeInfo.allyname}{/if}</a>{/if}</td>
	<td>{$RangeInfo.points}</td>
</tr>
{/foreach}