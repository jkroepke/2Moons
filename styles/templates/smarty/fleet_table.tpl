{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content">
    <table width="519" border="0" cellpadding="0" cellspacing="1" align="center">
        <tr>
        	<td colspan="9" class="c">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
				<td style="text-align:left;">{$fl_fleets} {$flyingfleets} / {$maxfleets}</td>
				<td style="text-align:right;">{$currentexpeditions} / {$maxexpeditions} {$fl_expeditions}</td>
				</tr>
				</table>
        	</td>
        </tr>
        <tr>
            <th>{$fl_number}</th>
            <th>{$fl_mission}</th>
            <th>{$fl_ammount}</th>
            <th>{$fl_beginning}</th>
            <th>{$fl_departure}</th>
            <th>{$fl_destiny}</th>
            <th>{$fl_objective}</th>
            <th>{$fl_arrival}</th>
            <th>{$fl_order}</th>
        </tr>
        {foreach name=FlyingFleets item=FlyingFleetRow from=$FlyingFleetList}
		<tr>
		<th>{$smarty.foreach.FlyingFleets.iteration}</th>
		<th>
		<a>{$FlyingFleetRow.missionname}</a>
		{if $FlyingFleetRow.way == 1}
			<br><a title="{$fl_returning}">{$fl_r}</a>
		{else}
			<br><a title="{$fl_onway}">{$fl_a}</a>
		{/if}
		</th>
		<th><a href="#" onmouseover="return overlib('<table width=100% cellpadding=2 cellspacing=0><tr><td class=c colspan=2 style=text-align:center;>{$fl_info_detail}</td></tr>{foreach key=name item=count from=$FlyingFleetRow.FleetList}<tr><td>{$name}:</td><td>{$count}</td></tr>{/foreach}</table>', MOUSEOFF, DELAY, 50, CENTER, OFFSETX, 0, OFFSETY, -40, WIDTH, 265);" onmouseout="return nd();">{$FlyingFleetRow.amount}</a></th>
		<th><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$FlyingFleetRow.start_galaxy}&amp;system={$FlyingFleetRow.start_system}">[{$FlyingFleetRow.start_galaxy}:{$FlyingFleetRow.start_system}:{$FlyingFleetRow.start_planet}]</a></th>
		<th>{$FlyingFleetRow.start_time}</th>
		<th><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$FlyingFleetRow.end_galaxy}&amp;system={$FlyingFleetRow.end_system}">[{$FlyingFleetRow.end_galaxy}:{$FlyingFleetRow.end_system}:{$FlyingFleetRow.end_planet}]</a></th>
		<th>{$FlyingFleetRow.end_time}</th>
		<th><font color="lime">{$FlyingFleetRow.backin}</font></th>
		<th>
		{if $FlyingFleetRow.way == 0}
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
		</th>
		</tr>
		{foreachelse}
		<tr>
		<th>-</th>
		<th>-</th>
		<th>-</th>
		<th>-</th>
		<th>-</th>
		<th>-</th>
		<th>-</th>
		<th>-</th>
		<th>-</th>
		</tr>
		{/foreach}
        {if !$slots_available}
		<tr><th colspan="9"><font color="red">{$fl_no_more_slots}</font></th></tr>
		{/if}
        </table>
		{$AKSPage}
        <form action="?page=fleet1" method="POST">
		<input type="hidden" name="galaxy" value="{$galaxy}">
        <input type="hidden" name="system" value="{$system}">
        <input type="hidden" name="planet" value="{$planet}">
        <input type="hidden" name="planet_type" value="{$planettype}">
        <input type="hidden" name="mission" value="{$target_mission}">
        <input type="hidden" name="maxepedition" value="{$envoimaxexpedition}">
        <input type="hidden" name="curepedition" value="{$expeditionencours}">
        <input type="hidden" name="target_mission" value="{$target_mission}">
        <table width="519" border="0" cellpadding="0" cellspacing="1" align="center">
            <tr>
            	<td colspan="4" class="c">{$fl_new_mission_title}</td>
            </tr>
            <tr style="height:20px;">
                <th>{$fl_ship_type}</th>
                <th>{$fl_ship_available}</th>
                <th>-</th>
                <th>-</th>
            </tr>
           	{foreach name=Fleets item=FleetRow from=$FleetsOnPlanet}
			<tr style="height:20px;">
				<th>{if $FleetRow.id != 212} <a title="{$fl_speed_title} {$FleetRow.speed}">{$FleetRow.name}</a>{else}{$FleetRow.name}{/if}</th>
				<th id="ship{$FleetRow.id}_value">{$FleetRow.count}</th>
				{if $FleetRow.id != 212}
				<th><a href="javascript:maxShip('ship{$FleetRow.id}');shortInfo();">{$fl_max}</a></th>
				<th><input name="ship{$FleetRow.id}" id="ship{$FleetRow.id}_input" size="10" value="0"></th>
				{else}
				<th>&nbsp;</th><th>&nbsp;</th>
				{/if}
			</tr>
			{/foreach}
			<tr style="height:20px;">
			{if $smarty.foreach.Fleets.total == 0}
			<th colspan="4">{$fl_no_ships}</th>
			{else}
			<th colspan="2"><a href="javascript:noShips();shortInfo();noResources();">{$fl_remove_all_ships}</a></th>
			<th colspan="2"><a href="javascript:maxShips();shortInfo();">{$fl_select_all_ships}</a></th>
			{/if}
			</tr>
			{if $slots_available}
			<tr style="height:20px;"><th colspan="4"><input type="submit" value="{$fl_continue}"></th>
			{/if}
    	</table>	
        </form>
</div>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}