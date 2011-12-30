{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
    <form action="?page=resources" method="post">
	<input type="hidden" name="send" value="1">
    <table style="width:50%" align="center">
    <tbody>
    <tr>
        <th colspan="5">{$header}</th>
    </tr>
	<tr style="height:22px">
        <td style="width:40%">&nbsp;</td>
        <td style="width:10%">{lang}tech.901{/lang}</td>
        <td style="width:10%">{lang}tech.902{/lang}</td>
        <td style="width:10%">{lang}tech.903{/lang}</td>
        <td style="width:10%">{lang}tech.911{/lang}</td>
    </tr>
	<tr style="height:22px">
        <td>{lang}rs_basic_income{/lang}</td>
        <td>{$basicProduction.901|number}</td>
        <td>{$basicProduction.902|number}</td>
        <td>{$basicProduction.903|number}</td>
        <td>{$basicProduction.911|number}</td>
    </tr>
    {foreach $productionList as $productionRow}
	<tr style="height:22px">
		<td>{lang}tech.{$productionRow.elementID}{/lang} ({lang}{if $productionRow.elementID > 200}rs_amount{else}rs_lvl{/if}{/lang} {$productionRow.elementLevel})</td>
		<td><span style="color:{if $productionRow.production.901 > 0}lime{elseif $productionRow.production.901 < 0}red{else}white{/if}">{$productionRow.production.901|number}</span></td>
		<td><span style="color:{if $productionRow.production.902 > 0}lime{elseif $productionRow.production.902 < 0}red{else}white{/if}">{$productionRow.production.902|number}</span></td>
		<td><span style="color:{if $productionRow.production.903 > 0}lime{elseif $productionRow.production.903 < 0}red{else}white{/if}">{$productionRow.production.903|number}</span></td>
		<td><span style="color:{if $productionRow.production.911 > 0}lime{elseif $productionRow.production.911 < 0}red{else}white{/if}">{$productionRow.production.911|number}</span></td>
		<td style="width:10%">
			{html_options name='prod[$ressourceID]' options=$prodSelector selected=$productionRow.prodLevel}
		</td>
	</tr>
    {/foreach}
    <tr style="height:22px">
        <td>{lang}rs_ress_bonus{/lang}</td>
		<td><span style="color:{if $bonusProduction.901 > 0}lime{elseif $bonusProduction.901 < 0}red{else}white{/if}">{$bonusProduction.901|number}</span></td>
		<td><span style="color:{if $bonusProduction.902 > 0}lime{elseif $bonusProduction.902 < 0}red{else}white{/if}">{$bonusProduction.902|number}</span></td>
		<td><span style="color:{if $bonusProduction.903 > 0}lime{elseif $bonusProduction.903 < 0}red{else}white{/if}">{$bonusProduction.903|number}</span></td>
		<td><span style="color:{if $bonusProduction.911 > 0}lime{elseif $bonusProduction.911 < 0}red{else}white{/if}">{$bonusProduction.911|number}</span></td>
        <td><input name="action" value="{lang}rs_calculate{/lang}" type="submit"></td>
    </tr>
	<tr style="height:22px">
        <td>{lang}rs_storage_capacity{/lang}</td>
        <td><span style="color:lime;">{$storage.901}</span></td>
        <td><span style="color:lime;">{$storage.902}</span></td>
        <td><span style="color:lime;">{$storage.903}</span></td>
        <td>-</td>
    </tr>
	<tr style="height:22px">
        <td>{lang}rs_sum{/lang}:</td>
		<td><span style="color:{if $totalProduction.901 > 0}lime{elseif $totalProduction.901 < 0}red{else}white{/if}">{$totalProduction.901|number}</span></td>
		<td><span style="color:{if $totalProduction.902 > 0}lime{elseif $totalProduction.902 < 0}red{else}white{/if}">{$totalProduction.902|number}</span></td>
		<td><span style="color:{if $totalProduction.903 > 0}lime{elseif $totalProduction.903 < 0}red{else}white{/if}">{$totalProduction.903|number}</span></td>
		<td><span style="color:{if $totalProduction.911 > 0}lime{elseif $totalProduction.911 < 0}red{else}white{/if}">{$totalProduction.911|number}</span></td>
    </tr>
    <tr style="height:22px">
        <td>{lang}rs_daily{/lang}</td>
		<td><span style="color:{if $dailyProduction.901 > 0}lime{elseif $dailyProduction.901 < 0}red{else}white{/if}">{$dailyProduction.901|number}</span></td>
		<td><span style="color:{if $dailyProduction.902 > 0}lime{elseif $dailyProduction.902 < 0}red{else}white{/if}">{$dailyProduction.902|number}</span></td>
		<td><span style="color:{if $dailyProduction.903 > 0}lime{elseif $dailyProduction.903 < 0}red{else}white{/if}">{$dailyProduction.903|number}</span></td>
		<td><span style="color:{if $dailyProduction.911 > 0}lime{elseif $dailyProduction.911 < 0}red{else}white{/if}">{$dailyProduction.911|number}</span></td>
    </tr>
    <tr style="height:22px">
        <td>{lang}rs_weekly{/lang}</td>
		<td><span style="color:{if $weeklyProduction.901 > 0}lime{elseif $weeklyProduction.901 < 0}red{else}white{/if}">{$weeklyProduction.901|number}</span></td>
		<td><span style="color:{if $weeklyProduction.902 > 0}lime{elseif $weeklyProduction.902 < 0}red{else}white{/if}">{$weeklyProduction.902|number}</span></td>
		<td><span style="color:{if $weeklyProduction.903 > 0}lime{elseif $weeklyProduction.903 < 0}red{else}white{/if}">{$weeklyProduction.903|number}</span></td>
		<td><span style="color:{if $weeklyProduction.911 > 0}lime{elseif $weeklyProduction.911 < 0}red{else}white{/if}">{$weeklyProduction.911|number}</span></td>
    </tr>
    </tbody>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}