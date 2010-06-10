<script>document.body.style.overflow = "auto";</script>
<body>
<br />
<form action="" method="post">
<table width="45%">
{display}
<tr>
<th colspan="3" align="left"><a href="AccountEditorPage.php">
<img src="../styles/images/Adm/arrowright.png" width="16" height="10"/> {ad_back_to_menu}</a></th>
</tr><tr>
	<td class="c" colspan="3">{buildings_title}</td>
</tr><tr>
	<th colspan="2">{input_id_p_m}</th>
	<th><input name="id" type="text" size="3"/></th>
</tr><tr>
	<td class="c">{ad_number}</td>
	<td class="c">{buildings_title}</td>
	<td class="c">{buildings_count}</td>
</tr>{build}<tr>
	<th colspan="3">
	<input type="reset" value="{button_reset}"/><br /><br />
	<input type="Submit" value="{button_add}" name="add"/>&nbsp;
	<input type="Submit" value="{button_delete}" name="delete"/></th>
</tr>
</table>
</form>
</body>