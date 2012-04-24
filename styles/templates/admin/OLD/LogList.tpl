{include file="overall_header.tpl"}
<table width=512>
<tr>
	<th>{$log_id}</th>
	<th>{$log_admin}</th>
	<th>{$log_uni}</th>
	<th>{$log_target}</th>
	<th>{$log_time}</th>
	<th>{$log_log}</th>
</tr>
{foreach item=LogInfo from=$LogArray}
<tr>
	<td>{$LogInfo.id}</td>
	<td>{$LogInfo.admin}</td>
	<td>{$LogInfo.target_uni}</td>
	<td>{$LogInfo.target}</td>
	<td>{$LogInfo.time}</td>
	<td><a href='?page=log&type=detail&id={$LogInfo.id}'>{$log_view}</a></td>
</tr>
{/foreach}
</table>
</body>
{include file="overall_footer.tpl"}