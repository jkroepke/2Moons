<script>document.body.style.overflow = "auto";</script> 
<body>
<h2>{new_creator_title_p}</h2>
<form action="" method="post">
<input type="hidden" name="mode" value="agregar">
<table width="40%">
{display}
<td colspan="3" class="c">{po_add_planet}</td>
<tr>
   <th>{input_id_user}</th>
   <th><input name="id" type="text" size="4"/></th>
</tr><tr>
   <th>{new_creator_coor}</th>
   <th><input name="galaxy" type="text" size="3" maxlength="1" 
   onMouseOver='return overlib("{po_galaxy}", CENTER, OFFSETX, 0, OFFSETY, -40);' onMouseOut='return nd();'/>&nbsp; :
   <input name="system" type="text" size="3" maxlength="3"
   onMouseOver='return overlib("{po_system}", CENTER, OFFSETX, 0, OFFSETY, -40);' onMouseOut='return nd();'//>&nbsp; :
   <input name="planet" type="text" size="3" maxlength="2"
   onMouseOver='return overlib("{po_planet}", CENTER, OFFSETX, 0, OFFSETY, -40);' onMouseOut='return nd();'//><br>
   </th>
</tr><tr>
   <th>{po_name_planet}</th>
   <th><input name="name" type="text" size="15" maxlength="25" value="{po_colony}"/></th>
</tr><tr>
   <th>{po_fields_max}</th>
   <th><input name="field_max" type="text" size="6" maxlength="10"/></th>
</tr><tr>
   <th colspan="2"><input type="Submit" value="{button_add}" /></th>
</tr>
</table>
</form>

<br>
<form action="" method="post">
<input type="hidden" name="mode" value="borrar">
<table width="40%">
{display2}
<td colspan="3" class="c">{po_delete_planet}</td>
<tr>
   <th>{input_id_planet}</th>
   <th><input name="id" type="text" size="4"/></th>
</tr><tr>
   <th colspan="2"><input type="Submit" value="{button_delete}" /></th>
</tr><tr>
   <th colspan="2" style="text-align:left;"><a href="MakerPage.php">{new_creator_go_back}</a>&nbsp;<a href="MakerPage.php?page=new_planet">{new_creator_refresh}</a></th>
</tr>
</table>
</form>
</body>