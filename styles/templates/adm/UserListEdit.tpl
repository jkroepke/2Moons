<form action="" method="post">
<input type="hidden" name="currid" value="{id}">
<table width="750" style="color:#FFFFFF">
<tr>
	<td class="c" colspan="5">Spieler {username} bearbeiten</td>
</tr>
<tr>
	<th>ID</th>
	<th>Name des Spielers</th>
	<th>Email</th>
	<th>Gesperrt</th>
	<th>U-Mod</th>
</tr>
<tr>
	<th> {id} </th>
	<th><input type="text" name="username" size="15" value="{username}" /></th>
	<th><input type="text" name="email" size="30" value="{email}"/></th>
	<th><input type="checkbox" name="gesperrt" value="1" {banchecked}/></th>
	<th><input type="checkbox" name="umod" value="1" {umodchecked}/></th>
</tr>
<tr>
	<td class="c" colspan="5">Details der Sperrung (wenn aktiviert)</td>
</tr>
<tr>
	<th width="268">Grund</th>
	<th>Tage</th>
	<th>Stunden</th>
	<th>Minuten</th>
	<th>Sekunden</th>
</tr>
<tr>
	<th width="268"><input name="reason" type="text" size="25" maxlength="50" /></th>
	<th><input type="text" name="ban_days" value="0" /> </th>
	<th><input type="text" name="ban_hours" value="0" /> </th>
	<th><input type="text" name="ban_mins" value="0" /> </th>
	<th><input type="text" name="ban_secs" value="0" /> </th>
</tr>
<tr>
	<th colspan="5"><input type="submit" name="submit" value="{ul_save}"></th>
</tr>
</table>
<table width="350">
<tr>
        <td class="c" colspan="7">Forschungen bearbeiten</td>
</tr>
<tr>
        <th width="20">Nr</th>
        <th>Forschung</th>
        <th>Wert</th>
</tr>
<tr>
        <th>1</td>
        <th>Spionagetechnik</th>
        <th><input name="spy_tech" type="text" value="{spy_tech}" /></th>
</tr>
<tr>
        <th>2</td>
        <th>Computertechnik</td>
        <th><input name="computer_tech" type="text" value="{computer_tech}" /></th>
</tr>
<tr>
        <th>3</td>
        <th>Waffentechnik</td>
        <th><input name="military_tech" type="text" value="{military_tech}" /></th>
</tr>
<tr>
        <th>4</td>
        <th>Schildtechnik</td>
        <th><input name="defence_tech" type="text" value="{defence_tech}" /></th>
</tr>
<tr>
        <th>5</td>
        <th>Raumschiffpanzerung</td>
        <th><input name="shield_tech" type="text" value="{shield_tech}" /></th>
</tr>
<tr>
        <th>6</td>
        <th>Energietechnik</td>
        <th><input name="energy_tech" type="text" value="{energy_tech}" /></th>
</tr>
<tr>
        <th>7</td>
        <th>Hyperraumtechnik</td>
        <th><input name="hyperspace_tech" type="text" value="{hyperspace_tech}" /></th>
</tr>
<tr>
        <th>8</td>
        <th>Verbrennungstriebwerk</td>
        <th><input name="combustion_tech" type="text" value="{combustion_tech}" /></th>
</tr>
<tr>
        <th>9</td>
        <th>Impulstriebwerk</td>
        <th><input name="impulse_motor_tech" type="text" value="{impulse_motor_tech}" /></th>
</tr>
<tr>
        <th>10</td>
        <th>Hyperraumantrieb</td>
        <th><input name="hyperspace_motor_tech" type="text" value="{hyperspace_motor_tech}" /></th>
</tr>
<tr>
        <th>11</td>
        <th>lasertechnik</td>
        <th><input name="laser_tech" type="text" value="{laser_tech}" /></th>
</tr>
<tr>
        <th>12</td>
        <th>Ionentechnik</td>
        <th><input name="ionic_tech" type="text" value="{ionic_tech}" /></th>
</tr>
<tr>
        <th>13</td>
        <th>Plasmatechnik</td>
        <th><input name="buster_tech" type="text" value="{buster_tech}" /></th>
</tr>
<tr>
        <th>14</td>
        <th>Intergalaktisches<br>
Forschungsnetzwerk</td>
        <th><input name="intergalactic_tech" type="text" value="{intergalactic_tech}" /></th>
</tr>
<tr>
        <th>15</td>
        <th>Expeditionstechnik</td>
        <th><input name="expedition_tech" type="text" value="{expedition_tech}" /></th>
</tr>
<tr>
        <th>16</td>
        <th>Gravitonforschung</td>
        <th><input name="graviton_tech" type="text" value="{graviton_tech}" /></th>
</tr>
<tr>
        <th colspan="3"><input type="Submit" name="submit" value="{ul_save}" /></th>
</tr>
</table>
</form>