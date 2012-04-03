{block name="title" prepend}{$LNG.lm_research}{/block}
{block name="content"}
<form action="game.php?page=alliance&amp;mode=cancelApply" method="post">
	<table class="table519">
	<tr>
		<th>{$LNG.al_your_request_title}</th>
	</tr>
	<tr>
		<td>{$request_text}</td>
	</tr>
	<tr>
		<td><input type="submit" value="{$LNG.al_continue}"></td>
	</tr>
</table>
</form>
{/block}