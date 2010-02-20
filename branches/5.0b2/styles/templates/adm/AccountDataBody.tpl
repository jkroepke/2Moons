<script>document.body.style.overflow = "auto";</script> 
<body>
<!DOCTYPE HTML>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="../scripts/animatedcollapse.js"></script>
<script type="text/javascript">

animatedcollapse.addDiv('pla', 'fade=1,height=auto')
animatedcollapse.addDiv('inves', 'fade=1,height=auto')
animatedcollapse.addDiv('info', 'fade=1,height=auto')
animatedcollapse.addDiv('recursos', 'fade=1,height=auto')
animatedcollapse.addDiv('edificios', 'fade=1,height=auto')
animatedcollapse.addDiv('especiales', 'fade=1,height=auto')
animatedcollapse.addDiv('naves', 'fade=1,height=auto')
animatedcollapse.addDiv('defensa', 'fade=1,height=auto')
animatedcollapse.addDiv('datos', 'fade=1,height=auto')
animatedcollapse.addDiv('editar', 'fade=1,height=auto')
animatedcollapse.addDiv('destr', 'fade=1,height=auto')
//animatedcollapse.addDiv('mensajes', 'fade=1,height=auto')

animatedcollapse.addDiv('imagen', 'fade=0,speed=400,group=pets')
animatedcollapse.addDiv('alianza', 'fade=0,speed=400,group=pets')
animatedcollapse.addDiv('externo', 'fade=0,speed=400,group=pets')
animatedcollapse.addDiv('interno', 'fade=0,speed=400,group=pets')
animatedcollapse.addDiv('solicitud', 'fade=0,speed=400,group=pets')
animatedcollapse.addDiv('puntaje', 'fade=0,speed=400,group=pets')
animatedcollapse.addDiv('puntaje_ali', 'fade=0,speed=400,group=pets')

animatedcollapse.ontoggle=function($, divobj, state){
}

animatedcollapse.init()
</script>
<style>
.image{width:100%;height:100%;_height:auto;}
</style>

<!--Datos de la cuenta-->
<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="60%" align="center" valign="top">
<tr>
<td class="c" width="7%" class="c" colspan="0">
{ac_account_data}<a href="javascript:animatedcollapse.toggle('datos')"><div align="right">{ac_minimize_maximize}</div></a>
</td>
</tr>
</table>
<div id="datos">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="60%">
<tr><th>{ac_id}</th><th>{id}</th></tr>
<tr><th>{ac_name}</th><th>{nombre}</th></tr>
<tr><th>{ac_password}</th><th>{contra}</th></tr>
<tr><th>{ac_mail}</th><th>{email_1}</th></tr>
<tr><th>{ac_perm_mail}</th><th>{email_2}</th></tr>
<tr><th>{ac_auth_level}</th><th>{nivel}</th></tr>
<tr><th>{ac_on_vacation}</th><th>{vacas}</th></tr>
<tr><th>{ac_banned}</th><th>{suspen}</th></tr>
<tr><th>{ac_alliance} {mas}</th><th>{alianza}{id_ali}</th></tr>
<tr><th>{ac_reg_ip}</th><th>{ip}</th></tr>
<tr><th>{ac_last_ip}</th><th>{ip2}</th></tr>
<tr><th>{ac_register_time}</th><th>{reg_time}</th></tr>
<tr><th>{ac_act_time}</th><th>{onlinetime}</th></tr>
<tr><th>{ac_home_planet_id}</th><th>{id_p}</th></tr>
<tr><th>{ac_home_planet_coord}</th><th>[{g}:{s}:{p}]</th></tr>
<tr><th>{ac_user_system}</th><th>{info}</th></tr>
<tr><th>{ac_ranking}</th><th><a href="#" rel="toggle[puntaje]">{ac_see_ranking}</a></th></tr>
</table>

