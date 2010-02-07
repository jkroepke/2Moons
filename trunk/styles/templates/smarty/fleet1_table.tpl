{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<form action="game.php?page=fleet2" method="post" onsubmit='this.submit.disabled = true;'>
    <input type="hidden" name="speedallsmin"   	value="{$speedallsmin}">
    <input type="hidden" name="usedfleet"      	value="{$fleetarray}">
    <input type="hidden" name="thisgalaxy"     	value="{$galaxy}">
    <input type="hidden" name="thissystem"     	value="{$system}">
    <input type="hidden" name="thisplanet"     	value="{$planet}">
    <input type="hidden" name="thisplanettype" 	value="{$planet_type}">
    <input type="hidden" name="fleetroom" 		value="{$fleetroom}">
    <input type="hidden" name="target_mission" 	value="{$target_mission}">
    <input type="hidden" name="speedfactor" 	value="{$speedfactor}">
    {$inputs}
    <div id="content">
    	<table width="519" border="0" cellpadding="0" cellspacing="1" align="center">
        	<tr style="height:20px;">
        		<td colspan="2" class="c">{$fl_send_fleet}</td>
        	</tr>
            <tr style="height:20px;">
            	<th width="50%">{$fl_destiny}</th>
            	<th>
                    <input name="galaxy" size="3" maxlength="2" onChange="shortInfo()" onKeyUp="shortInfo()" value="{$galaxy_post}">
                    <input name="system" size="3" maxlength="3" onChange="shortInfo()" onKeyUp="shortInfo()" value="{$system_post}">
                    <input name="planet" size="3" maxlength="2" onChange="shortInfo()" onKeyUp="shortInfo()" value="{$planet_post}">
                    <select name="planettype" onChange="shortInfo()" onKeyUp="shortInfo()">
                    {html_options options=$options_selector selected=$options}
                    </select>
                    <input name="fleet_group" type="hidden" onChange="shortInfo()" onKeyUp="shortInfo()" value="0">
                    <input name="acs_target_mr" type="hidden" onChange="shortInfo()" onKeyUp="shortInfo()" value="0:0:0">
            	</th>
            </tr>
            <tr style="height:20px;">
            	<th>{$fl_fleet_speed}</th>
            	<th>
                <select name="speed" onChange="shortInfo()" onKeyUp="shortInfo()">
                    {html_options options=$AvailableSpeeds}
                </select> %
                </th>
            </tr>
            <tr style="height:20px;">
            	<th>{$fl_distance}</th>
            	<th><div id="distance">-</div></th>
            </tr>
            <tr style="height:20px;">
            	<th>{$fl_flying_time}</th>
            	<th><div id="duration">-</div></th>
            </tr>
            <tr style="height:20px;">
                <th>{$fl_fuel_consumption}</th>
                <th><div id="consumption">-</div></th>
            </tr>
            <tr style="height:20px;">
                <th>{$fl_max_speed}</th>
                <th><div id="maxspeed">-</div></th>
            </tr>
            <tr style="height:20px;">
                <th>{$fl_cargo_capacity}</th>
                <th><div id="storage">-</div></th>
            </tr>
            <tr style="height:20px;">
                <td colspan="2" class="c">{$fl_shortcut} <a href="game.php?page=shortcuts">{$fl_shortcut_add_edit}</a></td>
            </tr>
            {$shortcut}
            <tr style="height:20px;">
            	<td colspan="2" class="c">{$fl_my_planets}</td>
            </tr>
			{foreach name=ColonyList item=ColonyRow from=$colonylist}
			{if $smarty.foreach.ColonyList.iteration is odd}<tr style="height:20px;">{/if}
            <th><a href="javascript:setTarget({$ColonyRow.galaxy},{$ColonyRow.system},{$ColonyRow.planet},{$ColonyRow.planet_type});shortInfo();">{$ColonyRow.name} [{$ColonyRow.galaxy}:{$ColonyRow.system}:{$ColonyRow.planet}]</a></th>
			{if $smarty.foreach.ColonyList.last && $smarty.foreach.ColonyList.total is odd}<th>&nbsp;</th>{/if}
			{if $smarty.foreach.ColonyList.iteration is even}</tr>{/if}
			{foreachelse}
			<tr><th colspan="2">{$fl_no_colony}</th></tr>
			{/foreach}
			{if $AKSList}
            <tr style="height:20px;">
                <td colspan="2" class="c">{$fl_acs_title}</td>
            </tr>
            {foreach item=AKSRow from=$AKSList}
			<tr style="height:20px;"><th colspan="2">
			<a href="javascript:setTarget({$AKSRow.galaxy},{$AKSRow.system},{$AKSRow.planet},{$AKSRow.planet_type});shortInfo();setACS({$AKSRow.id});setACS_target('g{$AKSRow.galaxy}s{$AKSRow.system}p{$AKSRow.planet}t{$AKSRow.planet_type}');">{$AKSRow.name} - [{$AKSRow.galaxy}:{$AKSRow.system}:{$AKSRow.planet}]</a>
			</th></tr>
			{/foreach}
			{/if}
            <tr style="height:20px;">
            	<th colspan="2"><input type="submit" value="{$fl_continue}"></th>
            </tr>
        </table>
    </div>
</form>
<script type="text/javascript">javascript:shortInfo();</script>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}