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


class ShowInformationPage extends AbstractGamePage
{
	public static $requireModule = MODULE_INFORMATION;

	protected $disableEcoSystem = true;

	function __construct()
	{
		parent::__construct();
	}

	static function getNextJumpWaitTime($lastTime)
	{
		return $lastTime + Config::get()->gate_wait_time;
	}

	public function sendFleet()
	{
		global $PLANET, $USER, $resource, $LNG, $reslist;

		$db = Database::get();

		$NextJumpTime = self::getNextJumpWaitTime($PLANET['last_jump_time']);

		if (TIMESTAMP < $NextJumpTime)
		{
			$this->sendJSON(array(
				'message'	=> $LNG['in_jump_gate_already_used'].' '.pretty_time($NextJumpTime - TIMESTAMP),
				'error'		=> true
			));
		}

		$TargetPlanet = HTTP::_GP('jmpto', (int) $PLANET['id']);

		$sql = "SELECT id, last_jump_time FROM %%PLANETS%% WHERE id = :targetID AND id_owner = :userID AND sprungtor > 0;";
		$TargetGate = $db->selectSingle($sql, array(
			':targetID' => $TargetPlanet,
			':userID'   => $USER['id']
		));

		if (!isset($TargetGate) || $TargetPlanet == $PLANET['id'])
		{
			$this->sendJSON(array(
				'message' => $LNG['in_jump_gate_doesnt_have_one'],
				'error' => true
			));
		}

		$NextJumpTime   = self::getNextJumpWaitTime($TargetGate['last_jump_time']);

		if (TIMESTAMP < $NextJumpTime)
		{
			$this->sendJSON(array(
				'message' => $LNG['in_jump_gate_not_ready_target'].' '.pretty_time($NextJumpTime - TIMESTAMP),
				'error' => true
			));
		}

		$ShipArray		= array();
		$SubQueryOri	= "";
		$SubQueryDes	= "";
		$Ships			= HTTP::_GP('ship', array());
		$SubQueryParams = array();

		foreach($reslist['fleet'] as $Ship)
		{
			if(!isset($Ships[$Ship]) || $Ship == 212)
				continue;

			$ShipArray[$Ship]	= max(0, min($Ships[$Ship], $PLANET[$resource[$Ship]]));

			if(empty($ShipArray[$Ship]))
				continue;

			$SubQueryOri 		.= $resource[$Ship]." = ".$resource[$Ship]." - :".$resource[$Ship].", ";
			$SubQueryDes 		.= $resource[$Ship]." = ".$resource[$Ship]." + :".$resource[$Ship].", ";
			$SubQueryParams[':'.$resource[$Ship]]    = $ShipArray[$Ship];
			$PLANET[$resource[$Ship]] -= $ShipArray[$Ship];
		}

		if (empty($SubQueryOri))
		{
			$this->sendJSON(array(
				'message' => $LNG['in_jump_gate_error_data'],
				'error' => true
			));
		}

		$sql  = "UPDATE %%PLANETS%% SET :subquery last_jump_time = :jumptime WHERE id = :planetID;";
		$db->update($sql, array_merge(array(
			':planetID' => $PLANET['id'],
			':jumptime' => TIMESTAMP,
			':subquery' => $SubQueryOri
		), $SubQueryParams));

		$sql  = "UPDATE %%PLANETS%% SET :subquery last_jump_time = :jumptime WHERE id = :targetID;";
		$db->update($sql, array_merge(array(
			':targetID' => $TargetPlanet,
			':jumptime' => TIMESTAMP,
			':subquery' => $SubQueryDes
		), $SubQueryParams));

		$PLANET['last_jump_time'] 	= TIMESTAMP;
		$NextJumpTime	= self::getNextJumpWaitTime($PLANET['last_jump_time']);
		$this->sendJSON(array(
			'message' => sprintf($LNG['in_jump_gate_done'], pretty_time($NextJumpTime - TIMESTAMP)),
			'error' => false
		));
	}

	private function getAvailableFleets()
	{
		global $reslist, $resource, $PLANET;

		$fleetList  = array();

		foreach($reslist['fleet'] as $Ship)
		{
			if ($Ship == 212 || $PLANET[$resource[$Ship]] <= 0)
				continue;

			$fleetList[$Ship]	= $PLANET[$resource[$Ship]];
		}

		return $fleetList;
	}

