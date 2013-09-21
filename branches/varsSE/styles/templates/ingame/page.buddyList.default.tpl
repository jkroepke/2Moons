{block name="title" prepend}{$LNG.lm_buddylist}{/block}
{block name="content"}
<table class="table569">
<tr><th colspan="5">{$LNG.bu_buddy_list}</th></tr>
{if !empty($otherRequestList)}
<tr><th colspan="5" style="text-align:center">{$LNG.bu_requests}</th></tr>
<tr>
	<th>{$LNG.bu_player}</th>
	<th>{$LNG.bu_alliance}</th>
	<th>{$LNG.bu_coords}</th>
	<th>{$LNG.bu_text}</th>
	<th>{$LNG.bu_action}</th>
</tr>
{foreach $otherRequestList as $otherRequestID => $otherRequestRow}
<tr>
	<td><a href="#" onclick="return Dialog.PM({$otherRequestRow.id});">{$otherRequestRow.username}</a></td>
	<td>{if {$otherRequestRow.ally_name}}<a href="game.php?page=alliance&amp;mode=info&amp;id={$otherRequestRow.ally_id}">{$otherRequestRow.ally_name}</a>{else}-{/if}</td>
	<td><a href="game.php?page=galaxy&amp;galaxy={$otherRequestRow.galaxy}&amp;system={$otherRequestRow.system}">[{$otherRequestRow.galaxy}:{$otherRequestRow.system}:{$otherRequestRow.planet}]</a></td>
	<td>{$otherRequestRow.text}</td>
	<td><a href="game.php?page=buddyList&amp;mode=accept&amp;id={$otherRequestID}"><img src="styles/resource/images/true.png" alt="{$LNG.bu_accept}" title="{$LNG.bu_accept}"></a><a href="game.php?page=buddyList&amp;mode=delete&amp;id={$otherRequestID}"><img src="styles/resource/images/false.png" alt="{$LNG.bu_decline}" title="{$LNG.bu_decline}"></a></td>
</tr>
{foreachelse}
<tr><td colspan="5">{$LNG.bu_no_request}</td></tr>
{/foreach}
{/if}
{if !empty($myRequestList)}
<tr><th colspan="5" style="text-align:center">{$LNG.bu_my_requests}</th></tr>
<tr>
	<th>{$LNG.bu_player}</th>
	<th>{$LNG.bu_alliance}</th>
	<th>{$LNG.bu_coords}</th>
	<th>{$LNG.bu_text}</th>
	<th>{$LNG.bu_action}</th>
</tr>
{foreach $myRequestList as $myRequestID => $myRequestRow}
<tr>
	<td><a href="#" onclick="return Dialog.PM({$myRequestRow.id});">{$myRequestRow.username}</a></td>
	<td>{if {$myRequestRow.ally_name}}<a href="game.php?page=alliance&amp;mode=info&amp;id={$myRequestRow.ally_id}">{$myRequestRow.ally_name}</a>{else}-{/if}</td>
	<td><a href="game.php?page=galaxy&amp;galaxy={$myRequestRow.galaxy}&amp;system={$myRequestRow.system}">[{$myRequestRow.galaxy}:{$myRequestRow.system}:{$myRequestRow.planet}]</a></td>
	<td>{$myRequestRow.text}</td>
	<td><a href="game.php?page=buddyList&amp;mode=delete&amp;id={$myRequestID}"><img src="styles/resource/images/false.png" alt="{$LNG.bu_cancel_request}" title="{$LNG.bu_cancel_request}"></a></td>
</tr>
{foreachelse}
<tr><td colspan="5">{$LNG.bu_no_request}</td></tr>
{/foreach}
{/if}
<tr><th colspan="5" style="text-align:center">{$LNG.bu_partners}</th></tr>
	<tr>
	<th>{$LNG.bu_player}</td>
	<th>{$LNG.bu_alliance}</th>
	<th>{$LNG.bu_coords}</th>
	<th>{$LNG.bu_online}</th>
	<th>{$LNG.bu_action}</th>
</tr>
{foreach $myBuddyList as $myBuddyID => $myBuddyRow}
<tr>
	<td><a href="#" onclick="return Dialog.PM({$myBuddyRow.id});">{$myBuddyRow.username}</a></td>
	<td>{if {$myBuddyRow.ally_name}}<a href="game.php?page=alliance&amp;mode=info&amp;id={$myBuddyRow.ally_id}">{$myBuddyRow.ally_name}</a>{else}-{/if}</td>
	<td><a href="game.php?page=galaxy&amp;galaxy={$myBuddyRow.galaxy}&amp;system={$myBuddyRow.system}">[{$myBuddyRow.galaxy}:{$myBuddyRow.system}:{$myBuddyRow.planet}]</a></td>
	<td>
	{if $myBuddyRow.onlinetime < 4}
	<span style="color:lime">{$LNG.bu_connected}</span>
	{elseif $myBuddyRow.onlinetime >= 4 && $myBuddyRow.onlinetime <= 15}
	<span style="color:yellow">{$myBuddyRow.onlinetime} {$LNG.bu_minutes}</span>
	{else}
	<span style="color:red">{$LNG.bu_disconnected}</span>
	{/if}
	</td>
	<td><a href="game.php?page=buddyList&amp;mode=delete&amp;id={$myBuddyID}"><img src="styles/resource/images/false.png" alt="{$LNG.bu_delete}" title="{$LNG.bu_delete}"></a></td>
</tr>
{foreachelse}
<tr><td colspan="5">{$LNG.bu_no_buddys}</td></tr>
{/foreach}
</table>
{/block}