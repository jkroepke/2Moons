<script>document.body.style.overflow = "auto";</script> 
<body>
{error_message}
<table width="100%">
<tr>
	<td colspan="13" class="c">{ou_players_connected} (<font color=lime>{adm_ov_data_count}</font>)</td>
</tr>
<tr>
	<th width="12px"><a href="?cmd=sort&type=id">{ou_private_message}</a></th>
	<th><a href="?cmd=sort&type=username">{ou_user_id}</a></th>
	<th><a href="?cmd=sort&type=user_lastip">{ou_ip_address}</a></th>
	<th><a href="?cmd=sort&type=ally_name">{ou_alliance}</a></th>
	<th>{ou_points}</th>
	<th><a href="?cmd=sort&type=onlinetime">{ou_inactivity}</a></th>
	<th>{ou_email}</th>
	<th width="16px">{ou_vacation_mode}</th>
	<th width="16px">{ou_banned}</th>
	<th>{ou_planet}</th>
	<th>{ou_actual_page}</th>
</tr>
	{adm_ov_data_table}
</table>
</body>