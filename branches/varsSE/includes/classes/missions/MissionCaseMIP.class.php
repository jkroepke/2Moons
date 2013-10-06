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

class MissionCaseMIP extends AbstractMission
{
	public function arrivalEndTargetEvent()
	{
		$db	= Database::get();

		$sqlFields	= array();
		$elements	= Vars::getElements(Vars::CLASS_DEFENSE) + Vars::getElements(Vars::CLASS_FLEET);

		$missileData	= $this->fleetData['elements'][Vars::CLASS_FLEET];
		$missileAmount	= array_sum($missileData);

		foreach($elements as $elementObj)
		{
			$sqlFields[]	= '%%PLANETS%%.`'.$elementObj->name.'`';
		}
			
		$sql = 'SELECT lang, shield_tech,
		%%PLANETS%%.id, name, id_owner, '.implode(', ', $sqlFields).'
		FROM %%PLANETS%%
		INNER JOIN %%USERS%% ON id_owner = %%PLANETS%%.id
		WHERE %%PLANETS%%.id = :planetId;';

		$targetData	= $db->selectSingle($sql, array(
			':planetId'	=> $this->fleetData['fleet_end_id']
		));

		if($this->fleetData['fleet_end_type'] == 3)
		{
			$sqlFields	= array();

			foreach(Vars::getElements(Vars::CLASS_MISSILE, Vars::FLAG_DEFEND_MISSILE) as $missileElementObj)
			{
				$sqlFields[]	= $missileElementObj->name;
			}

			if(!empty($sqlFields))
			{
				$sql	= 'SELECT '.implode(', ', $sqlFields).' FROM %%PLANETS%% WHERE id_luna = :moonId;';
				$targetData	= $db->selectSingle($sql, array(
					':moonId'	=> $this->fleetData['fleet_end_id']
				)) + $targetData;
			}
		}

		$sql		= 'SELECT lang, military_tech FROM %%USERS%% WHERE id = :userId;';
		$senderData	= $db->selectSingle($sql, array(
			':userId'	=> $this->fleetData['fleet_owner']
		));

		if($this->fleetData['fleet_target_obj'] == 0)
		{
			$primaryTarget	= key($elements);
		}
		else
		{
			$primaryTarget	= $this->fleetData['fleet_target_obj'];
		}

        $targetDefensive    = array();

		foreach($elements as $elementId => $elementObj)
		{
			$targetDefensive[$elementId]	= $targetData[$elementObj->name];
		}

		foreach(array_keys(Vars::getElements(Vars::CLASS_MISSILE, Vars::FLAG_DEFEND_MISSILE)) as $missileElementId)
		{
			unset($targetDefensive[$missileElementId]);
		}

		$updateQuery	= array();
		$param			= array(
			':planetId'	=> $targetData['id']
		);

		foreach(Vars::getElements(Vars::CLASS_MISSILE, Vars::FLAG_DEFEND_MISSILE) as $missileElementObj)
		{
			if (empty($targetData[$missileElementObj->name])) continue;

			$missileDestroyed	= 0;

			foreach($targetData as $attackElementId => $value)
			{
				if (empty($value)) continue;

				$missileDestroyed	+= min($missileData[$attackElementId], $targetData[$missileElementObj->name]);

				$missileData[$attackElementId]	-= $missileDestroyed;
				$missileAmount 					-= $missileDestroyed;

				if($missileAmount <= 0) break 2;
			}

			$updateQuery[]		= sprintf('%1$s = %1$s - :%1$s', $missileElementObj->name);
			$param[':'.$missileElementObj->name]	= $missileDestroyed;
		}

		if(!empty($updateQuery))
		{
			$where 		= $this->fleetData['fleet_end_type'] == 3 ? 'id_luna' : 'id';
			$sql		= 'UPDATE %%PLANETS%% SET '.implode(',', $updateQuery).' WHERE '.$where.' = :planetId;';

			$db->update($sql, $param);
		}

		$LNG	= $this->getLanguage($targetData->lang);

		if ($missileAmount <= 0)
		{
			$message 	= $LNG['sys_irak_no_att'];
		}
		else
		{
			$targetDefensive = array_filter($targetDefensive);
			
			if(!empty($targetDefensive))
			{
				require_once 'includes/classes/missions/functions/calculateMIPAttack.php';
				$result   	= calculateMIPAttack($targetData["shield_tech"], $senderData["military_tech"],
					$missileData, $targetDefensive, $primaryTarget);

				$result		= array_filter($result);

				$message	= sprintf($LNG['sys_irak_def'], abs($missileAmount - array_sum($missileData))).'<br><br>';

				ksort($result, SORT_NUMERIC);


				$updateQuery	= array();
				$param			= array(
					':planetId' => $targetData['id'],
				);

				foreach ($result as $elementId => $value)
				{
					$message .= sprintf('%s (- %d)<br>', $LNG['tech'][$elementId], $value);

					$elementName	= Vars::getElement($elementId)->name;
					$updateQuery[]	= sprintf('%1$s = %1$s - :%1$s', $elementName);
					$param[':'.$elementName]	= $value;
				}

				if(!empty($updateQuery))
				{
					$sql	= 'UPDATE %%PLANETS%% SET '.implode(',', $updateQuery).' WHERE id = :planetId;';
					$db->update($sql, $param);
				}
			}
			else
			{
				$message = $LNG['sys_irak_no_def'];
			}
		}

		$sql		= 'SELECT name FROM %%PLANETS%% WHERE id = :planetId;';
		$planetName	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->fleetData['fleet_start_id'],
		), 'name');

		$ownerLink			= $planetName." ".GetStartAdressLink($this->fleetData);
		$targetLink 		= $targetData['name']." ".GetTargetAdressLink($this->fleetData);
		$message			= sprintf($LNG['sys_irak_mess'], $missileAmount, $ownerLink, $targetLink).$message;

		PlayerUtil::sendMessage($this->fleetData['fleet_target_owner'], 0, $LNG['sys_mess_tower'], 3,
			$LNG['sys_irak_subject'], $message, $this->fleetData['fleet_start_time'], NULL, 1, $this->fleetData['fleet_universe']);

		$this->killFleet();
	}
}
