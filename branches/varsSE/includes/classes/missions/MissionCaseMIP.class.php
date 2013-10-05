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

		$missileAmount	= array_sum($this->fleetData['elements'][Vars::CLASS_FLEET]);
		
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

		$LNG	= $this->getLanguage(Config::get($this->fleetData['fleet_universe'])->lang);

		$missileAttack	= $missileAmount;

		$updateQuery	= array();

		foreach(Vars::getElements(Vars::CLASS_MISSILE, Vars::FLAG_DEFEND_MISSILE) as $missileElementObj)
		{
			if (empty($targetData[$missileElementObj->name])) continue;

			if ($targetData[$missileElementObj->name] >= $missileAttack)
			{
				$message 	= $LNG['sys_irak_no_att'];
				$where 		= $this->fleetData['fleet_end_type'] == 3 ? 'id_luna' : 'id';

				$sql		= 'UPDATE %%PLANETS%% SET '.$targetData[$missileElementObj->name].' = '.$targetData[$missileElementObj->name].' - :amount WHERE '.$where.' = :planetId;';

				$db->update($sql, array(
					':amount'	=> $missileAmount,
					':planetId'	=> $targetData['id']
				));
			}

			$missileAttack -= $targetData[$missileElementObj->name];
		}


		if(!empty($updateQuery))
		{
			$sql		= 'UPDATE %%PLANETS%% SET '.implode(',', $updateQuery).' WHERE '.$where.' = :planetId;';

			$db->update($sql, array(
				':amount'	=> $missileAmount,
				':planetId'	=> $targetData['id']
			));
		}





		if ($targetData[Vars::getElement(502)->name] >= $missileAmount)
		{
			$message 	= $LNG['sys_irak_no_att'];
			$where 		= $this->fleetData['fleet_end_type'] == 3 ? 'id_luna' : 'id';
			
			$sql		= 'UPDATE %%PLANETS%% SET '.Vars::getElement(502)->name.' = '.Vars::getElement(502)->name.' - :amount WHERE '.$where.' = :planetId;';

			$db->update($sql, array(
				':amount'	=> $missileAmount,
				':planetId'	=> $targetData['id']
			));
		}
		else
		{
			if ($targetData[Vars::getElement(502)->name] > 0)
			{
				$where 	= $this->fleetData['fleet_end_type'] == 3 ? 'id_luna' : 'id';
				$sql	= 'UPDATE %%PLANETS%% SET '.Vars::getElement(502)->name.' = :amount WHERE '.$where.' = :planetId;';

				$db->update($sql, array(
					':amount'	=> 0,
					':planetId'	=> $targetData['id']
				));
			}
			
			$targetDefensive = array_filter($targetDefensive);
			
			if(!empty($targetDefensive))
			{
				require_once 'includes/classes/missions/functions/calculateMIPAttack.php';
				$result   	= calculateMIPAttack($targetData["shield_tech"], $senderData["military_tech"],
					$missileAmount, $targetDefensive, $primaryTarget, $targetData[Vars::getElement(502)->name]);

				$result		= array_filter($result);
				
				$message	= sprintf($LNG['sys_irak_def'], $targetData[Vars::getElement(502)->name]).'<br><br>';
				
				ksort($result, SORT_NUMERIC);
				
				foreach ($result as $Element => $destroy)
				{
					$message .= sprintf('%s (- %d)<br>', $LNG['tech'][$Element], $destroy);

					$sql	= 'UPDATE %%PLANETS%% SET '.$resource[$Element].' = '.$resource[$Element].' - :amount WHERE id = :planetId;';
					$db->update($sql, array(
						':planetId' => $targetData['id'],
						':amount'	=> $destroy
					));
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

		PlayerUtil::sendMessage($this->fleetData['fleet_owner'], 0, $LNG['sys_mess_tower'], 3,
			$LNG['sys_irak_subject'], $message, $this->fleetData['fleet_start_time'], NULL, 1, $this->fleetData['fleet_universe']);

		PlayerUtil::sendMessage($this->fleetData['fleet_target_owner'], 0, $LNG['sys_mess_tower'], 3,
			$LNG['sys_irak_subject'], $message, $this->fleetData['fleet_start_time'], NULL, 1, $this->fleetData['fleet_universe']);

		$this->killFleet();
	}
}
