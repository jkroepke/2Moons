{include file="overall_header.tpl"}
<table width="90%">
<tr>
    <th colspan="2">{$LNG.px_scan_position} [{$galaxy}:{$system}:{$planet}] ({$name})</th>
</tr>
<tr>
    <th colspan="2">{$LNG.px_fleet_movement}</th>
</tr>
	{foreach $fleetTable as $index => $fleet}
	<tr>
		<td id="fleettime_{$index}" class="fleets" data-fleet-end-time="{$fleet.returntime}" data-fleet-time="{$fleet.resttime}">-</td>
		<td colspan="2">{$fleet.text}</td>
	</tr>
	{/foreach}
	{foreachelse}
		<tr><td colspan="2">{$LNG.px_no_fleet}</td></tr>
	{/foreach}
</table>
{/block}