{include file="install/ins_header.tpl"}
	<tr>
	<form method="POST" action="?mode=ins&amp;page=3&amp;lang={$lang}">
	<td colspan="2">
		<span style="font-size: 15px; font-weight: 700;">{$step3_create_admin}</span>
	</td>
	</tr>
    <tr>
      	<td style="width:50%">{$step3_admin_name}</td><td style="width:50%"><input name="adm_user" size="20" maxlength="20" type="text"></td>
    </tr>
    <tr>
      	<td>{$step3_admin_pass}</td><td width="50%"><input name="adm_pass" size="20" maxlength="20" type="password"></td>
    </tr>
    <tr>
		<td>{$step3_admin_mail}</td><td width="50%"><input name="adm_email" size="20" maxlength="40" type="text"></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="{$continue}"></td>
	</tr>
</form>
{include file="install/ins_footer.tpl"}