{include file="overall_header.tpl"}
{if $GateFleetList}<form action="" method="post">{/if}
    <table width="519" align="center">
    <tbody>
    <tr>
        <td class="c" colspan="2">{$name}</td>
    </tr><tr>
        <th colspan="2">
        <table>
        <tbody>
        <tr>
            <td><img src="{$dpath}gebaeude/{$id}.gif" alt="{$name}" align="top" name="bild" border="0" height="120" width="120" onerror="document.images['bild'].src = 'styles/images/officiers/{$id}.jpg'"></td>
            <td>{$description}
			{if $RapidFire}
			<br><br>
			{foreach item=RapidFireTo key=RapidFireToName from=$RapidFire.to}
			{$in_rf_again} {$RapidFireToName} <font color="#00ff00">{$RapidFireTo}</font><br>
			{/foreach}
			{foreach item=RapidFireFrom key=RapidFireFromName from=$RapidFire.from}
			{$in_rf_from} {$RapidFireFromName} <font color="#ff0000">{$RapidFireFrom}</font><br>
			{/foreach}
			{$GateFleetList}
			{/if}
			</td>
        </tr>
        </tbody>
        </table>
        </th>
    </tr>
	{if $ProductionTable}
	<tr>
        <th colspan="2">
            <center>
            <table border="1">
            <tbody>
            <tr><td class="c">{$in_level}</td><td class="c">{if $id == 3}{$in_prod_energy}{else}{$in_prod_p_hour}{/if}</td><td class="c">{$in_difference}</td><td class="c">{if $id == 12}{$in_used_deuter}{elseif $id == 3}{$in_prod_energy}{else}{$in_used_energy}{/if}</td><td class="c">{$in_difference}</td></tr>
			{foreach item=LevelRow from=$ProductionTable}
            <tr><th>{if $Level == $LevelRow.BuildLevel}<font color="#ff0000">{$LevelRow.BuildLevel}</font>{else}{$LevelRow.BuildLevel}{/if}</th><th>{$LevelRow.prod}</th><th>{$LevelRow.prod_diff}</th><th>{$LevelRow.need}</th><th>{$LevelRow.need_diff}</th></tr>
			{/foreach}
            </tbody>
            </table>
            </center>
        </th>
    </tr>
	{elseif $FleetInfo}
	{foreach key=Name item=content from=$FleetInfo}
	<tr>
	<th>{$Name}</th>
	<th>
	{if is_array($content)}{$content.0}{if $content.0 != $content.1} <font color="yellow">({$content.1})</font>{/if}{else}{$content}{/if}
	{/foreach}
	</th></tr>
	{elseif $GateFleetList}
	{$gate_time_script}
	<tr style="height:20px;">
	<th>
	{$in_jump_gate_start_moon}</th><th>{$GateFleetList.start_link}</th>
	</tr><tr style="height:20px;">
	<th>{$in_jump_gate_finish_moon}</th>
	<th><select name="jmpto">{$GateFleetList.moons}</select></th></tr>
	<tr>
		<td class="c" colspan="2">{$in_jump_gate_select_ships}</td>
	</tr>
	{if $GateFleetList.jump}
	<tr>
		<th class="l" colspan="2" align="right">
			<table width="100%">
					<tr>
					<td style="background-color: transparent;white-space: nowrap;color: red" align="right">{$GateFleetList.jump}</td>
					</tr>
			</table>
		</th>
	</tr>
	{/if}
	{if $gate_time_script}
	<tr>
		<th class="l" colspan="2" align="right">
			<table width="100%">
					<tr>
					<td style="background-color: transparent;white-space: nowrap;" align="right">{$in_jump_gate_wait_time} <span id="bxxGate1"></span></td>
					</tr>
			</table>
		</th>
	</tr>
	{/if}
	{foreach name=GateFleetList item=GateFleetRow from=$GateFleetList.fleets}
	<tr>
		<th>{$GateFleetRow.name} ({$GateFleetRow.max} {$gate_ship_dispo})</th>
		<th><input tabindex="{$smarty.foreach.GateFleetList.iteration}" name="c{$GateFleetRow.id}" size="7" value="0" type="text"></th>
	</tr>
	{/foreach}
	<tr>
		<th colspan="2"><input value="{$in_jump_gate_jump}" type="submit" {if $gate_time_script}disabled{/if}></th>
	</tr>
	{$gate_script_go}
	{/if}
    </tbody>
    </table>
{if $GateFleetList}</form>{/if}
{include file="overall_footer.tpl"}