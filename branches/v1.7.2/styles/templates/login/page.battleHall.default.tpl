{block name="title" prepend}{$LNG.siteTitleBattleHall}{/block}
{block name="content"}
{if $isMultiUniverse}<p>
{html_options options=$universeSelect selected=$UNI class="changeUni" id="universe" name="universe"}
</p>{/if}
<table>
<tr>
	<th style="color:lime">{$LNG.tkb_platz}</th>
	<th style="color:lime">{$LNG.tkb_owners}</th>
	<th style="color:lime">{$LNG.tkb_datum}</th>
	<th style="color:lime">{$LNG.tkb_units}</th>
</tr>
{foreach $hallList as $hallRow}
<tr>
	<td>{$hallRow@iteration}</td>
	<td>
	{if $hallRow.result == "a"}
	<span style="color:#00FF00">{$hallRow.attacker}</span><span style="color:#FFFFFF"><b> VS </b></span><span style="color:#FF0000">{$hallRow.defender}</span>
	{elseif $hallRow.result == "r"}
	<span style="color:#FF0000">{$hallRow.attacker}</span><span style="color:#FFFFFF"><b> VS </b></span><span style="color:#00FF00">{$hallRow.defender}</span>
	{else}
	{$hallRow.attacker}<b> VS </b>{$hallRow.defender}
	{/if}
	</td>
	<td>{$hallRow.time}</td>
	<td>{$hallRow.units|number}</td>
</tr>
{/foreach}
<tr>
<td colspan="4"><p>{$LNG.tkb_legende}<span style="color:#00FF00">{$LNG.tkb_gewinner}</span><span style="color:#FF0000">{$LNG.tkb_verlierer}</span></p></td>
</tr>
</table>
{/block}