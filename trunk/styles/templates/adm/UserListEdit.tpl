<script type="text/javascript">

function check(){
	$.post('UserListPage.php?submit=1', $('#userform').serialize(), function(data){
		alert(data);
		window.close();
	});
	return true;
}
</script>
<form method="post" id="userform">
<input type="hidden" name="currid" value="{id}">
<table width="800" style="color:#FFFFFF">
<tr>
        <td class="c" colspan="6">Spieler {username} bearbeiten</td>
</tr>
<tr>
        <th>ID</th>
        <th>Name des Spielers</th>
        <th>Email</th>
        <th>Dunkle Materie</th>
        <th>Urlaubmodos</th>
</tr>
<tr>
        <th>{id}</th>
        <th><input type="text" name="username" size="15" value="{username}"></th>
        <th><input type="text" name="email" size="30" value="{email}"></th>
        <th><input type="text" name="darkmatter" size="10" value="{darkmatter}"></th>
        <th><input type="checkbox" name="umod" value="1" {umodchecked}></th>
</tr>
</table>
<table width="800">
<tr>
        <td class="c" colspan="7">Forschungen bearbeiten</td>
</tr>
<tr>
        <th>Spionagetechnik</th>
        <th>Computertechnik</th>
        <th>Waffentechnik</th>
        <th>Schildtechnik</th>
</tr>
<tr>
        <th><input name="spy_tech" type="text" value="{spy_tech}"></th>
        <th><input name="computer_tech" type="text" value="{computer_tech}"></th>
        <th><input name="military_tech" type="text" value="{military_tech}"></th>
        <th><input name="defence_tech" type="text" value="{defence_tech}"></th>
</tr>
<tr>
        <th>Raumschiffpanzerung</th>
        <th>Energietechnik</th>
        <th>Hyperraumtechnik</th>
        <th>Verbrennungstriebwerk</th>
</tr>
<tr>
        <th><input name="shield_tech" type="text" value="{shield_tech}"></th>
        <th><input name="energy_tech" type="text" value="{energy_tech}"></th>
        <th><input name="hyperspace_tech" type="text" value="{hyperspace_tech}"></th>
        <th><input name="combustion_tech" type="text" value="{combustion_tech}"></th>
</tr>
<tr>
        <th>Impulstriebwerk</th>
        <th>Hyperraumantrieb</th>
        <th>lasertechnik</th>
        <th>Ionentechnik</th>
</tr>
<tr>
        <th><input name="impulse_motor_tech" type="text" value="{impulse_motor_tech}"></th>
        <th><input name="hyperspace_motor_tech" type="text" value="{hyperspace_motor_tech}"></th>
        <th><input name="laser_tech" type="text" value="{laser_tech}"></th>
        <th><input name="ionic_tech" type="text" value="{ionic_tech}"></th>
</tr>
<tr>
        <th>Plasmatechnik</th>
        <th>Intergalaktisches<br>
		Forschungsnetzwerk</th>
        <th>Expeditionstechnik</th>
        <th>Gravitonforschung</th>
</tr>
<tr>
        <th><input name="buster_tech" type="text" value="{buster_tech}"></th>
        <th><input name="intergalactic_tech" type="text" value="{intergalactic_tech}"></th>
        <th><input name="expedition_tech" type="text" value="{expedition_tech}"></th>
        <th><input name="graviton_tech" type="text" value="{graviton_tech}"></th>
</tr>
</table>
<table width="800">
<tr>
        <td class="c" colspan="7">Offiziere bearbeiten</td>
</tr>
<tr>
        <th>Geologe<br>(max. 20)</th>
        <th>Admiral<br>(max. 20)</th>
        <th>Ingenieur<br>(max. 10)</th>
        <th>Technokrat<br>(max. 10)</th>
        <th>Konstrukteur<br>(max. 3)</th>
</tr>
<tr>
        <th><input name="rpg_geologue" type="text" value="{rpg_geologue}"></th>
        <th><input name="rpg_amiral" type="text" value="{rpg_amiral}"></th>
        <th><input name="rpg_ingenieur" type="text" value="{rpg_ingenieur}"></th>
        <th><input name="rpg_technocrate" type="text" value="{rpg_technocrate}"></th>
        <th><input name="rpg_constructeur" type="text" value="{rpg_constructeur}"></th>
</tr>
<tr>
        <th>Wissenschaftler<br>(max. 3)</th>
        <th>Lagermeister<br>(max. 2)</th>
        <th>Verteidiger<br>(max. 2)</th>
        <th>Bunker<br>(max. 1)</th>
        <th>Spion<br>(max. 2)</th>
</tr>
<tr>
        <th><input name="rpg_scientifique" type="text" value="{rpg_scientifique}"></th>
        <th><input name="rpg_stockeur" type="text" value="{rpg_stockeur}"></th>
        <th><input name="rpg_defenseur" type="text" value="{rpg_defenseur}"></th>
        <th><input name="rpg_bunker" type="text" value="{rpg_bunker}"></th>
        <th><input name="rpg_espion" type="text" value="{rpg_espion}"></th>
</tr>
<tr>
        <th>Commandant<br>(max. 3)</th>
        <th>Zerst&ouml;rer<br>(max. 1)</th>
        <th>General<br>(max. 3)</th>
        <th>Eroberer<br>(max. 1)</th>
        <th>Imperoter<br>(max. 1)</th>
</tr>
<tr>
        <th><input name="rpg_commandant" type="text" value="{rpg_commandant}"></th>
        <th><input name="rpg_destructeur" type="text" value="{rpg_destructeur}"></th>
        <th><input name="rpg_general" type="text" value="{rpg_general}"></th>
        <th><input name="rpg_raideur" type="text" value="{rpg_raideur}"></th>
        <th><input name="rpg_empereur" type="text" value="{rpg_empereur}"></th>
</tr>
<tr>
        <th colspan="5"><input type="button" onClick="return check();" value="Absenden"></th>
</tr>
</table>
</form>