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
 * @version 1.8.0 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class MissionCaseColonisation extends AbstractMission
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		$db		= Database::get();

		$sql	= 'SELECT * FROM %%USERS%% WHERE `id` = :userId;';

		$senderUser		= $db->selectSingle($sql, array(
			':userId'	=> $this->_fleet['fleet_owner'],
		));

		$senderUser['factor']	= PlayerUtil::getFactors($senderUser, $this->_fleet['fleet_start_time']);

		$LNG	= $this->getLanguage($senderUser['lang']);

		$isPositionFree	= PlayerUtil::checkPosition($this->_fleet['fleet_universe'], $this->_fleet['fleet_end_galaxy'],
			$this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']);

		if (!$isPositionFree)
		{
			$message = sprintf($LNG['sys_colo_notfree'], GetTargetAdressLink($this->_fleet, ''));
		}
		else
		{
			$allowPlanetPosition	= PlayerUtil::allowPlanetPosition($this->_fleet['fleet_end_planet'], $senderUser);
			if(!$allowPlanetPosition)
			{
				$message = sprintf($LNG['sys_colo_notech'] , GetTargetAdressLink($this->_fleet, ''));
			}
			else
			{
				$sql	= 'SELECT COUNT(*) as state
				FROM %%PLANETS%%
				WHERE `id_owner`	= :userId
				AND `planet_type`	= :type
				AND `destroyed`		= :destroyed;';

				$currentPlanetCount	= $db->selectSingle($sql, array(
					':userId'		=> $this->_fleet['fleet_owner'],
					':type'			=> 1,
					':destroyed'	=> 0
				), 'state');

				$maxPlanetCount		= PlayerUtil::maxPlanetCount($senderUser);

				if($currentPlanetCount >= $maxPlanetCount)
				{
					$message = sprintf($LNG['sys_colo_maxcolo'], GetTargetAdressLink($this->_fleet, ''), $maxPlanetCount);
				}
				else
				{
					$NewOwnerPlanet = PlayerUtil::createPlanet($this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'],
						$this->_fleet['fleet_end_planet'], $this->_fleet['fleet_universe'], $this->_fleet['fleet_owner'],
						$LNG['fcp_colony'], false, $senderUser['authlevel']);

					if($NewOwnerPlanet === false)
					{
						$message = sprintf($LNG['sys_colo_badpos'], GetTargetAdressLink($this->_fleet, ''));
						$this->setState(FLEET_RETURN);
					}
					else
					{
						$this->_fleet['fleet_end_id']	= $NewOwnerPlanet;
						$message = sprintf($LNG['sys_colo_allisok'], GetTargetAdressLink($this->_fleet, ''));
						$this->StoreGoodsToPlanet();
						if ($this->_fleet['fleet_amount'] == 1) {
							$this->KillFleet();
						} else {
							$CurrentFleet = explode(";", $this->_fleet['fleet_array']);
							$NewFleet     = '';
							foreach ($CurrentFleet as $Group)
							{
								if (empty($Group)) continue;

								$Class = explode (",", $Group);
								if ($Class[0] == 208 && $Class[1] > 1)
									$NewFleet  .= $Class[0].",".($Class[1] - 1).";";
								elseif ($Class[0] != 208 && $Class[1] > 0)
									$NewFleet  .= $Class[0].",".$Class[1].";";
							}

							$this->UpdateFleet('fleet_array', $NewFleet);
							$this->UpdateFleet('fleet_amount', ($this->_fleet['fleet_amount'] - 1));
							$this->UpdateFleet('fleet_resource_metal', 0);
							$this->UpdateFleet('fleet_resource_crystal', 0);
							$this->UpdateFleet('fleet_resource_deuterium', 0);
						}
					}
				}
			}
		}

		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_colo_mess_from'], 4, $LNG['sys_colo_mess_report'],
			$message, $this->_fleet['fleet_start_time'], NULL, 1, $this->_fleet['fleet_universe']);

		$this->setState(FLEET_RETURN);
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