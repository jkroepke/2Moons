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

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowBanPage() 
{
	global $LNG, $USER;
	
	$ORDER = $_GET['order'] == 'id' ? "id" : "username";

	if ($_GET['view'] == 'bana')
		$WHEREBANA	= "AND `bana` = '1'";

	$UserList		= $GLOBALS['DATABASE']->query("SELECT `username`, `id`, `bana` FROM ".USERS." WHERE `id` != 1 AND `authlevel` <= '".$USER['authlevel']."' AND `universe` = '".Universe::getEmulated()."' ".$WHEREBANA." ORDER BY ".$ORDER." ASC;");

	$UserSelect	= array('List' => '', 'ListBan' => '');
	
	$Users	=	0;
	while ($a = $GLOBALS['DATABASE']->fetch_array($UserList))
	{
		$UserSelect['List']	.=	'<option value="'.$a['username'].'">'.$a['username'].'&nbsp;&nbsp;(ID:&nbsp;'.$a['id'].')'.(($a['bana']	==	'1') ? $LNG['bo_characters_suus'] : '').'</option>';
		$Users++;
	}

	$GLOBALS['DATABASE']->free_result($UserList);
	
	$ORDER2 = $_GET['order2'] == 'id' ? "id" : "username";
		
	$Banneds		=0;
	$UserListBan	= $GLOBALS['DATABASE']->query("SELECT `username`, `id` FROM ".USERS." WHERE `bana` = '1' AND `universe` = '".Universe::getEmulated()."' ORDER BY ".$ORDER2." ASC;");
	while ($b = $GLOBALS['DATABASE']->fetch_array($UserListBan))
	{
		$UserSelect['ListBan']	.=	'<option value="'.$b['username'].'">'.$b['username'].'&nbsp;&nbsp;(ID:&nbsp;'.$b['id'].')</option>';
		$Banneds++;
	}

	$GLOBALS['DATABASE']->free_result($UserListBan);

	$template	= new template();
	$template->loadscript('filterlist.js');


	$Name					= HTTP::_GP('ban_name', '', true);
	$BANUSER				= $GLOBALS['DATABASE']->getFirstRow("SELECT b.theme, b.longer, u.id, u.urlaubs_modus, u.banaday FROM ".USERS." as u LEFT JOIN ".BANNED." as b ON u.`username` = b.`who` WHERE u.`username` = '".$GLOBALS['DATABASE']->sql_escape($Name)."' AND u.`universe` = '".Universe::getEmulated()."';");

	if(isset($_POST['panel']))
	{
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
			$changedate_advert	=	'<td class="c" width="18px"><img src="./styles/resource/images/admin/i.gif" class="tooltip" data-tooltip-content="'.$LNG['bo_bbb_title_4'].'"></td>';
				
			$reas			= $BANUSER['theme'];
			$timesus		=	
				"<tr>
					<th>".$LNG['bo_bbb_title_5']."</th>
					<th height=25 colspan=2>".date($LNG['php_tdformat'], $BANUSER['longer'])."</th>
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
		));
	} elseif (isset($_POST['bannow']) && $BANUSER['id'] != 1) {
		$Name              = HTTP::_GP('ban_name', '' ,true);
		$reas              = HTTP::_GP('why', '' ,true);
		$days              = HTTP::_GP('days', 0);
		$hour              = HTTP::_GP('hour', 0);
		$mins              = HTTP::_GP('mins', 0);
		$secs              = HTTP::_GP('secs', 0);
		$admin             = $USER['username'];
		$mail              = $USER['email'];
		$BanTime           = $days * 86400 + $hour * 3600 + $mins * 60 + $secs;

		if ($BANUSER['longer'] > TIMESTAMP)
			$BanTime          += ($BANUSER['longer'] - TIMESTAMP);
		
		if (isset($_POST['permanent'])) {
			$BannedUntil = 2147483647;
		} else {
			$BannedUntil = ($BanTime + TIMESTAMP) < TIMESTAMP ? TIMESTAMP : TIMESTAMP + $BanTime;
		}
		
		if ($BANUSER['banaday'] > TIMESTAMP)
		{
			$SQL      = "UPDATE ".BANNED." SET ";
			$SQL     .= "`who` = '". $Name ."', ";
			$SQL     .= "`theme` = '". $reas ."', ";
			$SQL     .= "`time` = '".TIMESTAMP."', ";
			$SQL     .= "`longer` = '". $BannedUntil ."', ";
			$SQL     .= "`author` = '". $admin ."', ";
			$SQL     .= "`email` = '". $mail ."' ";
			$SQL     .= "WHERE `who2` = '".$Name."' AND `universe` = '".Universe::getEmulated()."';";
			$GLOBALS['DATABASE']->query($SQL);
		} else {
			$SQL      = "INSERT INTO ".BANNED." SET ";
			$SQL     .= "`who` = '". $Name ."', ";
			$SQL     .= "`theme` = '". $reas ."', ";
			$SQL     .= "`time` = '".TIMESTAMP."', ";
			$SQL     .= "`longer` = '". $BannedUntil ."', ";
			$SQL     .= "`author` = '". $admin ."', ";
			$SQL     .= "`universe` = '".Universe::getEmulated()."', ";
			$SQL     .= "`email` = '". $mail ."';";
			$GLOBALS['DATABASE']->query($SQL);
		}

		$SQL     = "UPDATE ".USERS." SET ";
		$SQL    .= "`bana` = '1', ";
		$SQL    .= "`banaday` = '". $BannedUntil ."', ";
		$SQL	.= isset($_POST['vacat']) ? "`urlaubs_modus` = '1'" : "`urlaubs_modus` = '0'";
		$SQL    .= "WHERE ";
		$SQL    .= "`username` = '". $Name ."' AND `universe` = '".Universe::getEmulated()."';";
		$GLOBALS['DATABASE']->query($SQL);

		$template->message($LNG['bo_the_player'].$Name.$LNG['bo_banned'], '?page=bans');
		exit;
	} elseif(isset($_POST['unban_name'])) {
		$Name	= HTTP::_GP('unban_name', '', true);
		$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET bana = '0', banaday = '0' WHERE username = '".$GLOBALS['DATABASE']->sql_escape($Name)."' AND `universe` = '".Universe::getEmulated()."';");
		#DELETE FROM ".BANNED." WHERE who = '".$GLOBALS['DATABASE']->sql_escape($Name)."' AND `universe` = '".Universe::getEmulated()."';
		$template->message($LNG['bo_the_player2'].$Name.$LNG['bo_unbanned'], '?page=bans');
		exit;
	}

	$template->assign_vars(array(	
		'UserSelect'		=> $UserSelect,
		'usercount'			=> $Users,
		'bancount'			=> $Banneds,
	));
	
	$template->show('BanPage.tpl');
}