{block name="title" prepend}{$LNG.lm_fleet}{/block}
{block name="content"}
<form action="game.php?page=fleetStep3" method="post">
<input type="hidden" name="token" value="{$token}">
   	<table class="table519">
        <tr>
        	<th colspan="2">{$galaxy}:{$system}:{$planet} - {$LNG.type_planet.{$type}}</th>
        </tr>
		<tr>
			<th>{$LNG.fl_mission}</th>
        	<th>{$LNG.fl_resources}</th>
        </tr>
		<tr>
			<td class="left top" style="width:50%;margin:0;padding:0;"{if $StaySelector} rowspan="3"{/if}>
        		<table border="0" cellpadding="0" cellspacing="0" width="259" style="margin:0;padding:0;">
        			{foreach $MissionSelector as $MissionID} 
					<tr style="height:20px;">
						<td class="transparent left">
						<input id="radio_{$MissionID}" type="radio" name="mission" value="{$MissionID}" {if $mission == $MissionID}checked="checked"{/if} style="width:60px;"><label for="radio_{$MissionID}">{$LNG.type_mission.{$MissionID}}</label><br>
							{if $MissionID == 15}<br><div style="color:red;padding-left:13px;">{$LNG.fl_expedition_alert_message}</div><br>{/if}
							{if $MissionID == 11}<br><div style="color:red;padding-left:13px;">{$LNG.fl_dm_alert_message}</div><br>{/if}
						</td>
					</tr>
					{/foreach}
        		</table>
        	</td>
        	<td class="top">
				<table border="0" cellpadding="0" cellspacing="0" width="259">
                    <tr style="height:20px;">
        				<td class="transparent">{$LNG.tech.901}</td>
        				<td class="transparent"><a href="javascript:maxResource('metal');">{$LNG.fl_max}</a></th>
        				<td class="transparent"><input name="metal" size="10" onchange="calculateTransportCapacity();" type="text"></td>
        			</tr>
                    <tr style="height:20px;">
        				<td class="transparent">{$LNG.tech.902}</td>
        				<td class="transparent"><a href="javascript:maxResource('crystal');">{$LNG.fl_max}</a></th>
        				<td class="transparent"><input name="crystal" size="10" onchange="calculateTransportCapacity();" type="text"></td>
        			</tr>
                    <tr style="height:20px;">
        				<td class="transparent">{$LNG.tech.903}</td>
        				<td class="transparent"><a href="javascript:maxResource('deuterium');">{$LNG.fl_max}</a></td>
        				<td class="transparent"><input name="deuterium" size="10" onchange="calculateTransportCapacity();" type="text"></td>
        			</tr>
                    <tr style="height:20px;">
        				<td class="transparent">{$LNG.fl_resources_left}</td>
        				<td class="transparent" colspan="2" id="remainingresources">-</td>
        			</tr>
                    <tr style="height:20px;">
        				<td class="transparent" colspan="3"><a href="javascript:maxResources()">{$LNG.fl_all_resources}</a></td>
        			</tr>
                    <tr style="height:20px;">
        				<td class="transparent" colspan="3">{$LNG.fl_fuel_consumption}: <span id="consumption" class="consumption">{$consumption}</span></td>
        			</tr>
				</table>
			</td>
		</tr>
		{if $StaySelector}
		<tr style="height:20px;">
			<th>{$LNG.fl_hold_time}</th>
		</tr>
		<tr style="height:20px;">
			<td>
			{html_options name=staytime options=$StaySelector} {$LNG.fl_hours}
			</td>
		</tr>
		{/if}
        <tr style="height:20px;">
        	<td colspan="2"><input value="{$LNG.fl_continue}" type="submit"></input></td>
        </tr>
    </table>
</form>
<script type="text/javascript">
data	= {$fleetdata|json};
</script>
{/block}