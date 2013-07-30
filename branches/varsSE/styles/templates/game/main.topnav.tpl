<div id="page">
	<div id="header">
		<table id="headerTable">
			<tbody>
				<tr>
					<td id="planetImage">
                       <img src="{$dpath}planeten/small/s_{$image}.jpg" alt="">
					</td>
					<td id="planetSelectorWrapper">
                        <label for="planetSelector"></label>
						<select id="planetSelector">
							{html_options options=$PlanetSelect selected=$current_pid}
						</select>
					</td>
					<td id="resourceWrapper">
						<table id="resourceTable">
							<tbody>
								<tr>
									{foreach $resourceTable as $resourceID => $resourceData}
									<td><img src="{$dpath}images/{$resourceData.name}.gif" alt=""></td>
									{/foreach}
								</tr>
								<tr>
									{foreach $resourceTable as $resourceID => $resourceData}
									<td class="res_name">{$LNG.tech.$resourceID}</td>
									{/foreach}
								</tr>
								{if $shortlyNumber}
								<tr>
									{foreach $resourceTable as $resourceID => $resourceData}
									{if !isset($resourceData.current)}
									{$resourceData.current = $resourceData.max + $resourceData.used}
									<td class="res_current tooltip" data-tooltip-content="{$resourceData.current|number}&nbsp;/&nbsp;{$resourceData.max|number}"><span{if $resourceData.current < 0} style="color:red"{/if}>{shortly_number($resourceData.current)}&nbsp;/&nbsp;{shortly_number($resourceData.max)}</span></td>
									{else}
									<td class="res_current tooltip" id="current_{$resourceData.name}" data-real="{$resourceData.current}" data-tooltip-content="{$resourceData.current|number}">{shortly_number($resourceData.current)}</td>
									{/if}
									{/foreach}
								</tr>
								<tr>
									{foreach $resourceTable as $resourceID => $resourceData}
									{if !isset($resourceData.current) || !isset($resourceData.max)}
									<td>&nbsp;</td>
									{else}
									<td class="res_max tooltip" id="max_{$resourceData.name}" data-real="{$resourceData.max}" data-tooltip-content="{$resourceData.max|number}">{shortly_number($resourceData.max)}</td>
									{/if}
									{/foreach}
								</tr>
								{else}
								<tr>
									{foreach $resourceTable as $resourceID => $resourceData}
									{if !isset($resourceData.current)}
									{$resourceData.current = $resourceData.max + $resourceData.used}
									<td class="res_current"><span{if $resourceData.current < 0} style="color:red"{/if}>{$resourceData.current|number}&nbsp;/&nbsp;{$resourceData.max|number}</span></td>
									{else}
									<td class="res_current" id="current_{$resourceData.name}" data-real="{$resourceData.current}">{$resourceData.current|number}</td>
									{/if}
									{/foreach}
								</tr>
								<tr>
									{foreach $resourceTable as $resourceID => $resourceData}
									{if !isset($resourceData.current) || !isset($resourceData.max)}
									<td>&nbsp;</td>
									{else}
									<td class="res_max" id="max_{$resourceData.name}" data-real="{$resourceData.current}">{$resourceData.max|number}</td>
									{/if}
									{/foreach}
								</tr>
								{/if}
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
		{if !$vmode}
		<script type="text/javascript">
		var viewShortlyNumber	= {$shortlyNumber|json};
		var vacation			= {$vmode};
        $(function() {
		{foreach $resourceTable as $resourceID => $resourceData}
		{if isset($resourceData.production)}
            resourceTicker({
                available: {$resourceData.current|json},
                limit: [0, {$resourceData.max|json}],
                production: {$resourceData.production|json},
                valueElem: "current_{$resourceData.name}"
            }, true);
		{/if}
		{/foreach}
        });
		</script>
        <script src="scripts/game/topnav.js"></script>
        {if $hasGate}<script src="scripts/game/gate.js"></script>{/if}
		{/if}
	</div>
	{if $closed}
	<div class="infobox">{$LNG.ov_closed}</div>
	{elseif $delete}
	<div class="infobox">{$delete}</div>
	{elseif $vacation}
	<div class="infobox">{$LNG.tn_vacation_mode} {$vacation}</div>
	{/if}