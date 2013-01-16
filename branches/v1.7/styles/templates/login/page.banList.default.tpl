{block name="title" prepend}{$LNG.siteTitleBanList}{/block}
{block name="content"}
{if $isMultiUniverse}<p>
{html_options options=$universeSelect selected=$UNI class="changeUni" id="universe" name="universe"}
</p>{/if}
<table>
	<tr>
		<th colspan="5">{$LNG.bn_players_banned_list}</th>
	</tr>
{if $banCount}
	<tr>
		<td style="text-align:right;" colspan="5">{$LNG.mg_page}: {if $page != 1}<a href="index.php?page=banList&amp;side={$page - 1}">&laquo;</a>&nbsp;{/if}{for $site=1 to $maxPage}<a href="index.php?page=banList&amp;side={$site}">{if $site == $page}<b>[{$site}]</b>{else}[{$site}]{/if}</a>{if $site != $maxPage}&nbsp;{/if}{/for}{if $page != $maxPage}&nbsp;<a href="index.php?page=banList&amp;side={$page + 1}">&raquo;</a>{/if}</td>
	</tr>
{/if}
	<tr>
		<td>{$LNG.bn_from}</td>
		<td>{$LNG.bn_until}</td>
		<td>{$LNG.bn_player}</td>
		<td>{$LNG.bn_by}</td>
		<td>{$LNG.bn_reason}</td>
	</tr>
{if $banCount}
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
		<td style="text-align:right;" colspan="5">{$LNG.mg_page}: {if $page != 1}<a href="index.php?page=banList&amp;side={$page - 1}">&laquo;</a>&nbsp;{/if}{for $site=1 to $maxPage}<a href="index.php?page=banList&amp;side={$site}">{if $site == $page}<b>[{$site}]</b>{else}[{$site}]{/if}</a>{if $site != $maxPage}&nbsp;{/if}{/for}{if $page != $maxPage}&nbsp;<a href="index.php?page=banList&amp;side={$page + 1}">&raquo;</a>{/if}</td>
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