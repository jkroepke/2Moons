<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.8.0 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");


function ShowCreatorPage()
{
	global $LNG, $USER;

	$template	= new template();

	switch ($_GET['mode'])
	{
		case 'user':
			$LNG->includeData(array('PUBLIC'));
			if ($_POST)
			{
				$UserName 	= HTTP::_GP('name', '', UTF8_SUPPORT);
				$UserPass 	= HTTP::_GP('password', '');
				$UserPass2 	= HTTP::_GP('password2', '');
				$UserMail 	= HTTP::_GP('email', '');
				$UserMail2	= HTTP::_GP('email2', '');
				$UserAuth 	= HTTP::_GP('authlevel', 0);
				$Galaxy 	= HTTP::_GP('galaxy', 0);
				$System 	= HTTP::_GP('system', 0);
				$Planet 	= HTTP::_GP('planet', 0);
				$Language 	= HTTP::_GP('lang', '');
					
				$ExistsUser 	= $GLOBALS['DATABASE']->getFirstCell("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE universe = ".Universe::getEmulated()." AND username = '".$GLOBALS['DATABASE']->sql_escape($UserName)."') + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE universe = ".Universe::getEmulated()." AND username = '".$GLOBALS['DATABASE']->sql_escape($UserName)."')");
				$ExistsMails	= $GLOBALS['DATABASE']->getFirstCell("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE universe = ".Universe::getEmulated()." AND (email = '".$GLOBALS['DATABASE']->sql_escape($UserMail)."' OR email_2 = '".$GLOBALS['DATABASE']->sql_escape($UserMail)."')) + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE universe = ".Universe::getEmulated()." AND email = '".$GLOBALS['DATABASE']->sql_escape($UserMail)."')");

				$errors	= "";

				$config	= Config::get(Universe::getEmulated());

				if (!PlayerUtil::isMailValid($UserMail))
					$errors .= $LNG['invalid_mail_adress'];
					
				if (empty($UserName))
					$errors .= $LNG['empty_user_field'];
										
				if (strlen($UserPass) < 6)
					$errors .= $LNG['password_lenght_error'];
					
				if ($UserPass != $UserPass2)
					$errors .= $LNG['different_passwords'];				
					
				if ($UserMail != $UserMail2)
					$errors .= $LNG['different_mails'];
					
				if (!PlayerUtil::isNameValid($UserName))
					$errors .= $LNG['user_field_specialchar'];				
										
				if ($ExistsUser != 0)
					$errors .= $LNG['user_already_exists'];

				if ($ExistsMails != 0)
					$errors .= $LNG['mail_already_exists'];
				
				if (!PlayerUtil::isPositionFree(Universe::getEmulated(), $Galaxy, $System, $Planet)) {
					$errors .= $LNG['planet_already_exists'];
				}	
				
				if ($Galaxy > $config->max_galaxy || $System > $config->max_system || $Planet > $config->max_planets) {
					$errors .= $LNG['po_complete_all2'];
				}

				if (!empty($errors)) {
					$template->message($errors, '?page=create&mode=user', 10, true);
					exit;
				}

				$Language	= array_key_exists($Language, $LNG->getAllowedLangs(false)) ? $Language : $config->lang;

				PlayerUtil::createPlayer(Universe::getEmulated(), $UserName,
					PlayerUtil::cryptPassword($UserPass), $UserMail, $Language, $Galaxy, $System, $Planet,
					$LNG['fcm_planet'], $UserAuth);
				
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
				'lang_reg'				=> $LNG['lang_reg'],		
				'new_title'				=> $LNG['new_title'],
				'Selector'				=> array('auth' => $AUTH, 'lang' => $LNG->getAllowedLangs(false)),  
			));
			$template->show('CreatePageUser.tpl');
		break;
		case 'moon':
			if ($_POST)
			{
				$PlanetID  	= HTTP::_GP('add_moon', 0);
				$MoonName  	= HTTP::_GP('name', '', UTF8_SUPPORT);
				$Diameter	= HTTP::_GP('diameter', 0);
			
				$MoonPlanet	= $GLOBALS['DATABASE']->getFirstRow("SELECT temp_max, temp_min, id_luna, galaxy, system, planet, planet_type, destruyed, id_owner FROM ".PLANETS." WHERE id = '".$PlanetID."' AND universe = '".Universe::getEmulated()."' AND planet_type = '1' AND destruyed = '0';");

				if (!isset($MoonPlanet)) {
					$template->message($LNG['mo_planet_doesnt_exist'], '?page=create&mode=moon', 3, true);
					exit;
				}

				$moonId	= PlayerUtil::createMoon(Universe::getEmulated(), $MoonPlanet['galaxy'], $MoonPlanet['system'],
					$MoonPlanet['planet'], $MoonPlanet['id_owner'], 20,
					(($_POST['diameter_check'] == 'on') ? NULL : $Diameter), $MoonName);



				if($moonId !== false)
				{
					$template->message($LNG['mo_moon_added'], '?page=create&mode=moon', 3, true);
				}
				else
				{
					$template->message($LNG['mo_moon_unavaible'], '?page=create&mode=moon', 3, true);
				}
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

				$config			= Config::get(Universe::getEmulated());

				if ($Galaxy > $config->max_galaxy || $System > $config->max_system || $Planet > $config->max_planets) {
					$template->message($LNG['po_complete_all2'], '?page=create&mode=planet', 3, true);
					exit;					
				}
				
				$ISUser		= $GLOBALS['DATABASE']->getFirstRow("SELECT id, authlevel FROM ".USERS." WHERE id = '".$id."' AND universe = '".Universe::getEmulated()."';");
				if(!PlayerUtil::checkPosition(Universe::getEmulated(), $Galaxy, $System, $Planet) || !isset($ISUser)) {
					$template->message($LNG['po_complete_all'], '?page=create&mode=planet', 3, true);
					exit;
				}

				$planetId	= PlayerUtil::createPlanet($Galaxy, $System, $Planet, Universe::getEmulated(), $id, NULL, false, $ISUser['authlevel']);
						
				$SQL  = "UPDATE ".PLANETS." SET ";
				
				if ($_POST['diameter_check'] != 'on' || $field_max > 0)
					$SQL .= "field_max = '".$field_max."' ";
			
				if (!empty($name))
					$SQL .= ", name = '".$GLOBALS['DATABASE']->sql_escape($name)."' ";

				$SQL .= "WHERE ";
				$SQL .= "id = '".$planetId."'";
				$GLOBALS['DATABASE']->query($SQL);

				$template->message($LNG['po_complete_succes'], '?page=create&mode=planet', 3, true);
				exit;
			}

			$template->assign_vars(array(
				'admin_auth'			=> $USER['authlevel'],
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