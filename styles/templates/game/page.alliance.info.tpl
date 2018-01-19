{block name="title" prepend}{$LNG.lm_alliance}{/block}
{block name="content"}
<table class="table519">
<tr>
	<th colspan="2">{$LNG.al_ally_information}</th>
</tr>
{if $ally_image}
<tr>
	<td colspan="2">
		<img style="max-width: 1024px;" src="{$ally_image}" alt="{$ally_tag}">
	</td>
</tr>
{/if}
<tr>
	<td style="width:50%">{$LNG.al_ally_info_tag}</td>
	<td style="width:50%">{$ally_tag}</td>
</tr>
<tr>
	<td>{$LNG.al_ally_info_name}</td>
	<td>{$ally_name}</td>
</tr>
<tr>
	<td>{$LNG.al_ally_info_members}</td>
	<td>{$ally_member_scount} / {$ally_max_members}</td>
</tr>
{if $ally_request}
<tr>
	<td>{$LNG.al_request}</td>
	{if $ally_request_min_points}
	<td><a href="game.php?page=alliance&amp;mode=apply&amp;id={$ally_id}">{$LNG.al_click_to_send_request}</a></td>
	{else}
		<td>{$ally_request_min_points_info}
	{/if}
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
{if $diplomaticData}
<tr>
	<th colspan="2">{$LNG.al_diplo}</th>
</tr>
<tr>
	<td colspan="2">
	{if $diplomaticData}
	{if !empty($diplomaticData.0)}<b><u>{$LNG.al_diplo_level.0}</u></b><br><br>{foreach item=PaktInfo from=$diplomaticData.0}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
	{if !empty($diplomaticData.1)}<b><u>{$LNG.al_diplo_level.1}</u></b><br><br>{foreach item=PaktInfo from=$diplomaticData.1}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
	{if !empty($diplomaticData.2)}<b><u>{$LNG.al_diplo_level.2}</u></b><br><br>{foreach item=PaktInfo from=$diplomaticData.2}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
	{if !empty($diplomaticData.3)}<b><u>{$LNG.al_diplo_level.3}</u></b><br><br>{foreach item=PaktInfo from=$diplomaticData.3}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
		{if !empty($diplomaticData.4)}<b><u>{$LNG.al_diplo_level.4}</u></b><br><br>{foreach item=PaktInfo from=$diplomaticData.4}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
	{else}
		{$LNG.al_no_diplo}
	{/if}
	</td>
</tr>
{/if}
{if !empty($statisticData)}
<tr>
	<th colspan="2">{$LNG.pl_fightstats}</th>
</tr>
<tr>
	<td>{$LNG.pl_totalfight}</td><td>{$statisticData.totalfight|number}</td>
</tr>
<tr>
	<td>{$LNG.pl_fightwon}</td><td>{$statisticData.fightwon|number}{if $statisticData.totalfight} ({round($statisticData.fightwon / $statisticData.totalfight * 100, 2)}%){/if}</td>
</tr>
<tr>	
	<td>{$LNG.pl_fightlose}</td><td>{$statisticData.fightlose|number}{if $statisticData.totalfight} ({round($statisticData.fightlose / $statisticData.totalfight * 100, 2)}%){/if}</td>
</tr>
<tr>	
	<td>{$LNG.pl_fightdraw}</td><td>{$statisticData.fightdraw|number}{if $statisticData.totalfight} ({round($statisticData.fightdraw / $statisticData.totalfight * 100, 2)}%){/if}</td>
</tr>
<tr>
	<td>{$LNG.pl_unitsshot}</td><td>{$statisticData.unitsshot}</td>
</tr>
<tr>
	<td>{$LNG.pl_unitslose}</td><td>{$statisticData.unitslose}</td>
</tr>
<tr>
	<td>{$LNG.pl_dermetal}</td><td>{$statisticData.dermetal}</td>
</tr>
<tr>
	<td>{$LNG.pl_dercrystal}</td><td>{$statisticData.dercrystal}</td>
</tr>
{/if}
</table>
{/block}