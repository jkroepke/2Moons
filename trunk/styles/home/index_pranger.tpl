<select onchange="Dialog.standart('{$menu_pranger}','pranger', parseInt($(this).val()))">
{html_options options=$AvailableUnis selected=$UNI}</select>
<br>
	<table style="width:100%;text-align:center;padding-top:3px;">
	<tr>
        <td style="width:20%;">{$bn_player}</td>
        <td style="width:20%;">{$bn_reason}</td>
        <td style="width:20%;">{$bn_from}</td>
        <td style="width:20%;">{$bn_until}</td>
        <td style="width:20%;">{$bn_by}</td>
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