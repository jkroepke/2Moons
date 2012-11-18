{block name="title" prepend}{$LNG.lm_topkb}{/block}
{block name="content"}
<table class="table569">
<tbody>
<tr>
    <th colspan="4">{$LNG.tkb_top}</th>
</tr>
<tr>
    <td colspan="4">{$LNG.tkb_gratz}</td>
</tr>
<tr>
    <td>{$LNG.tkb_platz}</td>
	<td><a href="?page=battleHall&order=owner&sort={if $sort == "ASC"}DESC{else}ASC{/if}"{if $order == "owner"} style="font-weight:bold;"{/if}>{$LNG.tkb_owners}</a></td>
    <td><a href="?page=battleHall&order=date&sort={if $sort == "ASC"}DESC{else}ASC{/if}"{if $order == "date"} style="font-weight:bold;"{/if}>{$LNG.tkb_datum}</a></td>
	<td><a href="?page=battleHall&order=units&sort={if $sort == "ASC"}DESC{else}ASC{/if}"{if $order == "units"} style="font-weight:bold;"{/if}>{$LNG.tkb_units}</a></td>
</tr>
{foreach $TopKBList as $hallCat}
{foreach $hallCat as $rank => $hallRow}
<tr class="day{floor($hallRow.date / 86400)} week{floor($hallRow.date / 604800)}">
    <td>{$rank}</td>
    <td><a href="CombatReport.php?mode=battlehall&amp;raport={$hallRow.rid}" target="_blank">
	{if $hallRow.result == "a"}
	<span style="color:#00FF00">{$hallRow.attacker}</span> VS <span style="color:#FF0000">{$hallRow.defender}</span>
	{elseif $hallRow.result == "r"}
	<span style="color:#FF0000">{$hallRow.attacker}</span> VS <span style="color:#00FF00">{$hallRow.defender}</span>
	{else}
	{$hallRow.attacker} VS {$hallRow.defender}
	{/if}
	</a></td>
    <td>{$hallRow.date}</td>
	<td>{$hallRow.units|number}</td>
</tr>
{/foreach}
{/foreach}
<tr>
<td colspan="4">{$LNG.tkb_legende}<span style="color:#00FF00">{$LNG.tkb_gewinner}</span><span style="color:#FF0000">{$LNG.tkb_verlierer}</span></td></tr>
</tbody>
</table>
{/block}