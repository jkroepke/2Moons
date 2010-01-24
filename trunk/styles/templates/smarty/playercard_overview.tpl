{include file="overall_header.tpl"}
<table width="90%" align="center">
<tbody>
<tr>
<td colspan="3" class="c"><b>{$pl_overview}</b></td>
</tr>
<tr>
<th width="40%">{$pl_name}</th>
<th colspan="2">{$name}</th>
</tr>
<tr>
<th>{$pl_homeplanet}</th>
<th colspan="2">{$homeplanet} <a href='javascript:window.opener.focus();' onclick='window.opener.location.href = "game.php?page=galaxy&amp;mode=3&amp;galaxy={$galaxy}&amp;system={$system}";'>[{$galaxy}:{$system}:{$planet}]</a></th>
</tr>
<tr>
<th>{$pl_ally}</th>
<th colspan="2">{if $allyname}<a href='javascript:window.opener.focus();' onclick='window.opener.location.href = "game.php?page=alliance&amp;mode=ainfo&amp;a={$allyid}";'>{$allyname}</a>{else}-{/if}</th>
</tr>
<tr>
<td class="c">&nbsp;</td>
<td class="c">{$pl_points}</td>
<td class="c">{$pl_range}</td>
</tr>
<tr>
<th>{$pl_builds}</th>
<th>{$build_points}</th>
<th>{$build_rank}</th>
</tr>
<tr>
<th>{$pl_tech}</th>
<th>{$tech_points}</th>
<th>{$tech_rank}</th>
</tr>
<tr>
<th>{$pl_fleet}</th>
<th>{$fleet_points}</th>
<th>{$fleet_rank}</th>
</tr>
<tr>
<th>{$pl_def}</th>
<th>{$defs_points}</th>
<th>{$defs_rank}</th>
</tr>
<tr>
<th>{$pl_total}</th>
<th>{$total_points}</th>
<th>{$total_rank}</th>
</tr>
<tr>
<td colspan="3" class="c" width="100%">{$pl_fightstats}</td>
</tr>
<tr>
<th>&nbsp;</th>
<th><b>{$pl_fights}</b></th>
<th align="right"><b>{$pl_fprocent}</b></th>
</tr>
<tr>
<th>{$pl_fightwon}</th>
<th><b>{$wons}</b></th>
<th align="right"><b>{$siegprozent} %</b></th>
</tr>
<tr>
<th>{$pl_fightdraw}</th>
<th><b>{$draws}</b></th>
<th align="right"><b>{$drawsprozent} %</b></th>
</tr>
<tr>
<th>{$pl_fightlose}</th>
<th><b>{$loos}</b></th>
<th align="right"><b>{$loosprozent} %</b></th>
</tr>
<tr>
<th>{$pl_totalfight}</th>
<th><b>{$totalfights}</b></th>
<th align="right"><b>100%</b></th>
</tr>
<tr>
<td colspan="3" class="c" width="100%">{$playerdestory}:</td>
</tr>
<tr>
<th>{$pl_unitsshot}</th>
<th colspan="2"><b>{$desunits}</b></th>
</tr>
<tr>
<th>{$pl_unitslose}</th>
<th colspan="2"><b>{$lostunits}</b></th>
</tr>
<tr>
<th>{$pl_dermetal}</th>
<th colspan="2"><b>{$kbmetal}</b></th>
</tr>
<tr>
<th>{$pl_dercrytal}</th>
<th colspan="2"><b>{$kbcrystal}</b></th>
</tr>
<tr>
<td colspan="3" class="c" width="100%">Sonstiges</td>
</tr>
<tr>
<th><a href="javascript:f('game.php?page=buddy&amp;mode=2&amp;u={$id}','');" title="{$pl_buddy}">{$pl_buddy}</a></th><th colspan="2"><a href="javascript:f('game.php?page=messages&amp;mode=write&amp;id={$pl_buddy}');" title="{$pl_message}">{$pl_message}</a></th>
</tr>
</table>
{include file="overall_footer.tpl"}