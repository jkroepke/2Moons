{include file="adm/overall_header.tpl"}
<table width="90%">
<tr>
	<th>{$ff_id}</th>
	<th>{$ff_ammount}</th>
	<th>{$ff_mission}</th>
	<th>{$ff_beginning}</th>
	<th>{$ff_departure}</th>
	<th>{$ff_departure_hour}</th>
	<th>{$ff_objective}</th>
	<th>{$ff_arrival}</th>
	<th>{$ff_arrival_hour}</th>
    <th>{$ff_hold_position}</th>
    <th>{$ff_lock}</th>
</tr>
{foreach item=FleetItem from=$FleetList}
<tr>
	<td>{$FleetItem.Id}</td>
	<td>{$FleetItem.Fleet}</td>
	<td>{$FleetItem.Mission}</td>
	<td>{$FleetItem.St_Owner}</td>
	<td>{$FleetItem.St_Posit}</td>
	<td>{$FleetItem.St_Time}</td>
	<td>{$FleetItem.En_Owner}</td>
	<td>{$FleetItem.En_Posit}</td>
	<td>{$FleetItem.En_Time}</td>
    <td>{$FleetItem.Wa_Time}</td>
    <td>{$FleetItem.lock}</td>
</tr>
{foreachelse}
<tr>
	<td colspan="11">{$ff_no_fleets}</td>
</tr>
{/foreach}
</table>
</body>
{include file="adm/overall_footer.tpl"}