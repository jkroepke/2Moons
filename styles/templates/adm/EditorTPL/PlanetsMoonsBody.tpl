<script>document.body.style.overflow = "auto";</script>
<body>
<br />
<form action="" method="post">
<table width="45%">
{display}
{display2}
<tr>
<th colspan="3" align="left"><a href="AccountEditorPage.php">
<img src="../styles/images/Adm/arrowright.png" width="16" height="10"/> {ad_back_to_menu}</a></th>
</tr><tr>
	<td class="c" colspan="7">{ad_pla_title}</td>
</tr><tr>
	<th>{input_id_p_m}</th>
	<th><input name="id" type="text" size="5" maxlength="5"/></th>
</tr><tr>
	<th>{ad_pla_edit_name}</th>
	<th><input name="name" type="text" size="20"/></th>
</tr><tr>
	<th>{ad_pla_edit_diameter}</th>
	<th><input name="diameter" type="text" size="5"/></th>
</tr><tr>
	<th>{ad_pla_edit_fields}</th>
	<th><input name="fields" type="text" size="5"/></th>
</tr><tr>
	<th>{ad_pla_delete_b}</th>
	<th><input name="0_buildings" type="checkbox"/></th>
</tr><tr>
	<th>{ad_pla_delete_s}</th>
	<th><input name="0_ships" type="checkbox"/></th>
</tr><tr>
	<th>{ad_pla_delete_d}</th>
	<th><input name="0_defenses" type="checkbox"/></th>
</tr><tr>
	<th>{ad_pla_delete_hd}</th>
	<th><input name="0_c_hangar" type="checkbox"/></th>
</tr><tr>
	<th>{ad_pla_delete_cb}</th>
	<th><input name="0_c_buildings" type="checkbox"/></th>
</tr><tr>
	<th>{ad_pla_delete_planet}</th>
	<th><input name="delete" type="checkbox"/></th>
</tr><tr>
	<th><a href="#" onMouseOver='return overlib("{ad_pla_title_l}", CENTER, OFFSETX, 120, OFFSETY, -40, WIDTH, 250);' onMouseOut='return nd();' class="big">{ad_pla_change_p}</a></th>
	<th><input name="change_position" type="checkbox" title="{ad_pla_change_pp}"/>
	<input name="g" type="text" size="1" maxlength="1"/> : 
	<input name="s" type="text" size="3" maxlength="3"/> : 
	<input name="p" type="text" size="2" maxlength="2"/></th>
</tr><tr>
	<th colspan="3"><input type="Submit" value="{button_submit}"/>&nbsp;
	<input type="reset" value="{button_reset}"/></th>
</tr>
</table>
</form>
</body>