	public function destroyMissiles()
	{
		global $resource, $PLANET;

		$db = Database::get();

		$Missle	= HTTP::_GP('missile', array());
		$PLANET[$resource[502]]	-= max(0, min($Missle[502], $PLANET[$resource[502]]));
		$PLANET[$resource[503]]	-= max(0, min($Missle[503], $PLANET[$resource[503]]));

		$sql = "UPDATE %%PLANETS%% SET :resource502Name = :resource502Val, :resource503Name = :resource503Val WHERE id = :planetID;";
		$db->update($sql, array(
			':resource502Name'  => $resource[502],
			':resource503Name'  => $resource[503],
			':resource502Val'   => $PLANET[$resource[502]],
			':resource503Val'   => $PLANET[$resource[503]],
			':planetID'         => $PLANET['id']
		));

		$this->sendJSON(array($PLANET[$resource[502]], $PLANET[$resource[503]]));
	}

	private function getTargetGates()
	{
		global $resource, $USER, $PLANET;

		$db = Database::get();

		$Order = $USER['planet_sort_order'] == 1 ? "DESC" : "ASC" ;
		$Sort  = $USER['planet_sort'];

		switch($Sort) {
			case 1:
				$OrderBy	= "galaxy, system, planet, planet_type ". $Order;
				break;
			case 2:
				$OrderBy	= "name ". $Order;
				break;
			default:
				$OrderBy	= "id ". $Order;
				break;
		}

		$sql = "SELECT id, name, galaxy, system, planet, last_jump_time, :resource43Name FROM %%PLANETS%% WHERE id != :planetID AND id_owner = :userID AND planet_type = '3' AND :resource43Name > 0 ORDER BY :order;";
		$moonResult = $db->select($sql, array(
			':resource43Name'   => $resource[43],
			':planetID'         => $PLANET['id'],
			':userID'           => $USER['id'],
			':order'            => $OrderBy
		));

		$moonList	= array();

		foreach($moonResult as $moonRow) {
			$NextJumpTime				= self::getNextJumpWaitTime($moonRow['last_jump_time']);
			$moonList[$moonRow['id']]	= '['.$moonRow['galaxy'].':'.$moonRow['system'].':'.$moonRow['planet'].'] '.$moonRow['name'].(TIMESTAMP < $NextJumpTime ? ' ('.pretty_time($NextJumpTime - TIMESTAMP).')':'');
		}

		return $moonList;
	}

