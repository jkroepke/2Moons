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
	</th>
</tr>
{include file="install/ins_footer.tpl"}