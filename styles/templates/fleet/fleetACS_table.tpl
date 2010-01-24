<script language="JavaScript" src="scripts/flotten.js"></script>
<script language="JavaScript" src="scripts/ocnt.js"></script>
<div id="content">
	<table width="519" border="0" cellpadding="0" cellspacing="1" align="center">
		<tr height="20">
			<td colspan="9" class="c">{fl_fleet} ({fl_max}. {ile})</td>
		</tr>
		<tr height="20">
            <th>{fl_number}</th>
            <th>{fl_mission}</th>
            <th>{fl_ammount}</th>
            <th>{fl_beginning}</th>
            <th>{fl_departure}</th>
            <th>{fl_destiny}</th>
            <th>{fl_objective}</th>
            <th>{fl_arrival}</th>
            <th>{fl_order}</th>
        </tr>
            {page1}
            {maxflot}
    </table>
	<table width="519" border="0" cellpadding="0" cellspacing="1">
		<tr height="20">
			<td class="c" colspan="2">{fl_sac_of_fleet} KV50502025</td>
		</tr>
		<tr height="20">
			<td class="c" colspan="2">{fl_modify_sac_name}</td>
		</tr>
		<tr>
			<th colspan="2">{aks_code_mr}<br /> </th>
		</tr>
		<tr>
			<th>
				<table width="100%" border="0" cellpadding="0" cellspacing="1">
					<tr height="20">
                        <td class="c">{fl_members_invited}</td>
                        <td class="c">{fl_invite_members}</td>
					</tr>
					<tr>
                        <th width="50%">
                            <select size="5">
                            {page2}
                            </select>
						</th>
                        <form action="game.php?page=fleetACS" method="POST">
                        <input type="hidden" name="add_member_to_aks" value="madnessred" />
                        <input name="fleetid" value="{fleetid}" type="hidden">
                        <input name="aks_invited_mr" value="{aks_invited_mr}" type="hidden">
						<td>
							<input name="addtogroup" type="text" /> <br /><input type="submit" value="{fl_continue}" />
						</td>
						</form>
                        <br />
                        {add_user_message_mr}
					</tr>
				</table>
			</th>
		</tr>
		<tr>
		</tr>
	</table>
	<form action="game.php?page=fleet1" method="post">
	<table width="519" border="0" cellpadding="0" cellspacing="1">
		<tr height="20">
			<td colspan="4" class="c">{fl_new_mission_title}</td>
		</tr>
		<tr height="20">
            <th>{fl_ship_type}</th>
            <th>{fl_ship_available}</th>
			<th>-</th>
            <th>-</th>
		</tr>
{page3}
</div>