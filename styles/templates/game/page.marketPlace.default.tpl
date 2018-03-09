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
			Ship type as first:
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
		<tr>
			<th>ID</th>
			<th>{$LNG['tech'][901]}</th>
			<th>{$LNG['tech'][902]}</th>
			<th>{$LNG['tech'][903]}</th>
			<th>{$LNG.market_p_total}</th>
			<th>{$LNG.market_p_cost_type}</th>
			<th>{$LNG.market_p_cost_amount}</th>
			<th>{$LNG.market_p_end}</th>
			<th>{$LNG.market_p_distance}</th>
			<th>{$LNG.market_p_buy}</th>
		</tr>
	</thead>
	<tbody>

	{foreach name=FlyingFleets item=FlyingFleetRow from=$FlyingFleetList}
	<tr>
		<td>{$smarty.foreach.FlyingFleets.iteration}</td>
		<td>{$FlyingFleetRow.fleet_resource_metal}</td>
		<td>{$FlyingFleetRow.fleet_resource_crystal}</td>
		<td>{$FlyingFleetRow.fleet_resource_deuterium}</td>
		<td>{$FlyingFleetRow.total}</td>
		<td>{$FlyingFleetRow.fleet_wanted_resource}</td>
		<td>{$FlyingFleetRow.fleet_wanted_resource_amount}</td>
		<td data-time="{$FlyingFleetRow.end}">{pretty_fly_time({$FlyingFleetRow.end})}</td>
		<td>{$FlyingFleetRow.distance}</td>
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
$(".market_form").submit( function() {
	var c = confirm("Are you sure?");
	if (c) {
		$(this).append('<input type="hidden" name="shipType" value="' + $("#shipT").val() + '">')
	}
	return c;
});
});</script>
{/block}
