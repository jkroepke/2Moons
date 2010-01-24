<!--
/**
# 	ShowLoteriaPage.php, Loteria-C.php
#	Creado por Neko para XG Proyect - xtreme-gamez
#	Algunas ideas sacadas de la Loteria de SainT.
**/
-->

<style>
td {
	color: #000000;
	margin: 3px;
	padding: 3px;
	font-size: 12px;
	font-weight: bold;
	border-bottom-width: thin;
	border-bottom-style: solid;
	border-bottom-color: #000099;
}
</style>

<br><br>
<h2>Configurar loteria</h2>
<form action="LotterieConfigPage.php" method="POST">
<table width="550" class="tabla">
   <tr>
    <th>Metallpreis pro Ticket</th>
    <th align="left" width="50" style="color:red"><input name="metal_precio" type="text" value="{metal_precio}"/></th>
  </tr>
    <tr>
    <th>Kristallpreis pro Ticket</th>
    <th align="left" width="50" style="color:red"><input name="cristal_precio" type="text" value="{cristal_precio}"/></th>
  </tr>
    <tr>
    <th>Deuteriumpreis pro Ticket</th>
    <th align="left" width="50" style="color:red"><input name="deute_precio" type="text" value="{deute_precio}"/></th>
  </tr>
  <tr>
    <th>Dunkle Materie Preis pro Ticket</th>
    <th align="left" width="50" style="color:red"><input name="materia_precio" type="text" value="{materia_precio}"/></th>
  </tr>     
    <tr>
    <th>Gewinn: Metall</th>
    <th align="left" width="50" style="color:red"><input name="metal_premio" type="text" value="{metal_premio}"/></th>
  </tr>
	<tr>
    <th>Gewinn: Kristall</th>
    <th align="left" width="50" style="color:red"><input name="cristal_premio" type="text" value="{cristal_premio}"/></th>
  </tr>
    <tr>
    <th>Gewinn: Deuterium</th>
    <th align="left" width="50" style="color:red"><input name="deute_premio" type="text" value="{deute_premio}"/></th>
  </tr>
    <tr>
    <th>Gewinn: Dunkle Materie</th>
    <th align="left" width="50" style="color:red"><input name="materia_premio" type="text" value="{materia_premio}"/></th>
  </tr>
  <tr>
    <th>Max. Anzahl der Lose</th>
    <th align="left" width="50" style="color:red"><input name="boletos_max" type="text" value="{boletos_max}"/></th>
  </tr>
    <tr>
    <th>Lose por Person</th>
    <th align="left" width="50" style="color:red"><input name="boletos_p_u" type="text" value="{boletos_p_u}"/></th>
  </tr>
  <tr>
    <th>Wartezeit bis nur n&auml;chsten Lotterie</th>
    <th align="left" width="50" style="color:red"><input name="tiempo" type="text" value="{tiempo}"/></th>
  </tr>
  <tr>
    <th>Spieler auschlie&szlig;en(Name oder ID)</th>
    <th align="left" width="50" style="color:red"><input name="suspender" type="text" /></th>
  </tr>
  <tr>
    <th>Spielerspeere aufheben(Name oder ID)</th>
    <th align="left" width="50" style="color:red"><input name="sacar_sus" type="text" /></th>
  </tr>
  <tr>
    <th>Lotterie deaktivieren</th>
    <th align="left" width="50" style="color:red"><center><input name="des-act" type="checkbox" {estado} /></center></th>
  </tr>
  <tr>
    <th>Aktuelle Lotterie leeren</th>
    <th align="left" width="50" style="color:red"><center><input name="reiniciar" type="checkbox" /></center></th>
  </tr>
  <tr>
    <th>Wartezeit aufheben</th>
    <th align="left" width="50" style="color:red"><center><input name="reiniciar_tiempo" type="checkbox" /></center></th>
  </tr>
    <tr>
    <th colspan="2"><input style="width:100%;" value="Aktulisieren" type="submit"></th>
</tr>
</table>
</form> 

<br>

<table width="450">
<th class="c">Gespeerte Spieler</th>
{suspendidos}
</table>