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

class CleanerCronjob
{
	function run()
	{
		$CONF	= Config::getAll(NULL, ROOT_UNI);
		
		$GLOBALS['DATABASE']->query("LOCK TABLES ".ALLIANCE." WRITE, ".BUDDY." WRITE, ".CONFIG." WRITE, ".FLEETS." WRITE, ".NOTES." WRITE, ".MESSAGES." WRITE, ".PLANETS." WRITE, ".RW." WRITE, ".SESSION." WRITE, ".STATPOINTS." WRITE, ".TOPKB." WRITE, ".TOPKB_USERS." WRITE, ".USERS." WRITE;");
	
		//Delete old messages
		$del_before 	= TIMESTAMP - ($CONF['del_oldstuff'] * 86400);
		$del_inactive 	= TIMESTAMP - ($CONF['del_user_automatic'] * 86400);
		$del_deleted 	= TIMESTAMP - ($CONF['del_user_manually'] * 86400);

		$GLOBALS['DATABASE']->multi_query("DELETE FROM ".MESSAGES." WHERE `message_time` < '". $del_before ."';
						  DELETE FROM ".ALLIANCE." WHERE `ally_members` = '0';
						  DELETE FROM ".PLANETS." WHERE `destruyed` < ".TIMESTAMP." AND `destruyed` != 0;
						  DELETE FROM ".SESSION." WHERE `lastonline` < '".(TIMESTAMP - SESSION_LIFETIME)."';
						  UPDATE ".USERS." SET `email_2` = `email` WHERE `setmail` < '".TIMESTAMP."';");

		$ChooseToDelete = $GLOBALS['DATABASE']->query("SELECT `id` FROM `".USERS."` WHERE `authlevel` = '".AUTH_USR."' AND ((`db_deaktjava` != 0 AND `db_deaktjava` < '".$del_deleted."')".($del_inactive == TIMESTAMP ? "" : " OR `onlinetime` < '".$del_inactive."'").");");

		if(isset($ChooseToDelete))
		{
			include_once(ROOT_PATH.'includes/functions/DeleteSelectedUser.php');
			while($delete = $GLOBALS['DATABASE']->fetch_array($ChooseToDelete))
			{
				DeleteSelectedUser($delete['id']);
			}	
		}
		
		$GLOBALS['DATABASE']->free_result($ChooseToDelete);
		
		foreach($this->Unis as $Uni)
		{
			$TopKBLow		= $GLOBALS['DATABASE']->countquery("SELECT units FROM ".TOPKB." WHERE `universe` = ".$Uni." ORDER BY units DESC LIMIT 99,1;");
			if(isset($TopKBLow))
				$GLOBALS['DATABASE']->query("DELETE ".TOPKB.", ".TOPKB_USERS." FROM ".TOPKB." INNER JOIN ".TOPKB_USERS." USING (rid) WHERE `universe` = ".$Uni." AND `units` < ".$TopKBLow.";");
		}

		$GLOBALS['DATABASE']->query("DELETE FROM ".RW." WHERE `time` < ". $del_before ." AND `rid` NOT IN (SELECT `rid` FROM ".TOPKB.");");
		$GLOBALS['DATABASE']->query("UNLOCK TABLES;");
	}
}
?>