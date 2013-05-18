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
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class MissionCaseMIP extends MissionFunctions implements Mission
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		global $resource, $reslist;

		$db	= Database::get();

		$sqlFields	= array();
		$elementIDs	= array_merge($reslist['defense'], $reslist['missile']);

		foreach($elementIDs as $elementID)
		{
			$sqlFields[]	= '%%PLANETS%%.`'.$resource[$elementID].'`';
		}
			
		$sql = 'SELECT lang, shield_tech,
		%%PLANETS%%.id, name, id_owner, '.implode(', ', $sqlFields).'
		FROM %%PLANETS%%
		INNER JOIN %%USERS%% ON id_owner = %%PLANETS%%.id
		WHERE %%PLANETS%%.id = :planetId;';

		$targetData	= $db->selectSingle($sql, array(
			':planetId'	=> $this->_fleet['fleet_end_id']
		));

		if($this->_fleet['fleet_end_type'] == 3)
		{
			$sql	= 'SELECT '.$resource[502].' FROM %%PLANETS%% WHERE id_luna = :moonId;';
			$targetData[$resource[502]]	= $db->selectSingle($sql, array(
				':moonId'	=> $this->_fleet['fleet_end_id']
			), $resource[502]);
		}

		$sql		= 'SELECT lang, military_tech FROM %%USERS% WHERE id = :userId;';
		$senderData	= $db->selectSingle($sql, array(
			':userId'	=> $this->_fleet['fleet_owner']
		));

		if(!in_array($this->_fleet['fleet_target_obj'], $reslist['defense'])
			|| !in_array($this->_fleet['fleet_target_obj'], $reslist['missile'])
			|| $this->_fleet['fleet_target_obj'] == 502
			|| $this->_fleet['fleet_target_obj'] == 0)
		{
			$primaryTarget	= 401;
		}
		else
		{
			$primaryTarget	= $this->_fleet['fleet_target_obj'];
		}

        $targetDefensive    = array();

		foreach($elementIDs as $elementID)	
		{
			$targetDefensive[$elementID]	= $targetData[$resource[$elementID]];
		}
		
		unset($targetDefensive[502]);

		$LNG	= $this->getLanguage(Config::get($this->_fleet['fleet_universe'])->lang, array('L18N', 'FLEET', 'TECH'));
				
		if ($targetData[$resource[502]] >= $this->_fleet['fleet_amount'])
		{
			$message 	= $LNG['sys_irak_no_att'];
			$where 		= $this->_fleet['fleet_end_type'] == 3 ? 'id_luna' : 'id';
			
			$sql		= 'UPDATE %%PLANETS%% SET '.$resource[502].' = '.$resource[502].' - :amount WHERE '.$where.' = :planetId;';

			$db->update($sql, array(
				':amount'	=> $this->_fleet['fleet_amount'],
				':planetId'	=> $targetData['id']
			));
		}
		else
		{
			if ($targetData[$resource[502]] > 0)
			{
				$where 	= $this->_fleet['fleet_end_type'] == 3 ? 'id_luna' : 'id';
				$sql	= 'UPDATE %%PLANETS%% SET '.$resource[502].' = :amount WHERE '.$where.' = :planetId;';

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
					$this->_fleet['fleet_amount'], $targetDefensive, $primaryTarget, $targetData[$resource[502]]);

				$result		= array_filter($result);
				
				$message	= sprintf($LNG['sys_irak_def'], $targetData[$resource[502]]).'<br><br>';
				
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
			':planetId'	=> $this->_fleet['fleet_start_id'],
		), 'name');

		$ownerLink			= $planetName." ".GetStartAdressLink($this->_fleet);
		$targetLink 		= $targetData['name']." ".GetTargetAdressLink($this->_fleet);
		$message			= sprintf($LNG['sys_irak_mess'], $this->_fleet['fleet_amount'], $ownerLink, $targetLink).$message;

		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_mess_tower'], 3,
			$LNG['sys_irak_subject'], $message, $this->_fleet['fleet_start_time'], NULL, 1, $this->_fleet['fleet_universe']);

		PlayerUtil::sendMessage($this->_fleet['fleet_target_owner'], 0, $LNG['sys_mess_tower'], 3,
			$LNG['sys_irak_subject'], $message, $this->_fleet['fleet_start_time'], NULL, 1, $this->_fleet['fleet_universe']);

		$this->KillFleet();
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		return;
	}
}
