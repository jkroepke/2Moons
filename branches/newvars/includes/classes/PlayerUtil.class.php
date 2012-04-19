<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-05-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class PlayerUtil {
	
	const POSITION_NOT_AVALIBLE = 0;
	
	static function cryptPassword($password)
	{
		// http://www.phpgangsta.de/schoener-hashen-mit-bcrypt
		global $salt;	
		if(!CRYPT_BLOWFISH || !isset($salt)) {
			return md5($password);
		} else {
			return crypt($password, '$2a$09$'.$salt.'$');
		}
	}

	static function isPositionFree($Universe, $Galaxy, $System, $Position, $Type = 1)
	{
		return $GLOBALS['DATABASE']->countquery("SELECT COUNT(*)
												 FROM ".PLANETS." 
												 WHERE universe = ".$Universe."
												 AND galaxy = ".$Galaxy."
												 AND system = ".$System."
												 AND planet = ".$Position."
												 AND planet_type = ".$Type.";");
	}

	static function calculateMoonChance($FleetDebris, $universe)
	{
		global $uniAllConfig;
		
		$uniConfig	= $uniAllConfig[$universe];
		
		return min(round($FleetDebris / 100000 * $uniConfig['planetMoonCreateChanceFactor'], 0), $uniConfig['planetMoonCreateMaxChance']);
	}

	static function isNameValid($name)
	{
		if(UTF8_SUPPORT) {
			return preg_match("/^[\p{L}\p{N}_\-. ]*$/u", $name);
		} else {
			return preg_match("/^[A-z0-9_\-. ]*$/", $name);
		}
	}

	static function isMailValid($address) {
		
		if(function_exists('filter_var')) {
			return filter_var($address, FILTER_VALIDATE_EMAIL) !== FALSE;
		} else {
			/* Regex expression from swift mailer (http://swiftmailer.org) - RFC 2822 */
			return preg_match('/^(?:(?:(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?(?:[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+(\.[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+)*)+(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)|(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?"((?:(?:[ \t]*(?:\r\n))?[ \t])?(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21\x23-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])))*(?:(?:[ \t]*(?:\r\n))?[ \t])?"(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?))@(?:(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?(?:[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+(\.[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+)*)+(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)|(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?\[((?:(?:[ \t]*(?:\r\n))?[ \t])?(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x5A\x5E-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])))*?(?:(?:[ \t]*(?:\r\n))?[ \t])?\](?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)))$/D', $address);
		}
	}
	
	static function createPlayer($Universe, $UserName, $UserPass, $UserMail, $Galaxy = NULL, $System = NULL, $Position = NULL, $planetname = NULL, $authlevel = 0, $UserLang = NULL, $UserIP = NULL)
	{
		global $gameConfig, $uniAllConfig, $UNI;

		$uniCurrentConfig	= $uniAllConfig[$Universe];
		
		$availableUniverse	= $GLOBALS['CACHE']->get('universe');
		if (isset($Galaxy, $System, $Position))
		{
			if ($uniCurrentConfig['planetMaxGalaxy'] < $Galaxy || 1 > $Galaxy) {
				throw new Exception("Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
			}	
			
			if ($uniCurrentConfig['planetMaxSystem'] < $System || 1 > $System) {
				throw new Exception("Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
			}	
			
			if ($uniCurrentConfig['planetMaxPosition'] < $Position || 1 > $Position) {
				throw new Exception("Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
			}
			
			if (self::isPositionFree($Universe, $Galaxy, $System, $Position)) {
				return self::POSITION_NOT_AVALIBLE;
			}
		} else {
			$Galaxy	= $availableUniverse[$Universe]['lastCreatePlanetGalaxy'];
			$System = $availableUniverse[$Universe]['lastCreatePlanetSystem'];
			$Planet	= $availableUniverse[$Universe]['lastCreatePlanetPosition'];
			
			do {
				$Position = mt_rand(round($uniCurrentConfig['planetMaxPosition'] * 0.2), round($uniCurrentConfig['planetMaxPosition'] * 0.8));
				if ($Planet < 3) {
					$Planet += 1;
				} else {
					if ($System >= $uniCurrentConfig['planetMaxSystem']) {
						$Galaxy += 1;
						$System = 1;
						if($Galaxy >= $uniCurrentConfig['planetMaxGalaxy']) {
							$Galaxy	= 1;
						}
					} else {
						$System += 1;
					}
				}
			} while (self::isPositionFree($Universe, $Galaxy, $System, $Position) === false);
			
			$GLOBALS['DATABASE']->query("UPDATE ".UNIVERSE." SET lastCreatePlanetGalaxy = ".$Galaxy.", lastCreatePlanetSystem = ".$System.", lastCreatePlanetPosition = ".$Planet." WHERE universe = ".$UNI.";");

			$availableUniverse[$Universe]['lastCreatePlanetGalaxy']		= $Galaxy;
			$availableUniverse[$Universe]['lastCreatePlanetSystem']		= $System;
			$availableUniverse[$Universe]['lastCreatePlanetPosition']	= $Planet;
		}
		
		$SQL = "INSERT INTO ".USERS." SET
		username		= '".$GLOBALS['DATABASE']->sql_escape($UserName)."',
		email			= '".$GLOBALS['DATABASE']->sql_escape($UserMail)."',
		email_2			= '".$GLOBALS['DATABASE']->sql_escape($UserMail)."',
		authlevel		= ".$authlevel.",
		universe		= ".$Universe.",
		lang			= '".$UserLang."',
		ip_at_reg		= '".(!empty($UserIP) ? $UserIP : $_SERVER['REMOTE_ADDR'])."',
		onlinetime		= ".TIMESTAMP.",
		register_time	= ".TIMESTAMP.",
		password		= '".$UserPass."',
		dpath			= '".DEFAULT_THEME."',
		timezone		= '".$gameConfig['timezone']."',
		uctime			= 0";
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE] as $elementID) {
			$SQL	.= ", ".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']." = ".$uniCurrentConfig['planetResource'.$elementID.'Start'];
		}
		
		$GLOBALS['DATABASE']->query($SQL);
		
		$userID		= $GLOBALS['DATABASE']->GetInsertID();
		$planetID	= self::createPlanet($Galaxy, $System, $Position, $Universe, $userID, $planetname, true, $authlevel);
	
		$currentUserAmount	= $availableUniverse[$Universe]['userAmount'] + 1;
		
		$SQL = "UPDATE ".USERS." SET 
				galaxy = ".$Galaxy.", 
				system = ".$System.", 
				planet = ".$Position.",
				id_planet = ".$planetID."
				WHERE id = ".$userID.";";
				
		$GLOBALS['DATABASE']->query($SQL);
		
		$SQL = "INSERT INTO ".STATPOINTS." SET 
				id_owner	= ".$userID.",
				universe	= ".$Universe.",
				stat_type	= 1,
				tech_rank	= ".$currentUserAmount.",
				build_rank	= ".$currentUserAmount.",
				defs_rank	= ".$currentUserAmount.",
				fleet_rank	= ".$currentUserAmount.",
				total_rank	= ".$currentUserAmount.";";
				
		$GLOBALS['DATABASE']->query($SQL);
		
		$GLOBALS['DATABASE']->query("UPDATE ".UNIVERSE." SET userAmount = userAmount + 1 WHERE universe = ".$UNI.";");
		
		$GLOBALS['CACHE']->flush('universe');
		
		return array($userID, $planetID);
	}
	
	static function createPlanet($Galaxy, $System, $Position, $Universe, $PlanetOwnerID, $PlanetName = NULL, $HomeWorld = false, $authlevel = 0)
	{
		global $uniAllConfig, $gameConfig, $LNG;

		$uniCurrentConfig	= $uniAllConfig[$Universe];

		if ($uniCurrentConfig['planetMaxGalaxy'] < $Galaxy || 1 > $Galaxy) {
			throw new Exception("Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
		}	
		
		if ($uniCurrentConfig['planetMaxSystem'] < $System || 1 > $System) {
			throw new Exception("Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
		}	
		
		if ($uniCurrentConfig['planetMaxPosition'] < $Position || 1 > $Position) {
			throw new Exception("Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
		}
		
		if (self::isPositionFree($Universe, $Galaxy, $System, $Position)) {
			return self::POSITION_NOT_AVALIBLE;
		}

		require(ROOT_PATH.'includes/PlanetData.php');
		
		$Pos                = ceil($Position / ($uniCurrentConfig['planetMaxPosition'] / count($PlanetData))); 
		$TMax				= $PlanetData[$Pos]['temp'];
		$TMin				= $TMax - 40;
		
		if($HomeWorld) {
			$Fields				= $uniCurrentConfig['planetFieldsMainPlanet'];
		} else {
			$Fields				= floor($PlanetData[$Pos]['fields'] * $uniCurrentConfig['planetMoonSizeFactor']);
		}
		
		$Types				= array_keys($PlanetData[$Pos]['image']);
		$Type				= $Types[array_rand($Types)];
		$Class				= $Type.'planet'.($PlanetData[$Pos]['image'][$Type] < 10 ? '0' : '').$PlanetData[$Pos]['image'][$Type];
		
		if(empty($PlanetName))
		{
			if($HomeWorld) {
				$PlanetName	= $LNG['fcp_mainplanet'];
			} else {
				$PlanetName	= $LNG['fcp_colony'];
			}
		}
	
		$SQL	= "INSERT INTO ".PLANETS." SET
				   name = '".$GLOBALS['DATABASE']->sql_escape($PlanetName)."',
				   universe = ".$Universe.",
				   id_owner = ".$PlanetOwnerID.",
				   galaxy = ".$Galaxy.",
				   system = ".$System.",
				   planet = ".$Position.",
				   last_update = ".TIMESTAMP.",
				   planet_type = '1',
				   image = '".$Class."',
				   diameter = ".floor(1000 * sqrt($Fields)).",
				   field_max = ".$Fields.",
				   temp_min = ".$TMin.",
				   temp_max = ".$TMax;
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $elementID) {
			$SQL	.= ", ".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']." = ".$uniCurrentConfig['planetResource'.$elementID.'Start'].", ".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']."_perhour = ".$uniCurrentConfig['planetResource'.$elementID.'BasicIncome'];
		}
		
		$GLOBALS['DATABASE']->query($SQL);
		return $GLOBALS['DATABASE']->GetInsertID();
	}
	
	static function createMoon($Universe, $Galaxy, $System, $Position, $userID, $Chance, $Size = NULL)
	{
		global $LNG, $USER;

		$SQL  = "SELECT id_luna, planet_type, id, name, temp_max, temp_min FROM ".PLANETS."
				 WHERE universe = ".$Universe."
				 AND galaxy = ".$Galaxy."
				 AND system = ".$System."
				 AND planet = ".$Position."
				 AND planet_type = '1';";
				 
		$MoonPlanet = $GLOBALS['DATABASE']->getFirstRow($SQL);

		if ($MoonPlanet['id_luna'] != 0)
			return false;

		if($Size == 0) {
			$size	= floor(pow(mt_rand(10, 20) + 3 * $Chance, 0.5) * 1000); # New Calculation - 23.04.2011
		} else {
			$size	= $Size;
		}
		
		$maxtemp	= $MoonPlanet['temp_max'] - mt_rand(10, 45);
		$mintemp	= $MoonPlanet['temp_min'] - mt_rand(10, 45);

		$GLOBALS['DATABASE']->multi_query("INSERT INTO ".PLANETS." SET
						  name = '".$MoonName."',
						  id_owner = ".$Owner.",
						  universe = ".$Universe.",
						  galaxy = ".$Galaxy.",
						  system = ".$System.",
						  planet = ".$Planet.",
						  last_update = ".TIMESTAMP.",
						  planet_type = '3',
						  image = 'mond',
						  diameter = ".$size.",
						  field_max = '1',
						  temp_min = ".$mintemp.",
						  temp_max = ".$maxtemp.",
						  metal = 0,
						  metal_perhour = 0,
						  crystal = 0,
						  crystal_perhour = 0,
						  deuterium = 0,
						  deuterium_perhour = 0;
						  SET @moonID = LAST_INSERT_ID();
						  UPDATE ".PLANETS." SET
						  id_luna = @moonID
						  WHERE
						  id = ".$MoonPlanet['id'].";");

		return true;
	}
 
	static function deletePlayer($userID)
	{
		global $db;
		
		if(ROOT_USER == $userID) {
			return false;
		}
		
		$userData = $GLOBALS['DATABASE']->getFirstRow("SELECT universe, ally_id FROM ".USERS." WHERE id = '".$userID."';");
		$SQL 	 = "";
		
		if (!empty($userData['ally_id']))
		{
			$memberCount =  $GLOBALS['DATABASE']->countquery("SELECT ally_members FROM ".ALLIANCE." WHERE id = ".$userData['ally_id'].";");
			
			if ($memberCount == 1)
			{
				$SQL .= "UPDATE ".ALLIANCE." SET ally_members = ally_members - 1 WHERE id = ".$userData['ally_id'].";";
			}
			else
			{
				$SQL .= "DELETE FROM ".ALLIANCE." WHERE id = ".$userData['ally_id'].";";
				$SQL .= "DELETE FROM ".STATPOINTS." WHERE stat_type = '2' AND id_owner = ".$userData['ally_id'].";";
				$SQL .= "UPDATE ".STATPOINTS." WHERE id_ally = 0 AND id_ally = ".$userData['ally_id'].";";
			}
		}
		
		$SQL .= "DELETE FROM ".ALLIANCE_REQUEST." WHERE userID = ".$userID.";";
		$SQL .= "DELETE FROM ".BUDDY." WHERE owner = ".$userID." OR sender = ".$userID.";";
		$SQL .= "DELETE FROM ".FLEETS." WHERE fleet_owner = ".$userID.";";
		$SQL .= "DELETE FROM ".MESSAGES." WHERE message_owner = ".$userID.";";
		$SQL .= "DELETE FROM ".NOTES." WHERE owner = ".$userID.";";
		$SQL .= "DELETE FROM ".PLANETS." WHERE id_owner = ".$userID.";";
		$SQL .= "DELETE FROM ".USERS." WHERE id = ".$userID.";";
		$SQL .= "DELETE FROM ".STATPOINTS." WHERE stat_type = '1' AND id_owner = ".$userID.";";
		$GLOBALS['DATABASE']->multi_query($SQL);
		
		$fleetData	= $GLOBALS['DATABASE']->query("SELECT fleet_id FROM ".FLEETS." WHERE fleet_target_owner = ".$userID.";");
		
		while($FleetID = $GLOBALS['DATABASE']->fetchArray($fleetData)) {
			FleetUtil::SendFleetBack($userID, $FleetID['fleet_id']);
		}
		
		$GLOBALS['DATABASE']->free_result($fleetData);

		$GLOBALS['DATABASE']->query("UPDATE ".UNIVERSE." SET userAmount = userAmount - 1 WHERE universe = ".$userData['universe'].";");
		
		$GLOBALS['CACHE']->flush('universe');
	}

	static function deletePlanet($planetID)
	{
		$planetData = $GLOBALS['DATABASE']->getFirstRow("SELECT planet_type FROM ".PLANETS." WHERE id = ".$planetID." AND id NOT IN (SELECT id_planet FROM ".USERS.");");
		
		if(empty($planetData)) {
			return false;
		}
		
		$fleetData	= $GLOBALS['DATABASE']->query("SELECT fleet_id FROM ".FLEETS." WHERE fleet_end_id = ".$planetID.";");
		
		while($FleetID = $GLOBALS['DATABASE']->fetchArray($fleetData)) {
			FleetUtil::SendFleetBack($$planetID, $FleetID['fleet_id']);
		}
		
		$GLOBALS['DATABASE']->free_result($fleetData);
		
		if ($planetData['planet_type'] == 3) {
			$GLOBALS['DATABASE']->multi_query("DELETE FROM ".PLANETS." WHERE id = ".$planetID.";UPDATE ".PLANETS." SET id_luna = 0 WHERE id_luna = ".$planetID.";");
		} else {
			$GLOBALS['DATABASE']->query("DELETE FROM ".PLANETS." WHERE id = ".$planetID." OR id_luna = ".$planetID.";");
		}
	}
	
	static function maxPlanetCount($USER, $Universe)
	{
		global $uniAllConfig;
		
		$uniConfig	= $uniAllConfig[$Universe];
		
		if(empty($uniConfig['userMaxPlanets']))
		{
			return 0;
		}

		// http://owiki.de/index.php/Astrophysik#.C3.9Cbersicht
		return min($uniConfig['userMinPlanets'] + ceil($Level / 2) * PLANETS_PER_TECH, $uniConfig['userMaxPlanets']);
	}

	static function allowPlanetPosition($USER, $planetPosition)
	{
		// http://owiki.de/index.php/Astrophysik#.C3.9Cbersicht
		
		$techLevel	= $USER[$GLOBALS['VARS']['ELEMENT'][124]['name']];
		
		switch($planetPosition) {
			case 1:
			case 15:
				return 8;
			break;
			case 2:
			case 14:
				return 6;
			break;
			case 3:
			case 13:
				return 4;
			break;
			default:
				return 1;
			break;
		}
	}
}