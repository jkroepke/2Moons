<br><br>
<h2>{supp_admin_system}</h2>
<table width="75%">
	<tr>
		<td colspan="5" class="c" width="500"><center>{supp_header}</center></td>
	</tr>
	<tr>
		<td class="c" width="10%"><center>{ticket_id}</center></td>
		<td class="c" width="10%"><center>{player}</center></td>
		<td class="c" width="40%"><center>{subject}</center></td>
		<td class="c" width="15%"><center>{status}</center></td>
		<td class="c" width="25%"><center>{ticket_posted}</center></td>
	</tr>
	{tickets}
</table>


<table width="75%">
	<tr>
		<td class="c"><center>{text}</center></td>
	</tr>
	<tr>
		<td class="b"><center>{text_view}</center></td>
	</tr>
</table>

<table width="519">
	<tr>
		<td class="c"><center>{answer_new}</center></td>
	</tr>
	<tr>
		<td class="b" colspan="2">
			<form action="?ticket={id}&sendenantwort=1" method="POST">
			<input type="hidden" name="senden_antwort_id" value="{id}">
			<textarea cols="70" rows="10" name="senden_antwort_text"></textarea>
			<br><center><input type="submit" value="Absenden"></center>
			</form><hr noshade>
			<form action="?ticket={id}&schliessen=1" method="POST">
			<input type="hidden" name="ticket" value="{id}">
			<center><input type="submit" value="{close_ticket}"></center>
			</form>
		</td>
	</tr>
</table>
