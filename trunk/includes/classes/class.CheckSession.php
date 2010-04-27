<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

class CheckSession
{
	private function CheckCookies ($IsUserChecked)
	{
		global $game_config, $lang, $db;

		$UserRow = array();

		include(ROOT_PATH . 'config.' . PHP_EXT);

		if (isset($_COOKIE[$game_config['COOKIE_NAME']]))
		{
			$TheCookie  = explode("/%/", $_COOKIE[$game_config['COOKIE_NAME']]);
			$UserResult = $db->query("SELECT * FROM ".USERS." WHERE `username` = '".$TheCookie[1]."';");

			if ($db->num_rows($UserResult) != 1)
			{
				message($lang['ccs_multiple_users'], ROOT_PATH, 5, false, false);
			}

			$UserRow = $db->fetch_array($UserResult);

			if ($UserRow["id"] != $TheCookie[0])
			{
				message($lang['ccs_other_user'], ROOT_PATH, 5,  false, false);
			}

			if (md5($UserRow["password"] . "--" . $dbsettings["secretword"]) !== $TheCookie[2])
			{
				message($lang['css_different_password'], ROOT_PATH, 5,  false, false);
			}

			$NextCookie = implode("/%/", $TheCookie);

			if ($TheCookie[3] == 1)
			{
				$ExpireTime = time() + 31536000;
			}
			else
			{
				$ExpireTime = 0;
			}

			if ($IsUserChecked == false)
			{
				if(!headers_sent()) 
					setcookie($game_config['COOKIE_NAME'], $NextCookie, $ExpireTime, "/", "", 0);
				
				$QryUpdateUser  = "UPDATE ".USERS." SET ";
				$QryUpdateUser .= "`onlinetime` = '". time() ."', ";
				$QryUpdateUser .= "`current_page` = '". addslashes($_SERVER['REQUEST_URI']) ."', ";
				$QryUpdateUser .= "`user_lastip` = '". $_SERVER['REMOTE_ADDR'] ."', ";
				$QryUpdateUser .= "`user_agent` = '". addslashes($_SERVER['HTTP_USER_AGENT']) ."' ";
				$QryUpdateUser .= "WHERE ";
				$QryUpdateUser .= "`id` = '". $TheCookie[0] ."' LIMIT 1;";
				$db->query($QryUpdateUser);
				$IsUserChecked = true;
			}
			else
			{
				$QryUpdateUser  = "UPDATE ".USERS." SET ";
				$QryUpdateUser .= "`onlinetime` = '". time() ."', ";
				$QryUpdateUser .= "`current_page` = '". $_SERVER['REQUEST_URI'] ."', ";
				$QryUpdateUser .= "`user_lastip` = '". $_SERVER['REMOTE_ADDR'] ."', ";
				$QryUpdateUser .= "`user_agent` = '". $_SERVER['HTTP_USER_AGENT'] ."' ";
				$QryUpdateUser .= "WHERE ";
				$QryUpdateUser .= "`id` = '". $TheCookie[0] ."' LIMIT 1;";
				$db->query($QryUpdateUser);
				$IsUserChecked = true;
			}
		}

		unset($dbsettings);

		$Return['state']  = $IsUserChecked;
		$Return['record'] = $UserRow;

		return $Return;
	}

	public function CheckUser($IsUserChecked)
	{
		global $user, $lang;

		$Result        = $this->CheckCookies($IsUserChecked);
		$IsUserChecked = $Result['state'];

		if ($Result['record'] != false)
		{
			$user = $Result['record'];

			if ($user['bana'] == 1)
			{
				require_once(ROOT_PATH . 'includes/classes/class.template.'.PHP_EXT);
				$template	= new template();
				$template->page_header();	
				$template->page_footer();
				$template->message("<font size=\"6px\">".$lang['css_account_banned_message']."</font><br><br>".sprintf($lang['css_account_banned_expire'],date("d. M y H:i", $user['banaday']))."<br><br>".$lang['css_goto_homeside'], false, 0, true);
				exit;
			}

			$RetValue['record'] = $user;
			$RetValue['state']  = $IsUserChecked;
		}
		else
		{
			$RetValue['record'] = array();
			$RetValue['state']  = false;
			header("location:".ROOT_PATH);
		}

		return $RetValue;
	}
}
?>