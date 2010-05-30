<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.'.PHP_EXT);


if ($Observation != 1) die(message ($LNG['404_page']));

$Micro = explode(" ", microTIMESTAMP);
$Time_One = ($Micro[1] + $Micro[0]);

$parse	=	$LNG;

function MyCrazyLittleSearch($SpecifyItems, $WhereItem, $SpecifyWhere, $SpecialSpecify, $Order, $OrderBY, $Limit, $Table, $Page, $NameLang, $ArrayOSec, $Minimize, $SName)
{
	global $USER, $LNG, $EditUsers, $db;
	
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
	$CountQuery		=	$db->fetch_array($db->query($QueryCSearch));
	
	if ($CountQuery['total'] > 0)
	{
		$NumberOfPages = ceil($CountQuery['total'] / $Limit);
	
		$UrlForPage	=	"SearchingPage.php?search=".$_GET['search']."
						&search_in=".$_GET['search_in']."
						&fuki=".$_GET['fuki']."
						&key_user=".$_GET['key_user']."
						&key_order=".$_GET['key_order']."
						&key_acc=".$_GET['key_acc']."
						&Limit=".$_GET['Limit'];
						 
		if($NumberOfPages > 1)
		{
			$BeforePage	=	($Page - 1);
			$NextPage	=	($Page + 1);
			
			for ($i = 1; $i <= $NumberOfPages; $i++)
			{ 
				if ($Page == $i) 
					$PAGEE	.=	 "&nbsp;".$Page."&nbsp;"; 
				else
					$PAGEE	.=	 " <a href='".$UrlForPage."&Page=".$i.$Minimize."'>".$i."</a> ";	
			}

			if(($Page - 1) > 0) 
				$BEFORE	=	 "<a href='".$UrlForPage."&Page=".$BeforePage.$Minimize."'>
						<img src=\"../styles/images/Adm/arrowleft.png\" title=".$LNG['se__before']." height=10 width=14></a> ";
		
			if(($Page + 1) <= $NumberOfPages) 
				$NEXT	=	 "<a href='".$UrlForPage."&Page=".$NextPage.$Minimize."'>
						<img src=\"../styles/images/Adm/arrowright.png\" title=".$LNG['se__next']." height=10 width=14></a>";
		

			$Search['PAGES']	=		
				"<tr>
					<td colspan=3 style=\"color:#00CC33;border: 1px lime solid;\">".$BEFORE."&nbsp; ".$PAGEE." &nbsp;".$NEXT."</td>
				</tr>";
		}
	

		$Search['LIST']	 =	"<table width=\"100%\">";
		$Search['LIST']	.=	"<tr>";
	
		for ($i = 0; $i < $CountArray; $i++)
			$Search['LIST']	.=	"<td class=c>".$NameLang[$i]."</td>";
	
		if ($Table == "users") 
		{
			$Search['LIST']	.=	"<td class=c>".$LNG['se_search_info']."</td>";


			if ($USER['authlevel']	==	'3')
				$Search['LIST']	.=	"<td class=c>".$LNG['button_delete']."</td>";
		}
		
		if ($Table == "planets")
		{				
			if ($EditUsers == '1')
				$Search['LIST']	.=	"<td class=c>".$LNG['se_search_edit']."</td>";
				
			if ($USER['authlevel'] == '3')
				$Search['LIST']	.=	"<td class=c>".$LNG['button_delete']."</td>";
		}

		
		$Search['LIST']	.=	"</tr>";
	
	
		while ($WhileResult	=	$db->fetch_num($FinalQuery))
		{
			$Search['LIST']	 .=	"<tr>";
			if ($Table == "users"){
				if ($_GET['search'] == "online")
					$WhileResult[3]	=	pretty_time( TIMESTAMP - $WhileResult[3] );
				else
					$WhileResult[3]	=	date("d-m-Y H:i:s", $WhileResult[3] );
					
				$WhileResult[4]	=	date("d-m-Y H:i:s", $WhileResult[4]);
				
				$WhileResult[6]	=	$LNG['rank'][$WhileResult[6]];
				(($WhileResult[7] == '1')	? $WhileResult[7] = "<font color=lime>".$LNG['one_is_yes'][1]."</font>" : $WhileResult[7] = $LNG['one_is_yes'][0]);
				(($WhileResult[8] == '1')	? $WhileResult[8] = "<font color=lime>".$LNG['one_is_yes'][1]."</font>" : $WhileResult[8] = $LNG['one_is_yes'][0]);
			}
			
			if ($Table == "banned"){
				$WhileResult[2]	=	date("d-m-Y H:i:s", $WhileResult[2]);
				$WhileResult[3]	=	date("d-m-Y H:i:s", $WhileResult[3]);
			}
			
			if ($Table == "alliance")
				$WhileResult[4]	=	date("d-m-Y H:i:s", $WhileResult[4]);
				
			if ($Table == "planets") {
				$WhileResult[3]	=	pretty_time(TIMESTAMP - $WhileResult[3]);
				$WhileResult[7]	= 	$WhileResult[7] > 0 ? "<font color=lime>".$LNG['one_is_yes'][1]."</font>" : $LNG['one_is_yes'][0];
			}
			for ($i = 0; $i < $CountArray; $i++)
				$Search['LIST']	.=	"<th>".$WhileResult[$i]."</th>";
		
		
			if ($Table == "users")
			{
				$Search['LIST']	.=	"<th><a href=AccountDataPage.php?id_u=".$WhileResult[0]."><img title=\"".$WhileResult[1]."\" src=\"../styles/images/Adm/GO.png\"></a></th>";
			
			
				if ($USER['authlevel']	==	'3')
				{
					if ($WhileResult[0] != $USER['id'])
						$DELETEBUTTON	=	"<a href=\"SearchingPage.php?delete=user&user=".$WhileResult[0]."\" border=\"0\" onclick=\"return confirm('".$LNG['ul_sure_you_want_dlte']." $WhileResult[1]?');\"><img src=\"../styles/images/r1.png\" title=".$WhileResult[1]."></a>";
					else
						$DELETEBUTTON	=	"-";
					
					$Search['LIST']	.=	"<th>".$DELETEBUTTON."</th>";
				}
			}
		
			if ($Table == "planets"){
			
				if ($EditUsers == '1')
					$Search['LIST']	.=	"<th><a href=\"javascript:openEdit('".$WhileResult[0]."', 'planet');\" border=\"0\"><img src=\"../styles/images/Adm/GO.png\" title=".$LNG['se_search_edit']."></a></th>";
					
				if ($USER['authlevel'] == '3')
					$Search['LIST']	.=	"<th><a href=\"SearchingPage.php?delete=planet&planet=".$WhileResult[0]."\" border=\"0\" onclick=\"return confirm('".$LNG['se_confirm_planet']." $WhileResult[1]');\"><img src=\"../styles/images/r1.png\" title=".$LNG['button_delete']."></a></th>";
			}
			
			$Search['LIST']	.=	"</tr>";
		}
		
		$Search['LIST']	.=	"<tr><th colspan=20>".$LNG['se_input_hay']."<font color=lime>".$CountQuery['total']."</font>".$SName."</th></tr>";
		$Search['LIST']	.=	"</table>";
	
	
		$db->free_result($FinalQuery);
		
		$Result	.=	parsetemplate(gettemplate('adm/SearchInDBRow'), $Search);
	
	
		return $Result;
	}
	else
	{
		$Result	 =	"<br><table border='0px' style='background:url(images/Adm/blank.gif);' width='100%'>";
		$Result	.=	"<tr><th style='color:#00CC33;border: 2px red solid;' height='25px'><font color=red>".$LNG['se_no_data']."</font></th></tr>";
		$Result	.=	"</table>";
		return $Result;
	}
}

