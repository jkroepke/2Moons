{include file="install/ins_header.tpl"}
<tr>
	<td>
		<table stylw="width:75%">
			<tr>
				<td>{$req_php_need}</td><td>{$PHP}</td>
			</tr>
			<tr>
				<td>{$req_smode_active}</td><td>{$safemode}</th>
			</tr>
			<tr>
				<td>{$reg_gd_need}</td><td>{$gdlib}</td>
			</tr>
			{$dir}
			{$config}
			{$done}
		</table>
	</td>
	</th>
</tr>
{include file="install/ins_footer.tpl"}