	public function show()
	{
		global $USER, $PLANET, $LNG, $resource, $pricelist, $reslist, $CombatCaps, $ProdGrid;

		$elementID 	= HTTP::_GP('id', 0);

		$this->setWindow('popup');
		$this->initTemplate();

		$productionTable	= array();
		$FleetInfo			= array();
		$MissileList		= array();
		$gateData			= array();

		$CurrentLevel		= 0;

		$ressIDs			= array_merge(array(), $reslist['resstype'][1], $reslist['resstype'][2]);

		if(in_array($elementID, $reslist['prod']) && in_array($elementID, $reslist['build']))
		{

			/* Data for eval */
			$BuildEnergy		= $USER[$resource[113]];
			$BuildTemp          = $PLANET['temp_max'];
			$BuildLevelFactor	= $PLANET[$resource[$elementID].'_porcent'];

			$CurrentLevel		= $PLANET[$resource[$elementID]];
			$BuildStartLvl   	= max($CurrentLevel - 2, 0);
			for($BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 15; $BuildLevel++)
			{
				foreach($ressIDs as $ID)
				{

					if(!isset($ProdGrid[$elementID]['production'][$ID]))
						continue;

					$Production	= eval(ResourceUpdate::getProd($ProdGrid[$elementID]['production'][$ID]));

					if(in_array($ID, $reslist['resstype'][2]))
					{
						$Production	*= Config::get()->energySpeed;
					}
					else
					{
						$Production	*= Config::get()->resource_multiplier;
					}

					$productionTable['production'][$BuildLevel][$ID]	= $Production;
				}
			}

			$productionTable['usedResource']	= array_keys($productionTable['production'][$BuildStartLvl]);
		}
		elseif(in_array($elementID, $reslist['storage']))
		{
			$CurrentLevel		= $PLANET[$resource[$elementID]];
			$BuildStartLvl   	= max($CurrentLevel - 2, 0);

			for($BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 15; $BuildLevel++)
			{
				foreach($ressIDs as $ID)
				{
					if(!isset($ProdGrid[$elementID]['storage'][$ID]))
						continue;

					$production = round(eval(ResourceUpdate::getProd($ProdGrid[$elementID]['storage'][$ID])));
					$production *= Config::get()->resource_multiplier;
					$production *= STORAGE_FACTOR;

					$productionTable['storage'][$BuildLevel][$ID]	= $production;
				}
			}

			$productionTable['usedResource']	= array_keys($productionTable['storage'][$BuildStartLvl]);
		}
		elseif(in_array($elementID, $reslist['fleet']))
		{
			$FleetInfo	= array(
				'structure'		=> $pricelist[$elementID]['cost'][901] + $pricelist[$elementID]['cost'][902],
				'tech'			=> $pricelist[$elementID]['tech'],
				'attack'		=> $CombatCaps[$elementID]['attack'],
				'shield'		=> $CombatCaps[$elementID]['shield'],
				'capacity'		=> $pricelist[$elementID]['capacity'],
				'speed1'		=> $pricelist[$elementID]['speed'],
				'speed2'		=> $pricelist[$elementID]['speed2'],
				'consumption1'	=> $pricelist[$elementID]['consumption'],
				'consumption2'	=> $pricelist[$elementID]['consumption2'],
				'rapidfire'		=> array(
					'from'	=> array(),
					'to'	=> array(),
				),
			);

			$fleetIDs	= array_merge($reslist['fleet'], $reslist['defense']);

			foreach($fleetIDs as $fleetID)
			{
				if (isset($CombatCaps[$elementID]['sd']) && !empty($CombatCaps[$elementID]['sd'][$fleetID])) {
					$FleetInfo['rapidfire']['to'][$fleetID] = $CombatCaps[$elementID]['sd'][$fleetID];
				}

				if (isset($CombatCaps[$fleetID]['sd']) && !empty($CombatCaps[$fleetID]['sd'][$elementID])) {
					$FleetInfo['rapidfire']['from'][$fleetID] = $CombatCaps[$fleetID]['sd'][$elementID];
				}
			}
		}
		elseif (in_array($elementID, $reslist['defense']))
		{
			$FleetInfo	= array(
				'structure'		=> $pricelist[$elementID]['cost'][901] + $pricelist[$elementID]['cost'][902],
				'attack'		=> $CombatCaps[$elementID]['attack'],
				'shield'		=> $CombatCaps[$elementID]['shield'],
				'rapidfire'		=> array(
					'from'	=> array(),
					'to'	=> array(),
				),
			);

			$fleetIDs	= array_merge($reslist['fleet'], $reslist['defense']);

			foreach($fleetIDs as $fleetID)
			{
				if (isset($CombatCaps[$elementID]['sd']) && !empty($CombatCaps[$elementID]['sd'][$fleetID])) {
					$FleetInfo['rapidfire']['to'][$fleetID] = $CombatCaps[$elementID]['sd'][$fleetID];
				}

				if (isset($CombatCaps[$fleetID]['sd']) && !empty($CombatCaps[$fleetID]['sd'][$elementID])) {
					$FleetInfo['rapidfire']['from'][$fleetID] = $CombatCaps[$fleetID]['sd'][$elementID];
				}
			}
		}

		if($elementID == 43 && $PLANET[$resource[43]] > 0)
		{
			$this->tplObj->loadscript('gate.js');
			$nextTime	= self::getNextJumpWaitTime($PLANET['last_jump_time']);
			$gateData	= array(
				'nextTime'	=> _date($LNG['php_tdformat'], $nextTime, $USER['timezone']),
				'restTime'	=> max(0, $nextTime - TIMESTAMP),
				'startLink'	=> $PLANET['name'].' '.strip_tags(BuildPlanetAdressLink($PLANET)),
				'gateList' 	=> $this->getTargetGates(),
				'fleetList'	=> $this->getAvailableFleets(),
			);
		}
		elseif($elementID == 44 && $PLANET[$resource[44]] > 0)
		{
			$MissileList	= array(
				502	=> $PLANET[$resource[502]],
				503	=> $PLANET[$resource[503]]
			);
		}

		$this->assign(array(
			'elementID'			=> $elementID,
			'productionTable'	=> $productionTable,
			'CurrentLevel'		=> $CurrentLevel,
			'MissileList'		=> $MissileList,
			'Bonus'				=> BuildFunctions::getAvalibleBonus($elementID),
			'FleetInfo'			=> $FleetInfo,
			'gateData'			=> $gateData,
		));

		$this->display('page.information.default.tpl');
	}
}