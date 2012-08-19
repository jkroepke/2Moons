{block name="title" prepend}{$LNG.lm_playercard}{/block}
{block name="content"}
<table width="90%">
<tr>
    <th colspan="2">{$LNG.px_scan_position} [{$galaxy}:{$system}:{$planet}] ({$name})</th>
</tr>
<tr>
    <th colspan="2">{$LNG.px_fleet_movement}</th>
</tr>
	{foreach $fleetTable as $index => $fleet}
	<tr>
		<td id="fleettime_{$index}" class="fleets" data-fleet-end-time="{$fleet.returntime}" data-fleet-time="{$fleet.resttime}">00:00:00</td>
		<td>{$fleet.text}</td>
	</tr>
	{foreachelse}
		<tr><td colspan="2">{$LNG.px_no_fleet}</td></tr>
	{/foreach}
</table>
{/block}