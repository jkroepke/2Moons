<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
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
