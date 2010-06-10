<script>document.body.style.overflow = "auto";</script> 
<body>
<h2>{new_creator_title_l}</h2>
<form action="" method="post">
<table width="40%">
	{display}
<tr>
	<td class="c" colspan="3">{po_add_moon}</td>
</tr>
<tr>
	<th>{input_id_planet}</th>
	<th colspan="2"><input  type="text" name="add_moon" value="" size="3"></th>
</tr>
<tr>
	<th>{mo_moon_name}</th>
	<th colspan="2"><input type="text" value="{mo_moon}" name="name"></th>
</tr>
<tr>
	<th>{mo_diameter}</th>
	<th colspan="2"><input type="text" name="diameter" size="5" maxlength="5">
	<input type="checkbox" checked="checked" name="diameter_check"> (Random)</th>
</tr>
<tr>
	<th>{mo_temperature}</th>
	<th colspan="2">
	<input type="text" name="temp_min" size="2" maxlength="3"> / 
	<input type="text" name="temp_max" size="2" maxlength="3">
	<input type="checkbox" checked="checked" name="temp_check"> (Random)</th>
</tr>
<tr>
	<th>{mo_fields_avaibles}</th>
	<th colspan="2"><center><input type="text" name="field_max" size="5" maxlength="5" value="1"></center></th>
</tr>
<tr>
	<th colspan="3"><input type="submit" value="{button_add}"></th>
</tr>
</table>
</form>

<br>
<form action="" method="post">
<table width="40%">
	{display2}
<tr>
   <td class="c" colspan="2">{po_delete_moon}</td>
</tr>
<tr>
   <th width="200">{input_id_moon}</th>
   <th width="200"><input type="text" name="del_moon" size="4"></th>
</tr>
<tr>
   <th colspan="2"><input type="submit" value="{button_delete}"></th>
</tr><tr>
   <th colspan="2" style="text-align:left;"><a href="MakerPage.php">{new_creator_go_back}</a>&nbsp;<a href="MakerPage.php?page=new_moon">{new_creator_refresh}</a></th>
</tr>
</table>
</form>
</body>