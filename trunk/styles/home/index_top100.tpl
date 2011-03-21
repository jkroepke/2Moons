<select onchange="ajax('?page=top100&amp;'+'getajax=1&amp;'+'lang={$lang}&amp;'+'universe='+$(this).val());">{html_options options=$AvailableUnis selected=$UNI}</select><br>
<table style="width:100%;text-align:center;padding-top:3px;">
<tbody>
<tr>
	<td colspan="4">
		<span style="color:#E75B12">{$tkb_gratz}</span>
	</td>
</tr><tr>
	<td><span style="color:lime">{$tkb_platz}</span></td>
	<td><span style="color:lime">{$tkb_owners}</span></td>
	<td><span style="color:lime">{$tkb_datum}</span></td>
	<td><span style="color:lime">{$tkb_units}</span></td>
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
</tbody>
</table>