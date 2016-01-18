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

class BannedBuildCache implements BuildCache
{
	function buildCache()
	{
		$Data	= Core::getDB()->query("SELECT userID, MAX(banTime) FROM ".BANNED." WHERE banTime > ".TIMESTAMP." GROUP BY userID;");
		$Bans	= array();
		while($Row = $Data->fetchObject())
		{
			$Bans[$Row->userID]	= $Row;
		}

		return $Bans;
	}
}
