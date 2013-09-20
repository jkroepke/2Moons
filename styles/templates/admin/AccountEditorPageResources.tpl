{include file="overall_header.tpl"}
<form action="" method="post">
<table width="50%">
<tr>
<td colspan="3" align="left"><a href="?page=accounteditor">
<img src="./styles/resource/images/admin/arrowright.png" width="16" height="10"> {$LNG.ad_back_to_menu}</a></td>
</tr><tr>
	<th colspan="2">{$LNG.resources_title}</th>
</tr><tr>
	<td>{$LNG.input_id_p_m}</td>
	<td><input name="id" type="text" value="0" size="3"></td>
</tr><tr>
	<td>{$LNG.tech.901}</td>
	<td><input name="metal" type="text" value="0"></td>
</tr><tr>
	<td>{$LNG.tech.902}</td>
	<td><input name="cristal" type="text" value="0"></td>
</tr><tr>
	<td>{$LNG.tech.903}</td>
	<td><input name="deut" type="text" value="0"></td>
</tr><tr>
	<th colspan="2">{$LNG.tech.921}</th>
</tr><tr>
	<td>{$LNG.input_id_user}</td>
	<td><input name="id_dark" type="text" value="0" size="3"></td>
</tr><tr>
	<td>{$LNG.tech.921}</td>
	<td><input name="dark" type="text" value="0"></td>
</tr><tr>
	<td colspan="2">
	<input type="reset" value="{$LNG.button_reset}"><br><br>
	<input type="Submit" value="{$LNG.button_add}" name="add">&nbsp;
	<input type="Submit" value="{$LNG.button_delete}" name="delete"></td>
</tr>
</table>
</form>
</body>
{include file="overall_footer.tpl"}