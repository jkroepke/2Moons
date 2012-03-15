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

if ($USER['authlevel'] != AUTH_ADM || $_GET['sid'] != session_id()) exit;
@set_time_limit(0);

function ShowUniversePage() {
	global $CONF, $LNG, $UNI, $USER;
	$template	= new template();

	if($_REQUEST['action'] == 'delete' && !empty($_REQUEST['id']) && $_REQUEST['id'] != ROOT_UNI) {
		$ID	= (int) $_REQUEST['id'];
		if($UNI != $ID) {
			$GLOBALS['DATABASE']->query("DELETE FROM ".ALLIANCE.", ".ALLIANCE_RANK.", ".ALLIANCE_REQUEST." 
			USING ".ALLIANCE." 
			LEFT JOIN ".ALLIANCE_RANK." ON ".ALLIANCE.".id = ".ALLIANCE_RANK.".allianceID
			LEFT JOIN ".ALLIANCE_REQUEST." ON ".ALLIANCE.".id = ".ALLIANCE_REQUEST." .allianceID
			WHERE ally_universe = ".$ID.";");
			
			$GLOBALS['DATABASE']->query("DELETE FROM ".BANNED." WHERE universe = ".$ID.";");
			
			$GLOBALS['DATABASE']->query("DELETE FROM ".BUDDY.", ".BUDDY_REQUEST."
			USING ".BUDDY."
			LEFT JOIN ".BUDDY_REQUEST." ON ".BUDDY.".id = ".BUDDY_REQUEST.".id
			WHERE ".BUDDY.".universe = ".$ID.";");
			
			$GLOBALS['DATABASE']->query("DELETE FROM ".CONFIG." WHERE uni = ".$ID.";");
			
			$GLOBALS['DATABASE']->query("DELETE FROM ".DIPLO." WHERE universe = ".$ID.";");
			
			$GLOBALS['DATABASE']->query("DELETE FROM ".FLEETS.", ".FLEETS_EVENT.", ".AKS.", ".LOG_FLEETS."
			USING ".FLEETS."
			LEFT JOIN ".FLEETS_EVENT." ON ".FLEETS.".fleet_id = ".FLEETS_EVENT.".fleetID
			LEFT JOIN ".AKS." ON ".FLEETS.".fleet_group = ".AKS.".id
			LEFT JOIN ".LOG_FLEETS." ON ".FLEETS.".fleet_id = ".LOG_FLEETS.".fleet_id
			WHERE ".FLEETS.".fleet_universe = ".$ID.";");

			$GLOBALS['DATABASE']->query("DELETE FROM ".MESSAGES." WHERE message_universe = ".$ID.";");
			
			$GLOBALS['DATABASE']->query("DELETE FROM ".NOTES." WHERE universe = ".$ID.";");
		
			$GLOBALS['DATABASE']->query("DELETE FROM ".PLANETS." WHERE universe = ".$ID.";");
			
			$GLOBALS['DATABASE']->query("DELETE FROM ".STATPOINTS." WHERE universe = ".$ID.";");
			
			$GLOBALS['DATABASE']->query("DELETE FROM ".TICKETS.", ".TICKETS_ANSWER."
			USING ".TICKETS."
			LEFT JOIN ".TICKETS_ANSWER." ON ".TICKETS.".ticketID = ".TICKETS_ANSWER.".ticketID
			WHERE universe = ".$ID.";");
			
			$GLOBALS['DATABASE']->query("DELETE FROM ".TOPKB." WHERE universe = ".$ID.";");
			
			$GLOBALS['DATABASE']->query("DELETE FROM ".USERS.", ".USERS_ACS.", ".USERS_AUTH.", ".TOPKB_USERS.", ".SESSION.", ".SHORTCUTS.", ".RECORDS."
			USING ".USERS."
			LEFT JOIN ".USERS_ACS." ON ".USERS.".id = ".USERS_ACS.".userID
			LEFT JOIN ".USERS_AUTH." ON ".USERS.".id = ".USERS_AUTH.".id
			LEFT JOIN ".TOPKB_USERS." ON ".USERS.".id = ".TOPKB_USERS.".uid
			LEFT JOIN ".SESSION." ON ".USERS.".id = ".SESSION.".userID
			LEFT JOIN ".SHORTCUTS." ON ".USERS.".id = ".SHORTCUTS.".ownerID
			LEFT JOIN ".RECORDS." ON ".USERS.".id = ".RECORDS.".userID
			WHERE ".USERS.".universe = ".$ID.";");
			
			$GLOBALS['DATABASE']->query("DELETE FROM ".USERS_VALID." WHERE universe = ".$ID.";");
		
			if($_SESSION['adminuni'] == $ID) {
				$_SESSION['adminuni']	= $UNI;
			}
		}
	} elseif($_REQUEST['action'] == 'create') {
		$ID	= (int) $_REQUEST['id'];
		$GLOBALS['DATABASE']->query("INSERT INTO ".CONFIG." (uni, VERSION, uni_name, game_name, close_reason, OverviewNewsText, lang) VALUES
		(NULL, '".$CONF['VERSION']."', '".$LNG['fcm_universe']."', '".$CONF['game_name']."', '".$CONF['close_reason']."', '', '".$CONF['lang']."');");
		
		$UniID	= $GLOBALS['DATABASE']->GetInsertID();
		
		$config	= array('users_amount' => 1);
		foreach($GLOBALS['BASICCONFIG'] as $key) {
			if(!isset($CONF[$key])) {
				continue;
			}
			
			$config[$key]	= $CONF[$key];
		}
		
		update_config($config, $UniID);
		
		unset($GLOBALS['CONFIG'][$UniID]);
		$Galaxy	= 1;
		$System	= 1;
		$Planet	= 2;
				
		$SQL = "INSERT INTO ".USERS." SET
		username		= '".$GLOBALS['DATABASE']->sql_escape($USER['username']). "',
		password		= '".$USER['password']."',
		email			= '".$GLOBALS['DATABASE']->sql_escape($USER['email'])."',
		email_2			= '".$GLOBALS['DATABASE']->sql_escape($USER['email_2'])."',
		lang			= '".$GLOBALS['DATABASE']->sql_escape($USER['lang'])."',
		authlevel		= ".$USER['authlevel'].",
		ip_at_reg		= '".$_SERVER['REMOTE_ADDR']."',
		id_planet		= 0,
		universe		= ".$UniID.",
		onlinetime		= ".TIMESTAMP.",
		register_time	= ".TIMESTAMP.",
		dpath			= '".DEFAULT_THEME."',
		timezone		= '".$CONF['timezone']."',
		uctime			= 0;";
		$GLOBALS['DATABASE']->query($SQL);

		$UserID = $GLOBALS['DATABASE']->GetInsertID();
		
		require_once(ROOT_PATH.'includes/functions/CreateOnePlanetRecord.php');
		$PlanerID	= CreateOnePlanetRecord($Galaxy, $System, $Planet, $UniID, $UserID, $LNG['fcm_planet'], true, $USER['authlevel']);
						
		$SQL = "UPDATE ".USERS." SET 
		id_planet	= ".$PlanerID.",
		galaxy		= ".$Galaxy.",
		system		= ".$System.",
		planet		= ".$Planet."
		WHERE
		id			= ".$UserID.";
		INSERT INTO ".STATPOINTS." SET 
		id_owner	= ".$UserID.",
		universe	= ".$UniID.",
		stat_type	= 1,
		tech_rank	= 1,
		build_rank	= 1,
		defs_rank	= 1,
		fleet_rank	= 1,
		total_rank	= 1;";
		$GLOBALS['DATABASE']->multi_query($SQL);
	}
	
	$Unis				= array();
	
	// Don't know, if works on MySQL < 5.5
	$Query	= $GLOBALS['DATABASE']->query("SELECT uni, users_amount, game_disable, halt_speed, resource_multiplier, fleet_speed, game_speed, uni_name, COUNT(inac.id) as inactive, COUNT(planet.id) as planet
	FROM ".CONFIG." conf
	LEFT JOIN ".USERS." as inac ON uni = inac.universe AND inac.onlinetime < ".(TIMESTAMP - INACTIVE)."
	LEFT JOIN ".PLANETS." as planet ON uni = planet.universe
	GROUP BY conf.uni, inac.universe, planet.universe
	ORDER BY uni ASC;");
	
	while($Uni	= $GLOBALS['DATABASE']->fetch_array($Query)) {
		$Unis[$Uni['uni']]	= $Uni;
	}
	
	ksort($Unis);
	$template->assign_vars(array(
		'Unis'					=> $Unis,
		'SID'					=> session_id(),
		'id'					=> $LNG['uvs_id'],
		'name'					=> $LNG['uvs_name'],
		'speeds'				=> $LNG['uvs_speeds'],
		'players'				=> $LNG['uvs_players'],
		'open'					=> $LNG['uvs_open'],
		'delete'				=> $LNG['uvs_delete'],
		'uni_on'				=> $LNG['uvs_on'],
		'uni_off'				=> $LNG['uvs_off'],
		'new_uni'				=> $LNG['uvs_new'],
	));
	
	$template->show('UniversePage.tpl');
}

?>