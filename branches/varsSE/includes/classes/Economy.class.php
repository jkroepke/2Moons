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
	private $save           = array();

    /**
     * reference of the config object
     * @var QueueManager
     */
    private $queueObj;


    static public function getProd($Calculation)
    {
        return 'return '.$Calculation.';';
    }

	function __construct($Build = true)
	{
		$this->Build	= $Build;
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
        $Hash[]	= PlayerUtil::getBonusValue(100, 'Resource', $this->USER);

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
                $Hash[]	= PlayerUtil::getBonusValue(100, 'Resource'.$elementId, $this->USER);
            }
		}

		foreach(Vars::getElements(NULL, Vars::FLAG_STORAGE) as $elementObj)
        {
			$Hash[]	= isset($this->PLANET{$elementObj->name}) ? $this->PLANET{$elementObj->name} : $this->USER{$elementObj->name};
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

		$this->UpdateResource($this->TIME, $HASH);

		if($SAVE === true)
        {
            $this->SavePlanetToDB($this->USER, $this->PLANET);
        }
			
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

    private function saveToDatabase($env, $variable)
    {
        $this->save[] = array('env' => $env, 'var' => $variable);
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

				$temp[$elementResourcePlanetId]['max']	+= round(eval(self::getProd($elementStorageObj->calcStorage[$elementResourcePlanetId])));
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
				$Production	= eval(self::getProd($elementProductionElementObj->calcProduction[$elementResourceElementId]));
				
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

    private function checkQueue()
    {
        $queueIds = $this->queueObj->getReadyTaskInQueues($this->TIME);

        foreach($queueIds as $queueId)
        {
            $queueData      = $this->queueObj->queryQueueIds($queueId);
            if($queueData[0]['taskType'] === 'amount')
            {
                $this->procedureAmountQueue($queueData);
            }
            else
            {
                $this->procedureBuildQueue($queueData);
            }
        }
    }

    private function procedureBuildQueue($queueData)
    {
        foreach($queueData as $task)
        {
            if($task['buildEndTime'] <= TIMESTAMP)
            {
                $elementObj = Vars::getElement($task['elementId']);

                if(isset($this->USER[$elementObj->name]))
                {
                    $this->saveToDatabase('USER', $elementObj->name);

                    $this->USER[$elementObj->name] = $task['amount'];
                    if($task['taskType'] == QueueManager::DESTROY)
                    {
                        $this->USER[$elementObj->name]--;
                    }
                }
                else
                {
                    $this->saveToDatabase('PLANET', $elementObj->name);

                    $this->PLANET[$elementObj->name] = $task['amount'];
                    if($task['taskType'] == QueueManager::DESTROY)
                    {
                        $this->PLANET[$elementObj->name]--;
                    }
                }

                $this->queueObj->remove($task['taskId']);
            }
            else
            {
                $isAnotherPlanet    = $task['taskType'] == QueueManager::USER && $task['planetId'] != $this->PLANET['id'];
                $ecoObj             = new self(false);

                if($isAnotherPlanet)
                {
                    $taskPlanet = Database::get()->selectSingle('SELECT * FROM %%PLANETS%% WHERE planetId = :planetId', array(
                        ':planetId' => $task['planetId'],
                    ));

                    $ecoObj->CalcResource($this->USER, $taskPlanet, false, $task['endBuildTime'] - $task['endTime']);
                    list(, $taskPlanet) = $ecoObj->ReturnVars();
                }
                else
                {
                    $taskPlanet = $this->PLANET;
                }

                $elementObj     = Vars::getElement($task['elementId']);
                $costResources  = BuildUtils::getElementPrice($elementObj, $task['amount'], $task['taskType'] == QueueManager::DESTROY);
                $buildTime      = BuildUtils::getBuildingTime($this->USER, $this->PLANET, $elementObj, $costResources, $task['taskType'] == QueueManager::DESTROY);

                if(!BuildUtils::isElementBuyable($this->USER, $taskPlanet, $elementObj, $costResources))
                {
                    $this->queueObj->removeAllTaskByElementId($elementObj);
                    if($isAnotherPlanet)
                    {
                        $ecoObj->SavePlanetToDB($this->USER, $taskPlanet);
                    }

                    continue;
                }

                foreach($costResources as $resourceElementId => $value)
                {
                    $resourceElementObj    = Vars::getElement($resourceElementId);
                    if(Vars::elementHasFlag($resourceElementObj, Vars::FLAG_RESOURCE_PLANET))
                    {
                        $taskPlanet[$resourceElementObj->name]	-= $costResources[$resourceElementId];
                    }
                    elseif(Vars::elementHasFlag($resourceElementObj, Vars::FLAG_RESOURCE_USER))
                    {
                        $this->USER[$resourceElementObj->name] 	-= $costResources[$resourceElementId];
                    }
                }

                if($buildTime != $task['buildTime'])
                {
                    $this->queueObj->updateQueueEndTimes($task['queueId'], $buildTime - $task['buildTime']);
                }

                if($isAnotherPlanet)
                {
                    $ecoObj->SavePlanetToDB($this->USER, $taskPlanet);
                }
                else
                {
                    $this->PLANET = $taskPlanet;
                }

                break;
            }
        }
    }

    private function procedureAmountQueue($queueData)
    {
        $partBuildTime = $this->TIME - $this->PLANET['last_update'];

        foreach($queueData as $task)
        {
            $elementObj = Vars::getElement($task['elementId']);
            if($task['buildTime'] == 0)
            {
                $this->PLANET[$elementObj->name]    += $task['amount'];
                if(isset($this->USER[$elementObj->name]))
                {
                    $this->saveToDatabase('USER', $elementObj->name);
                }
                else
                {
                    $this->saveToDatabase('PLANET', $elementObj->name);
                }
                continue;
            }

            $partBuildTime  += $task['partBuildTime'];
            $doneAmount     = max(min(floor($partBuildTime / $task['buildTime']), $task['amount']), 0);

            if($doneAmount == 0) break;

            if(isset($this->USER[$elementObj->name]))
            {
                $this->USER[$elementObj->name]    += $doneAmount;
                $this->saveToDatabase('USER', $elementObj->name);
            }
            else
            {
                $this->PLANET[$elementObj->name]    += $doneAmount;
                $this->saveToDatabase('PLANET', $elementObj->name);
            }

            $partBuildTime  -= $doneAmount * $task['buildTime'];
            $task['amount']         -= $doneAmount;

            if($task['amount'] != 0)
            {
                $this->queueObj->updateTaskAmount($task['taskId'], $task['amount']);
                break;
            }
            else
            {
                $this->queueObj->remove($task['taskId']);
            }
        }
    }

    public function addToQueue(Element $elementObj, $buildType, $amount = NULL)
    {
        $elementName        = $elementObj->name;
        $queueElementObj    = Vars::getElement($elementObj->queueId);
        $queueData          = $this->queueObj->queryElementIds($elementObj->elementID);

        if($buildType !== QueueManager::SHIPYARD)
        {
            if(!empty($queueData))
            {
                $amount = $queueData[count($queueData)-1]['amount'];
            }
            elseif(Vars::elementHasFlag($elementObj, Vars::FLAG_RESOURCE_USER))
            {
                $amount = $this->USER[$elementName];
            }
            else
            {
                $amount = $this->PLANET[$elementName];
            }

            $amount += (int) ($buildType === QueueManager::BUILD || $buildType === QueueManager::USER);
        }

        if(empty($amount))
        {
            return array('error' => true, 'code' => 1);
        }

        if($elementObj->maxLevel != 0 && $elementObj->maxLevel <= $amount)
        {
            return array('error' => true, 'code' => 2);
        }

        $queueCount = count($this->queueObj->queryQueueIds($elementObj->queueId));
        if($queueElementObj->maxCount != 0 && $queueCount >= $queueElementObj->maxCount)
        {
            return array('error' => true, 'code' => 3);
        }

        if($elementObj->class == Vars::CLASS_BUILDING)
        {
            $totalPlanetFields  	= CalculateMaxPlanetFields($this->PLANET);
            $queueBuildingData      = $this->queueObj->queryElementIds(array_keys(Vars::getElements(Vars::CLASS_BUILDING)));
            $queueBuildingCount     = count($queueBuildingData);
            if($buildType === QueueManager::BUILD && $this->PLANET["field_current"] >= ($totalPlanetFields - $queueBuildingCount))
            {
                return array('error' => true, 'code' => 4);
            }
        }

        if($buildType === QueueManager::SHIPYARD)
        {
            $amount = min($amount, BuildUtils::maxBuildableElements($this->USER, $this->PLANET, $elementObj));
        }

        if($elementObj->class == Vars::CLASS_MISSILE)
        {
            $maxMissiles    = BuildUtils::maxBuildableMissiles($this->USER, $this->PLANET, $elementObj, $this->queueObj);
            $amount         = min($amount, $maxMissiles[$elementObj->elementID]);
        }

        $costResources  = BuildUtils::getElementPrice($elementObj, $amount, $buildType === QueueManager::DESTROY);

        if($elementObj->class != Vars::CLASS_FLEET && $elementObj->class != Vars::CLASS_DEFENSE
            && $elementObj->class != Vars::CLASS_MISSILE && count($queueData) === 0 )
        {
            if($buildType !== QueueManager::SHIPYARD && !BuildUtils::isElementBuyable($this->USER, $this->PLANET, $elementObj, $costResources))
            {
                return array('error' => true, 'code' => 5);
            }

            foreach($costResources as $resourceElementId => $value)
            {
                $resourceElementObj    = Vars::getElement($resourceElementId);
                if(Vars::elementHasFlag($resourceElementObj, Vars::FLAG_RESOURCE_PLANET))
                {
                    $this->PLANET[$resourceElementObj->name]	-= $costResources[$resourceElementId];
                }
                elseif(Vars::elementHasFlag($resourceElementObj, Vars::FLAG_RESOURCE_USER))
                {
                    $this->USER[$resourceElementObj->name] 	-= $costResources[$resourceElementId];
                }
            }
        }

        $elementTime    = BuildUtils::getBuildingTime($this->USER, $this->PLANET, $elementObj, $costResources);
        if(!empty($queueData))
        {
            $elementEndTime = $queueData[count($queueData)-1]['endBuildTime'] + $elementTime;
        }
        else
        {
            $elementEndTime = TIMESTAMP + $elementTime;
        }

        $this->queueObj->add($elementObj, $amount, $elementTime, $elementEndTime);

        if($this->isGlobalMode)
        {
            $this->ReturnVars();
        }
        return array('error' => false, 'code' => 0);
    }
    
	public function SavePlanetToDB($USER = NULL, $PLANET = NULL)
	{
		if(is_null($USER))
			global $USER;
			
		if(is_null($PLANET))
			global $PLANET;

		$buildQueries	= array();

		$params	= array(
			':userId'				=> $USER['id'],
			':planetId'				=> $PLANET['id'],
            ':ecoHash'				=> $PLANET['eco_hash'],
            ':lastUpdateTime'		=> $PLANET['last_update'],
            ':field_current' 		=> $PLANET['field_current'],
		);

        foreach(Vars::getElements(Vars::CLASS_RESOURCE) as $elementId => $elementObj)
        {
            if(Vars::elementHasFlag($elementObj, Vars::FLAG_RESOURCE_PLANET))
            {
                $buildQueries[] = ', u.'.$elementObj->name.' = :'.$elementObj->name;
                $buildQueries[] = ', u.'.$elementObj->name.'_perhour = :'.$elementObj->name.'_perhour';
                $buildQueries[] = ', u.'.$elementObj->name.'_max = :'.$elementObj->name.'_max';

                $params[':'.$elementObj->name]	            = floattostring($PLANET[$elementObj->name]);
                $params[':'.$elementObj->name.'_perhour']	= floattostring($PLANET[$elementObj->name.'_perhour']);
                $params[':'.$elementObj->name.'_max']	    = floattostring($PLANET[$elementObj->name.'_max']);
            }
            elseif(Vars::elementHasFlag($elementObj, Vars::FLAG_RESOURCE_USER))
            {
                $buildQueries[] = ', u.'.$elementObj->name.' = :'.$elementObj->name;
                $params[':'.$elementObj->name]	= floattostring($USER[$elementObj->name]);
            }
            elseif(Vars::elementHasFlag($elementObj, Vars::FLAG_ENERGY))
            {
                $buildQueries[] = ', p.'.$elementObj->name.' = :'.$elementObj->name;
                $buildQueries[] = ', p.'.$elementObj->name.'_used = :'.$elementObj->name.'_used';

                $params[':'.$elementObj->name]	        = floattostring($PLANET[$elementObj->name]);
                $params[':'.$elementObj->name.'_used']	= floattostring($PLANET[$elementObj->name.'_used']);
            }
        }

		if (!empty($this->save))
		{
            $this->save = array_unique($this->save);
			foreach($this->save as $entry)
			{
                if($entry['env'] === 'USER' && isset($USER[$entry['var']]))
                {
                    $buildQueries[] = ', u.'.$entry['var'].' = :'.$entry['var'];
                    $params[':'.$entry['var']]	= floattostring($USER[$entry['var']]);
                }
                elseif($entry['env'] === 'PLANET' && isset($PLANET[$entry['var']]))
                {
                    $buildQueries[] = ', u.'.$entry['var'].' = :'.$entry['var'];
                    $params[':'.$entry['var']]	= floattostring($PLANET[$entry['var']]);
                }
			}
		}

		$sql = 'UPDATE %%PLANETS%% as p,%%USERS%% as u SET
		p.eco_hash			= :ecoHash,
		p.last_update		= :lastUpdateTime,
		p.field_current 	= :field_current,
		'.implode("\n", $buildQueries).'
		WHERE p.id = :planetId AND u.id = :userId;';

		Database::get()->update($sql, $params);

		$this->Builded	= array();

		return array($USER, $PLANET);
	}
}