<form action="game.php?page=messages" method="post"><input name="mess_type" type="hidden" value="{$MessCategory}"><input name="mode" type="hidden" value="delete"><table style="max-width:100%;width:100%;margin:0px;padding:0px;"><tr><th colspan="4">{$mg_message_title}</td></tr><tr style="height: 20px;"><td>{$mg_action}</td><td>{$mg_date}</td><td>{if $MessCategory != 999}{$mg_from}{else}{$mg_to}{/if}</td><td>{$mg_subject}</td></tr>
{foreach key=MessID item=MessInfo from=$MessageList}
<tr style="height: 20px;">
<td style="width:40px;" rowspan="2">{if $MessInfo.type != 50 && $MessCategory != 999}<input name="delmes[{$MessID}]" type="checkbox">{/if}</td><td>{$MessInfo.time}</td>
<td>{if $MessInfo.type == 50 && $MessCategory == 999}{$mg_game_message}{else}{$MessInfo.from}{/if}</td>
<td>{$MessInfo.subject}
{if $MessInfo.type == 1 && $MessCategory != 999}
<a href="javascript:OpenPopup('game.php?page=messages&amp;mode=write&amp;id={$MessInfo.sender}&amp;subject=Re:{$MessInfo.subject|strip_tags}', '', 720, 300);" title="Nachricht an {$MessInfo.from|strip_tags} schreiben">
<img src="{$dpath}img/m.gif" border="0"></a>
{/if}
</td></tr>
<tr>
<td colspan="3" class="left">{$MessInfo.text}</td>
</tr>
{/foreach}{if $MessCategory != 999}
<tr>
<td colspan="4">
<select id="deletemessages" name="deletemessages">
{if $MessCategory != 50}<option value="deletemarked">{$mg_delete_marked}</option>
<option value="deleteunmarked">{$mg_delete_unmarked}</option><option value="deletetypeall">{$mg_delete_type_all}</option>{/if}
<option value="deleteall">{$mg_delete_all}</option>
</select>
<input value="{$mg_confirm_delete}" type="submit">
</td>{/if}
</tr>
</table></form>