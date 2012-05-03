{block name="title" prepend}{$LNG.lm_alliance}{/block}
{block name="content"}
<table class="table519">
	<tr>
		<th colspan="2">{$LNG.al_request_list}</th>
	</tr>
	<tr>
		<th>{$LNG.al_candidate}</th>
		<th>{$LNG.al_request_date}</th>
	</tr>
	{foreach $applyList as $applyRow}
	<tr>
		<td><a href="game.php?page=alliance&amp;mode=admin&amp;action=detailApply&amp;id={$applyRow.id}">{$applyRow.username}</a></td>
		<td><a href="game.php?page=alliance&amp;mode=admin&amp;action=detailApply&amp;id={$applyRow.id}">{$applyRow.time}</a></td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="2">{$LNG.al_no_requests}</td>
	</tr>
	{/foreach}
	<tr>
		<th colspan="2"><a href="game.php?page=alliance">{$LNG.al_back}</a></th>
	</tr>
</table>
{/block}