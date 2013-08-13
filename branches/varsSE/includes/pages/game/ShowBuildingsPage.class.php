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

class ShowBuildingsPage extends AbstractGamePage
{	
	public static $requireModule = MODULE_BUILDING;

	function __construct() 
	{
		parent::__construct();
	}

	private function getQueueData()
	{
		global $LNG, $USER;

		$queueData  = $this->ecoObj->getQueueObj()->getTasksByElementId(array_keys(Vars::getElements(Vars::CLASS_BUILDING)));

        $queue          = array();
        $elementLevel   = array();
        $count          = array();


		foreach($queueData as $task)
        {
			if ($task['endBuildTime'] < TIMESTAMP)
				continue;


            $queue[$task['taskId']] = array(
				'element'	=> $task['elementId'],
				'level' 	=> $task['amount'],
				'time' 		=> $task['buildTime'],
				'resttime' 	=> $task['endBuildTime'] - TIMESTAMP,
				'destroy' 	=> $task['taskType'] == QueueManager::DESTROY,
				'endtime' 	=> _date('U', $task['endBuildTime'], $USER['timezone']),
				'display' 	=> _date($LNG['php_tdformat'], $task['endBuildTime'], $USER['timezone']),
			);

            $elementLevel[$task['elementId']]   = $task['amount'] - ((int) $task['taskType'] == QueueManager::DESTROY);
            if(!isset($count[$task['queueId']]))
            {
                $count[$task['queueId']] = 0;
            }

            $count[$task['queueId']]++;
		}
		
		return array('queue' => $queue, 'elementLevel' => $elementLevel, 'count' => $count);
	}

