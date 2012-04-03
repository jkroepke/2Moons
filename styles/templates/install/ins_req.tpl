{include file="ins_header.tpl"}
<tr>
	<td class="left">
		<h2>{$LNG.req_head}</h2>
		<p>{$LNG.req_desc}</p>
		<table class="req border">
			<tr>
				<td class="transparent left"><p>{$LNG.req_php_need}</p><p class="desc">{$LNG.req_php_need_desc}</p></td>
				<td class="transparent">{$PHP}</td>
			</tr>
			<tr>
				<td class="transparent left"><p>{$LNG.reg_global_need}</p><p class="desc">{$LNG.reg_global_desc}</p></td>
				<td class="transparent">{$global}</th>
			</tr>
			<tr>
				<td class="transparent left"><p>{$LNG.reg_mysqli_active}</p><p class="desc">{$LNG.reg_mysqli_desc}</p></td>
				<td class="transparent">{$mysqli}</th>
			</tr>
			<tr>
				<td class="transparent left"><p>{$LNG.reg_gd_need}</p><p class="desc">{$LNG.reg_gd_desc}</p></td>
				<td class="transparent">{$gdlib}</td>
			</tr>
			<tr>
				<td class="transparent left"><p>{$LNG.reg_json_need}</p></td>
				<td class="transparent">{$json}</td>
			</tr>
			<tr>
				<td class="transparent left"><p>{$LNG.reg_iniset_need}</p></td>
				<td class="transparent">{$iniset}</td>
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
	<th colspan="2">{$LNG.req_ftp_head}</th>
</tr>
<tr>
	<td>
		<form name="ftp" id="ftp" action="" onsubmit="return false;">
		<table class="req">
			<tr>
				<td class="transparent left" colspan="2">
					<p>{$LNG.req_ftp_desc}</p>
				</td>
			</tr>
			<tr>
				<td class="transparent left">{$LNG.req_ftp_host}:</td>
				<td class="transparent"><input type="text" name="host"></td>
			</tr>
			<tr>
				<td class="transparent left">{$LNG.req_ftp_username}:</td>
				<td class="transparent"><input type="text" name="user"></th>
			</tr>
			<tr>
				<td class="transparent left">{$LNG.req_ftp_password}:</td>
				<td class="transparent"><input type="password" name="pass"></td>
			</tr>
			<tr>
				<td class="transparent left">{$LNG.req_ftp_dir}:</td>
				<td class="transparent"><input type="text" name="path"></td>
			</tr>
			<tr class="noborder">
				<td class="transparent right" colspan="2"><input type="button" value="{$LNG.req_ftp_send}" onclick="submitftp();"></td>
			</tr>
			</table>
		</form>
	</td>
</tr>
{/if}
{include file="ins_footer.tpl"}