// BORRADO
include_once(ROOT_PATH . 'includes/functions/DeleteSelectedUser.'.PHP_EXT);
if ($_GET['delete'] == 'user'){
	DeleteSelectedUser ($_GET['user']);
	$Log	.=	"\n".$LNG['log_searchindb_del1'].$_GET['user'].$LNG['log_searchindb_del2'].$USER['username']."\n";
	LogFunction($Log, "GeneralLog", $LogCanWork);
	message($LNG['se_delete_succes_p'], "SearchingPage.php?search=users&minimize=on", 2);}
elseif ($_GET['delete'] == 'planet'){
	DeleteSelectedPlanet ($_GET['planet']);
	$Log	.=	"\n".$LNG['log_searchindb_del3'].$_GET['planet'].$LNG['log_searchindb_del2'].$USER['username']."\n";
	LogFunction($Log, "GeneralLog", $LogCanWork);
	message($LNG['se_delete_succes_p'], "SearchingPage.php?search=planet&minimize=on", 2);
	}
		
		
		
$SearchFile		=	$_GET['search'];
$SearchFor		=	$_GET['search_in'];
$SearchMethod	=	$_GET['fuki'];
$SpecifyWhere	=	$parse['Key']	=	$_GET['key_user'];
$Page 			= 	$_GET['Page'];
$Order			=	$_GET['key_order'];
$OrderBY		=	$_GET['key_acc'];
((!$_GET['Limit']) ? $Limit	=	'25' : $Limit	=	$_GET['Limit']);


