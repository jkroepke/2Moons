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
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

class PlayerUtil {
	
	const POSITION_NOT_AVALIBLE = 1;
	
	static function cryptPassword($password)
	{
		// http://www.phpgangsta.de/schoener-hashen-mit-bcrypt
		require(ROOT_PATH . 'includes/config.php');
		
		if(!CRYPT_BLOWFISH || !isset($salt)) {
			return md5($password);
		} else {
			return crypt($password, '$2a$09$'.$salt.'$');
		}
	}

	static function isPositionFree($Universe, $Galaxy, $System, $Position, $Type = 1)
	{
		return $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".PLANETS." 
												   WHERE universe = ".$Universe." AND galaxy = ".$Galaxy."
												   AND system = ".$System." AND planet = ".$Position."
												   AND planet_type = ".$Type.";") == 0;
	}

	static function calculateMoonChance($FleetDebris, $universe)
	{
		return min(round($FleetDebris / 100000 * $uniConfig['planetMoonCreateChanceFactor'], 0), $uniConfig['planetMoonCreateMaxFactor']);
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
	
	static function createPlayer($Universe, $UserName, $UserPass, $UserMail, $UserLang = NULL, $Galaxy = NULL, $System = NULL, $Position = NULL, $planetname = NULL, $authlevel = 0, $UserIP = NULL)
	{
		$CONF	= Config::getAll(NULL, $Universe);
		
		if (isset($Galaxy, $System, $Position))
		{
			if ($CONF['max_galaxy'] < $Galaxy || 1 > $Galaxy) {
				throw new Exception("Try to create a planet at position: ".$Galaxy.":".$System.":".$Position);
			}	
			
			if ($CONF['max_system'] < $System || 1 > $System) {
				throw new Exception("Try to create a planet at position: ".$Galaxy.":".$System.":".$Position);
			}	
			
			if ($CONF['max_planets'] < $Position || 1 > $Position) {
				throw new Exception("Try to create a planet at position: ".$Galaxy.":".$System.":".$Position);
			}
			
			if (!self::isPositionFree($Universe, $Galaxy, $System, $Position)) {
				throw new Exception("Position is not empty: ".$Galaxy.":".$System.":".$Position);
			}
		} else {
			$Galaxy	= $CONF['LastSettedGalaxyPos'];
			$System = $CONF['LastSettedSystemPos'];
			$Planet	= $CONF['LastSettedPlanetPos'];
			
			do {
				$Position = mt_rand(round($CONF['max_planets'] * 0.2), round($CONF['max_planets'] * 0.8));
				if ($Planet < 3) {
					$Planet += 1;
				} else {
					if ($System >= $CONF['max_system']) {
						$System = 1;
						if($Galaxy >= $CONF['max_galaxy']) {
							$Galaxy	= 1;
						} else {
							$Galaxy += 1;
						}
					} else {
						$System += 1;
					}
				}
			} while (self::isPositionFree($Universe, $Galaxy, $System, $Position) === false);
			
			Config::update(array(
				'LastSettedGalaxyPos'	=> $Galaxy,
				'LastSettedSystemPos'	=> $System,
				'LastSettedPlanetPos'	=> $Planet,
			));
		}
		
		$SQL = "INSERT INTO ".USERS." SET
		username		= '".$GLOBALS['DATABASE']->escape($UserName)."',
		email			= '".$GLOBALS['DATABASE']->escape($UserMail)."',
		email_2			= '".$GLOBALS['DATABASE']->escape($UserMail)."',
		authlevel		= ".$authlevel.",
		universe		= ".$Universe.",
		lang			= '".$UserLang."',
		ip_at_reg		= '".(!empty($UserIP) ? $UserIP : $_SERVER['REMOTE_ADDR'])."',
		onlinetime		= ".TIMESTAMP.",
		register_time	= ".TIMESTAMP.",
		password		= '".$UserPass."',
		dpath			= '".DEFAULT_THEME."',
		timezone		= '".$CONF['timezone']."',
		uctime			= 0";
		
		foreach($GLOBALS['reslist']['resstype'][3] as $elementID) {
			$SQL	.= ", ".$GLOBALS['resource'][$elementID]." = ".$CONF[$GLOBALS['resource'][$elementID].'_start'];
		}
		
		$GLOBALS['DATABASE']->query($SQL);
		
		$userID		= $GLOBALS['DATABASE']->GetInsertID();
		$planetID	= self::createPlanet($Galaxy, $System, $Position, $Universe, $userID, $planetname, true, $authlevel);
				
		$currentUserAmount	= $CONF['users_amount'] + 1;
	
		Config::update(array(
			'users_amount'	=> $currentUserAmount + 1,
		));
		
		$SQL = "UPDATE ".USERS." SET 
				galaxy = ".$Galaxy.", 
				system = ".$System.", 
				planet = ".$Position.",
				id_planet  = ".$planetID."
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
		
		return array($userID, $planetID);
	}
	
	static function createPlanet($Galaxy, $System, $Position, $Universe, $PlanetOwnerID, $PlanetName = NULL, $HomeWorld = false, $authlevel = 0)
	{
		$CONF	= Config::getAll(NULL, $Universe);
		
		if ($CONF['max_galaxy'] < $Galaxy || 1 > $Galaxy) {
			throw new Exception("Try to create a planet at position: ".$Galaxy.":".$System.":".$Position);
		}	
		
		if ($CONF['max_system'] < $System || 1 > $System) {
			throw new Exception("Try to create a planet at position: ".$Galaxy.":".$System.":".$Position);
		}	
		
		if ($CONF['max_planets'] < $Position || 1 > $Position) {
			throw new Exception("Try to create a planet at position: ".$Galaxy.":".$System.":".$Position);
		}
		
		if (!self::isPositionFree($Universe, $Galaxy, $System, $Position)) {
			throw new Exception("Position is not empty: ".$Galaxy.":".$System.":".$Position);
		}
		
		require(ROOT_PATH.'includes/PlanetData.php');
		
		$Pos                = ceil($Position / ($CONF['max_planets'] / count($PlanetData))); 
		$TMax				= $PlanetData[$Pos]['temp'];
		$TMin				= $TMax - 40;
		
		if($HomeWorld) {
			$Fields				= $CONF['initial_fields'];
		} else {
			$Fields				= floor($PlanetData[$Pos]['fields'] * $CONF['planet_factor']);
		}
		
		$Types				= array_keys($PlanetData[$Pos]['image']);
		$Type				= $Types[array_rand($Types)];
		$Class				= $Type.'planet'.($PlanetData[$Pos]['image'][$Type] < 10 ? '0' : '').$PlanetData[$Pos]['image'][$Type];
		
		if(empty($PlanetName))
		{
			if($HomeWorld) {
				$PlanetName	= t('fcm_mainplanet');
			} else {
				$PlanetName	= t('fcp_colony');
			}
		}
	
		$SQL	= "INSERT INTO ".PLANETS." SET
				   name = '".$GLOBALS['DATABASE']->escape($PlanetName)."',
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
		
		
		foreach($GLOBALS['reslist']['resstype'][1] as $elementID) {
			$SQL	.= ", ".$GLOBALS['resource'][$elementID]." = ".$CONF[$GLOBALS['resource'][$elementID].'_start'];
		}
		
		$GLOBALS['DATABASE']->query($SQL);
		return $GLOBALS['DATABASE']->GetInsertID();
	}
	
	static function createMoon($Universe, $Galaxy, $System, $Position, $userID, $Chance, $Size = NULL)
	{
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
			$memberCount =  $GLOBALS['DATABASE']->getFirstCell("SELECT ally_members FROM ".ALLIANCE." WHERE id = ".$userData['ally_id'].";");
			
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
	
	static function maxPlanetCount($USER, $PLANET)
	{
		global $resource;
		$CONF	= Config::getAll('universe', $USER['universe']);
		
		if(empty($CONF['max_player_planets']))
		{
			return 0;
		}

		// http://owiki.de/index.php/Astrophysik#.C3.9Cbersicht
		return min($CONF['min_player_planets'] + ceil($USER[$resource[124]] / 2) * PLANETS_PER_TECH * $USER['factor']['Planets'], $CONF['max_player_planets']);
	}

	static function allowPlanetPosition($planetPosition)
	{
		// http://owiki.de/index.php/Astrophysik#.C3.9Cbersicht
		
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

	static function sendMessage($userID, $senderID, $senderName, $messageType, $subject, $text, $time, $parentID = NULL, $hasRead = 0, $universe = NULL)
	{
		$SQL	= "INSERT INTO ".MESSAGES." SET 
				   parentMessageID	= ".(empty($parentID) ? "messageID" : $parentID).",
				   senderID			= ".$senderID.",
				   senderName		= '".$GLOBALS['DATABASE']->escape($senderName)."',
				   userID			= ".$userID.",
				   time				= ".$time.",
				   messageType		= ".$messageType.",
				   subject			= '".$GLOBALS['DATABASE']->escape($subject)."',
				   text				= '".$GLOBALS['DATABASE']->escape($text)."',
				   hasRead			= ".$hasRead.",
				   universe			= ".Globals::getUni().";";
		
		$GLOBALS['DATABASE']->query($SQL);
	}
}