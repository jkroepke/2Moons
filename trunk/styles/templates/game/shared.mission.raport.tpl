{block name="title" prepend}{$LNG.lm_topkb}{/block}
{block name="content"}
{if isset($Info)}
<table style="width:100%">
	<tr>
		<td class="transparent" style="width:40%;font-size:22px;font-weight:bold;padding:10px 0 30px;color:{if $Raport.result == "a"}lime{elseif $Raport.result == "r"}red{else}white{/if}">{$Info.0}</td>
		<td class="transparent" style="font-size:22px;font-weight:bold;padding:10px 0 30px;">VS</td>
		<td class="transparent" style="width:40%;font-size:22px;font-weight:bold;padding:10px 0 30px;color:{if $Raport.result == "r"}lime{elseif $Raport.result == "a"}red{else}white{/if}">{$Info.1}</td>
	</tr>
</table>
{/if}
<div style="width:100%;text-align:center">
{if $Raport.mode == 1}{$LNG.sys_destruc_title}{else}{$LNG.sys_attack_title}{/if} 
{$Raport.time}:<br><br>
{foreach $Raport.rounds as $Round => $RoundInfo}
<table>
	<tr>
		{foreach $RoundInfo.attacker as $Player}
		{$PlayerInfo = $Raport.players[$Player.userID]}
		<td class="transparent">
			<table>
				<tr>
					<td>
						{$LNG.sys_attack_attacker_pos} {$PlayerInfo.name} {if isset($Info)}([XX:XX:XX]){else}([{$PlayerInfo.koords[0]}:{$PlayerInfo.koords[1]}:{$PlayerInfo.koords[2]}]){/if}<br>
						{$LNG.sys_ship_weapon} {$PlayerInfo.tech[0]}% - {$LNG.sys_ship_shield} {$PlayerInfo.tech[1]}% - {$LNG.sys_ship_armour} {$PlayerInfo.tech[2]}%
						<table width="100%">
						{if !empty($Player.ships)}
							<tr>
								<td class="transparent">{$LNG.sys_ship_type}</td>
								{foreach $Player.ships as $ShipID => $ShipData}
								<td class="transparent">{$LNG.shortNames.{$ShipID}}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{$LNG.sys_ship_count}</td>
								{foreach $Player.ships as $ShipID => $ShipData}
								<td class="transparent">{$ShipData[0]|number}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{$LNG.sys_ship_weapon}</td>
								{foreach $Player.ships as $ShipID => $ShipData}
								<td class="transparent">{$ShipData[1]|number}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{$LNG.sys_ship_shield}</td>
								{foreach $Player.ships as $ShipID => $ShipData}
								<td class="transparent">{$ShipData[2]|number}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{$LNG.sys_ship_armour}</td>
								{foreach $Player.ships as $ShipID => $ShipData}
								<td class="transparent">{$ShipData[3]|number}</td>
								{/foreach}
							</tr>
						{else}
							<tr>
								<td class="transparent">
									<br>{$LNG.sys_destroyed}<br><br>
								</td>
							</tr>
						{/if}
						</table>
					</td>
				</tr>
			</table>
		</td>
		{/foreach}
	</tr>
</table>
<br><br>
<table>
	<tr>
		{foreach $RoundInfo.defender as $Player}
		{$PlayerInfo = $Raport.players[$Player.userID]}
		<td class="transparent">
			<table>
				<tr>
					<td>
						{$LNG.sys_attack_defender_pos} {$PlayerInfo.name} {if isset($Info)}([XX:XX:XX]){else}([{$PlayerInfo.koords[0]}:{$PlayerInfo.koords[1]}:{$PlayerInfo.koords[2]}]){/if}<br>
						{$LNG.sys_ship_weapon} {$PlayerInfo.tech[0]}% - {$LNG.sys_ship_shield} {$PlayerInfo.tech[1]}% - {$LNG.sys_ship_armour} {$PlayerInfo.tech[2]}%
						<table width="100%">
						{if !empty($Player.ships)}
							<tr>
								<td class="transparent">{$LNG.sys_ship_type}</td>
								{foreach $Player.ships as $ShipID => $ShipData}
								<td class="transparent">{$LNG.shortNames.{$ShipID}}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{$LNG.sys_ship_count}</td>
								{foreach $Player.ships as $ShipID => $ShipData}
								<td class="transparent">{$ShipData[0]|number}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{$LNG.sys_ship_weapon}</td>
								{foreach $Player.ships as $ShipID => $ShipData}
								<td class="transparent">{$ShipData[1]|number}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{$LNG.sys_ship_shield}</td>
								{foreach $Player.ships as $ShipID => $ShipData}
								<td class="transparent">{$ShipData[2]|number}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{$LNG.sys_ship_armour}</td>
								{foreach $Player.ships as $ShipID => $ShipData}
								<td class="transparent">{$ShipData[3]|number}</td>
								{/foreach}
							</tr>
						{else}
							<tr>
								<td class="transparent">
									<br>{$LNG.sys_destroyed}<br><br>
								</td>
							</tr>
						{/if}
						</table>
					</td>
				</tr>
			</table>
		</td>
		{/foreach}
	</tr>