<br>
<div id="alianza" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#08088A" width="60%">
<tr><td class="c" colspan="2" class="ali">{ac_info_ally}</td></tr>
<tr><th width="25%" align="center" >ID</th><th>{id_aliz}</th></tr>
<tr><th>{ac_leader}</th><th>{ali_lider}</th></tr>
<tr><th>{ac_tag}</th><th>{tag}</th></tr>
<tr><th>{ac_name_ali}</th><th>{ali_nom}</th></tr>
<tr><th>{ac_ext_text}</th><th>{ali_ext}</th></tr>
<tr><th>{ac_int_text}</th><th>{ali_int}</th></tr>
<tr><th>{ac_sol_text}</th><th>{ali_sol}</th></tr>
<tr><th>{ac_image}</th><th>{ali_logo}</th></tr>
<tr><th>{ac_ally_web}</th><th>{ali_web}</th></tr>
<tr><th>{ac_register_ally_time}</th><th>{ally_register_time}</th></tr>
<tr><th>{ac_total_members}</th><th>{ali_cant}</th></tr>
<tr><th>{ac_ranking}</th><th><a href="#" rel="toggle[puntaje_ali]">{ac_see_ranking}</a></th></tr>
</table>
</div>

<div id="imagen" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#08088A" width="60%">
<tr><th class="ali"><a href="#" rel="toggle[alianza]" class="aaa">{ac_back_to_ally}</a></th></tr>
<tr><th width="60%"><img src="{ali_logo2}" class="image"/></th></tr>
<tr><th><a href="{ali_logo2}" target="_blank">{ac_view_image}</a></th></tr>
<tr><th>URL: <input type="text" size="50" value="{ali_logo2}"></th></tr>
</table>
</div>

<div id="externo" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#08088A" width="60%">
<tr><th class="ali"><a href="#" rel="toggle[alianza]" class="aaa">{ac_back_to_ally}</a></th></tr>
<tr><th width="60%">{ali_ext2}</th></tr>
</table>
</div>

<div id="interno" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#08088A" width="60%">
<tr><th class="ali"><a href="#" rel="toggle[alianza]" class="aaa">{ac_back_to_ally}</a></th></tr>
<tr><th width="60%">{ali_int2}</th></tr>
</table>
</div>

<div id="solicitud" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#08088A" width="60%">
<tr><th class="ali"><a href="#" rel="toggle[alianza]" class="aaa">{ac_back_to_ally}</a></th></tr>
<tr><th width="60%">{ali_sol2}</th></tr>
</table>
</div>

<!-- PUNTAJE DEL USUARIO -->
<div id="puntaje" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#08088A" width="60%">
<tr><td class="c" colspan="3" class="centrado2">{ac_user_ranking}</td></tr>
<td class="c" width="15%"></td><td class="c" width="40%" class="centrado">{ac_points_count}</td><td class="c" width="5%" class="centrado">{ac_ranking}</td>
<tr><th width="15%" class="centrado">{ac_tenology}</th><th width="40%">{point_tecno} ({count_tecno} {ac_tenology})</th><th width="5%" class="ranking"># {ranking_tecno}</th></tr>
<tr><th width="15%" class="centrado">{ac_defenses}</th><th width="40%">{point_def} ({count_def} {ac_defenses})</th><th width="5%" class="ranking"># {ranking_def}</th></tr>
<tr><th width="15%" class="centrado">{ac_fleets}</th><th width="40%">{point_fleet} ({count_fleet} {ac_ships})</th><th width="5%" class="ranking"># {ranking_fleet}</th></tr>
<tr><th width="15%" class="centrado">{ac_builds}</th><th width="40%">{point_builds} ({count_builds} {ac_builds})</th><th width="5%" class="ranking"># {ranking_builds}</th></tr>
<tr><th colspan="3" class="total">{ac_total_points}<font color="#FF0000">{total_points}</font></th></tr>
</table>
</div>

