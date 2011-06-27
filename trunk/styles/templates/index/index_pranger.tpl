{extends file="index.tpl"}
{block name="title" prepend}{$menu_pranger}{/block}
{block name="content"}
<select onchange="changeUni($(this).val())">
{html_options options=$AvailableUnis selected=$UNI}</select>
<br>
<table>
<tr>
	<th style="width:20%;">{$bn_player}</th>
	<th style="width:20%;">{$bn_reason}</th>
	<th style="width:20%;">{$bn_from}</th>
	<th style="width:20%;">{$bn_until}</th>
	<th style="width:20%;">{$bn_by}</th>
</tr>
<tr><td colspan="5"><br></td></tr>
{foreach item=PlayerInfo from=$PrangerList name=Pranger}
<tr>
	<td style="width:20%;">{$PlayerInfo.player}</td>
	<td style="width:20%;">{$PlayerInfo.theme}</td>
	<td style="width:20%;">{$PlayerInfo.from}</td>
	<td style="width:20%;">{$PlayerInfo.to}</td>
	<td style="width:20%;"><a href="mailto:{$PlayerInfo.mail}" title="{$PlayerInfo.info}">{$PlayerInfo.admin}</a></td>
</tr>
{/foreach}
<tr><td colspan="5"><br>{if {$smarty.foreach.Pranger.total} == 0}{$bn_no_players_banned}{else}{$bn_exists}{$smarty.foreach.Pranger.total}{$bn_players_banned}{/if}</td></tr>
</table>
{/block}