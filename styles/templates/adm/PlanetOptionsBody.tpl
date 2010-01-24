<script>document.body.style.overflow = "auto";</script> 
<body>
<h1>{po_title_page}</h1>
<form action="" method="post">
<input type="hidden" name="mode" value="agregar">
<table width="30%">
{display}
<td colspan="3" class="c">{po_add_planet}</td>
<tr>
   <th>{po_id_user}</th>
   <th><input name="id" type="text" size="4"/></th>
</tr><tr>
   <th>{po_coor_1}</th>
   <th><input name="galaxy" type="text" size="3" maxlength="1" 
   onMouseOver='return overlib("{po_galaxy}", CENTER, OFFSETX, 0, OFFSETY, -40);' onMouseOut='return nd();'/>&nbsp; :
   <input name="system" type="text" size="3" maxlength="3"
   onMouseOver='return overlib("{po_system}", CENTER, OFFSETX, 0, OFFSETY, -40);' onMouseOut='return nd();'//>&nbsp; :
   <input name="planet" type="text" size="3" maxlength="2"
   onMouseOver='return overlib("{po_planet}", CENTER, OFFSETX, 0, OFFSETY, -40);' onMouseOut='return nd();'//><br>
   </th>
</tr><tr>
   <th colspan="2"><input type="Submit" value="{po_add_button}" /></th>
</tr>
</table>
</form>

<br>
<form action="" method="post">
<input type="hidden" name="mode" value="borrar">
<table width="50%">
{display2}
<td colspan="3" class="c">{po_delete_planet}</td>
<tr>
   <th>{po_id_planet}</th>
   <th><input name="id" type="text" size="4"/></th>
</tr><tr>
   <th colspan="2"><input type="Submit" value="{po_delete_button}" /></th>
</tr>
</table>
</form>
</body>