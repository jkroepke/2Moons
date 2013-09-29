{block name="title" prepend}{$LNG.lm_fleet}{/block}
{block name="content"}
<table class="table519">
	<tr style="height:20px">
		<th colspan="2" class="success">{$LNG.fl_fleet_sended}</span></th>
	</tr>
    <tr style="height:20px">
        <td>{$LNG.fl_mission}</td>
        <td>{$LNG.type_mission[$targetMission]}</td>
	</tr>
    <tr style="height:20px">
        <td>{$LNG.fl_distance}</td>
        <td>{$distance|number}</td>
    </tr>
    <tr style="height:20px">
        <td>{$LNG.fl_fleet_speed}</td>
        <td>{$fleetSpeed|number}</td>
    </tr>
    <tr style="height:20px">
        <td>{$LNG.fl_fuel_consumption}</td>
        <td>{$consumption|number}</td>
    </tr>
    <tr style="height:20px">
        <td>{$LNG.fl_from}</td>
        <td>{$from}</td>
    </tr>
    <tr style="height:20px">
        <td>{$LNG.fl_destiny}</td>
        <td>{$destination}</td>
    </tr>
    <tr style="height:20px">
        <td>{$LNG.fl_arrival_time}</td>
        <td>{$fleetArrivalTime}</td>
    </tr>
    <tr style="height:20px">
        <td>{$LNG.fl_return_time}</td>
        <td>{$fleetEndTime}</td>
    </tr>
    <tr style="height:20px">
        <th colspan="2">{$LNG.fl_fleet}</th>
    </tr>
	{foreach $fleetList as $elementId => $amount}
	<tr>
		<td>{$LNG.tech[$elementId]}</td>
		<td>{$amount|number}</td>
	</tr>
	{/foreach}
</table>
{/block}