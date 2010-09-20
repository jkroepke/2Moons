{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table style="min-width:569px;width:569px;">
<tr><th colspan="6">{$bu_buddy_list}</th></tr>
<tr><th colspan="6" style="text-align:center">{$bu_requests}</th></tr>
<tr><th>{$bu_player}</th>
<th>{$bu_alliance}</th>
<th>{$bu_coords}</th>
<th>{$bu_text}</th>
<th>{$bu_action}</th>
</tr>
{foreach name=OutRequestList item=OutRequestInfo from=$OutRequestList}
<tr>
<td><a href="javascript:OpenPopup('game.php?page=messages&amp;mode=write&amp;id={$OutRequestInfo.playerid}', '', 720, 300);">{$OutRequestInfo.name}</a></td>
<td>{if {$OutRequestInfo.allyname}}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$OutRequestInfo.allyid}">{$OutRequestInfo.allyname}</a>{else}-{/if}</td>
<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$OutRequestInfo.galaxy}&amp;system={$OutRequestInfo.system}">{$OutRequestInfo.galaxy}:{$OutRequestInfo.system}:{$OutRequestInfo.planet}</a></td>
<td>{$OutRequestInfo.text}</td>
<td><a href="game.php?page=buddy&amp;mode=1&amp;sm=2&amp;bid={$OutRequestInfo.buddyid}">{$bu_accept}</a>
<br><a href="game.php?page=buddy&amp;mode=1&amp;sm=1&amp;bid={$OutRequestInfo.buddyid}">{$bu_decline}</a></td>
</tr>
{foreachelse}
<tr><td colspan="6">{$bu_no_request}</td></tr>
{/foreach}
<tr><th colspan="6" style="text-align:center">{$bu_my_requests}</th></tr>
<tr><th>{$bu_player}</th>
<th>{$bu_alliance}</th>
<th>{$bu_coords}</th>
<th>{$bu_text}</th>
<th>{$bu_action}</th>
</tr>
{foreach name=MyRequestList item=MyRequestInfo from=$MyRequestList}
<tr>
<td><a href="javascript:OpenPopup('game.php?page=messages&amp;mode=write&amp;id={$MyRequestInfo.playerid}', '', 720, 300);">{$MyRequestInfo.name}</a></td>
<td>{if {$MyRequestInfo.allyname}}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$MyRequestInfo.allyid}">{$MyRequestInfo.allyname}</a>{else}-{/if}</td>
<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$MyRequestInfo.galaxy}&amp;system={$MyRequestInfo.system}">{$MyRequestInfo.galaxy}:{$MyRequestInfo.system}:{$MyRequestInfo.planet}</a></td>
<td>{$MyRequestInfo.text}</td>
<td><a href="game.php?page=buddy&amp;mode=1&amp;sm=1&amp;bid={$MyRequestInfo.buddyid}">{$bu_cancel_request}</a></td></tr>
{foreachelse}
<tr><td colspan="6">{$bu_no_request}</td></tr>
{/foreach}
<tr><th colspan="6" style="text-align:center">{$bu_partners}</th></tr>
<tr>
<th>{$bu_player}</td>
<th>{$bu_alliance}</th>
<th>{$bu_coords}</th>
<th>{$bu_online}</th>
<th>{$bu_action}</th>
</tr>
{foreach name=MyBuddyList item=MyBuddyInfo from=$MyBuddyList}
<tr>
<td><a href="javascript:OpenPopup('game.php?page=messages&amp;mode=write&amp;id={$MyBuddyInfo.playerid}', '', 720, 300);">{$MyBuddyInfo.name}</a></td>
<td>{if {$MyBuddyInfo.allyname}}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$MyBuddyInfo.allyid}">{$MyBuddyInfo.allyname}</a>{else}-{/if}</td>
<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$MyBuddyInfo.galaxy}&amp;system={$MyBuddyInfo.system}">{$MyBuddyInfo.galaxy}:{$MyBuddyInfo.system}:{$MyBuddyInfo.planet}</a></td>
<td>
{if $MyBuddyInfo.onlinetime < 4}
<span style="color:lime">{$bu_connected}</span>
{elseif $MyBuddyInfo.onlinetime >= 4 && $MyBuddyInfo.onlinetime <= 15}
<span style="color:yellow">{$MyBuddyInfo.onlinetime} {$bu_minutes}</span>
{else}
<span style="color:red">{$bu_disconnected}</span>
{/if}
</td>
<td><a href="game.php?page=buddy&amp;mode=1&amp;sm=1&amp;bid={$MyBuddyInfo.buddyid}">{$bu_delete}</a></td></tr>
{foreachelse}
<tr><td colspan="6">{$bu_no_buddys}</td></tr>
{/foreach}
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}