    public function build()
    {
        global $USER;
        $elementId  = HTTP::_GP('elementId', 0);
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0 && !empty($elementId))
        {
            $elementObj = Vars::getElement($elementId);
            if($elementObj->class == Vars::CLASS_BUILDING)
            {
                $this->ecoObj->addToQueue($elementObj, QueueManager::BUILD);
            }
        }
        $this->redirectTo('game.php?page=buildings');
    }

    public function destroy()
    {
        global $USER;
        $elementId  = HTTP::_GP('elementId', 0);
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0 && !empty($elementId))
        {
            $elementObj = Vars::getElement($elementId);
            if($elementObj->class == Vars::CLASS_BUILDING)
            {
                $this->ecoObj->addToQueue($elementObj, QueueManager::DESTROY);
            }
        }

        $this->redirectTo('game.php?page=buildings');
    }

    public function cancel()
    {
        global $USER;
        $taskId = HTTP::_GP('taskId', 0);
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0 && !empty($taskId))
        {
            $this->ecoObj->removeFromQueue($taskId, Vars::CLASS_BUILDING);
        }

        $this->redirectTo('game.php?page=buildings');
    }

	public function show()
	{
		global $LNG, $PLANET, $USER;
		$config				= Config::get();

		$queueData	 		= $this->getQueueData();
		$Queue	 			= $queueData['queue'];
        $QueueCount			= array_sum($queueData['count']);
		$planetMaxFields    = CalculateMaxPlanetFields($PLANET);
		
		$isPlanetFull 		= ($planetMaxFields - $QueueCount - $PLANET['field_current']) <= 0;

		$BuildEnergy		= $USER[Vars::getElement(113)->name];
		$BuildLevelFactor   = 10;
		$BuildTemp          = $PLANET['temp_max'];

        $BuildInfoList      = array();

        $flag               = $PLANET['planet_type'] == PLANET ? Vars::FLAG_BUILD_ON_PLANET : Vars::FLAG_BUILD_ON_MOON;

        $busyBuildings      = array();

        $blockerQueueData   = $this->ecoObj->getQueueObj()->getBusyQueues();
        foreach($blockerQueueData as $task)
        {
            $busyBuildings  += ArrayUtil::combineArrayWithSingleElement(Vars::getElement($task['queueId'])->blocker, true);
        }

		foreach(Vars::getElements(Vars::CLASS_BUILDING, $flag) as $elementId => $elementObj)
		{
			if (!BuildUtil::requirementsAvailable($USER, $PLANET, $elementObj)) continue;

			$infoEnergy	= "";
			
			if(isset($queueData['elementLevel'][$elementId]))
			{
				$levelToBuild	= $queueData['elementLevel'][$elementId];
			}
			else
			{
				$levelToBuild	= $PLANET[$elementObj->name];
			}

			if($elementObj->hasFlag(Vars::FLAG_PRODUCTION))
			{
				$BuildLevel	= $PLANET[$elementObj->name];
				$Need		= eval(Economy::getProd($elementObj->calcProduction[911]));
									
				$BuildLevel	= $levelToBuild + 1;
				$Prod		= eval(Economy::getProd($elementObj->calcProduction[911]));
					
				$requireEnergy	= $Prod - $Need;
				$requireEnergy	= round($requireEnergy * $config->energySpeed);

				$text       = $requireEnergy < 0 ? $LNG['bd_need_engine'] : $LNG['bd_more_engine'];
                $infoEnergy	= sprintf($text, pretty_number(abs($requireEnergy)), $LNG['tech'][911]);
			}

			$costResources		= BuildUtil::getElementPrice($elementObj, $levelToBuild + 1);
            $destroyResources	= BuildUtil::getElementPrice($elementObj, $PLANET[$elementObj->name], true);

            $elementTime    	= BuildUtil::getBuildingTime($USER, $PLANET, $elementObj, $costResources);
            $destroyTime		= BuildUtil::getBuildingTime($USER, $PLANET, $elementObj, $destroyResources);

            // zero cost resource do not need to display
			$costResources		= array_filter($costResources);
			$destroyResources	= array_filter($destroyResources);

			$costOverflow		= BuildUtil::getRestPrice($USER, $PLANET, $elementObj, $costResources);
            $destroyOverflow	= BuildUtil::getRestPrice($USER, $PLANET, $elementObj, $destroyResources);

            $isBusy             = isset($busyBuildings[$elementId]);

            if($isBusy)
            {
                $buyable        = false;
            }
            elseif(isset($queueData['count'][$elementObj->queueId]) && $queueData['count'][$elementObj->queueId] >= Vars::getElement($elementObj->queueId)->maxCount)
            {
                $buyable    = false;
            }
            elseif(isset($queueData['count'][$elementObj->queueId]) && $queueData['count'][$elementObj->queueId] > 0)
            {
                $buyable    = true;
            }
            else
            {
                $buyable    = BuildUtil::isElementBuyable($USER, $PLANET, $elementObj, $costResources);
            }

			$BuildInfoList[$elementId]	= array(
				'level'				=> $PLANET[$elementObj->name],
				'maxLevel'			=> $elementObj->maxLevel,
				'infoEnergy'		=> $infoEnergy,
				'costResources'		=> $costResources,
				'costOverflow'		=> $costOverflow,
				'elementTime'    	=> $elementTime,
				'destroyResources'	=> $destroyResources,
				'destroyTime'		=> $destroyTime,
				'destroyOverflow'	=> $destroyOverflow,
				'buyable'			=> $buyable,
                'isBusy'			=> $isBusy,
				'levelToBuild'		=> $levelToBuild,
			);
		}

		
		if ($QueueCount != 0) {
			$this->tplObj->loadscript('buildlist.js');
		}

        $haveMissiles           = false;
        $missileElementList     = Vars::getElements(Vars::CLASS_MISSILE);
        foreach($missileElementList as $elementObj)
        {
            if($PLANET[$elementObj->name] > 0)
            {
                $haveMissiles   = true;
                break;
            }
        }
		
		$this->assign(array(
			'BuildInfoList'		=> $BuildInfoList,
			'isPlanetFull'		=> $isPlanetFull,
			'Queue'				=> $Queue,
			'HaveMissiles'		=> $haveMissiles,
		));
			
		$this->display('page.buildings.default.tpl');
	}
}