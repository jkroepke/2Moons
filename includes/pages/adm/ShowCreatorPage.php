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
 * @version 1.4 (2011-07-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;


function ShowCreatorPage()
{
	global $LNG, $db, $USER, $UNI, $LANG;

	$template	= new template();

	
	switch ($_GET['mode'])
	{
		case 'user':
			$LANG->includeLang(array('PUBLIC'));
			if ($_POST)
			{
				$UserName 	= request_var('name', '', UTF8_SUPPORT);
				$UserPass 	= request_var('password', '');
				$UserPass2 	= request_var('password2', '');
				$UserMail 	= request_var('email', '');
				$UserMail2	= request_var('email2', '');
				$UserLang 	= request_var('lang', '');
				$UserAuth 	= request_var('authlevel', 0);
				$Galaxy 	= request_var('galaxy', 0);
				$System 	= request_var('system', 0);
				$Planet 	= request_var('planet', 0);
					
				$Exist['userv'] = $db->uniquequery("SELECT username, email FROM ".USERS." WHERE username = '".$db->sql_escape($UserName)."' OR email = '".$db->sql_escape($UserEmail)."';");
				$Exist['vaild'] = $db->uniquequery("SELECT username, email FROM ".USERS_VALID." WHERE username = '".$db->sql_escape($UserName)."' OR email = '".$db->sql_escape($UserEmail)."';");
								
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
					$errors .= (UTF8_SUPPORT) ? $LNG['user_field_no_space'] : $LNG['user_field_no_alphanumeric'];				
										
				if ((isset($Exist['userv']['username']) || isset($Exist['vaild']['username']) && ($UserName == $Exist['userv']['username'] || $UserName == $Exist['vaild']['username'])))
					$errors .= $LNG['user_already_exists'];

				if ((isset($Exist['userv']['email']) || isset($Exist['vaild']['email'])) && ($UserEmail == $Exist['userv']['email'] || $UserEmail == $Exist['vaild']['email']))
					$errors .= $LNG['mail_already_exists'];
				
				if (CheckPlanetIfExist($Galaxy, $System, $Position, $_SESSION['adminuni'])) {
					$errors .= $LNG['planet_already_exists'];
				}	

				if (!empty($errors)) {
					$template->message($errors, '?page=create&mode=user', 3, true);
					exit;
				}
				
				$SQL = "INSERT INTO ".USERS." SET ";
				$SQL .= "`username` = '".$db->sql_escape($UserName). "', ";
				$SQL .= "`email` = '".$db->sql_escape($UserMail)."', ";
				$SQL .= "`email_2` = '".$db->sql_escape($UserMail)."', ";
				$SQL .= "`lang` = '".$db->sql_escape($UserLang)."', ";
				$SQL .= "`authlevel` = '".$UserAuth."', ";
				$SQL .= "`ip_at_reg` = '".$_SERVER['REMOTE_ADDR']."', ";
				$SQL .= "`id_planet` = '0', ";
				$SQL .= "`universe` = '".$_SESSION['adminuni']."',";
				$SQL .= "`onlinetime` = '".TIMESTAMP."', ";
				$SQL .= "`register_time` = '".TIMESTAMP. "', ";
				$SQL .= "`password` = '".md5($UserPass)."', ";
				$SQL .= "`dpath` = '".DEFAULT_THEME."', ";
				$SQL .= "`timezone` = '".$CONF['timezone'];."', ";
				$SQL .= "`uctime`= '0';";
				$db->query($SQL);
				$db->query("UPDATE ".CONFIG." SET `users_amount` = users_amount + '1' WHERE `uni` = '".$_SESSION['adminuni']."';");

				$ID_USER 	= $db->uniquequery("SELECT `id` FROM ".USERS." WHERE `username` = '".$db->sql_escape($UserName)."';");
				
				require_once(ROOT_PATH.'includes/functions/CreateOnePlanetRecord.php');
				CreateOnePlanetRecord($Galaxy, $System, $Planet, $_SESSION['adminuni'] ,$ID_USER['id'], $UserPlanet, true, $UserAuth);
				$ID_PLANET 	= $db->uniquequery("SELECT `id` FROM ".PLANETS." WHERE `id_owner` = '".$ID_USER['id']."';");
								
				$SQL = "UPDATE ".USERS." SET ";
				$SQL .= "`id_planet` = '".$ID_PLANET['id']."', ";
				$SQL .= "`universe` = '".$_SESSION['adminuni']."', ";
				$SQL .= "`galaxy` = '".$Galaxy."', ";
				$SQL .= "`system` = '".$System."', ";
				$SQL .= "`planet` = '".$Planet."' ";
				$SQL .= "WHERE ";
				$SQL .= "`id` = '".$ID_USER['id']."' ";
				$SQL .= "LIMIT 1;";
				$db->query($SQL);
				
				$template->message($LNG['new_user_success'], '?page=create&mode=user', 3, true);
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
			$template->show('adm/CreatePageUser.tpl');
		break;
		case 'moon':
			if ($_POST)
			{
				$PlanetID  	= request_var('add_moon', 0);
				$MoonName  	= request_var('name', '', UTF8_SUPPORT);
				$Diameter	= request_var('diameter', 0);
				$FieldMax	= request_var('field_max', 0);
			
				$MoonPlanet	= $db->uniquequery("SELECT `temp_max`, `temp_min`, `id_luna`, `galaxy`, `system`, `planet`, `planet_type`, `destruyed`, `id_owner` FROM ".PLANETS." WHERE `id` = '".$PlanetID."' AND `universe` = '".$_SESSION['adminuni']."' AND `planet_type` = '1' AND `destruyed` = '0';");

				if (!isset($MoonPlanet)) {
					$template->message($LNG['mo_planet_doesnt_exist'], '?page=create&mode=moon', 3, true);
					exit;
				}
			
				require_once(ROOT_PATH.'includes/functions/CreateOneMoonRecord.php');
				
				if(CreateOneMoonRecord($MoonPlanet['galaxy'], $MoonPlanet['system'], $MoonPlanet['planet'], $_SESSION['adminuni'], $MoonPlanet['id_owner'], 0, $MoonName, 20, (($_POST['diameter_check'] == 'on') ? 0: $Diameter)) !== false)
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
			
			
			$template->show('adm/CreatePageMoon.tpl');
		break;
		case 'planet':
			if ($_POST) 
			{
				$id          = request_var('id', 0);
				$Galaxy      = request_var('galaxy', 0);
				$System      = request_var('system', 0);
				$Planet      = request_var('planet', 0);
				$name        = request_var('name', '', UTF8_SUPPORT);
				$field_max   = request_var('field_max', 0);
				
				
				$ISUser		= $db->uniquequery("SELECT id, authlevel FROM ".USERS." WHERE `id` = '".$id."' AND `universe` = '".$_SESSION['adminuni']."';");
				if(CheckPlanetIfExist($Galaxy, $System, $Planet, $_SESSION['adminuni']) || !isset($ISUser)) {
					$template->message($LNG['po_complete_all'], '?page=create&mode=planet', 3, true);
					exit;
				}
				
				require_once(ROOT_PATH.'includes/functions/CreateOnePlanetRecord.php');
				CreateOnePlanetRecord($Galaxy, $System, $Planet, $_SESSION['adminuni'], $id, '', '', false) ; 
						
				$SQL  = "UPDATE ".PLANETS." SET ";
				
				if ($_POST['diameter_check'] != 'on' || $field_max > 0)
					$SQL .= "`field_max` = '".$field_max."' ";
			
				if (!empty($name))
					$SQL .= ", `name` = '".$db->sql_escape($name)."' ";

				$SQL .= "WHERE ";
				$SQL .= "`universe` = '". $_SESSION['adminuni'] ."' AND ";
				$SQL .= "`galaxy` = '". $Galaxy ."' AND ";
				$SQL .= "`system` = '". $System ."' AND ";
				$SQL .= "`planet` = '". $Planet ."' AND ";
				$SQL .= "`planet_type` = '1'";
				$db->query($SQL);

				$template->message($LNG['po_complete_succes'], '?page=create&mode=planet', 3, true);
				exit;
			}
			
			$Query	= $db->query("SELECT `uni`, `game_name` FROM ".CONFIG." ORDER BY `uni` ASC;");
			while($Unis	= $db->fetch_array($Query)) {
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
			
			$template->show('adm/CreatePagePlanet.tpl');
		break;
		default:
			$template->assign_vars(array(	
				'new_creator_title_u'	=> $LNG['new_creator_title_u'],
				'new_creator_title_p'	=> $LNG['new_creator_title_p'],
				'new_creator_title_l'	=> $LNG['new_creator_title_l'],
				'new_creator_title'		=> $LNG['new_creator_title'],
			));
			
			$template->show('adm/CreatePage.tpl');
		break;	
	}
}
?>