{block name="title" prepend}{$LNG.lm_fleet}{/block}
{block name="content"}
<table class="table519">
	<tr class="highRow">
		<th colspan="2" class="success">{$LNG.fl_fleet_sended}</span></th>
	</tr>
    <tr class="highRow">
        <td>{$LNG.fl_mission}</td>
        <td>{$LNG.type_mission.{$targetMission}}</td>
	</tr>
    <tr class="highRow">
        <td>{$LNG.fl_distance}</td>
        <td>{$distance|number}</td>
    </tr>
    <tr class="highRow">
        <td>{$LNG.fl_fleet_speed}</td>
        <td>{$MaxFleetSpeed|number}</td>
    </tr>
    <tr class="highRow">
        <td>{$LNG.fl_fuel_consumption}</td>
        <td>{$consumption|number}</td>
    </tr>
    <tr class="highRow">
        <td>{$LNG.fl_from}</td>
        <td>{$from}</td>
    </tr>
    <tr class="highRow">
        <td>{$LNG.fl_destiny}</td>
        <td>{$destination}</td>
    </tr>
    <tr class="highRow">
        <td>{$LNG.fl_arrival_time}</td>
        <td>{$fleetStartTime}</td>
    </tr>
    <tr class="highRow">
        <td>{$LNG.fl_return_time}</td>
        <td>{$fleetEndTime}</td>
    </tr>
    <tr class="highRow">
        <th colspan="2">{$LNG.fl_fleet}</th>
    </tr>
	{foreach $FleetList as $ShipID => $ShipCount}
	<tr>
		<td>{$LNG.tech.{$ShipID}}</td>
		<td>{$ShipCount|number}</td>
	</tr>
	{/foreach}
</table>
{/block}