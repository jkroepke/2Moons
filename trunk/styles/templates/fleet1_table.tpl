{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<form action="game.php?page=fleet2" method="post" onsubmit="return CheckTarget()" id="form">
	<input type="hidden" name="fleet_group" value="0">
	<input type="hidden" name="mission" value="{$mission}">
	<input type="hidden" name="usedfleet" value="{$fleetarray}">
    <div id="content">
    	<table class="table519">
        	<tr style="height:20px;">
        		<th colspan="2">{lang}fl_send_fleet{/lang}</th>
        	</tr>
            <tr style="height:20px;">
            	<td style="width:50%">{lang}fl_destiny{/lang}</td>
            	<td>
                    <input type="text" name="galaxy" size="3" maxlength="2" onKeyUp="updateVars()" value="{$galaxy_post}">
                    <input type="text" name="system" size="3" maxlength="3" onKeyUp="updateVars()" value="{$system_post}">
                    <input type="text" name="planet" size="3" maxlength="2" onKeyUp="updateVars()" value="{$planet_post}">
                    <select name="planettype" onChange="updateVars()" onKeyUp="updateVars()">
                    {html_options options=$options_selector selected=$options}
                    </select>
            	</td>
            </tr>
            <tr style="height:20px;">
            	<td>{lang}fl_fleet_speed{/lang}</td>
            	<td>
                <select name="speed" onChange="updateVars()" onKeyUp="updateVars()">
                    {html_options options=$AvailableSpeeds}
                </select> %
                </td>
            </tr>
            <tr style="height:20px;">
            	<td>{lang}fl_distance{/lang}</td>
            	<td id="distance">-</td>
            </tr>
            <tr style="height:20px;">
            	<td>{lang}fl_flying_time{/lang}</th>
            	<td id="duration">-</td>
            </tr>
            <tr style="height:20px;">
            	<td>{lang}fl_flying_arrival{/lang}</th>
            	<td id="arrival">-</td>
            </tr>
            <tr style="height:20px;">
            	<td>{lang}fl_flying_return{/lang}</th>
            	<td id="return">-</td>
            </tr>
            <tr style="height:20px;">
                <td>{lang}fl_fuel_consumption{/lang}</td>
                <td id="consumption">-</td>
            </tr>
            <tr style="height:20px;">
                <td>{lang}fl_max_speed{/lang}</td>
                <td id="maxspeed">-</div></td>
            </tr>
            <tr style="height:20px;">
                <td>{lang}fl_cargo_capacity{/lang}</td>
                <td id="storage">-</td>
            </tr>
            <tr style="height:20px;">
                <th colspan="2">
					{lang}fl_shortcut{/lang} (<a href="#" onclick="EditShortcuts();return false" class="shoutcut-link">{lang}fl_shortcut_edition{/lang}</a><a href="#" onclick="SaveShortcuts();return false" class="shoutcut-edit">{lang}fl_shortcut_save{/lang}</a>)</th>
            </tr>
			{if !CheckModule(41)}
            {foreach name=ShoutcutList item=ShoutcutRow from=$Shoutcutlist}
			{if $smarty.foreach.ShoutcutList.iteration is odd}<tr style="height:20px;" class="shoutcut">{/if}
            <td>
				<div class="shoutcut-link">
					<a href="javascript:setTarget({$ShoutcutRow.galaxy},{$ShoutcutRow.system},{$ShoutcutRow.planet},{$ShoutcutRow.planet_type});updateVars();">{$ShoutcutRow.name}{if $ShoutcutRow.planet_type == 1}{lang}fl_planet_shortcut{/lang}{elseif $ShoutcutRow.planet_type == 2}{lang}fl_debris_shortcut{/lang}{elseif $ShoutcutRow.planet_type == 3}{lang}fl_moon_shortcut{/lang}{/if} [{$ShoutcutRow.galaxy}:{$ShoutcutRow.system}:{$ShoutcutRow.planet}]</a>
				</div>
				<div class="shoutcut-edit">
					<input type="text" class="shoutcut-input" name="shoutcut[{$smarty.foreach.ShoutcutList.index}][name]" value="{$ShoutcutRow.name}">
				</div>
				<div class="shoutcut-edit">
					<input type="text" class="shoutcut-input" name="shoutcut[{$smarty.foreach.ShoutcutList.index}][galaxy]" value="{$ShoutcutRow.galaxy}" size="3" maxlength="2">:<input type="text" class="shoutcut-input" name="shoutcut[{$smarty.foreach.ShoutcutList.index}][system]" value="{$ShoutcutRow.system}" size="3" maxlength="3">:<input type="text" class="shoutcut-input" name="shoutcut[{$smarty.foreach.ShoutcutList.index}][planet]" value="{$ShoutcutRow.planet}" size="3" maxlength="2">
					<select class="shoutcut-input" name="shoutcut[{$smarty.foreach.ShoutcutList.index}][type]">
						{html_options selected=$ShoutcutRow.planet_type options=$options_selector}
					</select>
				</div>
			</td>
			{if $smarty.foreach.ShoutcutList.last && $smarty.foreach.ShoutcutList.total is odd}<td>&nbsp;</td>{/if}
			{if $smarty.foreach.ShoutcutList.iteration is even}</tr>{/if}
			{foreachelse}
			<tr style="height:20px;" class="shoutcut-none">
				<td colspan="2">{lang}fl_no_shortcuts{/lang}</td>
			</tr>
            {/foreach}
			<tr style="height:20px;" class="shoutcut-edit shoutcut-new">
				<td colspan="2">
					<div class="shoutcut-link">
						
					</div>
					<div class="shoutcut-edit">
						<input type="text" class="shoutcut-input" name="shoutcut[][name]" value="" placeholder="Name">
					</div>
					<div class="shoutcut-edit">
						<input type="text" class="shoutcut-input" name="shoutcut[][galaxy]" value="" size="3" maxlength="2" placeholder="G">:<input type="text" class="shoutcut-input" name="shoutcut[][system]" value="" size="3" maxlength="3" placeholder="S">:<input type="text" class="shoutcut-input" name="shoutcut[][planet]" value="" size="3" maxlength="2" placeholder="P">
						<select class="shoutcut-input" name="shoutcut[][type]">
							{html_options options=$options_selector}
						</select>
					</div>
				</td>
			</tr>
			<tr style="height:20px;" class="shoutcut-edit">
				<td colspan="2">
					<a href="#" onclick="AddShortcuts();return false">{lang}fl_shortcut_add{/lang}</a>
				</td>
			</tr>
			{/if}
			<tr style="height:20px;">
            	<th colspan="2">{lang}fl_my_planets{/lang}</th>
            </tr>
			{foreach name=ColonyList item=ColonyRow from=$Colonylist}
			{if $smarty.foreach.ColonyList.iteration is odd}<tr style="height:20px;">{/if}
            <td>
				<a href="javascript:setTarget({$ColonyRow.galaxy},{$ColonyRow.system},{$ColonyRow.planet},{$ColonyRow.planet_type});updateVars();">{$ColonyRow.name} {if $ColonyRow.planet_type == 3}{lang}fl_moon_shortcut{/lang}{/if}[{$ColonyRow.galaxy}:{$ColonyRow.system}:{$ColonyRow.planet}]</a>
	
			</td>
			{if $smarty.foreach.ColonyList.last && $smarty.foreach.ColonyList.total is odd}<td>&nbsp;</td>{/if}
			{if $smarty.foreach.ColonyList.iteration is even}</tr>{/if}
			{foreachelse}
			<tr style="height:20px;">
				<td colspan="2">{lang}fl_no_colony{/lang}</td>
			</tr>
			{/foreach}
			{if $AKSList}
            <tr style="height:20px;">
                <th colspan="2">{lang}fl_acs_title{/lang}</th>
            </tr>
            {foreach item=AKSRow from=$AKSList}
			<tr style="height:20px;"><td colspan="2">
				<a href="javascript:setACSTarget({$AKSRow.galaxy},{$AKSRow.system},{$AKSRow.planet},{$AKSRow.planet_type}, {$AKSRow.id}, {$AKSRow.ankunft});">{$AKSRow.name} - [{$AKSRow.galaxy}:{$AKSRow.system}:{$AKSRow.planet}]</a>
			</td></tr>
			{/foreach}
			{/if}
            <tr style="height:20px;">
            	<td colspan="2"><input type="submit" value="{lang}fl_continue{/lang}"></td>
            </tr>
        </table>
    </div>
</form>
<script type="text/javascript">
data	= {$fleetdata};
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}