<form action="" method="post">
<input type="hidden" name="currid" value="{id}">
<table width="800">
<tr>
        <td class="c" colspan="14">Mond {name} bearbeiten</td>
</tr>
<tr>
        <th>ID</th>
        <th>Spieler-ID</th>
        <th>Planetenname</th>
        <th>Planetenname</th>
        <th>Felder</th>
        <th>davon bebaut</th>
        <th>Galaxie</th>
        <th>System</th>
        <th>Position</th>
</tr>
<tr style="text-align:center;">
        <td class=b>{id}</td>
        <td class=b>{id_owner}</td>
        <td class=b>{name}</td>
        <td class=b><input type="text" name="mondname" size="15" value="{name}"></td>
        <td class=b><input type="text" name="felder" size="4" maxlength="4" value="{field_max}"></td>
        <td class=b>{field_current}</td>
        <td class=b>{galaxy}</td>
        <td class=b>{system}</td>
        <td class=b>{planet}</td>
</tr>
  </table>
<table width="800" style="color:#FFFFFF">
<tr>
        <td class="c" colspan="14">Rohstoffe bearbeiten</td>
</tr>
<tr>
         <th>Metall</th>
         <th>Kristall</th>
         <th>Deuterium</th>
         <th>Energie</th>
</tr>
<tr>
         <th><input type="text" name="metal" size="20" value="{metal}"></th>
         <th><input type="text" name="crystal" size="20" value="{crystal}"></th>
         <th><input type="text" name="deuterium" size="20" value="{deuterium}"></th>
         <th><input type="text" name="energy" size="20" value="{energy_max}"></th>
</tr>
</table>
<table width="800">
<tr>
        <td class="c" colspan="9">Schiffe bearbeiten</td>
</tr>
<tr>
        <th>{ad_small_ship_cargo}</th>
        <th>{ad_big_ship_cargo}</th>
        <th>{ad_light_hunter}</th>
        <th>{ad_heavy_hunter}</th>
        <th>{ad_crusher}</th>
        <th>{ad_battle_ship}</th>
        <th>{ad_colonizer}</th>
        <th>{ad_recycler}</th>

</tr>
<tr>
        <th><input name="small_ship_cargo" type="text" size="7" value="{small_ship_cargo}" /></th>
        <th><input name="big_ship_cargo" type="text" size="7" value="{big_ship_cargo}" /></th>
        <th><input name="light_hunter" type="text" size="7" value="{light_hunter}" /></th>
        <th><input name="heavy_hunter" type="text" size="7" value="{heavy_hunter}" /></th>
        <th><input name="crusher" type="text" size="7" value="{crusher}" /></th>
        <th><input name="battle_ship" type="text" size="7" value="{battle_ship}" /></th>
        <th><input name="colonizer" type="text" size="7" value="{colonizer}" /></th>
        <th><input name="recycler" type="text" size="7" value="{recycler}" /></th>

</tr>
<tr>
        <th>{ad_spy_sonde}</th>
        <th>{ad_bomber_ship}</th>
        <th>{ad_solar_satelit}</th>
        <th>{ad_destructor}</th>
        <th>{ad_dearth_star}</th>
        <th>{ad_battleship}</th>
        <th>{ad_lune_noir}</th>
        <th>{ad_ev_transporter}</th>

</tr>
<tr>
        <th><input name="spy_sonde" type="text" size="7" value="{spy_sonde}" /></th>
        <th><input name="bomber_ship" type="text" size="7" value="{bomber_ship}" /></th>
        <th><input name="solar_satelit" type="text" size="7" value="{solar_satelit}" /></th>
        <th><input name="destructor" type="text" size="7" value="{destructor}" /></th>
        <th><input name="dearth_star" type="text" size="7" value="{dearth_star}" /></th>
        <th><input name="battleship" type="text" size="7" value="{battleship}" /></th>
        <th><input name="lune_noir" type="text" size="7" value="{lune_noir}" /></th>
        <th><input name="ev_transporter" type="text" size="7" value="{ev_transporter}" /></th>

</tr>
<tr>
        <th>{ad_giga_recykler}</th>
        <th>{ad_dm_ship}</th>
        <th>Spaltenrei&szlig;er</th>
        <th>Avatar</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
