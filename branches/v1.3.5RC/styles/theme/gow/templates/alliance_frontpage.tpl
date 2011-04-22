{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table class="table519">
        <tr>
        	<th colspan="2">{$al_your_ally}</th>
        </tr>
		{if $ally_image}
       	<tr>
			<td colspan="2"><img src="{$ally_image}"></td>
		</tr>
		{/if}
        <tr>
            <td style="width:50%">{$al_ally_info_tag}</td>
            <td style="width:50%">{$ally_tag}</td>
        </tr>
        <tr>
            <td>{$al_ally_info_name}</td>
            <td>{$ally_name}</td>
        </tr>
        <tr>
            <td>{$al_ally_info_members}</td>
            <td>{$ally_members}{if $rights.memberlist} (<a href="?page=alliance&amp;mode=memberslist">{$al_user_list}</a>){/if}</td>
        </tr>
        <tr>
            <td>{$al_rank}</td>
            <td>{$range}{if $rights.admin} (<a href="?page=alliance&amp;mode=admin&amp;edit=ally">{$al_manage_alliance}</a>){/if}</td>
        </tr>
        <tr>
            <td colspan="2"><a href="javascript:OpenPopup('?page=chat&amp;chat_type=ally', '', 800, 800);">{$al_goto_chat}</a></td>
        </tr> 
		{if $rights.seeapply && $req_count > 0}		
        <tr>
			<td>{$al_requests}</td><td><a href="?page=alliance&amp;mode=admin&amp;edit=requests">{$requests}</a></td>
		</tr>
        {/if}
		{if $rights.roundmail}
		<tr>
			<td>{$al_circular_message}</td><td><a href="javascript:OpenPopup('?page=alliance&amp;mode=circular','', 720, 300);">{$al_send_circular_message}</a></td>
		</tr>
        {/if}
		<tr>
        	<td colspan="2" style="height:100px" class="bbcode">{if $ally_description}{$ally_description}{else}{$al_description_message}{/if}</td>
        </tr>
		{if $ally_web}
        <tr>
            <td>{$al_web_text}</td>
            <td><a href="{$ally_web}">{$ally_web}</a></td>
        </tr>
		{/if}
        <tr>
        	<th colspan="2">{$al_inside_section}</th>
        </tr>
        <tr>
        	<td colspan="2" height="100" class="bbcode">{$ally_text}</td>
        </tr>
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
    </table>
	{if $isowner}
	<table class="table519">
		<tr>
			<th>{$al_leave_alliance}</th>
		</tr>
		<tr>
			<td><input type="button" onclick="javascript:if(confirm('{$al_leave_ally}')) location.href='game.php?page=alliance&amp;mode=exit';" value="{$al_continue}"></td>
		</tr>
	</table>
	{/if}
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}