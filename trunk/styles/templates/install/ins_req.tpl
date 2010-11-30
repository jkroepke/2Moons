{include file="install/ins_header.tpl"}
<tr>
	<td>
		<table style="width:100%">
			<tr>
				<td class="transparent">{$req_php_need}</td><td class="transparent">{$PHP}</td>
			</tr>
			<tr>
				<td class="transparent">{$req_smode_active}</td><td class="transparent">{$safemode}</th>
			</tr>
			<tr>
				<td class="transparent">{$reg_gd_need}</td><td class="transparent">{$gdlib}</td>
			</tr>
			<tr>
				<td class="transparent">{$reg_json_need}</td><td class="transparent">{$json}</td>
			</tr>
			{$dir}
			{$config}
			{$done}
		</table>
	</td>
</tr>
{if $ftp != 0}
<tr>
	<td>
		<form name="ftp" id="ftp" action="" onsubmit="return false;">
		<table style="width:100%">
			<tr>
				<th>FTP</th>
			</tr>
			<tr>
				<td class="transparent" colspan="2">Gebe deine FTP Daten ein, um die Verzeichnissrechte zu &auml;ndern.</td>
			</tr>
			<tr>
				<td class="transparent">FTP-Host:</td><td class="transparent"><input type="text name="host"></td>
			</tr>
			<tr>
				<td class="transparent">Username:</td><td class="transparent"><input type="text name="user"></th>
			</tr>
			<tr>
				<td class="transparent">Password:</td><td class="transparent"><input type="pasword name="pass"></td>
			</tr>
			<tr>
				<td class="transparent">Pfad zu 2Moons:</td><td class="transparent"><input type="text name="path"></td>
			</tr>
			<tr>
				<td class="transparent right" colspan="2"><input type="button" value="Absenden" onclick="submitftp();"><br>Ihr Passwort wird nicht gespeichert!</td>
			</tr>
			</table>
		</form>
	</td>
</tr>
{/if}
{include file="install/ins_footer.tpl"}