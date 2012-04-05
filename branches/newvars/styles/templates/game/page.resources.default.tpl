{block name="title" prepend}{$LNG.lm_resources}{/block}
{block name="content"}
<form action="?page=resources" method="post">
<input type="hidden" name="mode" value="send">
<table style="width:760px;">
<tbody>
<tr>
	<th colspan="5">{$header}</th>
</tr>
<tr style="height:22px">
	<td style="width:40%">&nbsp;</td>
	{foreach $ressIDs as $resourceID}
		<td style="width:10%">{$LNG.tech[$resourceID]}</td>
	{/foreach}
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_basic_income}</td>
	{foreach $ressIDs as $resourceID}
		<td>{$basicProduction[$resourceID]|number}</td>
	{/foreach}
</tr>
{foreach $productionList as $productionID => $productionRow}
<tr style="height:22px">
	<td>{$LNG.tech.$productionID} ({if $productionID  > 200}{$LNG.rs_amount}{else}{$LNG.rs_lvl}{/if} {$productionRow.elementLevel})</td>
	{foreach $ressIDs as $resourceID}
		<td><span style="color:{if $productionRow.production[$resourceID] > 0}lime{elseif $productionRow.production[$resourceID] < 0}red{else}white{/if}">{$productionRow.production[$resourceID]|number}</span></td>
	{/foreach}
	<td style="width:10%">
		{html_options name="prod[{$productionID}]" options=$prodSelector selected=$productionRow.prodLevel}
	</td>
</tr>
{/foreach}
<tr style="height:22px">
	<td>{$LNG.rs_ress_bonus}</td>
	{foreach $ressIDs as $resourceID}
		<td><span style="color:{if $bonusProduction[$resourceID] > 0}lime{elseif $bonusProduction[$resourceID] < 0}red{else}white{/if}">{$bonusProduction[$resourceID]|number}</span></td>
	{/foreach}
	<td><input value="{$LNG.rs_calculate}" type="submit"></td>
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_storage_capacity}</td>
	{foreach $ressIDs as $resourceID}
		<td><span style="color:lime;">{$storage[$resourceID]}</span></td>
	{/foreach}
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_sum}:</td>
	{foreach $ressIDs as $resourceID}
		<td><span style="color:{if $totalProduction[$resourceID] > 0}lime{elseif $totalProduction[$resourceID] < 0}red{else}white{/if}">{$totalProduction[$resourceID]|number}</span></td>
	{/foreach}
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_daily}</td>
	{foreach $ressIDs as $resourceID}
		<td><span style="color:{if $dailyProduction[$resourceID] > 0}lime{elseif $dailyProduction[$resourceID] < 0}red{else}white{/if}">{$dailyProduction[$resourceID]|number}</span></td>
	{/foreach}
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_weekly}</td>
	{foreach $ressIDs as $resourceID}
		<td><span style="color:{if $weeklyProduction[$resourceID] > 0}lime{elseif $weeklyProduction[$resourceID] < 0}red{else}white{/if}">{$weeklyProduction[$resourceID]|number}</span></td>
	{/foreach}
</tr>
</tbody>
</table>
</form>
{/block}