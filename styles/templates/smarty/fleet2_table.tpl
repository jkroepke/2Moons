{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<form action="game.php?page=fleet3" method="post" onsubmit='this.submit.disabled = true;'>
<input type="hidden" name="galaxy"      	value="{$galaxy}">
<input type="hidden" name="system"      	value="{$system}">
<input type="hidden" name="planet"      	value="{$planet}">
<input type="hidden" name="planettype"     	value="{$planettype}">
<input type="hidden" name="speed"          	value="{$speed}">
<input type="hidden" name="usedfleet"      	value="{$usedfleet}">
<input type="hidden" name="fleetroom" 	   	value="{$fleetroom}">
<input type="hidden" name="fleet_group"    	value="{$fleet_group}">
<input type="hidden" name="acs_target_mr"  	value="{$acs_target_mr}">
<input type="hidden" name="consumption"    	value="{$consumption}">
<input type="hidden" name="speedallsmin"   	value="{$speedallsmin}">
<input type="hidden" name="thisgalaxy"     	value="{$thisgalaxy}">
<input type="hidden" name="thissystem"     	value="{$thissystem}">
<input type="hidden" name="thisplanet"     	value="{$thisplanet}">
<input type="hidden" name="speedfactor" 	value="{$speedfactor}">
<input type="hidden" name="thisresource1"   value="{$metal}">
<input type="hidden" name="thisresource2"   value="{$crystal}">
<input type="hidden" name="thisresource3" 	value="{$deuterium}">
<br>
<div id="content">
    <table border="0" cellpadding="0" cellspacing="1" width="519" align="center">
        <tr align="left" style="height:20px;">
        	<td class="c" colspan="2">{$thisgalaxy}:{$thissystem}:{$thisplanet} - {if $thisplanet_type == 3}{$fl_moon}{else}{$fl_planet}{/if}</td>
        </tr>
		<tr align="left" valign="top">
			<th width="50%">
        		<table border="0" cellpadding="0" cellspacing="0" width="259">
        			<tr style="height:20px;">
        				<td class="c" colspan="2">{$fl_mission}</td>
        			</tr>
        			{foreach item=MissionName key=MissionID from=$MissionSelector}
					<tr style="height:20px;">
						<th>
						<input id="radio_{$MissionID}" type="radio" name="mission" value="{$MissionID}" {if $mission == $MissionID}checked="checked"{/if}><label for="radio_{$MissionID}">{$MissionName}</label><br>
							{if $MissionID == 15}<br><p style="color:red;padding-left:13px;">{$fl_expedition_alert_message}"</p><br></th>{/if}
							{if $MissionID == 11}<br><p style="color:red;padding-left:13px;">{$fl_dm_alert_message}</p><br></th>{/if}
					</tr>
					{/foreach}
        		</table>
        	</th>
        	<th style="vertical-align:top;">
				<table border="0" cellpadding="0" cellspacing="0" width="259">
        			<tr style="height:20px">
        				<td colspan="3" class="c">{$fl_resources}</td>
        			</tr>
                    <tr style="height:20px;">
        				<th>{$Metal}</th>
        				<th><a href="javascript:maxResource('1');">{$fl_max}</a></th>
        				<th><input name="resource1" size="10" onchange="calculateTransportCapacity();" type="text"></th>
        			</tr>
                    <tr style="height:20px;">
        				<th>{$Crystal}</th>
        				<th><a href="javascript:maxResource('2');">{$fl_max}</a></th>
        				<th><input name="resource2" size="10" onchange="calculateTransportCapacity();" type="text"></th>
        			</tr>
                    <tr style="height:20px;">
        				<th>{$Deuterium}</th>
        				<th><a href="javascript:maxResource('3');">{$fl_max}</a></th>
        				<th><input name="resource3" size="10" onchange="calculateTransportCapacity();" type="text"></th>
        			</tr>
                    <tr style="height:20px;">
        				<th>{$fl_resources_left}</th>
        				<th colspan="2"><div id="remainingresources">-</div></th>
        			</tr>
                    <tr style="height:20px;">
        				<th colspan="3"><a href="javascript:maxResources()">{$fl_all_resources}</a></th>
        			</tr>
                    <tr style="height:20px;">
        				<th colspan="3">{$fl_fuel_consumption}: {$consumption}</th>
        			</tr>
					{if $StaySelector}
					<tr style="height:20px;">
						<td class="c" colspan="3">{$fl_hold_time}</td>
					</tr>
					<tr style="height:20px;">
						<th colspan="3">
						{html_options name=holdingtime options=$StaySelector} {$fl_hours}
						</th>
					</tr>
					{/if}
				</table>
			</th>
		</tr>
        <tr style="height:20px;">
        	<th colspan="2"><input value="{$fl_continue}" type="submit"></th>
        </tr>
    </table>
</div>
</form>
<script type="text/javascript">calculateTransportCapacity();</script>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}