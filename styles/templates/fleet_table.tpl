{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
    <table>
        <tr>
        	<th colspan="9">
                <div class="transparent" style="text-align:left;float:left;">{lang}fl_fleets{/lang} {$activeFleetSlots} / {$maxFleetSlots}</div>
				<div class="transparent" style="text-align:right;float:right;">{$activeExpedition} / {$maxExpedition} {lang}fl_expeditions{/lang}</div>
        	</th>
        </tr>
        <tr>
            <td>{lang}fl_number{/lang}</td>
            <td>{lang}fl_mission{/lang}</td>
            <td>{lang}fl_ammount{/lang}</td>
            <td>{lang}fl_beginning{/lang}</td>
            <td>{lang}fl_departure{/lang}</td>
            <td>{lang}fl_destiny{/lang}</td>
            <td>{lang}fl_objective{/lang}</td>
            <td>{lang}fl_arrival{/lang}</td>
            <td>{lang}fl_order{/lang}</td>
        </tr>
        {foreach name=FlyingFleets item=FlyingFleetRow from=$FlyingFleetList}
		<tr>
		<td>{$smarty.foreach.FlyingFleets.iteration}</td>
		<td>{lang}type_mission.{$FlyingFleetRow.mission}{/lang}
		{if $FlyingFleetRow.state == 1}
			<br><a title="{lang}fl_returning{/lang}">{lang}fl_r{/lang}</a>
		{else}
			<br><a title="{lang}fl_onway{/lang}">{lang}fl_a{/lang}</a>
		{/if}
		</td>
		<td><a class="tooltip_sticky" name="<table width='100%'><tr><th colspan='2' style='text-align:center;'>{lang}fl_info_detail{/lang}</th></tr>{foreach $FlyingFleetRow.FleetList as $shipID => $shipCount}<tr><td class='transparent'>{lang}tech.{$shipID}{/lang}:</td><td class='transparent'>{$shipCount}</td></tr>{/foreach}</table>">{$FlyingFleetRow.amount}</a></td>
		<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$FlyingFleetRow.startGalaxy}&amp;system={$FlyingFleetRow.startSystem}">[{$FlyingFleetRow.startGalaxy}:{$FlyingFleetRow.startSystem}:{$FlyingFleetRow.startPlanet}]</a></td>
		<td>{$FlyingFleetRow.startTime}</td>
		<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$FlyingFleetRow.endGalaxy}&amp;system={$FlyingFleetRow.endSystem}">[{$FlyingFleetRow.endGalaxy}:{$FlyingFleetRow.endSystem}:{$FlyingFleetRow.endPlanet}]</a></td>
		<td>{$FlyingFleetRow.endTime}</td>
		<td style="color:lime">{$FlyingFleetRow.backin}</td>
		<td>
		{if $FlyingFleetRow.state != 1}
			<form action="?page=fleet&amp;action=sendfleetback" method="post">
			<input name="fleetID" value="{$FlyingFleetRow.id}" type="hidden">
			<input value="{lang}fl_send_back{/lang}" type="submit">
			</form>
			{if $FlyingFleetRow.mission == 1}
			<form action="?page=fleet&amp;action=getakspage" method="post">
			<input name="fleetID" value="{$FlyingFleetRow.id}" type="hidden">
			<input value="{lang}fl_acs{/lang}" type="submit">
			</form>
			{/if}
		{else}
		&nbsp;-&nbsp;
		{/if}
		</td>
		</tr>
		{foreachelse}
		<tr>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
		</tr>
		{/foreach}
        {if $maxFleetSlots == $activeFleetSlots}
		<tr><td colspan="9">{lang}fl_no_more_slots{/lang}</td></tr>
		{/if}
	</table>
	{if isset($acsName)}
	{include file="fleetACS_table.tpl"}
	{/if}
	<form action="?page=fleet1" method="POST">
	<input type="hidden" name="galaxy" value="{$targetGalaxy}">
	<input type="hidden" name="system" value="{$targetSystem}">
	<input type="hidden" name="planet" value="{$targetPlanet}">
	<input type="hidden" name="type" value="{$targetType}">
	<input type="hidden" name="mission" value="{$targetMission}">
	<table class="table519">
		<tr>
			<th colspan="4">{lang}fl_new_mission_title{/lang}</th>
		</tr>
		<tr style="height:20px;">
			<td>{lang}fl_ship_type{/lang}</td>
			<td>{lang}fl_ship_available{/lang}</td>
			<td>-</td>
			<td>-</td>
		</tr>
		{foreach name=Fleets item=FleetRow from=$FleetsOnPlanet}
		<tr style="height:20px;">
			<td>{if $FleetRow.speed != 0} <a title="{lang}fl_speed_title{/lang} {$FleetRow.speed}">{lang}tech.{$FleetRow.id}{/lang}</a>{else}{lang}tech.{$FleetRow.id}{/lang}{/if}</td>
			<td id="ship{$FleetRow.id}_value">{$FleetRow.count|number}</td>
			{if $FleetRow.speed != 0}
			<td><a href="javascript:maxShip('ship{$FleetRow.id}');">{lang}fl_max{/lang}</a></td>
			<td><input name="ship{$FleetRow.id}" id="ship{$FleetRow.id}_input" size="10" value="0"></td>
			{else}
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			{/if}
		</tr>
		{/foreach}
		<tr style="height:20px;">
		{if $smarty.foreach.Fleets.total == 0}
		<td colspan="4">{lang}fl_no_ships{/lang}</td>
		{else}
		<td colspan="2"><a href="javascript:noShips();">{lang}fl_remove_all_ships{/lang}</a></td>
		<td colspan="2"><a href="javascript:maxShips();">{lang}fl_select_all_ships{/lang}</a></td>
		{/if}
		</tr>
        {if $maxFleetSlots != $activeFleetSlots}
		<tr style="height:20px;"><td colspan="4"><input type="submit" value="{lang}fl_continue{/lang}"></td>
		{/if}
	</table>	
	</form>
	<br>
	<table style="min-width:519px;width:519px;">
		<tr><th colspan="3">{lang}fl_bonus{/lang}</th></tr>
		<tr><th style="width:33%">{lang}fl_bonus_attack{/lang}</th><th style="width:33%">{lang}fl_bonus_defensive{/lang}</th><th style="width:33%">{lang}fl_bonus_shield{/lang}</th></tr>
		<tr><td>+{$bonusAttack} %</td><td>+{$bonusDefensive} %</td><td>+{$bonusShield} %</td></tr>
		<tr><th style="width:33%">{lang}tech.115{/lang}</th><th style="width:33%">{lang}tech.117{/lang}</th><th style="width:33%">{lang}tech.118{/lang}</th></tr>
		<tr><td>+{$bonusCombustion} %</td><td>+{$bonusImpulse} %</td><td>+{$bonusHyperspace} %</td></tr>
	</table>
</div>
{if isset($smarty.get.code)}
<script type="text/javascript">
var error = "{lang}fl_send_error.{$smarty.get.code}{/lang}
if(error != "") alert(error);
</script>
{/if}
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}