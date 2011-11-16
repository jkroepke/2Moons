{include file="install/ins_header.tpl"}
<tr>
	<td class="left">
		<h2>{lang}req_head{/lang}</h2>
		<p>{lang}req_desc{/lang}</p>
		<table class="req border">
			<tr>
				<td class="transparent left"><p>{lang}req_php_need{/lang}</p><p class="desc">{lang}req_php_need_desc{/lang}</p></td>
				<td class="transparent">{$PHP}</td>
			</tr>
			<tr>
				<td class="transparent left"><p>{lang}reg_mysqli_active{/lang}</p><p class="desc">{lang}reg_mysqli_desc{/lang}</p></td>
				<td class="transparent">{$mysqli}</th>
			</tr>
			<tr>
				<td class="transparent left"><p>{lang}reg_gd_need{/lang}</p><p class="desc">{lang}reg_gd_desc{/lang}</p></td>
				<td class="transparent">{$gdlib}</td>
			</tr>
			<tr>
				<td class="transparent left"><p>{lang}reg_json_need{/lang}</p></td>
				<td class="transparent">{$json}</td>
			</tr>
			<tr>
				<td class="transparent left"><p>{lang}reg_iniset_need{/lang}</p></td>
				<td class="transparent">{$iniset}</td>
			</tr>
			<tr>
				<td class="transparent left"><p>{lang}reg_global_need{/lang}</p></td>
				<td class="transparent">{$global}</th>
			</tr>
			{$dir}
			{$config}
			{$done}
		</table>
	</td>
</tr>
{if $ftp != 0}
<tr>
	<td class="transparent" colspan="2"><p>&nbsp;</p></td>
</tr>
<tr>
	<th colspan="2">{lang}req_ftp_head{/lang}</th>
</tr>
<tr>
	<td>
		<form name="ftp" id="ftp" action="" onsubmit="return false;">
		<table class="req">
			<tr>
				<td class="transparent left" colspan="2">
					<p>{lang}req_ftp_desc{/lang}</p>
				</td>
			</tr>
			<tr>
				<td class="transparent left">{lang}req_ftp_host{/lang}:</td>
				<td class="transparent"><input type="text" name="host"></td>
			</tr>
			<tr>
				<td class="transparent left">{lang}req_ftp_username{/lang}:</td>
				<td class="transparent"><input type="text" name="user"></th>
			</tr>
			<tr>
				<td class="transparent left">{lang}req_ftp_password{/lang}:</td>
				<td class="transparent"><input type="password" name="pass"></td>
			</tr>
			<tr>
				<td class="transparent left">{lang}req_ftp_dir{/lang}:</td>
				<td class="transparent"><input type="text" name="path"></td>
			</tr>
			<tr class="noborder">
				<td class="transparent right" colspan="2"><input type="button" value="{lang}req_ftp_send{/lang}" onclick="submitftp();">{$req_ftp_pass_info}</td>
			</tr>
			</table>
		</form>
	</td>
</tr>
{/if}
{include file="install/ins_footer.tpl"}