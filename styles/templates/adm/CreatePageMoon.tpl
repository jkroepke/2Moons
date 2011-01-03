{include file="adm/overall_header.tpl"}
<form action="" method="post">
<table width="40%">
<tr>
	<th colspan="3">{$po_add_moon}</th>
</tr>
<tr>
	<td>{$input_id_planet}</td>
	<td colspan="2"><input  type="text" name="add_moon" value="" size="3"></td>
</tr>
<tr>
	<td>{$mo_moon_name}</td>
	<td colspan="2"><input type="text" value="{$mo_moon}" name="name"></td>
</tr>
<tr>
	<td>{$mo_diameter}</td>
	<td colspan="2"><input type="text" name="diameter" size="5" maxlengtd="5">
	<input type="checkbox" checked="checked" name="diameter_check"> (Random)</td>
</tr>
<tr>
	<td>{$mo_fields_avaibles}</td>
	<td colspan="2"><input type="text" name="field_max" size="5" maxlengtd="5" value="1"></td>
</tr>
{if $admin_autd == 3}
<tr>
	<td>{$universum}</td>
	<td colspan="2">
    <select name="uni">
    	{foreach $AvailableUnis as $ID => $Universe}<option value="{$ID}">{$Universe.game_name}</option>{/foreach}
    </select>
    </td>
</tr>
{/if}
<tr>
	<td colspan="3"><input type="submit" value="{$button_add}"></td>
</tr><tr>
   <td colspan="2" style="text-align:left;"><a href="?page=create">{$new_creator_go_back}</a>&nbsp;<a href="?page=create&mode=moon">{$new_creator_refresh}</a></td>
</tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}