<!-- PUNTAJE DE LA ALIANZA DEL USUARIO -->
<div id="puntaje_ali" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#08088A" width="60%">
<tr><td class="c" colspan="3" class="centrado2">{ac_ally_ranking}</td></tr>
<td class="c" width="15%"></td><td class="c" width="40%" class="centrado">{ac_points_count}</td><td class="c" width="5%" class="centrado">{ac_ranking}</td>
<tr><th width="15%" class="centrado">{ac_tenology}</th><th width="40%">{point_tecno_ali} ({count_tecno_ali} {ac_tenology})</th><th width="5%" class="ranking"># {ranking_tecno_ali}</th></tr>
<tr><th width="15%" class="centrado">{ac_defenses}</th><th width="40%">{point_def_ali} ({count_def_ali} {ac_defenses})</th><th width="5%" class="ranking"># {ranking_def_ali}</th></tr>
<tr><th width="15%" class="centrado">{ac_fleets}</th><th width="40%">{point_fleet_ali} ({count_fleet_ali} {ac_ships})</th><th width="5%" class="ranking"># {ranking_fleet_ali}</th></tr>
<tr><th width="15%" class="centrado">{ac_builds}</th><th width="40%">{point_builds_ali} ({count_builds_ali} {ac_builds})</th><th width="5%" class="ranking"># {ranking_builds_ali}</th></tr>
<tr><th colspan="3" class="total">{ac_total_points}<font color="#FF0000">{total_points_ali}</font></th></tr>
<tr><th class="ali" colspan="3"><a href="#" rel="toggle[alianza]" class="aaa">{ac_back_to_ally}</a></th></tr>
</table>
</div>
</div>
<br />


<!--Informacion detallada de planetas y lunas-->
<br /><br /><br /><br />
<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="80%" align="center" valign="top">
<tr>
<td class="c" width="7%" align="left" colspan="0">{ac_detailed_planet_moon_info}
<a href="javascript:animatedcollapse.toggle('info')"><div align="left">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<br />



<div id="info">
<!--Planetas y lunas-->
<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="20%" align="center" valign="top">
<tr>
<td class="c" width="7%" align="center" colspan="0">{ac_id_names_coords}
<a href="javascript:animatedcollapse.toggle('pla')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="pla" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="70%">
<tr>
<td class="c" width="6%" align="center" valign="top">{ac_id}</td>
<td class="c" width="35%" align="center" valign="top">{ac_name}</td>
<td class="c" width="15%" align="center" valign="top">{ac_coords}</td>
<td class="c" width="15%" align="center" valign="top">{ac_diameter}</td>
<td class="c" width="15%" align="center" valign="top">{ac_fields}</td>
<td class="c" width="25%" align="center" valign="top">{ac_temperature}</td>
</tr>
{planetas}
</table>
<br>
</div>
<br />


<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="25%" align="center" valign="top">
<tr>
<td class="c" width="7%" align="center" colspan="0">{ac_resources}
<a href="javascript:animatedcollapse.toggle('recursos')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="recursos" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
<td class="c" width="12%" align="center" colspan="0"><center>{ac_resources}</center></td>
<center>{planetas2}</center>
<tr><th>{Metal}</th>{metal}</tr>
<tr><th>{Crystal}</th>{cristal}</tr>
<tr><th>{Deuterium}</th>{deute}</tr>
<tr><th>{Energy}</th>{energia}</tr>
</table>
<br />
<table border="5" cellpadding="2" cellspacing="5" style="border-collapse: collapse" bordercolor="#000000" width="50%">
<tr><td class="c" width="25%" align="center" colspan="0">{Darkmatter}</td><th width="50%" align="center" colspan="0">{mo}</th></tr>
</table>
</div>
<br />


