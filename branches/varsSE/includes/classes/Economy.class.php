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

class Economy
{

	/**
	 * reference of the config object
	 * @var Config
	 */
	private $config			= NULL;

	private $isGlobalMode 	= NULL;
	private $TIME			= NULL;
	private $HASH			= NULL;
	private $ProductionTime	= NULL;

	private $PLANET			= array();
	private $USER			= array();
	private $Builded		= array();

    /**
     * reference of the config object
     * @var QueueManager
     */
    private $queueObj;

	function __construct($Build = true, $Tech = true)
	{
		$this->Build	= $Build;
		$this->Tech		= $Tech;
	}

	public function setData($USER, $PLANET)
	{
		$this->USER		= $USER;
		$this->PLANET	= $PLANET;
	}

	public function getData()
	{
		return array($this->USER, $this->PLANET);
	}

	public function getQueueObj()
	{
		return $this->queueObj;
	}
	
	public function ReturnVars() {
		if($this->isGlobalMode)
		{
			$GLOBALS['USER']	= $this->USER;
			$GLOBALS['PLANET']	= $this->PLANET;
			return true;
		} else {
			return array($this->USER, $this->PLANET);
		}
	}
	
	public function CreateHash()
    {
		$Hash	= array();

        $Hash[]	= $this->config->resource_multiplier;
        $Hash[]	= $this->config->energySpeed;
        $Hash[]	= $this->USER['factor']['Resource']['static'];
        $Hash[]	= $this->USER['factor']['Resource']['percent'];

		foreach(Vars::getElements(NULL, Vars::FLAG_PRODUCTION) as $elementObj)
        {
            if(isset($this->PLANET[$elementObj->name]))
            {
		    	$Hash[]	= $this->PLANET[$elementObj->name];
		    	$Hash[]	= $this->PLANET[$elementObj->name.'_porcent'];
            }
            else
            {
                $Hash[]	= $this->USER[$elementObj->name];
                $Hash[]	= $this->USER[$elementObj->name.'_porcent'];
            }
		}

		foreach(Vars::getElements(Vars::CLASS_RESOURCE) as $elementId =>  $elementObj)
        {
			$Hash[]	= $this->config->{$elementObj->name.'_basic_income'};
            if(isset($this->USER['factor']['Resource'.$elementId]))
            {
                $Hash[]	= $this->USER['factor']['Resource'.$elementId]['static'];
                $Hash[]	= $this->USER['factor']['Resource'.$elementId]['percent'];
            }
		}

		foreach(Vars::getElements(NULL, Vars::FLAG_STORAGE) as $elementObj)
        {
			$Hash[]	= isset($this->PLANET{$elementObj->name}) ? $this->PLANET{$elementObj->name}: $this->USER{$elementObj->name};
		}

		return md5(implode("::", $Hash));
	}
	
	public function CalcResource($USER = NULL, $PLANET = NULL, $SAVE = false, $TIME = NULL, $HASH = true)
	{			
		$this->isGlobalMode	= !isset($USER, $PLANET) ? true : false;
		$this->USER			= $this->isGlobalMode ? $GLOBALS['USER'] : $USER;
		$this->PLANET		= $this->isGlobalMode ? $GLOBALS['PLANET'] : $PLANET;
		$this->TIME			= is_null($TIME) ? TIMESTAMP : $TIME;
		$this->config		= Config::get($this->USER['universe']);

		if($this->USER['urlaubs_modus'] == 1)
			return $this->ReturnVars();

        $this->queueObj		= new QueueManager($this->USER['id'], $this->PLANET['id']);

		if($this->Build)
		{
			$this->checkQueue();
		}

		$this->UpdateResource($this->TIME, false);

		if($SAVE === true)
			$this->SavePlanetToDB($this->USER, $this->PLANET);
			
		return $this->ReturnVars();
	}
	
	public function UpdateResource($TIME, $HASH = false)
	{
		$this->ProductionTime = ($TIME - $this->PLANET['last_update']);
		if($this->ProductionTime > 0)
		{
			$this->PLANET['last_update'] = $TIME;
			if($HASH === false) {
				$this->ReBuildCache();
			} else {
				$this->HASH		= $this->CreateHash();

				if($this->PLANET['eco_hash'] !== $this->HASH) {
					$this->PLANET['eco_hash'] = $this->HASH;
					$this->ReBuildCache();
				}
			}

			$this->ExecCalc();
		}
	}

