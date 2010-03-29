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
	<td class="c" colspan="3">{defenses_title}</td>
</tr><tr>
	<th colspan="2">{input_id_p_m}</th>
	<th><input name="id" type="text" value="0" size="3" /></th>
</tr><tr>
	<td class="c">{ad_number}</td>
	<td class="c">{defenses_title}</td>
	<td class="c">{defenses_count}</td>
</tr><tr>
	<th>1</th>
	<th>{misil_launcher}</th>
	<th><input name="misil_launcher" type="text" value="0" /></th>
</tr><tr>
	<th>2</th>
	<th>{small_laser}</th>
	<th><input name="small_laser" type="text" value="0" /></th>
</tr><tr>
	<th>3</th>
	<th>{big_laser}</th>
	<th><input name="big_laser" type="text" value="0" /></th>
</tr><tr>
	<th>4</th>
	<th>{gauss_canyon}</th>
	<th><input name="gauss_canyon" type="text" value="0" /></th>
</tr><tr>
	<th>5</th>
	<th>{ionic_canyon}</th>
	<th><input name="ionic_canyon" type="text" value="0" /></th>
</tr><tr>
	<th>6</th>
	<th>{buster_canyon}</th>
	<th><input name="buster_canyon" type="text" value="0" /></th>
</tr><tr>
	<th>7</th>
	<th>{small_protection_shield}</th>
	<th><input name="small_protection_shield" type="text" value="0" /></th>
</tr><tr>
	<th>8</th>
	<th>{big_protection_shield}</th>
	<th><input name="big_protection_shield" type="text" value="0" /></th>
</tr><tr>
	<th>9</th>
	<th>{planet_protector}</th>
	<th><input name="planet_protector" type="text" value="0" /></th>
</tr><tr>
	<th>10</th>
	<th>{interceptor_misil}</th>
	<th><input name="interceptor_misil" type="text" value="0" /></th>
</tr><tr>
	<th>11</th>
	<th>{interplanetary_misil}</th>
	<th><input name="interplanetary_misil" type="text" value="0" /></th>
</tr><tr>
	<th colspan="3">
	<input type="reset" value="{button_reset}"/><br /><br />
	<input type="Submit" value="{button_add}" name="add" />&nbsp;
	<input type="Submit" value="{button_delete}" name="delete"/></th>
</tr>
</table>
</form>
</body>