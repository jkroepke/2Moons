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
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowBanPage() 
{
	global $LNG, $db, $USER;
	
	$ORDER = $_GET['order'] == 'id' ? "id" : "username";

	if ($_GET['view'] == 'bana')
		$WHEREBANA	= "AND `bana` = '1'";

	$UserList		= $db->query("SELECT `username`, `id`, `bana` FROM ".USERS." WHERE `id` != 1 AND `authlevel` <= '".$USER['authlevel']."' AND `universe` = '".$_SESSION['adminuni']."' ".$WHEREBANA." ORDER BY ".$ORDER." ASC;");

	$UserSelect	= array('List' => '', 'ListBan' => '');
	
	$Users	=	0;
	while ($a = $db->fetch_array($UserList))
	{
		$UserSelect['List']	.=	'<option value="'.$a['username'].'">'.$a['username'].'&nbsp;&nbsp;(ID:&nbsp;'.$a['id'].')'.(($a['bana']	==	'1') ? $LNG['bo_characters_suus'] : '').'</option>';
		$Users++;
	}

	$db->free_result($UserList);
	
	$ORDER2 = $_GET['order2'] == 'id' ? "id" : "username";
		
	$Banneds		=0;
	$UserListBan	= $db->query("SELECT `username`, `id` FROM ".USERS." WHERE `bana` = '1' AND `universe` = '".$_SESSION['adminuni']."' ORDER BY ".$ORDER2." ASC;");
	while ($b = $db->fetch_array($UserListBan))
	{
		$UserSelect['ListBan']	.=	'<option value="'.$b['username'].'">'.$b['username'].'&nbsp;&nbsp;(ID:&nbsp;'.$b['id'].')</option>';
		$Banneds++;
	}

	$db->free_result($UserListBan);

	$template	= new template();
	$template->loadscript('filterlist.js');


	if(isset($_POST['panel']))
	{
		$Name					= request_var('ban_name', '', true);
		$BANUSER				= $db->uniquequery("SELECT b.theme, b.longer, u.id, u.urlaubs_modus, u.banaday FROM ".USERS." as u LEFT JOIN ".BANNED." as b ON u.`username` = b.`who` WHERE u.`username` = '".$db->sql_escape($Name)."' AND u.`universe` = '".$_SESSION['adminuni']."';");
			
		if ($BANUSER['banaday'] <= TIMESTAMP)
		{
			$title			= $LNG['bo_bbb_title_1'];
			$changedate		= $LNG['bo_bbb_title_2'];
			$changedate_advert		= '';
			$reas					= '';
			$timesus				= '';
		}
		else
		{
			$title			= $LNG['bo_bbb_title_3'];
			$changedate		= $LNG['bo_bbb_title_6'];
			$changedate_advert	=	'<td class="c" width="18px"><img src="./styles/images/Adm/i.gif" class="tooltip" name="'.$LNG['bo_bbb_title_4'].'"></td>';
				
			$reas			= $BANUSER['theme'];
			$timesus		=	
				"<tr>
					<th>".$LNG['bo_bbb_title_5']."</th>
					<th height=25 colspan=2>".date(TDFORMAT, $BANUSER['longer'])."</th>
				</tr>";
		}
		
		
		$vacation	= ($BANUSER['urlaubs_modus'] == 1) ? true : false;
		
		$template->assign_vars(array(	
			'name'				=> $Name,
			'bantitle'			=> $title,
			'changedate'		=> $changedate,
			'reas'				=> $reas,
			'changedate_advert'	=> $changedate_advert,
			'timesus'			=> $timesus,
			'vacation'			=> $vacation,
			'bo_characters_1'	=> $LNG['bo_characters_1'],
			'bo_reason'			=> $LNG['bo_reason'],
			'bo_username'		=> $LNG['bo_username'],
			'bo_vacation_mode'	=> $LNG['bo_vacation_mode'],
			'bo_vacaations'		=> $LNG['bo_vacaations'],
			'time_seconds'		=> $LNG['time_seconds'],
			'time_minutes'		=> $LNG['time_minutes'],
			'time_hours'		=> $LNG['time_hours'],
			'time_days'			=> $LNG['time_days'],
		));
	} elseif (isset($_POST['bannow']) && $BANUSER['id'] != 1) {
		$Name              = request_var('ban_name', '' ,true);
		$reas              = request_var('why', '' ,true);
		$days              = request_var('days', 0);
		$hour              = request_var('hour', 0);
		$mins              = request_var('mins', 0);
		$secs              = request_var('secs', 0);
		$admin             = $USER['username'];
		$mail              = $USER['email'];
		$BanTime           = $days * 86400 + $hour * 3600 + $mins * 60 + $secs;

		if ($BANUSER['longer'] > TIMESTAMP)
			$BanTime          += ($BANUSER['longer'] - TIMESTAMP);
		
		$BannedUntil = ($BanTime + TIMESTAMP) < TIMESTAMP ? TIMESTAMP : TIMESTAMP + $BanTime;
		
		
		if ($BANUSER['banaday'] > TIMESTAMP)
		{
			$SQL      = "UPDATE ".BANNED." SET ";
			$SQL     .= "`who` = '". $Name ."', ";
			$SQL     .= "`theme` = '". $reas ."', ";
			$SQL     .= "`who2` = '". $Name ."', ";
			$SQL     .= "`time` = '".TIMESTAMP."', ";
			$SQL     .= "`longer` = '". $BannedUntil ."', ";
			$SQL     .= "`author` = '". $admin ."', ";
			$SQL     .= "`email` = '". $mail ."' ";
			$SQL     .= "WHERE `who2` = '".$Name."' AND `universe` = '".$_SESSION['adminuni']."';";
			$db->query($SQL);
		} else {
			$SQL      = "INSERT INTO ".BANNED." SET ";
			$SQL     .= "`who` = '". $Name ."', ";
			$SQL     .= "`theme` = '". $reas ."', ";
			$SQL     .= "`who2` = '". $Name ."', ";
			$SQL     .= "`time` = '".TIMESTAMP."', ";
			$SQL     .= "`longer` = '". $BannedUntil ."', ";
			$SQL     .= "`author` = '". $admin ."', ";
			$SQL     .= "`universe` = '".$_SESSION['adminuni']."', ";
			$SQL     .= "`email` = '". $mail ."';";
			$db->query($SQL);
		}

		$SQL     = "UPDATE ".USERS." SET ";
		$SQL    .= "`bana` = '1', ";
		$SQL    .= "`banaday` = '". $BannedUntil ."', ";
		$SQL	.= isset($_POST['vacat']) ? "`urlaubs_modus` = '1'" : "`urlaubs_modus` = '0'";
		$SQL    .= "WHERE ";
		$SQL    .= "`username` = '". $Name ."' AND `universe` = '".$_SESSION['adminuni']."';";
		$db->query($SQL);

		$template->message($LNG['bo_the_player'].$Name.$LNG['bo_banned'], '?page=bans');
		exit;
	} elseif(isset($_POST['unban_name'])) {
		$Name	= request_var('unban_name', '', true);
		$db->multi_query("DELETE FROM ".BANNED." WHERE who = '".$db->sql_escape($Name)."' AND `universe` = '".$_SESSION['adminuni']."';UPDATE ".USERS." SET bana = '0', banaday = '0' WHERE username = '".$db->sql_escape($Name)."' AND `universe` = '".$_SESSION['adminuni']."';");
		$template->message($LNG['bo_the_player2'].$Name.$LNG['bo_unbanned'], '?page=bans');
		exit;
	}

	$template->assign_vars(array(	
		'UserSelect'		=> $UserSelect,
		'bo_ban_player'		=> $LNG['bo_ban_player'],
		'bo_select_title'	=> $LNG['bo_select_title'],
		'bo_order_banned'	=> $LNG['bo_order_banned'],
		'bo_order_id'		=> $LNG['bo_order_id'],
		'bo_order_username'	=> $LNG['bo_order_username'],
		'button_filter'		=> $LNG['button_filter'],
		'button_reset'		=> $LNG['button_reset'],
		'button_deselect'	=> $LNG['button_deselect'],
		'button_submit'		=> $LNG['button_submit'],
		'bo_total_users'	=> $LNG['bo_total_users'],
		'bo_total_banneds'	=> $LNG['bo_total_banneds'],
		'bo_unban_player'	=> $LNG['bo_unban_player'],
		'usercount'			=> $Users,
		'bancount'			=> $Banneds,
	));
	
	$template->show('adm/BanPage.tpl');
}
?>