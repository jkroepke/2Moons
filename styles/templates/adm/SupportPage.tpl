{include file="adm/overall_header.tpl"}
<table width="842px">
	<tr>
		<th colspan="5" width="500">{$supp_header}</th>
	</tr>
	<tr>
		<th width="10%">{$ticket_id}</th>
		<th width="10%">{$player}</th>
		<th width="40%">{$subject}</th>
		<th width="15%">{$status}</th>
		<th width="25%">{$ticket_posted}</th>
	</tr>	
	{foreach item=Ticket from=$tickets.open}
	<tr><td>{$Ticket.id}</td><td>{$Ticket.username}</td><td><a href="?page=support&amp;action=detail&amp;id={$Ticket.id}">{$Ticket.subject}</a></td><td>{$Ticket.status}</td><td>{$Ticket.date}</td></tr>
	{/foreach}
</table>
{if !empty($tickets.closed)}
<br><br>
<table width="842px">
	<tr>
		<th colspan="5" width="500">{$supp_header_g}</th>
	</tr>
	<tr>
		<th width="10%">{$ticket_id}</th>
		<th width="10%">{$player}</th>
		<th width="40%">{$subject}</th>
		<th width="15%">{$status}</th>
		<th width="25%">{$ticket_posted}</th>
	</tr>
	{foreach item=Ticket from=$tickets.closed}
	<tr><td>{$Ticket.id}</td><td>{$Ticket.username}</td><td><a href="?page=support&amp;action=detail&amp;id={$Ticket.id}">{$Ticket.subject}</a></td><td>{$Ticket.status}</td><td>{$Ticket.date}</td></tr>
	{/foreach}
</table>
{/if}
{if isset($t_id)}
<br><br>
<table width="842px">
	<tr>
		<th width="10%">{$ticket_id}</th>
		<th width="10%">{$player}</th>
		<th width="40%">{$subject}</th>
		<th width="15%">{$status}</th>
		<th width="25%">{$ticket_posted}</th>
	</tr>
	<tr>
		<td>{$t_id}</td>
		<td>{$t_username}</td>
		<td>{$t_subject}</a></td>
		<td>{$t_statustext}</td>
		<td>{$t_date}</td></tr>
</table>


<table width="842px">
	<tr>
		<th>{$text}</td>
	</tr>
	<tr>
		<td>{$t_text}</td>
	</tr>
	<tr>
		<th>{$answer_new}</td>
	</tr>
	<tr>
		<td>
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
		</td>
	</tr>
</table>

{/if}
{include file="adm/overall_footer.tpl"}