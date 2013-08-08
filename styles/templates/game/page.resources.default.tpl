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
	{foreach $basicProduction as $elementId => $value}
	<td style="width:10%">{$LNG.tech.$elementId}</td>
	{/foreach}
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_basic_income}</td>
	{foreach $basicProduction as $value}
	<td>{$value|number}</td>
	{/foreach}
</tr>
{foreach $productionList as $productionID => $productionRow}
<tr style="height:22px">
	<td>{$LNG.tech.$productionID } ({if $productionID  > 200}{$LNG.rs_amount}{else}{$LNG.rs_lvl}{/if} {$productionRow.elementLevel})</td>
	{foreach $productionRow.production as $value}
	<td><span style="color:{if $value > 0}lime{elseif $value < 0}red{else}white{/if}">{$value|number}</span></td>
	{/foreach}
	<td style="width:10%">
		{html_options name="prod[{$productionID}]" options=$prodSelector selected=$productionRow.prodLevel}
	</td>
</tr>
{/foreach}
<tr style="height:22px">
	<td>{$LNG.rs_ress_bonus}</td>
	{foreach $bonusProduction as $value}
	<td><span style="color:{if $value > 0}lime{elseif $value < 0}red{else}white{/if}">{$value|number}</span></td>
	{/foreach}
	<td><input value="{$LNG.rs_calculate}" type="submit"></td>
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_storage_capacity}</td>
	{foreach $storage as $value}
	<td><span style="color:lime;">{$value}</span></td>
	{/foreach}
	{for $i=1 to {count($basicProduction) - count($storage)}}<td>-</td>{/for}
	<td>-</td>
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_sum}:</td>
	{foreach $totalProduction as $value}
	<td><span style="color:{if $value > 0}lime{elseif $value < 0}red{else}white{/if}">{$value|number}</span></td>
	{/foreach}
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_daily}</td>
	{foreach $dailyProduction as $value}
		<td><span style="color:{if $value > 0}lime{elseif $value < 0}red{else}white{/if}">{$value|number}</span></td>
	{/foreach}
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_weekly}</td>
	{foreach $weeklyProduction as $value}
		<td><span style="color:{if $value > 0}lime{elseif $value < 0}red{else}white{/if}">{$value|number}</span></td>
	{/foreach}
</tr>
</tbody>
</table>
</form>
{/block}