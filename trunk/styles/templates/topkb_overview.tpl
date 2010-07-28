{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table width="569" align="center">
<tbody>
<tr>
    <td colspan="4" class="c"><b>{$tkb_top}</b></td>
</tr><tr>
    <th colspan="4">
        <font color="#E75B12">{$tkb_gratz}</font>
    </th>
</tr><tr>
    <th><font color="lime">{$tkb_platz}</font></th>
	<th><font color="lime">{$tkb_owners}</font></th>
    <th><font color="lime">{$tkb_datum}</font></th>
	<th><font color="lime">{$tkb_units}</font></th>
</tr>
{foreach item=RowInfo key=RowNR from=$TopKBList}
<tr>
    <th>{$RowNR + 1}</th>
    <th><a href="game.php?page=topkb&action=showkb&rid={$RowInfo.rid}" onclick="topkb('{$RowInfo.rid}');return false">
	{if $RowInfo.result == "a"}
	<font style="color:#00FF00">{$RowInfo.attacker}</font><b> VS </b><font style="color:#FF0000">{$RowInfo.defender}</font>
	{elseif $RowInfo.result == "r"}
	<font style="color:#FF0000">{$RowInfo.attacker}</font><b> VS </b><font style="color:#00FF00">{$RowInfo.defender}</font>
	{else}
	{$RowInfo.attacker}<b> VS </b>{$RowInfo.defender}
	{/if}
	</a></th>
    <th>{$RowInfo.time}</th>
	<th>{$RowInfo.units}</th>
</tr>
{/foreach}
<tr>
<th colspan="4">{$tkb_legende}<font style="color:#00FF00">{$tkb_gewinner}</font><font style="color:#FF0000">{$tkb_verlierer}</font></th></tr>
</tbody>
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}