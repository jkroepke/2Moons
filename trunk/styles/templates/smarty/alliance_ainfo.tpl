{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table width="519" align="center">
    <tr>
    	<td class="c" colspan="2">{$al_ally_information}</td>
    </tr>
	{if $ally_image}
    <tr>
		<th colspan="2">
			<img src="{$ally_image}" alt="{$ally_tag}">
		</th>
	</tr>
    {/if}
	<tr>
        <th>{$al_ally_info_tag}</th>
        <th>{$ally_tag}</th>
    </tr>
    <tr>
        <th>{$al_ally_info_name}</th>
        <th>{$ally_name}</th>
    </tr>
    <tr>
        <th>{$al_ally_info_members}</th>
        <th>{$ally_member_scount}</th>
    </tr>
	{if $ally_request}
	<tr>
		<th>{$al_request}</th>
		<th><a href="game.php?page=alliance&amp;mode=apply&amp;allyid={$ally_id}">{$al_click_to_send_request}</a></th>
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
	{if $ally_stats}
    <tr>
		<td class="c" colspan="2">{$al_Allyquote}</td>
	</tr>
	<tr>
		<th>{$pl_totalfight}</th><th align="right">{$totalfight}</th>
	</tr>
	<tr>
		<th>{$pl_fightwon}</th><th>{$fightwon} {if $totalfight}({round($fightwon / $totalfight * 100)}%){/if}</th>
	</tr>
	<tr>	
		<th>{$pl_fightlose}</th><th>{$fightlose} {if $totalfight}({round($fightlose / $totalfight * 100)}%){/if}</th>
	</tr>
	<tr>	
		<th>{$pl_fightdraw}</th><th>{$fightdraw} {if $totalfight}({round($fightdraw / $totalfight * 100)}%){/if}</th>
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
	{/if}
    </table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}