		<tr>
			<th colspan="2">{convert_info}</th>
		</tr>
		<tr>
			<th>{step1_mysql_server}</th>
			<th><input type="text" name="host" value="localhost" size="30"></th>
		</tr>
		<tr>
			<th>{step1_mysql_port}</th>
			<th><input type="text" name="port" value="3306" size="30"></th>
		</tr>
		<tr>
			<th>{step1_mysql_dbname}</th>
			<th><input type="text" name="db" value="" size="30"></th>
		</tr>
		<tr>
			<th>{step1_mysql_dbuser}</th>
			<th><input type="text" name="user" value="" size="30"></th>
		</tr>
		<tr>
			<th>{step1_mysql_dbpass}</th>
			<th><input type="password" name="passwort" value="" size="30"></th>
		</tr>
		<tr>
			<th>{step1_mysql_prefix}</th>
			<th><input type="text" name="prefix" value="uni1_" size="30"></th>
		</tr>
		<tr>
			<th>{convert_version}</th>
			<th>
                <select name="version">
				<optgroup label="XG Proyecto">
					<option label="XG Proyecto 2.9.0" value="xgp">XG Proyecto 2.9.0</option>
					<option label="XG Proyecto 2.9.1" value="xgp">XG Proyecto 2.9.1</option>
					<option label="XG Proyecto 2.9.2" value="xgp">XG Proyecto 2.9.2</option>
					<option label="XG Proyecto 2.9.3" value="xgp">XG Proyecto 2.9.3</option>
					<option label="XG Proyecto 2.9.4" value="xgp">XG Proyecto 2.9.4</option>
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
            </th>
		</tr>        
		<tr>
			<th align="center" colspan="2"><input type="submit" value="{convert_submit}"></th>
		</tr>