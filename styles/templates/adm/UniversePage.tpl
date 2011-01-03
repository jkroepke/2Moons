{include file="adm/overall_header.tpl"}
<form enctype="multipart/form-data" action="?page=universe&action=import&sid={$SID}" method="POST">
<table>
	<tr>
		<th>{$id}</th>
		<th>{$name}</th>
		<th>{$speeds}</th>
		<th>{$players}</th>
		<th>{$open}</th>
		<th>{$export}</th>
		<th>{$delete}</th>
	</tr>
	{foreach key=ID item=UniInfo from=$Unis}
	<tr>
		<td>{$ID}</td>
		<td>{$UniInfo.game_name}</td>
		<td>{$UniInfo.game_speed / 2500}/{$UniInfo.fleet_speed / 2500}/{$UniInfo.resource_multiplier}/{$UniInfo.halt_speed}</td>
		<td>{$UniInfo.users_amount}</td>
		<td>{if $UniInfo.game_disable == 1}{$uni_on}{else}{$uni_off}{/if}</td>
		<td><a href="?page=universe&action=download&id={$ID}&sid={$SID}"><img src="styles/images/Adm/GO.png" alt=""></a></td>
		<td><a href="?page=universe&action=delete&id={$ID}&sid={$SID}" onclick="return confirm('Delete?');"><img src="styles/images/Adm/i.gif" alt=""></a></td>
	</tr>
	{/foreach}
	<tr><td colspan="7"><a href="?page=universe&action=create&sid={$SID}">{$new_uni}</a></td></tr>
	<tr><th colspan="7">{$import_uni}</th></tr>
	<tr><td colspan="7"><input name="file" type="file"><br><input type="submit" value="{$upload}"></td></tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}