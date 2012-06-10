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

class MissionCaseColonisation extends MissionFunctions
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{	
		global $LANG;
		
		$userData		= $GLOBALS['DATABASE']->getFirstRow("SELECT lang, authlevel, ".$GLOBALS['VARS']['ELEMENT'][124]['name'].", COUNT(p.id) as planetCount
															 FROM ".USERS." u
															 INNER JOIN ".PLANETS." p ON p.id_owner = u.id
															 WHERE u.id = '".$this->_fleet['fleet_owner']."'
															 GROUP BY p.id_owner;");
		
		$MaxPlanets		= PlayerUtil::maxPlanetCount($userData, $this->_fleet['fleet_universe']);
		
		$LNG			= $LANG->GetUserLang($userData['lang']);
		
		if (PlayerUtil::isPositionFree($this->_fleet['fleet_universe'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']))
		{
			$TheMessage = sprintf($LNG['sys_colo_notfree'], GetTargetAdressLink($this->_fleet));
			$this->setState(FLEET_RETURN);
		}
		elseif(!empty($MaxPlanets) && $userData['planetCount'] >= $MaxPlanets)
		{
			$TheMessage = sprintf($LNG['sys_colo_maxcolo'] , GetTargetAdressLink($this->_fleet), $MaxPlanets);
			$this->setState(FLEET_RETURN);
		}
		else
		{
			$NewOwnerPlanet = PlayerUtil::createPlanet($this->_fleet['fleet_universe'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet'], $this->_fleet['fleet_owner'], NULL, false, $userData['authlevel']);
			
			if($NewOwnerPlanet === false)
			{
				$TheMessage = sprintf($LNG['sys_colo_badpos'], GetTargetAdressLink($this->_fleet));
				$this->setState(FLEET_RETURN);
			}
			else
			{
				$this->_fleet['fleet_end_id']	= $NewOwnerPlanet;
				$TheMessage = sprintf($LNG['sys_colo_allisok'], GetTargetAdressLink($this->_fleet));
				$this->StoreGoodsToPlanet();
				if ($this->_fleet['fleet_amount'] == 1) 
				{
					$this->KillFleet();
				}
				else
				{
					$CurrentFleet = explode(";", $this->_fleet['fleet_array']);
					$NewFleet     = '';
					
					foreach ($CurrentFleet as $Item => $Group)
					{
						if (empty($Group))
						{
							continue;
						}
						
						$Class = explode (",", $Group);
						if ($Class[0] == 208 && $Class[1] > 1)
						{
							$NewFleet  .= $Class[0].",".($Class[1] - 1).";";
						}
						elseif ($Class[0] != 208 && $Class[1] > 0)
						{
							$NewFleet  .= $Class[0].",".$Class[1].";";
						}
					}
					
					$this->UpdateFleet('fleet_array', $NewFleet);
					$this->UpdateFleet('fleet_amount', ($this->_fleet['fleet_amount'] - 1));
					$this->clearResource();
					$this->setState(FLEET_RETURN);
				}
			}
		}
		SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_start_time'], 4, $LNG['sys_colo_mess_from'], $LNG['sys_colo_mess_report'], $TheMessage);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		$this->RestoreFleet();
	}
}
