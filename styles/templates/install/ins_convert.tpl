{include file="ins_header.tpl"}
<tr>
	<td colspan="2">{$convert_info}</td>
</tr>
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
	<td>{$convert_version}</td>
	<td>
		<select name="version">
			<optgroup label="XG Proyecto">
				<option label="XG Proyecto 2.9.0" value="xgp">XG Proyecto 2.9.0</option>
				<option label="XG Proyecto 2.9.1" value="xgp">XG Proyecto 2.9.1</option>
				<option label="XG Proyecto 2.9.2" value="xgp">XG Proyecto 2.9.2</option>
				<option label="XG Proyecto 2.9.3" value="xgp">XG Proyecto 2.9.3</option>
				<option label="XG Proyecto 2.9.4" value="xgp">XG Proyecto 2.9.4</option>
				<option label="XG Proyecto 2.9.5" value="xgp">XG Proyecto 2.9.5</option>
				<option label="XG Proyecto 2.9.6" value="xgp">XG Proyecto 2.9.6</option>
			</optgroup>
			<optgroup label="XNova SVN">
				<option label="XNova SVN v2.0" value="xsvn20">XNova SVN v2.0</option>
				<option label="XNova SVN v2.1" value="xsvn21">XNova SVN v2.1</option>
			</optgroup><!-- 
			<optgroup label="Spacebeginners">
				<option label="Spacebeginners v3" value="sb3">Spacebeginners v3</option>
				<option label="Spacebeginners v4" value="sb4">Spacebeginners v4</option>
			</optgroup> -->
        </select>
    </td>
</tr>        
<tr>
	<td colspan="2"><input type="submit" value="{$convert_submit}"></td>
</tr>
{include file="ins_footer.tpl"}