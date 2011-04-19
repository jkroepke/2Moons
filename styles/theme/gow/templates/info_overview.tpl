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
<td class="transparent" colspan="2"><hr></td>
</tr>
<tr>
	<td colspan="2" class="transparent">
		<table>
		<tr><th>{$in_level}</th>{if $id != 4}<th>{if $id == 12}{$in_prod_energy}{else}{$in_prod_p_hour}{/if}</th><th>{$in_difference}</th>{/if}<th>{if $id == 12}{$in_used_deuter}{elseif $id == 4}{$in_prod_energy}{else}{$in_used_energy}{/if}</th><th>{$in_difference}</th></tr>
		{foreach item=LevelRow from=$ProductionTable}
		<tr><td>{if $Level == $LevelRow.BuildLevel}<span style="color:#ff0000">{$LevelRow.BuildLevel}</span>{else}{$LevelRow.BuildLevel}{/if}</td>{if $id != 4}<td>{$LevelRow.prod}</td><td>{$LevelRow.prod_diff}</td>{/if}<td>{$LevelRow.need}</td><td>{$LevelRow.need_diff}</td></tr>
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