// TABLA DE BÚSQUEDA
$parse['OPT_LIST']	 =	'<option value="users"'.(($SearchFile == "users") ? " selected": "").'>'.$LNG['se_users'].'</option>';
$parse['OPT_LIST']	.=	'<option value="planet"'.(($SearchFile == "planet") ? " selected": "").'>'.$LNG['se_planets'].'</option>';
$parse['OPT_LIST']	.=	'<option value="moon"'.(($SearchFile == "moon") ? " selected": "").'>'.$LNG['se_moons'].'</option>';
$parse['OPT_LIST']	.=	'<option value="alliance"'.(($SearchFile == "alliance") ? " selected": "").'>'.$LNG['se_allys'].'</option>';
$parse['OPT_LIST']	.=	'<option value="vacation"'.(($SearchFile == "vacation") ? " selected": "").'>'.$LNG['se_vacations'].'</option>';
$parse['OPT_LIST']	.=	'<option value="banned"'.(($SearchFile == "banned") ? " selected": "").'>'.$LNG['se_suspended'].'</option>';
$parse['OPT_LIST']	.=	'<option value="admin"'.(($SearchFile == "admin") ? " selected": "").'>'.$LNG['se_authlevels'].'</option>';
$parse['OPT_LIST']	.=	'<option value="inactives"'.(($SearchFile == "inactives") ? " selected": "").'>'.$LNG['se_inactives'].'</option>';
$parse['OPT_LIST']	.=	'<option value="online"'.(($SearchFile == "online") ? " selected": "").'>'.$LNG['online_users'].'</option>';
$parse['OPT_LIST']	.=	'<option value="p_connect"'.(($SearchFile == "p_connect") ? " selected": "").'>'.$LNG['se_planets_act'].'</option>';

// BÚSQUEDA POR ID O NOMBRE
$parse['OPT_SEARCH']	 =	'<option value="name"'.(($SearchFor == "name") ? " selected": "").((!$SearchFor) ? " selected": "").'>'.$LNG['se_input_name'].'</option>';
$parse['OPT_SEARCH']	.=	'<option value="id"'.(($SearchFor == "id") ? " selected": "").'>'.$LNG['input_id'].'</option>';

