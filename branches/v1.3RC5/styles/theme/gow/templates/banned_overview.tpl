{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table>
    <tr>
        <th colspan="5">{$bn_players_banned_list}</th>
    </tr><tr>
        <td>{$bn_player}</td>
        <td>{$bn_reason}</td>
        <td>{$bn_from}</td>
        <td>{$bn_until}</td>
        <td>{$bn_by}</td>
    </tr>
	{foreach item=PlayerInfo from=$PrangerList name=Pranger}
	<tr>
		<td><center><b>{$PlayerInfo.player}</b></center></td>
		<td><center><b>{$PlayerInfo.theme}</b></center></td>
		<td><center><b>{$PlayerInfo.from}</b></center></td>
		<td><center><b>{$PlayerInfo.to}</b></center></td>
		<td><center><b><a href="mailto:{$PlayerInfo.mail}" title="{$PlayerInfo.info}">{$PlayerInfo.admin}</a></b></center></td>
	</tr>
	{/foreach}
	<tr><td colspan="5">{if {$smarty.foreach.Pranger.total} == 0}{$bn_no_players_banned}{else}{$bn_exists}{$smarty.foreach.Pranger.total}{$bn_players_banned}{/if}</td></tr>
    </table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}