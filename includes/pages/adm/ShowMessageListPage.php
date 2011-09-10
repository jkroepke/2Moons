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
 * @version 1.4 (2011-07-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowMessageListPage()
{
	global $db, $LNG;
	
	$Prev       = !empty($_POST['prev']) ? true : false;
	$Next       = !empty($_POST['next']) ? true : false;
	$DelSel     = !empty($_POST['delsel']) ? true : false;
	$DelDat     = !empty($_POST['deldat']) ? true : false;
	$CurrPage   = request_var('curr', 1);
	$Selected   = request_var('sele', 0);
	$SelType    = request_var('type', 1);
	$SelPage    = request_var('side', 1);

	$ViewPage = 1;
	if ( $Selected != $SelType )
	{
		$Selected = $SelType;
		$ViewPage = 1;
	}
	elseif ( $CurrPage != $SelPage )
	{
		$ViewPage = ( !empty($SelPage) ) ? $SelPage : 1;
	}

	if ($Selected < 100)
		$Mess      = $db->countquery("SELECT COUNT(*) FROM ".MESSAGES." WHERE `message_type` = '".$Selected."' AND `message_universe` = '".$_SESSION['adminuni']."';;");
	elseif ($Selected == 100)
		$Mess      = $db->countquery("SELECT COUNT(*) FROM ".MESSAGES." WHERE `message_universe` = '".$_SESSION['adminuni']."';;");
	
	
	$MaxPage   = ceil($Mess / 25);

	if($Prev   == true)
	{
		$CurrPage -= 1;
		$ViewPage = $CurrPage >= 1 ? $CurrPage : 1;
	}
	elseif ($Next   == true && $_POST['page'])
	{
		$CurrPage += 1;
		$ViewPage = $CurrPage <= $MaxPage ? $CurrPage : $MaxPage;
	}
	
	if ($_POST['delsel'] && is_array($_POST['sele']))
	{
		if ($DelSel == true)
		{
			foreach($_POST['sele'] as $MessId => $Value)
			{
				if ($Value = "on")
					$db->query("DELETE FROM ".MESSAGES." WHERE `message_id` = '". $MessId ."';");
			}
		}
	}
	
	if ($DelDat == true && $_POST['deldat'] && $_POST['sele'] >= 1 && is_numeric($_POST['selday']) && is_numeric($_POST['selmonth']) && is_numeric($_POST['selyear']))
	{
		$SelDay    = $_POST['selday'];
		$SelMonth  = $_POST['selmonth'];
		$SelYear   = $_POST['selyear'];
		$LimitDate = mktime (0,0,0, $SelMonth, $SelDay, $SelYear );
		if ($LimitDate !== false)
		{
			$db->multi_query("DELETE FROM ".MESSAGES." WHERE `message_time` <= '".$LimitDate."';DELETE FROM ".RW." WHERE `time` <= '".$LimitDate ."';");
		}
	}

	$data = $MessagesList = array();
	unset($LNG['mg_type'][999]);
	$Selector['type']	= $LNG['mg_type'];

	for($cPage = 1; $cPage <= $MaxPage; $cPage++) {
		$Selector['pages'][$cPage]	= $cPage.'/'.$MaxPage;
	}
	
	$StartRec            = (($ViewPage - 1) * 25);
	if ($Selected == 50)
		$Messages            = $db->query("SELECT * FROM ".MESSAGES." WHERE `message_type` = '". $Selected ."' AND `message_universe` = '".$_SESSION['adminuni']."' ORDER BY `message_time` DESC LIMIT ". $StartRec .",25;");
	elseif ($Selected == 100)
		$Messages            = $db->query("SELECT u.username, m.* FROM ".MESSAGES." as m, ".USERS." as u WHERE m.`message_owner` = u.`id` AND m.`message_universe` = '".$_SESSION['adminuni']."' ORDER BY `message_time` DESC LIMIT ". $StartRec .",25;");
	else
		$Messages            = $db->query("SELECT u.username, m.* FROM ".MESSAGES." as m, ".USERS." as u WHERE m.`message_type` = '". $Selected ."' AND m.`message_owner` = u.`id` AND `message_universe` = '".$_SESSION['adminuni']."' ORDER BY `message_time` DESC LIMIT ". $StartRec .",25;");
	
	while($row = $db->fetch_array($Messages))
	{
		$MessagesList[]	= array(
			'id'		=> $row['message_id'],
			'from'		=> $row['message_from'],
			'to'		=> ($Selected != 50) ? $row['username'].' '.$LNG['input_id'].':'.$row['message_owner'] : 'Universe',
			'subject'	=> $row['message_subject'],
			'text'		=> $row['message_text'],
			'time'		=> str_replace(' ', '&nbsp;', tz_date($row['message_time'])),
		);
	}	

	$template 	= new template();

	$template->loadscript('global.js');

	$template->assign_vars(array(	
		'Selector'					=> $Selector,
		'ViewPage'					=> $ViewPage,
		'Selected'					=> $Selected,
		'MaxPage'					=> $MaxPage,
		'MessagesList'				=> $MessagesList,
		'ml_page'					=> $LNG['ml_page'],
		'ml_type'					=> $LNG['ml_type'],
		'ml_dlte_since'				=> $LNG['ml_dlte_since'],
		'ml_dlte_selection'			=> $LNG['ml_dlte_selection'],
		'ml_dlte_since_button'		=> $LNG['ml_dlte_since_button'],
		'button_des_se'				=> $LNG['button_des_se'],
		'ml_select_all_messages'	=> $LNG['ml_select_all_messages'],
		'input_id'					=> $LNG['input_id'],
		'ml_date'					=> $LNG['ml_date'],
		'ml_from'					=> $LNG['ml_from'],
		'ml_to'						=> $LNG['ml_to'],
		'ml_subject'				=> $LNG['ml_subject'],
		'ml_content'				=> $LNG['ml_content'],
	));
				
	$template->show('adm/MessageList.tpl');
}
?>