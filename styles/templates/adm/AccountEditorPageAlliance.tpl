{include file="adm/overall_header.tpl"}
<form action="" method="post">
<table width="55%">
<tr>
<td colspan="3" align="left"><a href="?page=accounteditor">
<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$ad_back_to_menu}</a></td>
</tr><tr>
	<th colspan="7">{$ad_ally_title}</th>
</tr><tr>
	<td>{$input_id_ally}</td>
	<td><input name="id" type="text" size="5"></td>
</tr><tr>
	<td>{$ad_ally_change_id}&nbsp;{$ad_ally_user_id}</td>
	<td><input name="changeleader" type="text" size="5"></td>
</tr><tr>
	<td>{$ad_ally_name}</td>
	<td><input name="name" type="text"></td>
</tr><tr>
	<td>{$ad_ally_tag}</td>
	<td><input name="tag" type="text" size="5"></td>
</tr><tr>
	<td>{$ad_ally_delete_u}&nbsp;{$ad_ally_user_id}</td>
	<td><input name="delete_u" type="text"></td>
</tr><tr>
	<td>{$ad_ally_delete}</td>
	<td><input name="delete" type="checkbox"></td>
</tr><tr>
	<td>{$ad_ally_text1}</td>
	<td><textarea name="externo" type="text" rows="10" cols="80"></textarea></td>
</tr><tr>
	<td>{$ad_ally_text2}</td>
	<td><textarea name="interno" type="text" rows="10" cols="80"></textarea></td>
</tr><tr>
	<td>{$ad_ally_text3}</td>
	<td><textarea name="solicitud" type="text" rows="10" cols="80"></textarea></td>
</tr><tr>
	<td colspan="3"><input type="submit" value="{$button_submit}"></td>
</tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}