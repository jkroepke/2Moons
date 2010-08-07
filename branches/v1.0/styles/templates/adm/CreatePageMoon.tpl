{include file="adm/overall_header.tpl"}
<form action="" method="post">
<table width="40%">
<tr>
	<td class="c" colspan="3">{$po_add_moon}</td>
</tr>
<tr>
	<th>{$input_id_planet}</th>
	<th colspan="2"><input  type="text" name="add_moon" value="" size="3"></th>
</tr>
<tr>
	<th>{$mo_moon_name}</th>
	<th colspan="2"><input type="text" value="{$mo_moon}" name="name"></th>
</tr>
<tr>
	<th>{$mo_diameter}</th>
	<th colspan="2"><input type="text" name="diameter" size="5" maxlength="5">
	<input type="checkbox" checked="checked" name="diameter_check"> (Random)</th>
</tr>
<tr>
	<th>{$mo_fields_avaibles}</th>
	<th colspan="2"><input type="text" name="field_max" size="5" maxlength="5" value="1"></th>
</tr>
<tr>
	<th colspan="3"><input type="submit" value="{$button_add}"></th>
</tr><tr>
   <th colspan="2" style="text-align:left;"><a href="?page=create">{$new_creator_go_back}</a>&nbsp;<a href="?page=create&mode=moon">{$new_creator_refresh}</a></th>
</tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}