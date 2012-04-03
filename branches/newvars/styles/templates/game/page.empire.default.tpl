{block name="title" prepend}{$LNG.lm_empire}{/block}
{block name="content"}
<table>
	<tbody>
		<tr>
			<th colspan="{$colspan}">{$LNG.lv_imperium_title}</th>
		</tr>
		<tr>
			<td style="width:100px">{$LNG.lv_planet}</td>
			<td style="width:100px;font-size: 50px;">&Sigma;</td>
			{foreach $planetList.image as $planetID => $image}
			<td style="width:100px"><a href="game.php?page=overview&amp;cp={$planetID}"><img width="80" height="80" border="0" src="{$dpath}planeten/small/s_{$image}.jpg"></a></td>
			{/foreach}
		</tr>
		<tr>
			<td>{$LNG.lv_name}</td>
			<td>{$LNG.lv_total}</td>
			{foreach $planetList.name as $name}
				<td>{$name}</td>
			{/foreach}
		</tr>
		<tr>
			<td>{$LNG.lv_coords}</td>
			<td>-</td>
			{foreach $planetList.coords as $coords}
				<td><a href="game.php?page=galaxy&amp;galaxy={$coords.galaxy}&amp;system={$coords.system}">[{$coords.galaxy}:{$coords.system}:{$coords.planet}]</a></td>
			{/foreach}
		</tr>
		<tr>
			<td>{$LNG.lv_fields}</td>
			<td>-</td>
			{foreach $planetList.field as $field}
				<td>{$field.current} / {$field.max}</td>
			{/foreach}
		</tr>
		<tr>
			<th colspan="{$colspan}">{$LNG.lv_resources}</th>
		</tr>
		{foreach $planetList.resource as $elementID => $resourceArray}
		<tr>
			<td>{$LNG.tech.$elementID}</td>
			<td>{array_sum($resourceArray)|number}</td>
			{foreach $resourceArray as $planetID => $resource}
				<td>{$resource|number}</td>
			{/foreach}
		</tr>
		{/foreach}
		<tr>
			<th colspan="{$colspan}">{$LNG.lv_buildings}</th>
		</tr>
		{foreach $planetList.build as $elementID => $buildArray}
		<tr>
			<td>{$LNG.tech.$elementID}</td>
			<td>{array_sum($buildArray)|number}</td>
			{foreach $buildArray as $planetID => $build}
				<td>{$build|number}</td>
			{/foreach}
		</tr>
		{/foreach}
		<tr>
			<th colspan="{$colspan}">{$LNG.lv_technology}</th>
		</tr>
		{foreach $planetList.tech as $elementID => $tech}
		<tr>
			<td>{$LNG.tech.$elementID}</td>
			<td>{$tech|number}</td>
			{foreach $planetList.name as $name}
				<td>{$tech|number}</td>
			{/foreach}
		</tr>
		{/foreach}
		<tr>
			<th colspan="{$colspan}">{$LNG.lv_ships}</th>
		</tr>
		{foreach $planetList.fleet as $elementID => $fleetArray}
		<tr>
			<td>{$LNG.tech.$elementID}</td>
			<td>{array_sum($fleetArray)|number}</td>
			{foreach $fleetArray as $planetID => $fleet}
				<td>{$fleet|number}</td>
			{/foreach}
		</tr>
		{/foreach}
		<tr>
			<th colspan="{$colspan}">{$LNG.lv_defenses}</th>
		</tr>
		{foreach $planetList.defense as $elementID => $fleetArray}
		<tr>
			<td>{$LNG.tech.$elementID}</td>
			<td>{array_sum($fleetArray)|number}</td>
			{foreach $fleetArray as $planetID => $fleet}
				<td>{$fleet|number}</td>
			{/foreach}
		</tr>
		{/foreach}
	</tbody>
</table>
{/block}