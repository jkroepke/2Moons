<div id="page">
	<div id="header">
		<table id="headerTable">
			<tbody>
				<tr>
					<td id="planetImage">
						<img src="{$dpath}planeten/small/s_{$image}.jpg" alt=""> 
					</td>
					<td id="planetSelectorWrapper">
						<select id="planetSelector">
							{html_options options=$PlanetSelect selected=$current_pid}
						</select>
					</td>
					<td id="resourceWrapper">
						<table id="resourceTable">
							<tbody>
								<tr>
									<td><img src="{$dpath}images/metall.gif" alt=""></td>
									<td><img src="{$dpath}images/kristall.gif" alt=""></td>
									<td><img src="{$dpath}images/deuterium.gif" alt=""></td>
									<td><img src="{$dpath}images/darkmatter.gif" alt=""></td>
									<td><img src="{$dpath}images/energie.gif" alt=""></td>
								</tr>
								<tr>
									<td class="res_name">{$LNG.tech.901}</td>
									<td class="res_name">{$LNG.tech.902}</td>
									<td class="res_name">{$LNG.tech.903}</td>
									<td class="res_name">{$LNG.tech.921}</td>
									<td class="res_name">{$LNG.tech.911}</td>
								</tr>
								{if $shortlyNumber}
								<tr>
									<td class="res_current tooltip" name="{$metal|number}" id="current_metal">{shortly_number($metal)}</td>
									<td class="res_current tooltip" name="{$crystal|number}" id="current_crystal">{shortly_number($crystal)}</td>
									<td class="res_current tooltip" name="{$deuterium|number}" id="current_deuterium">{shortly_number($deuterium)}</td>
									<td class="res_current tooltip" name="{$darkmatter|number}" id="current_darkmatter">{shortly_number($darkmatter)} </td>
									<td class="res_current tooltip" name="{($energy + $energy_used)|number}&nbsp;/&nbsp;{$energy|number}"><span{if $energy + $energy_used < 0} style="color:red"{/if}>{shortly_number($energy + $energy_used)}&nbsp;/&nbsp;{shortly_number($energy)}</span></td>
								</tr>
								<tr>
									<td class="res_max tooltip" name="{$metal_max|number}" id="max_metal">{shortly_number($metal_max)}</td>
									<td class="res_max tooltip" name="{$crystal_max|number}" id="max_crystal">{shortly_number($crystal_max)}</td>
									<td class="res_max tooltip" name="{$deuterium_max|number}" id="max_deuterium">{shortly_number($deuterium_max)}</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								{else}
								<tr>
									<td class="res_current" id="current_metal">{$metal|number}</td>
									<td class="res_current" id="current_crystal">{$crystal|number}</td>
									<td class="res_current" id="current_deuterium">{$deuterium|number}</td>
									<td class="res_current" id="current_darkmatter">{$darkmatter|number} </td>
									<td class="res_current"><span{if $energy + $energy_used < 0} style="color:red"{/if}>{($energy + $energy_used)|number}&nbsp;/&nbsp;{$energy|number}</span></td>
								</tr>
								<tr>
									<td class="res_max" id="max_metal">{$metal_max|number}</td>
									<td class="res_max" id="max_crystal">{$crystal_max|number}</td>
									<td class="res_max" id="max_deuterium">{$deuterium_max|number}</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								{/if}
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
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
		
		var shortlyNumber	= {$shortlyNumber|json}
		var vacation = {$vmode};
		if (!vacation) {
			resourceTicker(resourceTickerMetal, true);
			resourceTicker(resourceTickerCrystal, true);
			resourceTicker(resourceTickerDeuterium, true);
		}
		</script>
	</div>
	{if $closed}
	<div class="infobox">{$closed}</div>
	{elseif $delete}
	<div class="infobox">{$delete}</div>
	{elseif $vacation}
	<div class="infobox">{$LNG.tn_vacation_mode} {$vacation}</div>
	{/if}