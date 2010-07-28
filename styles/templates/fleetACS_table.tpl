<form action="?page=fleet&amp;action=getakspage" method="POST">
<input name="fleetid" value="{$fleetid}" type="hidden">
<input name="aks_invited_mr" value="{$aks_invited_mr}" type="hidden">
	<table width="519" border="0" cellpadding="0" cellspacing="1" align="center">
		<tr style="height:20px;">
			<td class="c" colspan="2">{$fl_sac_of_fleet}</td>
		</tr>
		<tr style="height:20px;">
			<td class="c" colspan="2">{$fl_modify_sac_name}</td>
		</tr>
		<tr>
			<th colspan="2">{$aks_code_mr}<br>{$add_user_message_mr}</th>
		</tr>
		<tr style="height:20px;">
			<td class="c" style="width:50%;">{$fl_members_invited}</td>
            <td class="c" style="width:50%;">{$fl_invite_members}</td>
		</tr>
		<tr>
			<th>
				<select size="5" style="width:80%;">
                {$selector}
                </select>
			</th>
			<th>
				<input name="addtogroup" type="text"><br><input type="submit" value="{$fl_continue}">
			</th>
		</tr>
	</table>
	</form>