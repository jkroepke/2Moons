{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content">
<table width="569" align="center">
<tbody>
<tr>
    <td colspan="4" class="c"><b>{$tkb_top}</b></td>
</tr><tr>
    <th colspan="4">
        <font color="orange">{$tkb_gratz}</font>
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
    <th><a href="javascript:f('?page=topkb&amp;mode=showkb&amp;rid={$RowInfo.rid}', '');">
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
<th colspan="4">{$tkb_legende}<font style="color:#00FF00">{$tkb_gewinner}</font><font style="color:#FF0000">{$tkb_verlierer}</font></tr></th>
</tbody>
</table>
</div>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}