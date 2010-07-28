{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table border="0" cellpadding="0" cellspacing="1" width="519" align="center">
	<tr style="height:20px">
		<td class="c" colspan="2"><span class="success">{$fl_fleet_sended}</span></td>
	</tr>
    <tr style="height:20px">
        <th>{$fl_mission}</th>
        <th>{$mission}</th>
	</tr>
    <tr style="height:20px">
        <th>{$fl_distance}</th>
        <th>{$distance}</th>
    </tr>
    <tr style="height:20px">
        <th>{$fl_fleet_speed}</th>
        <th>{$speedallsmin}</th>
    </tr>
    <tr style="height:20px">
        <th>{$fl_fuel_consumption}</th>
        <th>{$consumption}</th>
    </tr>
    <tr style="height:20px">
        <th>{$fl_from}</th>
        <th>{$from}</th>
    </tr>
    <tr style="height:20px">
        <th>{$fl_destiny}</th>
        <th>{$destination}</th>
    </tr>
    <tr style="height:20px">
        <th>{$fl_arrival_time}</th>
        <th>{$start_time}</th>
    </tr>
    <tr style="height:20px">
        <th>{$fl_return_time}</th>
        <th>{$end_time}</th>
    </tr>
    <tr style="height:20px">
        <td class="c" colspan="2">{$fl_fleet}</td>
    </tr>
	{foreach key=Shipname item=Shipcount from=$FleetList}
	<tr>
	<th>{$Shipname}</th>
	<th>{$Shipcount}</th>
	</tr>
	{/foreach}
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}