<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################


define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.' . PHP_EXT);
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($Observation != 1) die();

$parse	= 	$lang;


$UserWhileLogin	= $db->query("SELECT `id`, `username` FROM ".USERS." ORDER BY `username` ASC;");
while($UserList	= $db->fetch_array($UserWhileLogin))
{
	$parse['lista']	.=	"<option value=\"".$UserList['id']."\">".$UserList['username']."</option>";
}


if($_POST['id_u'] != NULL)
{
	$id_u	=	$_POST['id_u'];
}
else
{
	$id_u	=	$_POST['id_u2'];
}


$modo		=	$_POST['modo'];
$info_u 	= 	$db->query("SELECT * FROM ".USERS." WHERE `id` LIKE '%".$id_u."%';");
$info_p		=	$db->query("SELECT * FROM ".PLANETS." WHERE `id_owner` = '".$id_u."';");	//Consulta para sacar datos de la tabla de planetas

		
	if ($modo == "datos")
	{
		if ($id_u == NULL)
		{
			$parse['error']	=	$lang['ac_user_id_required'];
		}
		elseif($_POST['id_u'] != NULL && $_POST['id_u2'] != NULL)
		{
			$parse['error']	=	$lang['ac_select_one_id'];
		}
		elseif(!is_numeric($id_u))
		{
			$parse['error']	=	$lang['ac_no_character'];
		}
		elseif($db->num_rows($info_u) == 0)
		{
			$parse['error']	=	$lang['ac_username_doesnt'];
		}
		else
		{
			//Despliegue de todos los datos de la cuenta
			while ($b = $db->fetch_array($info_u))
			{
				$identi						=	$b['id'];
				$nivel						=	$b['authlevel'];
				$vacas						=	$b['urlaubs_modus'];
				$alianza					=	$b['ally_name'];
				$id_ali						=	$b['ally_id'];
				$suspen						=	$b['bana'];
				$parse['reg_time']			=	date("d.M.y H:i:s", $b['register_time']);
				$parse['onlinetime']		=	date("d.M.y H:i:s", $b['onlinetime']);
				$parse['id']				=	$b['id'];
				$parse['nombre']			=	$b['username'];
				$parse['contra']			=	$b['password'];
				$parse['email_1']			=	$b['email'];
				$parse['email_2']			=	$b['email_2'];
				$parse['ip']				=	$b['ip_at_reg'];
				$parse['ip2']				=	$b['user_lastip'];
				$parse['id_p']				=	$b['id_planet'];
				$parse['g']					=	$b['galaxy'];
				$parse['s']					=	$b['system'];
				$parse['p']					=	$b['planet'];
				$parse['info']				=	$b['user_agent'];

				//Materia Oscura
				$parse['mo']	.=	pretty_number($b['darkmatter']);


				//Investigaciones
				$parse['tec_espia']				=	$b['spy_tech'];
				$parse['tec_compu']				=	$b['computer_tech'];
				$parse['tec_militar']			=	$b['military_tech'];
				$parse['tec_defensa']			=	$b['defence_tech'];
				$parse['tec_blindaje']			=	$b['shield_tech'];
				$parse['tec_energia']			=	$b['energy_tech'];
				$parse['tec_hiperespacio']		=	$b['hyperspace_tech'];
				$parse['tec_combustion']		=	$b['combustion_tech'];
				$parse['tec_impulso']			=	$b['impulse_motor_tech'];
				$parse['tec_hiperespacio_p']	=	$b['hyperspace_motor_tech'];
				$parse['tec_laser']				=	$b['laser_tech'];
				$parse['tec_ionico']			=	$b['ionic_tech'];
				$parse['tec_plasma']			=	$b['buster_tech'];
				$parse['tec_intergalactico']	=	$b['intergalactic_tech'];
				$parse['tec_expedicion']		=	$b['expedition_tech'];
				$parse['tec_graviton']			=	$b['graviton_tech'];
				
				
				//Oficiales
				$parse['ofi_geologo']			=	$b['rpg_geologue'];
				$parse['ofi_almirante']			=	$b['rpg_amiral'];
				$parse['ofi_ingeniero']			=	$b['rpg_ingenieur'];
				$parse['ofi_tecnocrata']		=	$b['rpg_technocrate'];
				$parse['ofi_espia']				=	$b['rpg_espion'];
				$parse['ofi_constructor']		=	$b['rpg_constructeur'];
				$parse['ofi_cientifico']		=	$b['rpg_scientifique'];
				$parse['ofi_comandante']		=	$b['rpg_commandant'];
				$parse['ofi_almacenista']		=	$b['rpg_stockeur'];
				$parse['ofi_defensa']			=	$b['rpg_defenseur'];
				$parse['ofi_destructor']		=	$b['rpg_destructeur'];
				$parse['ofi_general']			=	$b['rpg_general'];
				$parse['ofi_bunker']			=	$b['rpg_bunker'];
				$parse['ofi_conquis']			=	$b['rpg_raideur'];
				$parse['ofi_emperador']			=	$b['rpg_empereur'];
			}



			if ($vacas != 0)
			{
				$parse['vacas']	=	$lang['ac_yes'];
			}
			else
			{
				$parse['vacas']	=	$lang['ac_no'];
			}


			if ($suspen != 0)
			{
				$parse['suspen']	=	$lang['ac_yes'];
			}
			else
			{
				$parse['suspen']	=	$lang['ac_no'];
			}
			
			//Puntaje
			$info_puntaje	=	$db->query("SELECT * FROM ".STATPOINTS." WHERE `id_owner` = '".$id_u."';");
			
			while ($f = $db->fetch_array($info_puntaje))
			{
				$stat_type	=	$f['stat_type'];
				if ($stat_type	==	'1')
				{
					$count_tecno	=	pretty_number($f['tech_count']);
					$count_def		=	pretty_number($f['defs_count']);
					$count_fleet	=	pretty_number($f['fleet_count']);
					$count_builds	=	pretty_number($f['build_count']);
				
					$point_builds	=	pretty_number($f['build_points']);
					$point_tecno	=	pretty_number($f['tech_points']);
					$point_def		=	pretty_number($f['defs_points']);
					$point_fleet	=	pretty_number($f['fleet_points']);
				
				
					$ranking_tecno		=	$f['tech_rank'];
					$ranking_builds		=	$f['build_rank'];
					$ranking_def		=	$f['defs_rank'];
					$ranking_fleet		=	$f['fleet_rank'];
				
					$total_points	=	pretty_number($f['total_points']);
					
					
					$parse['count_tecno']	=	$count_tecno;
					$parse['count_def']		=	$count_def;
					$parse['count_fleet']	=	$count_fleet;
					$parse['count_builds']	=	$count_builds;
				
					$parse['point_builds']	=	$point_builds;
					$parse['point_tecno']	=	$point_tecno;
					$parse['point_def']		=	$point_def;
					$parse['point_fleet']	=	$point_fleet;
				
				
					$parse['ranking_tecno']		=	$ranking_tecno;
					$parse['ranking_builds']	=	$ranking_builds;
					$parse['ranking_def']		=	$ranking_def;
					$parse['ranking_fleet']		=	$ranking_fleet;
				
					$parse['total_points']	=	$total_points;
				}
			}

			// ALIANZA
			if ($alianza == 0 && $id_ali == 0)
			{
				$parse['alianza']	=	$lang['ac_no_ally'];
			}
			elseif ($alianza != NULL && $id_ali != 0)
			{
				$parse['alianza']	=	$alianza;
				$parse['id_ali']	=	" (ID: ".$id_ali.")";
				$parse['mas']		=	"<a href=\"#\" rel=\"toggle[alianza]\" class=\"editar_l\">".$lang['ac_more']."</a>";

				
				$info_a		=	$db->query("SELECT * FROM ".ALLIANCE." WHERE `ally_name` = '".$alianza."';");
				while ($c = $db->fetch_array($info_a))
				{
					include_once("AdminFunctions/BBCode-Panel-Adm.php");	
					$bbcode = new bbcode;			
					
					$ali_lider			=	$c['ally_owner'];
					$parse['id_aliz']	=	$c['id'];
					$parse['tag']		=	$c['ally_tag'];
					$parse['ali_nom']	=	$c['ally_name'];
					
					if($c['ally_web'] != NULL){$parse['ali_web'] = $c['ally_web'];}else{$parse['ali_web'] = $lang['ac_no_web'];}
					
					if($c['ally_description'] != NULL)
					{
						$parse['ali_ext2'] = $bbcode->reemplazo($c['ally_description']);
						$parse['ali_ext']  = "<a href=\"#\" rel=\"toggle[externo]\">".$lang['ac_view_text_ext']."</a>";}
					else
					{$parse['ali_ext'] = $lang['ac_no_text_ext'];}
					
					if($c['ally_text'] != NULL)
					{
						$parse['ali_int2'] = $bbcode->reemplazo($c['ally_text']);
						$parse['ali_int']  = "<a href=\"#\" rel=\"toggle[interno]\">".$lang['ac_view_text_int']."</a>";}
					else{$parse['ali_int'] = $lang['ac_no_text_int'];}
					
					if($c['ally_request'] != NULL)
					{
						$parse['ali_sol2'] = $bbcode->reemplazo($c['ally_request']);
						$parse['ali_sol']  = "<a href=\"#\" rel=\"toggle[solicitud]\">".$lang['ac_view_text_sol']."</a>";}
					else{$parse['ali_sol'] = $lang['ac_no_text_sol'];}
					
					if($c['ally_image'] != NULL)
					{
						$parse['ali_logo2'] = $c['ally_image'];
						$parse['ali_logo'] = "<a href=\"#\" rel=\"toggle[imagen]\">".$lang['ac_view_image2']."</a>";}
					else{$parse['ali_logo'] = $lang['ac_no_img'];}
					
					$parse['ali_cant']				=	$c['ally_members'];
					$parse['ally_register_time']	=	gmdate("d/M/y H:i:s", $c['ally_register_time']);
				}
			
				$info_uu	=	$db->query("SELECT username FROM ".USERS." WHERE `id` = '".$ali_lider."';");
				while ($d = $db->fetch_array($info_uu))
				{
					$parse['ali_lider']	=	$d['username'];
				}
				
				
			$info_puntaje_ali	=	$db->query("SELECT * FROM ".STATPOINTS." WHERE `id_owner` = '".$id_ali."';");
			while ($g = $db->fetch_array($info_puntaje_ali))
			{
				$stat_type	=	$g['stat_type'];
				if ($stat_type	==	'2')
				{		
					$parse['count_tecno_ali']	=	pretty_number($g['tech_count']);
					$parse['count_def_ali']		=	pretty_number($g['defs_count']);
					$parse['count_fleet_ali']	=	pretty_number($g['fleet_count']);
					$parse['count_builds_ali']	=	pretty_number($g['build_count']);
				
					$parse['point_builds_ali']	=	pretty_number($g['build_points']);
					$parse['point_tecno_ali']	=	pretty_number($g['tech_points']);
					$parse['point_def_ali']		=	pretty_number($g['defs_points']);
					$parse['point_fleet_ali']	=	pretty_number($g['fleet_points']);
				
				
					$parse['ranking_tecno_ali']		=	$g['tech_rank'];
					$parse['ranking_builds_ali']	=	$g['build_rank'];
					$parse['ranking_def_ali']		=	$g['defs_rank'];
					$parse['ranking_fleet_ali']		=	$g['fleet_rank'];
				
					$parse['total_points_ali']		=	pretty_number($g['total_points']);
				}
			}
		}	


			if ($nivel == 3)
			{
				$parse['nivel']	=	$lang['user_level'][3];
			}
			elseif ($nivel == 2)
			{
				$parse['nivel']	=	$lang['user_level'][2];
			}
			elseif ($nivel == 1)
			{
				$parse['nivel']	=	$lang['user_level'][1];
			}
			elseif ($nivel == 0)
			{
				$parse['nivel']	=	$lang['user_level'][0];
			}

			
			//Despliegue de todos los datos de los planetas
			while ($a = $db->fetch_array($info_p))
			{
				if ($a["destruyed"] == 0) {
				//Recursos
				$parse['metal']		.=	"<th>".pretty_number($a['metal'])."</th>";
				$parse['cristal']	.=	"<th>".pretty_number($a['crystal'])."</th>";
				$parse['deute']		.=	"<th>".pretty_number($a['deuterium'])."</th>";
				$parse['energia']	.=	"<th>".pretty_number($a['energy_max'])."</th>";

				//Edificios
				$parse['mina_metal']	.=	"<th>".pretty_number($a['metal_mine'])."</th>";
				$parse['mina_cristal']	.=	"<th>".pretty_number($a['crystal_mine'])."</th>";
				$parse['mina_deu']		.=	"<th>".pretty_number($a['deuterium_sintetizer'])."</th>";
				$parse['planta_s']		.=	"<th>".pretty_number($a['solar_plant'])."</th>";
				$parse['planta_f']		.=	"<th>".pretty_number($a['fusion_plant'])."</th>";
				$parse['fabrica']		.=	"<th>".pretty_number($a['robot_factory'])."</th>";
				$parse['nanos']			.=	"<th>".pretty_number($a['nano_factory'])."</th>";
				$parse['hangar']		.=	"<th>".pretty_number($a['hangar'])."</th>";
				$parse['almacen_m']		.=	"<th>".pretty_number($a['metal_store'])."</th>";
				$parse['almacen_c']		.=	"<th>".pretty_number($a['crystal_store'])."</th>";
				$parse['almacen_d']		.=	"<th>".pretty_number($a['deuterium_store'])."</th>";
				$parse['labo']			.=	"<th>".pretty_number($a['laboratory'])."</th>";
				$parse['terra']			.=	"<th>".pretty_number($a['terraformer'])."</th>";
				$parse['ali']			.=	"<th>".pretty_number($a['ally_deposit'])."</th>";
				$parse['silo']			.=	"<th>".pretty_number($a['silo'])."</th>";

				$moont	=	0;
				if ($a['planet_type'] == 3)
				{
					//Edificios de la luna
					$parse['base']		.=	"<th>".pretty_number($a['mondbasis'])."</th>";
					$parse['phalanx']	.=	"<th>".pretty_number($a['phalanx'])."</th>";
					$parse['salto']		.=	"<th>".pretty_number($a['sprungtor'])."</th>";
					$moont++;
				}
				if ($moont == 0){$parse['no_moon']	=	$lang['ac_moons_no'];$parse['min_max']	= "";}else{
				$parse['min_max']	=	"<a href=\"javascript:animatedcollapse.toggle('especiales')\"><div align=\"center\">
											".$lang['ac_minimize_maximize']."</div></a>";$parse['no_moon']	=	"";}

				//Naves
				$parse['peque']		.=	"<th>".pretty_number($a['small_ship_cargo'])."</th>";
				$parse['grande']	.=	"<th>".pretty_number($a['big_ship_cargo'])."</th>";
				$parse['ligero']	.=	"<th>".pretty_number($a['light_hunter'])."</th>";
				$parse['pesado']	.=	"<th>".pretty_number($a['heavy_hunter'])."</th>";
				$parse['cru']		.=	"<th>".pretty_number($a['crusher'])."</th>";
				$parse['nave']		.=	"<th>".pretty_number($a['battle_ship'])."</th>";
				$parse['colo']		.=	"<th>".pretty_number($a['colonizer'])."</th>";
				$parse['reci']		.=	"<th>".pretty_number($a['recycler'])."</th>";
				$parse['sondas']	.=	"<th>".pretty_number($a['spy_sonde'])."</th>";
				$parse['bomba']		.=	"<th>".pretty_number($a['bomber_ship'])."</th>";
				$parse['satelite']	.=	"<th>".pretty_number($a['solar_satelit'])."</th>";
				$parse['destru']	.=	"<th>".pretty_number($a['destructor'])."</th>";
				$parse['edlm']		.=	"<th>".pretty_number($a['dearth_star'])."</th>";
				$parse['aco']		.=	"<th>".pretty_number($a['battleship'])."</th>";
				$parse['supernova']	.=	"<th>".pretty_number($a['supernova'])."</th>";

				//Defensas
				$parse['lanza']		.=	"<th>".pretty_number($a['misil_launcher'])."</th>";
				$parse['laser_p']	.=	"<th>".pretty_number($a['small_laser'])."</th>";
				$parse['laser_g']	.=	"<th>".pretty_number($a['big_laser'])."</th>";
				$parse['gauss']		.=	"<th>".pretty_number($a['gauss_canyon'])."</th>";
				$parse['ionico']	.=	"<th>".pretty_number($a['ionic_canyon'])."</th>";
				$parse['plasma']	.=	"<th>".pretty_number($a['buster_canyon'])."</th>";
				$parse['c_peque']	.=	"<th>".pretty_number($a['small_protection_shield'])."</th>";
				$parse['c_grande']	.=	"<th>".pretty_number($a['big_protection_shield'])."</th>";
				$parse['protector']	.=	"<th>".pretty_number($a['planet_protector'])."</th>";
				$parse['misil_i']	.=	"<th>".pretty_number($a['interceptor_misil'])."</th>";
				$parse['misil_in']	.=	"<th>".pretty_number($a['interplanetary_misil'])."</th>";
				}


				if ($a["destruyed"] == 0)
				{
					if ($a['planet_type'] == 3)
					{
						$parse['planetas'] .= "<tr><th>".$a['id']."</th><th>".$a['name']."&nbsp;(".$lang['ac_moon'].")</th>";
						$parse['planetas'] .= "<th>[".$a['galaxy'].":".$a['system'].":".$a['planet']."]</th>";
						$parse['planetas'] .= "<th>".pretty_number($a['diameter'])."</th>";
						$parse['planetas'] .= "<th>".pretty_number($a['field_current'])."/".pretty_number($a['field_max'])."</th>";
						$parse['planetas'] .= "<th>".$a['temp_min']."/".$a['temp_max']."</th></tr>";
						$parse['lunas']    .= "<th><center><font color=#0099FF>".$a['name']."&nbsp;(".$lang['ac_moon'].")<br>[".$a['galaxy'].":".$a['system'].":".$a['planet']."]</th>";
						$parse['planetas2'] .= "<th><center><font color=#0099FF>".$a['name']."&nbsp;(".$lang['ac_moon'].")
											<br>[".$a['galaxy'].":".$a['system'].":".$a['planet']."]</font><center></th>";
					}
					elseif ($a['planet_type'] == 1)
					{
						$parse['planetas'] .= "<tr><th>".$a['id']."</th><th>".$a['name']."</th>";
						$parse['planetas'] .= "<th>[".$a['galaxy'].":".$a['system'].":".$a['planet']."]</th>";
						$parse['planetas'] .= "<th>".pretty_number($a['diameter'])."</th>";
						$parse['planetas'] .= "<th>".pretty_number($a['field_current'])."/".pretty_number($a['field_max'])."</th>";
						$parse['planetas'] .= "<th>".$a['temp_min']."/".$a['temp_max']."</th></tr>";
						$parse['planetas2'] .= "<th><center><font color=#0099FF>".$a['name']."
												<br>[".$a['galaxy'].":".$a['system'].":".$a['planet']."]</font><center></th>";
					}
				}

				if ($a["destruyed"] > 0)
				{
					$parse['planetas_d'] .= "<tr><th>".$a['id']."</th><th>".$a['name']."</th>";
					$parse['planetas_d'] .= "<th>[".$a['galaxy'].":".$a['system'].":".$a['planet']."]</th></tr>";
				}
			}
			
			/*$info_mensajes	=	$db->query("SELECT * FROM ".MESSAGES." WHERE `message_owner` = '".$id_u."' ORDER BY `message_time` ASC;");
			$i	=	0;
			while ($t	=	$db->fetch_array($info_mensajes))
			{
				$parse['messages_list']	.=
				"<table border=\"5\" cellpadding=\"5\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#000000\" width=\"65%\">
				<tr><th class=\"message\">".$lang['ac_message_id']." <font color=#0099FF>".$t['message_id']."</font></th></tr>
				<tr><th class=\"message\">".$lang['ac_message_from']." <font color=#0099FF>".$t['message_from']."</font></th></tr>
				<tr><th class=\"message\">".$lang['ac_message_subject']." <font color=#0099FF>".$t['message_subject']."</font></th></tr>
				<tr><th class=\"message\">".$lang['ac_message_time']." <font color=#0099FF>".gmdate("d/M/y H:i:s",$t['message_time'])."</font></th></tr>
				<tr><th align=\"left\"><span class=\"message2\">".$lang['ac_message_a']."</span><br><br>".$t['message_text']."</th></tr></table><br>";
				$i++;
			}
			$parse['conteoo']	=	"(".$i.")";
			if($i	==	'0')
			{
				$parse['sin_mensajes']	=
				"<table border=\"5\" cellpadding=\"5\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#000000\" width=\"60%\">
				<tr><td class=\"messages2\"><center>".$lang['ac_messages_no']."</center></td></tr>
				</table>";
			}*/
					
			display (parsetemplate(gettemplate("adm/AccountDataBody"), $parse), false, '', true, false);
		}
	}




display (parsetemplate(gettemplate("adm/AccountDataIntro"), $parse), false, '', true, false);
?>