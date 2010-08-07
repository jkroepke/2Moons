{include file="adm/overall_header.tpl"}
<table width="90%">
<tr>
	<td class="c">{$ff_id}</td>
	<td class="c">{$ff_ammount}</td>
	<td class="c">{$ff_mission}</td>
	<td class="c">{$ff_beginning}</td>
	<td class="c">{$ff_departure}</td>
	<td class="c">{$ff_departure_hour}</td>
	<td class="c">{$ff_objective}</td>
	<td class="c">{$ff_arrival}</td>
	<td class="c">{$ff_arrival_hour}</td>
    <td class="c">{$ff_hold_position}</td>
    <td class="c">{$ff_lock}</td>
</tr>
{foreach item=FleetItem from=$FleetList}
<tr>
	<th>{$FleetItem.Id}</th>
	<th>{$FleetItem.Fleet}</th>
	<th>{$FleetItem.Mission}</th>
	<th>{$FleetItem.St_Owner}</th>
	<th>{$FleetItem.St_Posit}</th>
	<th>{$FleetItem.St_Time}</th>
	<th>{$FleetItem.En_Owner}</th>
	<th>{$FleetItem.En_Posit}</th>
	<th>{$FleetItem.En_Time}</th>
    <th>{$FleetItem.Wa_Time}</th>
    <th>{$FleetItem.lock}</th>
</tr>
{foreachelse}
<tr>
	<th colspan="11">{$ff_no_fleets}</th>
</tr>
{/foreach}
</table>
</body>
{include file="adm/overall_footer.tpl"}