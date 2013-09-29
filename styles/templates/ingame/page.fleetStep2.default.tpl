{block name="title" prepend}{$LNG.lm_fleet}{/block}
{block name="content"}
<form action="game.php?page=fleetStep3" method="post">
<input type="hidden" name="token" value="{$token}">
   	<table class="table519">
        <tr>
        	<th colspan="2">{$ownPlanet.galaxy}:{$ownPlanet.system}:{$ownPlanet.planet} - {$LNG.type_planet[$ownPlanet.type]}</th>
        </tr>
		<tr>
			<th>{$LNG.fl_mission}</th>
        	<th>{$LNG.fl_resources}</th>
        </tr>
		<tr>
			<td class="left top" style="width:50%;margin:0;padding:0;"{if $StaySelector} rowspan="3"{/if}>
        		<table border="0" cellpadding="0" cellspacing="0" width="259" style="margin:0;padding:0;">
        			{foreach $availableMissions as $MissionID}
					<tr style="height:20px;">
						<td class="transparent left">
						<input id="radio_{$MissionID}" type="radio" name="targetMission" value="{$MissionID}" {if $targetMission == $MissionID}checked="checked"{/if} style="width:60px;"><label for="radio_{$MissionID}">{$LNG.type_mission.{$MissionID}}</label><br>
							{if $MissionID == 15}<br><div style="color:red;padding-left:13px;">{$LNG.fl_expedition_alert_message}</div><br>{/if}
							{if $MissionID == 11}<br><div style="color:red;padding-left:13px;">{$LNG.fl_dm_alert_message}</div><br>{/if}
						</td>
					</tr>
					{/foreach}
        		</table>
        	</td>
        	<td class="top">
				<table border="0" cellpadding="0" cellspacing="0" width="259">
					{foreach $resourceElementIds as $elementId}
                    <tr style="height:20px;">
        				<td class="transparent"><label for="resource_{$elementId}">{$LNG.tech.$elementId}</label></td>
        				<td class="transparent"><a class="maxButton jsLink" data-resource-id="{$elementId}">{$LNG.fl_max}</a></td>
        				<td class="transparent"><input data-resource-id="{$elementId}" id="resource_{$elementId}" name="transportResource[{$elementId}]" size="10" type="text" class="fleetTransportResourceInput"></td>
        			</tr>
					{/foreach}
                    <tr style="height:20px;">
        				<td class="transparent">{$LNG.fl_resources_left}</td>
        				<td class="transparent" colspan="2" id="remainingResources">-</td>
        			</tr>
                    <tr style="height:20px;">
        				<td class="transparent" colspan="3"><a class="maxAllButton jsLink">{$LNG.fl_all_resources}</a></td>
        			</tr>
                    <tr style="height:20px;">
        				<td class="transparent" colspan="3">{$LNG.fl_fuel_consumption}: <span id="consumption" class="consumption">{$fleetData.consumption|number}</span></td>
        			</tr>
				</table>
			</td>
		</tr>
		{if $StaySelector}
		<tr style="height:20px;">
			<th><label for="holdTime">{$LNG.fl_hold_time}</label></th>
		</tr>
		<tr style="height:20px;">
			<td>
			{html_options name=holdTime id=holdTime options=$StaySelector} {$LNG.fl_hours}
			</td>
		</tr>
		{/if}
        <tr style="height:20px;">
        	<td colspan="2"><input value="{$LNG.fl_continue}" type="submit"></td>
        </tr>
    </table>
</form>
<script type="text/javascript">
data	= {$fleetData|json};
</script>
{/block}