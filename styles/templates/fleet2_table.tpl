{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<form action="game.php?page=fleet3" method="post">
<input type="hidden" name="token" value="{$token}">
<div id="content">
   	<table class="table519">
        <tr>
        	<th colspan="2">{$galaxy}:{$system}:{$planet} - {lang}type_planet.{$type}{/lang}</th>
        </tr>
		<tr>
			<th>{lang}fl_mission{/lang}</th>
        	<th>{lang}fl_resources{/lang}</th>
        </tr>
		<tr class="left top">
			<td style="width:50%;margin:0;padding:0;">
        		<table border="0" cellpadding="0" cellspacing="0" width="259" style="margin:0;padding:0;">
        			{foreach $MissionSelector as $MissionID} 
					<tr style="height:20px;">
						<td class="transparent left">
						<input id="radio_{$MissionID}" type="radio" name="mission" value="{$MissionID}" {if $mission == $MissionID}checked="checked"{/if} style="width:60px;"><label for="radio_{$MissionID}">{lang}type_mission.{$MissionID}{/lang}</label><br>
							{if $MissionID == 15}<br><div style="color:red;padding-left:13px;">{lang}fl_expedition_alert_message{/lang}</div><br>{/if}
							{if $MissionID == 11}<br><div style="color:red;padding-left:13px;">{lang}fl_dm_alert_message{/lang}</div><br>{/if}
						</td>
					</tr>
					{/foreach}
        		</table>
        	</td>
        	<td class="top">
				<table border="0" cellpadding="0" cellspacing="0" width="259">
                    <tr style="height:20px;">
        				<td class="transparent">{lang}tech.901{/lang}</td>
        				<td class="transparent"><a href="javascript:maxResource('metal');">{lang}fl_max{/lang}</a></th>
        				<td class="transparent"><input name="metal" size="10" onchange="calculateTransportCapacity();" type="text"></td>
        			</tr>
                    <tr style="height:20px;">
        				<td class="transparent">{lang}tech.902{/lang}</td>
        				<td class="transparent"><a href="javascript:maxResource('crystal');">{lang}fl_max{/lang}</a></th>
        				<td class="transparent"><input name="crystal" size="10" onchange="calculateTransportCapacity();" type="text"></td>
        			</tr>
                    <tr style="height:20px;">
        				<td class="transparent">{lang}tech.903{/lang}</td>
        				<td class="transparent"><a href="javascript:maxResource('deuterium');">{lang}fl_max{/lang}</a></td>
        				<td class="transparent"><input name="deuterium" size="10" onchange="calculateTransportCapacity();" type="text"></td>
        			</tr>
                    <tr style="height:20px;">
        				<td class="transparent">{lang}fl_resources_left{/lang}</td>
        				<td class="transparent" colspan="2" id="remainingresources">-</td>
        			</tr>
                    <tr style="height:20px;">
        				<td class="transparent" colspan="3"><a href="javascript:maxResources()">{lang}fl_all_resources{/lang}</a></td>
        			</tr>
                    <tr style="height:20px;">
        				<td class="transparent" colspan="3">{lang}fl_fuel_consumption{/lang}: <span id="consumption" class="consumption">{$consumption}</span></td>
        			</tr>
					{if $StaySelector}
					<tr style="height:20px;">
						<th class="transparent" colspan="3">{lang}fl_hold_time{/lang}</th>
					</tr>
					<tr style="height:20px;">
						<td class="transparent" colspan="3">
						{html_options name=staytime options=$StaySelector} {lang}fl_hours{/lang}
						</td>
					</tr>
					{/if}
				</table>
			</td>
		</tr>
        <tr style="height:20px;">
        	<td colspan="2"><input value="{lang}fl_continue{/lang}" type="submit"></input></td>
        </tr>
    </table>
</div>
</form>
<script type="text/javascript">
data	= {$fleetdata|json};
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}