    private function ExecCalc()
    {
        if($this->PLANET['planet_type'] != PLANET) return;

        $resourcePlanetElements = Vars::getElements(Vars::CLASS_RESOURCE, Vars::FLAG_RESOURCE_PLANET);

        foreach($resourcePlanetElements as $elementObj)
        {
            $elementName    = $elementObj->name;
            $storage        = $this->PLANET[$elementName.'_max'] * $this->config->max_overflow;

            $theoretical    = $this->ProductionTime * ($this->config->{$elementName.'_basic_income'} * $this->config->resource_multiplier + $this->PLANET[$elementName.'_perhour']) / 3600;
            $this->PLANET[$elementName] = max(min($this->PLANET[$elementName] + $theoretical, $storage), 0);
        }
    }
	
	public static function getProd($Calculation)
	{
		return 'return '.$Calculation.';';
	}
	
	public function ReBuildCache()
	{
        $elementResourcePlanetList      = Vars::getElements(NULL, Vars::FLAG_RESOURCE_PLANET);
        $elementEnergyList              = Vars::getElements(NULL, Vars::FLAG_ENERGY);
        $elementProductionList          = Vars::getElements(NULL, Vars::FLAG_PRODUCTION);
        $elementStorageList             = Vars::getElements(NULL, Vars::FLAG_STORAGE);
        $elementResourceProductionList  = $elementResourcePlanetList + $elementEnergyList;

        $temp	= ArrayUtil::combineArrayWithSingleElement(array_keys($elementResourceProductionList), array(
            'max'	=> 0,
            'plus'	=> 0,
            'minus'	=> 0,
        ));
		
		$BuildTemp		= $this->PLANET['temp_max'];
		$BuildEnergy	= $this->USER[Vars::getElement(113)->name];
		
		foreach($elementStorageList as $elementStorageObj)
		{
            foreach($elementResourcePlanetList as $elementResourcePlanetId => $elementResourcePlanetObj)
			{
				$BuildLevel 		= isset($this->PLANET[$elementStorageObj->name])
                    ? $this->PLANET[$elementStorageObj->name]
                    : $this->USER[$elementStorageObj->name];

				$temp[$elementResourcePlanetId]['max']	+= round(eval(BuildUtils::getProd($elementStorageObj->calcStorage[$elementResourcePlanetId])));
			}
		}

		foreach($elementProductionList as $elementProductionElementObj)
		{
            if(isset($this->PLANET[$elementProductionElementObj->name]))
            {
                $BuildLevelFactor	= $this->PLANET[$elementProductionElementObj->name.'_porcent'];
                $BuildLevel 		= $this->PLANET[$elementProductionElementObj->name];
            }
            else
            {
                $BuildLevelFactor	= $this->USER[$elementProductionElementObj->name.'_porcent'];
                $BuildLevel 		= $this->USER[$elementProductionElementObj->name];
            }

            foreach($elementResourceProductionList as $elementResourceElementId => $elementResourceElementObj)
			{
				$Production	= eval(BuildUtils::getProd($elementProductionElementObj->calcProduction[$elementResourceElementId]));
				
				if($Production > 0) {					
					$temp[$elementResourceElementId]['plus']	+= $Production;
				}
                else
                {
					if(!in_array($elementResourceElementId, array_keys($elementEnergyList)))
                    {
                        $elementResourceName    = $elementResourceElementObj->name;
					    if(isset($this->PLANET[$elementResourceName]) && $this->PLANET[$elementResourceName] == 0) continue;
					    if(isset($this->USER[$elementResourceName]) && $this->USER[$elementResourceName] == 0) continue;
					}
					$temp[$elementResourceElementId]['minus']	+= $Production;
				}
			}
		}

        foreach($elementResourcePlanetList as $elementId => $elementObj)
        {
            $storage    = $temp[$elementId]['max'];
            $storage    += PlayerUtil::getBonusValue($storage, 'ResourceStorage', $this->USER);
            $storage    *= $this->config->resource_multiplier * STORAGE_FACTOR;

            $this->PLANET[$elementObj->name.'_max'] = $storage;
        }

        foreach($elementEnergyList as $elementId => $elementObj)
        {
            $prodHour   = $temp[$elementId]['plus'];
            $prodHour   += PlayerUtil::getBonusValue($prodHour, array('Resource', 'Resource'.$elementId), $this->USER);
            $prodHour   *= $this->config->energySpeed;

		    $this->PLANET[$elementObj->name]	    	= round($prodHour);
		    $this->PLANET[$elementObj->name.'_used']    = $temp[$elementId]['minus'] * $this->config->energySpeed;
        }

		if($this->PLANET['energy_used'] == 0)
        {
            foreach($elementResourcePlanetList as $elementObj)
            {
                $this->PLANET[$elementObj->name.'_perhour'] = 0;
            }
        }
        else
        {
			$prodLevel	= min(1, $this->PLANET['energy'] / abs($this->PLANET['energy_used']));

            foreach($elementResourcePlanetList as $elementId => $elementObj)
            {
                $prodHour   = $temp[$elementId]['plus'];
                $prodHour   *= $prodLevel;
                $prodHour   += PlayerUtil::getBonusValue($prodHour, array('Resource', 'Resource'.$elementId), $this->USER);
                $prodHour   += $temp[$elementId]['minus'];
                $prodHour   *= $this->config->resource_multiplier;

			    $this->PLANET[$elementObj->name.'_perhour']	= round($prodHour, 6);
            }
		}
	}

