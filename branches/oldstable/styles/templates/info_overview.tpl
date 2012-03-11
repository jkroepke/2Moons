<div id="info_name" style="display:none;">{$name}</div>
<table>
<tbody><tr>
	<td colspan="2" class="transparent">
	<table>
		<tr>
			<td class="transparent"><img src="./styles/theme/{$dpath}/gebaeude/{$id}.{if $id >=600 && $id <= 699}jpg{else}gif{/if}" alt="{$name}"></td>
			<td class="transparent">{$description}
			{if $RapidFire}
			<br><br>
			{foreach item=RapidFireTo key=RapidFireToName from=$RapidFire.to}
			{$in_rf_again} {$RapidFireToName} <span style="color:#00ff00">{$RapidFireTo}</span><br>
			{/foreach}
			{foreach item=RapidFireFrom key=RapidFireFromName from=$RapidFire.from}
			{$in_rf_from} {$RapidFireFromName} <span style="color:#ff0000">{$RapidFireFrom}</span><br>
			{/foreach}
			{/if}
			</td>
		</tr>
	</table>
	</td>
</tr>
{if $ProductionTable}
<tr>
	<td colspan="2">
		<table>
		<tr>
			<th>{lang}in_level{/lang}</th>
			{if $id != 4}
			<th>{if $id == 12}{lang}in_prod_energy{/lang}{else}{lang}in_prod_p_hour{/lang}{/if}</th>
			<th>{lang}in_difference{/lang}</th>
			{/if}
			<th>{if $id == 12}{lang}in_used_deuter{/lang}{elseif $id == 4}{lang}in_prod_energy{/lang}{else}{lang}in_used_energy{/lang}{/if}</th>
			<th>{lang}in_difference{/lang}</th>
		</tr>
		{foreach $ProductionTable as $elementLevel => $productionRow}
		{if $elementLevel != 0}
		{$production = $productionRow.production}
		{$productionDiff = $production - $ProductionTable[$Level].production}
		{$required = $productionRow.required}
		{$requiredDiff = $required - $ProductionTable[$Level].required}
		<tr>
			<td><span{if $Level == $elementLevel} style="color:#ff0000"{/if}>{$elementLevel}</span></td>
			{if $elementID != 4}
			<td><span style="color:{if $production > 0}lime{elseif $production < 0}red{else}white{/if}">{$production|number}</span></td>
			<td><span style="color:{if $productionDiff > 0}lime{elseif $productionDiff < 0}red{else}white{/if}">{$productionDiff|number}</span></td>
			{/if}
			<td><span style="color:{if $required > 0}lime{elseif $required < 0}red{else}white{/if}">{$required|number}</span></td>
			<td><span style="color:{if $requiredDiff > 0}lime{elseif $requiredDiff < 0}red{else}white{/if}">{$requiredDiff|number}</span></td>
		</tr>
		{/if}
		{/foreach}
		</table>
	</td>
</tr>
{elseif $FleetInfo}
<tr>
<td class="transparent" colspan="2"><hr></td>
</tr>
{foreach key=Name item=content from=$FleetInfo}
<tr>
<td class="transparent" style="width:50%">{$Name}</td>
<td class="transparent" style="width:50%">
{if is_array($content)}{$content.0}{if $content.0 != $content.1} <span style="color:yellow">({$content.1})</span>{/if}{else}{$content}{/if}
{/foreach}
</td></tr>
{elseif $gate_fleets}
{include file="info_gatelist.tpl"}
{elseif $missiles}
<tr>
<td class="transparent" colspan="2"><hr></td>
</tr>
<tr>
<td class="transparent" colspan="2">
	<table>
		<tr>
			<th>{$in_missilestype}</th><th>{$in_missilesamount}</th><th></th>
		</tr>
		<tr>
			<td>{$tech_502}</td><td><span id="missile_502">{$missiles.0}</span></td><td><input class="missile" type="text" name="missile_502"></td>
		</tr>
		<tr>
			<td>{$tech_503}</td><td><span id="missile_503">{$missiles.1}</span></td><td><input class="missile" type="text" name="missile_503"></td>
		</tr>
		<tr>
			<td colspan="3"><input type="button" value="{$in_destroy}" onclick="DestroyMissiles();"></td>
		</tr>
	</table>
</td>
</tr>
{/if}
</tbody>
</table>