<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="30%" align="center" valign="top">
<tr>
<td class="c" width="7%" align="center" colspan="0">{ad_buildings}
<a href="javascript:animatedcollapse.toggle('edificios')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="edificios" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
<td class="c" width="12%" align="center" colspan="0"><center>{ad_buildings}</center></td>
{planetas2}
<tr><th>{ad_metal_mine}</th>{mina_metal}</tr>
<tr><th>{ad_crystal_mine}</th>{mina_cristal}</tr>
<tr><th>{ad_deuterium_sintetizer}</th>{mina_deu}</tr>
<tr><th>{ad_solar_plant}</th>{planta_s}</tr>
<tr><th>{ad_fusion_plant}</th>{planta_f}</tr>
<tr><th>{ad_robot_factory}</th>{fabrica}</tr>
<tr><th>{ad_nano_factory}</th>{nanos}</tr>
<tr><th>{ad_shipyard}</th>{hangar}</tr>
<tr><th>{ad_metal_store}</th>{almacen_m}</tr>
<tr><th>{ad_crystal_store}</th>{almacen_c}</tr>
<tr><th>{ad_deuterium_store}</th>{almacen_d}</tr>
<tr><th>{ad_laboratory}</th>{labo}</tr>
<tr><th>{ad_terraformer}</th>{terra}</tr>
<tr><th>{ad_ally_deposit}</th>{ali}</tr>
<tr><th>{ad_silo}</th>{silo}</tr>
</table>
</div>
<br />

<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="35%" align="center" valign="top">
<tr>
<td class="c" width="7%" align="center" colspan="0">{ac_lunar_buildings} {no_moon}
{min_max}</td>
</tr>
</table>
<div id="especiales" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
<td class="c" width="12%" align="center" colspan="0"><center>{ac_short_lunar_buildings}</center></td>
{lunas}
<tr><th>{ac_lunar_base}</th>{base}</tr>
<tr><th>{ac_phalanx}</th>{phalanx}</tr>
<tr><th>{ac_jump_gate}</th>{salto}</tr>
</table>
</div>
<br />

<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="40%" align="center" valign="top">
<tr>
<td class="c" width="7%" align="center" colspan="0">{ac_ships}
<a href="javascript:animatedcollapse.toggle('naves')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="naves" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
<td class="c" width="12%" align="center" colspan="0"><center>{ac_ships}</center></td>
{planetas2}
<tr><th>{ad_small_ship_cargo}</th>{peque}</tr>
<tr><th>{ad_big_ship_cargo}</th>{grande}</tr>
<tr><th>{ad_light_hunter}</th>{ligero}</tr>
<tr><th>{ad_heavy_hunter}</th>{pesado}</tr>
<tr><th>{ad_crusher}</th>{cru}</tr>
<tr><th>{ad_battle_ship}</th>{nave}</tr>
<tr><th>{ad_colonizer}</th>{colo}</tr>
<tr><th>{ad_recycler}</th>{reci}</tr>
<tr><th>{ad_spy_sonde}</th>{sondas}</tr>
<tr><th>{ad_bomber_ship}</th>{bomba}</tr>
<tr><th>{ad_solar_satelit}</th>{satelite}</tr>
<tr><th>{ad_destructor}</th>{destru}</tr>
<tr><th>{ad_dearth_star}</th>{edlm}</tr>
<tr><th>{ad_battleship}</th>{aco}</tr>
<tr><th>{ac_supernova}</th>{supernova}</tr>
</table>
</div>
<br />

<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="45%" align="center" valign="top">
<tr>
<td class="c" width="7%" align="center" colspan="0">{ac_defense}
<a href="javascript:animatedcollapse.toggle('defensa')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="defensa" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
<td class="c" width="12%" align="center" colspan="0"><center>{ac_defense}</center></td>
{planetas2}
<tr><th>{ad_misil_launcher}</th>{lanza}</tr>
<tr><th>{ad_small_laser}</th>{laser_p}</tr>
<tr><th>{ad_big_laser}</th>{laser_g}</tr>
<tr><th>{ad_gauss_canyon}</th>{gauss}</tr>
<tr><th>{ad_ionic_canyon}</th>{ionico}</tr>
<tr><th>{ad_buster_canyon}</th>{plasma}</tr>
<tr><th>{ad_small_protection_shield}</th>{c_peque}</tr>
<tr><th>{ad_big_protection_shield}</th>{c_grande}</tr>
<tr><th>{ac_planet_protector}</th>{protector}</tr>
<tr><th>{ad_interceptor_misil}</th>{misil_i}</tr>
<tr><th>{ad_interplanetary_misil}</th>{misil_in}</tr>
</table>
</div>
<br />


