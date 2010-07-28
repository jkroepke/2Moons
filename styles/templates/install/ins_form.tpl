{include file="install/ins_header.tpl"}
<form method="POST" action="?mode=ins&amp;page=2&amp;{$lang}">
<tr>
	<th colspan="3"><font color="red">{$step1_notice_chmod}</font></th>
</tr>
<tr>
	<th>{$step1_mysql_server}</th>
	<th><input type="text" name="host" value="localhost" size="30"></th>
</tr>
<tr>
	<th>{$step1_mysql_port}</th>
	<th><input type="text" name="port" value="3306" size="30"></th>
</tr>
<tr>
	<th>{$step1_mysql_dbname}</th>
	<th><input type="text" name="db" value="" size="30"></th>
</tr>
<tr>
	<th>{$step1_mysql_dbuser}</th>
	<th><input type="text" name="user" value="" size="30"></th>
</tr>
<tr>
	<th>{$step1_mysql_dbpass}</th>
	<th><input type="password" name="passwort" value="" size="30"></th>
</tr>
<tr>
	<th>{$step1_mysql_prefix}</th>
	<th><input type="text" name="prefix" value="uni1_" size="30"></th>
</tr>
<tr>
	<th colspan="3"><input type="submit" name="next" value="{$continue}"></th>
</tr>
</form>
{include file="install/ins_footer.tpl"}