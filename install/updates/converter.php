<?php

/**
 *  2Moons
 *  Copyright (C) 2011 Jan Kröpke
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
 * @package   2Moons
 * @author    Jan Kröpke <info@2moons.cc>
 * @copyright 2009 Lucky
 * @copyright 2011 Jan Kröpke <info@2moons.cc>
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version   1.5 (2011-07-31)
 * @info $Id$
 * @link      http://2moons.cc/
 */

define('MODE', 'INSTALL');
define('ROOT_PATH', str_replace('\\', '/', dirname(dirname(__FILE__))) . '/');


set_include_path(ROOT_PATH);
chdir(ROOT_PATH);

require 'includes/common.php';
$THEME->setUserTheme('gow');
$LNG = new Language;
$LNG->getUserAgentLanguage();
$LNG->includeData(array('L18N', 'INGAME', 'INSTALL', 'CUSTOM'));


$template = new template();
$template->assign(array(
    'lang' => $LNG->getLanguage(),
    'Selector' => $LNG->getAllowedLangs(false),
    'title' => $LNG['title_install'] . ' &bull; 2Moons',
    'header' => $LNG['menu_install'],
    'canUpgrade' => file_exists('includes/config.php') && filesize('includes/config.php') !== 0
));

$db = Database::get();
$insertData = array();

require 'includes/classes/BuildUtil.class.php';
require 'includes/classes/Element.class.php';
require 'includes/classes/Vars.class.php';
Vars::init();

function execQuery($data, $type)
{
    switch ($type) {
        case 'queue':
            $query = "INSERT INTO  `uni1_queue` (`queueId` ,`userId` ,`planetId` ,`elementId` ,`buildTime` ,`endBuildTime` ,`amount` ,`taskType`) VALUES " . implode(', ', $data) . ";";
            break;
        case 'fleet':
            $query = "INSERT INTO  `uni1_fleet_elements` (`fleetId` ,`elemenId` ,`amount`) VALUES " . implode(', ', $data) . ";";
            break;
    }
    echo($query);
}


## BUILDINGS & HANGAR ##
$sql = "SELECT * FROM %%PLANETS%% ORDER BY id_owner ASC;";
$Rows = $db->select($sql);

foreach ($Rows as $Row) {
    $userId = $Row['id_owner'];
    $planetId = $Row['id'];
    $partTime = $Row['b_hangar'];
    $buildingdata = unserialize($Row['b_building_id']);
    $hangardata = unserialize($Row['b_hangar_id']);
    if (!isset($userData) || $userData['id'] != $userId)
        $userData = $db->selectSingle("SELECT * FROM %%USERS%% WHERE id = :userID;", array(':userID' => $userId));
    $endTime = $Row['last_update'];
    if (is_array($buildingdata)) {
        foreach ($buildingdata as $data) {
            list($elementId, $amount, $time, , $mode) = $data;
            $time = BuildUtil::getBuildingTime($userData, $Row, Vars::getElement($elementId), NULL, false, 1);
            $endTime += $time;
            $insertData[] = "(1001,  $userId,  $planetId,  $elementId,  $time,  $endTime,  $amount,  " . ($mode == 'build' ? 1 : 2) . ")";
            if (count($insertData) >= 100) {
                execQuery($insertData, 'queue');
                $insertData = array();
            }
        }
    }
    if (is_array($hangardata)) {
        $first = true;
        foreach ($hangardata as $data) {
            list($elementId, $amount) = $data;
            $time = BuildUtil::getBuildingTime($userData, $Row, Vars::getElement($elementId), NULL, false, 1);
            $endTime = ($first ? $Row['last_update'] + $time - $partTime : 0);
            $first = false;
            $insertData[] = "(1003,  $userId,  $planetId,  $elementId,  $time,  $endTime,  $amount,  4)";
            if (count($insertData) >= 100) {
                execQuery($insertData, 'queue');
                $insertData = array();
            }
        }
    }
}


## TECH ##
$sql = "SELECT * FROM %%USERS%%;";
$Rows = $db->select($sql);

foreach ($Rows as $Row) {
    if (!empty($Row['b_tech_queue'])) {
        $userId = $Row['id'];
        $datas = unserialize($Row['b_tech_queue']);
        foreach ($datas as $data) {
            list($elementId, $amount, $time, $endTime, $planetId) = $data;
            $insertData[] = "(1002,  $userId,  $planetId,  $elementId,  $time,  $endTime,  $amount,  3)";
            if (count($insertData) >= 100) {
                execQuery($insertData, 'queue');
                $insertData = array();
            }
        }
    }
}

execQuery($insertData, 'queue');


## FlEET ##
if (!empty($insertData)) {
    $insertData = array();
}
$sql = "SELECT * FROM %%FLEETS%%;";
$Rows = $db->select($sql);

foreach ($Rows as $Row) {
    {
        $fleetId = $Row['fleetId'];
        $insertData[] = "($fleetId,  901,  " . $Row['fleet_resource_metal'] . ")";
        $insertData[] = "($fleetId,  902,  " . $Row['fleet_resource_crystal'] . ")";
        $insertData[] = "($fleetId,  903,  " . $Row['fleet_resource_deuterium'] . ")";
		if(!empty($Row['fleet_resource_darkmatter']))
		{
			$insertData[] = "($fleetId,  921,  " . $Row['fleet_resource_darkmatter'] . ")";
		}
        $datas = explode(';', $Row['fleet_array']);
        foreach ($datas as $data) {
            list($elementId, $amount) = explode(',', $data);
            $insertData[] = "($fleetId,  $elementId,  $amount)";
            if (count($insertData) >= 100) {
                execQuery($insertData, 'fleet');
                $insertData = array();
            }
        }
    }
}

execQuery($insertData, 'fleet');