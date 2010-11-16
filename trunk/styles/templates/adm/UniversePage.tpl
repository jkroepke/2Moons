{include file="adm/overall_header.tpl"}
<form enctype="multipart/form-data" action="?page=universe&action=import&sid={$SID}" method="POST">
<table>
	<tr>
		<td class="c">ID</td>
		<td class="c">Name</td>
		<td class="c">Speeds</td>
		<td class="c">Players</td>
		<td class="c">Open</td>
		<td class="c">Export</td>
		<td class="c">Delete</td>
	</tr>
	{foreach key=ID item=UniInfo from=$Unis}
	<tr>
		<th>{$ID}</th>
		<th>{$UniInfo.game_name}</th>
		<th>{$UniInfo.game_speed / 2500}/{$UniInfo.fleet_speed / 2500}/{$UniInfo.resource_multiplier}/{$UniInfo.halt_speed}</th>
		<th>{$UniInfo.users_amount}</th>
		<th>{if $UniInfo.game_disable == 0}N{else}Y{/if}</th>
		<th><a href="?page=universe&action=download&id={$ID}&sid={$SID}"><img src="./styles/images/adm/Go.png" alt=""></a></th>
		<th><a href="?page=universe&action=delete&id={$ID}&sid={$SID}" onclick="return confirm('Delete?');"><img src="./styles/images/adm/i.gif" alt=""></a></th>
	</tr>
	{/foreach}
	<tr><th colspan="7"><a href="?page=universe&action=create&sid={$SID}">Create a new</a></th></tr>
	<tr><td class="c" colspan="7">Import a Universe</td></tr>
	<tr><th colspan="7"><input name="file" type="file"><br><input type="submit" value="Upload"></th></tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}