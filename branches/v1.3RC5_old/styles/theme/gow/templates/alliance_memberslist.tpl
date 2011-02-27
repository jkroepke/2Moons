{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table style="width:50%">
        <tr>
          <th colspan="8">{$al_users_list}</th>
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
			<td>{$smarty.foreach.Memberlist.iteration}</td>
			<td>{$MemberInfo.username}</td>
			<td><a href="javascript:OpenPopup('game.php?page=messages&amp;mode=write&amp;id={$MemberInfo.id}','' , 720, 300);"><img src="{$dpath}img/m.gif" border="0" title="{$write_message}"></a></td>
			<td>{$MemberInfo.range}</td>
			<td>{$MemberInfo.points}</td>
			<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$MemberInfo.galaxy}&amp;system={$MemberInfo.system}">[{$MemberInfo.galaxy}:{$MemberInfo.system}:{$MemberInfo.planet}]</a></td>
			<td>{$MemberInfo.register_time}</td>
			<td>{if $seeonline}{if $MemberInfo.onlinetime < 4}<span style="color:lime">{$al_memberlist_on}</span>{elseif $MemberInfo.onlinetime >= 4 && $MemberInfo.onlinetime <= 15}<span style="color:yellow">{$MemberInfo.onlinetime} {$al_memberlist_min}</span>{else}<span style="color:red">{$al_memberlist_off}</span>{/if}{else}-{/if}</td>
		</tr>
		{/foreach}
        <tr>
          <th colspan="8"><a href="game.php?page=alliance">{$al_back}</a></th>
        </tr>
    </table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}