{block name="title" prepend}{if $mode == "defense"}{$LNG.lm_defenses}{else}{$LNG.lm_shipshard}{/if}{/block}
{block name="content"}
{if $isShipyardInBuild}<table width="70%" id="infobox" style="border: 2px solid red; text-align:center;background:transparent"><tr><td>{$LNG.bd_building_shipyard}</td></tr></table><br><br>{/if}
{if !empty($BuildList)}
<table style="width:760px">
	<tr>
		<td class="transparent">
			<div id="bx" class="z"></div>
			<br>
			<form action="game.php?page=shipyard&amp;mode={$mode}" method="post">
			<input type="hidden" name="action" value="delete">
			<table>
			<tr>
				<th>&nbsp;</th>
			</tr>
			<tr>
				<td><select name="auftr[]" id="auftr" size="10" multiple><option>&nbsp;</option></select><br><br>{$LNG.bd_cancel_warning}<br><input type="submit" value="{$LNG.bd_cancel_send}"></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
			</tr>
			</table>
			</form>
			<br><span id="timeleft"></span><br><br>
		</td>
	</tr>
</table>
<br>
{/if}
<form action="game.php?page=shipyard" method="post">
<input type="hidden" name="mode" value="build">
<input type="hidden" name="redirectMode" value="{$mode}">
<table style="width:760px">
	{foreach $elementList as $elementId => $elementData}
	<tr>
		<td rowspan="2" style="width:120px;">
			<a href="#" onclick="return Dialog.info({$elementId})">
				<img src="{$dpath}gebaeude/{$elementId}.gif" alt="{$LNG.tech.{$elementId}}" width="120" height="120">
			</a>
		</td>
		<th>
			<a href="#" onclick="return Dialog.info({$elementId})"><label for="input_{$elementId}">{$LNG.tech.{$elementId}}</label></a><span id="val_{$elementId}">{if $elementData.available != 0} ({$LNG.bd_available} {$elementData.available|number}){/if}</span>
		</th>
	</tr>
	<tr>
		<td>
			<table style="width:100%">
				<tr>
					<td class="transparent left" style="width:90%;padding:10px;"><p>{$LNG.shortDescription.{$elementId}}</p><p>{foreach $elementData.costResources as $resourceId => $value}
					{$LNG.tech.{$resourceId}}: <b><span style="color:{if $elementData.costOverflow[$resourceId] == 0}lime{else}red{/if}">{$value|number}</span></b>
					{/foreach}</p></td>
					<td class="transparent" style="vertical-align:middle;width:100px">
					{if $elementData.maxLevel != 0 && $elementData.maxLevel == $elementData.levelToBuild}
						<p><span style="color:red">{$LNG.bd_maxlevel}</span></p>
					{elseif $elementData.isBusy}
						<p><span style="color:red">{$LNG.bd_working}</span></p>
					{elseif $elementData.buyable}
						<p><input type="text" name="element[{$elementId}]" id="input_{$elementId}" size="{$maxlength}" maxlength="{$maxlength}" value="0" tabindex="{$smarty.foreach.FleetList.iteration}"></p>
						<p><input type="button" value="{$LNG.bd_max_ships}" onclick="$('#input_{$elementId}').val('{$elementData.maxBuildable}')"></p>
					{/if}
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="margin-bottom:10px;">  
			<table style="width:100%">
				<tr>
					<td class="transparent left">
						{$LNG.bd_remaining}<br>
						{foreach $elementData.costOverflow as $resourceId => $value}
						{$LNG.tech.{$resourceId}}: <span style="font-weight:700">{$value|number}</span><br>
						{/foreach}
						<br>
					</td>
					<td class="transparent right">
						{$LNG.fgf_time}
					</td>
				</tr>
				<tr>		
					<td class="transparent left" style="width:68%">
						{$LNG.bd_max_ships_long}:<br><span style="font-weight:700">{$elementData.maxBuildable|number}</span>
					</td>
					<td class="transparent right" style="white-space:nowrap;">
						{$elementData.elementTime|time}
					</td>
				</tr>	
			</table>
		</td>
	</tr>
	{/foreach}
	{if !$isShipyardInBuild}<tr><th colspan="2" style="text-align:center"><input type="submit" value="{$LNG.bd_build_ships}"></th></tr>{/if}
</table>
</form>
{/block}
{block name="script" append}
<script type="text/javascript">
data			= {$BuildList|json};
bd_operating	= '{$LNG.bd_operating}';
bd_available	= '{$LNG.bd_available}';
</script>
{if !empty($BuildList)}
<script src="scripts/base/bcmath.js"></script>
<script src="scripts/game/shipyard.js"></script>
<script type="text/javascript">
$(function() {
    ShipyardInit();
});
</script>
{/if}
{/block}