<script>document.body.style.overflow = "auto";</script>
<SCRIPT TYPE="text/javascript" SRC="../scripts/filterlist.js"></SCRIPT>
<body>
<br />
<form action="" method="post" name="users">
<table width="50%">
{display}
<tr>
<th colspan="3" align="left"><a href="AccountEditorPage.php">
<img src="../styles/images/Adm/arrowright.png" width="16" height="10"/> {ad_back_to_menu}</a></th>
</tr><tr>
	<td class="c" colspan="2">{ad_resources}</td>
</tr><tr>
	<th>{ad_add_id_planet22}</th>
	<th><input name="id" type="text" value="0" size="3" /></th>
</tr><tr>
	<th>{Metal}</th>
	<th><input name="metal" type="text" value="0" /></th>
</tr><tr>
	<th>{Crystal}</th>
	<th><input name="cristal" type="text" value="0" /></th>
</tr><tr>
	<th>{Deuterium}</th>
	<th><input name="deut" type="text" value="0" /></th>
</tr><tr>
	<td class="c" colspan="2">{ad_resources_dark}</td>
</tr><tr>
	<th>{ad_add_id_user22}</th>
	<th><input name="id_dark" type="text" value="0" size="3" /></th>
</tr><tr>
	<th>{Darkmatter}</th>
	<th><input name="dark" type="text" value="0" /></th>
</tr><tr>
	<th colspan="2">
	<input type="reset" value="{ad_reset_button}"/><br /><br />
	<input type="Submit" value="{ad_add_resources_button}" name="add"/>&nbsp;
	<input type="Submit" value="{ad_delete_resources_button}" name="delete"/></th>
</tr>
</table>
</form>
</body>