<table style="width:100%;">
	<tbody>
		<tr style="height:20px;">
			<th colspan="3" class="left">{$LNG.in_jump_gate_select_ships}</th>
		</tr>
		{if $gateData.restTime != 0}
		<tr style="height:20px;">
			<td colspan="3">{$LNG.in_jump_gate_wait_time} {$gateData.nextTime}&nbsp;(<span class="countdown" data-time="{$gateData.restTime}">{pretty_fly_time($gateData.restTime)}</span>)</td>
		</tr>
		{else}
			<tr style="height:20px;">
				<td>{$LNG.in_jump_gate_start_moon}</td>
				<td colspan="2">{$gateData.startLink}</td>
			</tr>
			{if !empty($gateData.gateList)}
				<tr style="height:20px;">
					<td>{$LNG.in_jump_gate_finish_moon}</td>
					<td colspan="2">{html_options options=$gateData.gateList name="jmpto" class="jumpgate"}</td>
				</tr>
				<tr>
					<th>{$LNG.fl_ship_type}</td>
					<th>{$LNG.fl_ship_available}</td>
					<th></td>
				</tr>
				{foreach $gateData.fleetList as $fleetID => $amount}
				<tr>
					<td style="width:33%;">{$LNG.tech.$fleetID}</td>
					<td style="width:33%;"><span id="ship{$fleetID}_value">{$amount|number}</span></td>
					<td style="width:33%;"><input class="jumpgate" name="ship[{$fleetID}]" id="ship{$fleetID}_input" size="7" value="0" type="text"><input onclick="Gate.max({$fleetID});" value="max" type="button"></td>
				</tr>
				{/foreach}
				<tr>
					<td colspan="3"><input value="{$LNG.in_jump_gate_jump}" type="button" onclick="Gate.submit();"></td>
				</tr>
			{else}
				<tr style="height:20px;">
					<td colspan="3"><span style="color:red">{$LNG.in_jump_gate_no_target}</span></td>
				</tr>
			{/if}
		{/if}
	</tbody>
</table>