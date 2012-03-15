{include file="overall_header.tpl"}
<table width="760px">
	<tr>
		<th>{$id}</th>
		<th>{$name}</th>
		<th colspan="4">{$speeds}</th>
		<th>{$players}</th>
		<th>{$LNG.uvs_inactive}</th>
		<th>{$LNG.uvs_planets}</th>
		<th>{$open}</th>
		<th>{$delete}</th>
	</tr>
	{foreach key=ID item=UniInfo from=$Unis}
	<tr style="height:23px;">
		<td>{$ID}</td>
		<td>{$UniInfo.uni_name}</td>
		<td>{$UniInfo.game_speed / 2500}</td>
		<td>{$UniInfo.fleet_speed / 2500}</td>
		<td>{$UniInfo.resource_multiplier}</td>
		<td>{$UniInfo.halt_speed}</td>
		<td>{$UniInfo.users_amount}</td>
		<td>{$UniInfo.inactive}</td>
		<td>{$UniInfo.planet}</td>
		<td>{if $UniInfo.game_disable == 1}{$uni_on}{else}{$uni_off}{/if}</td>
		<td>{if $ID != $smarty.const.ROOT_UNI}<a href="?page=universe&amp;action=delete&amp;id={$ID}&amp;sid={$SID}&amp;reload=t" onclick="return confirm('{$LNG.uvs_delete}');" title="{$LNG.uvs_delete}"><img src="styles/images/FALSE.png" alt=""></a>{/if}</td>
	</tr>
	{/foreach}
	<tr><td colspan="11"><a href="?page=universe&action=create&amp;sid={$SID}&amp;reload=t">{$new_uni}</a></td></tr>
</table>
{include file="overall_footer.tpl"}