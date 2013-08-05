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


class ShowRecordsPage extends AbstractGamePage
{
    public static $requireModule = MODULE_RECORDS;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show()
	{
		global $USER, $LNG;

		$db = Database::get();

		$sql = "SELECT elementID, level, userID, username
		FROM %%USERS%%
		INNER JOIN %%RECORDS%% ON userID = id
		WHERE universe = :universe;";

		$recordResult = $db->select($sql, array(
			':universe'	=> Universe::current()
		));

        $buildingElementIds = array_keys(Vars::getElements(Vars::CLASS_BUILDING));
        $techElementIds     = array_keys(Vars::getElements(Vars::CLASS_TECH));
        $fleetElementIds    = array_keys(Vars::getElements(Vars::CLASS_FLEET));
        $defenseElementIds  = array_keys(Vars::getElements(Vars::CLASS_DEFENSE));

		$buildList	        = ArrayUtil::combineArrayWithSingleElement($buildingElementIds, array());
		$techList	        = ArrayUtil::combineArrayWithSingleElement($techElementIds, array());
		$fleetList		    = ArrayUtil::combineArrayWithSingleElement($fleetElementIds, array());
		$defenseList        = ArrayUtil::combineArrayWithSingleElement($defenseElementIds, array());
		
		foreach($recordResult as $recordRow)
        {
			if (in_array($recordRow['elementID'], $buildingElementIds))
            {
                $buildList[$recordRow['elementID']][]   = $recordRow;
			}
            elseif (in_array($recordRow['elementID'], $techElementIds))
            {
                $techList[$recordRow['elementID']][]    = $recordRow;
            }
            elseif (in_array($recordRow['elementID'], $fleetElementIds))
            {
				$fleetList[$recordRow['elementID']][]   = $recordRow;
			}
            elseif (in_array($recordRow['elementID'], $defenseElementIds))
            {
                $defenseList[$recordRow['elementID']][] = $recordRow;
			}
		}

		require_once 'includes/classes/Cronjob.class.php';
		
		$this->assign(array(
            'buildList'		=> $buildList,
            'researchList'	=> $techList,
            'fleetList'		=> $fleetList,
			'defenseList'	=> $defenseList,
			'update'		=> _date($LNG['php_tdformat'], Cronjob::getLastExecutionTime('statistic'), $USER['timezone']),
		));
		
		$this->display('page.records.default.tpl');
	}
}
 