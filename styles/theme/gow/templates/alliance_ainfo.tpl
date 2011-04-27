{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
<table class="table519">
    <tr>
    	<th colspan="2">{$al_ally_information}</th>
    </tr>
	{if $ally_image}
    <tr>
		<td colspan="2">
			<img src="{$ally_image}" alt="{$ally_tag}">
		</td>
	</tr>
    {/if}
	<tr>
        <td>{$al_ally_info_tag}</td>
        <td>{$ally_tag}</td>
    </tr>
    <tr>
        <td>{$al_ally_info_name}</td>
        <td>{$ally_name}</td>
    </tr>
    <tr>
        <td>{$al_ally_info_members}</td>
        <td>{$ally_member_scount}</td>
    </tr>
	{if $ally_request}
	<tr>
		<td>{$al_request}</td>
		<td><a href="game.php?page=alliance&amp;mode=apply&amp;allyid={$ally_id}">{$al_click_to_send_request}</a></td>
	</tr>
    {/if}
	<tr>
		<td colspan="2" style="height:100px">{if $ally_description}{$ally_description}{else}{$al_description_message}{/if}</td>
	</tr>
	{if $ally_web}
    <tr>
		<td>{$al_web_text}</td>
		<td><a href="{$ally_web}">{$ally_web}</a></td>
	</tr>
	{/if}
	{if $DiploInfo}
    <tr>
		<th colspan="2">{$al_diplo}</th>
	</tr>
	<tr>
		<td colspan="2">{if !empty($DiploInfo.0)}<b><u>{$al_diplo_level.0}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.0}<a href="?page=alliance&mode=ainfo&a={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
		{if !empty($DiploInfo.1)}<b><u>{$al_diplo_level.1}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.1}<a href="?page=alliance&mode=ainfo&a={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
		{if !empty($DiploInfo.2)}<b><u>{$al_diplo_level.2}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.2}<a href="?page=alliance&mode=ainfo&a={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
		{if !empty($DiploInfo.3)}<b><u>{$al_diplo_level.3}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.3}<a href="?page=alliance&mode=ainfo&a={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
		{if !empty($DiploInfo.4)}<b><u>{$al_diplo_level.4}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.4}<a href="?page=alliance&mode=ainfo&a={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}</td>
	</tr>
	{/if}
	{if $ally_stats}
    <tr>
		<th colspan="2">{$al_Allyquote}</th>
	</tr>
	<tr>
		<td>{$pl_totalfight}</td><td>{pretty_number($totalfight)}</td>
	</tr>
	<tr>
		<td>{$pl_fightwon}</td><td>{pretty_number($fightwon)} {if $totalfight}({round($fightwon / $totalfight * 100, 2)}%){/if}</td>
	</tr>
	<tr>	
		<td>{$pl_fightlose}</td><td>{pretty_number($fightlose)} {if $totalfight}({round($fightlose / $totalfight * 100, 2)}%){/if}</td>
	</tr>
	<tr>	
		<td>{$pl_fightdraw}</td><td>{pretty_number($fightdraw)} {if $totalfight}({round($fightdraw / $totalfight * 100, 2)}%){/if}</td>
	</tr>
	<tr>
		<td>{$pl_unitsshot}</td><td>{$unitsshot}</td>
	</tr>
	<tr>
		<td>{$pl_unitslose}</td><td>{$unitslose}</td>
	</tr>
	<tr>
		<td>{$pl_dermetal}</td><td>{$dermetal}</td>
	</tr>
	<tr>
		<td>{$pl_dercrystal}</td><td>{$dercrystal}</td>
	</tr>
	{/if}
    </table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}