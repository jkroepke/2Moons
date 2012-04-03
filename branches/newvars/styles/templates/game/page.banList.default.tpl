{block name="title" prepend}{$LNG.lm_banned}{/block}
{block name="content"}
<table style="width:760px;">
	<tr>
		<th colspan="5">{$LNG.bn_players_banned_list}</th>
	</tr>
	<tr>
		<td>{$LNG.bn_from}</td>
		<td>{$LNG.bn_until}</td>
		<td>{$LNG.bn_player}</td>
		<td>{$LNG.bn_by}</td>
		<td>{$LNG.bn_reason}</td>
	</tr>
	{if $banCount}
	<tr>
		<td class="right" colspan="5">{$LNG.mg_page}: {if $page != 1}<a href="game.php?page=banList&amp;side={$page - 1}">&laquo;</a>&nbsp;{/if}{for $site=1 to $maxPage}<a href="game.php?page=banList&amp;side={$site}">{if $site == $page}<b>[{$site}]</b>{else}[{$site}]{/if}</a>{if $site != $maxPage}&nbsp;{/if}{/for}{if $page != $maxPage}&nbsp;<a href="game.php?page=banList&amp;side={$page + 1}">&raquo;</a>{/if}</td>
	</tr>
	{foreach $banList as $banRow}
	<tr>
		<td>{$banRow.from}</td>
		<td>{$banRow.to}</td>
		<td>{$banRow.player}</td>
		<td><a href="mailto:{$banRow.mail}" title="{$banRow.info}">{$banRow.admin}</a></td>
		<td>{$banRow.theme}</td>
	</tr>
	{/foreach}
	<tr>
		<td class="right" colspan="5">{$LNG.mg_page}: {if $page != 1}<a href="game.php?page=banList&amp;side={$page - 1}">&laquo;</a>&nbsp;{/if}{for $site=1 to $maxPage}<a href="game.php?page=banList&amp;side={$site}">{if $site == $page}<b>[{$site}]</b>{else}[{$site}]{/if}</a>{if $site != $maxPage}&nbsp;{/if}{/for}{if $page != $maxPage}&nbsp;<a href="game.php?page=banList&amp;side={$page + 1}">&raquo;</a>{/if}</td>
	</tr>
	<tr>
		<td colspan="5">{$LNG.bn_exists}{$banCount|number}{$LNG.bn_players_banned}</td>
	</tr>
	{else}
	<tr>
		<td colspan="5">{$LNG.bn_no_players_banned}</td>
	</tr>	
	{/if}
</table>
{/block}