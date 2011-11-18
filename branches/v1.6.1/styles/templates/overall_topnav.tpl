<div id="page">
	<div id="header">
		<div id="planetselect">
			<img src="{$dpath}planeten/small/s_{$image}.jpg" alt=""> 
			<select onchange="document.location = $(this).val();">
				{html_options options=$PlanetSelect selected=$current_planet}
			</select>
		</div>
		<div id="resourcesdiv">
			<ul id="resourcestable">
				<li class="resourceinfo">
					<p><img src="{$dpath}images/metall.gif" alt="{$Metal}"></p>
					<p class="res_name">{lang}Metal{/lang}</p>
					<p class="res_current tooltip" name="{pretty_number($metal)}" id="current_metal">{shortly_number($metal)}</p>
					<p class="res_max tooltip" name="{pretty_number($metal_max)}" id="max_metal">{shortly_number($metal_max)}</p>
				</li>
				<li class="resourceinfo">
					<p><img src="{$dpath}images/kristall.gif" alt="{$Crystal}"></p>
					<p class="res_name">{lang}Crystal{/lang}</p>
					<p class="res_current tooltip" name="{pretty_number($crystal)}" id="current_crystal">{shortly_number($crystal)}</p>
					<p class="res_max tooltip" name="{pretty_number($crystal_max)}" id="max_crystal">{shortly_number($crystal_max)}</p>
				</li>
				<li class="resourceinfo">
					<p><img src="{$dpath}images/deuterium.gif" alt="{$Deuterium}"></p>
					<p class="res_name">{lang}Deuterium{/lang}</p>
					<p class="res_current tooltip" name="{pretty_number($deuterium)}" id="current_deuterium">{shortly_number($deuterium)}</p>
					<p class="res_max tooltip" name="{pretty_number($deuterium_max)}" id="max_deuterium">{shortly_number($deuterium_max)}</p>
				</li>
				<li class="resourceinfo">
					<p><img src="{$dpath}images/darkmatter.gif" alt="{$Darkmatter}"></p>
					<p class="res_name">{lang}Darkmatter{/lang}</p>
					<p class="res_current tooltip" name="{pretty_number($darkmatter)}">{shortly_number($darkmatter)}</p>
					<p>&nbsp;</p>
				</li>
				<li class="resourceinfo">
					<p><img src="{$dpath}images/energie.gif" alt="{$Energy}"></p>
					<p class="res_name">{lang}Energy{/lang}</p>
					<p class="res_current tooltip" name="{$energy_alt}">{$energy}</p>
					<p>&nbsp;</p>
				</li>
			</ul>
		</div>
		{if $closed}
		<div class="infobox">{$closed}</div>
		{elseif $delete}
		<div class="infobox">{lang}tn_delete_mode{/lang} {$delete}</div>
		{elseif $vacation}
		<div class="infobox">{lang}tn_vacation_mode{/lang} {$vacation}</div>
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