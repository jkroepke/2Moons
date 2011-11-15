{include file="overall_header.tpl"}
{if $fame == 1}
<table style="width:100%">
	<tr>
		<td class="transparent" style="width:40%;font-size:22px;font-weight:bold;">{$Info.0}</td>
		<td class="transparent" style="font-size:22px;font-weight:bold;">VS</td>
		<td class="transparent" style="width:40%;font-size:22px;font-weight:bold;">{$Info.1}</td>
	</tr>
</table>
{/if}
<div style="width:100%;text-align:center">
{if $Raport.mode == 1}{lang}sys_destruc_title{/lang}{else}{lang}sys_attack_title{/lang}{/if} 
{tz_date($Raport.time)}:<br><br>
{foreach $Raport.rounds as $Round => $RoundInfo}
<table>
	<tr>
		{foreach $RoundInfo.attacker as $PlayerID => $PlayerShips}
		{$PlayerInfo = $Raport.players[$PlayerID]}
		<td class="transparent">
			<table>
				<tr>
					<td>
						{lang}sys_attack_attacker_pos{/lang} {$PlayerInfo.name} {if $fame == 1}([XX:XX:XX]){else}([{$PlayerInfo.koords[0]}:{$PlayerInfo.koords[1]}:{$PlayerInfo.koords[2]}]){/if}<br>
						{lang}sys_ship_weapon{/lang} {$PlayerInfo.tech[0]}% - {lang}sys_ship_shield{/lang} {$PlayerInfo.tech[1]}% - {lang}sys_ship_armour{/lang} {$PlayerInfo.tech[2]}%
						<table width="100%">
						{if !empty($PlayerShips)}
							<tr>
								<td class="transparent">{lang}sys_ship_type{/lang}</td>
								{foreach $PlayerShips as $ShipID => $ShipData}
								<td class="transparent">{lang}tech_rc.{$ShipID}{/lang}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{lang}sys_ship_count{/lang}</td>
								{foreach $PlayerShips as $ShipID => $ShipData}
								<td class="transparent">{pretty_number($ShipData[0])}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{lang}sys_ship_weapon{/lang}</td>
								{foreach $PlayerShips as $ShipID => $ShipData}
								<td class="transparent">{pretty_number($ShipData[1])}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{lang}sys_ship_shield{/lang}</td>
								{foreach $PlayerShips as $ShipID => $ShipData}
								<td class="transparent">{pretty_number($ShipData[2])}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{lang}sys_ship_armour{/lang}</td>
								{foreach $PlayerShips as $ShipID => $ShipData}
								<td class="transparent">{pretty_number($ShipData[3])}</td>
								{/foreach}
							</tr>
						{else}
							<tr>
								<td class="transparent">
									<br>{lang}sys_destroyed{/lang}<br><br>
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
		{foreach $RoundInfo.defender as $PlayerID => $PlayerShips}
		{$PlayerInfo = $Raport.players[$PlayerID]}
		<td class="transparent">
			<table>
				<tr>
					<td>
						{lang}sys_attack_defender_pos{/lang} {$PlayerInfo.name} {if $fame == 1}([XX:XX:XX]){else}([{$PlayerInfo.koords[0]}:{$PlayerInfo.koords[1]}:{$PlayerInfo.koords[2]}]){/if}<br>
						{lang}sys_ship_weapon{/lang} {$PlayerInfo.tech[0]}% - {lang}sys_ship_shield{/lang} {$PlayerInfo.tech[1]}% - {lang}sys_ship_armour{/lang} {$PlayerInfo.tech[2]}%
						<table width="100%">
						{if !empty($PlayerShips)}
							<tr>
								<td class="transparent">{lang}sys_ship_type{/lang}</td>
								{foreach $PlayerShips as $ShipID => $ShipData}
								<td class="transparent">{lang}tech_rc.{$ShipID}{/lang}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{lang}sys_ship_count{/lang}</td>
								{foreach $PlayerShips as $ShipID => $ShipData}
								<td class="transparent">{pretty_number($ShipData[0])}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{lang}sys_ship_weapon{/lang}</td>
								{foreach $PlayerShips as $ShipID => $ShipData}
								<td class="transparent">{pretty_number($ShipData[1])}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{lang}sys_ship_shield{/lang}</td>
								{foreach $PlayerShips as $ShipID => $ShipData}
								<td class="transparent">{pretty_number($ShipData[2])}</td>
								{/foreach}
							</tr>
							<tr>
								<td class="transparent">{lang}sys_ship_armour{/lang}</td>
								{foreach $PlayerShips as $ShipID => $ShipData}
								<td class="transparent">{pretty_number($ShipData[3])}</td>
								{/foreach}
							</tr>
						{else}
							<tr>
								<td class="transparent">
									<br>{lang}sys_destroyed{/lang}<br><br>
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
{lang}fleet_attack_1{/lang} {pretty_number($RoundInfo.info[0])} {lang}fleet_attack_2{/lang} {pretty_number($RoundInfo.info[3])} {lang}damage{/lang}<br>
{lang}fleet_defs_1{/lang} {pretty_number($RoundInfo.info[2])} {lang}fleet_defs_2{/lang} {pretty_number($RoundInfo.info[1])} {lang}damage{/lang}<br><br>
{/if}
{/foreach}
<br><br>
{if $Raport.result == "a"}
{lang}sys_attacker_won{/lang}<br>
{lang}sys_stealed_ressources{/lang} {pretty_number($Raport.steal[0])} {lang}Metal{/lang}, 
{pretty_number($Raport.steal[1])} {lang}Crystal{/lang} {lang}and{/lang} 
{pretty_number($Raport.steal[2])} {lang}Deuterium{/lang}
{elseif $Raport.result == "r"}
{lang}sys_defender_won{/lang}
{else}
{lang}sys_both_won{/lang}
{/if}
<br><br>
{lang}sys_attacker_lostunits{/lang} {pretty_number($Raport['units'][0])} {lang}sys_units{/lang}<br>
{lang}sys_defender_lostunits{/lang} {pretty_number($Raport['units'][1])} {lang}sys_units{/lang}<br>
{lang}debree_field_1{/lang} {pretty_number($Raport.debris[0])} {lang}Metal{/lang} {lang}sys_and{/lang}
{pretty_number($Raport.debris[1])} {lang}Crystal{/lang} {lang}debree_field_2{/lang}<br><br>
{if $Raport.mode == 1}
	{capture sys_destruc_mess assign=sys_destruc_mess}{lang}sys_destruc_mess{/lang}{/capture}
	{capture sys_destruc_lune assign=sys_destruc_lune}{lang}sys_destruc_lune{/lang}{/capture}
	{capture sys_destruc_rip assign=sys_destruc_rip}{lang}sys_destruc_rip{/lang}{/capture}
	{if $fame == 1}
		{sprintf($sys_destruc_mess, "XX", "XX", "XX", "XX", "XX", "XX")}<br>
	{else}
		{sprintf($sys_destruc_mess, "{$Raport.start[0]}", "{$Raport.start[1]}", "{$Raport.start[2]}", "{$Raport.koords[0]}", "{$Raport.koords[1]}", "{$Raport.koords[2]}")}<br>
	{/if}
	{if $Raport.moon[2] == 1}
		{lang}sys_destruc_stop{/lang}<br>
	{else}
		{sprintf($sys_destruc_lune, "{$Raport.moon[0]}")}<br>{lang}sys_destruc_mess1{/lang}
		{if $Raport.moon[2] == 0}
			{lang}sys_destruc_reussi{/lang}
		{else}
			{lang}sys_destruc_null{/lang}			
		{/if}
		<br>
		{sprintf($sys_destruc_rip, "{$Raport.moon[3]}")}
		{if $Raport.moon[4] == 1}
			<br>{lang}sys_destruc_echec{/lang}
		{/if}			
	{/if}
{else}
	{capture sys_moonbuilt assign=sys_moonbuilt}{lang}sys_moonbuilt{/lang}{/capture}
	{lang}sys_moonproba{/lang} {$Raport.moon[0]} %<br>
	{if !empty($Raport.moon[1])}
		{if $fame == 1}
			{sprintf($sys_moonbuilt, "{$Raport.moon[1]}", "XX", "XX", "XX")}
		{else}
			{sprintf($sys_moonbuilt, "{$Raport.moon[1]}", "{$Raport.koords[0]}", "{$Raport.koords[1]}", "{$Raport.koords[2]}")}
		{/if}
	{/if}
{/if}

{$Raport['simu']}
</div>
{include file="overall_footer.tpl"}