// TIPO DE FILTRO: BÚSQUEDA EXACTA, NORMAL, ETC
$parse['EXT_LIST']	 =	'<option value="normal"'.(($SearchMethod == "normal") ? " selected": "").'>'.$LNG['se_type_all'].'</option>';
$parse['EXT_LIST']	.=	'<option value="exacto"'.(($SearchMethod == "exacto") ? " selected": "").'>'.$LNG['se_type_exact'].'</option>';
$parse['EXT_LIST']	.=	'<option value="last"'.(($SearchMethod == "last") ? " selected": "").'>'.$LNG['se_type_last'].'</option>';
$parse['EXT_LIST']	.=	'<option value="first"'.(($SearchMethod == "first") ? " selected": "").'>'.$LNG['se_type_first'].'</option>';

// ASCENDIENTE / DESCENDIENTE
$parse['ORDER']	 =	'<option value="ASC"'.(($OrderBY == "ASC") ? " selected": "").'>'.$LNG['se_input_asc'].'</option>';
$parse['ORDER']	.=	'<option value="DESC"'.(($OrderBY == "DESC") ? " selected": "").'>'.$LNG['se_input_desc'].'</option>';

// LIMITE DE USUARIOS A MOSTRAR
$parse['LIMIT']	 .=	'<option value="1"'.(($Limit == '1') ? " selected": "").'>1</option>';
$parse['LIMIT']	 .=	'<option value="5"'.(($Limit == '5') ? " selected": "").'>5</option>';
$parse['LIMIT']	 .=	'<option value="10"'.(($Limit == '10') ? " selected": "").'>10</option>';
$parse['LIMIT']	 .=	'<option value="15"'.(($Limit == '15') ? " selected": "").'>15</option>';
$parse['LIMIT']	 .=	'<option value="20"'.(($Limit == '20') ? " selected": "").'>20</option>';
$parse['LIMIT']	 .=	'<option value="25"'.(($Limit == '25') ? " selected": "").((!$Limit) ? " selected": "").'>25</option>';
$parse['LIMIT']	 .=	'<option value="50"'.(($Limit == '50') ? " selected": "").'>50</option>';
$parse['LIMIT']	 .=	'<option value="100"'.(($Limit == '100') ? " selected": "").'>100</option>';
$parse['LIMIT']	 .=	'<option value="200"'.(($Limit == '200') ? " selected": "").'>200</option>';
$parse['LIMIT']	 .=	'<option value="500"'.(($Limit == '500') ? " selected": "").'>500</option>';

// BUSCADOR DE PALABRA CLAVE
if ($SearchMethod == 'exacto' && $SpecifyWhere)
	$SpecifyWhere	=	"= '".$SpecifyWhere."'";
elseif ($SearchMethod == 'last')
	$SpecifyWhere	=	"LIKE '".$SpecifyWhere."%'";
elseif ($SearchMethod == 'first')
	$SpecifyWhere	=	"LIKE '%".$SpecifyWhere."'";
else
	$SpecifyWhere	=	"LIKE '%".$SpecifyWhere."%'";

// MINIMIZADOR
if ($_GET['minimize'] == 'on')
{
	$Minimize				=	"&minimize=on";
	$parse['minimize']		=	'checked = "checked"';
	$parse['diisplaay']		=	"none";
}

