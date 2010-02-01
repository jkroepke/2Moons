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

class ShowOptionsPage
{
	private function CheckIfIsBuilding($CurrentUser)
	{
		global $db;
		$query = $db->query("SELECT b_building,b_tech,b_hangar FROM ".PLANETS." WHERE id_owner = '".$CurrentUser['id']."';");
		
		$this->ClearBuildHanger($CurrentUser['id']);
		
		while($id = $db->fetch_array($query))
		{
			if($id['b_building'] != 0)
			{
				if($id['b_building'] != "")
					return true;
			}
			elseif($id['b_tech'] != 0)
			{
				if($id['b_tech'] != "")
					return true;
			}
			elseif($id['b_hangar'] != 0)
			{
				if($id['b_hangar'] != "")
					return true;
			}
		}
		$fleets = $db->fetch_array($db->query("SELECT * FROM ".FLEETS." WHERE `fleet_owner` = '{$CurrentUser['id']}';"));
		if($fleets != 0)
			return true;

		return false;
	}


	private function ClearBuildHanger($userid)
	{
		global $db;
		$QrySelectPlanet  = "SELECT `id`, `id_owner`, `b_hangar`, `b_hangar_id` ";
		$QrySelectPlanet .= "FROM ".PLANETS." ";
		$QrySelectPlanet .= "WHERE ";
		$QrySelectPlanet .= "`b_hangar_id` != '0' AND ";
		$QrySelectPlanet .= "`id_owner` = '".$userid."';";
		$AffectedPlanets  = $db->query ($QrySelectPlanet);
		$DeletedQueues    = 0;
		while($ActualPlanet = $db->fetch($AffectedPlanets) ) {
			$HangarQueue = explode (";", $ActualPlanet['b_hangar_id']);
			$bDelQueue   = false;
			if (count($HangarQueue)) {
				for ( $Queue = 0; $Queue < count($HangarQueue); $Queue++) {
					$InQueue = explode (",", $HangarQueue[$Queue]);
					if ($InQueue[1] > MAX_FLEET_OR_DEFS_PER_ROW) {
						$bDelQueue = true;
					}
				}
			}
			if ($bDelQueue) {
				$QryUpdatePlanet  = "UPDATE ".PLANETS." ";
				$QryUpdatePlanet .= "SET ";
				$QryUpdatePlanet .= "`b_hangar` = '0', ";
				$QryUpdatePlanet .= "`b_hangar_id` = '0' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '".$ActualPlanet['id']."';";
				$db->query ($QryUpdatePlanet);
				$DeletedQueues += 1;
			}
		}
	}
	
