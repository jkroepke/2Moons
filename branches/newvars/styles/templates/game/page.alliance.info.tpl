{block name="title" prepend}{$LNG.lm_alliance}{/block}
{block name="content"}
<table class="table519">
<tr>
	<th colspan="2">{$LNG.al_ally_information}</th>
</tr>
{if $ally_image}
<tr>
	<td colspan="2">
		<img src="{$ally_image}" alt="{$ally_tag}">
	</td>
</tr>
{/if}
<tr>
	<td>{$LNG.al_ally_info_tag}</td>
	<td>{$ally_tag}</td>
</tr>
<tr>
	<td>{$LNG.al_ally_info_name}</td>
	<td>{$ally_name}</td>
</tr>
<tr>
	<td>{$LNG.al_ally_info_members}</td>
	<td>{$ally_member_scount}</td>
</tr>
{if $ally_request}
<tr>
	<td>{$LNG.al_request}</td>
	<td><a href="game.php?page=alliance&amp;mode=apply&amp;id={$ally_id}">{$LNG.al_click_to_send_request}</a></td>
</tr>
{/if}
<tr>
	<td colspan="2" style="height:100px">{if !empty($ally_description)}{$ally_description}{else}{$LNG.al_description_message}{/if}</td>
</tr>
{if $ally_web}
<tr>
	<td>{$LNG.al_web_text}</td>
	<td><a href="{$ally_web}">{$ally_web}</a></td>
</tr>
{/if}
{if isset($DiploInfo)}
<tr>
	<th colspan="2">{$LNG.al_diplo}</th>
</tr>
<tr>
	<td colspan="2">
	{if !empty($DiploInfo.0)}<b><u>{$LNG.al_diplo_level.0}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.0}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
	{if !empty($DiploInfo.1)}<b><u>{$LNG.al_diplo_level.1}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.1}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
	{if !empty($DiploInfo.2)}<b><u>{$LNG.al_diplo_level.2}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.2}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
	{if !empty($DiploInfo.3)}<b><u>{$LNG.al_diplo_level.3}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.3}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
	{if !empty($DiploInfo.4)}<b><u>{$LNG.al_diplo_level.4}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.4}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}</td>
</tr>
{/if}
{if $ally_stats}
<tr>
	<th colspan="2">{$LNG.pl_fightstats}</th>
</tr>
<tr>
	<td>{$LNG.pl_totalfight}</td><td>{$totalfight|number}</td>
</tr>
<tr>
	<td>{$LNG.pl_fightwon}</td><td>{$fightwon|number} {if $totalfight}({round($fightwon / $totalfight * 100, 2)}%){/if}</td>
</tr>
<tr>	
	<td>{$LNG.pl_fightlose}</td><td>{$fightlose|number} {if $totalfight}({round($fightlose / $totalfight * 100, 2)}%){/if}</td>
</tr>
<tr>	
	<td>{$LNG.pl_fightdraw}</td><td>{$fightdraw|number} {if $totalfight}({round($fightdraw / $totalfight * 100, 2)}%){/if}</td>
</tr>
<tr>
	<td>{$LNG.pl_unitsshot}</td><td>{$unitsshot}</td>
</tr>
<tr>
	<td>{$LNG.pl_unitslose}</td><td>{$unitslose}</td>
</tr>
<tr>
	<td>{$LNG.pl_dermetal}</td><td>{$dermetal}</td>
</tr>
<tr>
	<td>{$LNG.pl_dercrystal}</td><td>{$dercrystal}</td>
</tr>
{/if}
</table>
{/block}