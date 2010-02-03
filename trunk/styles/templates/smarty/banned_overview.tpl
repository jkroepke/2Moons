{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content">
    <table width="600" align="center">
    <tr>
        <td class="c" colspan="6">{$bn_players_banned_list}</td>
    </tr><tr>
        <th>{$bn_player}</th>
        <th>{$bn_reason}</th>
        <th>{$bn_from}</th>
        <th>{$bn_until}</th>
        <th>{$bn_by}</th>
    </tr>
	{foreach item=PlayerInfo from=$PrangerList name=Pranger}
	<tr>
		<th><center><b>{$PlayerInfo.player}</b></center></th>
		<th><center><b>{$PlayerInfo.theme}</b></center></th>
		<th><center><b>{$PlayerInfo.from}</b></center></th>
		<th><center><b>{$PlayerInfo.to}</b></center></th>
		<th><center><b><a href="mailto:{$PlayerInfo.mail}" title="{$PlayerInfo.info}">{$PlayerInfo.admin}</a></b></center></th>
	</tr>
	{/foreach}
	<tr><th colspan="5">{if {$smarty.foreach.Pranger.total} == 0}{$bn_no_players_banned}{else}{$bn_exists}{$smarty.foreach.Pranger.total}{$bn_players_banned}{/if}</th></tr>
    </table>
</div>

{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}