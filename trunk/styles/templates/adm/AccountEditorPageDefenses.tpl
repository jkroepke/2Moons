{include file="adm/overall_header.tpl"}
<form action="" method="post">
<table width="45%">
<tr>
<td colspan="3" align="left"><a href="?page=accounteditor">
<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$ad_back_to_menu}</a></td>
</tr><tr>
	<th colspan="7">{$defenses_title}</th>
</tr><tr>
	<td colspan="2">{$input_id_p_m}</td>
	<td><input name="id" type="text" value="0" size="3"></td>
</tr><tr>
	<th>{$ad_number}</th>
	<th>{$defenses_title}</th>
	<th>{$defenses_count}</th>
</tr>
{foreach key=id item=input from=$inputlist}
<tr><td>{$id}</td><td>{$input.name}</td><td><input name="{$input.type}" type="text" value="0"></td></tr>
{/foreach}
<tr>
	<td colspan="3">
	<input type="reset" value="{$button_reset}"><br><br>
	<input type="submit" value="{$button_add}" name="add">&nbsp;
	<input type="submit" value="{$button_delete}" name="delete"></td>
</tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}