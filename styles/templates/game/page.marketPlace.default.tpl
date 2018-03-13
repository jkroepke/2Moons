{block name="title" prepend}{$LNG.lm_marketplace}{/block}
{block name="content"}

<table style="width:50%">
	<tr>
		<th colspan="2">
			Options
		</th>
	</tr>
	<tr>
		<td>
			{$LNG.market_ship_as_first}
		</td>
		<td>
			<select id="shipT">
				<option value="1">{$LNG.shortNames[202]}</option>
				<option value="2" selected>{$LNG.shortNames[203]}</option>
			</select>
		</td>
	</tr>
</table>

{if $message}
<table style="width:50%">
	<tr>
		<th>
			{$LNG.fcm_info}
		</th>
	</tr>
	<tr>
		<td>
			{$message}
		</td>
	</tr>
</table>
<br/><br/>
{/if}
<table id="tradeList" style="width:50%;white-space: nowrap;" class="tablesorter">
	<thead>
		<tr class="no-background no-border">
			<th></th>
			<th></th>
			<th><img src="./styles/theme/nova/images/metal.gif"/></th>
			<th><img src="./styles/theme/nova/images/crystal.gif"/></th>
			<th><img src="./styles/theme/nova/images/deuterium.gif"/></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th class="LC" style="display: none;"></th>
			<th class="HC"></th>
			<th></th>
		</tr>
		<tr>
			<th>ID</th>
			<th>{$LNG['gl_player']}</th>
			<th>{$LNG['tech'][901]}</th>
			<th>{$LNG['tech'][902]}</th>
			<th>{$LNG['tech'][903]}</th>
			<th>{$LNG.market_p_total}</th>
			<th  class="no-background no-border">-></th>
			<th>{$LNG.market_p_cost_type}</th>
			<th>{$LNG.market_p_cost_amount}</th>
			<th>{$LNG.market_p_end}</th>
			<th>{$LNG.market_p_from_duration}</th>
			<th class="LC" style="display: none;">{$LNG.market_p_to_duration}</th>
			<th class="HC">{$LNG.market_p_to_duration}</th>
			<th>{$LNG.market_p_buy}</th>
		</tr>
	</thead>
	<tbody>

	{foreach name=FlyingFleets item=FlyingFleetRow from=$FlyingFleetList}
	<tr>
		<td>{$smarty.foreach.FlyingFleets.iteration}</td>
		<td>{$FlyingFleetRow.username}</td>
		<td class="resource_metal">{$FlyingFleetRow.fleet_resource_metal}</td>
		<td class="resource_crystal">{$FlyingFleetRow.fleet_resource_crystal}</td>
		<td class="resource_deuterium">{$FlyingFleetRow.fleet_resource_deuterium}</td>
		<td>{$FlyingFleetRow.total}</td>
		<td class="no-background no-border">
			{if $FlyingFleetRow.fleet_wanted_resource_id == 1}
			<img src="./styles/theme/nova/images/metal.gif"/>
			{elseif $FlyingFleetRow.fleet_wanted_resource_id == 2}
			<img src="./styles/theme/nova/images/crystal.gif"/>
			{elseif $FlyingFleetRow.fleet_wanted_resource_id == 3}
			<img src="./styles/theme/nova/images/deuterium.gif"/>
			{/if}
		</td>
		<td class="wanted-resource-{$FlyingFleetRow.fleet_wanted_resource_id}">{$FlyingFleetRow.fleet_wanted_resource}</td>
		<td class="wanted-resource-amount">{$FlyingFleetRow.fleet_wanted_resource_amount}</td>
		<td data-time="{$FlyingFleetRow.end}">{pretty_fly_time({$FlyingFleetRow.end})}</td>
		<td>{pretty_fly_time({$FlyingFleetRow.from_duration})}</td>
		<td class="LC" style="display: none;">{pretty_fly_time({$FlyingFleetRow.to_lc_duration})}</td>
		<td class="HC">{pretty_fly_time({$FlyingFleetRow.to_hc_duration})}</td>
		<td><form class="market_form" action="game.php?page=marketPlace&amp;action=buy" method="post">
		<input name="fleetID" value="{$FlyingFleetRow.id}" type="hidden">
		<input value="{$LNG.market_p_submit}" type="submit">
		</form></td>
	</tr>
	{/foreach}
	</tbody>
</table>
{/block}
{block name="script" append}
<script src="scripts/base/jquery.tablesorter.js"></script>
<script>$(function() {
$("#tradeList").tablesorter({
	headers: {},
	debug: false
});

$('#shipT').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
		if(valueSelected == 1) {
			$('.HC').hide();
			$('.LC').show();
		}
		if(valueSelected == 2) {
			$('.LC').hide();
			$('.HC').show();
		}
});

$('#shipT').trigger("change");

$(".market_form").submit( function() {
	var c = confirm({$LNG.market_confirm_are_you_sure});
	if (c) {
		$(this).append('<input type="hidden" name="shipType" value="' + $("#shipT").val() + '">')
	}
	return c;
});
});</script>
{/block}
