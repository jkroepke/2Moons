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

class ShowAccountPage extends AbstractPage
{
	function __construct() 
	{
		parent::__construct();
	}
	
	function show()
	{
		global $ADMINUNI;
		$userResult	= $GLOBALS['DATABASE']->query("SELECT id, username, authlevel FROM ".USERS." WHERE universe = ".$ADMINUNI." ORDER BY username;");

		$userList	= array();
		
		while($userRow = $GLOBALS['DATABASE']->fetchArray($userResult))
		{
			$userList[$userRow['id']]	= array(
				'username'	=> $userRow['username'],
				'authlevel'	=> $userRow['authlevel'],
			);
		}
		
		$this->assign(array(
			'userList'	=> $userList
		));
		
		$this->render('page.account.default.tpl');
	}
	
	function detailUser()
	{
		global $ADMINUNI;
		
		$infoUserID	= HTTP::_GP('id', 0);
		
		$infoUser	= $GLOBALS['DATABASE']->getFirstRow("SELECT * FROM ".USERS." WHERE id = ".$infoUserID." AND universe = ".$ADMINUNI.";");
		
		$infoUserList	= $infoUser;
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_TECH] as $elementID)
		{
			$infoUserList[100][$elementID]	= $infoUser[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
		}
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_OFFICIER] as $elementID)
		{
			$infoUserList[600][$elementID]	= $infoUser[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
		}
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_PREMIUM] as $elementID)
		{
			$infoUserList[700][$elementID]	= $infoUser[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
		}
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE] as $elementID)
		{
			$infoUserList[900][$elementID]	= $infoUser[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
		}	
		
		$infoPlanet = $GLOBALS['DATABASE']->query("SELECT * FROM ".PLANETS." WHERE id_owner = ".$infoUserID." AND universe = ".$ADMINUNI." ORDER BY planet_type ASC;");

        $infoPlanetList		= array();
		$infoPlanetRowList	= array();
		
		while($infoPlanetRow = $GLOBALS['DATABASE']->fetchArray($infoPlanet))
		{
			$infoPlanetRowList[]	= $infoPlanetRow;
		}
			
		$elementIDs	= array_keys($GLOBALS['VARS']['ELEMENT']);

		foreach($infoPlanetRowList as $infoPlanetRow)
		{
			$planetID														= $infoPlanetRow['id'];
			$planetType														= $infoPlanetRow['planet_type'];
			$infoPlanetList[$planetType][$planetID]['name']					= $infoPlanetRow['name'];
			$infoPlanetList[$planetType][$planetID]['image']				= $infoPlanetRow['image'];
			
			$infoPlanetList[$planetType][$planetID]['galaxy']				= $infoPlanetRow['galaxy'];
			$infoPlanetList[$planetType][$planetID]['system']				= $infoPlanetRow['system'];
			$infoPlanetList[$planetType][$planetID]['planet']				= $infoPlanetRow['planet'];
			
			$infoPlanetList[$planetType][$planetID]['field']['current']		= $infoPlanetRow['field_current'];
			$infoPlanetList[$planetType][$planetID]['field']['max']			= $infoPlanetRow['field_max'];
			$infoPlanetList[$planetType][$planetID]['field']['maxBonus']	= CalculateMaxPlanetFields($infoPlanetRow);
			
			$infoPlanetList[$planetType][$planetID]['temp']['min']			= $infoPlanetRow['temp_min'];
			$infoPlanetList[$planetType][$planetID]['temp']['max']			= $infoPlanetRow['temp_max'];
			
			$infoPlanetList[$planetType][$planetID]['energy_used']			= $infoPlanetRow['energy'] + $infoPlanetRow['energy_used'];
			
			foreach($elementIDs as $elementID)
			{
				if(elementHasFlag($elementID, ELEMENT_PLANET_RESOURCE) || elementHasFlag($elementID, ELEMENT_ENERGY))
				{
					$list	= 900;
				} elseif(elementHasFlag($elementID, ELEMENT_BUILD)) {
					$list	= 0;
				} elseif(elementHasFlag($elementID, ELEMENT_FLEET)) {
					$list	= 200;
				} elseif(elementHasFlag($elementID, ELEMENT_DEFENSIVE)) {
					$list	= 400;
				} else {
					continue;
				}
				
				$infoPlanetList[$planetType][$planetID][$list][$elementID]	= $infoPlanetRow[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
			}
		}
		
		$this->assign(array(
			'infoPlanetList'	=> $infoPlanetList,
			'infoUserList'		=> $infoUserList,
		));

		$this->render('page.account.detailUser.tpl');
	}
	
	function updateUser()
	{
		global $ADMINUNI, $LNG;
		$userID		= HTTP::_GP('id', 0);
		$update		= HTTP::_GP('update', array());
		
		foreach($update as $section => $updateArray)
		{
			switch($section)
			{
				case 'tech':
					$planetID	= (int) key($updateArray);
					$elementID	= (int) key($updateArray[$planetID]);
					$techCount	= $updateArray[$planetID][$elementID];
					
					if(elementHasFlag($elementID, ELEMENT_BUILD) || elementHasFlag($elementID, ELEMENT_TECH) || elementHasFlag($elementID, ELEMENT_OFFICIER))
					{
						$techCount	= max(min($techCount, 255), 0);
					}
					elseif(elementHasFlag($elementID, ELEMENT_FLEET) || elementHasFlag($elementID, ELEMENT_DEFENSIVE))
					{
						$techCount	= max(min($techCount, 18446744073709551615), 0);
					}
					elseif(elementHasFlag($elementID, ELEMENT_PREMIUM))
					{
						$techCount	= max(min($techCount, 2147483647), 0);
					}
					elseif(elementHasFlag($elementID, ELEMENT_USER_RESOURCE) || elementHasFlag($elementID, ELEMENT_PLANET_RESOURCE))
					{
						$techCount	= max(min($techCount, 500000000000000000000000000000000000000000000000000), 0);
					}
					else
					{
						$this->sendJSON(array('message' => ''));
					}
					
					#try {
						if(elementHasFlag($elementID, ELEMENT_TECH) || elementHasFlag($elementID, ELEMENT_OFFICIER) || elementHasFlag($elementID, ELEMENT_PREMIUM) || elementHasFlag($elementID, ELEMENT_USER_RESOURCE))
						{
							$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET ".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']." = ".$techCount." WHERE id = ".$userID." AND universe = ".$ADMINUNI.";");
						}
						elseif(elementHasFlag($elementID, ELEMENT_FLEET) || elementHasFlag($elementID, ELEMENT_DEFENSIVE) || elementHasFlag($elementID, ELEMENT_PLANET_RESOURCE))
						{
							$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']." = ".$techCount." WHERE id = ".$planetID." AND id_owner = ".$userID." AND universe = ".$ADMINUNI.";");
						}
						elseif(elementHasFlag($elementID, ELEMENT_BUILD))
						{
							$fielsCurrent	= $GLOBALS['DATABASE']->countquery("SELECT ".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']." FROM ".PLANETS." WHERE id = ".$planetID." AND id_owner = ".$userID." AND universe = ".$ADMINUNI.";");
							$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']." = ".$techCount.", field_current = field_current + ".max(0, $techCount - $fielsCurrent)." WHERE id = ".((int) $planetID)." AND id_owner = ".$userID." AND universe = ".$ADMINUNI.";");
						}
						
						$this->sendJSON(array('message' => $LNG['ed_saved'], 'count' => floattostring($techCount)));
					#} catch (Exception $e) {
					#	$this->sendJSON(array('message' => "SQL Error!", 'count' => $updateArray[$planetID][$elementID]));
					#}
				break;
				case 'planet':
					$allowedToChance	= array('name', 'field_max', 'temp_min', 'temp_max', 'name');
					$planetID			= (int) key($updateArray);
					$key				= key($updateArray[$planetID]);
					$value				= $updateArray[$planetID][$key];
					
					if(!in_array($key, $allowedToChance))
					{
						return false;
					}
					
					switch($key)
					{
						case 'temp_min':
						case 'temp_max':
							$value	= max(min($value, 32767), -32768);
						break;
						case 'field_max':
							$value	= max(min($value, 65535), 0);
						break;
						case 'name':		
							if(!PlayerUtil::isNameValid($value)) {
								$this->sendJSON(array('message' => $LNG['user_field_specialchar'], 'count' => $value));
							}
						break;
					}
					
					try {
						$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".$GLOBALS['DATABASE']->escape($key)." = '".$GLOBALS['DATABASE']->escape($value)."' WHERE id = ".$planetID." AND id_owner = ".$userID." AND universe = ".$ADMINUNI.";");
						$this->sendJSON(array('message' => $LNG['ed_saved'], 'count' => $value));
					} catch (Exception $e) {
						$this->sendJSON(array('message' => 'SQL Error!', 'count' => $value));
					}
				break;
			}
		}
	}
}