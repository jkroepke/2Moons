{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
	<table style="width:50%">
		<tr>
			<th colspan="4">{$supp_header}</td>
		</tr>
		<tr>
			<th width="10%">{$ticket_id}</td>
			<th width="50%">{$subject}</td>
			<th width="15%">{$status}</td>
			<th width="25%">{$ticket_posted}</td>
		</tr>
		{foreach key=TicketID item=TicketInfo from=$TicketsList}	
		<tr>
		<td class='b'>{$TicketID}</td>
		<td class='b'><a href="javascript:infodiv('ticket_{$TicketID}');">{$TicketInfo.subject}</a></td>
		<td class='b'>{if $TicketInfo.status == 0}<font color="red">{$supp_close}</font>{elseif $TicketInfo.status == 1}<font color="green">{$supp_open}</font>{elseif $TicketInfo.status == 2}<font color="orange">{$supp_admin_answer}</font>{elseif $TicketInfo.status == 3}<font color="green">{$supp_player_answer}</font>{/if}</td>
		<td class='b'>{$TicketInfo.date}</td>
		</tr>
		{/foreach}
	</table>
	{foreach key=TicketID item=TicketInfo from=$TicketsList}
	<div id="ticket_{$TicketID}" style="display:none;">
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
					<textarea cols="50" rows="10" name="text"></textarea><br><input type="submit" value="Absenden">
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
				<th><a href="javascript:infodiv(0);">{$ticket_new}</a></th>
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
						<input type="submit" value="Absenden">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<script type="text/javascript">
function infodiv(i) {
	if(i == 0){ $('#newbutton:visible').hide('blind', {}, 500);$('#new:hidden').show('blind', {}, 500); }
	if(i != 0){ $('#newbutton:hidden').show('blind', {}, 500);$('#new:visible').hide('blind', {}, 500); }

	{foreach key=TicketID item=TicketInfo from=$TicketsList}
	$('#ticket_{$TicketID}:visible').hide('blind', {}, 500);
	{/foreach}
	$('#'+i).show('blind', {}, 500);
}
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}