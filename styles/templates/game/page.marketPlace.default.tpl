{block name="title" prepend}{$LNG.lm_marketplace}{/block}
{block name="content"}
{$message}<br/>
<table id="tradeList" style="width:50%" class="tablesorter">
	<thead>
		<tr>
			<th>ID</th>
			<th>{$LNG['tech'][901]}</th>
			<th>{$LNG['tech'][902]}</th>
			<th>{$LNG['tech'][903]}</th>
			<th>Total</th>
			<th>Total value</th>
			<th>Cost type</th>
			<th>Amount</th>
			<th>Ratio</th>
			<th>End</th>
			<th>Distance</th>
			<th>Buy</th>
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
		<td>{$FlyingFleetRow.total_value}</td>
		<td>{$FlyingFleetRow.fleet_wanted_resource}</td>
		<td>{$FlyingFleetRow.fleet_wanted_resource_amount}</td>
		<td>{$FlyingFleetRow.ratio}</td>
		<td>{pretty_fly_time({$FlyingFleetRow.end})}</td>
		<td>{$FlyingFleetRow.distance}</td>
		<td><form action="game.php?page=marketPlace&amp;action=buy" method="post">
		<input name="fleetID" value="{$FlyingFleetRow.id}" type="hidden">
		<input value="{$LNG.fl_submit}" type="submit">
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
		headers: {
			0: { sorter: false } ,
			3: { sorter: false }
		},
		debug: false
	});
});</script>
{/block}
