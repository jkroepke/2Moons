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
    <td style="width:10%"><a class='tooltip_sticky' data-tooltip-content="<table><tr><th><a href='#' onclick='return Dialog.info(901)'>{$LNG.tech.901}</a></th></tr><tr><table class='hoverinfo'><tr><td><img src='{$dpath}gebaeude/901.gif'></td><td>{$LNG.shortDescription.901}</td></tr></table></tr></table>">{$LNG.tech.901}</a></td>
    <td style="width:10%"><a class='tooltip_sticky' data-tooltip-content="<table><tr><th><a href='#' onclick='return Dialog.info(902)'>{$LNG.tech.902}</a></th></tr><tr><table class='hoverinfo'><tr><td><img src='{$dpath}gebaeude/902.gif'></td><td>{$LNG.shortDescription.902}</td></tr></table></tr></table>">{$LNG.tech.902}</a></td>
    <td style="width:10%"><a class='tooltip_sticky' data-tooltip-content="<table><tr><th><a href='#' onclick='return Dialog.info(903)'>{$LNG.tech.903}</a></th></tr><tr><table class='hoverinfo'><tr><td><img src='{$dpath}gebaeude/903.gif'></td><td>{$LNG.shortDescription.903}</td></tr></table></tr></table>">{$LNG.tech.903}</a></td>
    <td style="width:10%"><a class='tooltip_sticky' data-tooltip-content="<table><tr><th><a href='#' onclick='return Dialog.info(911)'>{$LNG.tech.911}</a></th></tr><tr><table class='hoverinfo'><tr><td><img src='{$dpath}gebaeude/911.gif'></td><td>{$LNG.shortDescription.911}</td></tr></table></tr></table>">{$LNG.tech.911}</a></td>
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_basic_income}</td>
	<td>{$basicProduction.901|number}</td>
	<td>{$basicProduction.902|number}</td>
	<td>{$basicProduction.903|number}</td>
	<td>{$basicProduction.911|number}</td>
</tr>
{foreach $productionList as $productionID => $productionRow}
<tr style="height:22px">
	<td><a class='tooltip_sticky' data-tooltip-content="<table><tr><th><a href='#' onclick='return Dialog.info({$productionID});'>{$LNG.tech.{$productionID}}</a></th></tr><tr><table class='hoverinfo'><tr><td><img src='{$dpath}gebaeude/{$productionID}.{if $productionID >=600 && $productionID <= 699}jpg{else}gif{/if}'></td><td>{$LNG.shortDescription.{$productionID}}</td></tr></table></tr></table>">{$LNG.tech.$productionID }</a> ({if $productionID  > 200}{$LNG.rs_amount}{else}{$LNG.rs_lvl}{/if} {$productionRow.elementLevel})</td>
	<td><span style="color:{if $productionRow.production.901 > 0}lime{elseif $productionRow.production.901 < 0}red{else}white{/if}">{$productionRow.production.901|number}</span></td>
	<td><span style="color:{if $productionRow.production.902 > 0}lime{elseif $productionRow.production.902 < 0}red{else}white{/if}">{$productionRow.production.902|number}</span></td>
	<td><span style="color:{if $productionRow.production.903 > 0}lime{elseif $productionRow.production.903 < 0}red{else}white{/if}">{$productionRow.production.903|number}</span></td>
	<td><span style="color:{if $productionRow.production.911 > 0}lime{elseif $productionRow.production.911 < 0}red{else}white{/if}">{$productionRow.production.911|number}</span></td>
	<td style="width:10%">
		{html_options name="prod[{$productionID}]" options=$prodSelector selected=$productionRow.prodLevel}
	</td>
</tr>
{/foreach}
<tr style="height:22px">
	<td>{$LNG.rs_ress_bonus}</td>
	<td><span style="color:{if $bonusProduction.901 > 0}lime{elseif $bonusProduction.901 < 0}red{else}white{/if}">{$bonusProduction.901|number}</span></td>
	<td><span style="color:{if $bonusProduction.902 > 0}lime{elseif $bonusProduction.902 < 0}red{else}white{/if}">{$bonusProduction.902|number}</span></td>
	<td><span style="color:{if $bonusProduction.903 > 0}lime{elseif $bonusProduction.903 < 0}red{else}white{/if}">{$bonusProduction.903|number}</span></td>
	<td><span style="color:{if $bonusProduction.911 > 0}lime{elseif $bonusProduction.911 < 0}red{else}white{/if}">{$bonusProduction.911|number}</span></td>
	<td><input value="{$LNG.rs_calculate}" type="submit"></td>
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_storage_capacity}</td>
	<td><span style="color:lime;">{$storage.901}</span></td>
	<td><span style="color:lime;">{$storage.902}</span></td>
	<td><span style="color:lime;">{$storage.903}</span></td>
	<td>-</td>
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_sum}:</td>
	<td><span style="color:{if $totalProduction.901 > 0}lime{elseif $totalProduction.901 < 0}red{else}white{/if}">{$totalProduction.901|number}</span></td>
	<td><span style="color:{if $totalProduction.902 > 0}lime{elseif $totalProduction.902 < 0}red{else}white{/if}">{$totalProduction.902|number}</span></td>
	<td><span style="color:{if $totalProduction.903 > 0}lime{elseif $totalProduction.903 < 0}red{else}white{/if}">{$totalProduction.903|number}</span></td>
	<td><span style="color:{if $totalProduction.911 > 0}lime{elseif $totalProduction.911 < 0}red{else}white{/if}">{$totalProduction.911|number}</span></td>
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_daily}</td>
	<td><span style="color:{if $dailyProduction.901 > 0}lime{elseif $dailyProduction.901 < 0}red{else}white{/if}">{$dailyProduction.901|number}</span></td>
	<td><span style="color:{if $dailyProduction.902 > 0}lime{elseif $dailyProduction.902 < 0}red{else}white{/if}">{$dailyProduction.902|number}</span></td>
	<td><span style="color:{if $dailyProduction.903 > 0}lime{elseif $dailyProduction.903 < 0}red{else}white{/if}">{$dailyProduction.903|number}</span></td>
	<td><span style="color:{if $dailyProduction.911 > 0}lime{elseif $dailyProduction.911 < 0}red{else}white{/if}">{$dailyProduction.911|number}</span></td>
</tr>
<tr style="height:22px">
	<td>{$LNG.rs_weekly}</td>
	<td><span style="color:{if $weeklyProduction.901 > 0}lime{elseif $weeklyProduction.901 < 0}red{else}white{/if}">{$weeklyProduction.901|number}</span></td>
	<td><span style="color:{if $weeklyProduction.902 > 0}lime{elseif $weeklyProduction.902 < 0}red{else}white{/if}">{$weeklyProduction.902|number}</span></td>
	<td><span style="color:{if $weeklyProduction.903 > 0}lime{elseif $weeklyProduction.903 < 0}red{else}white{/if}">{$weeklyProduction.903|number}</span></td>
	<td><span style="color:{if $weeklyProduction.911 > 0}lime{elseif $weeklyProduction.911 < 0}red{else}white{/if}">{$weeklyProduction.911|number}</span></td>
</tr>
</tbody>
</table>
</form>
{/block}
