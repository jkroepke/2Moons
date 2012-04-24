{include file="overall_header.tpl"}
<table width=512>
	<tr>
		<th colspan=2>{$log_info}</th>
	</tr>
	<tr>
		<td>{$log_admin}:</td>
		<td>{$admin}</td>
	</tr>
	<tr>
		<td>{$log_target}:</td>
		<td>{$target}</td>
	</tr>
	<tr>
		<td>{$log_time}:</td>
		<td>{$time}</td>
	</tr>
</table>
<table width=512>
<tr>
	<th>{$log_element}</th>
	<th>{$log_old}</th>
	<th>{$log_new}</th>
</tr>
{foreach item=LogInfo from=$LogArray}
{if ($LogInfo.old <> $LogInfo.new)}
<tr>
	<td>{$LogInfo.Element}</td>
	<td>{$LogInfo.old}</td>
	<td>{$LogInfo.new}</td>
</tr>
{/if}
{/foreach}
</table>
</body>
{include file="overall_footer.tpl"}