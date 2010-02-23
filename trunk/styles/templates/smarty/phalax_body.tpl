{include file="overall_header.tpl"}
<table width="519" align="center">
<tr>
    <td class="c" colspan="4">{$px_scan_position} [{$phl_pl_galaxy}:{$phl_pl_system}:{$phl_pl_place}] ({$phl_pl_name})</td>
</tr>
<tr>
    <td class="c" colspan="4">{$px_fleet_movement}</td>
</tr>
    {foreach item=FleetInfoRow from=$fleets}
	<tr class="{$FleetInfoRow.fleet_status}">
		<th style="width:80px;">
		{$FleetInfoRow.fleet_javai}
			<div id="bxx{$FleetInfoRow.fleet_order}" class="z">-</div>
		</th><th colspan="3">
			<span class="{$FleetInfoRow.fleet_status} {$FleetInfoRow.fleet_prefix}{$FleetInfoRow.fleet_style}">{$FleetInfoRow.fleet_descr}</span>
		{$FleetInfoRow.fleet_javas}
		</th>
	</tr>
	{foreachelse}
	<tr><th colspan="4">{$px_no_fleet}</th></tr>
	{/foreach}
</table>
{include file="overall_footer.tpl"}