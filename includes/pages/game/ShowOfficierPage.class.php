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


class ShowOfficierPage extends AbstractGamePage
{
	public static $requireModule = 0;

	function __construct()
	{
		parent::__construct();
	}

    private function formatBonusList($elementObj)
    {
        global $LNG;
        $list   = array();

        foreach($elementObj->bonus as $bonusName => $bonusData)
        {
            if($bonusData['value'] == 0) continue;

            if($bonusData['unit'] === 'static')
            {
                $list[] = ($bonusData['value'] > 0 ? '+' : '').$bonusData['value'].' '.$LNG['bonus'][$bonusName];
            }
            else
            {
                $list[] = ($bonusData['value'] > 0 ? '+' : '').($bonusData['value'] * 100).'% '.$LNG['bonus'][$bonusName];
            }
        }

        return $list;
    }

    public function upgrade()
    {
        global $USER, $PLANET;
        $elementId = HTTP::_GP('elementId', 0);

        $elementObj = Vars::getElement($elementId);

        if(isModulAvalible(MODULE_OFFICIER) && $elementObj->class == Vars::CLASS_PERM_BONUS)
        {
            if($elementObj->maxLevel <= $USER[$elementObj->name])
            {
                return false;
            }

            if(!BuildUtil::requirementsAvailable($USER, $PLANET, $elementObj))
            {
                return false;
            }

            $costResources		= BuildUtil::getElementPrice($USER, $PLANET, $elementObj);

            if (!BuildUtil::isElementBuyable($USER, $PLANET, $elementObj, $costResources))
            {
                return false;
            }

            foreach($costResources as $resourceElementId => $value)
            {
                $resourceElementObj    = Vars::getElement($resourceElementId);
                if($resourceElementObj->hasFlag(Vars::FLAG_RESOURCE_PLANET))
                {
                    $PLANET[$resourceElementObj->name]	-= $costResources[$resourceElementId];
                }
                elseif($resourceElementObj->hasFlag(Vars::FLAG_RESOURCE_USER))
                {
                    $USER[$resourceElementObj->name]    -= $costResources[$resourceElementId];
                }
            }

            $USER[$elementObj->name]	+= 1;
            $this->ecoObj->saveToDatabase('USER', $elementObj->name);

            return true;

        }if(isModulAvalible(MODULE_OFFICIER) && $elementObj->class == Vars::CLASS_PERM_BONUS)
        {
            if(!BuildUtil::requirementsAvailable($USER, $PLANET, $elementObj))
            {
                return false;
            }

            $costResources		= BuildUtil::getElementPrice($USER, $PLANET, $elementObj);

            if (!BuildUtil::isElementBuyable($USER, $PLANET, $elementObj, $costResources))
            {
                return false;
            }

            foreach($costResources as $resourceElementId => $value)
            {
                $resourceElementObj    = Vars::getElement($resourceElementId);
                if($resourceElementObj->hasFlag(Vars::FLAG_RESOURCE_PLANET))
                {
                    $PLANET[$resourceElementObj->name]	-= $costResources[$resourceElementId];
                }
                elseif($resourceElementObj->hasFlag(Vars::FLAG_RESOURCE_USER))
                {
                    $USER[$resourceElementObj->name]    -= $costResources[$resourceElementId];
                }
            }

            $USER[$elementObj->name]	= max($USER[$elementObj->name], TIMESTAMP) + $elementObj->timeBonus;
            $this->ecoObj->saveToDatabase('USER', $elementObj->name);

            return true;
        }

        return false;
    }

	public function show()
	{
		global $USER, $PLANET, $LNG;


		$darkmatterList	= array();
		$officierList	= array();

		if(isModulAvalible(MODULE_DMEXTRAS))
		{
			foreach(Vars::getElements(Vars::CLASS_TEMP_BONUS) as $elementId => $elementObj)
			{
                if (!BuildUtil::requirementsAvailable($USER, $PLANET, $elementObj))
                    continue;

				$costResources		= BuildUtil::getElementPrice($elementObj, 1);
				$buyable			= BuildUtil::isElementBuyable($USER, $PLANET, $elementObj, $costResources);

                // zero cost resource do not need to display
                $costResources		= array_filter($costResources);

				$costOverflow		= BuildUtil::getRestPrice($USER, $PLANET, $elementObj, $costResources);

				$darkmatterList[$elementId]	= array(
					'timeLeft'		=> max($USER[$elementObj->name] - TIMESTAMP, 0),
					'costResources'	=> $costResources,
					'buyable'		=> $buyable,
					'time'			=> $elementObj->timeBonus,
					'costOverflow'	=> $costOverflow,
					'elementBonus'	=> $this->formatBonusList($elementObj),
				);
			}
		}

		if(isModulAvalible(MODULE_OFFICIER))
		{
            foreach(Vars::getElements(Vars::CLASS_PERM_BONUS) as $elementId => $elementObj)
			{
				if (!BuildUtil::requirementsAvailable($USER, $PLANET, $elementObj))
					continue;

                $costResources		= BuildUtil::getElementPrice($elementObj, $USER[$elementObj->name]);
				$buyable			= BuildUtil::isElementBuyable($USER, $PLANET, $elementObj, $costResources);

                // zero cost resource do not need to display
                $costResources		= array_filter($costResources);

				$costOverflow		= BuildUtil::getRestPrice($USER, $PLANET, $elementObj, $costResources);

				$officierList[$elementId]	= array(
					'level'			=> $USER[$elementObj->name],
					'maxLevel'		=> $elementObj->maxLevel,
					'costResources' => $costResources,
					'buyable'		=> $buyable,
					'costOverflow'	=> $costOverflow,
					'elementBonus'	=> $this->formatBonusList($elementObj),
				);
			}
		}

		$this->assign(array(
			'officierList'		=> $officierList,
			'darkmatterList'	=> $darkmatterList,
			'of_dm_trade'		=> sprintf($LNG['of_dm_trade'], $LNG['tech'][921]),
		));

		$this->display('page.officier.default.tpl');
	}
}