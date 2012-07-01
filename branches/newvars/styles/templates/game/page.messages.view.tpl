{block name="content"}
<form action="game.php?page=messages&amp;mode=delete&amp;messcat={$MessID}&amp;ajax=1" method="post">
<table id="messagestable" style="width:760px;" data-category="{$MessID}">
	<tr>
		<th colspan="4">{$LNG.mg_message_title}</th>
	</tr>
	<tr class="highRow">
		<td class="right" colspan="4">{$LNG.mg_page}:&nbsp;{if $maxSite > 1}<a href="#" class="pageLink" data-page="1">&laquo;&laquo;</a>&nbsp;{/if}{if $site > 1}<a href="#" class="pageLink" data-page="{$site - 1}">&laquo;</a>&nbsp;{/if}{for $page=1 to $maxSite}<a href="#" class="pageLink" data-page="{$page}">{if $site == $page}<b>[{$page}]</b>{else}[{$page}]{/if}</a>{if $page != $maxSite}&nbsp;{/if}{/for}{if $site < $maxSite}&nbsp;<a href="#" class="pageLink" data-page="{$site + 1}">&raquo;</a>{/if}{if $maxSite > 1}&nbsp;<a href="#" class="pageLink" data-page="{$maxPage}">&raquo;&raquo;</a>{/if}</td>
	</tr>
	<tr class="highRow">
		<td style="width:48px;">{$LNG.mg_action}</td>
		<td style="width:295px;">{$LNG.mg_date}</td>
		<td style="width:205px;">{if $MessID != 999}{$LNG.mg_from}{else}{$LNG.mg_to}{/if}</td>
		<td style="width:202px;">{$LNG.mg_subject}</td>
	</tr>
	{foreach $MessageList as $Message}
	<tr id="message_{$Message.id}" class="message_head{if $MessID != 999 && $Message.unread == 1} mes_unread{/if}">
		<td rowspan="2">
		{if $MessID != 999}<input name="delmes[{$Message.id}]" type="checkbox">{/if}
		</td>
		<td>{$Message.time}</td>
		<td>{$Message.from}</td>
		<td>{$Message.subject}
		{if $Message.sender != 0 && $MessID != 999}
			<a href="#" onclick="return Dialog.PM({$Message.sender}, {$Message.id});" title="{$LNG.mg_answer_to} {strip_tags($Message.from)}"><img src="{$dpath}img/m.gif" border="0"></a>
		{/if}
		</td>
	</tr>
	<tr class="messages_body">
		<td colspan="3" class="left">
		{$Message.text}
		</td>
	</tr>
	{/foreach}
	<tr class="highRow">
		<td class="right" colspan="4">{$LNG.mg_page}:&nbsp;{if $maxSite > 1}<a href="#" class="pageLink" data-page="1">&laquo;&laquo;</a>&nbsp;{/if}{if $site > 1}<a href="#" class="pageLink" data-page="{$site - 1}">&laquo;</a>&nbsp;{/if}{for $page=1 to $maxSite}<a href="#" class="pageLink" data-page="{$page}">{if $site == $page}<b>[{$page}]</b>{else}[{$page}]{/if}</a>{if $page != $maxSite}&nbsp;{/if}{/for}{if $site < $maxSite}&nbsp;<a href="#" class="pageLink" data-page="{$site + 1}">&raquo;</a>{/if}{if $maxSite > 1}&nbsp;<a href="#" class="pageLink" data-page="{$maxPage}">&raquo;&raquo;</a>{/if}</td>
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