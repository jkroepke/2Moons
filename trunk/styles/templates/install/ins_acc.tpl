{include file="install/ins_header.tpl"}
	<tr>
	<form method="POST" action="?mode=ins&amp;page=4{$lang}">
	<th colspan="2">
		<span style="font-size: 15px; font-weight: 700;">{$step3_create_admin}</span>
	</th>
	</tr>
    <tr>
      	<th width="50%">{$step3_admin_name}</th><th width="50%"><input name="adm_user" size="20" maxlength="20" type="text"></th>
    </tr>
    <tr>
      	<th width="50%">{$step3_admin_pass}</th><th width="50%"><input name="adm_pass" size="20" maxlength="20" type="password"></th>
    </tr>
    <tr>
		<th width="50%">{$step3_admin_mail}</th><th width="50%"><input name="adm_email" size="20" maxlength="40" type="text"></th>
	</tr>
	<tr>
		<th colspan="2"><input type="submit" value="{$continue}"></th>
	</tr>
</form>
{include file="install/ins_footer.tpl"}