<!--Investigaciones y oficiales-->
<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="50%" align="center" valign="top">
<tr>
<td class="c" width="7%" align="center" colspan="0">{ac_officier_research}
<a href="javascript:animatedcollapse.toggle('inves')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="inves" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="60%">
<tr>
<td class="c" width="40%" align="center" valign="top">{ac_research}</td>
<td class="c" width="40%" align="center" valign="top">{ac_officier}</td>
</tr>
<tr><th>{ad_spy_tech}: {tec_espia}</th><th>{ac_geologist}: {ofi_geologo}</th></tr>
<tr><th>{ad_computer_tech}: {tec_compu}</th><th>{ac_admiral}: {ofi_almirante}</th></tr>
<tr><th>{ad_military_tech}: {tec_militar}</th><th>{ac_engineer}: {ofi_ingeniero}</th></tr>
<tr><th>{ad_defence_tech}: {tec_defensa}</th><th>{ac_technocrat}: {ofi_tecnocrata}</th></tr>
<tr><th>{ad_shield_tech}: {tec_blindaje}</th><th>{ac_spy}: {ofi_espia}</th></tr>
<tr><th>{ad_energy_tech}: {tec_energia}</th><th>{ac_constructor}: {ofi_constructor}</th></tr>
<tr><th>{ad_hyperspace_tech}: {tec_hiperespacio}</th><th>{ac_scientific}: {ofi_cientifico}</th></tr>
<tr><th>{ad_combustion_tech}: {tec_combustion}</th><th>{ac_commander}: {ofi_comandante}</th></tr>
<tr><th>{ad_impulse_motor_tech}: {tec_impulso}</th><th>{ac_storer}: {ofi_almacenista}</th></tr>
<tr><th>{ad_hyperspace_motor_tech}: {tec_hiperespacio_p}</th><th>{ac_defender}: {ofi_defensa}</th></tr>
<tr><th>{ad_laser_tech}: {tec_laser}</th><th>{ac_destroyer}: {ofi_destructor}</th></tr>
<tr><th>{ad_ionic_tech}: {tec_ionico}</th><th>{ac_general}: {ofi_general}</th></tr>
<tr><th>{ad_buster_tech}: {tec_plasma}</th><th>{ac_protector}: {ofi_bunker}</th></tr>
<tr><th>{ad_intergalactic_tech}: {tec_intergalactico}</th><th>{ac_conqueror}: {ofi_conquis}</th></tr>
<tr><th>{ad_expedition_tech}: {tec_expedicion}</th><th>{ac_emperor}: {ofi_emperador}</th></tr>
<tr><th>{ad_graviton_tech}: {tec_graviton}</th></tr>
</table>
</div>
<br />

<!--Planetas y lunas destruidos-->
<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="55%" align="center" valign="top">
<tr>
<td class="c" width="7%" align="center" colspan="0">{ac_recent_destroyed_planets}
<a href="javascript:animatedcollapse.toggle('destr')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="destr" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="60%">
<tr>
<td class="c" width="6%" align="center" valign="top">{ac_id}</td>
<td class="c" width="40%" align="center" valign="top">{ac_name}</td>
<td class="c" width="30%" align="center" valign="top">{ac_coords}</td>
</tr>
{planetas_d}
</table>
</div>
<br />

<!--
<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="60%" align="center" valign="top">
<tr>
<td class="c" width="7%" align="center" colspan="0">{ac_messages} {conteoo}
<a href="javascript:animatedcollapse.toggle('mensajes')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="mensajes" style="display:none">
{sin_mensajes}
{messages_list}
</div>-->
</div>


<br><br><br><br>
</body>