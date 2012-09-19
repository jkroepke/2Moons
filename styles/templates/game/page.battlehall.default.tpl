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
{foreach item=RowInfo key=RowNR from=$TopKBList}
<tr class="day{floor($RowInfo.date / 86400)} week{floor($RowInfo.date / 604800)}">
    <td>{$RowInfo.rank}</td>
    <td><a href="CombatReport.php?mode=battlehall&amp;raport={$RowInfo.rid}" target="_blank">
	{if $RowInfo.result == "a"}
	<span style="color:#00FF00">{$RowInfo.attacker}</span> VS <span style="color:#FF0000">{$RowInfo.defender}</span>
	{elseif $RowInfo.result == "r"}
	<span style="color:#FF0000">{$RowInfo.attacker}</span> VS <span style="color:#00FF00">{$RowInfo.defender}</span>
	{else}
	{$RowInfo.attacker} VS {$RowInfo.defender}
	{/if}
	</a></td>
    <td>{$RowInfo.date}</td>
	<td>{$RowInfo.units|number}</td>
</tr>
{/foreach}
<tr>
<td colspan="4">{$LNG.tkb_legende}<span style="color:#00FF00">{$LNG.tkb_gewinner}</span><span style="color:#FF0000">{$LNG.tkb_verlierer}</span></td></tr>
</tbody>
</table>
{/block}