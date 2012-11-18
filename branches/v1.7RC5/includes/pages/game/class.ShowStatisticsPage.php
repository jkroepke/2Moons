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
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */


class ShowStatisticsPage extends AbstractPage
{
    public static $requireModule = MODULE_STATISTICS;

	function __construct() 
	{
		parent::__construct();
	}

    function show()
    {
        global $USER, $CONF, $LNG, $UNI;

        $who   	= HTTP::_GP('who', 1);
        $type  	= HTTP::_GP('type', 1);
        $range 	= HTTP::_GP('range', 1);

        switch ($type)
        {
            case 2:
                $Order   = "fleet_rank";
                $Points  = "fleet_points";
                $Rank    = "fleet_rank";
                $OldRank = "fleet_old_rank";
            break;
            case 3:
                $Order   = "tech_rank";
                $Points  = "tech_points";
                $Rank    = "tech_rank";
                $OldRank = "tech_old_rank";
            break;
            case 4:
                $Order   = "build_rank";
                $Points  = "build_points";
                $Rank    = "build_rank";
                $OldRank = "build_old_rank";
            break;
            case 5:
                $Order   = "defs_rank";
                $Points  = "defs_points";
                $Rank    = "defs_rank";
                $OldRank = "defs_old_rank";
            break;
            default:
                $Order   = "total_rank";
                $Points  = "total_points";
                $Rank    = "total_rank";
                $OldRank = "total_old_rank";
            break;
        }

        $RangeList  = array();

        switch($who)
        {
            case 1:
                $MaxUsers 	= Config::get('users_amount');
                $range		= min($range, $MaxUsers);
                $LastPage 	= max(1, ceil($MaxUsers / 100));

                for ($Page = 0; $Page < $LastPage; $Page++)
                {
                    $PageValue      				= ($Page * 100) + 1;
                    $PageRange      				= $PageValue + 99;
                    $Selector['range'][$PageValue] 	= $PageValue."-".$PageRange;
                }

                $start = max(floor(($range - 1) / 100) * 100, 0);

                $stats_sql	=	'SELECT DISTINCT s.*, u.id, u.username, u.ally_id, a.ally_name FROM '.STATPOINTS.' as s
                INNER JOIN '.USERS.' as u ON u.id = s.id_owner
                LEFT JOIN '.ALLIANCE.' as a ON a.id = s.id_ally
                WHERE s.`universe` = '.$UNI.' AND s.`stat_type` = 1 '.((Config::get('stat') == 2)?'AND u.`authlevel` < '.Config::get('stat_level').' ':'').'
                ORDER BY `'. $Order .'` ASC LIMIT '. $start .',100;';

                $query = $GLOBALS['DATABASE']->query($stats_sql);

                $RangeList	= array();

                while ($StatRow = $GLOBALS['DATABASE']->fetch_array($query))
                {
                    $RangeList[]	= array(
                        'id'		=> $StatRow['id'],
                        'name'		=> $StatRow['username'],
                        'points'	=> pretty_number($StatRow[$Points]),
                        'allyid'	=> $StatRow['ally_id'],
                        'rank'		=> $StatRow[$Rank],
                        'allyname'	=> $StatRow['ally_name'],
                        'ranking'	=> $StatRow[$OldRank] - $StatRow[$Rank],
                    );
                }

                $GLOBALS['DATABASE']->free_result($query);
            break;
            case 2:
                $MaxAllys 	= $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".ALLIANCE." WHERE `ally_universe` = '".$UNI."';");
                $range		= min($range, $MaxAllys);
                $LastPage 	= max(1, ceil($MaxAllys / 100));
				
                for ($Page = 0; $Page < $LastPage; $Page++)
                {
                    $PageValue      				= ($Page * 100) + 1;
                    $PageRange      				= $PageValue + 99;
                    $Selector['range'][$PageValue] 	= $PageValue."-".$PageRange;
                }

                $start = max(floor(($range - 1) / 100) * 100, 0);

                $stats_sql	=	'SELECT DISTINCT s.*, a.id, a.ally_members, a.ally_name FROM '.STATPOINTS.' as s
                INNER JOIN '.ALLIANCE.' as a ON a.id = s.id_owner
                WHERE `universe` = '.$UNI.' AND `stat_type` = 2
                ORDER BY `'. $Order .'` ASC LIMIT '. $start .',100;';

                $query = $GLOBALS['DATABASE']->query($stats_sql);

                while ($StatRow = $GLOBALS['DATABASE']->fetch_array($query))
                {
                    $RangeList[]	= array(
                        'id'		=> $StatRow['id'],
                        'name'		=> $StatRow['ally_name'],
                        'members'	=> $StatRow['ally_members'],
                        'rank'		=> $StatRow[$Rank],
                        'mppoints'	=> pretty_number(floor($StatRow[$Points] / $StatRow['ally_members'])),
                        'points'	=> pretty_number($StatRow[$Points]),
                        'ranking'	=> $StatRow[$OldRank] - $StatRow[$Rank],
                    );
                }

                $GLOBALS['DATABASE']->free_result($query);
            break;
        }

        $Selector['who'] 	= array(1 => $LNG['st_player'], 2 => $LNG['st_alliance']);
        $Selector['type']	= array(1 => $LNG['st_points'], 2 => $LNG['st_fleets'], 3 => $LNG['st_researh'], 4 => $LNG['st_buildings'], 5 => $LNG['st_defenses']);

        $this->tplObj->assign_vars(array(
            'Selectors'				=> $Selector,
            'who'					=> $who,
            'type'					=> $type,
            'range'					=> floor(($range - 1) / 100) * 100 + 1,
            'RangeList'				=> $RangeList,
            'CUser_ally'			=> $USER['ally_id'],
            'CUser_id'				=> $USER['id'],
            'stat_date'				=> _date($LNG['php_tdformat'], Config::get('stat_last_update'), $USER['timezone']),
        ));

        $this->display('page.statistics.default.tpl');
    }
}