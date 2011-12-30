{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
<table class="table519">
	<tr style="height:20px">
		<th colspan="2" class="success">{lang}fl_fleet_sended{/lang}</span></th>
	</tr>
    <tr style="height:20px">
        <td>{lang}fl_mission{/lang}</td>
        <td>{lang}type_mission.{$targetMission}{/lang}</td>
	</tr>
    <tr style="height:20px">
        <td>{lang}fl_distance{/lang}</td>
        <td>{$distance|number}</td>
    </tr>
    <tr style="height:20px">
        <td>{lang}fl_fleet_speed{/lang}</td>
        <td>{$MaxFleetSpeed|number}</td>
    </tr>
    <tr style="height:20px">
        <td>{lang}fl_fuel_consumption{/lang}</td>
        <td>{$consumption|number}</td>
    </tr>
    <tr style="height:20px">
        <td>{lang}fl_from{/lang}</td>
        <td>{$from}</td>
    </tr>
    <tr style="height:20px">
        <td>{lang}fl_destiny{/lang}</td>
        <td>{$destination}</td>
    </tr>
    <tr style="height:20px">
        <td>{lang}fl_arrival_time{/lang}</td>
        <td>{$fleetStartTime}</td>
    </tr>
    <tr style="height:20px">
        <td>{lang}fl_return_time{/lang}</td>
        <td>{$fleetEndTime}</td>
    </tr>
    <tr style="height:20px">
        <th colspan="2">{lang}fl_fleet{/lang}</th>
    </tr>
	{foreach $FleetList as $ShipID => $ShipCount}
	<tr>
		<td>{lang}tech.{$ShipID}{/lang}</td>
		<td>{$ShipCount|number}</td>
	</tr>
	{/foreach}
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}