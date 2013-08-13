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
 

class ShowShipyardPage extends AbstractGamePage
{
	public static $requireModule = 0;
	
	public static $defaultController = 'show';

	function __construct() 
	{
		parent::__construct();
	}
    public function build()
    {
        global $USER;
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0)
        {
            $elements  = HTTP::_GP('element', array());
            foreach($elements as $elementId => $amount)
            {
                $elementObj = Vars::getElement($elementId);
                if($elementObj->class == Vars::CLASS_FLEET || $elementObj->class == Vars::CLASS_DEFENSE || $elementObj->class == Vars::CLASS_MISSILE)
                {
                    $this->ecoObj->addToQueue($elementObj, QueueManager::SHIPYARD, $amount);
                }
            }
        }

        $this->redirectTo('game.php?page=shipyard&mode='.HTTP::_GP('redirectMode', ''));
    }

    public function cancel()
    {
        global $USER;
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0)
        {
			$taskIds  = HTTP::_GP('taskId', array());
			foreach($taskIds as $taskId)
			{
				$this->ecoObj->removeFromQueue($taskId, array(Vars::CLASS_FLEET, Vars::CLASS_DEFENSE, Vars::CLASS_MISSILE));
			}
        }

        $this->redirectTo('game.php?page=shipyard&mode='.HTTP::_GP('redirectMode', ''));
    }

    private function getQueueData()
    {
        global $LNG, $USER, $PLANET;

        $elementIds = array_merge(
			array_keys(Vars::getElements(Vars::CLASS_FLEET)),
			array_keys(Vars::getElements(Vars::CLASS_DEFENSE)),
			array_keys(Vars::getElements(Vars::CLASS_DEFENSE))
		);

        $queueData  	= $this->ecoObj->getQueueObj()->getTasksByElementId($elementIds);

        $queue          = array();
        $elementLevel   = array();
        $count          = array();
        $info 	        = array();

        foreach($queueData as $task)
        {
            if (($task['endBuildTime'] + $task['buildTime'] * ($task['amount'] - 1)) < TIMESTAMP)
                continue;

            $queue[$task['taskId']] = array(
                'elementId'		=> $task['elementId'],
                'amount' 		=> $task['amount'],
                'buildTime' 	=> $task['buildTime'],
                'endBuildTime' 	=> _date('U', $task['endBuildTime'], $USER['timezone']),
            );

            if(!isset($elementLevel[$task['elementId']]))
            {
                $elementLevel[$task['elementId']]   = 0;
            }

            $elementLevel[$task['elementId']]   += $task['amount'];
            if(!isset($count[$task['queueId']]))
            {
                $count[$task['queueId']] = 0;
            }

            $count[$task['queueId']]++;
        }

		if(!empty($queue))
		{
			$lastTask	= end($queue);
			$firstTask	= reset($queue);
			$info['restTime']		= $firstTask['endBuildTime'] - TIMESTAMP;
			$info['endBuildTime']	= _date($LNG['php_tdformat'], $lastTask['endBuildTime'] + $lastTask['buildTime'] * ($lastTask['amount'] - 1), $USER['timezone']);
		}

        return array('queue' => $queue, 'elementLevel' => $elementLevel, 'count' => $count, 'info' => $info);
    }
	
	public function show()
	{
		global $USER, $PLANET, $LNG;
		
		if ($PLANET[Vars::getElement(21)->name] == 0)
		{
			$this->printMessage($LNG['bd_shipyard_required']);
		}

        $queueData		= $this->getQueueData();

        $busyQueues 	= array();
		$buildList		= array();
		$elementList	= array();

        $isShipyardInBuild  = false;
		
		$mode		= HTTP::_GP('mode', 'fleet');
		
		if($mode == 'defense')
        {
			$elementShipyardList	= Vars::getElements(Vars::CLASS_DEFENSE) + Vars::getElements(Vars::CLASS_MISSILE);
        }
        else
        {
			$elementShipyardList	= Vars::getElements(Vars::CLASS_FLEET);
		}

        $tempPlanet = $PLANET;

        foreach($queueData['elementLevel'] as $elementId => $value)
        {
            $tempPlanet[Vars::getElement($elementId)->name]  += $value;
        }

        $maxMissiles    = BuildUtil::maxBuildableMissiles($USER, $tempPlanet, $this->ecoObj->getQueueObj());
		
		foreach($elementShipyardList as $elementId => $elementObj)
		{
			if(!BuildUtil::requirementsAvailable($USER, $PLANET, $elementObj))
				continue;
			
			$costResources		= BuildUtil::getElementPrice($elementObj, 1);
			$elementTime    	= BuildUtil::getBuildingTime($USER, $PLANET, $elementObj, $costResources);

            $maxBuildable		= BuildUtil::maxBuildableElements($USER, $PLANET, $elementObj, $costResources);

            // zero cost resource do not need to display
            $costResources		= array_filter($costResources);
            $costOverflow		= BuildUtil::getRestPrice($USER, $PLANET, $elementObj, $costResources);

			if(isset($maxMissiles[$elementId]))
            {
				$maxBuildable	= min($maxBuildable, $maxMissiles[$elementId]);
			}

            if(!isset($busyQueues[$elementObj->queueId]))
            {
                $tasks  = $this->ecoObj->getQueueObj()->getTasksByElementId(Vars::getElement($elementObj->queueId)->blocker);
                $busyQueues[$elementObj->queueId] = count($tasks) != 0;
            }

            $isBusy             = $busyQueues[$elementObj->queueId];

            if($isBusy)
            {
                $buyable            = false;
                $isShipyardInBuild  = true;
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
			
			$elementList[$elementId]	= array(
				'available'			=> $PLANET[$elementObj->name],
                'maxLevel'			=> $elementObj->maxLevel,
				'isBusy'			=> $isBusy,
				'costResources'		=> $costResources,
				'costOverflow'		=> $costOverflow,
				'elementTime'    	=> $elementTime,
				'buyable'			=> $buyable,
				'maxBuildable'		=> floattostring($maxBuildable),
			);
		}
		
		$this->assign(array(
            'queueData'         => $queueData,
			'elementList'	    => $elementList,
			'isShipyardInBuild'	=> $isShipyardInBuild,
			'BuildList'		    => $buildList,
            'maxlength'		    => strlen(Config::get()->max_fleet_per_build),
			'mode'			    => $mode,
		));

		$this->display('page.shipyard.default.tpl');
	}
}