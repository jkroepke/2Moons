{include file="install/ins_header.tpl"}
<tr>
	<th>
		<table width="75%" align="center">
			<tr>
				<th>{$req_php_need}</th><th>{$PHP}</th>
			</tr>
			<tr>
				<th>{$req_smode_active}</th><th>{$safemode}</th>
			</tr>
			<tr>
				<th>{$reg_gd_need}</th><th>{$gdlib}</th>
			</tr>
			{$dir}
			{$config}
			{$done}
		</table>
	</th>
	</th>
</tr>
{include file="install/ins_footer.tpl"}