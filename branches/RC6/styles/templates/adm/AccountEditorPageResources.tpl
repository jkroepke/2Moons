{include file="adm/overall_header.tpl"}
<form action="" method="post">
<table width="50%">
<tr>
<th colspan="3" align="left"><a href="?page=accounteditor">
<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$ad_back_to_menu}</a></th>
</tr><tr>
	<td class="c" colspan="2">{$resources_title}</td>
</tr><tr>
	<th>{$input_id_p_m}</th>
	<th><input name="id" type="text" value="0" size="3"></th>
</tr><tr>
	<th>{$Metal}</th>
	<th><input name="metal" type="text" value="0"></th>
</tr><tr>
	<th>{$Crystal}</th>
	<th><input name="cristal" type="text" value="0"></th>
</tr><tr>
	<th>{$Deuterium}</th>
	<th><input name="deut" type="text" value="0"></th>
</tr><tr>
	<td class="c" colspan="2">{$Darkmatter}</td>
</tr><tr>
	<th>{$input_id_user}</th>
	<th><input name="id_dark" type="text" value="0" size="3"></th>
</tr><tr>
	<th>{$Darkmatter}</th>
	<th><input name="dark" type="text" value="0"></th>
</tr><tr>
	<th colspan="2">
	<input type="reset" value="{$button_reset}"><br><br>
	<input type="Submit" value="{$button_add}" name="add">&nbsp;
	<input type="Submit" value="{$button_delete}" name="delete"></th>
</tr>
</table>
</form>
</body>
{include file="adm/overall_footer.tpl"}