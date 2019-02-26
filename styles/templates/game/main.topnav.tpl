<label class="hamburger" for="toggle-menu" class="toggle-menu"><i class="fas fa-bars"></i></label>

<div class="planetImage no-mobile">
   <img src="{$avatar}" width="50" height="50" alt="">
   <div>{$LNG.tech.615}</div>
   <div><b>{$username}</b></div>
</div>

<div class="planetSelectorWrapper">
	<img src="{$dpath}planeten/{$image}.jpg" width="50" height="50" alt="">
	<div class="planetSelectorName" for="planetSelector"></div>
	<div class="no-mobile">&nbsp;</div>
	<div class="no-mobile">&nbsp;</div>
	<select id="planetSelector">
		{html_options options=$PlanetSelect selected=$current_pid}
	</select>
</div>

<div id="resources_mobile">
	{foreach $resourceTable as $resourceID => $resourceData}
	<div id="resource_mobile">
		<a href="#" onclick="return Dialog.info({$resourceID});">
			<img src="{$dpath}images/{$resourceData.name}.gif">
			<div class="resource_name no-mobile">{$LNG.tech.$resourceID}</div>
			
			<div class="no-mobile">
				{if !isset($resourceData.current)}
					{$resourceData.currentt = $resourceData.max + $resourceData.used}
						<td class="res_current tooltip" data-tooltip-content="{$resourceData.currentt|number}">
							<span{if $resourceData.currentt < 0} style="color:red"{/if}>{$resourceData.currentt|number}&nbsp;/&nbsp;{$resourceData.max|number}</span>
						</td>
				{else}
					<div class="res_current" id="current_{$resourceData.name}" data-real="{$resourceData.current}">{$resourceData.current|number}</div>
				{/if}
				{if !isset($resourceData.current) || !isset($resourceData.max)}
					<div>&nbsp;</div>
				{else}
					<div class="res_max" id="max_{$resourceData.name}" data-real="{$resourceData.current}">{$resourceData.max|number}</div>
				{/if}
			</div>
			
			<div class="mobile">
				{if !isset($resourceData.current)}
					{$resourceData.currentt = $resourceData.max + $resourceData.used}
						<td class="res_current tooltip" data-tooltip-content="{$resourceData.currentt|number}">
							<span{if $resourceData.currentt < 0} style="color:red"{/if}>{shortly_number($resourceData.currentt)}</span>
						</td>
				{else}
					<td class="res_current" id="current_{$resourceData.name}" data-real="{$resourceData.current}">{shortly_number($resourceData.current)}</td>
				{/if}
			</div>
			<!--
			<div class="mobile">
				{if !isset($resourceData.current)}
					{$resourceData.current = $resourceData.max + $resourceData.used}
						<td class="res_current tooltip mobile" data-tooltip-content="{$resourceData.current|number}">
							<span{if $resourceData.current < 0} style="color:red"{/if}>!{shortly_number($resourceData.current)}</span>
							<span{if $resourceData.current < 0} style="color:red"{/if} class="no-mobile">&nbsp;/&nbsp;@{$resourceData.max|number}</span>
						</td>
						<td class="res_current tooltip no-mobile" data-tooltip-content="{$resourceData.current|number}">
							<span{if $resourceData.current < 0} style="color:red"{/if}>!{$resourceData.current}</span>
							<span{if $resourceData.current < 0} style="color:red"{/if} class="no-mobile">&nbsp;/&nbsp;@{$resourceData.max|number}</span>
						</td>
				{else}
					<td class="res_current tooltip mobile" id="current_{$resourceData.name}" data-real="{$resourceData.current}" data-tooltip-content="{$resourceData.current|number}">#{shortly_number($resourceData.current)}</td>
					<td class="res_current no-mobile" id="current_{$resourceData.name}" data-real="{$resourceData.current}">#{$resourceData.current}</td>
				{/if}
				{if !isset($resourceData.current) || !isset($resourceData.max)}
				{else}
					<div class="res_max no-mobile" id="max_{$resourceData.name}" data-real="{$resourceData.current}">{$resourceData.max|number}</div>
				{/if}
			</div>
			-->
			
			<!--
			<div>
			{if true or $shortlyNumber}
				{if !isset($resourceData.current)}
				{$resourceData.current = $resourceData.max + $resourceData.used}
				<td class="res_current tooltip" data-tooltip-content="{$resourceData.current|number}"><span{if $resourceData.current < 0} style="color:red"{/if}>{shortly_number($resourceData.current)}</span></td>
				{else}
				<td class="res_current tooltip" id="current_{$resourceData.name}" data-real="{$resourceData.current}" data-tooltip-content="{$resourceData.current|number}">{shortly_number($resourceData.current)}</td>
				{/if}
			{else}
				{if !isset($resourceData.current)}
				{$resourceData.current = $resourceData.max + $resourceData.used}
				<div class="res_current"><span{if $resourceData.current < 0} style="color:red"{/if}>{$resourceData.current|number}&nbsp;/&nbsp;{$resourceData.max|number}</span></div>
				{else}
				<div class="res_current" id="current_{$resourceData.name}" data-real="{$resourceData.current}">{$resourceData.current|number}</div>
				{/if}
				{if !isset($resourceData.current) || !isset($resourceData.max)}
				<div>&nbsp;</div>
				{else}
				<div class="res_max" id="max_{$resourceData.name}" data-real="{$resourceData.current}">{$resourceData.max|number}</div>
				{/if}
			{/if}
			</div>
			-->
		</a>
	</div>
	{/foreach}
</div>

<!--
<table id="headerTable">
	<tbody>
		<tr>
			<td id="planetImage">
			   <img src="{$avatar}" width="50" height="50" alt="">
			   <div>{$LNG.tech.615} <b>{$username}</b></div>
			</td>
			<td id="planetSelectorWrapper">
			   <img src="{$dpath}planeten/{$image}.jpg" width="50" height="50" alt="">
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
							<td>
								<a href="#" onclick="return Dialog.info({$resourceID});">
									<img src="{$dpath}images/{$resourceData.name}.gif" alt="">
								</a>
							</td>
							{/foreach}
						</tr>
						<tr>
							{foreach $resourceTable as $resourceID => $resourceData}
							<td class="res_name">
								<a href="#" onclick="return Dialog.info({$resourceID});">
									<span style="color:red">
									{$LNG.tech.$resourceID}
									</span>
								</a>
							</td>
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
-->
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