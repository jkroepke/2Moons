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
	<td class="c" colspan="7">{ships_title}</td>
</tr><tr>
	<th colspan="2">{input_id_p_m}</th>
	<th><input name="id" type="text" value="0" size="3" /></th>
</tr><tr>
	<td class="c">{ad_number}</td>
	<td class="c">{ships_title}</td>
	<td class="c">{ships_count}</td>
</tr><tr>
	<th>1</th>
	<th>{small_ship_cargo}</th>
	<th><input name="small_ship_cargo" type="text" value="0" /></th>
</tr><tr>
	<th>2</th>
	<th>{big_ship_cargo}</th>
	<th><input name="big_ship_cargo" type="text" value="0" /></th>
</tr><tr>
	<th>3</th>
	<th>{light_hunter}</th>
	<th><input name="light_hunter" type="text" value="0" /></th>
</tr><tr>
	<th>4</th>
	<th>{heavy_hunter}</th>
	<th><input name="heavy_hunter" type="text" value="0" /></th>
</tr><tr>
	<th>5</th>
	<th>{crusher}</th>
	<th><input name="crusher" type="text" value="0" /></th>
</tr><tr>
	<th>6</th>
	<th>{battle_ship}</th>
	<th><input name="battle_ship" type="text" value="0" /></th>
</tr><tr>
	<th>7</th>
	<th>{colonizer}</th>
	<th><input name="colonizer" type="text" value="0" /></th>
</tr><tr>
	<th>8</th>
	<th>{recycler}</th>
	<th><input name="recycler" type="text" value="0" /></th>
</tr><tr>
	<th>9</th>
	<th>{spy_sonde}</th>
	<th><input name="spy_sonde" type="text" value="0" /></th>
</tr><tr>
	<th>10</th>
	<th>{bomber_ship}</th>
	<th><input name="bomber_ship" type="text" value="0" /></th>
</tr><tr>
	<th>11</th>
	<th>{solar_satelit}</th>
	<th><input name="solar_satelit" type="text" value="0" /></th>
</tr><tr>
	<th>12</th>
	<th>{destructor}</th>
	<th><input name="destructor" type="text" value="0" /></th>
</tr><tr>
	<th>13</th>
	<th>{dearth_star}</th>
	<th><input name="dearth_star" type="text" value="0" /></th>
</tr><tr>
	<th>14</th>
	<th>{battleship}</th>
	<th><input name="battleship" type="text" value="0" /></th>
</tr><tr>
	<th>15</th>
	<th>{supernova}</th>
	<th><input name="supernova" type="text" value="0" /></th>
</tr><tr>
	<th colspan="3">
	<input type="reset" value="{button_reset}"/><br /><br />
	<input type="Submit" value="{button_add}" name="add" />&nbsp;
	<input type="Submit" value="{button_delete}" name="delete" /></th>
</tr>
</table>
</form>
</body>