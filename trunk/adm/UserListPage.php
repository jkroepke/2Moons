<?php

##############################################################################
# *                                                                                                                                                         #
# * RN FRAMEWORK                                                                                                                           #
# *                                                                                                                                                   #
# * @copyright Copyright (C) 2009 By ShadoX from xnova-reloaded.de                     #
# *                                                                                                                                                         #
# *                                                                                                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                                                         #
# *                                                                                                                                                         #
# *  This program is distributed in the hope that it will be useful,                 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of                         #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                         #
# *  GNU General Public License for more details.                                                         #
# *                                                                                                                                                         #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.' . PHP_EXT);
include(ROOT_PATH . 'includes/functions/DeleteSelectedUser.' . PHP_EXT);
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($EditUsers != 1) die();

        $parse        = $lang;

        if(isset($_GET['action']) && isset($_GET['id'])) {
                $id = intval($_GET['id']);
                $query                  = $db->query("SELECT * FROM ".USERS." WHERE id='".$id."' LIMIT 1");
                $parse                 	= $db->fetch_array($query);
                $parse['ul_save']  		= $lang['ul_save'];
                $parse['umodchecked'] 	= $users['urlaubs_modus'] ? 'checked=checked' : '';
                $parse['banchecked'] 	= ( $users['bana'] == 1 ) ? 'checked=checked' : '';
				display(parsetemplate(gettemplate('adm/UserListEdit'), $parse), false, '', true, false);
        }
        elseif(isset($_GET['submit'])) {

                $edit_id 			= intval($_POST['currid']);
                $username			= $_POST['username'];
                $email				= $_POST['email'];
                if($_POST['umod'] == 1) {
                        $umod = '`urlaubs_modus` = 1,`urlaubs_until` = '.time();
                }else{
                        $umod = '`urlaubs_modus` = 0,`urlaubs_until` = 0';
                }

                $query = $db->query("UPDATE ".USERS." SET
                                                        `username`                = '".$username."',
                                                        `email`                        = '".$email."',
                                                        `spy_tech`                                 = '".intval($_POST['spy_tech'])."',
                                                        `computer_tech`                 = '".intval($_POST['computer_tech'])."',
                                                        `military_tech`                 = '".intval($_POST['military_tech'])."',
                                                        `defence_tech`                         = '".intval($_POST['defence_tech'])."',
                                                        `shield_tech`                         = '".intval($_POST['shield_tech'])."',
                                                        `energy_tech`                         = '".intval($_POST['energy_tech'])."',
                                                        `hyperspace_tech`                 = '".intval($_POST['hyperspace_tech'])."',
                                                        `combustion_tech`                 = '".intval($_POST['combustion_tech'])."',
                                                        `impulse_motor_tech`         = '".intval($_POST['impulse_motor_tech'])."',
                                                        `hyperspace_motor_tech` = '".intval($_POST['hyperspace_motor_tech'])."',
                                                        `laser_tech`                         = '".intval($_POST['laser_tech'])."',
                                                        `ionic_tech`                         = '".intval($_POST['ionic_tech'])."',
                                                        `buster_tech`                         = '".intval($_POST['buster_tech'])."',
                                                        `intergalactic_tech`         = '".intval($_POST['intergalactic_tech'])."',
                                                        `expedition_tech`                 = '".intval($_POST['expedition_tech'])."',
                                                        `graviton_tech`                 = '".intval($_POST['graviton_tech'])."',
                                                        `rpg_stockeur`          = '".intval($_POST['rpg_stockeur'])."',
                                                        `rpg_geologue`          = '".intval($_POST['rpg_geologue'])."',
                                                        `rpg_amiral`            = '".intval($_POST['rpg_amiral'])."',
                                                        `rpg_ingenieur`         = '".intval($_POST['rpg_ingenieur'])."',
                                                        `rpg_technocrate`       = '".intval($_POST['rpg_technocrate'])."',
                                                        `rpg_constructeur`      = '".intval($_POST['rpg_constructeur'])."',
                                                        `rpg_scientifique`      = '".intval($_POST['rpg_scientifique'])."',
                                                        `rpg_destructeur`       = '".intval($_POST['rpg_destructeur'])."',
                                                        `rpg_defenseur`         = '".intval($_POST['rpg_defenseur'])."',
                                                        `rpg_bunker`            = '".intval($_POST['rpg_bunker'])."',
                                                        `rpg_espion`            = '".intval($_POST['rpg_espion'])."',
                                                        `rpg_commandant`        = '".intval($_POST['rpg_commandant'])."',
                                                        `rpg_general`           = '".intval($_POST['rpg_general'])."',
                                                        `rpg_raideur`           = '".intval($_POST['rpg_raideur'])."',
                                                        `rpg_empereur`          = '".intval($_POST['rpg_empereur'])."',
                                                        `darkmatter`            = '".intval($_POST['darkmatter'])."',
                                                         ".$umod."
                                                         WHERE `id` = '".$edit_id."' LIMIT 1");
                // AdminLOG - Helmchen
                $fp = fopen('logs/adminlog_'.date('d.m.Y').'.txt','a');
                fwrite($fp,date("d.m.Y H:i:s",time())." - ".$user['username']." - ".$user['user_lastip']." - ".__FILE__." - changed values of user with ID: ".$edit_id."\n");
                fclose($fp);
                // AdminLOG ENDE

                exit("User ".$_POST['username']." erfolgreich editiert.");
        }
		else
		{
			if ($_GET['cmd'] == 'dele')
					DeleteSelectedUser ($_GET['user']);
			if ($_GET['cmd'] == 'sort')
					$TypeSort = $_GET['type'];
			else
					$TypeSort = "id";

			$query   = $db->query("SELECT `id`,`id_planet`,`username`,`email`,`ip_at_reg`,`user_lastip`,`register_time`,`onlinetime`,`bana`,`banaday`,`urlaubs_modus`,`galaxy`,`system`,`planet`,`urlaubs_until` FROM ".USERS." ORDER BY `". $TypeSort ."` ASC");

			$parse['adm_ul_table'] = "";
			$i                     = 0;
			$Color                 = "green ";
			while ($u = $db->fetch($query))
			{
					if ($PrevIP != "")
					{
							if ($PrevIP == $u['user_lastip'])
									$Color = "red";
							else
									$Color = "green";
					}

					$Bloc['adm_ul_data_id']         = $u['id'];
					$Bloc['adm_ul_data_pid']        = $u['id_planet'];
					$Bloc['adm_ul_data_name']       = $u['username'];
					$Bloc['adm_ul_data_mail']       = $u['email'];
					$Bloc['adm_ul_data_hp']         = "[".$u['galaxy'].":".$u['system'].":".$u['planet']."]";
					$Bloc['adm_ul_data_rgip']       = $u['ip_at_reg'];
					$Bloc['adm_ul_data_adip']       = ($user['authlevel'] >= 3) ? "<font color=\"".$Color."\">". $u['user_lastip'] ."</font>" : "-";
					$Bloc['adm_ul_data_regd']       = date ( "d.m.Y G:i:s", $u['register_time'] );
					$Bloc['adm_ul_data_lconn']      = date ( "d.m.Y G:i:s", $u['onlinetime'] );
					$Bloc['adm_ul_data_banna']      = ($u['bana'] == 1) ? "<a href # title=\"". date ( "d. M Y G:i:s", $u['banaday']) ."\">".$lang['ul_yes']."</a>" : $lang['ul_no'];
					$Bloc['adm_ul_data_umod']       = ($u['urlaubs_modus'] == 1) ? "<a href # title=\"". date ( "d. M Y G:i:s", $u['urlaubs_until']) ."\">".$lang['ul_yes']."</a>" : $lang['ul_no'];
					$Bloc['adm_ul_data_actio']      = ($u['id'] != $user['id'] && $user['authlevel'] >= 3) ? "<a href=\"?cmd=dele&amp;user=".$u['id']."\" onclick=\"return confirm('".$lang['ul_sure_you_want_dlte']."  $u[username]?');\"><img border=\"0\" alt=\"\" src=\"../styles/images/r1.png\"></a>" : "-";
					$Bloc['adm_ul_goto_maintrace']  = ($user['authlevel'] >= 3) ? "<a href=\"?maintrace=".$u['id']."\">". $lang['ul_maintrace'] ."</a>" : "-";
					$PrevIP                         = $u['user_lastip'];
					$parse['adm_ul_table']         .= parsetemplate(gettemplate('adm/UserListRows'), $Bloc);
					$i++;
			}
			$parse['adm_ul_count']                                         = $i;
			display( parsetemplate( gettemplate('adm/UserListBody'), $parse ), false, '', true, false);

		}
?>