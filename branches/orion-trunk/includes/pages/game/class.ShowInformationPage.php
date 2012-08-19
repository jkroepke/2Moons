<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
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
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */


class ShowInformationPage extends AbstractPage
{
	public static $requireModule = MODULE_INFORMATION;
	
	protected $disableEcoSystem = true;

	function __construct() 
	{
		parent::__construct();
	}
		
	static function getNextJumpWaitTime($lastTime)
	{
		global $CONF;
		
		return $lastTime + $CONF['gate_wait_time'];
	}

	public function sendFleet()
	{
		global $PLANET, $USER, $resource, $LNG, $reslist;

		$NextJumpTime = self::getNextJumpWaitTime($PLANET['last_jump_time']);
		
		if (TIMESTAMP < $NextJumpTime) {
			$this->sendJSON(array('message' => $LNG['in_jump_gate_already_used'].' '.pretty_time($NextJumpTime - TIMESTAMP), 'error' => true));
		}
		
		$TargetPlanet = HTTP::_GP('jmpto', $PLANET['id']);
		$TargetGate   = $GLOBALS['DATABASE']->uniquequery("SELECT id, last_jump_time FROM ".PLANETS." WHERE id = ".$TargetPlanet." AND id_owner = ".$USER['id']." AND sprungtor > 0;");

		if (!isset($TargetGate) || $TargetPlanet == $PLANET['id']) {
			$this->sendJSON(array('message' => $LNG['in_jump_gate_doesnt_have_one'], 'error' => true));
		}
		
		$NextJumpTime   = self::getNextJumpWaitTime($TargetGate['last_jump_time']);
				
		if (TIMESTAMP < $NextJumpTime) {
			$this->sendJSON(array('message' => $LNG['in_jump_gate_not_ready_target'].' '.pretty_time($NextJumpTime - TIMESTAMP), 'error' => true));
		}
		
		$ShipArray		= array();
		$SubQueryOri	= "";
		$SubQueryDes	= "";
		$Ships			= HTTP::_GP('ship', array());
		
		foreach($reslist['fleet'] as $Ship)
		{
			if(!isset($Ships[$Ship]) || $Ship == 212)
				continue;
				
			$ShipArray[$Ship]	= max(0, min($Ships[$Ship], $PLANET[$resource[$Ship]]));
					
			if(empty($ShipArray[$Ship]))
				continue;
								
			$SubQueryOri 		.= $resource[$Ship]." = ".$resource[$Ship]." - ".$ShipArray[$Ship].", ";
			$SubQueryDes 		.= $resource[$Ship]." = ".$resource[$Ship]." + ".$ShipArray[$Ship].", ";
			$PLANET[$resource[$Ship]] -= $ShipArray[$Ship];
		}

		if (empty($SubQueryOri)) {
			$this->sendJSON(array('message' => $LNG['in_jump_gate_error_data'], 'error' => true));
		}
		
		$JumpTime	= TIMESTAMP;

		$SQL  = "UPDATE ".PLANETS." SET ";
		$SQL .= $SubQueryOri;
		$SQL .= "last_jump_time = ".$JumpTime." ";
		$SQL .= "WHERE ";
		$SQL .= "id = ". $PLANET['id'].";";
		$SQL .= "UPDATE ".PLANETS." SET ";
		$SQL .= $SubQueryDes;
		$SQL .= "last_jump_time = ".$JumpTime." ";
		$SQL .= "WHERE ";
		$SQL .= "id = ".$TargetPlanet.";";
		$GLOBALS['DATABASE']->multi_query($SQL);

		$PLANET['last_jump_time'] 	= $JumpTime;
		$NextJumpTime	= self::getNextJumpWaitTime($PLANET['last_jump_time']);
		$this->sendJSON(array('message' => sprintf($LNG['in_jump_gate_done'], pretty_time($NextJumpTime - TIMESTAMP)), 'error' => false));
	}

	private function getAvalibleFleets()
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
		
		$Missle	= HTTP::_GP('missile', array());
		$PLANET[$resource[502]]	-= max(0, min($Missle[502], $PLANET[$resource[502]]));
		$PLANET[$resource[503]]	-= max(0, min($Missle[503], $PLANET[$resource[503]]));
		
		$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".$resource[502]." = ".$PLANET[$resource[502]].", ".$resource[503]." = ".$PLANET[$resource[503]]." WHERE id = ".$PLANET['id'].";");
		
