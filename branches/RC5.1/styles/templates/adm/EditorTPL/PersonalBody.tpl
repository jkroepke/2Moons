<script>document.body.style.overflow = "auto";</script>
<body>
<br />
</table>
<form action="" method="post">
<table width="45%">
{display}
<tr>
<th colspan="3" align="left"><a href="AccountEditorPage.php">
<img src="../styles/images/Adm/arrowright.png" width="16" height="10"/> {ad_back_to_menu}</a></th>
</tr><tr>
	<td class="c" colspan="7">{ad_personal_title}</td>
</tr><tr>
	<th>{input_id}</th>
	<th><input name="id" type="text"/></th>
</tr><tr>
	<th>{ad_personal_name}</th>
	<th><input name="username" type="text" {Block}/></th>
</tr><tr>
	<th>{ad_personal_pass}</th>
	<th><input name="password" type="password" {Block}/></th>
</tr><tr>
	<th>{ad_personal_email}</th>
	<th><input name="email" type="text" {Block}/></th>
</tr><tr>
	<th>{ad_personal_email2}</th>
	<th><input name="email_2" type="text" {Block}/></th>
</tr><tr>
	<th>{ad_personal_vacat}</th>
	<th>
		<select name="vacation">
			<option value="">{select_option}</option>
			<option value="yes">{yes}</option>
			<option value="no">{no}</option>
		</select>
	</th>
</tr><tr>
	<th>{time_days}</th><th><input name="d" type="text" size="5" maxlength="5"/></th>
</tr><tr>
	<th>{time_hours}</th><th><input name="h" type="text" size="5"  maxlength="10"/></th>
</tr><tr>
	<th>{time_minutes}</th><th><input name="m" type="text" size="5"  maxlength="10"/></th>
</tr><tr>
	<th>{time_seconds}</th><th><input name="s" type="text" size="5"  maxlength="10"/></th>
</tr><tr>
	<th colspan="3"><input type="Submit" value="{button_submit}"/></th>
</tr>
</table>
</form>
</body>