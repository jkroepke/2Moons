<form action="game.php?page=messages&amp;mode=delMessages&amp;messcat={$MessID}&amp;ajax=1" method="post">
<table id="messagestable">
	<tr>
		<th colspan="4">{lang}mg_message_title{/lang}</th>
	</tr>
	<tr style="height: 20px;">
		<td>{lang}mg_action{/lang}</td>
		<td>{lang}mg_date{/lang}</td>
		<td>{if $MessID != 999}{lang}mg_from{/lang}{else}{lang}mg_to{/lang}{/if}</td>
		<td>{lang}mg_subject{/lang}</td>
	</tr>
	{foreach $MessageList as $Message}
	<tr id="message_{$Message.id}" class="message_head{if $MessID != 999 && $Message.unread == 1} mes_unread{/if}">
		<td style="width:40px;" rowspan="2">
		{if $MessID != 999}<input name="delmes[{$Message.id}]" type="checkbox">{/if}
		</td>
		<td>{$Message.time}</td>
		<td>{$Message.from}</td>
		<td>{$Message.subject}
		{if $MessID == 1}
		<a href="#" onclick="return Dialog.PM({$Message.sender}, Message.CreateAnswer('{$Message.subject}'));" title="{lang}mg_answer_to{/lang} {strip_tags($Message.from)}"><img src="{$dpath}img/m.gif" border="0"></a>
		{/if}
		</td>
	</tr>
	<tr class="messages_body">
		<td colspan="3" class="left">
		{$Message.text}
		</td>
	</tr>
	{/foreach}
	{if $MessID != 999}
	<tr>
		<td colspan="4">
			<select name="deletemessages">
				<option value="deletemarked">{lang}mg_delete_marked{/lang}</option>
				<option value="deleteunmarked">{lang}mg_delete_unmarked{/lang}</option>
				<option value="deletetypeall">{lang}mg_delete_type_all{/lang}</option>
				<option value="deleteall">{lang}mg_delete_all{/lang}</option>
			</select>
			<input value="{lang}mg_confirm_delete{/lang}" type="submit">
		</td>
	</tr>
	{/if}
</table>
</form>