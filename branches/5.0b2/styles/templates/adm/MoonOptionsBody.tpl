<script>document.body.style.overflow = "auto";</script> 
<body>
<h1>{mo_moon_optionss}</h1>
<style>
.centrado{text-align:center;}
.big{text-align:center; font:bold; font-size:14px; color:aqua;}
</style>
<form action="" method="post">
<table width="35%" border="5" bordercolor="#000099">
<tr>
	<td class="c" colspan="3">{mo_add_moons}</td>
</tr>
<tr>
	<th>{mo_planet_id}</th>
	<th colspan="2"><input  class="centrado" type="text" name="add_moon" value="" size="3"></th>
</tr>
<tr>
	<th>{mo_moon_name}</th>
	<th colspan="2"><input class="centrado" type="text" value="{mo_moon}" name="name"></th>
</tr>
<tr>
	<th>{mo_diameter}</th>
	<th colspan="2"><input class="centrado" type="text" name="diameter" size="5" maxlength="5">
	<input type="checkbox" checked="checked" name="diameter_check"> (Random)</th>
</tr>
<tr>
	<th>{mo_temperature}</th>
	<th colspan="2">
	<input type="text" class="centrado" name="temp_min" size="2" maxlength="3"> / 
	<input class="centrado" type="text" name="temp_max" size="2" maxlength="3">
	<input type="checkbox" checked="checked" name="temp_check"> (Random)</th>
</tr>
<tr>
	<th>{mo_fields_avaibles}</th>
	<th colspan="2"><center><input class="centrado" type="text" name="field_max" size="5" maxlength="5" value="1"></center></th>
</tr>
<tr>
	<th colspan="3"><input type="submit" value="{mo_add_moon_button}"></th>
</tr>
</table>
</form>


<br /><br />
<form action="" method="post">
<table width="35%" border="5" bordercolor="#000099" cellspacing="2" cellpadding="0">
<tr>
   <td class="c" colspan="2" align="center">{mo_dlte_moon}</td>
</tr>
<tr>
   <th width="200">{mo_moon_id}</th>
   <th width="200"><input class="centrado" type="text" name="del_moon" size="4"></th>
</tr>
<tr>
   <th colspan="2"><input type="submit" value="{mo_dlte_moon_button}"></th>
</tr>
</table>
</form>


<br /><br />
<form action="" method="post">
<table width="35%" border="5" bordercolor="#000099" cellspacing="2" cellpadding="0">
<tr>
   <td class="c" colspan="2" align="center">{mo_search_moon}</td>
</tr>
<tr>
   <th width="200">{mo_user}</th>
   <th width="200"><select name="search_moon"><option>{mo_search_select}</option>{list}</select></th>
</tr>
<tr>
   <th colspan="2"><input type="submit" value="Enviar"></th>
</tr>
{moonlist}
</table>
</form>
</body>