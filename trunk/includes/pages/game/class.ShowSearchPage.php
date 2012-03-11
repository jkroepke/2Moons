<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
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
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class ShowSearchPage extends AbstractPage
{
	public static $requireModule = MODULE_SEARCH;
	
	function __construct() {
		parent::__construct();
	}

	static function _getSearchList($seachMode, $searchText, $maxResult)
	{
		global $UNI;
				
		$Limit		= $maxResult === -1 ? "" : "LIMIT ".$maxResult;
		
		$searchList	= array();

		switch($seachMode) {
			case 'playername':
				$searchResult = $GLOBALS['DATABASE']->query("SELECT 
				a.id, a.username, a.ally_id, a.galaxy, a.system, a.planet, b.name, c.total_rank, d.ally_name
				FROM ".USERS." as a 
				INNER JOIN ".PLANETS." as b ON b.id = a.id_planet 
				LEFT JOIN ".STATPOINTS." as c ON c.id_owner = a.id AND c.stat_type = 1
				LEFT JOIN ".ALLIANCE." as d ON d.id = a.ally_id
				WHERE a.universe = ".$UNI." AND a.username LIKE '%".$GLOBALS['DATABASE']->sql_escape($searchText, true)."%'
				ORDER BY (
				  IF(a.username = '".$GLOBALS['DATABASE']->sql_escape($searchText, true)."', 1, 0)
				  + IF(a.username LIKE '".$GLOBALS['DATABASE']->sql_escape($searchText, true)."%', 1, 0)
				) DESC, a.username ASC ".$Limit.";");
				
				while($searchRow = $GLOBALS['DATABASE']->fetch_array($searchResult))
				{
					$searchList[]	= array(
						'planetname'	=> $searchRow['name'],
						'username' 		=> $searchRow['username'],
						'userid' 		=> $searchRow['id'],
						'allyname'	 	=> $searchRow['ally_name'],
						'allyid'		=> $searchRow['ally_id'],
						'galaxy' 		=> $searchRow['galaxy'],
						'system'		=> $searchRow['system'],
						'planet'		=> $searchRow['planet'],
						'rank'			=> $searchRow['total_rank'],
					);	
				}
				
				$GLOBALS['DATABASE']->free_result($searchResult);
			break;
			case 'planetname':
				$searchResult = $GLOBALS['DATABASE']->query("SELECT 
				a.name, a.galaxy, a.planet, a.system,
				b.id, b.ally_id, b.username, 
				c.total_rank, 
				d.ally_name 
				FROM ".PLANETS." as a 
				INNER JOIN ".USERS." as b ON b.id = a.id_owner 
				LEFT JOIN  ".STATPOINTS." as c ON c.id_owner = b.id AND c.stat_type = 1
				LEFT JOIN ".ALLIANCE." as d ON d.id = b.ally_id
				WHERE a.universe = ".$UNI." AND a.name LIKE '%".$GLOBALS['DATABASE']->sql_escape($searchText, true)."%'
				ORDER BY (
				  IF(a.name = '".$GLOBALS['DATABASE']->sql_escape($searchText, true)."', 1, 0)
				  + IF(a.name LIKE '".$GLOBALS['DATABASE']->sql_escape($searchText, true)."%', 1, 0)
				) DESC, a.name ASC ".$Limit.";");
				
				while($searchRow = $GLOBALS['DATABASE']->fetch_array($searchResult))
				{
					$searchList[]	= array(
						'planetname'	=> $searchRow['name'],
						'username' 		=> $searchRow['username'],
						'userid' 		=> $searchRow['id'],
						'allyname'	 	=> $searchRow['ally_name'],
						'allyid'		=> $searchRow['ally_id'],
						'galaxy' 		=> $searchRow['galaxy'],
						'system'		=> $searchRow['system'],
						'planet'		=> $searchRow['planet'],
						'rank'			=> $searchRow['total_rank'],
					);	
				}
				
				$GLOBALS['DATABASE']->free_result($searchResult);
			break;
			case "allytag":
				$searchResult = $GLOBALS['DATABASE']->query("SELECT 
				a.id, a.ally_name, a.ally_tag, a.ally_members, 
				c.total_points FROM ".ALLIANCE." as a 
				LEFT JOIN ".STATPOINTS." as c ON c.stat_type = 1 AND c.id_owner = a.id 
				WHERE a.ally_universe = ".$UNI." AND a.ally_tag LIKE '%".$GLOBALS['DATABASE']->sql_escape($searchText, true)."%'
				ORDER BY (
				  IF(a.ally_tag = '".$GLOBALS['DATABASE']->sql_escape($searchText, true)."', 1, 0)
				  + IF(a.ally_tag LIKE '".$GLOBALS['DATABASE']->sql_escape($searchText, true)."%', 1, 0)
				) DESC, a.ally_tag ASC ".$Limit.";");
				while($searchRow = $GLOBALS['DATABASE']->fetch_array($searchResult))
				{
					$searchList[]	= array(
						'allypoints'	=> pretty_number($searchRow['total_points']),
						'allytag'		=> $searchRow['ally_tag'],
						'allymembers'	=> $searchRow['ally_members'],
						'allyname'		=> $searchRow['ally_name'],
					);
				}
				
				$GLOBALS['DATABASE']->free_result($searchResult);
			break;
			case "allyname":
				$searchResult = $GLOBALS['DATABASE']->query("SELECT 
				a.ally_name, a.ally_tag, a.ally_members, 
				b.total_points FROM ".ALLIANCE." as a
				LEFT JOIN ".STATPOINTS." as b ON b.stat_type = 1 AND b.id_owner = a.id
				WHERE a.ally_universe = ".$UNI." AND a.ally_name LIKE '%".$GLOBALS['DATABASE']->sql_escape($searchText, true)."%'
				ORDER BY (
				  IF(a.ally_name = '".$GLOBALS['DATABASE']->sql_escape($searchText, true)."', 1, 0)
				  + IF(a.ally_name LIKE '".$GLOBALS['DATABASE']->sql_escape($searchText, true)."%', 1, 0)
				) DESC,a.ally_name ASC ".$Limit.";");
				
				while($searchRow = $GLOBALS['DATABASE']->fetch_array($searchResult))
				{
					$searchList[]	= array(
						'allypoints'	=> pretty_number($searchRow['total_points']),
						'allytag'		=> $searchRow['ally_tag'],
						'allymembers'	=> $searchRow['ally_members'],
						'allyname'		=> $searchRow['ally_name'],
					);
				}
				
				$GLOBALS['DATABASE']->free_result($searchResult);
			break;
		}
		
		return $searchList;
	}
	
	function autocomplete()
	{
		global $LNG;
		
		$this->setWindow('ajax');
		
		$seachMode 	= HTTP::_GP('type', 'playername');
		$searchText	= HTTP::_GP('term', '', UTF8_SUPPORT);
		
		$searchList	= array();
		
		$seachModes	= explode('|', $seachMode);
		
		if(empty($searchText)) {
			$this->sendJSON(array());
		}
		
		foreach($seachModes as $search)
		{
			$searchData	= self::_getSearchList($search, $searchText, 5);
			foreach($searchData as $data) {
				switch($search) {
					case 'playername':
						$searchList[]	= array('label' => str_replace($searchText, '<b>'.$searchText.'</b>', $data['username']), 'category' => $LNG['sh_player_name'], 'type' => 'playername');
					break;
					case 'planetname':
						$searchList[]	= array('label' => str_replace($searchText, '<b>'.$searchText.'</b>', $data['username']), 'category' => $LNG['sh_planet_name'], 'type' => 'planetname');
					break;
					case "allytag":
						$searchList[]	= array('label' => str_replace($searchText, '<b>'.$searchText.'</b>', $data['allytag']), 'category' => $LNG['sh_alliance_tag'], 'type' => 'allytag');
					break;
					case "allyname":
						$searchList[]	= array('label' => str_replace($searchText, '<b>'.$searchText.'</b>', $data['allyname']), 'category' => $LNG['sh_alliance_name'], 'type' => 'allyname');
					break;
				}
			}
		}
		
		$this->sendJSON($searchList);
	}
	
	function result()
	{
		global $THEME;
		
		$this->initTemplate();
		$this->setWindow('ajax');
		
		$seachMode 	= HTTP::_GP('type', 'playername');
		$searchText	= HTTP::_GP('search', '', UTF8_SUPPORT);
		
		$searchList	= array();
		
		if(!empty($searchText))
		{
			$searchList	= self::_getSearchList($seachMode, $searchText, SEARCH_LIMIT);
		}
		
		$this->tplObj->assign_vars(array(
			'searchList'	=> $searchList,
            'dpath'			=> $THEME->getTheme(),
		));
		
		$templateSuffix	= ($seachMode === "allyname" || $seachMode === "allytag") ? "ally" : "default";
		
		$this->display('page.search.result.'.$templateSuffix.'.tpl');
	}
	
	function show()
	{
		global $LNG, $THEME;
		
		$seachMode 		= HTTP::_GP('type', 'playername');
		
		$modeSelector	= array('playername' => $LNG['sh_player_name'], 'planetname' => $LNG['sh_planet_name'], 'allytag' => $LNG['sh_alliance_tag'], 'allyname' => $LNG['sh_alliance_name']);
		$this->tplObj->loadscript('search.js');
		$this->tplObj->assign_vars(array(
			'modeSelector'	=> $modeSelector,
			'seachMode'		=> $seachMode,
		));
		
		$this->display('page.search.default.tpl');
	}
}
?>