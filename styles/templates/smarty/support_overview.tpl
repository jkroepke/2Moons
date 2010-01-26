{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<script type="text/javascript">

animatedcollapse.addDiv('new', 'fade=1,height=auto');
animatedcollapse.addDiv('newbutton', 'fade=1,height=auto');
{foreach key=TicketID item=TicketInfo from=$TicketsList}
animatedcollapse.addDiv('ticket_{$TicketID}', 'fade=1,height=auto');
{/foreach}
animatedcollapse.init();
{literal}
function infodiv(i){
{/literal}
{foreach key=TicketID item=TicketInfo from=$TicketsList}
animatedcollapse.hide('ticket_{$TicketID}');
{/foreach}
{literal}
if(i == 0){animatedcollapse.hide('newbutton');animatedcollapse.show('new');}
if(i != 0){animatedcollapse.show('newbutton');animatedcollapse.hide('new');}
}
{/literal}
</script>

<div id="content">
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
	<td class='b'><a href="javascript:infodiv({$TicketID});javascript:animatedcollapse.toggle('ticket_{$TicketID}');">{$TicketInfo.subject}</a></td>
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
<textarea cols="50" rows="10" name="text"></textarea><center><input type="submit" value="Absenden"></center>
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
		<textarea cols="50" rows="10" name="text" style="font-family:Arial;font-size:11px;"></textarea>
		<center><input type="submit" value="Absenden"></center>
		</th>
	</tr>
</table></form>
</div>
</div>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}