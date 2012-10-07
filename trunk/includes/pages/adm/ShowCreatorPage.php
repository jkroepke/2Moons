<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;


function ShowCreatorPage()
{
	global $LNG, $USER, $UNI, $LANG, $CONF;

	$template	= new template();

	
	switch ($_GET['mode'])
	{
		case 'user':
			$LANG->includeLang(array('PUBLIC'));
			if ($_POST)
			{
				$UserName 	= HTTP::_GP('name', '', UTF8_SUPPORT);
				$UserPass 	= HTTP::_GP('password', '');
				$UserPass2 	= HTTP::_GP('password2', '');
				$UserMail 	= HTTP::_GP('email', '');
				$UserMail2	= HTTP::_GP('email2', '');
				$UserLang 	= HTTP::_GP('lang', '');
				$UserAuth 	= HTTP::_GP('authlevel', 0);
				$Galaxy 	= HTTP::_GP('galaxy', 0);
				$System 	= HTTP::_GP('system', 0);
				$Planet 	= HTTP::_GP('planet', 0);
					
				$ExistsUser 	= $GLOBALS['DATABASE']->countquery("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE universe = ".$_SESSION['adminuni']." AND username = '".$GLOBALS['DATABASE']->sql_escape($UserName)."') + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE universe = ".$_SESSION['adminuni']." AND username = '".$GLOBALS['DATABASE']->sql_escape($UserName)."')");
				$ExistsMails	= $GLOBALS['DATABASE']->countquery("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE universe = ".$_SESSION['adminuni']." AND (email = '".$GLOBALS['DATABASE']->sql_escape($UserMail)."' OR email_2 = '".$GLOBALS['DATABASE']->sql_escape($UserMail)."')) + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE universe = ".$_SESSION['adminuni']." AND email = '".$GLOBALS['DATABASE']->sql_escape($UserMail)."')");
								
				if (!ValidateAddress($UserMail)) 
					$errors .= $LNG['invalid_mail_adress'];
					
				if (empty($UserName))
					$errors .= $LNG['empty_user_field'];
										
				if (strlen($UserPass) < 6)
					$errors .= $LNG['password_lenght_error'];
					
				if ($UserPass != $UserPass2)
					$errors .= $LNG['different_passwords'];				
					
				if ($UserMail != $UserMail2)
					$errors .= $LNG['different_mails'];
					
				if (!CheckName($UserName))
					$errors .= $LNG['user_field_specialchar'];				
										
				if ($ExistsUser != 0)
					$errors .= $LNG['user_already_exists'];

				if ($ExistsMails != 0)
					$errors .= $LNG['mail_already_exists'];
				
				if (CheckPlanetIfExist($Galaxy, $System, $Planet, $_SESSION['adminuni'])) {
					$errors .= $LNG['planet_already_exists'];
				}	
				
				if ($Galaxy > $CONF['max_galaxy'] || $System > $CONF['max_system'] || $Planet > $CONF['max_planets']) {
					$errors .= $LNG['po_complete_all2'];
				}

				if (!empty($errors)) {
					$template->message($errors, '?page=create&mode=user', 10, true);
					exit;
				}
				
				$SQL = "INSERT INTO ".USERS." SET
				username		= '".$GLOBALS['DATABASE']->sql_escape($UserName). "',
				password		= '".cryptPassword($UserPass)."',
				email			= '".$GLOBALS['DATABASE']->sql_escape($UserMail)."',
				email_2			= '".$GLOBALS['DATABASE']->sql_escape($UserMail)."',
				lang			= '".$GLOBALS['DATABASE']->sql_escape($UserLang)."',
				authlevel		= ".$UserAuth.",
				ip_at_reg		= '".$_SERVER['REMOTE_ADDR']."',
				id_planet		= 0,
				universe		= ".$_SESSION['adminuni'].",
				onlinetime		= ".TIMESTAMP.",
				register_time	= ".TIMESTAMP.",
				dpath			= '".DEFAULT_THEME."',
				timezone		= '".$CONF['timezone']."',
				uctime			= 0;";
				$GLOBALS['DATABASE']->query($SQL);

				$UserID = $GLOBALS['DATABASE']->GetInsertID();
				
				require_once(ROOT_PATH.'includes/functions/CreateOnePlanetRecord.php');
				$PlanerID	= CreateOnePlanetRecord($Galaxy, $System, $Planet, $_SESSION['adminuni'], $UserID, $LNG['fcm_planet'], true, $UserAuth);
								
				$SQL = "UPDATE ".USERS." SET 
				id_planet	= ".$PlanerID.",
				galaxy		= ".$Galaxy.",
				system		= ".$System.",
				planet		= ".$Planet."
				WHERE
				id			= ".$UserID.";
				INSERT INTO ".STATPOINTS." SET 
				id_owner	= ".$UserID.",
				universe	= ".$_SESSION['adminuni'].",
				stat_type	= 1,
				tech_rank	= ".($CONF['users_amount'] + 1).",
				build_rank	= ".($CONF['users_amount'] + 1).",
				defs_rank	= ".($CONF['users_amount'] + 1).",
				fleet_rank	= ".($CONF['users_amount'] + 1).",
				total_rank	= ".($CONF['users_amount'] + 1).";";
				$GLOBALS['DATABASE']->multi_query($SQL);
				
				update_config(array('users_amount' => $CONF['users_amount'] + 1));
				
				$template->message($LNG['new_user_success'], '?page=create&mode=user', 5, true);
				exit;
			}

			$AUTH			= array();
			$AUTH[AUTH_USR]	= $LNG['user_level'][AUTH_USR];
			
			if($USER['authlevel'] >= AUTH_OPS)
				$AUTH[AUTH_OPS]	= $LNG['user_level'][AUTH_OPS];
				
			if($USER['authlevel'] >= AUTH_MOD)
				$AUTH[AUTH_MOD]	= $LNG['user_level'][AUTH_MOD];
				
			if($USER['authlevel'] >= AUTH_ADM)
				$AUTH[AUTH_ADM]	= $LNG['user_level'][AUTH_ADM];
				
			
			$template->assign_vars(array(	
				'admin_auth'			=> $USER['authlevel'],
				'new_add_user'			=> $LNG['new_add_user'],
				'new_creator_refresh'	=> $LNG['new_creator_refresh'],
				'new_creator_go_back'	=> $LNG['new_creator_go_back'],
				'universe'				=> $LNG['mu_universe'],
				'user_reg'				=> $LNG['user_reg'],
				'pass_reg'				=> $LNG['pass_reg'],
				'pass2_reg'				=> $LNG['pass2_reg'],
				'email_reg'				=> $LNG['email_reg'],
				'email2_reg'			=> $LNG['email2_reg'],
				'new_coord'				=> $LNG['new_coord'],
				'new_range'				=> $LNG['new_range'],
				'lang'					=> $LNG['op_lang'],		
				'new_title'				=> $LNG['new_title'],
				'Selector'				=> array('auth' => $AUTH, 'lang' => $LANG->getAllowedLangs(false)),  
			));
			$template->show('CreatePageUser.tpl');
		break;
		case 'moon':
			if ($_POST)
			{
				$PlanetID  	= HTTP::_GP('add_moon', 0);
				$MoonName  	= HTTP::_GP('name', '', UTF8_SUPPORT);
				$Diameter	= HTTP::_GP('diameter', 0);
				$FieldMax	= HTTP::_GP('field_max', 0);
			
				$MoonPlanet	= $GLOBALS['DATABASE']->uniquequery("SELECT temp_max, temp_min, id_luna, galaxy, system, planet, planet_type, destruyed, id_owner FROM ".PLANETS." WHERE id = '".$PlanetID."' AND universe = '".$_SESSION['adminuni']."' AND planet_type = '1' AND destruyed = '0';");

				if (!isset($MoonPlanet)) {
					$template->message($LNG['mo_planet_doesnt_exist'], '?page=create&mode=moon', 3, true);
					exit;
				}
			
				require_once(ROOT_PATH.'includes/functions/CreateOneMoonRecord.php');
				
				if(empty($MoonName))
				{
					$MoonName = $LNG['type_planet'][3];
				}
				
				if(CreateOneMoonRecord($MoonPlanet['galaxy'], $MoonPlanet['system'], $MoonPlanet['planet'], $_SESSION['adminuni'], $MoonPlanet['id_owner'], $MoonName, 20, TIMESTAMP, (($_POST['diameter_check'] == 'on') ? 0: $Diameter)) !== false)
					$template->message($LNG['mo_moon_added'], '?page=create&mode=moon', 3, true);
				else
					$template->message($LNG['mo_moon_unavaible'], '?page=create&mode=moon', 3, true);
				
				exit;
			}
			
			$template->assign_vars(array(
				'admin_auth'			=> $USER['authlevel'],	
				'universum'				=> $LNG['mu_universe'],
				'po_add_moon'			=> $LNG['po_add_moon'],
				'input_id_planet'		=> $LNG['input_id_planet'],
				'mo_moon_name'			=> $LNG['mo_moon_name'],
				'mo_diameter'			=> $LNG['mo_diameter'],
				'mo_temperature'		=> $LNG['mo_temperature'],
				'mo_fields_avaibles'	=> $LNG['mo_fields_avaibles'],
				'button_add'			=> $LNG['button_add'],
				'new_creator_refresh'	=> $LNG['new_creator_refresh'],
				'mo_moon'				=> $LNG['fcm_moon'],
				'new_creator_go_back'	=> $LNG['new_creator_go_back'],
			));
			
			
			$template->show('CreatePageMoon.tpl');
		break;
		case 'planet':
			if ($_POST) 
			{
				$id          = HTTP::_GP('id', 0);
				$Galaxy      = HTTP::_GP('galaxy', 0);
				$System      = HTTP::_GP('system', 0);
				$Planet      = HTTP::_GP('planet', 0);
				$name        = HTTP::_GP('name', '', UTF8_SUPPORT);
				$field_max   = HTTP::_GP('field_max', 0);
				
				if($Galaxy > $CONF['max_galaxy'] || $System > $CONF['max_system'] || $Planet > $CONF['max_planets']) {
					$template->message($LNG['po_complete_all2'], '?page=create&mode=planet', 3, true);
					exit;					
				}
				
				$ISUser		= $GLOBALS['DATABASE']->uniquequery("SELECT id, authlevel FROM ".USERS." WHERE id = '".$id."' AND universe = '".$_SESSION['adminuni']."';");
				if(CheckPlanetIfExist($Galaxy, $System, $Planet, $_SESSION['adminuni']) || !isset($ISUser)) {
					$template->message($LNG['po_complete_all'], '?page=create&mode=planet', 3, true);
					exit;
				}
				
				require_once(ROOT_PATH.'includes/functions/CreateOnePlanetRecord.php');
				CreateOnePlanetRecord($Galaxy, $System, $Planet, $_SESSION['adminuni'], $id, '', '', false) ; 
						
				$SQL  = "UPDATE ".PLANETS." SET ";
				
				if ($_POST['diameter_check'] != 'on' || $field_max > 0)
					$SQL .= "field_max = '".$field_max."' ";
			
				if (!empty($name))
					$SQL .= ", name = '".$GLOBALS['DATABASE']->sql_escape($name)."' ";

				$SQL .= "WHERE ";
				$SQL .= "universe = '". $_SESSION['adminuni'] ."' AND ";
				$SQL .= "galaxy = '". $Galaxy ."' AND ";
				$SQL .= "system = '". $System ."' AND ";
				$SQL .= "planet = '". $Planet ."' AND ";
				$SQL .= "planet_type = '1'";
				$GLOBALS['DATABASE']->query($SQL);

				$template->message($LNG['po_complete_succes'], '?page=create&mode=planet', 3, true);
				exit;
			}
			
			$Query	= $GLOBALS['DATABASE']->query("SELECT uni, game_name FROM ".CONFIG." ORDER BY uni ASC;");
			while($Unis	= $GLOBALS['DATABASE']->fetch_array($Query)) {
				$AvailableUnis[$Unis['uni']]	= $Unis;
			}

			$template->assign_vars(array(	
				'AvailableUnis'			=> $AvailableUnis,
				'admin_auth'			=> $USER['authlevel'],	
				'universum'				=> $LNG['mu_universe'],
				'po_add_planet'			=> $LNG['po_add_planet'],
				'po_galaxy'				=> $LNG['po_galaxy'],
				'po_system'				=> $LNG['po_system'],
				'po_planet'				=> $LNG['po_planet'],
				'input_id_user'			=> $LNG['input_id_user'],
				'new_creator_coor'		=> $LNG['new_creator_coor'],
				'po_name_planet'		=> $LNG['po_name_planet'],
				'po_fields_max'			=> $LNG['po_fields_max'],
				'button_add'			=> $LNG['button_add'],
				'po_colony'				=> $LNG['fcp_colony'],
				'new_creator_refresh'	=> $LNG['new_creator_refresh'],
				'new_creator_go_back'	=> $LNG['new_creator_go_back'],
			));
			
			$template->show('CreatePagePlanet.tpl');
		break;
		default:
			$template->assign_vars(array(	
				'new_creator_title_u'	=> $LNG['new_creator_title_u'],
				'new_creator_title_p'	=> $LNG['new_creator_title_p'],
				'new_creator_title_l'	=> $LNG['new_creator_title_l'],
				'new_creator_title'		=> $LNG['new_creator_title'],
			));
			
			$template->show('CreatePage.tpl');
		break;	
	}
}
?>