    public function checkQueue()
    {
        $queueIds = $this->getQueueObj()->getReadyTaskInQueues($this->TIME);

        foreach($queueIds as $queueId)
        {
            $this->queue($queueId);
        }
    }


    public static function addToQueue(QueueManager $queueObj, $USER, $PLANET, Element $elementObj, $buildType, $amount = NULL)
    {
        $elementName        = $elementObj->name;
        $queueElementObj    = Vars::getElement($elementObj->queueId);
        $queueData          = $queueObj->queryElementIds($elementObj->elementID);

        if($buildType !== BuildUtils::AMOUNT)
        {
            if(!empty($queueData))
            {
                $amount = $queueData[count($queueData)-1]['amount'];
            }
            elseif(Vars::elementHasFlag($elementObj, Vars::FLAG_RESOURCE_USER))
            {
                $amount = $USER[$elementName];
            }
            else
            {
                $amount = $PLANET[$elementName];
            }

            $amount += (int) $buildType === BuildUtils::BUILD;
        }

        if(empty($amount))
        {
            return array('error' => true, 'code' => 1);
        }

        if($elementObj->maxLevel != 0 && $elementObj->maxLevel <= $amount)
        {
            return array('error' => true, 'code' => 2);
        }

        $queueCount = count($queueObj->queryQueueIds($elementObj->queueId));
        if($queueElementObj->maxCount != 0 && $queueCount >= $queueElementObj->maxCount)
        {
            return array('error' => true, 'code' => 3);
        }

        if($elementObj->class == Vars::CLASS_BUILDING)
        {
            $totalPlanetFields  	= CalculateMaxPlanetFields($PLANET);
            $queueBuildingData      = $queueObj->queryElementIds(array_keys(Vars::getElements(Vars::CLASS_BUILDING)));
            $queueBuildingCount     = count($queueBuildingData);
            if($buildType === BuildUtils::BUILD && $PLANET["field_current"] >= ($totalPlanetFields - $queueBuildingCount))
            {
                return array('error' => true, 'code' => 4);
            }
        }

        if($buildType === BuildUtils::AMOUNT)
        {
            $amount = min($amount, BuildUtils::maxBuildableElements($USER, $PLANET, $elementObj));
        }

        if($elementObj->class == Vars::CLASS_MISSILE)
        {
            $maxMissiles    = BuildUtils::maxBuildableMissiles($USER, $PLANET, $elementObj, $queueObj);
            $amount         = min($amount, $maxMissiles[$elementObj->elementID]);
        }

        $costResources  = BuildUtils::getElementPrice($elementObj, $amount, $buildType === BuildUtils::DESTROY);

        if($elementObj->class != Vars::CLASS_FLEET && $elementObj->class != Vars::CLASS_DEFENSE
            && $elementObj->class != Vars::CLASS_MISSILE && count($queueData) === 0 )
        {
            if($buildType !== BuildUtils::AMOUNT && !BuildUtils::isElementBuyable($USER, $PLANET, $elementObj, $costResources))
            {
                return array('error' => true, 'code' => 5);
            }

            foreach($costResources as $resourceElementId => $value)
            {
                $resourceElementObj    = Vars::getElement($resourceElementId);
                if(Vars::elementHasFlag($resourceElementObj, Vars::FLAG_RESOURCE_PLANET))
                {
                    $PLANET[$resourceElementObj->name]	-= $costResources[$resourceElementId];
                }
                elseif(Vars::elementHasFlag($resourceElementObj, Vars::FLAG_RESOURCE_USER))
                {
                    $USER[$resourceElementObj->name] 	-= $costResources[$resourceElementId];
                }
            }
        }

        $elementTime    = BuildUtils::getBuildingTime($USER, $PLANET, $elementObj, $costResources);
        if(!empty($queueData))
        {
            $elementEndTime = $queueData[count($queueData)-1]['endBuildtime'] + $elementTime;
        }
        else
        {
            $elementEndTime = TIMESTAMP + $elementTime;
        }

        $queueObj->add($elementObj, $amount, $elementTime, $elementEndTime);
        return array('error' => false, 'code' => 0);
    }
    
