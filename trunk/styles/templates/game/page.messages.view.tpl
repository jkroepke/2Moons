{block name="content"}
<form action="game.php?page=messages&amp;mode=delete&amp;messcat={$MessID}&amp;ajax=1" method="post">
<table id="messagestable" style="width:760px;">
	<tr>
		<th colspan="4">{$LNG.mg_message_title}</th>
	</tr>
	<tr style="height: 20px;">
		<td class="right" colspan="4">{$LNG.mg_page}: {if $page != 1}<a href="#" onclick="Message.getMessages({$MessID}, {$page - 1});return false;">&laquo;</a>&nbsp;{/if}{for $site=1 to $maxPage}<a href="#" onclick="Message.getMessages({$MessID}, {$site});return false;">{if $site == $page}<b>[{$site}]</b>{else}[{$site}]{/if}</a>{if $site != $maxPage}&nbsp;{/if}{/for}{if $page != $maxPage}&nbsp;<a href="#" onclick="Message.getMessages({$MessID}, {$page + 1});return false;">&raquo;</a>{/if}</td>
	</tr>
	<tr style="height: 20px;">
		<td>{$LNG.mg_action}</td>
		<td>{$LNG.mg_date}</td>
		<td>{if $MessID != 999}{$LNG.mg_from}{else}{$LNG.mg_to}{/if}</td>
		<td>{$LNG.mg_subject}</td>
	</tr>
	{foreach $MessageList as $Message}
	<tr id="message_{$Message.id}" class="message_head{if $MessID != 999 && $Message.unread == 1} mes_unread{/if}">
		<td style="width:40px;" rowspan="2">
		{if $MessID != 999}<input name="delmes[{$Message.id}]" type="checkbox">{/if}
		</td>
		<td>{$Message.time}</td>
		<td>{$Message.from}</td>
		<td>{$Message.subject}
		{if $Message.type == 1 && $MessID != 999}
		<a href="#" onclick="return Dialog.PM({$Message.sender}, Message.CreateAnswer('{$Message.subject}'));" title="{$LNG.mg_answer_to} {strip_tags($Message.from)}"><img src="{$dpath}img/m.gif" border="0"></a>
		{/if}
		</td>
	</tr>
	<tr class="messages_body">
		<td colspan="3" class="left">
		{$Message.text}
		</td>
	</tr>
	{/foreach}
	<tr style="height: 20px;">
		<td class="right" colspan="4">{$LNG.mg_page}: {if $page != 1}<a href="#" onclick="Message.getMessages({$MessID}, 1);return false;">&laquo;</a>&nbsp;{/if}{for $site=1 to $maxPage}<a href="#" onclick="Message.getMessages({$MessID}, {$site});return false;">{if $site == $page}<b>[{$site}]</b>{else}[{$site}]{/if}</a>{if $site != $maxPage}&nbsp;{/if}{/for}{if $page != $maxPage}&nbsp;<a href="#" onclick="Message.getMessages({$MessID}, {$maxPage});return false;">&raquo;</a>{/if}</td>
	</tr>
	{if $MessID != 999}
	<tr>
		<td colspan="4">
			<select name="deletemessages">
				<option value="deletemarked">{$LNG.mg_delete_marked}</option>
				<option value="deleteunmarked">{$LNG.mg_delete_unmarked}</option>
				<option value="deletetypeall">{$LNG.mg_delete_type_all}</option>
				<option value="deleteall">{$LNG.mg_delete_all}</option>
			</select>
			<input value="{$LNG.mg_confirm_delete}" type="submit">
		</td>
	</tr>
	{/if}
</table>
</form>
{/block}