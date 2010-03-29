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
</tr><tr>
	<th>1</th>
	<th>{metal_mine}</th>
	<th><input name="metal_mine" type="text" value="0" /></th>
</tr><tr>
	<th>2</th>
	<th>{crystal_mine}</th>
	<th><input name="crystal_mine" type="text" value="0" /></th>
</tr><tr>
	<th>3</th>
	<th>{deuterium_sintetizer}</th>
	<th><input name="deuterium_sintetizer" type="text" value="0" /></th>
</tr><tr>
	<th>4</th>
	<th>{solar_plant}</th>
	<th><input name="solar_plant" type="text" value="0" /></th>
</tr><tr>
	<th>5</th>
	<th>{fusion_plant}</th>
	<th><input name="fusion_plant" type="text" value="0" /></th>
</tr><tr>
	<th>6</th>
	<th>{robot_factory}</th>
	<th><input name="robot_factory" type="text" value="0" /></th>
</tr><tr>
	<th>7</th>
	<th>{nano_factory}</th>
	<th><input name="nano_factory" type="text" value="0" /></th>
</tr><tr>
	<th>8</th>
	<th>{shipyard}</th>
	<th><input name="hangar" type="text" value="0" /></th>
</tr><tr>
	<th>9</th>
	<th>{metal_store}</th>
	<th><input name="metal_store" type="text" value="0" /></th>
</tr><tr>
	<th>10</th>
	<th>{crystal_store}</th>
	<th><input name="crystal_store" type="text" value="0" /></th>
</tr><tr>
	<th>11</th>
	<th>{deuterium_store}</th>
	<th><input name="deuterium_store" type="text" value="0" /></th>
</tr><tr>
	<th>12</th>
	<th>{laboratory}</th>
	<th><input name="laboratory" type="text" value="0" /></th>
</tr><tr>
	<th>13</th>
	<th>{terraformer}</th>
	<th><input name="terraformer" type="text" value="0" /></th>
</tr><tr>
	<th>14</th>
	<th>{ally_deposit}</th>
	<th><input name="ally_deposit" type="text" value="0" /></th>
</tr><tr>
	<th>15</th>
	<th>{silo}</th>
	<th><input name="silo" type="text" value="0" /></th>
</tr>
{display2}
<tr>
<td class="c" colspan="3">{moon_build}</td>
</tr><tr>
	<th>1</th>
	<th>{moonbases}</th>
	<th><input name="mondbasis" type="text" value="0" /></th>
</tr><tr>
	<th>2</th>
	<th>{phalanx}</th>
	<th><input name="phalanx" type="text" value="0" /></th>
</tr><tr>
	<th>3</th>
	<th>{cuantic}</th>
	<th><input name="sprungtor" type="text" value="0" /></th>
</tr><tr>
	<th colspan="3">
	<input type="reset" value="{button_reset}"/><br /><br />
	<input type="Submit" value="{button_add}" name="add"/>&nbsp;
	<input type="Submit" value="{button_delete}" name="delete"/></th>
</tr>
</table>
</form>
</body>