if ($_GET)
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
			
			
		(($SearchFor == "name") ? $WhereItem = "WHERE username" : $WhereItem = "WHERE id");
		$ArrayOSec		=	array("id", "username", "email_2", "onlinetime", "register_time", "user_lastip", "authlevel", "bana", "urlaubs_modus");
		$Array0SecCount	=	count($ArrayOSec);

		for ($OrderNum = 0; $OrderNum < $Array0SecCount; $OrderNum++)
			$OrderBYParse	 .=	'<option value="'.$ArrayOSec[$OrderNum].'"'.(($Order == $ArrayOSec[$OrderNum]) ? " selected": "").'>'.$LNG['se_search_users'][$OrderNum].'</option>';
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
			
		if ($SearchFile == "moon"){
			$SpecialSpecify	=	"AND planet_type = '3'";
			$SName			=	$LNG['se_input_moonn'];}
			
		if ($SearchFile == "p_connect"){
			$SpecialSpecify	=	"AND last_update >= '".(TIMESTAMP - 60 * 60)."'";
			$SName			=	$LNG['se_input_act_pla'];}
			
		
		(($SearchFor == "name") ? $WhereItem = "WHERE name" : $WhereItem = "WHERE id");
		
		$ArrayOSec		=	array("id", "name", "id_owner", "id_luna", "last_update", "galaxy", "system", "planet");
		$Array0SecCount	=	count($ArrayOSec);
		
		for ($OrderNum = 0; $OrderNum < $Array0SecCount; $OrderNum++)
			$OrderBYParse	 .=	'<option value="'.$ArrayOSec[$OrderNum].'"'.(($Order == $ArrayOSec[$OrderNum]) ? " selected": "").'>'.$LNG['se_search_planets'][$OrderNum].'</option>';
	}
	
	
	elseif (in_array($SearchFile, $ArrayBanned))
	{
		$Table			=	"banned";
		$NameLang		=	$LNG['se_search_banned'];
		$SpecifyItems	=	"id,who,time,longer,theme,author";
		$SName			=	$LNG['se_input_susss'];
		
		(($SearchFor == "name") ? $WhereItem = "WHERE who" : $WhereItem = "WHERE id");
		
		
		$ArrayOSec		=	array("id", "who", "time", "longer", "theme", "author");
		$Array0SecCount	=	count($ArrayOSec);
		
		for ($OrderNum = 0; $OrderNum < $Array0SecCount; $OrderNum++)
			$OrderBYParse	 .=	'<option value="'.$ArrayOSec[$OrderNum].'"'.(($Order == $ArrayOSec[$OrderNum]) ? " selected": "").'>'.$LNG['se_search_banned'][$OrderNum].'</option>';
	}
	
	
	elseif (in_array($SearchFile, $ArrayAlliance))
	{
		$Table			=	"alliance";
		$NameLang		=	$LNG['se_search_alliance'];
		$SpecifyItems	=	"id,ally_name,ally_tag,ally_owner,ally_register_time,ally_members";
		$SName			=	$LNG['se_input_allyy'];
		
		(($SearchFor == "name") ? $WhereItem = "WHERE ally_name" : $WhereItem = "WHERE id");
		
		
		$ArrayOSec		=	array("id", "ally_name", "ally_tag", "ally_owner", "ally_register_time", "ally_members");
		$Array0SecCount	=	count($ArrayOSec);
		
		for ($OrderNum = 0; $OrderNum < $Array0SecCount; $OrderNum++)
			$OrderBYParse	 .=	'<option value="'.$ArrayOSec[$OrderNum].'"'.(($Order == $ArrayOSec[$OrderNum]) ? " selected": "").'>'.$LNG['se_search_alliance'][$OrderNum].'</option>';
	}


	$parse['ORDER_BY_TITLE']	=
		"<th>
			".$LNG['se_search_order']."
		</th>";
		
	$parse['ORDER_BY']	=
			"<th>
				<select name=\"key_order\">
					".$OrderBYParse."
				</select>
			</th>";
			
			
	$parse['TPL_ROW']	=	MyCrazyLittleSearch($SpecifyItems, $WhereItem, $SpecifyWhere, $SpecialSpecify, $Order, $OrderBY, $Limit, $Table, $Page, $NameLang, $ArrayOSec, $Minimize, $SName);
}


$Micro 						= 	explode(" ", microTIMESTAMP);
$Time_Two 					= 	(($Micro[1] + $Micro[0]) - $Time_One);
$parse['TimeToCreatePage']	=	$LNG['se_time_of_page'].$Time_Two."&nbsp;".$LNG['time_seconds']; 


display(parsetemplate(gettemplate('adm/SearchInDBBody'), $parse), false, '', true, false);
?>