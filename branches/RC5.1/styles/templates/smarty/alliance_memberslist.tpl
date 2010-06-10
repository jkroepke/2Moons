{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table width="600" align="center">
        <tr>
          <td class="c" colspan="8">{$al_users_list}</td>
        </tr>
        <tr>
          <th>{$al_num}</th>
          <th><a href="game.php?page=alliance&amp;mode=memberslist&amp;sort1=1&amp;sort2={$sort}">{$al_member}</a></th>
          <th>{$al_message}</th>
          <th><a href="game.php?page=alliance&amp;mode=memberslist&amp;sort1=2&amp;sort2={$sort}">{$al_position}</a></th>
          <th><a href="game.php?page=alliance&amp;mode=memberslist&amp;sort1=3&amp;sort2={$sort}">{$al_points}</a></th>
          <th><a href="game.php?page=alliance&amp;mode=memberslist&amp;sort1=0&amp;sort2={$sort}">{$al_coords}</a></th>
          <th><a href="game.php?page=alliance&amp;mode=memberslist&amp;sort1=4&amp;sort2={$sort}">{$al_member_since}</a></th>
          <th><a href="game.php?page=alliance&amp;mode=memberslist&amp;sort1=5&amp;sort2={$sort}">{$al_estate}</a></th>
        </tr>
        {foreach name=Memberlist item=MemberInfo from=$Memberlist}
		<tr>
			<th>{$smarty.foreach.Memberlist.iteration}</th>
			<th>{$MemberInfo.username}</th>
			<th><a href="javascript:f('game.php?page=messages&amp;mode=write&amp;id={$MemberInfo.id}','');"><img src="{$dpath}img/m.gif" border="0" title="{$rite_message}"></a></th>
			<th>{$MemberInfo.range}</th>
			<th>{$MemberInfo.points}</th>
			<th><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$MemberInfo.galaxy}&amp;system={$MemberInfo.system}">[{$MemberInfo.galaxy}:{$MemberInfo.system}:{$MemberInfo.planet}]</a></th>
			<th>{$MemberInfo.register_time}</th>
			<th>{if $seeonline}{if $MemberInfo.onlinetime < 4}<font color="lime">{$al_memberlist_on}</font>{elseif $MemberInfo.onlinetime >= 4 && $MemberInfo.onlinetime <= 15}<font color="yellow">{$MemberInfo.onlinetime} {$al_memberlist_min}</font>{else}<font color="red">{$al_memberlist_off}</font>{/if}{else}-{/if}</th>
		</tr>
		{/foreach}
        <tr>
          <td class="c" colspan="9"><a href="game.php?page=alliance">{$al_back}</a></td>
        </tr>
    </table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}