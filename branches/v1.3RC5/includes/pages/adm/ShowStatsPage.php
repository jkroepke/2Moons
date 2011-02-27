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
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowStatsPage() 
{
	global $LNG, $CONF;
	if ($_POST)
	{
		$CONF['stat_settings']				= request_var('stat_settings', 0);
		$CONF['stat'] 						= request_var('stat', 0);
		$CONF['stat_update_time']			= request_var('stat_update_time', 0);
		$CONF['stat_level']					= request_var('stat_level', 0);
		
		update_config(array(
			'stat_settings' =>  $CONF['stat_settings'], 
			'stat' => $CONF['stat'],
			'stat_update_time' => $CONF['stat_update_time'],
			'stat_level' => $CONF['stat_level']), true);
		
	}
	
	$template	= new template();

	$template->assign_vars(array(	
		'stat_level'						=> $CONF['stat_level'],
		'stat_update_time'					=> $CONF['stat_update_time'],
		'stat'								=> $CONF['stat'],
		'stat_settings'						=> $CONF['stat_settings'],
		'timeact'							=> date('d. M y H:i:s T', $CONF['stat_last_update']),
		'cs_timeact_1'						=> $LNG['cs_timeact_1'],
		'cs_access_lvl'						=> $LNG['cs_access_lvl'],
		'cs_points_to_zero'					=> $LNG['cs_points_to_zero'],
		'cs_time_between_updates'			=> $LNG['cs_time_between_updates'],
		'cs_point_per_resources_used'		=> $LNG['cs_point_per_resources_used'],
		'cs_title'							=> $LNG['cs_title'],
		'cs_banner_time_between_updates'	=> $LNG['cs_banner_time_between_updates'],
		'cs_banner_title'					=> $LNG['cs_banner_title'],
		'cs_resources'						=> $LNG['cs_resources'],
		'cs_minutes'						=> $LNG['cs_minutes'],
		'cs_save_changes'					=> $LNG['cs_save_changes'],
		'Selector'							=> array(1 => $LNG['cs_yes'], 2 => $LNG['cs_no_view'], 0 => $LNG['cs_no']),
	));
		
	$template->show('adm/StatsPage.tpl');
}
?>