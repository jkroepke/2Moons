{extends file="index.tpl"}
{block name="title" prepend}{$menu_top100}{/block}
{block name="content"}
<select onchange="changeUni($(this).val());">{html_options options=$AvailableUnis selected=$UNI}</select><br>
<table>
<tr>
	<th style="color:lime">{$tkb_platz}</th>
	<th style="color:lime">{$tkb_owners}</th>
	<th style="color:lime">{$tkb_datum}</th>
	<th style="color:lime">{$tkb_units}</th>
</tr>
{foreach item=RowInfo key=RowNR from=$TopKBList}
<tr>
	<td>{$RowNR + 1}</td>
	<td>
	{if $RowInfo.result == "a"}
	<span style="color:#00FF00">{$RowInfo.attacker}</span><span style="color:#FFFFFF"><b> VS </b></span><span style="color:#FF0000">{$RowInfo.defender}</span>
	{elseif $RowInfo.result == "r"}
	<span style="color:#FF0000">{$RowInfo.attacker}</span><span style="color:#FFFFFF"><b> VS </b></span><span style="color:#00FF00">{$RowInfo.defender}</span>
	{else}
	{$RowInfo.attacker}<b> VS </b>{$RowInfo.defender}
	{/if}
	</td>
	<td>{$RowInfo.time}</td>
	<td>{$RowInfo.units}</td>
</tr>
{/foreach}
<tr>
<td colspan="4">{$tkb_legende}<span style="color:#00FF00">{$tkb_gewinner}</span><span style="color:#FF0000">{$tkb_verlierer}</span></td>
</tr>
</table>
{/block}