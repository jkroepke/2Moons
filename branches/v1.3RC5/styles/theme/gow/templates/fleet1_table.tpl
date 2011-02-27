{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<form action="game.php?page=fleet2" method="post" onsubmit="return CheckTarget()" id="form">
	<input type="hidden" name="fleet_group" value="0">
	<input type="hidden" name="mission" value="{$mission}">
	<input type="hidden" name="usedfleet" value="{$fleetarray}">
    <div id="content" class="content">
    	<table class="table519">
        	<tr style="height:20px;">
        		<th colspan="2">{$fl_send_fleet}</th>
        	</tr>
            <tr style="height:20px;">
            	<td style="width:50%">{$fl_destiny}</td>
            	<td>
                    <input name="galaxy" size="3" maxlength="2" onChange="updateVars()" onKeyUp="updateVars()" value="{$galaxy_post}">
                    <input name="system" size="3" maxlength="3" onChange="updateVars()" onKeyUp="updateVars()" value="{$system_post}">
                    <input name="planet" size="3" maxlength="2" onChange="updateVars()" onKeyUp="updateVars()" value="{$planet_post}">
                    <select name="planettype" onChange="updateVars()" onKeyUp="updateVars()">
                    {html_options options=$options_selector selected=$options}
                    </select>
            	</td>
            </tr>
            <tr style="height:20px;">
            	<td>{$fl_fleet_speed}</td>
            	<td>
                <select name="speed" onChange="updateVars()" onKeyUp="updateVars()">
                    {html_options options=$AvailableSpeeds}
                </select> %
                </td>
            </tr>
            <tr style="height:20px;">
            	<td>{$fl_distance}</td>
            	<td id="distance">-</td>
            </tr>
            <tr style="height:20px;">
            	<td>{$fl_flying_time}</th>
            	<td id="duration">-</td>
            </tr>
            <tr style="height:20px;">
            	<td>{$fl_flying_arrival}</th>
            	<td id="arrival">-</td>
            </tr>
            <tr style="height:20px;">
            	<td>{$fl_flying_return}</th>
            	<td id="return">-</td>
            </tr>
            <tr style="height:20px;">
                <td>{$fl_fuel_consumption}</td>
                <td id="consumption">-</td>
            </tr>
            <tr style="height:20px;">
                <td>{$fl_max_speed}</td>
                <td id="maxspeed">-</div></td>
            </tr>
            <tr style="height:20px;">
                <td>{$fl_cargo_capacity}</td>
                <td id="storage">-</td>
            </tr>
            <tr style="height:20px;">
                <th colspan="2">{$fl_shortcut} <a href="javascript:OpenPopup('game.php?page=shortcuts', 'short', 720, 300);">{$fl_shortcut_add_edit}</a></th>
            </tr>
			{if !CheckModule(40)}
            {foreach name=ShoutcutList item=ShoutcutRow from=$Shoutcutlist}
			{if $smarty.foreach.ShoutcutList.iteration is odd}<tr style="height:20px;">{/if}
            <td><a href="javascript:setTarget({$ShoutcutRow.galaxy},{$ShoutcutRow.system},{$ShoutcutRow.planet},{$ShoutcutRow.planet_type});updateVars();">{$ShoutcutRow.name}{if $ColonyRow.planet_type == 1}{$fl_planet_shortcut}{elseif $ColonyRow.planet_type == 2}{$fl_derbis_shortcut}{elseif $ShoutcutRow.planet_type == 3}{$fl_moon_shortcut}{/if} [{$ShoutcutRow.galaxy}:{$ShoutcutRow.system}:{$ShoutcutRow.planet}]</a></td>
			{if $smarty.foreach.ShoutcutList.last && $smarty.foreach.ShoutcutList.total is odd}<td>&nbsp;</td>{/if}
			{if $smarty.foreach.ShoutcutList.iteration is even}</tr>{/if}
			{foreachelse}
			<tr style="height:20px;">
				<td colspan="2">{$fl_no_shortcuts}</td>
			</tr>
            {/foreach}
			{/if}
			<tr style="height:20px;">
            	<th colspan="2">{$fl_my_planets}</th>
            </tr>
			{foreach name=ColonyList item=ColonyRow from=$Colonylist}
			{if $smarty.foreach.ColonyList.iteration is odd}<tr style="height:20px;">{/if}
            <td><a href="javascript:setTarget({$ColonyRow.galaxy},{$ColonyRow.system},{$ColonyRow.planet},{$ColonyRow.planet_type});updateVars();">{$ColonyRow.name} {if $ColonyRow.planet_type == 3}{$fl_moon_shortcut}{/if}[{$ColonyRow.galaxy}:{$ColonyRow.system}:{$ColonyRow.planet}]</a></td>
			{if $smarty.foreach.ColonyList.last && $smarty.foreach.ColonyList.total is odd}<td>&nbsp;</td>{/if}
			{if $smarty.foreach.ColonyList.iteration is even}</tr>{/if}
			{foreachelse}
			<tr style="height:20px;">
				<td colspan="2">{$fl_no_colony}</td>
			</tr>
			{/foreach}
			{if $AKSList}
            <tr style="height:20px;">
                <th colspan="2">{$fl_acs_title}</th>
            </tr>
            {foreach item=AKSRow from=$AKSList}
			<tr style="height:20px;"><td colspan="2">
				<a href="javascript:setACSTarget({$AKSRow.galaxy},{$AKSRow.system},{$AKSRow.planet},{$AKSRow.planet_type}, {$AKSRow.id});updateVars();">{$AKSRow.name} - [{$AKSRow.galaxy}:{$AKSRow.system}:{$AKSRow.planet}]</a>
			</td></tr>
			{/foreach}
			{/if}
            <tr style="height:20px;">
            	<td colspan="2"><input type="submit" value="{$fl_continue}"></td>
            </tr>
        </table>
    </div>
</form>
<script type="text/javascript">
data	= {$fleetdata};
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}