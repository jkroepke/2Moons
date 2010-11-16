{include file="adm/overall_header.tpl"}
<form enctype="multipart/form-data" action="?page=universe&action=import&sid={$SID}" method="POST">
<table>
	<tr>
		<td class="c">{$id}</td>
		<td class="c">{$name}</td>
		<td class="c">{$speeds}</td>
		<td class="c">{$players}</td>
		<td class="c">{$open}</td>
		<td class="c">{$export}</td>
		<td class="c">{$delete}</td>
	</tr>
	{foreach key=ID item=UniInfo from=$Unis}
	<tr>
		<th>{$ID}</th>
		<th>{$UniInfo.game_name}</th>
		<th>{$UniInfo.game_speed / 2500}/{$UniInfo.fleet_speed / 2500}/{$UniInfo.resource_multiplier}/{$UniInfo.halt_speed}</th>
		<th>{$UniInfo.users_amount}</th>
		<th>{if $UniInfo.game_disable == 0}{$uni_on}{else}{$uni_off}{/if}</th>
		<th><a href="?page=universe&action=download&id={$ID}&sid={$SID}"><img src="styles/images/Adm/Go.png" alt=""></a></th>
		<th><a href="?page=universe&action=delete&id={$ID}&sid={$SID}" onclick="return confirm('Delete?');"><img src="styles/images/Adm/i.gif" alt=""></a></th>
	</tr>
	{/foreach}
	<tr><th colspan="7"><a href="?page=universe&action=create&sid={$SID}">{$new_uni}</a></th></tr>
	<tr><td class="c" colspan="7">{$import_uni}</td></tr>
	<tr><th colspan="7"><input name="file" type="file"><br><input type="submit" value="{$upload}"></th></tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}