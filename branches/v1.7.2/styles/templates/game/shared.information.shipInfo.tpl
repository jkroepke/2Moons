<table style="width:100%;">
	<tbody>
		{if !empty($FleetInfo.tech)}
		<tr>
			<td style="width:50%">{$LNG.in_engine}</td>
			<td style="width:50%">{if $FleetInfo.tech == 1}{$LNG.tech.115}{elseif $FleetInfo.tech == 2}{$LNG.tech.117}{elseif $FleetInfo.tech == 3}{$LNG.tech.118}{elseif $FleetInfo.tech == 4}{$LNG.tech.115} <span style="color:yellow">({$LNG.tech.117})</span>{elseif $FleetInfo.tech == 3}{$LNG.tech.117} <span style="color:yellow">({$LNG.tech.118})</span>{else}-{/if}</td>
		</tr>
		{/if}
		<tr>
			<td style="width:50%">{$LNG.in_struct_pt}</td>
			<td style="width:50%">{$FleetInfo.structure|number}</td>
		</tr>
		<tr>
			<td style="width:50%">{$LNG.in_attack_pt}</td>
			<td style="width:50%">{$FleetInfo.attack|number}</td>
		</tr>
		<tr>
			<td style="width:50%">{$LNG.in_shield_pt}</td>
			<td style="width:50%">{$FleetInfo.shield|number}</td>
		</tr>
		{if !empty($FleetInfo.capacity)}
		<tr>
			<td style="width:50%">{$LNG.in_capacity}</td>
			<td style="width:50%">{$FleetInfo.capacity|number}</td>
		</tr>
		{/if}
		{if !empty($FleetInfo.speed1)}
		<tr>
			<td style="width:50%">{$LNG.in_base_speed}</td>
			<td style="width:50%">{$FleetInfo.speed1|number}{if $FleetInfo.speed1 != $FleetInfo.speed2} <span style="color:yellow">({$FleetInfo.speed2|number})</span>{/if}</td>
		</tr>
		{/if}
		{if !empty($FleetInfo.consumption1)}
		<tr>
			<td style="width:50%">{$LNG.in_consumption}</td>
			<td style="width:50%">{$FleetInfo.consumption1|number}{if $FleetInfo.consumption1 != $FleetInfo.consumption2} <span style="color:yellow">({$FleetInfo.consumption2|number})</span>{/if}</td>
		</tr>
		{/if}
	</tbody>
</table>