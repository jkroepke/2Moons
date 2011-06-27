{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
	<table class="table569">
	<tr><th colspan="6">{lang}bu_buddy_list{/lang}</th></tr>
	<tr><th colspan="6" style="text-align:center">{lang}bu_requests{/lang}</th></tr>
	<tr>
		<th>{lang}bu_player{/lang}</th>
		<th>{lang}bu_alliance{/lang}</th>
		<th>{lang}bu_coords{/lang}</th>
		<th>{lang}bu_text{/lang}</th>
		<th>{lang}bu_action{/lang}</th>
	</tr>
	{foreach name=OutRequestList item=OutRequestInfo from=$OutRequestList}
	<tr>
		<td><a href="#" onclick="return Dialog.PM({$OutRequestInfo.id});">{$OutRequestInfo.username}</a></td>
		<td>{if {$OutRequestInfo.ally_name}}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$OutRequestInfo.ally_id}">{$OutRequestInfo.ally_name}</a>{else}-{/if}</td>
		<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$OutRequestInfo.galaxy}&amp;system={$OutRequestInfo.system}">{$OutRequestInfo.galaxy}:{$OutRequestInfo.system}:{$OutRequestInfo.planet}</a></td>
		<td>{$OutRequestInfo.text}</td>
		<td><a href="game.php?page=buddy&amp;mode=1&amp;sm=2&amp;bid={$OutRequestInfo.buddyid}">{lang}bu_accept{/lang}</a>
		<br><a href="game.php?page=buddy&amp;mode=1&amp;sm=1&amp;bid={$OutRequestInfo.buddyid}">{lang}bu_decline{/lang}</a></td>
	</tr>
	{foreachelse}
	<tr><td colspan="6">{lang}bu_no_request{/lang}</td></tr>
	{/foreach}
	<tr><th colspan="6" style="text-align:center">{lang}bu_my_requests{/lang}</th></tr>
	<tr>
		<th>{lang}bu_player{/lang}</th>
		<th>{lang}bu_alliance{/lang}</th>
		<th>{lang}bu_coords{/lang}</th>
		<th>{lang}bu_text{/lang}</th>
		<th>{lang}bu_action{/lang}</th>
	</tr>
	{foreach name=MyRequestList item=MyRequestInfo from=$MyRequestList}
	<tr>
		<td><a href="#" onclick="return Dialog.PM({$MyRequestInfo.id});">{$MyRequestInfo.username}</a></td>
		<td>{if {$MyRequestInfo.ally_name}}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$MyRequestInfo.ally_id}">{$MyRequestInfo.ally_name}</a>{else}-{/if}</td>
		<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$MyRequestInfo.galaxy}&amp;system={$MyRequestInfo.system}">{$MyRequestInfo.galaxy}:{$MyRequestInfo.system}:{$MyRequestInfo.planet}</a></td>
		<td>{$MyRequestInfo.text}</td>
		<td><a href="game.php?page=buddy&amp;mode=1&amp;sm=1&amp;bid={$MyRequestInfo.buddyid}">{lang}bu_cancel_request{/lang}</a></td>
	</tr>
	{foreachelse}
	<tr><td colspan="6">{lang}bu_no_request{/lang}</td></tr>
	{/foreach}
	<tr><th colspan="6" style="text-align:center">{lang}bu_partners{/lang}</th></tr>
		<tr>
		<th>{lang}bu_player{/lang}</td>
		<th>{lang}bu_alliance{/lang}</th>
		<th>{lang}bu_coords{/lang}</th>
		<th>{lang}bu_online{/lang}</th>
		<th>{lang}bu_action{/lang}</th>
	</tr>
	{foreach name=MyBuddyList item=MyBuddyInfo from=$MyBuddyList}
	<tr>
		<td><a href="#" onclick="return Dialog.PM({$MyBuddyInfo.id});">{$MyBuddyInfo.username}</a></td>
		<td>{if {$MyBuddyInfo.ally_name}}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$MyBuddyInfo.ally_id}">{$MyBuddyInfo.ally_name}</a>{else}-{/if}</td>
		<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$MyBuddyInfo.galaxy}&amp;system={$MyBuddyInfo.system}">{$MyBuddyInfo.galaxy}:{$MyBuddyInfo.system}:{$MyBuddyInfo.planet}</a></td>
		<td>
		{if $MyBuddyInfo.onlinetime < 4}
		<span style="color:lime">{lang}bu_connected{/lang}</span>
		{elseif $MyBuddyInfo.onlinetime >= 4 && $MyBuddyInfo.onlinetime <= 15}
		<span style="color:yellow">{$MyBuddyInfo.onlinetime} {lang}bu_minutes{/lang}</span>
		{else}
		<span style="color:red">{lang}bu_disconnected{/lang}</span>
		{/if}
		</td>
		<td><a href="game.php?page=buddy&amp;mode=1&amp;sm=1&amp;bid={$MyBuddyInfo.buddyid}">{lang}bu_delete{/lang}</a></td>
	</tr>
	{foreachelse}
	<tr><td colspan="6">{lang}bu_no_buddys{/lang}</td></tr>
	{/foreach}
	</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}