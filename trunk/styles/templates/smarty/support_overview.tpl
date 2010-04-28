{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<script type="text/javascript">
function infodiv(i){
{foreach key=TicketID item=TicketInfo from=$TicketsList}
$('#ticket_{$TicketID}:visible').hide('blind', {}, 500);
{/foreach}
{literal}
if(i == 0){$('#newbutton:visible').hide('blind', {}, 500);$('#new:hidden').show('blind', {}, 500);}
if(i != 0){$('#newbutton:hidden').show('blind', {}, 500);$('#new:visible').hide('blind', {}, 500);}
$('#'+i).show('blind', {}, 500);
}
{/literal}
</script>

<div id="content" class="content">
<table width="519" align="center">
	<tr>
		<td colspan="4" class="c" width="50%"><center>{$supp_header}</center></td>
	</tr>
	<tr>
		<td class="c" width="10%"><center>{$ticket_id}</center></td>
		<td class="c" width="50%"><center>{$subject}</center></td>
		<td class="c" width="15%"><center>{$status}</center></td>
		<td class="c" width="25%"><center>{$ticket_posted}</center></td>
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
<table width="519" align="center">
<tr>
<td class="c"><center>{$text}</center></td>
</tr>
<tr>
<td class="b"><center>{$TicketInfo.text}</center></td>
</tr>
{if $TicketInfo.status == 0}<tr><td class="c" width="50%"><center>{$supp_ticket_close}</center></td></tr>{/if}
<tr>
<td class="b" colspan="2">
{if $TicketInfo.status != 0}
<center><textarea cols="50" rows="10" name="text"></textarea><br><input type="submit" value="Absenden"></center>
{/if}
</td>
</tr>
</table>
</form>
</div>
{/foreach}
<div id="newbutton" style="display:block;">
<table width="519" align="center">
	<tr>
		<td colspan="4" class="c" width="50%"><center><a href="javascript:infodiv(0);">{$ticket_new}</a></center></td>
	</tr>
</table>
</div>
<div id="new" style="display:none;">
<form action="game.php?page=support&amp;action=newticket" method="POST">
<table width="519" align="center">
	<tr>
		<td colspan="2" class="c" width="50%"><center>{$ticket_new}</center></td>
	</tr>
	<tr>
		<th><center>{$subject}:</center></th><th><input type="text" name="subject"></th>
	</tr>
	<tr>
		<th colspan="2">{$input_text}</th>
	</tr>
	<tr>
		<th colspan="2">
		<center><textarea cols="50" rows="10" name="text" style="font-family:Arial;font-size:11px;"></textarea>
		<input type="submit" value="Absenden"></center>
		</th>
	</tr>
</table></form>
</div>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}