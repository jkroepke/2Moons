{include file="overall_header.tpl"}
<form action="admin.php?page=support&mode=send" method="post" id="form">
<input type="hidden" name="id" value="{$ticketID}">
<table width="70%" cellpadding="2" cellspacing="2">
	{foreach $answerList as $answerID => $answerRow}	
	{if $answerRow@first}
	<tr>
		<th colspan="2"><a href="admin.php?page=support">{$LNG.ti_overview}</a></th>
	</tr>
	<tr>
		<th colspan="2">{$LNG.ti_read} :: {$answerRow.subject}</th>
	</tr>
	{/if}
	<tr>
		<td class="left" colspan="2">
			<p>{if !$answerRow@first}
				<b>{$LNG.ti_subject}: {$answerRow.subject}</b><br>
			{$LNG.ti_responded}: <b>{$answerRow.time}</b> {$LNG.ti_from} <b>{$answerRow.ownerName}</b>
			{/if}
			{if $answerRow@first}
			{$LNG.ti_create}: <b>{$answerRow.time}</b> {$LNG.ti_from} <b>{$answerRow.ownerName}</b>
				<br>{$LNG.ti_category}: {$categoryList[$answerRow.categoryID]}
			{/if}
			</p>
			<hr>
			<p>
				{$answerRow.message}
			</p>
		</td>
	</tr>
	{/foreach}
	<tr>
		<th colspan="2">{$LNG.ti_answer}</th>
	</tr>
	<tr>
		<td style="width:30%"><label for="message">{$LNG.ti_message}</label></td>
		<td style="width:70%"><textarea class="validate[required]" id="message" name="message" row="60" cols="8" style="height:100px;"></textarea></td>
	</tr>
	<tr>
		<td style="width:30%">{if $ticket_status < 2}{$LNG.ti_close}{else}{$LNG.ti_open}{/if}</td>
		<td style="width:70%"><input type="checkbox" name="change_status"></td>
	</tr>	
	<tr>
		<td colspan="2"><input type="submit" value="{$LNG.ti_submit}" onclick="parent.rightFrame.document.location.reload();"></td>
	</tr>
</table>
</form>
{include file="overall_footer.tpl"}