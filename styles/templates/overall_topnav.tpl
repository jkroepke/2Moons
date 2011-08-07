<div id="header">
	<div id="planetselect">
		<img src="{$dpath}planeten/small/s_{$image}.jpg" alt=""> 
		<select onchange="document.location = $(this).val();">
			{html_options options=$PlanetSelect selected=$current_planet}
		</select>
	</div>
	<div id="resources">
		<table id="resourcestable">
			<tr>
				<td class="resourceinfo">
					<p><img src="{$dpath}images/metall.gif" alt="{$Metal}"></p>
					<p class="res_name">{$Metal}</p>
					<p class="res_current tooltip" name="{pretty_number($metal)}" id="current_metal">{shortly_number($metal)}</p>
					<p class="res_max tooltip" name="{pretty_number($metal_max)}" id="max_metal">{shortly_number($metal_max)}</p>
				</td>
				<td class="resourceinfo">
					<p><img src="{$dpath}images/kristall.gif" alt="{$Crystal}"></p>
					<p class="res_name">{$Crystal}</p>
					<p class="res_current tooltip" name="{pretty_number($crystal)}" id="current_crystal">{shortly_number($crystal)}</p>
					<p class="res_max tooltip" name="{pretty_number($crystal_max)}" id="max_crystal">{shortly_number($crystal_max)}</p>
				</td>
				<td class="resourceinfo">
					<p><img src="{$dpath}images/deuterium.gif" alt="{$Deuterium}"></p>
					<p class="res_name">{$Deuterium}</p>
					<p class="res_current tooltip" name="{pretty_number($deuterium)}" id="current_deuterium">{shortly_number($deuterium)}</p>
					<p class="res_max tooltip" name="{pretty_number($deuterium_max)}" id="max_deuterium">{shortly_number($deuterium_max)}</p>
				</td>
				<td class="resourceinfo">
					<p><img src="{$dpath}images/darkmatter.gif" alt="{$Darkmatter}"></p>
					<p class="res_name">{$Darkmatter}</p>
					<p class="res_current tooltip" name="{pretty_number($darkmatter)}">{shortly_number($darkmatter)}</p>
					<p>&nbsp;</p>
				</td>
				<td class="resourceinfo">
					<p><img src="{$dpath}images/energie.gif" alt="{$Energy}"></p>
					<p class="res_name">{$Energy}</p>
					<p class="res_current tooltip" name="{$energy_alt}">{$energy}</p>
				</td>
			</tr>
		</table>
	</div>
	{if $closed}
	<table width="70%" id="infobox" style="border: 3px solid red; text-align:center;"><tr><td>{$closed}</td></tr></table>
	{elseif $delete}
	<table width="70%" id="infobox" style="border: 3px solid red; text-align:center;"><tr><td>{$tn_delete_mode} {$delete}</td></tr></table>
	{elseif $vacation}
	<table width="70%" id="infobox" style="border: 3px solid red; text-align:center;"><tr><td>{$tn_vacation_mode} {$vacation}</td></tr></table>
	{/if}
	<script type="text/javascript">
	var resourceTickerMetal = {
		available: {$metal},
		limit: [0, {$js_metal_max}],
		production: {$js_metal_hr},
		valueElem: "current_metal"
	};
	var resourceTickerCrystal = {
		available: {$crystal},
		limit: [0, {$js_crystal_max}],
		production: {$js_crystal_hr},
		valueElem: "current_crystal"
	};
	var resourceTickerDeuterium = {
		available: {$deuterium},
		limit: [0, {$js_deuterium_max}],
		production: {$js_deuterium_hr},
		valueElem: "current_deuterium"
	};

	var vacation = {$vmode};
	if (!vacation) {
		resourceTicker(resourceTickerMetal, true);
		resourceTicker(resourceTickerCrystal, true);
		resourceTicker(resourceTickerDeuterium, true);
	}
	</script>
</div>