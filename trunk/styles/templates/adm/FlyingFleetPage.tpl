{include file="overall_header.tpl"}
<table width="90%">
<tr>
	<th>{lang}ff_fleetid{/lang}</th>
	<th>{lang}ff_mission{/lang}</th>
	<th>{lang}ff_starttime{/lang}</th>
	<th>{lang}ff_ships{/lang}</th>
	<th>{lang}ff_startuser{/lang}</th>
	<th>{lang}ff_startplanet{/lang}</th>
	<th>{lang}ff_arrivaltime{/lang}</th>
	<th>{lang}ff_targetuser{/lang}</th>
	<th>{lang}ff_targetplanet{/lang}</th>
    <th>{lang}ff_endtime{/lang}</th>
    <th>{lang}ff_holdtime{/lang}</th>
    <th>{lang}ff_lock{/lang}</th>
</tr>
{foreach $FleetList as $FleetRow}
<tr>
	<td>{$FleetRow.fleetID}</td>
	<td><a href="#" name="<table style='width:200px'>{foreach $FleetRow.resource as $resourceID => $resourceCount}<tr><td style='width:50%'>{lang}tech.{$resourceID}{/lang}</td><td style='width:50%'>{$resourceCount|number}</td></tr>{/foreach}</table>" class="tooltip">{lang}type_mission.{$FleetRow.missionID}{/lang}{if $FleetRow.acsID != 0}<br>{$FleetRow.acsID}<br>{$FleetRow.acsName}{/if}&nbsp;(R)</a></td>
	<td>{$FleetRow.starttime}</td>
	<td><a href="#" name="<table style='width:200px'>{foreach $FleetRow.ships as $shipID => $shipCount}<tr><td style='width:50%'>{lang}tech.{$shipID}{/lang}</td><td style='width:50%'>{$shipCount|number}</td></tr>{/foreach}</table>" class="tooltip">{$FleetRow.count|number}&nbsp;(D)</a></td>
	<td>{$FleetRow.startUserName} (ID:&nbsp;{$FleetRow.startUserID})</td>
	<td>{$FleetRow.startPlanetName}&nbsp;[{$FleetRow.startPlanetGalaxy}:{$FleetRow.startPlanetSystem}:{$FleetRow.startPlanetPlanet}] (ID:&nbsp;{$FleetRow.startPlanetID})</td>
	<td>{if $FleetRow.state == 0}<span style="color:lime;">{/if}{$FleetRow.arrivaltime}{if $FleetRow.state == 0}</span>{/if}</td>
	<td>{if $FleetRow.targetUserID != 0}{$FleetRow.targetUserName} (ID:&nbsp;{$FleetRow.targetUserID}){/if}</td>
	<td>{$FleetRow.targetPlanetName}&nbsp;[{$FleetRow.targetPlanetGalaxy}:{$FleetRow.targetPlanetSystem}:{$FleetRow.targetPlanetPlanet}]{if $FleetRow.targetPlanetID != 0} (ID:&nbsp;{$FleetRow.targetPlanetID}){/if}</td>
	<td>{if $FleetRow.state == 1}<span style="color:lime;">{/if}{$FleetRow.endtime}{if $FleetRow.state == 0}</span>{/if}</td>
	<td>{if $FleetRow.stayhour !== 0}{if $FleetRow.state == 2}<span style="color:lime;">{/if}{$FleetRow.staytime} ({$FleetRow.stayhour}&nbsp;h){if $FleetRow.state == 0}</span>{/if}{else}-{/if}</td>
    <td><a href="admin.php?page=fleets&amp;id={$FleetRow.fleetID}&amp;lock={if $FleetRow.lock}0" style="color:lime">{lang}ff_unlock{/lang}{else}1" style="color:red">{lang}ff_lock{/lang}{/if}</a></td>
</tr>
{foreachelse}
<tr>
	<td colspan="11">{lang}ff_no_fleets{/lang}</td>
</tr>
{/foreach}
</table>
</body>
{include file="overall_footer.tpl"}