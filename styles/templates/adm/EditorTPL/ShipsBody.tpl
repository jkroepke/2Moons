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
	<td class="c" colspan="7">{ad_ships_title}</td>
</tr><tr>
	<th colspan="2">{ad_planet_id}</th>
	<th><input name="id" type="text" value="0" size="3" /></th>
</tr><tr>
	<td class="c">{ad_number}</td>
	<td class="c">{ad_ships}</td>
	<td class="c">{ad_ships_number}</td>
</tr><tr>
	<th>1</th>
	<th>{ad_small_ship_cargo}</th>
	<th><input name="small_ship_cargo" type="text" value="0" /></th>
</tr><tr>
	<th>2</th>
	<th>{ad_big_ship_cargo}</th>
	<th><input name="big_ship_cargo" type="text" value="0" /></th>
</tr><tr>
	<th>3</th>
	<th>{ad_light_hunter}</th>
	<th><input name="light_hunter" type="text" value="0" /></th>
</tr><tr>
	<th>4</th>
	<th>{ad_heavy_hunter}</th>
	<th><input name="heavy_hunter" type="text" value="0" /></th>
</tr><tr>
	<th>5</th>
	<th>{ad_crusher}</th>
	<th><input name="crusher" type="text" value="0" /></th>
</tr><tr>
	<th>6</th>
	<th>{ad_battle_ship}</th>
	<th><input name="battle_ship" type="text" value="0" /></th>
</tr><tr>
	<th>7</th>
	<th>{ad_colonizer}</th>
	<th><input name="colonizer" type="text" value="0" /></th>
</tr><tr>
	<th>8</th>
	<th>{ad_recycler}</th>
	<th><input name="recycler" type="text" value="0" /></th>
</tr><tr>
	<th>9</th>
	<th>{ad_spy_sonde}</th>
	<th><input name="spy_sonde" type="text" value="0" /></th>
</tr><tr>
	<th>10</th>
	<th>{ad_bomber_ship}</th>
	<th><input name="bomber_ship" type="text" value="0" /></th>
</tr><tr>
	<th>11</th>
	<th>{ad_solar_satelit}</th>
	<th><input name="solar_satelit" type="text" value="0" /></th>
</tr><tr>
	<th>12</th>
	<th>{ad_destructor}</th>
	<th><input name="destructor" type="text" value="0" /></th>
</tr><tr>
	<th>13</th>
	<th>{ad_dearth_star}</th>
	<th><input name="dearth_star" type="text" value="0" /></th>
</tr><tr>
	<th>14</th>
	<th>{ad_battleship}</th>
	<th><input name="battleship" type="text" value="0" /></th>
</tr><tr>
	<th>15</th>
	<th>{ad_supernova}</th>
	<th><input name="supernova" type="text" value="0" /></th>
</tr><tr>
	<th colspan="3">
	<input type="reset" value="{ad_reset_button}"/><br /><br />
	<input type="Submit" value="{ad_add_ships_button}" name="add" />&nbsp;
	<input type="Submit" value="{ad_delete_ships_button}" name="delete" /></th>
</tr>
</table>
</form>
</body>