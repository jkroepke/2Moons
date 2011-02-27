{include file="install/ins_header.tpl"}
<form method="POST" action="?mode=ins&amp;page=2&amp;{$lang}" id="install" onsubmit="return submitinstall();">
<tr>
	<td>{$step1_mysql_server}</td>
	<td><input type="text" name="host" value="localhost" size="30"></td>
</tr>
<tr>
	<td>{$step1_mysql_port}</td>
	<td><input type="text" name="port" value="3306" size="30"></td>
</tr>
<tr>
	<td>{$step1_mysql_dbname}</td>
	<td><input type="text" name="db" value="" size="30"></td>
</tr>
<tr>
	<td>{$step1_mysql_dbuser}</td>
	<td><input type="text" name="user" value="" size="30"></td>
</tr>
<tr>
	<td>{$step1_mysql_dbpass}</td>
	<td><input type="password" name="passwort" value="" size="30"></td>
</tr>
<tr>
	<td>{$step1_mysql_prefix}</td>
	<td><input type="text" name="prefix" value="uni1_" size="30"></td>
</tr>
<tr>
	<td colspan="3"><input type="submit" name="next" value="{$continue}"></td>
</tr>
</form>
{include file="install/ins_footer.tpl"}