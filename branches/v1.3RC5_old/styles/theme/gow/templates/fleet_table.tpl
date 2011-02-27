{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table>
        <tr>
        	<th colspan="9">
                <div class="transparent" style="text-align:left;float:left;">{$fl_fleets} {$flyingfleets} / {$maxfleets}</div>
				<div class="transparent" style="text-align:right;">{$currentexpeditions} / {$maxexpeditions} {$fl_expeditions}</div>
        	</th>
        </tr>
        <tr>
            <td>{$fl_number}</td>
            <td>{$fl_mission}</td>
            <td>{$fl_ammount}</td>
            <td>{$fl_beginning}</td>
            <td>{$fl_departure}</td>
            <td>{$fl_destiny}</td>
            <td>{$fl_objective}</td>
            <td>{$fl_arrival}</td>
            <td>{$fl_order}</td>
        </tr>
        {foreach name=FlyingFleets item=FlyingFleetRow from=$FlyingFleetList}
		<tr>
		<td>{$smarty.foreach.FlyingFleets.iteration}</td>
		<td>{$FlyingFleetRow.missionname}
		{if $FlyingFleetRow.way == 1}
			<br><a title="{$fl_returning}">{$fl_r}</a>
		{else}
			<br><a title="{$fl_onway}">{$fl_a}</a>
		{/if}
		</td>
		<td><a href="#" onmouseover="return overlib('<table width=\'100%\'><tr><th colspan=\'2\' style=\'text-align:center;\'>{$fl_info_detail}</th></tr>{foreach key=name item=count from=$FlyingFleetRow.FleetList}<tr><td class=\'transparent\'>{$name}:</td><td class=\'transparent\'>{$count}</td></tr>{/foreach}</table>', CENTER, WIDTH, 265);" onmouseout="return nd();">{$FlyingFleetRow.amount}</a></td>
		<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$FlyingFleetRow.start_galaxy}&amp;system={$FlyingFleetRow.start_system}">[{$FlyingFleetRow.start_galaxy}:{$FlyingFleetRow.start_system}:{$FlyingFleetRow.start_planet}]</a></td>
		<td>{$FlyingFleetRow.start_time}</td>
		<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$FlyingFleetRow.end_galaxy}&amp;system={$FlyingFleetRow.end_system}">[{$FlyingFleetRow.end_galaxy}:{$FlyingFleetRow.end_system}:{$FlyingFleetRow.end_planet}]</a></td>
		<td>{$FlyingFleetRow.end_time}</td>
		<td style="color:lime">{$FlyingFleetRow.backin}</td>
		<td>
		{if $FlyingFleetRow.way != 1}
			<form action="?page=fleet&amp;action=sendfleetback" method="post">
			<input name="fleetid" value="{$FlyingFleetRow.id}" type="hidden">
			<input value="{$fl_send_back}" type="submit">
			</form>
			{if $FlyingFleetRow.mission == 1}
			<form action="?page=fleet&amp;action=getakspage" method="post">
			<input name="fleetid" value="{$FlyingFleetRow.id}" type="hidden">
			<input value="{$fl_acs}" type="submit">
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
        {if !$slots_available}
		<tr><td colspan="9">{$fl_no_more_slots}</td></tr>
		{/if}
        </table>
		{if isset($aks_invited_mr)}
		{include file="fleetACS_table.tpl"}
		{/if}
        <form action="?page=fleet1" method="POST">
		<input type="hidden" name="galaxy" value="{$galaxy}">
        <input type="hidden" name="system" value="{$system}">
        <input type="hidden" name="planet" value="{$planet}">
        <input type="hidden" name="planet_type" value="{$planettype}">
        <input type="hidden" name="mission" value="{$target_mission}">
        <input type="hidden" name="maxepedition" value="{$envoimaxexpedition}">
        <input type="hidden" name="curepedition" value="{$expeditionencours}">
        <input type="hidden" name="target_mission" value="{$target_mission}">
        <table style="min-width:519px;width:519px;">
            <tr>
            	<th colspan="4">{$fl_new_mission_title}</th>
            </tr>
            <tr style="height:20px;">
                <td>{$fl_ship_type}</td>
                <td>{$fl_ship_available}</td>
                <td>-</td>
                <td>-</td>
            </tr>
           	{foreach name=Fleets item=FleetRow from=$FleetsOnPlanet}
			<tr style="height:20px;">
				<td>{if $FleetRow.speed != 0} <a title="{$fl_speed_title} {$FleetRow.speed}">{$FleetRow.name}</a>{else}{$FleetRow.name}{/if}</td>
				<td id="ship{$FleetRow.id}_value">{$FleetRow.count}</td>
				{if $FleetRow.speed != 0}
				<td><a href="javascript:maxShip('ship{$FleetRow.id}');">{$fl_max}</a></td>
				<td><input name="ship{$FleetRow.id}" id="ship{$FleetRow.id}_input" size="10" value="0"></td>
				{else}
				<td>&nbsp;</td><td>&nbsp;</td>
				{/if}
			</tr>
			{/foreach}
			<tr style="height:20px;">
			{if $smarty.foreach.Fleets.total == 0}
			<td colspan="4">{$fl_no_ships}</td>
			{else}
			<td colspan="2"><a href="javascript:noShips();">{$fl_remove_all_ships}</a></td>
			<td colspan="2"><a href="javascript:maxShips();">{$fl_select_all_ships}</a></td>
			{/if}
			</tr>
			{if $slots_available}
			<tr style="height:20px;"><td colspan="4"><input type="submit" value="{$fl_continue}"></td>
			{/if}
    	</table>	
        </form>
		
		<br>
		<table style="min-width:519px;width:519px;">
		<tr><th colspan="3">{$fl_bonus}</th></tr>
		<tr><th style="width:33%">{$fl_bonus_attack}</th><th style="width:33%">{$fl_bonus_defensive}</th><th style="width:33%">{$fl_bonus_shield}</th></tr>
		<tr><td>+{$bonus_attack} %</td><td>+{$bonus_defensive} %</td><td>+{$bonus_shield} %</td></tr>
		<tr><th style="width:33%">{$bonus_comp}</th><th style="width:33%">{$bonus_impul}</th><th style="width:33%">{$bonus_hyper}</th></tr>
		<tr><td>+{$bonus_combustion} %</td><td>+{$bonus_impulse} %</td><td>+{$bonus_hyperspace} %</td></tr>
		</table>
</div>
{if isset($smarty.get.alert)}
<script type="text/javascript">
alert(unescape("{$smarty.get.alert}"));
</script>
{/if}
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}