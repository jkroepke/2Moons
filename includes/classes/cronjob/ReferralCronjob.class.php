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
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2009 Lucky
 * @copyright 2011 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2011-12-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class ReferralCronJob
{
	function run()
	{
		global $LNG, $LANG;
		
		$CONF	= Config::getAll(NULL, ROOT_UNI);
		
		if($CONF['ref_active'] != 1)
		{
			return;
		}
		
		$Users	= $GLOBALS['DATABASE']->query("SELECT user.`username`, user.`ref_id`, user.`id`, user.`lang` 
							  FROM ".USERS." user
							  INNER JOIN ".STATPOINTS." as stats
							  ON stats.`id_owner` = user.`id` AND stats.`stat_type` = '1' AND stats.`total_points` >= ".$CONF['ref_minpoints']."
							  WHERE user.`ref_bonus` = 1;");
							  
		$LANG->setDefault($CONF['lang']);
		while($User	= $GLOBALS['DATABASE']->fetch_array($Users))
		{
			$LANG->setUser($User['lang']);	
			$LANG->includeLang(array('L18N', 'INGAME', 'TECH'));
			$GLOBALS['DATABASE']->multi_query("UPDATE ".USERS." SET `darkmatter` = `darkmatter` + ".$CONF['ref_bonus']." WHERE `id` = ".$User['ref_id'].";UPDATE ".USERS." SET `ref_bonus` = `ref_bonus` = '0' WHERE `id` = ".$User['id'].";");
			$Message	= sprintf($LNG['sys_refferal_text'], $User['username'], pretty_number($CONF['ref_minpoints']), pretty_number($CONF['ref_bonus']), $LNG['tech'][921]);
			SendSimpleMessage($User['ref_id'], '', TIMESTAMP, 4, $LNG['sys_refferal_from'], sprintf($LNG['sys_refferal_title'], $User['username']), $Message);
		}
	}
}
?>