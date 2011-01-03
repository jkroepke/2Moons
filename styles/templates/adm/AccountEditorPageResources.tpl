{include file="adm/overall_header.tpl"}
<form action="" method="post">
<table width="50%">
<tr>
<td colspan="3" align="left"><a href="?page=accounteditor">
<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$ad_back_to_menu}</a></td>
</tr><tr>
	<th colspan="2">{$resources_title}</th>
</tr><tr>
	<td>{$input_id_p_m}</td>
	<td><input name="id" type="text" value="0" size="3"></td>
</tr><tr>
	<td>{$Metal}</td>
	<td><input name="metal" type="text" value="0"></td>
</tr><tr>
	<td>{$Crystal}</td>
	<td><input name="cristal" type="text" value="0"></td>
</tr><tr>
	<td>{$Deuterium}</td>
	<td><input name="deut" type="text" value="0"></td>
</tr><tr>
	<th colspan="2">{$Darkmatter}</th>
</tr><tr>
	<td>{$input_id_user}</td>
	<td><input name="id_dark" type="text" value="0" size="3"></td>
</tr><tr>
	<td>{$Darkmatter}</td>
	<td><input name="dark" type="text" value="0"></td>
</tr><tr>
	<td colspan="2">
	<input type="reset" value="{$button_reset}"><br><br>
	<input type="Submit" value="{$button_add}" name="add">&nbsp;
	<input type="Submit" value="{$button_delete}" name="delete"></td>
</tr>
</table>
</form>
</body>
{include file="adm/overall_footer.tpl"}