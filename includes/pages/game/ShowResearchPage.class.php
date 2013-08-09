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

require_once('AbstractGamePage.class.php');

class ShowResearchPage extends AbstractGamePage
{
	public static $requireModule = MODULE_RESEARCH;

	function __construct() 
	{
		parent::__construct();
	}

    public function build()
    {
        global $USER;
        $elementId  = HTTP::_GP('elementId', 0);
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0 && !empty($elementId))
        {
            $elementObj = Vars::getElement($elementId);
            if($elementObj->class == Vars::CLASS_TECH)
            {
                $this->ecoObj->addToQueue($elementObj, QueueManager::BUILD);
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
            $this->ecoObj->removeFromQueue($taskId, Vars::CLASS_TECH);
        }
        $this->redirectTo('game.php?page=buildings');
    }

    private function getQueueData()
    {
        global $LNG, $USER, $PLANET;

        $queueData  = $this->ecoObj->getQueueObj()->queryElementIds(array_keys(Vars::getElements(Vars::CLASS_TECH)));

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
                'planet'	=> $task['planetId'] != $PLANET['id'] ? $USER['PLANETS'][$task['planetId']]['name'] : false,
            );

            $elementLevel[$task['elementId']]   = $task['amount'];
            if(!isset($count[$task['queueId']]))
            {
                $count[$task['queueId']] = 0;
            }

            $count[$task['queueId']]++;
        }

        return array('queue' => $queue, 'elementLevel' => $elementLevel, 'count' => $count);
    }

	public function show()
	{
		global $PLANET, $USER, $LNG;
		
		if ($PLANET[Vars::getElement(31)->name] == 0)
		{
			$this->printMessage($LNG['bd_lab_required']);
		}

        if(!isset($USER['techNetwork']))
        {
            $USER['techNetwork']  = PlayerUtil::getLabLevelByNetwork($USER, $PLANET);
        }
		
		$bContinue		= $this->CheckLabSettingsInQueue($PLANET);
		
		$queueData		= $this->getQueueData();
        $Queue	 		= $queueData['queue'];
        $QueueCount		= array_sum($queueData['count']);
		$ResearchList	= array();

		foreach(Vars::getElements(Vars::CLASS_TECH) as $elementId => $elementObj)
		{
			if (!BuildUtil::requirementsAvailable($USER, $PLANET, $elementObj))
				continue;
				
			if(isset($queueData['elementLevel'][$elementId]))
			{
				$levelToBuild	= $queueData['elementLevel'][$elementId];
			}
			else
			{
				$levelToBuild	= $USER[$elementObj->name];
			}
			
			$costResources		= BuildUtil::getElementPrice($elementObj, $levelToBuild);
            $elementTime    	= BuildUtil::getBuildingTime($USER, $PLANET, $elementObj, $costResources);

            // zero cost resource do not need to display
            $costResources		= array_filter($costResources);

			$costOverflow		= BuildUtil::getRestPrice($USER, $PLANET, $elementObj, $costResources);
			$buyable			= $QueueCount != 0 || BuildUtil::isElementBuyable($USER, $PLANET, $elementObj, $costResources);

			$ResearchList[$elementId]	= array(
                'level'				=> $PLANET[$elementObj->name],
                'maxLevel'			=> $elementObj->maxLevel,
				'costResources'		=> $costResources,
				'costOverflow'		=> $costOverflow,
				'elementTime'    	=> $elementTime,
				'buyable'			=> $buyable,
				'levelToBuild'		=> $levelToBuild,
			);
		}
		
		$this->assign(array(
			'ResearchList'	=> $ResearchList,
			'IsLabinBuild'	=> !$bContinue,
			'IsFullQueue'	=> Config::get()->max_elements_tech == 0 || Config::get()->max_elements_tech == count($TechQueue),
			'Queue'			=> $Queue,
		));
		
		$this->display('page.research.default.tpl');
	}
}