		$this->sendJSON(array($PLANET[$resource[502]], $PLANET[$resource[503]]));
	}

	private function getTargetGates()
	{
		global $resource, $USER, $PLANET;
								
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
				
				
        $moonResult	= $GLOBALS['DATABASE']->query("SELECT id, name, galaxy, system, planet, last_jump_time, ".$resource[43]." FROM ".PLANETS." WHERE id != ".$PLANET['id']." AND id_owner = ". $USER['id'] ." AND planet_type = '3' AND ".$resource[43]." > 0 ORDER BY ".$OrderBy.";");
        $moonList	= array();

        while($moonRow = $GLOBALS['DATABASE']->fetch_array($moonResult)) {
			$NextJumpTime				= self::getNextJumpWaitTime($moonRow['last_jump_time']);
			$moonList[$moonRow['id']]	= '['.$moonRow['galaxy'].':'.$moonRow['system'].':'.$moonRow['planet'].'] '.$moonRow['name'].(TIMESTAMP < $NextJumpTime ? ' ('.pretty_time($NextJumpTime - TIMESTAMP).')':'');
		}
		
		$GLOBALS['DATABASE']->free_result($moonResult);

		return $moonList;
	}

	public function show()
	{
		global $USER, $PLANET, $dpath, $LNG, $resource, $pricelist, $reslist, $CombatCaps, $ProdGrid, $CONF;

		$elementID 	= HTTP::_GP('id', 0);
		
		$this->setWindow('popup');
		$this->initTemplate();
		
		$productionTable	= array();
		$FleetInfo			= array();
		$MissileList		= array();

		$CurrentLevel		= 0;
		
		$ressIDs			= array_merge(array(), $reslist['resstype'][1], $reslist['resstype'][2]);
		
		if(in_array($elementID, $reslist['prod']) && in_array($elementID, $reslist['build']))
		{
			$BuildLevelFactor	= 10;
			$BuildTemp       	= $PLANET['temp_max'];
			$CurrentLevel		= $PLANET[$resource[$elementID]];
			$BuildEnergy		= $USER[$resource[113]];
			$BuildLevel     	= max($CurrentLevel, 0);
			$BuildStartLvl   	= max($CurrentLevel - 2, 0);
						
			for($BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 15; $BuildLevel++)
			{
				foreach($ressIDs as $ID) 
				{
					if(!isset($ProdGrid[$elementID]['production'][$ID]))
						continue;
						
					$Production	= eval(ResourceUpdate::getProd($ProdGrid[$elementID]['production'][$ID]));
					
					if($ID != 911) {
						$Production	*= $CONF['resource_multiplier'];
					}
					
					$productionTable['production'][$BuildLevel][$ID]	= $Production;
				}
			}
			
			$productionTable['usedResource']	= array_keys($productionTable['production'][$BuildStartLvl]);
		}
		elseif(in_array($elementID, $reslist['storage']))
		{
			$BuildLevelFactor	= 10;
			$BuildTemp       	= $PLANET['temp_max'];
			$CurrentLevel		= $PLANET[$resource[$elementID]];
			$BuildEnergy		= $USER[$resource[113]];
			$BuildLevel     	= max($CurrentLevel, 0);
			$BuildStartLvl   	= max($CurrentLevel - 2, 0);
						
			for($BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 15; $BuildLevel++)
			{
				foreach($ressIDs as $ID) 
				{
					if(!isset($ProdGrid[$elementID]['storage'][$ID]))
						continue;
						
					$productionTable['storage'][$BuildLevel][$ID]	= round(eval(ResourceUpdate::getProd($ProdGrid[$elementID]['storage'][$ID]))) * $CONF['resource_multiplier'] * STORAGE_FACTOR;
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
		elseif($elementID == 43 && $PLANET[$resource[43]] > 0)
		{
			$this->tplObj->loadscript('gate.js');
			$nextTime	= self::getNextJumpWaitTime($PLANET['last_jump_time']);
			$this->tplObj->assign_vars(array(
				'nextTime'	=> _date($LNG['php_tdformat'], $nextTime, $USER['timezone']),
				'restTime'	=> max(0, $nextTime - TIMESTAMP),
				'startLink'	=> strip_tags(BuildPlanetAdressLink($PLANET)),
				'gateList' 	=> $this->getTargetGates(),
				'fleetList'	=> $this->getAvalibleFleets(),
			));
		}
		elseif($elementID == 44 && $PLANET[$resource[44]] > 0)
		{								
			$MissileList	= array(
				502	=> $PLANET[$resource[502]],
				503	=> $PLANET[$resource[503]]
			);
		}

		$this->tplObj->assign_vars(array(		
			'elementID'			=> $elementID,
			'productionTable'	=> $productionTable,
			'CurrentLevel'		=> $CurrentLevel,
			'MissileList'		=> $MissileList,
			'Bonus'				=> BuildFunctions::getAvalibleBonus($elementID),
			'FleetInfo'			=> $FleetInfo,
		));
		
		$this->display('page.infomation.default.tpl');
	}
}
?>