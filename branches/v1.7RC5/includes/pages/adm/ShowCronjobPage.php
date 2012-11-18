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
 * @author FC92
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function getCronjobTimes($row,$max)
{
	$arr = explode(',',$row);
	if (count($arr) > 1)
		return $arr;
	
	if (substr($arr[0],0,(2-strlen($arr[0]))) == '*/')
		return range(0,$max,(int) substr($arr[0],(2-strlen($arr[0]))));
	else
		return $arr[0];
}

function checkPostData($column,$max)
{
	$all = HTTP::_GP($column.'_all', 0);
	if ($all)
		return '*';
	
	$post = HTTP::_GP($column, array());
	$post = array_filter($post, 'is_numeric');
	if (empty($post))
		return false;
	
	$check = array(2,3,5,6,7,10,14,15,20,30);
	$result = array();
	foreach ($check as $i)
	{
		if ($i <= $max && range(0, $max, $i) == $post)
			$result[] = $i;
	}
	if (!empty($result))
		return '*/'.max($result);
	else
		return implode(',',$post);
	
}

function ShowCronjob()
{
	if ($_POST)
		ShowCronjobEdit();
	elseif (!isset($_GET['detail']))
		ShowCronjobOverview();
	else
		ShowCronjobDetail(HTTP::_GP('detail', 0));
}

function ShowCronjobEdit() 
{
	global $LNG;
	
	$post_id 		= 	HTTP::_GP('id', 0);
	$post_name 		= 	HTTP::_GP('name', '');
	$post_min 		= 	checkPostData('min', 59);
	$post_hours 	= 	checkPostData('hours', 23);
	$post_month 	= 	checkPostData('month', 12);
	$post_dow 		= 	checkPostData('dow', 6);
	$post_dom 		= 	checkPostData('dom', 31);
	$post_class 	= 	HTTP::_GP('class', '');
	$error_msg 		= 	array();
	
	if ($post_name == '')
		$error_msg[] = $LNG['cronjob_error_name'];
	if (!$post_min)
		$error_msg[] = $LNG['cronjob_error_min'];
	if (!$post_hours)
		$error_msg[] = $LNG['cronjob_error_hours'];
	if (!$post_month)
		$error_msg[] = $LNG['cronjob_error_month'];
	if (!$post_dow)
		$error_msg[] = $LNG['cronjob_error_dow'];
	if (!$post_dom)
		$error_msg[] = $LNG['cronjob_error_dom'];
	if ($post_class == '')
		$error_msg[] = $LNG['cronjob_error_class'];
	elseif (!file_exists(ROOT_PATH . 'includes/classes/cronjob/'.$post_class.'.class.php')) 
		$error_msg[] = $LNG['cronjob_error_filenotfound'].ROOT_PATH . 'includes/classes/cronjobs/'.$post_class.'.class.php';
	
	if (count($error_msg) == 0)
	{
		if ($post_id != 0)
			$GLOBALS['DATABASE']->query("UPDATE ".CRONJOBS." SET name = '".$GLOBALS['DATABASE']->sql_escape($post_name)."', min = '".$post_min."', hours = '".$post_hours."', month = '".$post_month."', dow = '".$post_dow."', dom = '".$post_dom."', class = '".$GLOBALS['DATABASE']->sql_escape($post_class)."' WHERE cronjobID = $post_id;");
		else
			$GLOBALS['DATABASE']->query("INSERT INTO ".CRONJOBS." SET name = '".$GLOBALS['DATABASE']->sql_escape($post_name)."', min = '".$post_min."', hours = '".$post_hours."', month = '".$post_month."', dow = '".$post_dow."', dom = '".$post_dom."', class = '".$GLOBALS['DATABASE']->sql_escape($post_class)."';");
		ShowCronjobOverview();
	} else {
		ShowCronjobDetail($post_id,$error_msg);
	}
}