	public function SavePlanetToDB($USER = NULL, $PLANET = NULL)
	{
		global $resource, $reslist;
		
		if(is_null($USER))
			global $USER;
			
		if(is_null($PLANET))
			global $PLANET;

		$buildQueries	= array();

		$params	= array(
			':userId'				=> $USER['id'],
			':planetId'				=> $PLANET['id'],
			':metal'				=> $PLANET['metal'],
			':crystal'				=> $PLANET['crystal'],
			':deuterium'			=> $PLANET['deuterium'],
			':ecoHash'				=> $PLANET['eco_hash'],
			':lastUpdateTime'		=> $PLANET['last_update'],
			':b_building'			=> $PLANET['b_building'],
			':b_building_id' 		=> $PLANET['b_building_id'],
			':field_current' 		=> $PLANET['field_current'],
			':b_hangar_id'			=> $PLANET['b_hangar_id'],
			':metal_perhour'		=> $PLANET['metal_perhour'],
			':crystal_perhour'		=> $PLANET['crystal_perhour'],
			':deuterium_perhour'	=> $PLANET['deuterium_perhour'],
			':metal_max'			=> $PLANET['metal_max'],
			':crystal_max'			=> $PLANET['crystal_max'],
			':deuterium_max'		=> $PLANET['deuterium_max'],
			':energy_used'			=> $PLANET['energy_used'],
			':energy'				=> $PLANET['energy'],
			':b_hangar'				=> $PLANET['b_hangar'],
			':darkmatter'			=> $USER['darkmatter'],
			':b_tech'				=> $USER['b_tech'],
			':b_tech_id'			=> $USER['b_tech_id'],
			':b_tech_planet'		=> $USER['b_tech_planet'],
			':b_tech_queue'			=> $USER['b_tech_queue']
		);

		if (!empty($this->Builded))
		{
			foreach($this->Builded as $Element => $Count)
			{
				$Element	= (int) $Element;
				
				if(empty($resource[$Element]) || empty($Count)) {
					continue;
				}
				
				if(in_array($Element, $reslist['one']))
				{
					$buildQueries[]						= ', p.'.$resource[$Element].' = :'.$resource[$Element];
					$params[':'.$resource[$Element]]	= '1';
				}
				elseif(isset($PLANET[$resource[$Element]]))
				{
					$buildQueries[]						= ', p.'.$resource[$Element].' = p.'.$resource[$Element].' + :'.$resource[$Element];
					$params[':'.$resource[$Element]]	= floattostring($Count);
				}
				elseif(isset($USER[$resource[$Element]]))
				{
					$buildQueries[]						= ', u.'.$resource[$Element].' = u.'.$resource[$Element].' + :'.$resource[$Element];
					$params[':'.$resource[$Element]]	= floattostring($Count);
				}
			}
		}

		$sql = 'UPDATE %%PLANETS%% as p,%%USERS%% as u SET
		p.metal				= :metal,
		p.crystal			= :crystal,
		p.deuterium			= :deuterium,
		p.eco_hash			= :ecoHash,
		p.last_update		= :lastUpdateTime,
		p.b_building		= :b_building,
		p.b_building_id 	= :b_building_id,
		p.field_current 	= :field_current,
		p.b_hangar_id		= :b_hangar_id,
		p.metal_perhour		= :metal_perhour,
		p.crystal_perhour	= :crystal_perhour,
		p.deuterium_perhour	= :deuterium_perhour,
		p.metal_max			= :metal_max,
		p.crystal_max		= :crystal_max,
		p.deuterium_max		= :deuterium_max,
		p.energy_used		= :energy_used,
		p.energy			= :energy,
		p.b_hangar			= :b_hangar,
		u.darkmatter		= :darkmatter,
		u.b_tech			= :b_tech,
		u.b_tech_id			= :b_tech_id,
		u.b_tech_planet		= :b_tech_planet,
		u.b_tech_queue		= :b_tech_queue
		'.implode("\n", $buildQueries).'
		WHERE p.id = :planetId AND u.id = :userId;';

		Database::get()->update($sql, $params);

		$this->Builded	= array();

		return array($USER, $PLANET);
	}
}