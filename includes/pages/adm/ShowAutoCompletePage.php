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

if ($USER['authlevel'] == AUTH_USR)
{
	throw new Exception("Permission error!");
}

function ShowAutoCompletePage()
{
	$searchText	= HTTP::_GP('term', '', UTF8_SUPPORT);
	$searchList	= array();
	
	if(empty($searchText) || $searchText === '#') {
		echo json_encode(array());
		exit;
	}
	
	if(substr($searchText, 0, 1) === '#')
	{
		$where = 'id = '.((int) substr($searchText, 1));
		$orderBy = ' ORDER BY id ASC';
	}
	else
	{
		$where = "username LIKE '%".$GLOBALS['DATABASE']->escape($searchText, true)."%'";
		$orderBy = " ORDER BY (IF(username = '".$GLOBALS['DATABASE']->sql_escape($searchText, true)."', 1, 0) + IF(username LIKE '".$GLOBALS['DATABASE']->sql_escape($searchText, true)."%', 1, 0)) DESC, username";
	}
	
	$userRaw		= $GLOBALS['DATABASE']->query("SELECT id, username FROM ".USERS." WHERE universe = ".Universe::getEmulated()." AND ".$where.$orderBy." LIMIT 20");
	while($userRow = $GLOBALS['DATABASE']->fetch_array($userRaw))
	{
		$searchList[]	= array(
			'label' => $userRow['username'].' (ID:'.$userRow['id'].')', 
			'value' => $userRow['username']
		);
	}
	
	echo json_encode($searchList);
	exit;
}