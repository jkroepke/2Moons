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
 * @info $elementResourceId: ShowResourcesPage.class.php 2746 2013-05-18 11:38:36Z slaver7 $
 * @link http://2moons.cc/
 */

class ShowResourcesPage extends AbstractGamePage
{
	public static $requireModule = MODULE_RESSOURCE_LIST;

	function __construct() 
	{
		parent::__construct();
	}
	
	function send()
	{
		global $USER, $PLANET;
		if ($USER['urlaubs_modus'] == 0)
		{
			$updateSQL	= array();
			if(!isset($_POST['prod']))
				$_POST['prod'] = array();


			$param	                = array(':planetId' => $PLANET['id']);
            $productionLevel        = HTTP::_GP('prod', array());
            $elementResourceList    = Vars::getElements(Vars::CLASS_RESOURCE, Vars::FLAG_ON_ECO_OVERVIEW);

			foreach($elementResourceList as $elementId => $elementObj)
			{
                if(!isset($productionLevel[$elementId])) continue;

                $value      = $productionLevel[$elementId];
				$fieldName  = $elementObj->name.'_porcent';

				if (!isset($PLANET[$fieldName]) || !in_array($value, range(0, 10))) continue;
				
				$updateSQL[]	= $fieldName." = :".$fieldName;
				$param[':'.$fieldName]		= (int) $value;
				$PLANET[$fieldName]			= $value;
			}

			if(!empty($updateSQL))
			{
				$sql	= 'UPDATE %%PLANETS%% SET '.implode(', ', $updateSQL).' WHERE id = :planetId;';

				Database::get()->update($sql, $param);

				$this->ecoObj->setData($USER, $PLANET);
				$this->ecoObj->ReBuildCache();
				list($USER, $PLANET)	= $this->ecoObj->getData();

				$PLANET['eco_hash'] = $this->ecoObj->CreateHash();
			}
		}
		$this->redirectTo('game.php?page=resources');
	}

	function show()
	{
		global $LNG, $USER, $PLANET;

		$config	                = Config::get();
        $elementResourceList    = Vars::getElements(Vars::CLASS_RESOURCE, array(Vars::FLAG_RESOURCE_PLANET , Vars::FLAG_ENERGY));
        $elementEnergyList      = Vars::getElements(NULL, Vars::FLAG_ENERGY);
        $elementProductionList  = Vars::getElements(NULL, Vars::FLAG_PRODUCTION);

		$planetIsOnProduction   = $USER['urlaubs_modus'] == 0 && $PLANET['planet_type'] == PLANET;

        $basicIncome            = array();
        $production             = array();
        $temp                   = array();
        $basicProduction        = array();
        $storage                = array();
        $totalProduction        = array();
        $dailyProduction        = array();
        $weeklyProduction       = array();
        $bonusProduction        = array();

        foreach($elementResourceList as $elementId => $elementObj)
		{
            $basicIncome[$elementId]        = $planetIsOnProduction ? $config->{$elementObj->name.'_basic_income'} : 0;
            $production[$elementId]         = 0;
            $bonusProduction[$elementId]    = 0;
            $temp[$elementId]               = array('plus' => 0, 'minus' => 0);

            if(isset($PLANET[$elementObj->name.'_max']))
            {
                $storage[$elementId]    = shortly_number($PLANET[$elementObj->name.'_max']);
            }

            $basicProduction[$elementId]	= $basicIncome[$elementId];
            if(in_array($elementId, array_keys($elementEnergyList)))
            {
                $basicProduction[$elementId]    *= $config->energySpeed;
                $totalProduction[$elementId]    = $PLANET[$elementObj->name] + $basicProduction[$elementId] + $PLANET[$elementObj->name.'_used'];
                $dailyProduction[$elementId]    = $totalProduction[$elementId] * 24;
                $weeklyProduction[$elementId]   = $totalProduction[$elementId] * 168;
            }
            else
            {
                $basicProduction[$elementId]    *= $config->resource_multiplier;
                $totalProduction[$elementId]    = $PLANET[$elementObj->name.'_perhour'] + $basicProduction[$elementId];
                $dailyProduction[$elementId]    = $totalProduction[$elementId];
                $weeklyProduction[$elementId]   = $totalProduction[$elementId];
            }
		}

		$productionList	= array();

		if($PLANET['energy_used'] != 0) {
			$prodLevel	= min(1, $PLANET['energy'] / abs($PLANET['energy_used']));
		} else {
			$prodLevel	= 0;
		}

		/* Data for eval */
		$BuildEnergy		= $USER[Vars::getElement(113)->name];
		$BuildTemp          = $PLANET['temp_max'];

		foreach($elementProductionList as $elementProductionId => $elementProductionObj)
		{
            $elementProductionName  = $elementProductionObj->name;
			if(empty($PLANET[$elementProductionName]) || empty($USER[$elementProductionName])) continue;

			$productionList[$elementProductionId]	= array(
				'production'	=> array(901 => 0, 902 => 0, 903 => 0, 911 => 0),
				'elementLevel'	=> $PLANET[$elementProductionName],
				'prodLevel'		=> $PLANET[$elementProductionName.'_porcent'],
			);

			/* Data for eval */
			$BuildLevel			= $PLANET[$elementProductionName];
			$BuildLevelFactor	= $PLANET[$elementProductionName.'_porcent'];

			foreach($elementResourceList as $elementResourceId => $elementResourceObj)
			{
				if(!isset($elementProductionObj->calcProduction[$elementResourceId])) continue;

				$productionAmount = eval(Economy::getProd($elementProductionObj->calcProduction[$elementResourceId]));

                if(in_array($elementResourceId, array_keys($elementEnergyList)))
				{
                    $productionAmount *= $config->energySpeed;
				}
				else
				{
                    $productionAmount *= $prodLevel * $config->resource_multiplier;
				}

                if($productionAmount > 0 && $PLANET[$elementResourceObj->name] == 0)
                {
                    $bonusProduction[$elementProductionId]  += PlayerUtil::getBonusValue($productionAmount, array('Resource', 'Resource'.$elementResourceId), $USER);
                }

				$productionList[$elementProductionId]['production'][$elementResourceId]	= $productionAmount;
			}
		}
			
		$prodSelector	= array();
		
		foreach(range(10, 0) as $percent)
        {
			$prodSelector[$percent]	= ($percent * 10).'%';
		}
		
		$this->assign(array(
			'header'			=> sprintf($LNG['rs_production_on_planet'], $PLANET['name']),
			'prodSelector'		=> $prodSelector,
			'productionList'	=> $productionList,
			'basicProduction'	=> $basicProduction,
			'totalProduction'	=> $totalProduction,
			'bonusProduction'	=> $bonusProduction,
			'dailyProduction'	=> $dailyProduction,
			'weeklyProduction'	=> $weeklyProduction,
			'storage'			=> $storage,
		));
		
		$this->display('page.resources.default.tpl');
	}
}
