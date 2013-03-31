{block name="title" prepend}{$LNG.lm_faq}{/block}
{block name="content"}
<table>
	<tr>
		<th>{$LNG.faq_overview}</th>
	</tr>
	<tr>
		<td class="left">{foreach $LNG.questions as $categoryID => $categoryRow}<h2>{$categoryRow.category}</h2>
		<ul>
		{foreach $categoryRow as $questionID => $questionRow}
		{if is_numeric($questionID)}
			<li><a href="game.php?page=questions&amp;mode=single&amp;categoryID={$categoryID}&amp;questionID={$questionID}">{$questionRow.title}</a></li>
		{/if}
		{/foreach}
		</ul>
		{/foreach}</td>
	</tr>
</table>
{/block}



	{*{foreach $LNG.questions as $categoryID => $categoryRow}
	<tr>
		<th>{$categoryRow.category}</th>
	</tr>
	{foreach $categoryRow as $questionID => $questionRow}
	{if is_numeric($questionID)}
	<tr>
		<th>{$questionRow.title}</th>
	</tr>
	<tr>
		<td class="left">
		{$questionRow.body}
	</tr>
	{/if}
	{/foreach}
	{/foreach}*}