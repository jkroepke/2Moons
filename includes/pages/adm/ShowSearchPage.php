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
 * @version 1.3.5 (2011-04-22)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

require_once(ROOT_PATH . 'includes/functions/DeleteSelectedUser.php');


function ShowSearchPage()
{
	global $LNG, $db;
	
	if ($_GET['delete'] == 'user') {
        DeleteSelectedUser((int) $_GET['user']);
        message($LNG['se_delete_succes_p'], '?page=search&search=users&minimize=on', 2);
	} elseif ($_GET['delete'] == 'planet'){
        DeleteSelectedPlanet((int) $_GET['planet']);
        message($LNG['se_delete_succes_p'], '?page=search&search=planet&minimize=on', 2);
    }
	
	$SearchFile		= request_var('search', '');
	$SearchFor		= request_var('search_in', '');
	$SearchMethod	= request_var('fuki', '');
	$SearchKey		= request_var('key_user', '');
	$Page 			= request_var('side', 0);
	$Order			= request_var('key_order', '');
	$OrderBY		= request_var('key_acc', '');
	$limit			= request_var('limit', 25);

	$Selector	= array(
		'list'	=> array(
			'users'		=> $LNG['se_users'],	
			'planet'	=> $LNG['se_planets'],
			'moon'		=> $LNG['se_moons'],
			'alliance'	=> $LNG['se_allys'],
			'vacation'	=> $LNG['se_vacations'],
			'banned'	=> $LNG['se_suspended'],
			'admin'		=> $LNG['se_authlevels'],
			'inactives'	=> $LNG['se_inactives'],
			'online'	=> $LNG['online_users'],
			'p_connect'	=> $LNG['se_planets_act'],
		),
		'search'	=> array(
			'name'	=> $LNG['se_input_name'],
			'id'	=> $LNG['input_id'],
		),
		'filter'	=> array(
			'normal'	=> $LNG['se_type_all'],
			'exacto'	=> $LNG['se_type_exact'],
			'last'		=> $LNG['se_type_last'],
			'first'		=> $LNG['se_type_first'],
		),
		'order'	=> array(
			'ASC'	=> $LNG['se_input_asc'],
			'DESC'	=> $LNG['se_input_desc'],
		),
		'limit'	=> array(
			'1'		=> '1',
			'5'		=> '5',
			'10'	=> '10',
			'15'	=> '15',
			'20'	=> '20',
			'25'	=> '25',
			'50'	=> '50',
			'100'	=> '100',
			'200'	=> '200',
			'500'	=> '500',	
		)
	);
	$template	= new template();

	
	
	
	if (request_var('minimize', '') == 'on')
	{
		$Minimize			= "&amp;minimize=on";
		$template->assign_vars(array(	
			'minimize'	=> 'checked = "checked"',
			'diisplaay'	=> 'style="display:none;"',
		));
	}
	
	switch($SearchMethod)
	{
		case 'exacto':
			$SpecifyWhere	=	"= '".$db->sql_escape($SearchKey)."'";
		break;
		case 'last':
			$SpecifyWhere	=	"LIKE '".$db->sql_escape($SearchKey, true)."%'";
		break;
		case 'first':
			$SpecifyWhere	=	"LIKE '%".$db->sql_escape($SearchKey, true)."'";
		break;
		default:
			$SpecifyWhere	=	"LIKE '%".$db->sql_escape($SearchKey, true)."%'";
		break;
	};

	if (!empty($SearchFile))
	{
		$ArrayUsers		=	array("users", "vacation", "admin", "inactives", "online");
		$ArrayPlanets	=	array("planet", "moon", "p_connect");
		$ArrayBanned	=	array("banned");
		$ArrayAlliance	=	array("alliance");

		if (in_array($SearchFile, $ArrayUsers))
		{
			$Table			=	"users";
			$NameLang		=	$LNG['se_search_users'];
			$SpecifyItems	=	"id,username,email_2,onlinetime,register_time,user_lastip,authlevel,bana,urlaubs_modus";
			$SName			=	$LNG['se_input_userss'];
			$SpecialSpecify	= "";
			if ($SearchFile == "vacation"){
				$SpecialSpecify	=	"AND urlaubs_modus = '1'";
				$SName			=	$LNG['se_input_vacatii'];}
				
			if ($SearchFile == "online"){
				$SpecialSpecify	=	"AND onlinetime >= '".(TIMESTAMP - 15 * 60)."'";
				$SName			=	$LNG['se_input_connect'];}
				
			if ($SearchFile == "inactives"){
				$SpecialSpecify	=	"AND onlinetime < '".(TIMESTAMP - 60 * 60 * 24 * 7)."'";
				$SName			=	$LNG['se_input_inact'];}
				
			if ($SearchFile == "admin"){
				$SpecialSpecify	=	"AND authlevel <= '".$USER['authlevel']."' AND authlevel > '0'";
				$SName			=	$LNG['se_input_admm'];}
				
				
			$SpecialSpecify	.=	" AND `universe` = '".$_SESSION['adminuni']."'";
			
			(($SearchFor == "name") ? $WhereItem = "WHERE username" : $WhereItem = "WHERE id");
			$ArrayOSec		=	array("id", "username", "email_2", "onlinetime", "register_time", "user_lastip", "authlevel", "bana", "urlaubs_modus");
			$Array0SecCount	=	count($ArrayOSec);

			for ($OrderNum = 0; $OrderNum < $Array0SecCount; $OrderNum++)
				$OrderBYParse[$ArrayOSec[$OrderNum]]	= $LNG['se_search_users'][$OrderNum];
		}
		
		
		elseif (in_array($SearchFile, $ArrayPlanets))
		{
			$Table			=	"planets";
			$TableUsers		=	"2";
			$NameLang		=	$LNG['se_search_planets'];
			$SpecifyItems	=	"id,name,id_owner,last_update,galaxy,system,planet,id_luna";
			
			if ($SearchFile == "planet"){
				$SpecialSpecify	=	"AND planet_type = '1'";
				$SName			=	$LNG['se_input_planett'];}
			elseif ($SearchFile == "moon"){
				$SpecialSpecify	=	"AND planet_type = '3'";
				$SName			=	$LNG['se_input_moonn'];}
			elseif ($SearchFile == "p_connect"){
				$SpecialSpecify	=	"AND last_update >= '".(TIMESTAMP - 60 * 60)."'";
				$SName			=	$LNG['se_input_act_pla'];}
			
			
			$SpecialSpecify	.=	" AND `universe` = '".$_SESSION['adminuni']."'";
			
			(($SearchFor == "name") ? $WhereItem = "WHERE name" : $WhereItem = "WHERE id");
			
			$ArrayOSec		=	array("id", "name", "id_owner", "id_luna", "last_update", "galaxy", "system", "planet");
			$Array0SecCount	=	count($ArrayOSec);
			
			for ($OrderNum = 0; $OrderNum < $Array0SecCount; $OrderNum++)
				$OrderBYParse[$ArrayOSec[$OrderNum]]	= $LNG['se_search_planets'][$OrderNum];
		}
		
		
		elseif (in_array($SearchFile, $ArrayBanned))
		{
			$Table			=	"banned";
			$NameLang		=	$LNG['se_search_banned'];
			$SpecifyItems	=	"id,who,time,longer,theme,author";
			$SName			=	$LNG['se_input_susss'];
			$SpecialSpecify	=	" AND `universe` = '".$_SESSION['adminuni']."'";
			
			(($SearchFor == "name") ? $WhereItem = "WHERE who" : $WhereItem = "WHERE id");
			
			
			$ArrayOSec		=	array("id", "who", "time", "longer", "theme", "author");
			$Array0SecCount	=	count($ArrayOSec);
			
			for ($OrderNum = 0; $OrderNum < $Array0SecCount; $OrderNum++)
				$OrderBYParse[$ArrayOSec[$OrderNum]]	= $LNG['se_search_banned'][$OrderNum];
		}
		
		
		elseif (in_array($SearchFile, $ArrayAlliance))
		{
			$Table			=	"alliance";
			$NameLang		=	$LNG['se_search_alliance'];
			$SpecifyItems	=	"id,ally_name,ally_tag,ally_owner,ally_register_time,ally_members";
			$SName			=	$LNG['se_input_allyy'];
			$SpecialSpecify	=	" AND `ally_universe` = '".$_SESSION['adminuni']."'";
			
			(($SearchFor == "name") ? $WhereItem = "WHERE ally_name" : $WhereItem = "WHERE id");
			
			
			$ArrayOSec		=	array("id", "ally_name", "ally_tag", "ally_owner", "ally_register_time", "ally_members");
			$Array0SecCount	=	count($ArrayOSec);
			
			for ($OrderNum = 0; $OrderNum < $Array0SecCount; $OrderNum++)
				$OrderBYParse[$ArrayOSec[$OrderNum]]	= $LNG['se_search_alliance'][$OrderNum];
		}
				
		$RESULT	= MyCrazyLittleSearch($SpecifyItems, $WhereItem, $SpecifyWhere, $SpecialSpecify, $Order, $OrderBY, $limit, $Table, $Page, $NameLang, $ArrayOSec, $Minimize, $SName, $SearchFile);
	}
	
	$template->assign_vars(array(	
		'Selector'				=> $Selector,
		'limit'					=> $limit,
		'search'				=> $SearchKey,
		'SearchFile'			=> $SearchFile,
		'SearchFor'				=> $SearchFor,
		'SearchMethod'			=> $SearchMethod,
		'Order'					=> $Order,
		'OrderBY'				=> $OrderBY,
		'OrderBYParse'			=> $OrderBYParse,
		'se_search'				=> $LNG['se_search'],
		'se_limit'				=> $LNG['se_limit'],
		'se_asc_desc'			=> $LNG['se_asc_desc'],
		'se_filter_title'		=> $LNG['se_filter_title'],
		'se_search_in'			=> $LNG['se_search_in'],
		'se_type_typee'			=> $LNG['se_type_typee'],
		'se_intro'				=> $LNG['se_intro'],
		'se_search_title'		=> $LNG['se_search_title'],
		'se_contrac'			=> $LNG['se_contrac'],
		'se_search_order'		=> $LNG['se_search_order'],
		'ac_minimize_maximize'	=> $LNG['ac_minimize_maximize'],
		'LIST'					=> $RESULT['LIST'],
		'PAGES'					=> $RESULT['PAGES'],
	));
	
	$template->show('adm/SearchPage.tpl');
}

