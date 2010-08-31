{include file="overall_header.tpl"}
<table class="table519">
<tr>
    <th colspan="2">{$px_scan_position} [{$phl_pl_galaxy}:{$phl_pl_system}:{$phl_pl_place}] ({$phl_pl_name})</th>
</tr>
<tr>
    <th colspan="2">{$px_fleet_movement}</th>
</tr>
    {foreach item=FleetInfoRow from=$fleets}
	<tr class="{$FleetInfoRow.fleet_status}">
		<td style="width:80px;">
		{$FleetInfoRow.fleet_javai}
			<div id="bxx{$FleetInfoRow.fleet_order}" class="z">-</div>
		</td><td>
			<span class="{$FleetInfoRow.fleet_status} {$FleetInfoRow.fleet_prefix}{$FleetInfoRow.fleet_style}">{$FleetInfoRow.fleet_descr}</span>
		{$FleetInfoRow.fleet_javas}
		</td>
	</tr>
	{foreachelse}
	<tr><td colspan="2">{$px_no_fleet}</td></tr>
	{/foreach}
</table>
{include file="overall_footer.tpl"}