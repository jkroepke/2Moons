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
 * @version 1.7.3 (2013-05-19)
 * @info $universe: ShowUniversePage.php 2152 2012-03-16 20:52:20Z slaver7 $
 * @link http://2moons.cc/
 */
 
if ($USER['authlevel'] != AUTH_ADM || $_GET['sid'] != session_id())
{
	throw new Exception("Permission error!");
}

function ShowUniversePage() {
	global $LNG, $UNI, $USER;
	$template	= new template();
	
	$action		= HTTP::_GP('action', '');
	$universe	= HTTP::_GP('uniID', 0);
	
	switch($action)
	{
		case 'open':
			try {
				Config::update(array('game_disable' => 1), $universe);
			}
			catch (Exception $e) { }
		break;
		case 'closed':
			try {
				Config::update(array('game_disable' => 0), $universe);
			}
			catch (Exception $e) { }
		break;
		case 'delete':
			$CONFIG	= Config::getAll(NULL);
			if(!empty($universe) && $universe != ROOT_UNI && $universe != $USER['universe'] && isset($CONFIG[$universe]))
			{
				$GLOBALS['DATABASE']->query("DELETE FROM ".ALLIANCE.", ".ALLIANCE_RANK.", ".ALLIANCE_REQUEST." 
				USING ".ALLIANCE." 
				LEFT JOIN ".ALLIANCE_RANK." ON ".ALLIANCE.".id = ".ALLIANCE_RANK.".allianceID
				LEFT JOIN ".ALLIANCE_REQUEST." ON ".ALLIANCE.".id = ".ALLIANCE_REQUEST." .allianceID
				WHERE ally_universe = ".$universe.";");
				$GLOBALS['DATABASE']->query("DELETE FROM ".BANNED." WHERE universe = ".$universe.";");
				$GLOBALS['DATABASE']->query("DELETE FROM ".BUDDY.", ".BUDDY_REQUEST."
				USING ".BUDDY."
				LEFT JOIN ".BUDDY_REQUEST." ON ".BUDDY.".id = ".BUDDY_REQUEST.".id
				WHERE ".BUDDY.".universe = ".$universe.";");
				$GLOBALS['DATABASE']->query("DELETE FROM ".CONFIG." WHERE uni = ".$universe.";");
				$GLOBALS['DATABASE']->query("DELETE FROM ".DIPLO." WHERE universe = ".$universe.";");
				$GLOBALS['DATABASE']->query("DELETE FROM ".FLEETS.", ".FLEETS_EVENT.", ".AKS.", ".LOG_FLEETS."
				USING ".FLEETS."
				LEFT JOIN ".FLEETS_EVENT." ON ".FLEETS.".fleet_id = ".FLEETS_EVENT.".fleetID
				LEFT JOIN ".AKS." ON ".FLEETS.".fleet_group = ".AKS.".id
				LEFT JOIN ".LOG_FLEETS." ON ".FLEETS.".fleet_id = ".LOG_FLEETS.".fleet_id
				WHERE ".FLEETS.".fleet_universe = ".$universe.";");
				$GLOBALS['DATABASE']->query("DELETE FROM ".MESSAGES." WHERE message_universe = ".$universe.";");
				$GLOBALS['DATABASE']->query("DELETE FROM ".NOTES." WHERE universe = ".$universe.";");
				$GLOBALS['DATABASE']->query("DELETE FROM ".PLANETS." WHERE universe = ".$universe.";");
				$GLOBALS['DATABASE']->query("DELETE FROM ".STATPOINTS." WHERE universe = ".$universe.";");
				$GLOBALS['DATABASE']->query("DELETE FROM ".TICKETS.", ".TICKETS_ANSWER."
				USING ".TICKETS."
				LEFT JOIN ".TICKETS_ANSWER." ON ".TICKETS.".ticketID = ".TICKETS_ANSWER.".ticketID
				WHERE universe = ".$universe.";");
				$GLOBALS['DATABASE']->query("DELETE FROM ".TOPKB." WHERE universe = ".$universe.";");
				$GLOBALS['DATABASE']->query("DELETE FROM ".USERS.", ".USERS_ACS.", ".USERS_AUTH.", ".TOPKB_USERS.", ".SESSION.", ".SHORTCUTS.", ".RECORDS."
				USING ".USERS."
				LEFT JOIN ".USERS_ACS." ON ".USERS.".id = ".USERS_ACS.".userID
				LEFT JOIN ".USERS_AUTH." ON ".USERS.".id = ".USERS_AUTH.".id
				LEFT JOIN ".TOPKB_USERS." ON ".USERS.".id = ".TOPKB_USERS.".uid
				LEFT JOIN ".SESSION." ON ".USERS.".id = ".SESSION.".userID
				LEFT JOIN ".SHORTCUTS." ON ".USERS.".id = ".SHORTCUTS.".ownerID
				LEFT JOIN ".RECORDS." ON ".USERS.".id = ".RECORDS.".userID
				LEFT JOIN ".LOSTPASSWORD." ON ".USERS.".id = ".LOSTPASSWORD.".userID
				WHERE ".USERS.".universe = ".$universe.";");
				$GLOBALS['DATABASE']->query("DELETE FROM ".USERS_VALID." WHERE universe = ".$universe.";");
				if($_SESSION['adminuni'] == $universe)
				{
					$_SESSION['adminuni']	= $USER['universe'];
				}
				
				Config::init();
				$CONFIG	= Config::getAll(NULL);
				
				if(count($CONFIG) == 1)
				{
					// Hack The Session
					setcookie(session_name(), session_id(), SESSION_LIFETIME, HTTP_BASE, NULL, HTTPS, true);
					HTTP::redirectTo("admin.php?reload=r");
				}
			}
		break;
		case 'create':
			Config::init();
			$CONFIG	= Config::getAll(NULL);
			
			// Check Multiuniverse Support
			$ch	= curl_init();
			if(count($CONFIG) == 1)
			{
				curl_setopt($ch, CURLOPT_URL, PROTOCOL.HTTP_HOST.HTTP_BASE."uni".ROOT_UNI."/");
			}
			else
			{
				curl_setopt($ch, CURLOPT_URL, PROTOCOL.HTTP_HOST.HTTP_BASE);
			}
			curl_setopt($ch, CURLOPT_HTTPGET, true);
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; 2Moons/".Config::get('VERSION')."; +http://2moons.cc)");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
				"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.3",
				"Accept-Language: de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4",
			));
			curl_exec($ch);
			$httpCode	= curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
			curl_close($ch);
			if($httpCode != 302)
			{
				$template = new template();
				$template->message(str_replace(
					array(
						'{NGINX-CODE}'
					), 
					array(
						#'rewrite '.HTTP_ROOT.'uni[0-9]+/?(.*)?$ '.HTTP_ROOT.'$2 break;'
						'rewrite /(.*)/?uni[0-9]+/?(.*) /$1/$2 break;'
					),
					$LNG->getTemplate('createUniverseInfo')
				)
				.'<a href="javascript:window.history.back();"><button>'.$LNG['uvs_back'].'</button></a>'
				.'<a href="javascript:window.location.reload();"><button>'.$LNG['uvs_reload'].'</button></a>');
				exit;
			}
			
			$CONFIG	= Config::getAll(NULL);
			$CONF	= $CONFIG[$_SESSION['adminuni']];
			
			$configSQL	= array();
			foreach($GLOBALS['BASICCONFIG'] as $basicConfigKey)
			{
				$configSQL[]	= '`'.$basicConfigKey.'` = "'.$CONF[$basicConfigKey].'"';
			}
			
			$configSQL[]	= '`uni_name` = "'.$LNG['fcm_universe'].' '.(count($CONFIG) + 1).'"';
			$configSQL[]	= '`close_reason` = ""';
			$configSQL[]	= '`OverviewNewsText` = "'.$GLOBALS['DATABASE']->escape($CONF['OverviewNewsText']).'"';		
		
			$GLOBALS['DATABASE']->query("INSERT INTO ".CONFIG." SET ".implode(', ', $configSQL).";");
			$newUniverse	= $GLOBALS['DATABASE']->GetInsertID();
			Config::init();
			$CONFIG	= Config::getAll(NULL);
			
			list($userID, $planetID) = PlayerUtil::createPlayer($newUniverse, $USER['username'], '', $USER['email'], $USER['lang'], 1, 1, 1, NULL, AUTH_ADM);
			$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET password = '".$USER['password']."' WHERE id = ".$userID.";");

			if(count($CONFIG) == 2)
			{
				// Hack The Session
				setcookie(session_name(), session_id(), SESSION_LIFETIME, HTTP_ROOT.'uni'.$USER['universe'].'/', NULL, HTTPS, true);
				HTTP::redirectTo("admin.php?reload=r");
			}
		break;
	}
	
	$uniList	= array();
	
	$uniResult	= $GLOBALS['DATABASE']->query("SELECT uni, users_amount, game_disable, energySpeed, halt_speed, resource_multiplier, fleet_speed, game_speed, uni_name, COUNT(DISTINCT inac.id) as inactive, COUNT(planet.id) as planet
	FROM ".CONFIG." conf
	LEFT JOIN ".USERS." as inac ON uni = inac.universe AND inac.onlinetime < ".(TIMESTAMP - INACTIVE)."
	LEFT JOIN ".PLANETS." as planet ON uni = planet.universe
	GROUP BY conf.uni, inac.universe, planet.universe
	ORDER BY uni ASC;");
	
	while($uniRow = $GLOBALS['DATABASE']->fetch_array($uniResult)) {
		$uniList[$uniRow['uni']]	= $uniRow;
	}
	
	$template->assign_vars(array(
		'uniList'	=> $uniList,
		'SID'		=> session_id(),
	));
	
	$template->show('UniversePage.tpl');
}