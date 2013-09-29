{block name="title" prepend}{$LNG.lm_fleet}{/block}
{block name="content"}
<form action="game.php?page=fleetStep2" method="post" id="form">
	<input type="hidden" name="token" value="{$token}">
	<input type="hidden" name="fleetGroup" value="0">
	<input type="hidden" name="targetMission" value="{$mission}">
	<table class="table519" style="table-layout: fixed;">
		<tr style="height:20px;">
			<th colspan="2">{$LNG.fl_send_fleet}</th>
		</tr>
		<tr style="height:20px;">
			<td style="width:50%">{$LNG.fl_destiny}</td>
			<td>
				<input class="updateOnChange" type="text" id="targetGalaxy" name="targetGalaxy" size="3" maxlength="2" value="{$target.galaxy}">
				<input class="updateOnChange" type="text" id="targetSystem" name="targetSystem" size="3" maxlength="3" value="{$target.system}">
				<input class="updateOnChange" type="text" id="targetPlanet" name="targetPlanet" size="3" maxlength="2" value="{$target.planet}">
				{html_options options=$typeSelect selected=$target.type id="targetType" name="targetType" class="updateOnChange"}
			</td>
		</tr>
		<tr style="height:20px;">
			<td>{$LNG.fl_fleet_speed}</td>
			<td>{html_options values=$speedSelect output=$speedSelect id=fleetSpeed name=fleetSpeed class=updateOnChange}%</td>
		</tr>
		<tr style="height:20px;">
			<td>{$LNG.fl_distance}</td>
			<td id="distance">-</td>
		</tr>
		<tr style="height:20px;">
			<td>{$LNG.fl_flying_time}</td>
			<td id="duration">-</td>
		</tr>
		<tr style="height:20px;">
			<td>{$LNG.fl_flying_arrival}</td>
			<td id="arrival">-</td>
		</tr>
		<tr style="height:20px;">
			<td>{$LNG.fl_flying_return}</td>
			<td id="return">-</td>
		</tr>
		{foreach $missionData.data.consumption as $elementConsumptionId => $amount}
			<tr style="height:20px;">
				<td>{$LNG.fl_fuel_consumption} - {$LNG.tech.$elementConsumptionId}</td>
				<td id="consumption_{$elementConsumptionId}">{$amount}</td>
			</tr>
		{/foreach}
		<tr style="height:20px;">
			<td>{$LNG.fl_max_speed}</td>
			<td id="maxspeed">-</td>
		</tr>
		<tr style="height:20px;">
			<td>{$LNG.fl_cargo_capacity}</td>
			<td id="storage">-</td>
		</tr>
	</table>
	{if isModulAvalible($smarty.const.MODULE_SHORTCUTS)}
	<table class="table519 shortcut" style="table-layout: fixed;">
		<tr style="height:20px;">
			<th colspan="{$themeSettings.SHORTCUT_ROWS_ON_FLEET1}">{$LNG.fl_shortcut} (<a href="#" onclick="EditShortcuts();return false" class="shortcut-link-edit shortcut-link">{$LNG.fl_shortcut_edition}</a><a href="#" onclick="SaveShortcuts();return false" class="shortcut-edit">{$LNG.fl_shortcut_save}</a>)</th>
		</tr>
		{foreach $shortcutList as $shortcutID => $shortcutRow}
			{if ($shortcutRow@iteration % $themeSettings.SHORTCUT_ROWS_ON_FLEET1) === 1}<tr style="height:20px;" class="shortcut-row">{/if}			
			<td style="width:{100 / $themeSettings.SHORTCUT_ROWS_ON_FLEET1}%" class="shortcut-colum shortcut-isset">
				<div class="shortcut-link">
					<a class="jsLink setTarget" data-galaxy="{$shortcutRow.galaxy}" data-system="{$shortcutRow.system}" data-planet="{$shortcutRow.planet}" data-type="{$shortcutRow.type}">{$shortcutRow.name}{if $shortcutRow.type == 1}{$LNG.fl_planet_shortcut}{elseif $shortcutRow.type == 2}{$LNG.fl_debris_shortcut}{elseif $shortcutRow.type == 3}{$LNG.fl_moon_shortcut}{/if} [{$shortcutRow.galaxy}:{$shortcutRow.system}:{$shortcutRow.planet}]</a>
				</div>
				<div class="shortcut-edit">
					<input type="text" class="shortcut-input" name="shortcut[{$shortcutID}][name]" value="{$shortcutRow.name}">
					<div class="shortcut-delete" title="{$LNG.fl_dlte_shortcut}"></div>
				</div>
				<div class="shortcut-edit">
					<input type="text" class="shortcut-input" name="shortcut[{$shortcutID}][galaxy]" value="{$shortcutRow.galaxy}" size="3" maxlength="2">:<input type="text" class="shortcut-input" name="shortcut[{$shortcutID}][system]" value="{$shortcutRow.system}" size="3" maxlength="3">:<input type="text" class="shortcut-input" name="shortcut[{$shortcutID}][planet]" value="{$shortcutRow.planet}" size="3" maxlength="2">
					<select class="shortcut-input" name="shortcut[{$shortcutID}][type]">
						{html_options selected=$shortcutRow.type options=$typeSelect}
					</select>
				</div>
			</td>
			{if $shortcutRow@last && ($shortcutRow@iteration % $themeSettings.SHORTCUT_ROWS_ON_FLEET1) !== 0}
			{$to = $themeSettings.SHORTCUT_ROWS_ON_FLEET1 - ($shortcutRow@iteration % $themeSettings.SHORTCUT_ROWS_ON_FLEET1)}
			{for $foo=1 to $to}
			<td class="shortcut-colum" style="width:{100 / $themeSettings.SHORTCUT_ROWS_ON_FLEET1}%">&nbsp;</td>
			{/for}
			{/if}
			{if ($shortcutRow@iteration % $themeSettings.SHORTCUT_ROWS_ON_FLEET1) === 0}</tr>{/if}
		{foreachelse}
		<tr style="height:20px;" class="shortcut-none">
			<td colspan="{$themeSettings.SHORTCUT_ROWS_ON_FLEET1}">{$LNG.fl_no_shortcuts}</td>
		</tr>
		{/foreach}
		<tr style="height:20px;" class="shortcut-edit shortcut-new">
			<td>
				<div class="shortcut-link">
					
				</div>
				<div class="shortcut-edit">
					<input type="text" class="shortcut-input" name="shortcut[][name]" placeholder="{$LNG.fl_shortcut_name}">
					<div class="shortcut-delete" title="{$LNG.fl_dlte_shortcut}"></div>
				</div>
				<div class="shortcut-edit">
					<input type="text" class="shortcut-input" name="shortcut[][galaxy]" value="" size="3" maxlength="2" placeholder="G" pattern="[0-9]*">:<input type="text" class="shortcut-input" name="shortcut[][system]" value="" size="3" maxlength="3" placeholder="S" pattern="[0-9]*">:<input type="text" class="shortcut-input" name="shortcut[][planet]" value="" size="3" maxlength="2" placeholder="P" pattern="[0-9]*">
					<select class="shortcut-input" name="shortcut[][type]">
						{html_options options=$typeSelect}
					</select>
				</div>
			</td>
		</tr>
		<tr style="height:20px;" class="shortcut-edit">
			<td colspan="{$themeSettings.SHORTCUT_ROWS_ON_FLEET1}">
				<a href="#" onclick="AddShortcuts();return false">{$LNG.fl_shortcut_add}</a>
			</td>
		</tr>		
	</table>
	{/if}
	<table class="table519" style="table-layout: fixed;">
		<tr style="height:20px;">
			<th colspan="{$themeSettings.COLONY_ROWS_ON_FLEET1}">{$LNG.fl_my_planets}</th>
		</tr>
		{foreach $colonyList as $ColonyRow}
		{if ($ColonyRow@iteration % $themeSettings.COLONY_ROWS_ON_FLEET1) === 1}<tr style="height:20px;">{/if}
		<td>
			<a class="jsLink setTarget" data-galaxy="{$ColonyRow.galaxy}" data-system="{$ColonyRow.system}" data-planet="{$ColonyRow.planet}" data-type="{$ColonyRow.type}">{$ColonyRow.name}{if $ColonyRow.type == 3}{$LNG.fl_moon_shortcut}{/if} [{$ColonyRow.galaxy}:{$ColonyRow.system}:{$ColonyRow.planet}]</a>
		</td>
		{if $ColonyRow@last && ($ColonyRow@iteration % $themeSettings.COLONY_ROWS_ON_FLEET1) !== 0}
		{$to = $themeSettings.COLONY_ROWS_ON_FLEET1 - ($ColonyRow@iteration % $themeSettings.COLONY_ROWS_ON_FLEET1)}
		{for $foo=1 to $to}<td>&nbsp;</td>{/for}
		{/if}
		{if ($ColonyRow@iteration % $themeSettings.COLONY_ROWS_ON_FLEET1) === 0}</tr>{/if}
		{foreachelse}
		<tr style="height:20px;">
			<td colspan="{$themeSettings.COLONY_ROWS_ON_FLEET1}">{$LNG.fl_no_colony}</td>
		</tr>
		{/foreach}	
	</table>
	{if $fleetGroupList}
	<table class="table519" style="table-layout: fixed;">
		<tr style="height:20px;">
			<th colspan="{$themeSettings.COLONY_ROWS_ON_FLEET1}">{$LNG.fl_acs_title}</th>
		</tr>
		{foreach $fleetGroupList as $ACSRow}
		{if ($ACSRow@iteration % $themeSettings.ACS_ROWS_ON_FLEET1) === 1}<tr style="height:20px;">{/if}
		<tr style="height:20px;">
			<td><a class="jsLink setTarget setFleetGroup" data-galaxy="{$ACSRow.galaxy}" data-system="{$ACSRow.system}" data-planet="{$ACSRow.planet}" data-type="{$ACSRow.type}" data-fleet-group="{$ACSRow.id}">{$ACSRow.name}{if $ACSRow.type == 3}{$LNG.fl_moon_shortcut}{/if}  - [{$ACSRow.galaxy}:{$ACSRow.system}:{$ACSRow.planet}]</a></td>
		</tr>
		{if $ACSRow@last && ($ACSRow@iteration % $themeSettings.ACS_ROWS_ON_FLEET1) !== 0}
		{$to = $themeSettings.ACS_ROWS_ON_FLEET1 - ($ACSRow@iteration % $themeSettings.ACS_ROWS_ON_FLEET1)}
		{for $foo=1 to $to}<td>&nbsp;</td>{/for}
		{/if}
		{if ($ACSRow@iteration % $themeSettings.ACS_ROWS_ON_FLEET1) === 0}</tr>{/if}
		{/foreach}
	</table>
	{/if}
	<table class="table519" style="table-layout: fixed;">
		<tr style="height:20px;">
			<td><input type="submit" value="{$LNG.fl_continue}"></td>
		</tr>
	</table>
</form>
{/block}
{block name="script" append}
<script src="scripts/game/fleet.js"></script>
<script type="text/javascript">
var missionData		= {$missionData|json};
var shortCutRows	= {$themeSettings.SHORTCUT_ROWS_ON_FLEET1};
var fl_no_shortcuts	= '{$LNG.fl_no_shortcuts}';
var endDateInterval	= 0;

$(function() {
	updateScreen();
	$('#form').on('submit', checkTarget);
	$('.updateOnChange').live('change', updateData);
	$('.setTarget').live('click', setTarget);
	$('.setFleetGroup').live('click', setFleetGroup);
});
</script>{/block}