function MyCrazyLittleSearch($SpecifyItems, $WhereItem, $SpecifyWhere, $SpecialSpecify, $Order, $OrderBY, $Limit, $Table, $Page, $NameLang, $ArrayOSec, $Minimize, $SName, $SearchFile)
{
	global $USER, $LNG, $db;
	
	$parse	=	$LNG;
	
	if (!$Page) 
	{ 
		$INI = 0; 
    	$Page = 1; 
	}
	else
		$INI = ($Page - 1) * $Limit;
		
	$ArrayEx	=	explode(",", $SpecifyItems);

	if (!$Order || !in_array($Order, $ArrayOSec))
		$Order	=	$ArrayEx[0];
		
	$CountArray	=	count($ArrayEx);
	
	
	$QuerySearch	 =	"SELECT ".$SpecifyItems." FROM ".DB_PREFIX.$Table." ";
	$QuerySearch	.=	$WhereItem." ";
	$QuerySearch	.=	$SpecifyWhere." ".$SpecialSpecify." ";
	$QuerySearch	.=	"ORDER BY ".$Order." ".$OrderBY." ";
	$QuerySearch	.=	"LIMIT ".$INI.",".$Limit;
	$FinalQuery		=	$db->query($QuerySearch);
	
	$QueryCSearch	 =	"SELECT COUNT(".$ArrayEx[0].") AS `total` FROM ".DB_PREFIX.$Table." ";
	$QueryCSearch	.=	$WhereItem." ";
	$QueryCSearch	.=	$SpecifyWhere." ".$SpecialSpecify." ";
	$CountQuery		=	$db->uniquequery($QueryCSearch);
	
	if ($CountQuery['total'] > 0)
	{
		$NumberOfPages = ceil($CountQuery['total'] / $Limit);
	
		$UrlForPage	=	"?page=search
						&search=".$SearchFile."
						&search_in=".$_GET['search_in']."
						&fuki=".$_GET['fuki']."
						&key_user=".$_GET['key_user']."
						&key_order=".$_GET['key_order']."
						&key_acc=".$_GET['key_acc']."
						&limit=".$Limit;
						 
		if($NumberOfPages > 1)
		{
			$BeforePage	=	($Page - 1);
			$NextPage	=	($Page + 1);
			
			for ($i = 1; $i <= $NumberOfPages; $i++)
			{ 
				$PAGEE .= $Page == $i ? "&nbsp;".$Page."&nbsp;" : " <a href='".$UrlForPage."&amp;side=".$i.$Minimize."'>".$i."</a> ";
			}

			if(($Page - 1) > 0) 
				$BEFORE	= "<a href='".$UrlForPage."&amp;side=".$BeforePage.$Minimize."'><img src=\"./styles/images/Adm/arrowleft.png\" title=".$LNG['se__before']." height=10 width=14></a> ";
		
			if(($Page + 1) <= $NumberOfPages) 
				$NEXT	= "<a href='".$UrlForPage."&amp;side=".$NextPage.$Minimize."'><img src=\"./styles/images/Adm/arrowright.png\" title=".$LNG['se__next']." height=10 width=14></a>";
		

			$Search['PAGES']	= '<tr><td colspan="3" style="color:#00CC33;border: 1px lime solid;text-align:center;">'.$BEFORE.'&nbsp;'.$PAGEE.'&nbsp;'.$NEXT.'</td></tr>';
		}
	

		$Search['LIST']	 =	"<table width=\"90%\">";
		$Search['LIST']	.=	"<tr>";
	
		for ($i = 0; $i < $CountArray; $i++)
			$Search['LIST']	.=	"<th>".$NameLang[$i]."</th>";
	
		if ($Table == "users") 
		{
			if (allowedTo('ShowAccountDataPage'))
				$Search['LIST']	.=	"<th>".$LNG['se_search_info']."</th>";

			if ($USER['authlevel'] == AUTH_ADM)
				$Search['LIST']	.=	"<th>".$LNG['button_delete']."</th>";
		}
		
		if ($Table == "planets")
		{				
			if (allowedTo('ShowQuickEditorPage'))
				$Search['LIST']	.=	"<th>".$LNG['se_search_edit']."</th>";
				
			if ($USER['authlevel'] == AUTH_ADM)
				$Search['LIST']	.=	"<th>".$LNG['button_delete']."</th>";
		}

		
		$Search['LIST']	.=	"</tr>";
	
	
		while ($WhileResult	=	$db->fetch_num($FinalQuery))
		{
			$Search['LIST']	 .=	"<tr>";
			if ($Table == "users"){				
				$WhileResult[3] = $_GET['search'] == "online" ? pretty_time( TIMESTAMP - $WhileResult[3] ) : date(TDFORMAT, $WhileResult[3] );
				$WhileResult[4]	=	date(TDFORMAT, $WhileResult[4]);
				
				$WhileResult[6]	=	$LNG['rank'][$WhileResult[6]];
				(($WhileResult[7] == '1')	? $WhileResult[7] = "<font color=lime>".$LNG['one_is_yes'][1]."</font>" : $WhileResult[7] = $LNG['one_is_yes'][0]);
				(($WhileResult[8] == '1')	? $WhileResult[8] = "<font color=lime>".$LNG['one_is_yes'][1]."</font>" : $WhileResult[8] = $LNG['one_is_yes'][0]);
			}
			
			if ($Table == "banned"){
				$WhileResult[2]	=	date(TDFORMAT, $WhileResult[2]);
				$WhileResult[3]	=	date(TDFORMAT, $WhileResult[3]);
			}
			
			if ($Table == "alliance")
				$WhileResult[4]	=	date(TDFORMAT, $WhileResult[4]);
				
			if ($Table == "planets") {
				$WhileResult[3]	=	pretty_time(TIMESTAMP - $WhileResult[3]);
				$WhileResult[7]	= 	$WhileResult[7] > 0 ? "<font color=lime>".$LNG['one_is_yes'][1]."</font>" : $LNG['one_is_yes'][0];
			}
			for ($i = 0; $i < $CountArray; $i++)
				$Search['LIST']	.=	"<td>".$WhileResult[$i]."</td>";
		
		
			if ($Table == "users")
			{
				if (allowedTo('ShowQuickEditorPage'))
					$Search['LIST']	.=	"<td><a href=\"javascript:openEdit('".$WhileResult[0]."', 'player');\" border=\"0\"><img title=\"".$WhileResult[1]."\" src=\"./styles/images/Adm/GO.png\"></a></d>";
			
				if ($USER['authlevel'] == AUTH_ADM)
				{
					$DELETEBUTTON = $WhileResult[0] != $USER['id'] || $WhileResult[0] != 1 ? "<a href=\"?page=search&amp;delete=user&amp;user=".$WhileResult[0]."\" border=\"0\" onclick=\"return confirm('".$LNG['ul_sure_you_want_dlte']." ".$WhileResult[1]."?');\"><img src=\"./styles/images/r1.png\" title=".$WhileResult[1]."></a>" : "-";
					
					$Search['LIST']	.=	"<td>".$DELETEBUTTON."</td>";
				}
			}
		
			if ($Table == "planets"){
			
				if (allowedTo('ShowQuickEditorPage'))
					$Search['LIST']	.=	"<td><a href=\"javascript:openEdit('".$WhileResult[0]."', 'planet');\" border=\"0\"><img src=\"./styles/images/Adm/GO.png\" title=".$LNG['se_search_edit']."></a></td>";
					
				if ($USER['authlevel'] == AUTH_ADM)
					$Search['LIST']	.=	"<td><a href=\"?page=search&amp;delete=planet&planet=".$WhileResult[0]."\" border=\"0\" onclick=\"return confirm('".$LNG['se_confirm_planet']." ".$WhileResult[1]."');\"><img src=\"./styles/images/r1.png\" title=".$LNG['button_delete']."></a></td>";
			}
			
			$Search['LIST']	.=	"</tr>";
		}
		
		$Search['LIST']	.=	"<tr><td colspan=20>".$LNG['se_input_hay']."<font color=lime>".$CountQuery['total']."</font>".$SName."</td></tr>";
		$Search['LIST']	.=	"</table>";
	
	
		$db->free_result($FinalQuery);
		
		return $Search;
	}
	else
	{
		$Result['LIST']	 =	"<br><table border='0px' style='background:url(images/Adm/blank.gif);' width='90%'>";
		$Result['LIST']	.=	"<tr><td style='color:#00CC33;border: 2px red solid;' height='25px'><font color=red>".$LNG['se_no_data']."</font></td></tr>";
		$Result['LIST']	.=	"</table>";
		return $Result;
	}
}

?>