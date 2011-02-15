{include file="adm/overall_header.tpl"}
<form action="" method="post">
<table width="45%">
<tr>
<td colspan="3" align="left"><a href="?page=accounteditor">
<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$ad_back_to_menu}</a></td>
</tr><tr>
	<th colspan="7">{$ad_personal_title}</th>
</tr><tr>
	<td>{$input_id}</td>
	<td><input name="id" type="text"></td>
</tr><tr>
	<td>{$ad_personal_name}</td>
	<td><input name="username" type="text"></td>
</tr><tr>
	<td>{$ad_personal_pass}</td>
	<td><input name="password" type="password"></td>
</tr><tr>
	<td>{$ad_personal_email}</td>
	<td><input name="email" type="text"></td>
</tr><tr>
	<td>{$ad_personal_email2}</td>
	<td><input name="email_2" type="text"></td>
</tr><tr>
	<td>{$ad_personal_vacat}</td>
	<td>{html_options name=vacation options=$Selector}</td>
</tr><tr>
	<td>{$time_days}</td><td><input name="d" type="text" size="5" maxlength="5"></td>
</tr><tr>
	<td>{$time_hours}</td><td><input name="h" type="text" size="5" maxlength="10"></td>
</tr><tr>
	<td>{$time_minutes}</td><td><input name="m" type="text" size="5" maxlength="10"></td>
</tr><tr>
	<td>{$time_seconds}</td><td><input name="s" type="text" size="5" maxlength="10"></td>
</tr><tr>
	<td colspan="3"><input type="submit" value="{$button_submit}"></td>
</tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}