function ShowCronjobOverview() 
{
	if (isset($_GET['lock']))
		$GLOBALS['DATABASE']->query("UPDATE ".CRONJOBS." SET `lock` = ".(HTTP::_GP('lock', 0)?'MD5(UNIX_TIMESTAMP())':'NULL')." WHERE cronjobID = ".HTTP::_GP('id', 0).";");
	if (isset($_GET['active']))
		$GLOBALS['DATABASE']->query("UPDATE ".CRONJOBS." SET `isActive` = ".HTTP::_GP('active', 0)." WHERE cronjobID = ".HTTP::_GP('id', 0).";");
	
	$data    = $GLOBALS['DATABASE']->query("SELECT * FROM ".CRONJOBS.";");

	$template	= new template();	
	if(!$data)
		$template->message($LNG['cronjob_no_data']);
	
	$CronjobArray = array();
	while ($CronjobRow = $GLOBALS['DATABASE']->fetch_array($data))
	{			
		$CronjobArray[]	= array(
			'id'			=> $CronjobRow['cronjobID'],
			'isActive'		=> $CronjobRow['isActive'],
			'name'			=> $CronjobRow['name'],
			'min'			=> $CronjobRow['min'],
			'hours'			=> $CronjobRow['hours'],
			'dom'			=> $CronjobRow['dom'],
			'month'			=> getCronjobTimes($CronjobRow['month'],12),
			'dow'			=> getCronjobTimes($CronjobRow['dow'],6),
			'class'			=> $CronjobRow['class'],
			'nextTime'		=> $CronjobRow['nextTime'],
			'lock'			=> !empty($CronjobRow['lock']),
		);
	}
	$template	= new template();	
	$template->assign_vars(array(	
		'CronjobArray'	=> $CronjobArray,
	));
	$template->show("CronjobOverview.tpl");
}

function ShowCronjobDetail($detail,$error_msg=NULL) 
{
	$template	= new template();
	
	
	$avalibleCrons	= array();
	
	$dir = new DirectoryIterator(ROOT_PATH.'includes/classes/cronjob/');
	foreach ($dir as $fileinfo) {
		if ($fileinfo->isFile()) {
			$avalibleCrons[]	= $fileinfo->getBasename('.class.php');
		}
	}
	
	$template->assign_vars(array(	
		'avalibleCrons' => $avalibleCrons
	));
	
	if ($detail != 0)
	{
		$CronjobRow   	= $GLOBALS['DATABASE']->uniquequery("SELECT * FROM ".CRONJOBS." WHERE cronjobID = ".$detail."");
		$template->assign_vars(array(	
			'id'			=> $CronjobRow['cronjobID'],
			'name'			=> isset($_POST['name'])?HTTP::_GP('name', ''):$CronjobRow['name'],
			'min'			=> isset($_POST['min_all'])?array(0 => '*'):(isset($_POST['min'])?HTTP::_GP('min', array()):getCronjobTimes($CronjobRow['min'],59)),
			'hours'			=> isset($_POST['hours_all'])?array(0 => '*'):(isset($_POST['hours'])?HTTP::_GP('hours', array()):getCronjobTimes($CronjobRow['hours'],23)),
			'dom'			=> isset($_POST['dom_all'])?array(0 => '*'):(isset($_POST['dom'])?HTTP::_GP('dom', array()):getCronjobTimes($CronjobRow['dom'],31)),
			'month'			=> isset($_POST['month_all'])?array(0 => '*'):(isset($_POST['month'])?HTTP::_GP('month', array()):getCronjobTimes($CronjobRow['month'],12)),
			'dow'			=> isset($_POST['dow_all'])?array(0 => '*'):(isset($_POST['dow'])?HTTP::_GP('dow', array()):getCronjobTimes($CronjobRow['dow'],6)),
			'class'			=> isset($_POST['class'])?HTTP::_GP('class', ''):$CronjobRow['class'],
			'error_msg'		=> $error_msg,
		));
	} else {
		$template->assign_vars(array(	
			'id'			=> 'add',
			'name'			=> HTTP::_GP('name', ''),
			'min'			=> isset($_POST['min_all'])?array(0 => '*'):HTTP::_GP('min', array()),
			'hours'			=> isset($_POST['hours_all'])?array(0 => '*'):HTTP::_GP('hours', array()),
			'dom'			=> isset($_POST['dom_all'])?array(0 => '*'):HTTP::_GP('dom', array()),
			'month'			=> isset($_POST['month_all'])?array(0 => '*'):HTTP::_GP('month', array()),
			'dow'			=> isset($_POST['dow_all'])?array(0 => '*'):HTTP::_GP('dow', array()),
			'class'			=> HTTP::_GP('class', ''),
			'error_msg'		=> $error_msg,
		));
	}
	$template->show("CronjobDetail.tpl");
}

