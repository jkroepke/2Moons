{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table class="table519">
	<tr style="height:20px">
		<th colspan="2" class="success">{$fl_fleet_sended}</span></th>
	</tr>
    <tr style="height:20px">
        <td>{$fl_mission}</td>
        <td>{$mission}</td>
	</tr>
    <tr style="height:20px">
        <td>{$fl_distance}</td>
        <td>{$distance}</td>
    </tr>
    <tr style="height:20px">
        <td>{$fl_fleet_speed}</td>
        <td>{$speedallsmin}</td>
    </tr>
    <tr style="height:20px">
        <td>{$fl_fuel_consumption}</td>
        <td>{$consumption}</td>
    </tr>
    <tr style="height:20px">
        <td>{$fl_from}</td>
        <td>{$from}</td>
    </tr>
    <tr style="height:20px">
        <td>{$fl_destiny}</td>
        <td>{$destination}</td>
    </tr>
    <tr style="height:20px">
        <td>{$fl_arrival_time}</td>
        <td>{$start_time}</td>
    </tr>
    <tr style="height:20px">
        <td>{$fl_return_time}</td>
        <td>{$end_time}</td>
    </tr>
    <tr style="height:20px">
        <th colspan="2">{$fl_fleet}</th>
    </tr>
	{foreach key=Shipname item=Shipcount from=$FleetList}
	<tr>
	<td>{$Shipname}</td>
	<td>{$Shipcount}</td>
	</tr>
	{/foreach}
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}