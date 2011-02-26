{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
	<table style="width:50%">
		<tr>
			<th colspan="4">{$supp_header}</td>
		</tr>
		<tr>
			<th style="width:10%">{$ticket_id}</td>
			<th style="width:50%">{$subject}</td>
			<th style="width:15%">{$status}</td>
			<th style="width:25%">{$ticket_posted}</td>
		</tr>
		{foreach key=TicketID item=TicketInfo from=$TicketsList}	
		<tr>
		<td>{$TicketID}</td>
		<td><a href="#" onclick="ShowTicket('ticket_{$TicketID}');">{$TicketInfo.subject}</a></td>
		<td>{if $TicketInfo.status == 0}<span style="color:red">{$supp_close}</span>{elseif $TicketInfo.status == 1}<span style="color:green">{$supp_open}</span>{elseif $TicketInfo.status == 2}<span style="color:orange">{$supp_admin_answer}</span>{elseif $TicketInfo.status == 3}<span style="color:green">{$supp_player_answer}</span>{/if}</td>
		<td>{$TicketInfo.date}</td>
		</tr>
		{/foreach}
	</table>
	{foreach key=TicketID item=TicketInfo from=$TicketsList}
	<div id="ticket_{$TicketID}" style="display:none;" class="tickets">
		<form action="game.php?page=support&amp;action=send&amp;id={$TicketID}" method="POST">
			<table style="width:50%">
				<tr>
					<th>{$text}</th>
				</tr>
				<tr>
					<td>{$TicketInfo.text}</td>
				</tr>
				{if $TicketInfo.status == 0}<tr><th>{$supp_ticket_close}</th></tr>{/if}
				<tr>
					<td>
					{if $TicketInfo.status != 0}
					<textarea cols="50" rows="10" name="text"></textarea><br><input type="submit" value="{$supp_send}">
					{/if}
					</td>
				</tr>
			</table>
		</form>
	</div>
	{/foreach}
	<div id="newbutton" style="display:block;">
		<table style="width:50%">
			<tr>
				<th><a href="#" onclick="ShowTicket(0);">{$ticket_new}</a></th>
			</tr>
		</table>
	</div>
	<div id="new" style="display:none;">
		<form action="game.php?page=support&amp;action=newticket" method="POST">
			<table style="width:50%">
				<tr>
					<th colspan="2" width="50%">{$ticket_new}</th>
				</tr>
				<tr>
					<td>{$subject}:</td>
					<td><input type="text" name="subject"></td>
				</tr>
				<tr>
					<td colspan="2">{$input_text}</td>
				</tr>
				<tr>
					<td colspan="2">
						<textarea name="text" cols="50" rows="10"></textarea>
						<input type="submit" value="{$supp_send}">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}