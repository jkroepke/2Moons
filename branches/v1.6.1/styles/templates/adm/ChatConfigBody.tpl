{include file="adm/overall_header.tpl"}
<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="70%" cellpadding="2" cellspacing="2">
<tr>
	<th colspan="2">{$se_server_parameters}</th>
	<th>(?)</th>
</tr><tr>
	<td>{$ch_channelname}</td>
	<td><input name="chat_channelname" value="{$chat_channelname}" type="text"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$ch_botname}</td>
	<td><input name="chat_botname" value="{$chat_botname}" type="text"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$ch_nickchange}</td>
	<td><input name="chat_nickchange"{if $chat_nickchange == '1'} checked="checked"{/if} type="checkbox"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$ch_logmessage}</td>
	<td><input name="chat_logmessage"{if $chat_logmessage == '1'} checked="checked"{/if} type="checkbox"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$ch_allowmes}</td>
	<td><input name="chat_allowmes"{if $chat_allowmes == '1'} checked="checked"{/if} type="checkbox"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$ch_allowchan}</td>
	<td><input name="chat_allowchan"{if $chat_allowchan == '1'} checked="checked"{/if} type="checkbox"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$ch_closed}</td>
	<td><input name="chat_closed"{if $chat_closed == '1'} checked="checked"{/if} type="checkbox"></td>
	<td>&nbsp;</td>
</tr><tr>
	<th colspan="2">{$ch_socket}</th>
	<th>&nbsp;</th>
</tr><tr>
	<td>{$ch_socket_active}</td>
	<td><input name="chat_socket_active"{if $chat_socket_active == '1'} checked="checked"{/if} type="checkbox"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" onclick="window.open('http://sourceforge.net/apps/mediawiki/ajax-chat/index.php?title=Socket_Server');"></td>
</tr><tr>
	<td>{$ch_socket_host}</td>
	<td><input name="chat_socket_host" value="{$chat_socket_host}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$ch_socket_host_info}"></td>
</tr><tr>
	<td>{$ch_socket_ip}</td>
	<td><input name="chat_socket_ip" value="{$chat_socket_ip}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$ch_socket_ip_info}"></td>
</tr><tr>
	<td>{$ch_socket_port}</td>
	<td><input name="chat_socket_port" value="{$chat_socket_port}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$ch_socket_port_info}"></td>
</tr><tr>
	<td>{$ch_socket_chatid}</td>
	<td><input name="chat_socket_port" value="{$chat_socket_chatid}" type="text"></td>
	<td><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$ch_socket_chatid_info}"></td>
</tr>
<tr>
	<td colspan="3"><input value="{$se_save_parameters}" type="submit"></td>
</tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}