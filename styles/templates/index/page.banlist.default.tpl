{extends file="index.tpl"}
{block name="title" prepend}{$LNG.menu_banlist}{/block}
{block name="content"}
<select onchange="changeUni($(this).val())">
{html_options options=$AvailableUnis selected=$UNI}</select>
<br>
<table>
<tr>
	<th style="width:20%;">{$LNG.bn_player}</th>
	<th style="width:20%;">{$LNG.bn_reason}</th>
	<th style="width:20%;">{$LNG.bn_from}</th>
	<th style="width:20%;">{$LNG.bn_until}</th>
	<th style="width:20%;">{$LNG.bn_by}</th>
</tr>
<tr><td colspan="5"><br></td></tr>
{foreach $banList as $banRow}
<tr>
	<td style="width:20%;">{$PlayerInfo.player}</td>
	<td style="width:20%;">{$PlayerInfo.theme}</td>
	<td style="width:20%;">{$PlayerInfo.from}</td>
	<td style="width:20%;">{$PlayerInfo.to}</td>
	<td style="width:20%;"><a href="mailto:{$PlayerInfo.mail}" title="{$PlayerInfo.info}">{$PlayerInfo.admin}</a></td>
</tr>
{if $banRow@last}
<tr>
	<td colspan="5">{$LNG.bn_exists}{$banRow@total}{$LNG.bn_players_banned}</td
</tr>
{/if}
{foreachelse}
<tr>
	<td colspan="5">{$LNG.bn_no_players_banned}</td>
</tr>
{/foreach}
</table>
{/block}