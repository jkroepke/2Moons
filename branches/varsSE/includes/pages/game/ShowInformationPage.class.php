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
		global $PLANET, $USER, $LNG;

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
        foreach(Vars::getElements(Vars::CLASS_FLEET) as $elementId => $elementObj)
		{
            if (empty($Ships[$elementId]) || empty($PLANET[$elementObj->name]) || FleetUtil::GetFleetMaxSpeed($elementObj, $USER) == 0)
                continue;
				
			$ShipArray[$elementId]	= max(0, min($Ships[$elementId], $PLANET[$elementObj->name]));
					
			if(empty($ShipArray[$elementId])) continue;

            $SubQueryDes 		.= $elementObj->name." = ".$elementObj->name." + :".$elementObj->name."Element, ";
            $SubQueryParams[':'.$elementObj->name.'Element']    = $ShipArray[$elementId];
			$PLANET[$elementObj->name] -= $ShipArray[$elementId];
            $this->ecoObj->saveToDatabase('PLANET', $elementObj->name);
		}

		if (empty($SubQueryOri))
		{
			$this->sendJSON(array(
				'message' => $LNG['in_jump_gate_error_data'],
				'error' => true
			));
		}

        $sql  = "UPDATE %%PLANETS%% SET ".$SubQueryDes." last_jump_time = :jumptime WHERE id = :targetID;";
        $db->update($sql, array_merge(array(
            ':targetID' => $TargetPlanet,
            ':jumptime' => TIMESTAMP,
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
		global $USER, $PLANET;

        $fleetList  = array();

		foreach(Vars::getElements(Vars::CLASS_FLEET) as $elementId => $elementObj)
		{
			if (empty($PLANET[$elementObj->name]) || FleetUtil::GetFleetMaxSpeed($elementObj, $USER) == 0)
				continue;
						
			$fleetList[$elementId]	= $PLANET[$elementObj->name];
		}
				
		return $fleetList;
	}

	public function destroyMissiles()
	{
		global $PLANET;
		$missileList	= HTTP::_GP('missile', array());

        $result         = array();

        foreach(Vars::getElements(Vars::CLASS_MISSILE) as $missileElementId => $missileElementObj)
        {
            if(empty($missileList[$missileElementId])) continue;

            $PLANET[$missileElementObj->name]	-= max(0, min($missileList[$missileElementId], $PLANET[$missileElementObj->name]));
            $result[$missileElementId] = $PLANET[$missileElementObj->name];
            $this->ecoObj->saveToDatabase('PLANET', $missileElementObj->name);
        }

        $this->sendJSON($result);
	}

	private function getTargetGates()
	{
		global $USER, $PLANET;

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
				
		$sql = "SELECT id, name, galaxy, system, planet, last_jump_time, ".Vars::getElement(43)->name." FROM %%PLANETS%% WHERE id != :planetID AND id_owner = :userID AND planet_type = '3' AND :resource43Name > 0 ORDER BY :order;";
        $moonResult = $db->select($sql, array(
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
		global $USER, $PLANET, $LNG;

		$elementId  = HTTP::_GP('id', 0);
		$elementObj = Vars::getElement($elementId);

		$this->setWindow('popup');
		$this->initTemplate();
		
		$productionTable	= array();
		$fleetData			= array();
		$missileList		= array();
		$gateData			= array();

        $resourceElements	= Vars::getElements(NULL, array(Vars::FLAG_RESOURCE_PLANET, Vars::FLAG_ENERGY));

		if($elementObj->class == Vars::CLASS_BUILDING && $elementObj->hasFlag(Vars::FLAG_PRODUCTION))
		{
			/* Data for eval */
			$BuildEnergy		= $USER[Vars::getElement(113)->name];
			$BuildTemp          = $PLANET['temp_max'];
			$BuildLevelFactor	= $PLANET[$elementObj->name.'_porcent'];

			$startLevel   	    = max($PLANET[$elementObj->name] - 2, 0);

			for($BuildLevel = $startLevel; $BuildLevel < $startLevel + 15; $BuildLevel++)
			{
				foreach($resourceElements as $resourceElementId => $resourceElementObj)
				{
                    if(is_null($elementObj->calcProduction[$resourceElementId])) continue;
						
					$production	= eval(Economy::getProd($elementObj->calcProduction[$resourceElementId]));
					
					if($resourceElementObj->hasFlag(Vars::FLAG_ENERGY))
					{
						$production	*= Config::get()->energySpeed;
					}
					else
					{
						$production	*= Config::get()->resource_multiplier;
					}
					
					$productionTable['production'][$BuildLevel][$resourceElementId]	= $production;
				}
			}
			
			$productionTable['usedResource']	= array_keys($productionTable['production'][$startLevel]);
		}
		elseif($elementObj->class == Vars::CLASS_BUILDING && $elementObj->hasFlag(Vars::FLAG_STORAGE))
		{
            $startLevel   	    = max($PLANET[$elementObj->name] - 2, 0);

            for($BuildLevel = $startLevel; $BuildLevel < $startLevel + 15; $BuildLevel++)
			{
                foreach($resourceElements as $resourceElementId => $resourceElementObj)
                {
                    if(is_null($elementObj->calcProduction[$resourceElementId])) continue;

                    $production	= eval(Economy::getProd($elementObj->calcProduction[$resourceElementId]));
					$production *= Config::get()->resource_multiplier;
					$production *= STORAGE_FACTOR;

                    $productionTable['production'][$BuildLevel][$resourceElementId]	= $production;
				}
			}

            $productionTable['usedResource']	= array_keys($productionTable['production'][$startLevel]);
		}
		elseif($elementObj->class == Vars::CLASS_FLEET)
		{
			$fleetData	= array(
				'structure'		=> FleetUtil::calcStructurePoints($elementObj),
				'techLevel' 	=> FleetUtil::getShipTechLevel($elementObj, $USER),
				'tech' 	        => array($elementObj->speed1Tech, $elementObj->speed2Tech, $elementObj->speed3Tech),
				'attack'		=> $elementObj->attack,
				'shield'		=> $elementObj->shield,
				'capacity'		=> $elementObj->capacity,
				'speed'		    => array($elementObj->speed1, $elementObj->speed2, $elementObj->speed3),
				'consumption'	=> $elementObj->consumption,
				'rapidfire'		=> $elementObj->radidfire,
			);
		}
		elseif($elementObj->class == Vars::CLASS_DEFENSE)
		{
			$fleetData	= array(
				'structure'		=> FleetUtil::calcStructurePoints($elementObj),
                'attack'		=> $elementObj->attack,
                'shield'		=> $elementObj->shield,
                'rapidfire'		=> $elementObj->radidfire,
			);
		}
		
		if($elementId == 43 && $PLANET[$elementObj->name] > 0)
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
		elseif($elementId == 44 && $PLANET[$elementObj->name] > 0)
		{
            foreach(Vars::getElements(Vars::CLASS_MISSILE) as $missileElementId => $missileElementObj)
            {
                $missileList[$missileElementId]	= $PLANET[$missileElementObj->name];
            }
		}

		$this->assign(array(
			'elementID'			=> $elementId,
			'productionTable'	=> $productionTable,
			'CurrentLevel'		=> isset($USER[$elementObj->name]) ? $USER[$elementObj->name] : $PLANET[$elementObj->name],
			'MissileList'		=> $missileList,
			'elementBonus'		=> $elementObj->bonus,
			'FleetInfo'			=> $fleetData,
			'gateData'			=> $gateData,
		));
		
		$this->display('page.information.default.tpl');
	}
}