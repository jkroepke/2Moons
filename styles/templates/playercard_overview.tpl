{include file="overall_header.tpl"}
<table style="width:95%">
	<tr>
		<th colspan="3">{lang}pl_overview{/lang}</th>
		</tr>
	<tr>
		<td style="width:40%">{lang}pl_name{/lang}</td>
		<td colspan="2">{$name}</td>
	</tr>
	<tr>
		<td>{lang}pl_homeplanet{/lang}</td>
		<td colspan="2">{$homeplanet} <a href="#" onclick="opener.document.location = 'game.php?page=galaxy&amp;mode=3&amp;galaxy={$galaxy}&amp;system={$system}';return false;">[{$galaxy}:{$system}:{$planet}]</a></td>
	</tr>
	<tr>
		<td>{lang}pl_ally{/lang}</td>
		<td colspan="2">{if $allyname}<a href="#" onclick="opener.document.location = 'game.php?page=alliance&amp;mode=ainfo&amp;a={$allyid}';return false;">{$allyname}</a>{else}-{/if}</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<th>{lang}pl_points{/lang}</th>
		<th>{lang}pl_range{/lang}</th>
	</tr>
	<tr>
		<td>{lang}pl_builds{/lang}</td>
		<td>{$build_points}</td>
		<td>{$build_rank}</td>
	</tr>
	<tr>
		<td>{lang}pl_tech{/lang}</td>
		<td>{$tech_points}</td>
		<td>{$tech_rank}</td>
	</tr>
	<tr>
		<td>{lang}pl_fleet{/lang}</td>
		<td>{$fleet_points}</td>
		<td>{$fleet_rank}</td>
	</tr>
	<tr>
		<td>{lang}pl_def{/lang}</td>
		<td>{$defs_points}</td>
		<td>{$defs_rank}</td>
	</tr>
	<tr>
		<td>{lang}pl_total{/lang}</td>
		<td>{$total_points}</td>
		<td>{$total_rank}</td>
	</tr>
	<tr>
		<th colspan="3">{lang}pl_fightstats{/lang}</th>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>{lang}pl_fights{/lang}</td>
		<td>{lang}pl_fprocent{/lang}</td>
	</tr>
	<tr>
		<td>{lang}pl_fightwon{/lang}</td>
		<td>{$wons}</td>
		<td>{$siegprozent} %</td>
	</tr>
	<tr>
		<td>{lang}pl_fightdraw{/lang}</td>
		<td>{$draws}</td>
		<td>{$drawsprozent} %</td>
	</tr>
	<tr>
		<td>{lang}pl_fightlose{/lang}</td>
		<td>{$loos}</td>
		<td>{$loosprozent} %</td>
	</tr>
	<tr>
		<td>{lang}pl_totalfight{/lang}</td>
		<td>{$totalfights}</td>
		<td>100%</td>
	</tr>
	<tr>
		<th colspan="3">{$playerdestory}:</th>
	</tr>
	<tr>
		<td>{lang}pl_unitsshot{/lang}</td>
		<td colspan="2">{$desunits}</td>
	</tr>
	<tr>
		<td>{lang}pl_unitslose{/lang}</td>
		<td colspan="2">{$lostunits}</td>
	</tr>
	<tr>
		<td>{lang}pl_dermetal{/lang}</td>
		<td colspan="2">{$kbmetal}</td>
	</tr>
	<tr>
		<td>{lang}pl_dercrystal{/lang}</td>
		<td colspan="2">{$kbcrystal}</td>
	</tr>
{if $id != $yourid}
	<tr>
		<th colspan="3">{lang}pl_etc{/lang}</th>
	</tr>
	<tr>
		<td><a href="javascript:OpenPopup('game.php?page=buddy&amp;mode=2&amp;u={$id}', '', 720, 300);" title="{lang}pl_buddy{/lang}">{lang}pl_buddy{/lang}</a></td><td colspan="2"><a href="#" onclick="return Dialog.PM({$id});" title="{lang}pl_message{/lang}">{lang}pl_message{/lang}</a></td>
	</tr>
{/if}
</table>
{include file="overall_footer.tpl"}