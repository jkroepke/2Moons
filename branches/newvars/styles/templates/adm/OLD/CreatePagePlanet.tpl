{include file="overall_header.tpl"}
<form action="" method="post">
<input type="hidden" name="mode" value="agregar">
<table width="40%">
<tr>
	<th colspan="3">{$po_add_planet}</th>
</tr>
<tr>
	<td>{$input_id_user}</td>
	<td><input name="id" type="text" size="4"></td>
</tr><tr>
	<td>{$new_creator_coor}</td>
	<td><input name="galaxy" type="text" size="3" maxlength="1" class="tooltip" data-tooltip-content="{$po_galaxy}">&nbsp; :
	<input name="system" type="text" size="3" maxlength="3" class="tooltip" data-tooltip-content="{$po_system}">&nbsp; :
	<input name="planet" type="text" size="3" maxlength="2" class="tooltip" data-tooltip-content="{$po_planet}"><br>
	</td>
</tr><tr>
	<td>{$po_name_planet}</td>
	<td><input name="name" type="text" size="15" maxlength="25" value="{$po_colony}"></td>
</tr><tr>
	<td>{$po_fields_max}</td>
	<td><input name="field_max" type="text" size="6" maxlength="10"></td>
</tr><tr>
	<td colspan="2"><input type="Submit" value="{$button_add}"></td>
</tr><tr>
	<td colspan="2" style="text-align:left;"><a href="?page=create">{$new_creator_go_back}</a>&nbsp;<a href="?page=create&amp;mode=planet">{$new_creator_refresh}</a></td>
</tr>
</table>
</form>
{include file="overall_footer.tpl"}