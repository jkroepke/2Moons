{include file="overall_header.tpl"}
<table width="90%">
<tr>
    <th colspan="2">{$px_scan_position} [{$phl_pl_galaxy}:{$phl_pl_system}:{$phl_pl_place}] ({$phl_pl_name})</th>
</tr>
<tr>
    <th colspan="2">{$px_fleet_movement}</th>
</tr>
    {foreach key=ID item=FleetInfoRow from=$fleets}
		<tr class="{$FleetInfoRow.fleet_status}">
			<td id="fleettime_{$ID}" style="width:92px;">-</td>
			<td>
				{$FleetInfoRow.fleet_descr}
			</td>
		</tr>
	{foreachelse}
		<tr><td colspan="2">{$px_no_fleet}</td></tr>
	{/foreach}
</table>
<script type="text/javascript">
Fleets		= {$FleetData};
</script>
{include file="overall_footer.tpl"}