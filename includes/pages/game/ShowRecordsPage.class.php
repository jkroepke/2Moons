<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
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
		global $USER, $LNG, $reslist;

		$db = Database::get();

		$sql = "SELECT elementID, level, userID, username
		FROM %%USERS%%
		INNER JOIN %%RECORDS%% ON userID = id
		WHERE universe = :universe;";

		$recordResult = $db->select($sql, array(
			':universe'	=> Universe::current()
		));

		$defenseList	= array_fill_keys($reslist['defense'], array());
		$fleetList		= array_fill_keys($reslist['fleet'], array());
		$researchList	= array_fill_keys($reslist['tech'], array());
		$buildList		= array_fill_keys($reslist['build'], array());
		
		foreach($recordResult as $recordRow) {
			if (in_array($recordRow['elementID'], $reslist['defense'])) {
				$defenseList[$recordRow['elementID']][]		= $recordRow;
			} elseif (in_array($recordRow['elementID'], $reslist['fleet'])) {
				$fleetList[$recordRow['elementID']][]		= $recordRow;
			} elseif (in_array($recordRow['elementID'], $reslist['tech'])) {
				$researchList[$recordRow['elementID']][]	= $recordRow;
			} elseif (in_array($recordRow['elementID'], $reslist['build'])) {
				$buildList[$recordRow['elementID']][]		= $recordRow;
			}
		}

		require_once 'includes/classes/Cronjob.class.php';
		
		$this->assign(array(
			'defenseList'	=> $defenseList,
			'fleetList'		=> $fleetList,
			'researchList'	=> $researchList,
			'buildList'		=> $buildList,
			'update'		=> _date($LNG['php_tdformat'], Cronjob::getLastExecutionTime('statistic'), $USER['timezone']),
		));
		
		$this->display('page.records.default.tpl');
	}
}
 