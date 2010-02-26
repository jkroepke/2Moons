{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table width="520" align="center">
<tr><td class="c" colspan="6">{$bu_buddy_list}</td></tr>
<tr><td class="c" colspan="6" style="text-align:center">{$bu_requests}</td></tr>
<tr><td class="c">{$bu_player}</td>
<td class="c">{$bu_alliance}</td>
<td class="c">{$bu_coords}</td>
<td class="c">{$bu_text}</td>
<td class="c">{$bu_action}</td>
</tr>
{foreach name=OutRequestList item=OutRequestInfo from=$OutRequestList}
<tr>
<th><a href="javascript:f('game.php?page=messages&amp;mode=write&amp;id={$OutRequestInfo.playerid}','');">{$OutRequestInfo.name}</a></th>
<th>{if {$OutRequestInfo.allyname}}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$OutRequestInfo.allyid}">{$OutRequestInfo.allyname}</a>{else}-{/if}</th>
<th><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$OutRequestInfo.galaxy}&amp;system={$OutRequestInfo.system}">{$OutRequestInfo.galaxy}:{$OutRequestInfo.system}:{$OutRequestInfo.planet}</a></th>
<th>{$OutRequestInfo.text}</th>
<th><a href="game.php?page=buddy&amp;mode=1&amp;sm=2&amp;bid={$OutRequestInfo.buddyid}">{$bu_accept}</a>
<br><a href="game.php?page=buddy&amp;mode=1&amp;sm=1&amp;bid={$OutRequestInfo.buddyid}">{$bu_decline}</a></th>
</tr>
{foreachelse}
<tr><th colspan="6">{$bu_no_request}</th></tr>
{/foreach}
<tr><td class="c" colspan="6" style="text-align:center">{$bu_my_requests}</td></tr>
<tr><td class="c">{$bu_player}</td>
<td class="c">{$bu_alliance}</td>
<td class="c">{$bu_coords}</td>
<td class="c">{$bu_text}</td>
<td class="c">{$bu_action}</td>
</tr>
{foreach name=MyRequestList item=MyRequestInfo from=$MyRequestList}
<tr>
<th><a href="javascript:f('game.php?page=messages&amp;mode=write&amp;id={$MyRequestInfo.playerid}','');">{$MyRequestInfo.name}</a></th>
<th>{if {$MyRequestInfo.allyname}}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$MyRequestInfo.allyid}">{$MyRequestInfo.allyname}</a>{else}-{/if}</th>
<th><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$MyRequestInfo.galaxy}&amp;system={$MyRequestInfo.system}">{$MyRequestInfo.galaxy}:{$MyRequestInfo.system}:{$MyRequestInfo.planet}</a></th>
<th>{$MyRequestInfo.text}</th>
<th><a href="game.php?page=buddy&amp;mode=1&amp;sm=1&amp;bid={$MyRequestInfo.buddyid}">{$bu_cancel_request}</a></th></tr>
{foreachelse}
<tr><th colspan="6">{$bu_no_request}</th></tr>
{/foreach}
<tr><td class="c" colspan="6" style="text-align:center">{$bu_partners}</td></tr>
<tr>
<td class="c">{$bu_player}</td>
<td class="c">{$bu_alliance}</td>
<td class="c">{$bu_coords}</td>
<td class="c">{$bu_online}</td>
<td class="c">{$bu_action}</td>
</tr>
{foreach name=MyBuddyList item=MyBuddyInfo from=$MyBuddyList}
<tr>
<th><a href="javascript:f('game.php?page=messages&amp;mode=write&amp;id={$MyBuddyInfo.playerid}','');">{$MyBuddyInfo.name}</a></th>
<th>{if {$MyBuddyInfo.allyname}}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$MyBuddyInfo.allyid}">{$MyBuddyInfo.allyname}</a>{else}-{/if}</th>
<th><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$MyBuddyInfo.galaxy}&amp;system={$MyBuddyInfo.system}">{$MyBuddyInfo.galaxy}:{$MyBuddyInfo.system}:{$MyBuddyInfo.planet}</a></th>
<th>
{if $MyBuddyInfo.onlinetime < 4}
<font color="lime">{$bu_connected}</font>
{elseif $MyBuddyInfo.onlinetime >= 4 && $MyBuddyInfo.onlinetime <= 15}
<font color="yellow">{$MyBuddyInfo.onlinetime} {$bu_minutes}</font>
{else}
<font color="red">{$bu_disconnected}</font>
{/if}
</th>
<th><a href="game.php?page=buddy&amp;mode=1&amp;sm=1&amp;bid={$MyBuddyInfo.buddyid}">{$bu_delete}</a></th></tr>
{foreachelse}
<tr><th colspan="6">{$bu_no_buddys}</th></tr>
{/foreach}
</table></div>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}