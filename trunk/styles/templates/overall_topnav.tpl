<div id="header_top">
	<table class="header">
		<tr class="header">
			<td class="header" style="width: 150px;">
				<table class="header">
					<tr class="header">
						<td class="header" style="width: 50px;"><img src="{$dpath}planeten/small/s_{$image}.jpg" height="50" width="50" alt="Planetenbild"></td> 
						<td class="header">	  
						<select onChange="document.location = $(this).val();">
						{html_options options=$PlanetSelect selected=$current_panet}
						</select>
						</td>
					</tr>
				</table>
			</td>
			<td class="header">
				<table class="header" id='resources'>
					<tr class="header">
						<td class="header">
							<img src="{$dpath}images/metall.gif" width="42" height="22" alt="{$Metal}">
						</td>
						<td class="header">
							<img src="{$dpath}images/kristall.gif" width="42" height="22" alt="{$Crystal}">
						</td>
						<td class="header">
							<img src="{$dpath}images/deuterium.gif" width="42" height="22" alt="{$Deuterium}">
						</td>
						<td class="header">
							<img src="{$dpath}images/darkmatter.gif" width="42" height="22" alt="{$Darkmatter}">
						</td>	     
						<td class="header">
							<img src="{$dpath}images/energie.gif" width="42" height="22" alt="{$Energy}">
						</td>
					</tr>
					<tr class="header">
						<td class="header res_name">{$Metal}</td>
						<td class="header res_name">{$Crystal}</td>
						<td class="header res_name">{$Deuterium}</td>
						<td class="header res_name">{$Darkmatter}</td>    
						<td class="header res_name">{$Energy}</td>
					</tr>
					<tr class="header">
						<td class="header res_current" id="current_metal">{pretty_number($metal)}</td>
						<td class="header res_current" id="current_crystal">{pretty_number($crystal)}</td>
						<td class="header res_current" id="current_deuterium">{pretty_number($deuterium)}</td>
						<td class="header res_current">{$darkmatter}</td>
						<td class="header res_current">{$energy}</td>
					</tr>
					<tr class="header">
						<td class="header res_max" id="max_metal"><span title="{$alt_metal_max}">{if $settings_tnstor}{$metal_max}{else}{$alt_metal_max}{/if}</span></td>
						<td class="header res_max" id="max_crystal"><span title="{$alt_crystal_max}">{if $settings_tnstor}{$crystal_max}{else}{$alt_crystal_max}{/if}</span></td>
						<td class="header res_max" id="max_deuterium"><span title="{$alt_deuterium_max}">{if $settings_tnstor}{$deuterium_max}{else}{$alt_deuterium_max}{/if}</span></td>
						<td class="header res_max"></td>
						<td class="header res_max"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	{if $closed}
	<table width="70%" id="infobox" style="border: 3px solid red; text-align:center;"><tr><td>{$closed}</td></tr></table>
	{elseif $delete}
	<table width="70%" id="infobox" style="border: 3px solid red; text-align:center;"><tr><td>{$tn_delete_mode} {$delete}</td></tr></table>
	{elseif $vacation}
	<table width="70%" id="infobox" style="border: 3px solid red; text-align:center;"><tr><td>{$tn_vacation_mode} {$vacation}</td></tr></table>
	{/if}
</div>