<div class="reportMessage">
	<table>
		<tr>
			<td colspan="2"><a href="game.php?page=raport&amp;raport={$reportId}" target="_blank"><span class="{$attackClass}">{$LNG.sys_mess_attack_report} {$planetPos|htmlPlanetPosition} ({$LNG.type_planet_short[$planetPos.type]})</span></a></td>
		</tr>
		<tr>
			<td>{$LNG.sys_lost}</td><td><span class="{$attackClass}">{$LNG.sys_attack_attacker_pos}: {$unitLost.attacker|number}</span>&nbsp;<span class="{$defendClass}">{$LNG.sys_attack_defender_pos}: {$unitLost.defender|number}</span></td>
		</tr>
		<tr>
			<td>{$LNG.sys_gain}</td><td>{foreach $steal as $resourceElementId => $value}<span>{$LNG.tech[$resourceElementId]}:&nbsp;<span class="reportSteal element{$resourceElementId}">%s</span>{if !$value@last}&nbsp;{/if}</span>{/foreach}</td>
		</tr>
		<tr>
			<td>{$LNG.sys_debris}</td><td>{foreach $debris as $resourceElementId => $value}<span>{$LNG.tech[$resourceElementId]}:&nbsp;<span class="reportDebris element{$resourceElementId}">%s</span>{if !$value@last}&nbsp;{/if}</span>{/foreach}</td>
		</tr>
	</table>
</div>