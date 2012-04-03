{block name="title" prepend}{$LNG.lm_faq}{/block}
{block name="content"}
<table>
	<tr>
		<th>{$LNG.faq_overview}</th>
	</tr>
	<tr>
		<th>{$questionRow.title}</th>
	</tr>
	<tr>
		<td class="left">
		{$questionRow.body}
		</td>
	</tr>
	<tr><th><a href="game.php?page=questions">{$LNG.al_back}</a></th>
	</tr>
</table>
{/block}