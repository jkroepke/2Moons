<tr>
	<td class="transparent" colspan="2" class="left">{$in_jump_gate_select_ships}<br /></td>
</tr>
<tr style="height:20px;">
	<td class="transparent">{$in_jump_gate_start_moon}</td>
	<td class="transparent">{$gate_start_link}</td>
</tr>
<tr style="height:20px;">
	<td class="transparent">{$in_jump_gate_finish_moon}</td>
	<td class="transparent"><select name="jmpto" class="jumpgate">{html_options options=$gate_moons}</select></td>
</tr>
{if $gate_jump == 0}
<tr>
	<td class="transparent" colspan="2" class="right">{$gate_jump}</td>
</tr>
{/if}
{if $gate_rest_time != 0}
<tr>
	<td class="transparent" colspan="2" class="right">{$in_jump_gate_wait_time} <span id="bxxGate1">{$gate_rest_time}</span><script type="text/javascript">Gate.time();</script></td>
</tr>
{else}
{foreach name=GateFleetList item=GateFleetRow from=$gate_fleets}
<tr>
	<td class="transparent" style="width:50%;">{$GateFleetRow.name} (<span id="ship{$GateFleetRow.id}_value">{$GateFleetRow.max}</span> {$gate_ship_dispo})</td>
	<td class="transparent" style="width:50%;"><input class="jumpgate" tabindex="{$smarty.foreach.gate_iteration}" name="ship{$GateFleetRow.id}" id="ship{$GateFleetRow.id}_input" size="7" value="0" type="text"><input onclick="Gate.max({$GateFleetRow.id});" value="max" type="button"></td>
</tr>
{/foreach}
<tr>
	<td class="transparent" colspan="2"><input value="{$in_jump_gate_jump}" type="button" onclick="Gate.submit();" ></td>
</tr>
{/if}