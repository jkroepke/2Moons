{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table width="519" align="center">
        <tr>
			<td class="c" colspan="9">{$al_users_list}</td>
        </tr>
        <tr>
            <th>{$al_num}</th>
            <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;sort1=1&amp;sort2={$s}">{$al_member}</a></th>
            <th>{$al_message}</th>
            <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;sort1=2&amp;sort2={$s}">{$al_position}</a></th>
            <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;sort1=3&amp;sort2={$s}">{$al_points}</a></th>
            <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;sort1=0&amp;sort2={$s}">{$al_coords}</a></th>
            <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;sort1=4&amp;sort2={$s}">{$al_member_since}</a></th>
            <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;sort1=5&amp;sort2={$s}">{$al_estate}</a></th>
            <th>{$al_actions}</th>
        </tr>
        {foreach name=Memberlist item=MemberInfo from=$Memberlist}
		<tr>
			<th>{$smarty.foreach.Memberlist.iteration}</th>
			<th>{$MemberInfo.username}</th>
			<th><a href="javascript:f('game.php?page=messages&amp;mode=write&amp;id={$MemberInfo.id}','');"><img src="{$dpath}img/m.gif" border="0" title="{$rite_message}" alt="{$rite_message}"></a></th>
			<th>{$MemberInfo.range}</th>
			<th>{$MemberInfo.points}</th>
			<th><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$MemberInfo.galaxy}&amp;system={$MemberInfo.system}">[{$MemberInfo.galaxy}:{$MemberInfo.system}:{$MemberInfo.planet}]</a></th>
			<th>{$MemberInfo.register_time}</th>
			<th>{$MemberInfo.onlinetime}</th>
			<th>{if $MemberInfo.action > 0}<a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;action=edit&amp;id={$MemberInfo.id}"><img src="{$dpath}pic/key.gif" border="0" alt=""></a>
			{if $MemberInfo.action == 2}<a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;action=kick&amp;id={$MemberInfo.id}" onclick="javascript:return confirm('{$MemberInfo.kick}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a>{/if}{else}-{/if}
		</th>
		</tr>
		{if $MemberInfo.id == $id}
		<tr>
			<th colspan="9">
			<form action="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;action=edit&amp;id={$MemberInfo.id}" name="editar_usu_rango" method="POST">
				{html_options name=newrang options=$Selector selected=$MemberInfo.rank_id}
				<input type="submit" value="{$al_ok}"> 
			</form>
			</th>
		</tr>
		{/if}
		{/foreach}
        <tr>
            <td class="c" colspan="9"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally">{$al_back}</a></td>
        </tr>
    </table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}