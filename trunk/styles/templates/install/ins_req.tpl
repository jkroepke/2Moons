{include file="install/ins_header.tpl"}
<tr>
	<td>
		<table style="width:100%">
			<tr>
				<td class="transparent">{$req_php_need}</td><td class="transparent">{$PHP}</td>
			</tr>
			<tr>
				<td class="transparent">{$reg_iniset_need}</td><td class="transparent">{$json}</td>
			</tr>
			<tr>
				<td class="transparent">{$reg_mysqli_active}</td><td class="transparent">{$mysqli}</th>
			</tr>
			<tr>
				<td class="transparent">{$reg_gd_need}</td><td class="transparent">{$gdlib}</td>
			</tr>
			<tr>
				<td class="transparent">{$reg_json_need}</td><td class="transparent">{$json}</td>
			</tr>
			<tr>
				<td class="transparent">{$reg_bcmath_need}</td><td class="transparent">{$json}</td>
			</tr>
			{$dir}
			{$config}
			{$done}
		</table>
	</td>
</tr>
{if $ftp != 0}
<tr>
	<th colspan="2">{$req_ftp}</th>
</tr>
<tr>
	<td>
		<form name="ftp" id="ftp" action="" onsubmit="return false;">
		<table style="width:100%">

			<tr>
				<td class="transparent" colspan="2">{$req_ftp_info}</td>
			</tr>
			<tr>
				<td class="transparent">{$req_ftp_host}:</td><td class="transparent"><input type="text" name="host"></td>
			</tr>
			<tr>
				<td class="transparent">{$req_ftp_username}:</td><td class="transparent"><input type="text" name="user"></th>
			</tr>
			<tr>
				<td class="transparent">{$req_ftp_password}:</td><td class="transparent"><input type="password" name="pass"></td>
			</tr>
			<tr>
				<td class="transparent">{$req_ftp_dir}:</td><td class="transparent"><input type="text" name="path"></td>
			</tr>
			<tr>
				<td class="transparent right" colspan="2"><input type="button" value="{$req_ftp_send}" onclick="submitftp();"><br>{$req_ftp_pass_info}</td>
			</tr>
			</table>
		</form>
	</td>
</tr>
{/if}
{include file="install/ins_footer.tpl"}