	public function ShowOptionsPage($CurrentUser)
	{
		global $game_config, $dpath, $lang, $db;

		$mode = request_var('mode', '');
		$exit = request_var('exit_modus', '');
		if ($_POST && $mode == "exit")
		{
			if ($exit == 'on' and $CurrentUser['urlaubs_until'] <= time())
			{
				$urlaubs_modus = "0";

				$db->query("UPDATE ".USERS." SET
				`urlaubs_modus` = '0',
				`urlaubs_until` = '0'
				WHERE `id` = '".$CurrentUser['id']."' LIMIT 1;");

				die(header("location:game.php?page=options"));
			}
			else
			{
				$urlaubs_modus = "1";
				die(header("location:game.php?page=options"));
			}
		}

		if ($_POST && $mode == "change")
		{
			if ($CurrentUser['authlevel'] > 0)
			{
				if (request_var('adm_pl_prot', '') == 'on')
					$db->query ("UPDATE ".PLANETS." SET `id_level` = '".$CurrentUser['authlevel']."' WHERE `id_owner` = '".$CurrentUser['id']."';");
				else
					$db->query ("UPDATE ".PLANETS." SET `id_level` = '0' WHERE `id_owner` = '".$CurrentUser['id']."';");
			}
			// < ------------------------------------------------------------------- EL SKIN ------------------------------------------------------------------- >
			$design 				= request_var('design', '');
			$noipcheck 				= request_var('noipcheck', '');
			$username 				= request_var('db_character', '');
			$db_email 				= request_var('db_email', '');
			$spio_anz 				= request_var('spio_anz', 5);
			$settings_tooltiptime 	= request_var('settings_tooltiptime', '');
			$settings_fleetactions 	= request_var('settings_fleetactions', '');
			$settings_planetmenu	= request_var('settings_planetmenu', '');
			$settings_esp 			= request_var('settings_esp', '');
			$settings_wri 			= request_var('settings_wri', '');
			$settings_bud 			= request_var('settings_bud', '');
			$settings_mis 			= request_var('settings_mis', '');
			$settings_rep 			= request_var('settings_rep', '');
			$urlaubs_modus 			= request_var('urlaubs_modus', '');
			$db_deaktjava 			= request_var('db_deaktjava', '');
			$SetSort  				= request_var('settings_sort' , '');
			$SetOrder 				= request_var('settings_order', '');
			$dpath    				= request_var('dpath', '');
			$db_password			= request_var('db_password', '');
			$newpass1				= request_var('newpass1', '');
			$newpass2				= request_var('newpass2', '');		
			$hof					= request_var('hof', '');	
			if ($design == 'on')
			{
				$design = "1";
			}
			else
			{
				$design = "0";
			}

			if ($hof == 'on')
			{
				$hof = "1";
			}
			else
			{
				$hof = "0";
			}
			// < ------------------------------------------------------------- COMPROBACION DE IP ------------------------------------------------------------- >
			if ($noipcheck == 'on')
			{
				$noipcheck = "1";
			}
			else
			{
				$noipcheck = "0";
			}
			// < ------------------------------------------------------------- NOMBRE DE USUARIO ------------------------------------------------------------- >
			if ($username == '')
			{
				$username = $CurrentUser['username'];
			}
			// < ------------------------------------------------------------- DIRECCION DE EMAIL ------------------------------------------------------------- >

			if ($db_email == '')
			{
				$db_email = $CurrentUser['email'];
			}
			// < ------------------------------------------------------------- CANTIDAD DE SONDAS ------------------------------------------------------------- >
			if (!is_numeric($spio_anz))
			{
				$spio_anz = "1";
			}
			// < ------------------------------------------------------------- TIEMPO TOOLTIP ------------------------------------------------------------- >
			if (!is_numeric($settings_tooltiptime))
			{
				$settings_tooltiptime = "1";
			}
			// < ------------------------------------------------------------- MENSAJES DE FLOTAS ------------------------------------------------------------- >
			if (!is_numeric($settings_fleetactions))
			{
				$settings_fleetactions = "1";
			}
			// < ------------------------------------------------------------ SONDAS DE ESPIONAJE ------------------------------------------------------------ >
			if ($settings_esp == 'on')
			{
				$settings_esp = "1";
			}
			else
			{
				$settings_esp = "0";
			}
			// < ------------------------------------------------------------ ESCRIBIR MENSAJE ------------------------------------------------------------ >
			if ($settings_wri == 'on')
			{
				$settings_wri = "1";
			}
			else
			{
				$settings_wri = "0";
			}
			// < ------------------------------------------------------------ AÑADIR A LISTA DE AMIGOS ------------------------------------------------------------ >
			if ($settings_bud == 'on')
			{
				$settings_bud = "1";
			}
			else
			{
				$settings_bud = "0";
			}
			// < ------------------------------------------------------------ ATAQUE CON MISILES ------------------------------------------------------------ >
			if ($settings_mis == 'on')
			{
				$settings_mis = "1";
			}
			else
			{
				$settings_mis = "0";
			}
			// < ------------------------------------------------------------ VER REPORTE ------------------------------------------------------------ >
			if ($settings_rep == 'on')
			{
				$settings_rep = "1";
			}
			else
			{
				$settings_rep = "0";
			}

			if ($settings_planetmenu == 'on')
			{
				$settings_planetmenu = "1";
			}
			else
			{
				$settings_planetmenu = "0";
			}
			// < ------------------------------------------------------------ MODO VACACIONES ------------------------------------------------------------ >
			if ($urlaubs_modus == 'on')
			{
				if($this->CheckIfIsBuilding($CurrentUser))
				{
					message($lang['op_cant_activate_vacation_mode'], "game.php?page=options",1);
				}

				$urlaubs_modus = "1";
				$time = time() + 86400;
				$db->query("UPDATE ".USERS." SET
				`urlaubs_modus` = '".$urlaubs_modus."',
				`urlaubs_until` = '".$time."'
				WHERE `id` = '".$CurrentUser["id"]."' LIMIT 1", "users");

				$query = $db->query("SELECT id FROM ".PLANETS." WHERE id_owner = '".$CurrentUser['id']."';");

				while($id = $db->fetch_array($query))
				{
					$db->query("UPDATE ".PLANETS." SET
					metal_perhour = '".$game_config['metal_basic_income']."',
					crystal_perhour = '".$game_config['crystal_basic_income']."',
					deuterium_perhour = '".$game_config['deuterium_basic_income']."',
					energy_used = '0',
					energy_max = '0',
					metal_mine_porcent = '0',
					crystal_mine_porcent = '0',
					deuterium_sintetizer_porcent = '0',
					solar_plant_porcent = '0',
					fusion_plant_porcent = '0',
					solar_satelit_porcent = '0'
					WHERE id = '".$id['id']."' AND `planet_type` = 1;");
				}
			}
			else
				$urlaubs_modus = "0";

			// < ------------------------------------------------------------ BORRAR CUENTA ------------------------------------------------------------ >
			if ($db_deaktjava == 'on')
			{
				$db_deaktjava = time();
			}
			else
			{
				$db_deaktjava = "0";
			}

			// < ---------------------------------------------------- ACTUALIZAR TODO LO SETEADO ANTES ---------------------------------------------------- >
			$db->query("UPDATE ".USERS." SET
			`email` = '".$db_email."',
			`dpath` = '".$db->sql_escape($dpath)."',
			`design` = '".$design."',
			`noipcheck` = '".$noipcheck."',
			`planet_sort` = '".$db->sql_escape($SetSort)."',
			`planet_sort_order` = '".$db->sql_escape($SetOrder)."',
			`spio_anz` = '".$db->sql_escape($spio_anz)."',
			`settings_tooltiptime` = '".$settings_tooltiptime."',
			`settings_fleetactions` = '".$settings_fleetactions."',
			`settings_planetmenu` = '".$settings_planetmenu."',
			`settings_esp` = '".$settings_esp."',
			`settings_wri` = '".$settings_wri."',
			`settings_bud` = '".$settings_bud."',
			`settings_mis` = '".$settings_mis."',
			`hof` = '".$hof."',
			`settings_rep` = '".$settings_rep."',
			`urlaubs_modus` = '".$urlaubs_modus."',
			`db_deaktjava` = '".$db_deaktjava."'
			WHERE `id` = '".$CurrentUser["id"]."' LIMIT 1;");
			// < ------------------------------------------------------------- CAMBIO DE CLAVE ------------------------------------------------------------- >
			if (md5($db_password) == $CurrentUser["password"] && $newpass1 == $newpass2 && !empty($newpass1))
			{
				$newpass = md5($newpass1);
				$db->query("UPDATE ".USERS." SET `password` = '".$newpass."' WHERE `id` = '".$CurrentUser['id']."' LIMIT 1;");
				setcookie(COOKIE_NAME, "", time()-100000, "/", "", 0);
				message($lang['op_password_changed'],"index.php",1);
			}
			// < ------------------------------------------------------- CAMBIO DE NOMBRE DE USUARIO ------------------------------------------------------ >
			if ($CurrentUser['username'] != $username)
			{
				if (!ctype_alnum($UserName))
					message($lang['op_user_name_no_alphanumeric'], "game.php?page=options", 1);

				$query = $db->fetch_array($db->query("SELECT id FROM ".USERS." WHERE username='".$db->sql_escape($username)."';"));
				if (!$query)
				{
					$db->query("UPDATE ".USERS." SET username='".$db->sql_escape($username)."' WHERE id='".$CurrentUser['id']."' LIMIT 1;");
					setcookie(COOKIE_NAME, "", time()-100000, "/", "", 0);
					message($lang['op_username_changed'], "index.php", 1);
				}
			}
			message($lang['op_options_changed'], "game.php?page=options", 1);
		}
		else
		{
			$parse			= $lang;
			$parse['dpath'] = $dpath;

			if($CurrentUser['urlaubs_modus'])
			{
				$parse['opt_modev_data'] 	= ($CurrentUser['urlaubs_modus'] == 1)?" checked='checked'/":'';
				$parse['opt_modev_exit'] 	= ($CurrentUser['urlaubs_modus'] == 0)?" checked='1'/":'';
				$parse['vacation_until'] 	= date("d.m.Y G:i:s",$CurrentUser['urlaubs_until']);

				display(parsetemplate(gettemplate('options/options_body_vmode'), $parse), false);
			}
			else
			{
				$parse['opt_lst_ord_data']   = "<option value =\"0\"". (($CurrentUser['planet_sort'] == 0) ? " selected": "") .">".$lang['op_sort_normal']."</option>";
				$parse['opt_lst_ord_data']  .= "<option value =\"1\"". (($CurrentUser['planet_sort'] == 1) ? " selected": "") .">".$lang['op_sort_koords']."</option>";
				$parse['opt_lst_ord_data']  .= "<option value =\"2\"". (($CurrentUser['planet_sort'] == 2) ? " selected": "") .">".$lang['op_sort_abc']."</option>";
				$parse['opt_lst_cla_data']   = "<option value =\"0\"". (($CurrentUser['planet_sort_order'] == 0) ? " selected": "") .">".$lang['op_sort_up']."</option>";
				$parse['opt_lst_cla_data']  .= "<option value =\"1\"". (($CurrentUser['planet_sort_order'] == 1) ? " selected": "") .">".$lang['op_sort_down']."</option>";

				if ($CurrentUser['authlevel'] > 0)
				{
					$IsProtOn = $db->fetch_array($db->query("SELECT `id_level` FROM ".PLANETS." WHERE `id_owner` = '".$CurrentUser['id']."' LIMIT 1;"));
					$parse['adm_pl_prot_data']   = ($IsProtOn['id_level'] > 0) ? " checked='checked'/":'';
					$parse['opt_adm_frame']      = parsetemplate(gettemplate('options/options_admadd'), $parse);
				}
				$parse['opt_usern_data'] 	= $CurrentUser['username'];
				$parse['opt_mail1_data'] 	= $CurrentUser['email'];
				$parse['opt_mail2_data'] 	= $CurrentUser['email_2'];
				$parse['opt_dpath_data'] 	= $CurrentUser['dpath'];
				$parse['opt_probe_data'] 	= $CurrentUser['spio_anz'];
				$parse['opt_toolt_data'] 	= $CurrentUser['settings_tooltiptime'];
				$parse['opt_fleet_data'] 	= $CurrentUser['settings_fleetactions'];
				$parse['opt_sskin_data'] 	= ($CurrentUser['design'] == 1) ? " checked='checked'":'';
				$parse['opt_noipc_data'] 	= ($CurrentUser['noipcheck'] == 1) ? " checked='checked'":'';
				$parse['opt_allyl_data'] 	= ($CurrentUser['settings_planetmenu'] == 1) ? " checked='checked'/":'';
				$parse['opt_delac_data'] 	= ($CurrentUser['db_deaktjava'] != 0) ? " checked='checked'/":'';
				$parse['user_settings_rep'] = ($CurrentUser['settings_rep'] == 1) ? " checked='checked'/":'';
				$parse['user_settings_esp'] = ($CurrentUser['settings_esp'] == 1) ? " checked='checked'/":'';
				$parse['user_settings_wri'] = ($CurrentUser['settings_wri'] == 1) ? " checked='checked'/":'';
				$parse['user_settings_mis'] = ($CurrentUser['settings_mis'] == 1) ? " checked='checked'/":'';
				$parse['user_settings_bud'] = ($CurrentUser['settings_bud'] == 1) ? " checked='checked'/":'';
				$parse['opt_hof'] 			= ($CurrentUser['hof'] == 1) ? " checked='checked'/":'';
				$parse['db_deaktjava']		= ($CurrentUser['db_deaktjava']  > 0) ? " checked='checked'/":'';

				display(parsetemplate(gettemplate('options/options_body'), $parse));
			}
		}
	}
}
?>