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
 * @version 2.0.$Revision$ (2012-11-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowQuickEditorPage()
{
	global $USER, $LNG, $reslist, $resource;
	$action	= HTTP::_GP('action', '');
	$edit	= HTTP::_GP('edit', '');
	$id 	= HTTP::_GP('id', 0);
	
	switch($edit)
	{
		case 'planet':
			$elementIDs		= array_merge($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE], $GLOBALS['VARS']['LIST'][ELEMENT_BUILD], $GLOBALS['VARS']['LIST'][ELEMENT_FLEET], $GLOBALS['VARS']['LIST'][ELEMENT_DEFENSIVE]);
			
			$querySelect	= '';
			
			foreach($elementIDs as $elementID)
			{
				$querySelect	.= 'p.'.$GLOBALS['VARS']['ELEMENT'][$elementID]['name'].',';
			}
			
			$planetData	= $GLOBALS['DATABASE']->getFirstRow("SELECT u.username, u.id as userid, ".$querySelect." p.name, p.id_owner, p.planet_type, p.galaxy, p.system, p.planet, p.destruyed, p.diameter, p.field_current, p.field_max, p.temp_min, p.temp_max FROM ".PLANETS." p INNER JOIN ".USERS." u ON u.id = p.id_owner WHERE p.id = ".$id.";");
			
			$planetFlag	= $planetData['planet_type'] == 3 ? ELEMENT_BUILD_ON_MOON : ELEMENT_BUILD_ON_PLANET;
			
			if($action == 'send')
			{
				$currentFields	= $planetData['field_current'];
				$maxFields		= HTTP::_GP('field_max', 0);
				$minTempature	= HTTP::_GP('temp_min', 0);
				$maxTempature	= HTTP::_GP('temp_max', 0);
				
				$oldValue	= array();
				$newValue	= array();
				
				$SQL	= "UPDATE ".PLANETS." SET ";
								
				foreach($elementIDs as $elementID)
				{
					if(!elementHasFlag($elementID, $planetFlag) && !elementHasFlag($elementID, ELEMENT_PLANET_RESOURCE)) {
						continue;
					}
					
					$oldLevel	= $planetData[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
					$newLevel	= max(0, round(HTTP::_GP($GLOBALS['VARS']['ELEMENT'][$elementID]['name'], 0.0)));
					
					$oldValue[$elementID]	= $oldLevel;
					$newValue[$elementID]	= $newLevel;
					
					if(elementHasFlag($elementID, $planetFlag)) {
						$currentFields	+= $newLevel - $oldLevel;
					}
					
					$SQL	.= $GLOBALS['VARS']['ELEMENT'][$elementID]['name']." = ".$newLevel.", ";
				}
				
				$SQL	.= "field_current = ".$currentFields.", ";
				$SQL	.= "field_max = ".$maxFields.", ";
				$SQL	.= "temp_min = ".$minTempature.", ";
				$SQL	.= "temp_max = ".$maxTempature.", ";
				$SQL	.= "name = '".$GLOBALS['DATABASE']->escape(HTTP::_GP('name', '', UTF8_SUPPORT))."', ";
				$SQL	.= "eco_hash = '' ";
				$SQL	.= "WHERE id = ".$id." AND universe = '".$_SESSION['adminuni']."';";
					
				$GLOBALS['DATABASE']->query($SQL);
				
				$oldValue['field_max'] = $planetData['field_max'];
				$newValue['field_max'] = $maxFields;
				$oldValue['temp_min'] = $planetData['temp_min'];
				$newValue['temp_min'] = $minTempature;
				$oldValue['temp_max'] = $planetData['temp_max'];
				$newValue['temp_max'] = $maxTempature;
				
				$LOG = new Log();
				$LOG->setMode(Log::PLANET)
					->setTarget($id)
					->setOldData($old)
					->setNewData($new)
					->save();
		
				exit(sprintf($LNG['qe_edit_planet_sucess'], $planetData['name'], $planetData['galaxy'], $planetData['system'], $planetData['planet']));
			}
			
			$elementData	= array();
			
			foreach($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $elementID)
			{
				$elementData[900][$elementID] = $GLOBALS['VARS']['ELEMENT'][$elementID]['name'];
			}
			
			foreach($GLOBALS['VARS']['LIST'][$planetFlag] as $elementID)
			{
				if(elementHasFlag($elementID, ELEMENT_BUILD)) {
					$list	= 0;
				} elseif(elementHasFlag($elementID, ELEMENT_FLEET)) {
					$list	= 200;
				} elseif(elementHasFlag($elementID, ELEMENT_DEFENSIVE)) {
					$list	= 400;
				} else {
					continue;
				}
				
				$elementData[$list][$elementID]	= $GLOBALS['VARS']['ELEMENT'][$elementID]['name'];
			}
			
			$template	= new Template();
			$template->assign(array(	
				'id'			=> $id,
				'elementData'	=> $elementData,
				'planetData'	=> $planetData
			));
			
			$template->show('QuickEditorPlanet.tpl');
		break;
		case 'player':
			$elementIDs	= array_merge($reslist['tech'], $reslist['officier']);
			foreach($elementIDs as $elementID)
			{
				$querySelect	.= "".$GLOBALS['VARS']['ELEMENT'][$elementID]['name'].",";
			}
			$UserData	= $GLOBALS['DATABASE']->getFirstRow("SELECT ".$querySelect." username, authlevel, galaxy, system, planet, id_planet, darkmatter, authattack, authlevel FROM ".USERS." WHERE id = '".$id."';");
			$ChangePW	= $USER['id'] == ROOT_USER || ($id != ROOT_USER && $USER['authlevel'] > $UserData['authlevel']);
		
			if($action == 'send'){
				$SQL	= "UPDATE ".USERS." SET ";
				foreach($elementIDs as $elementID)
				{
					$SQL	.= "".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']." = '".abs(HTTP::_GP($GLOBALS['VARS']['ELEMENT'][$elementID]['name'], 0))."', ";
				}
				$SQL	.= "darkmatter = '".max(HTTP::_GP('darkmatter', 0), 0)."', ";
				if(!empty($_POST['password']) && $ChangePW)
					$SQL	.= "password = '".PlayerUtil::cryptPassword(HTTP::_GP('password', '', true))."', ";
				$SQL	.= "username = '".$GLOBALS['DATABASE']->escape(HTTP::_GP('name', '', UTF8_SUPPORT))."', ";
				$SQL	.= "authattack = '".($UserData['authlevel'] != AUTH_USR && HTTP::_GP('authattack', '') == 'on' ? $UserData['authlevel'] : 0)."' ";
				$SQL	.= "WHERE id = '".$id."' AND universe = '".$_SESSION['adminuni']."';";
				$GLOBALS['DATABASE']->query($SQL);
				
				$old = array();
				$new = array();
				foreach($elementIDs as $elementIDs)
                {
                    $old[$elementIDs]    = $UserData[$GLOBALS['VARS']['ELEMENT'][$elementIDs]['name']];
                    $new[$elementIDs]    = abs(HTTP::_GP($GLOBALS['VARS']['ELEMENT'][$elementIDs]['name'], 0));
                }
				$old[921]			= $UserData[$GLOBALS['VARS']['ELEMENT'][921]['name']];
				$new[921]			= abs(HTTP::_GP($GLOBALS['VARS']['ELEMENT'][921]['name'], 0));
				$old['username']	= $UserData['username'];
				$new['username']	= $GLOBALS['DATABASE']->escape(HTTP::_GP('name', '', UTF8_SUPPORT));
				$old['authattack']	= $UserData['authattack'];
				$new['authattack']	= ($UserData['authlevel'] != AUTH_USR && HTTP::_GP('authattack', '') == 'on' ? $UserData['authlevel'] : 0);
				
				$LOG = new Log(1);
				$LOG->target = $id;
				$LOG->old = $old;
				$LOG->new = $new;
				$LOG->save();
				
				exit(sprintf($LNG['qe_edit_player_sucess'], $UserData['username'], $id));
			}
			$PlanetInfo				= $GLOBALS['DATABASE']->getFirstRow("SELECT name FROM ".PLANETS." WHERE id = '".$UserData['id_planet']."' AND universe = '".$_SESSION['adminuni']."';");

			$tech		= array();
			$officier	= array();
			
			foreach($reslist['tech'] as $elementID)
			{
				$tech[]	= array(
					'type'	=> $GLOBALS['VARS']['ELEMENT'][$elementID]['name'],
					'name'	=> $LNG['tech'][$elementID],
					'count'	=> pretty_number($UserData[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']]),
					'input'	=> $UserData[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']]
				);
			}
			foreach($reslist['officier'] as $elementID)
			{
				$officier[]	= array(
					'type'	=> $GLOBALS['VARS']['ELEMENT'][$elementID]['name'],
					'name'	=> $LNG['tech'][$elementID],
					'count'	=> pretty_number($UserData[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']]),
					'input'	=> $UserData[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']]
				);
			}

			$template	= new Template();
			$template->assign(array(	
				'tech'			=> $tech,
				'officier'		=> $officier,
				'id'			=> $id,
				'planetid'		=> $UserData['id_planet'],
				'planetname'	=> $PlanetInfo['name'],
				'name'			=> $UserData['username'],
				'galaxy'		=> $UserData['galaxy'],
				'system'		=> $UserData['system'],
				'planet'		=> $UserData['planet'],
				'authlevel'		=> $UserData['authlevel'],
				'authattack'	=> $UserData['authattack'],
				'ChangePW'		=> $ChangePW,
				'darkmatter'	=> floattostring($UserData['darkmatter']),
				'darkmatter_c'	=> pretty_number($UserData['darkmatter']),
			));
			$template->show('QuickEditorUser.tpl');
		break;
	}
}