</table>
{if !$RoundInfo@last}
{$LNG.fleet_attack_1} {$RoundInfo.info[0]|number} {$LNG.fleet_attack_2} {$RoundInfo.info[3]|number} {$LNG.damage}<br>
{$LNG.fleet_defs_1} {$RoundInfo.info[2]|number} {$LNG.fleet_defs_2} {$RoundInfo.info[1]|number} {$LNG.damage}<br><br>
{/if}
{/foreach}
<br><br>
{if $Raport.result == "a"}
{$LNG.sys_attacker_won}<br>
{$LNG.sys_stealed_ressources} {$Raport.steal[0]|number} {$LNG.tech.901}, 
{$Raport.steal[1]|number} {$LNG.tech.902} {$LNG.and} 
{$Raport.steal[2]|number} {$LNG.tech.903}
{elseif $Raport.result == "r"}
{$LNG.sys_defender_won}
{else}
{$LNG.sys_both_won}
{/if}
<br><br>
{$LNG.sys_attacker_lostunits} {$Raport['units'][0]|number} {$LNG.sys_units}<br>
{$LNG.sys_defender_lostunits} {$Raport['units'][1]|number} {$LNG.sys_units}<br>
{$LNG.debree_field_1} {$Raport.debris[0]|number} {$LNG.tech.901} {$LNG.sys_and}
{$Raport.debris[1]|number} {$LNG.tech.902} {$LNG.debree_field_2}<br><br>
{if $Raport.mode == 1}
	{if isset($Info)}
		{sprintf($LNG.sys_destruc_mess, "XX", "XX", "XX", "XX", "XX", "XX")}<br>
	{else}
		{sprintf($LNG.sys_destruc_mess, "{$Raport.start[0]}", "{$Raport.start[1]}", "{$Raport.start[2]}", "{$Raport.koords[0]}", "{$Raport.koords[1]}", "{$Raport.koords[2]}")}<br>
	{/if}
	{if $Raport.moon[2] == 1}
		{$LNG.sys_destruc_stop}<br>
	{else}
		{sprintf($LNG.sys_destruc_lune, "{$Raport.moon[0]}")}<br>{$LNG.sys_destruc_mess1}
		{if $Raport.moon[2] == 0}
			{$LNG.sys_destruc_reussi}
		{else}
			{$LNG.sys_destruc_null}			
		{/if}
		<br>
		{sprintf($LNG.sys_destruc_rip, "{$Raport.moon[3]}")}
		{if $Raport.moon[4] == 1}
			<br>{$LNG.sys_destruc_echec}
		{/if}			
	{/if}
{else}
	{$LNG.sys_moonproba} {$Raport.moon[0]} %<br>
	{if !empty($Raport.moon[1])}
		{if isset($Info)}
			{sprintf($LNG.sys_moonbuilt, "{$Raport.moon[1]}", "XX", "XX", "XX")}
		{else}
			{sprintf($LNG.sys_moonbuilt, "{$Raport.moon[1]}", "{$Raport.koords[0]}", "{$Raport.koords[1]}", "{$Raport.koords[2]}")}
		{/if}
	{/if}
{/if}

{$Raport['simu']}
</div>
{/block}