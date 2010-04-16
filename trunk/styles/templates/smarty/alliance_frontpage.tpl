{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table width="519" align="center">
        <tr>
        	<td class="c" colspan="2">{$al_your_ally}</td>
        </tr>
		{if $ally_image}
       	<tr>
			<th colspan="2"><img src="{$ally_image}"></th>
		</tr>
		{/if}
        <tr>
            <th style="width:50%">{$al_ally_info_tag}</th>
            <th style="width:50%">{$ally_tag}</th>
        </tr>
        <tr>
            <th>{$al_ally_info_name}</th>
            <th>{$ally_name}</th>
        </tr>
        <tr>
            <th>{$al_ally_info_members}</th>
            <th>{$ally_members}{if $rights.memberlist} (<a href="?page=alliance&amp;mode=memberslist">{$al_user_list}</a>){/if}</th>
        </tr>
        <tr>
            <th>{$al_rank}</th>
            <th>{$range}{if $rights.admin} (<a href="?page=alliance&amp;mode=admin&amp;edit=ally">{$al_manage_alliance}</a>){/if}</th>
        </tr>
        <tr>
            <th colspan="2"><a href="javascript:f('?page=chat&amp;chat_type=ally','');">Zum Allianz-Chat</a></th>
        </tr> 
		{if $rights.seeapply && $requests != 0}		
        <tr>
			<th>{$al_requests}</th><th><a href="?page=alliance&amp;mode=admin&amp;edit=requests">{$requests}</a></th>
		</tr>
        {/if}
		{if $rights.roundmail}
		<tr>
			<th>{$al_circular_message}</th><th><a href="javascript:f('?page=alliance&amp;mode=circular','');">{$al_send_circular_message}</a></th>
		</tr>
        {/if}
		<tr>
        	<th colspan="2" height="100">{if $ally_description}{$ally_description}{else}{$al_description_message}{/if}</th>
        </tr>
		{if $ally_web}
        <tr>
            <th>{$al_web_text}</th>
            <th><a href="{$ally_web}">{$ally_web}</a></th>
        </tr>
		{/if}
        <tr>
        	<td class="c" colspan="2">{$al_inside_section}</td>
        </tr>
        <tr>
        	<th colspan="2" height="100">{$ally_text}</th>
        </tr>
		{if $DiploInfo}
		<tr>
			<td class="c" colspan="2">{$al_diplo}</td>
		</tr>
		<tr>
			<th colspan="2">{if !empty($DiploInfo.0)}<b><u>{$al_diplo_level.0}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.0}<a href="?page=alliance&mode=ainfo&a={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
			{if !empty($DiploInfo.1)}<b><u>{$al_diplo_level.1}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.1}<a href="?page=alliance&mode=ainfo&a={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
			{if !empty($DiploInfo.2)}<b><u>{$al_diplo_level.2}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.2}<a href="?page=alliance&mode=ainfo&a={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
			{if !empty($DiploInfo.3)}<b><u>{$al_diplo_level.3}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.3}<a href="?page=alliance&mode=ainfo&a={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
			{if !empty($DiploInfo.4)}<b><u>{$al_diplo_level.4}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.4}<a href="?page=alliance&mode=ainfo&a={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}</th>
		</tr>
		{/if}
		<tr>
			<td class="c" colspan="2">{$al_Allyquote}</td>
		</tr>
		<tr>
			<th>{$pl_totalfight}</th><th align="right">{pretty_number($totalfight)}</th>
		</tr>
		<tr>
			<th>{$pl_fightwon}</th><th>{pretty_number($fightwon)} {if $totalfight}({round($fightwon / $totalfight * 100, 2)}%){/if}</th>
		</tr>
		<tr>	
			<th>{$pl_fightlose}</th><th>{pretty_number($fightlose)} {if $totalfight}({round($fightlose / $totalfight * 100, 2)}%){/if}</th>
		</tr>
		<tr>	
			<th>{$pl_fightdraw}</th><th>{pretty_number($fightdraw)} {if $totalfight}({round($fightdraw / $totalfight * 100, 2)}%){/if}</th>
		</tr>
		<tr>
			<th>{$pl_unitsshot}</th><th>{$unitsshot}</th>
		</tr>
		<tr>
			<th>{$pl_unitslose}</th><th>{$unitslose}</th>
		</tr>
		<tr>
			<th>{$pl_dermetal}</th><th>{$dermetal}</th>
		</tr>
		<tr>
			<th>{$pl_dercrystal}</th><th>{$dercrystal}</th>
		</tr>
    </table>
	{if $isowner}
	<table width="519" align="center">
		<tr>
			<td class="c">{$al_leave_alliance}</td>
		</tr>
		<tr>
			<th><input type="button" onclick="javascript:location.href='game.php?page=alliance&amp;mode=exit';" value="{$al_continue}"></th>
		</tr>
	</table>
	{/if}
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}