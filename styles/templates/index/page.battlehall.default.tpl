{block name="title" prepend}{$LNG.menu_battlehall}{/block}
{block name="content"}
<select onchange="changeUni($(this).val());">{html_options options=$AvailableUnis selected=$UNI}</select><br>
<table>
<tr>
	<th style="color:lime">{$LNG.tkb_platz}</th>
	<th style="color:lime">{$LNG.tkb_owners}</th>
	<th style="color:lime">{$LNG.tkb_datum}</th>
	<th style="color:lime">{$LNG.tkb_units}</th>
</tr>
{foreach $battlehallList as $battlehallRow}
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
<td colspan="4"><p>{$LNG.tkb_legende}<span style="color:#00FF00">{$LNG.tkb_gewinner}</span><span style="color:#FF0000">{$LNG.tkb_verlierer}</span></p></td>
</tr>
</table>
{/block}