</tr>
<tr>
        <th><input name="giga_recykler" type="text" size="7" value="{giga_recykler}" /></th>
        <th><input name="dm_ship" type="text" size="7" value="{dm_ship}" /></th>
        <th><input name="thriller" type="text" size="7" value="{thriller}" /></th>
        <th><input name="star_crasher" type="text" size="7" value="{star_crasher}" /></th>
        <th><input name="&nbsp;" type="text" size="7" value="&nbsp;" /></th>
        <th><input name="&nbsp;" type="text" size="7" value="&nbsp;" /></th>
        <th><input name="&nbsp;" type="text" size="7" value="&nbsp;" /></th>
        <th><input name="&nbsp;" type="text" size="7" value="&nbsp;" /></th>
</tr>
</table>
<table width="800">
<tr>
        <td class="c" colspan="7">Verteidigung bearbeiten</td>
</tr>
<tr>
        <th>{ad_misil_launcher}</th>
        <th>{ad_small_laser}</th>
        <th>{ad_big_laser}</th>
        <th>{ad_gauss_canyon}</th>
        <th>{ad_ionic_canyon}</th>
        <th>{ad_buster_canyon}</th>
        <th>{ad_graviton_canyon}</th>
</tr>
<tr>
        <th><input name="misil_launcher" size="5" type="text" value="{misil_launcher}" /></th>
        <th><input name="small_laser" size="5" type="text" value="{small_laser}" /></th>
        <th><input name="big_laser" size="5" type="text" value="{big_laser}" /></th>
        <th><input name="gauss_canyon" size="5" type="text" value="{gauss_canyon}" /></th>
        <th><input name="ionic_canyon" size="5" type="text" value="{ionic_canyon}" /></th>
        <th><input name="buster_canyon" size="5" type="text" value="{buster_canyon}" /></th>
        <th><input name="graviton_canyon" size="5" type="text" value="{graviton_canyon}" /></th>
</tr>
<tr>
        <th>{ad_small_protection_shield}</th>
        <th>{ad_big_protection_shield}</th>
        <th>{ad_planet_protector}</th>
        <th>{ad_interceptor_misil}</th>
        <th>{ad_interplanetary_misil}</th>
        <th>{ad_planet_protector}</th>
        <th>&nbsp;</th>
</tr>

<tr>
        <th><input name="small_protection_shield" size="5" type="text" value="{small_protection_shield}" /></th>
        <th><input name="big_protection_shield" size="5" type="text" value="{big_protection_shield}" /></th>
        <th><input name="planet_protector" size="5" type="text" value="{planet_protector}" /></th>
        <th><input name="interceptor_misil" size="5" type="text" value="{interceptor_misil}" /></th>
        <th><input name="interplanetary_misil" size="5" type="text" value="{interplanetary_misil}" /></th>
        <th><input name="planet_protector" size="5" type="text" value="{planet_protector}" /></th>
        <th><input name="&nbsp;" size="5" type="text" value="&nbsp;" /></th>
</tr>
</table>
<table width="800" style="color:#FFFFFF;">
<tr>
      <td class="c" colspan="10">Gebäude bearbeiten</td>
</tr>
<tr>
      <th>Roboterfabrik</th>
      <th>Schiffswerft</th>
      <th>Metallspeicher</th>
      <th>Kristallspeicher </th>
      <th>Deuteriumtank</th>
</tr>
<tr>
      <th><input name="robot_factory" size="5" type="text" value="{robot_factory}" /></th>
      <th><input name="hangar" size="5" type="text" value="{hangar}" /></th>
      <th><input name="metal_store" size="5" type="text" value="{metal_store}" /></th>
      <th><input name="crystal_store" size="5" type="text" value="{crystal_store}" /></th>
      <th><input name="deuterium_store" size="5" type="text" value="{deuterium_store}" /></th>
</tr>
<tr>
      <th>Allianzdepot</th>
      <th>Mondbasis</th>
      <th>Sensorphalanx</th>
      <th>Sprungtor</th>
      <th>&nbsp;</th>
</tr>
<tr>
      <th><input name="ally_deposit" size="5" type="text" value="{ally_deposit}" /></th>
      <th><input name="mondbasis" size="5" type="text" value="{mondbasis}" /></th>
      <th><input name="phalanx" size="5" type="text" value="{phalanx}" /></th>
      <th><input name="sprungtor" size="5" type="text" value="{sprungtor}" /></th>
      <th><input name="&nbsp;" size="5" type="text" value="&nbsp;" /></th>
</tr>
<tr>
      <th colspan="14"><input type="Submit" name="submit" value="Änderungen speichern" /></th>
    </tr>
  </table>
  </form>