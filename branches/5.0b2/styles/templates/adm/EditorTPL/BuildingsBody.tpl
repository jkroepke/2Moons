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
	<td class="c" colspan="3">{ad_buildings_title}</td>
</tr><tr>
	<th colspan="2">{ad_planet_id}</th>
	<th><input name="id" type="text" value="0" size="3" /></th>
</tr><tr>
	<td class="c">{ad_number}</td>
	<td class="c">{ad_buildings}</td>
	<td class="c">{ad_levels}</td>
</tr><tr>
	<th>1</th>
	<th>{ad_metal_mine}</th>
	<th><input name="metal_mine" type="text" value="0" /></th>
</tr><tr>
	<th>2</th>
	<th>{ad_crystal_mine}</th>
	<th><input name="crystal_mine" type="text" value="0" /></th>
</tr><tr>
	<th>3</th>
	<th>{ad_deuterium_sintetizer}</th>
	<th><input name="deuterium_sintetizer" type="text" value="0" /></th>
</tr><tr>
	<th>4</th>
	<th>{ad_solar_plant}</th>
	<th><input name="solar_plant" type="text" value="0" /></th>
</tr><tr>
	<th>5</th>
	<th>{ad_fusion_plant}</th>
	<th><input name="fusion_plant" type="text" value="0" /></th>
</tr><tr>
	<th>6</th>
	<th>{ad_robot_factory}</th>
	<th><input name="robot_factory" type="text" value="0" /></th>
</tr><tr>
	<th>7</th>
	<th>{ad_nano_factory}</th>
	<th><input name="nano_factory" type="text" value="0" /></th>
</tr><tr>
	<th>8</th>
	<th>{ad_shipyard}</th>
	<th><input name="hangar" type="text" value="0" /></th>
</tr><tr>
	<th>9</th>
	<th>{ad_metal_store}</th>
	<th><input name="metal_store" type="text" value="0" /></th>
</tr><tr>
	<th>10</th>
	<th>{ad_crystal_store}</th>
	<th><input name="crystal_store" type="text" value="0" /></th>
</tr><tr>
	<th>11</th>
	<th>{ad_deuterium_store}</th>
	<th><input name="deuterium_store" type="text" value="0" /></th>
</tr><tr>
	<th>12</th>
	<th>{ad_laboratory}</th>
	<th><input name="laboratory" type="text" value="0" /></th>
</tr><tr>
	<th>13</th>
	<th>{ad_terraformer}</th>
	<th><input name="terraformer" type="text" value="0" /></th>
</tr><tr>
	<th>14</th>
	<th>{ad_ally_deposit}</th>
	<th><input name="ally_deposit" type="text" value="0" /></th>
</tr><tr>
	<th>15</th>
	<th>{ad_silo}</th>
	<th><input name="silo" type="text" value="0" /></th>
</tr>
{display2}
<tr>
<td class="c" colspan="3">{ad_moon_buildings}</td>
</tr><tr>
	<th>1</th>
	<th>{ad_moonbases}</th>
	<th><input name="mondbasis" type="text" value="0" /></th>
</tr><tr>
	<th>2</th>
	<th>{ad_phalanx}</th>
	<th><input name="phalanx" type="text" value="0" /></th>
</tr><tr>
	<th>3</th>
	<th>{ad_cuantic}</th>
	<th><input name="sprungtor" type="text" value="0" /></th>
</tr><tr>
	<th colspan="3">
	<input type="reset" value="{ad_reset_button}"/><br /><br />
	<input type="Submit" value="{ad_add_buildings_button}" name="add"/>&nbsp;
	<input type="Submit" value="{ad_delete_buildings_button}" name="delete"/></th>
</tr>
</table>
</form>
</body>