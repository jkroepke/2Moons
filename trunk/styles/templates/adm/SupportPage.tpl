{include file="adm/overall_header.tpl"}
<table width="842px">
	<tr>
		<td colspan="5" class="c" width="500"><center>{$supp_header}</center></td>
	</tr>
	<tr>
		<td class="c" width="10%"><center>{$ticket_id}</center></td>
		<td class="c" width="10%"><center>{$player}</center></td>
		<td class="c" width="40%"><center>{$subject}</center></td>
		<td class="c" width="15%"><center>{$status}</center></td>
		<td class="c" width="25%"><center>{$ticket_posted}</center></td>
	</tr>	
	{foreach item=Ticket from=$tickets.open}
	<tr><th>{$Ticket.id}</th><th>{$Ticket.username}</th><th><a href="?page=support&amp;action=detail&amp;id={$Ticket.id}">{$Ticket.subject}</a></th><th>{$Ticket.status}</th><th>{$Ticket.date}</th></tr>
	{/foreach}
</table>
{if !empty($tickets.closed)}
<br><br>
<table width="842px">
	<tr>
		<td colspan="5" class="c" width="500"><center>{$supp_header_g}</center></td>
	</tr>
	<tr>
		<td class="c" width="10%"><center>{$ticket_id}</center></td>
		<td class="c" width="10%"><center>{$player}</center></td>
		<td class="c" width="40%"><center>{$subject}</center></td>
		<td class="c" width="15%"><center>{$status}</center></td>
		<td class="c" width="25%"><center>{$ticket_posted}</center></td>
	</tr>
	{foreach item=Ticket from=$tickets.closed}
	<tr><th>{$Ticket.id}</th><th>{$Ticket.username}</th><th><a href="?page=support&amp;action=detail&amp;id={$Ticket.id}">{$Ticket.subject}</a></th><th>{$Ticket.status}</th><th>{$Ticket.date}</th></tr>
	{/foreach}
</table>
{/if}
{if isset($t_id)}
<br><br>
<table width="842px">
	<tr>
		<td class="c" width="10%">{$ticket_id}</td>
		<td class="c" width="10%">{$player}</td>
		<td class="c" width="40%">{$subject}</td>
		<td class="c" width="15%">{$status}</td>
		<td class="c" width="25%">{$ticket_posted}</td>
	</tr>
	<tr>
		<th>{$t_id}</th>
		<th>{$t_username}</th>
		<th>{$t_subject}</a></th>
		<th>{$t_statustext}</th>
		<th>{$t_date}</th></tr>
</table>


<table width="842px">
	<tr>
		<td class="c">{$text}</td>
	</tr>
	<tr>
		<th>{$t_text}</th>
	</tr>
	<tr>
		<td class="c">{$answer_new}</td>
	</tr>
	<tr>
		<th>
			<form action="?page=support&amp;action=send&amp;id={$t_id}" method="POST">
			<textarea cols="70" rows="10" name="text"></textarea>
			<br><input type="submit" value="{$button_submit}">
			</form><hr>
			{if $t_status != 0}
			<form action="?page=support&amp;action=close&amp;id={$t_id}" method="POST">
			<input type="submit" value="{$close_ticket}"></form>
			{else}
			<form action="?page=support&amp;action=open&amp;id={$t_id}" method="POST">
			<input type="submit" value="{$open_ticket}"></form>
			{/if}
		</th>
	</tr>
</table>

{/if}
{include file="adm/overall_footer.tpl"}