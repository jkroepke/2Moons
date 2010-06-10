<script>document.body.style.overflow = "auto";</script>
<SCRIPT TYPE="text/javascript" SRC="../scripts/filterlist.js"></SCRIPT>
<body>
<br />
<form action="" method="post">
<table width="50%">
{display}
<tr>
<th colspan="3" align="left"><a href="AccountEditorPage.php">
<img src="../styles/images/Adm/arrowright.png" width="16" height="10"/> {ad_back_to_menu}</a></th>
</tr><tr>
	<td class="c" colspan="2">{resources_title}</td>
</tr><tr>
	<th>{input_id_p_m}</th>
	<th><input name="id" type="text" value="0" size="3" /></th>
</tr><tr>
	<th>{metal}</th>
	<th><input name="metal" type="text" value="0" /></th>
</tr><tr>
	<th>{crystal}</th>
	<th><input name="cristal" type="text" value="0" /></th>
</tr><tr>
	<th>{deuterium}</th>
	<th><input name="deut" type="text" value="0" /></th>
</tr><tr>
	<td class="c" colspan="2">{darkmatter}</td>
</tr><tr>
	<th>{input_id_user}</th>
	<th><input name="id_dark" type="text" value="0" size="3" /></th>
</tr><tr>
	<th>{darkmatter}</th>
	<th><input name="dark" type="text" value="0" /></th>
</tr><tr>
	<th colspan="2">
	<input type="reset" value="{button_reset}"/><br /><br />
	<input type="Submit" value="{button_add}" name="add"/>&nbsp;
	<input type="Submit" value="{button_delete}" name="delete"/></th>
</tr>
</table>
</form>
</body>