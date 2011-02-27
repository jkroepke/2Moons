{include file="overall_header.tpl"}
<table style="width:90%">
<tr>
<th colspan="3">{$pl_overview}</th>
</tr>
<tr>
<td style="width:40%">{$pl_name}</td>
<td colspan="2">{$name}</td>
</tr>
<tr>
<td>{$pl_homeplanet}</td>
<td colspan="2">{$homeplanet} <a href='javascript:window.opener.focus();' onclick='window.opener.location.href = "game.php?page=galaxy&amp;mode=3&amp;galaxy={$galaxy}&amp;system={$system}";'>[{$galaxy}:{$system}:{$planet}]</a></td>
</tr>
<tr>
<td>{$pl_ally}</td>
<td colspan="2">{if $allyname}<a href='javascript:window.opener.focus();' onclick='window.opener.location.href = "game.php?page=alliance&amp;mode=ainfo&amp;a={$allyid}";'>{$allyname}</a>{else}-{/if}</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>{$pl_points}</td>
<td>{$pl_range}</td>
</tr>
<tr>
<td>{$pl_builds}</td>
<td>{$build_points}</td>
<td>{$build_rank}</td>
</tr>
<tr>
<td>{$pl_tech}</td>
<td>{$tech_points}</td>
<td>{$tech_rank}</td>
</tr>
<tr>
<td>{$pl_fleet}</td>
<td>{$fleet_points}</td>
<td>{$fleet_rank}</td>
</tr>
<tr>
<td>{$pl_def}</td>
<td>{$defs_points}</td>
<td>{$defs_rank}</td>
</tr>
<tr>
<td>{$pl_total}</td>
<td>{$total_points}</td>
<td>{$total_rank}</td>
</tr>
<tr>
<th colspan="3">{$pl_fightstats}</th>
</tr>
<tr>
<td>&nbsp;</td>
<td>{$pl_fights}</td>
<td>{$pl_fprocent}</td>
</tr>
<tr>
<td>{$pl_fightwon}</td>
<td>{$wons}</td>
<td>{$siegprozent} %</td>
</tr>
<tr>
<td>{$pl_fightdraw}</td>
<td>{$draws}</td>
<td>{$drawsprozent} %</td>
</tr>
<tr>
<td>{$pl_fightlose}</td>
<td>{$loos}</td>
<td>{$loosprozent} %</td>
</tr>
<tr>
<td>{$pl_totalfight}</td>
<td>{$totalfights}</td>
<td>100%</td>
</tr>
<tr>
<th colspan="3">{$playerdestory}:</th>
</tr>
<tr>
<td>{$pl_unitsshot}</td>
<td colspan="2">{$desunits}</td>
</tr>
<tr>
<td>{$pl_unitslose}</td>
<td colspan="2">{$lostunits}</td>
</tr>
<tr>
<td>{$pl_dermetal}</td>
<td colspan="2">{$kbmetal}</td>
</tr>
<tr>
<td>{$pl_dercrystal}</td>
<td colspan="2">{$kbcrystal}</td>
</tr>
{if $id != $yourid}
<tr>
<th colspan="3">{$pl_etc}</th>
</tr>
<tr>
<td><a href="javascript:OpenPopup('game.php?page=buddy&amp;mode=2&amp;u={$id}', '', 720, 300);" title="{$pl_buddy}">{$pl_buddy}</a></td><td colspan="2"><a href="javascript:OpenPopup('game.php?page=messages&amp;mode=write&amp;id={$id}', '', 720, 300);" title="{$pl_message}">{$pl_message}</a></td>
</tr>
{/if}
</table>
{include file="overall_footer.tpl"}