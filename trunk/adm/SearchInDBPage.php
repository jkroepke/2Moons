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


if ($Observation != 1) die();

$parse			=	$lang;
$key_user		=	$_POST['key_user'];
$parse['key']	=	$key_user;

switch($_POST[search])
{

	// USUARIOS ####################################################################
	case 'user':
	$parse['selected_u']	=	'selected = "selected"';
	
	if ($_POST['key_order'] == 'username')
		$b	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'email_2')
		$c	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'authlevel')
		$d	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'onlinetime')
		$e	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'register_time')
		$f	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'user_lastip')
		$g	=	'checked = "checked"';
	else 
		$a	=	'checked = "checked"';
		
	if ($_POST['key_acc']	==	'DESC')
		$y	=	'checked = "checked"';
	else
		$z	=	'checked = "checked"';
	
	$parse['orderby']	=	
				'<table width="70%">
				<tr>
					<td class="c">-</td>
					<td class="c">'.$lang['se_input_id'].'</td>
					<td class="c">'.$lang['se_input_name'].'</td>
					<td class="c">'.$lang['se_input_email'].'</td>
					<td class="c">'.$lang['se_input_authlevel'].'</td>
					<td class="c">'.$lang['se_input_activity'].'</td>
					<td class="c">'.$lang['se_input_register'].'</td>
					<td class="c">'.$lang['se_input_ip'].'</td>
					<th><a href="#" title="'.$lang['se_input_asc'].'">'.$lang['se_input_a'].' </a> 
					<input type="radio" name="key_acc" value="ASC" '.$z.' title="'.$lang['se_input_asc'].'">&nbsp; 
					<a href="#" title="'.$lang['se_input_desc'].'">'.$lang['se_input_d'].' </a>
					<input type="radio" name="key_acc" value="DESC" '.$y.' title="'.$lang['se_input_desc'].'"></th>
				</tr><tr>
					<th width="15%">'.$lang['se_input_orderby'].'</th>
					<th width="20%"><input type="radio" name="key_order" value="id" '.$a.'></th>
					<th width="20%"><input type="radio" name="key_order" value="username" '.$b.'></th>
					<th width="20%"><input type="radio" name="key_order" value="email_2" '.$c.'></th>
					<th width="20%"><input type="radio" name="key_order" value="authlevel" '.$d.'></th>
					<th width="30%"><input type="radio" name="key_order" value="onlinetime" '.$e.'></th>
					<th width="30%"><input type="radio" name="key_order" value="register_time" '.$f.'></th>
					<th width="30%"><input type="radio" name="key_order" value="user_lastip" '.$g.'></th>
					<th width="10%"><input type="submit" value="'.$lang['se_input_submit'].'"></th>
				</tr>
				</table>';
	
	$QueryFind	=	$db->fetch_array($db->query("SELECT * FROM ".USERS.";"));
	$ORDERBY	=	$_POST['key_order'];
	$ORDERBY2	=	$_POST['key_acc'];
	if (!$ORDERBY || !$QueryFind[$ORDERBY])
		$ORDER	=	"id";
	else
		$ORDER	=	$_POST['key_order'];
		
		
	if ($key_user	!=	NULL)
	{
		$search	=	$db->query("SELECT * FROM ".USERS." WHERE `username` LIKE '%{$key_user}%' ORDER BY `".$ORDER."` ".$ORDERBY2.";");
	}
	else
	{
		$search	=	$db->query("SELECT * FROM ".USERS." ORDER BY `".$ORDER."` ".$ORDERBY2.";");
	}
	
	$cnt	=	$db->num_rows($search);
	if ($cnt	!=	NULL)
	{
		while ($user	=	$db->fetch_array($search))
		{
			$id			=	$user['id'];
			$name		=	$user['username'];
			$email		=	$user['email_2'];
			$onlinetime	=	$user['onlinetime'];
			$reg_time	=	$user['register_time'];
			$user_ip	=	$user['user_lastip'];
			$authlevel	=	$user['authlevel'];
			$suspended	=	$user['bana'];
			$vacations	=	$user['urlaubs_modus'];
		
			if ($suspended == '0' or $suspended == NULL){$suspended = $lang['se_no'];}else{$suspended = "<font color=lime>".$lang['se_yes']."</font>";}
			if ($vacations == '0'){$vacations = $lang['se_no'];}else{$vacations = "<font color=aqua>".$lang['se_yes']."</font>";}
			for ($i = 0; $i < 5; $i++)
			{
				if ($authlevel == $i){$authlevel = $lang['se_authlevel'][$i];}
			}
		
			
			$parse['table1']	 =
			"<table width=\"90%\">
			".$OrderBy."
			<tr><td class=\"c\">".$lang['se_id']."</th><td class=\"c\">".$lang['se_name']."</th><td class=\"c\">".$lang['se_email']."</th>
			<td class=\"c\">".$lang['se_auth']."</th><td class=\"c\">".$lang['se_ban']."</th><td class=\"c\">".$lang['se_vacat']."</th>
			<td class=\"c\">".$lang['se_input_activity']."</th><td class=\"c\">".$lang['se_input_register']."</th>
			<td class=\"c\">".$lang['se_input_ip']."</th></tr>";
			
			$parse['table2']	.=
			"<tr><th>".$id."</th><th>".$name."</th><th>".$email."</th><th>".$authlevel."</th><th>".$suspended."</th><th>".$vacations."</th>
			<th>".date("d/M/y H:i:s",$onlinetime)."</th><th>".date("d/M/y H:i:s",$reg_time)."</th><th>".$user_ip."</th></tr>";
			
			$parse['table3']	 =	"<tr><th colspan=\"20\">".$lang['se_input_hay'].$cnt.$lang['se_input_userss']."</th></tr></table>";
		}
		
	}
	else
	{
		$parse['error']	=	$lang['se_no_data'];
	}
	display(parsetemplate(gettemplate('adm/SearchInDBBody'), $parse), false, '', true, false);
	break;
	
	
	// PLANETAS ####################################################################
	case 'planet':
	$parse['selected_p']	=	'selected = "selected"';
	
	if ($_POST['key_order'] == 'name')
		$b	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'id_owner')
		$c	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'galaxy')
		$d	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'system')
		$e	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'planet')
		$f	=	'checked = "checked"';
	else 
		$a	=	'checked = "checked"';
		
	if ($_POST['key_acc']	==	'DESC')
		$y	=	'checked = "checked"';
	else
		$z	=	'checked = "checked"';
	
	$parse['orderby']	=	
				'<table width="60%">
				<tr>
					<td class="c">-</td>
					<td class="c">'.$lang['se_input_id'].'</td>
					<td class="c">'.$lang['se_input_name'].'</td>
					<td class="c">'.$lang['se_input_prop'].'</td>
					<td class="c">'.$lang['se_input_g'].'</td>
					<td class="c">'.$lang['se_input_s'].'</td>
					<td class="c">'.$lang['se_input_p'].'</td>
					<th><a href="#" title="'.$lang['se_input_asc'].'">'.$lang['se_input_a'].' </a> 
					<input type="radio" name="key_acc" value="ASC" '.$z.' title="'.$lang['se_input_asc'].'">&nbsp; 
					<a href="#" title="'.$lang['se_input_desc'].'">'.$lang['se_input_d'].' </a>
					<input type="radio" name="key_acc" value="DESC" '.$y.' title="'.$lang['se_input_desc'].'"></th>
				</tr><tr>
					<th width="15%">'.$lang['se_input_orderby'].'</th>
					<th width="20%"><input type="radio" name="key_order" value="id" '.$a.'></th>
					<th width="20%"><input type="radio" name="key_order" value="name" '.$b.'></th>
					<th width="20%"><input type="radio" name="key_order" value="id_owner" '.$c.'></th>
					<th width="20%"><input type="radio" name="key_order" value="galaxy" '.$d.'></th>
					<th width="20%"><input type="radio" name="key_order" value="system" '.$e.'></th>
					<th width="20%"><input type="radio" name="key_order" value="planet" '.$f.'></th>
					<th width="10%"><input type="submit" value="'.$lang['se_input_submit'].'"></th>
				</tr>
				</table>';
			
	$QueryFind	=	$db->fetch_array($db->query("SELECT * FROM ".PLANETS.";"));
	$ORDERBY	=	$_POST['key_order'];
	$ORDERBY2	=	$_POST['key_acc'];
	if (!$ORDERBY || !$QueryFind[$ORDERBY])
		$ORDER	=	"id";
	else
		$ORDER	=	$_POST['key_order'];
		
	if ($key_user	==	NULL)
	{
		$search	=	$db->query("SELECT * FROM ".PLANETS." WHERE `planet_type` = '1' ORDER BY `".$ORDER."` ".$ORDERBY2.";");
	}
	else
	{
		$search	=	$db->query("SELECT * FROM ".PLANETS." WHERE `name` LIKE '%{$key_user}%' AND `planet_type` = '1' ORDER BY `".$ORDER."` ".$ORDERBY2.";");
	}
	
	$cnt	=	$db->num_rows($search);
	if ($cnt	==	NULL)
	{
		$parse['error']	=	$lang['se_no_data'];
	}
	else
	{
		while ($planet	=	$db->fetch_array($search))
		{
			$id			=	$planet['id'];
			$name		=	$planet['name'];
			$id_owner	=	$planet['id_owner'];
			$g			=	$planet['galaxy'];
			$s			=	$planet['system'];
			$p			=	$planet['planet'];
			
			if ($planet['id_luna'] != 0)
				$moons	=	"<font color=lime>".$lang['se_yes']."</font>";
			else
				$moons	=	$lang['se_no'];
			
			$parse['table1']	 =
			"<table width=\"65%\">
			<tr><td class=\"c\">".$lang['se_id']."</th><td class=\"c\">".$lang['se_name']."</th><td class=\"c\">".$lang['se_id_owner']."</th>
			<td class=\"c\">".$lang['se_galaxy']."</th><td class=\"c\">".$lang['se_system']."</th><td class=\"c\">".$lang['se_planet']."</th>
			<td class=\"c\">".$lang['se_input_have_moon']."</th></tr>";
			
			$parse['table2']	.=
			"<tr><th>".$id."</th><th>".$name."</th><th>".$id_owner."</th><th>".$g."</th><th>".$s."</th><th>".$p."</th><th>".$moons."</th></tr>";
			
			$parse['table3']	 =	"<tr><th colspan=\"20\">".$lang['se_input_hay'].$cnt.$lang['se_input_planett']."</th></tr></table>";
		}
	}
	display(parsetemplate(gettemplate('adm/SearchInDBBody'), $parse), false, '', true, false);
	break;
	
	
	// LUNAS ####################################################################
	case 'moon':
	$parse['selected_m']	=	'selected = "selected"';
	
	if ($_POST['key_order'] == 'name')
		$b	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'id_owner')
		$c	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'galaxy')
		$d	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'system')
		$e	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'planet')
		$f	=	'checked = "checked"';
	else 
		$a	=	'checked = "checked"';
		
	if ($_POST['key_acc']	==	'DESC')
		$y	=	'checked = "checked"';
	else
		$z	=	'checked = "checked"';
	
	$parse['orderby']	=	
				'<table width="60%">
				<tr>
					<td class="c">-</td>
					<td class="c">'.$lang['se_input_id'].'</td>
					<td class="c">'.$lang['se_input_name'].'</td>
					<td class="c">'.$lang['se_input_prop'].'</td>
					<td class="c">'.$lang['se_input_g'].'</td>
					<td class="c">'.$lang['se_input_s'].'</td>
					<td class="c">'.$lang['se_input_p'].'</td>
					<th><a href="#" title="'.$lang['se_input_asc'].'">'.$lang['se_input_a'].' </a> 
					<input type="radio" name="key_acc" value="ASC" '.$z.' title="'.$lang['se_input_asc'].'">&nbsp; 
					<a href="#" title="'.$lang['se_input_desc'].'">'.$lang['se_input_d'].' </a>
					<input type="radio" name="key_acc" value="DESC" '.$y.' title="'.$lang['se_input_desc'].'"></th>
				</tr><tr>
					<th width="15%">'.$lang['se_input_orderby'].'</th>
					<th width="20%"><input type="radio" name="key_order" value="id" '.$a.'></th>
					<th width="20%"><input type="radio" name="key_order" value="name" '.$b.'></th>
					<th width="20%"><input type="radio" name="key_order" value="id_owner" '.$c.'></th>
					<th width="20%"><input type="radio" name="key_order" value="galaxy" '.$d.'></th>
					<th width="20%"><input type="radio" name="key_order" value="system" '.$e.'></th>
					<th width="20%"><input type="radio" name="key_order" value="planet" '.$f.'></th>
					<th width="10%"><input type="submit" value="'.$lang['se_input_submit'].'"></th>
				</tr>
				</table>';
			
	$QueryFind	=	$db->fetch_array($db->query("SELECT * FROM ".PLANETS.";"));
	$ORDERBY	=	$_POST['key_order'];
	$ORDERBY2	=	$_POST['key_acc'];
	if (!$ORDERBY || !$QueryFind[$ORDERBY])
		$ORDER	=	"id";
	else
		$ORDER	=	$_POST['key_order'];
		
	if ($key_user	==	NULL)
	{
		$search	=	$db->query("SELECT * FROM ".PLANETS." WHERE `planet_type` = '3' ORDER BY `".$ORDER."` ".$ORDERBY2.";");
	}
	else
	{
		$search	=	$db->query("SELECT * FROM ".PLANETS." WHERE `name` LIKE '%{$key_user}%' AND `planet_type` = '3' ORDER BY `".$ORDER."` ".$ORDERBY2.";");
	}
	
	$cnt	=	$db->num_rows($search);
	if ($cnt	==	NULL)
	{
		$parse['error']	=	$lang['se_no_data'];
	}
	else
	{
		while ($moon	=	$db->fetch_array($search))
		{
			$id			=	$moon['id'];
			$name		=	$moon['name'];
			$id_owner	=	$moon['id_owner'];
			$g			=	$moon['galaxy'];
			$s			=	$moon['system'];
			$p			=	$moon['planet'];
		
		
			$parse['table1']	 =
			"<table width=\"65%\">
			<tr><td class=\"c\">".$lang['se_id']."</th><td class=\"c\">".$lang['se_name']."</th><td class=\"c\">".$lang['se_id_owner']."</th>
			<td class=\"c\">".$lang['se_galaxy']."</th><td class=\"c\">".$lang['se_system']."</th><td class=\"c\">".$lang['se_planet']."</th></tr>";
			
			$parse['table2']	.=
			"<tr><th>".$id."</th><th>".$name."</th><th>".$id_owner."</th><th>".$g."</th><th>".$s."</th><th>".$p."</th></tr>";
			
			$parse['table3']	 =	"<tr><th colspan=\"20\">".$lang['se_input_hay'].$cnt.$lang['se_input_moonn']."</th></tr></table>";
		}
	}
	display(parsetemplate(gettemplate('adm/SearchInDBBody'), $parse), false, '', true, false);
	break;
	
	// ALIANZAS ####################################################################
	case 'ally':
	$parse['selected_a']	=	'selected = "selected"';
	
	if ($_POST['key_order'] == 'ally_name')
		$b	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'ally_tag')
		$c	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'ally_owner')
		$d	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'ally_register_time')
		$e	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'ally_members')
		$f	=	'checked = "checked"';
	else 
		$a	=	'checked = "checked"';
		
	if ($_POST['key_acc']	==	'DESC')
		$y	=	'checked = "checked"';
	else
		$z	=	'checked = "checked"';
	
	$parse['orderby']	=	
				'<table width="70%">
				<tr>
					<td class="c">-</td>
					<td class="c">'.$lang['se_input_id'].'</td>
					<td class="c">'.$lang['se_input_name'].'</td>
					<td class="c">'.$lang['se_tag'].'</td>
					<td class="c">'.$lang['se_input_prop'].'</td>
					<td class="c">'.$lang['se_input_register'].'</td>
					<td class="c">'.$lang['se_input_members2'].'</td>
					<th><a href="#" title="'.$lang['se_input_asc'].'">'.$lang['se_input_a'].' </a> 
					<input type="radio" name="key_acc" value="ASC" '.$z.' title="'.$lang['se_input_asc'].'">&nbsp; 
					<a href="#" title="'.$lang['se_input_desc'].'">'.$lang['se_input_d'].' </a>
					<input type="radio" name="key_acc" value="DESC" '.$y.' title="'.$lang['se_input_desc'].'"></th>
				</tr><tr>
					<th width="15%">'.$lang['se_input_orderby'].'</th>
					<th width="20%"><input type="radio" name="key_order" value="id" '.$a.'></th>
					<th width="20%"><input type="radio" name="key_order" value="ally_name" '.$b.'></th>
					<th width="20%"><input type="radio" name="key_order" value="ally_tag" '.$c.'></th>
					<th width="20%"><input type="radio" name="key_order" value="ally_owner" '.$d.'></th>
					<th width="20%"><input type="radio" name="key_order" value="ally_register_time" '.$e.'></th>
					<th width="20%"><input type="radio" name="key_order" value="ally_members" '.$f.'></th>
					<th width="10%"><input type="submit" value="'.$lang['se_input_submit'].'"></th>
				</tr>
				</table>';
			
	$QueryFind	=	$db->fetch_array($db->query("SELECT * FROM ".ALLIANCE.";"));
	$ORDERBY	=	$_POST['key_order'];
	$ORDERBY2	=	$_POST['key_acc'];
	if (!$ORDERBY || !$QueryFind[$ORDERBY])
		$ORDER	=	"id";
	else
		$ORDER	=	$_POST['key_order'];
		
	if ($key_user	==	NULL)
	{
		$search	=	$db->query("SELECT * FROM ".ALLIANCE." ORDER BY `".$ORDER."` ".$ORDERBY2.";");
	}
	else
	{
		$search	=	$db->query("SELECT * FROM ".ALLIANCE." WHERE `ally_name` LIKE '%{$key_user}%' ORDER BY `".$ORDER."` ".$ORDERBY2.";");
	}
	
	$cnt	=	$db->num_rows($search);
	if ($cnt	==	NULL)
	{
		$parse['error']	=	$lang['se_no_data'];
	}
	else
	{
		while ($alliances	=	$db->fetch_array($search))
		{
			$id				=	$alliances['id'];
			$ally_name		=	$alliances['ally_name'];
			$ally_tag		=	$alliances['ally_tag'];
			$ally_owner		=	$alliances['ally_owner'];
			$reg_time_a		=	$alliances['ally_register_time'];
			$ally_members	=	$alliances['ally_members'];
		
		
			$parse['table1']	 =
			"<table width=\"55%\">
			<tr><td class=\"c\">".$lang['se_id']."</th><td class=\"c\">".$lang['se_name']."</th><td class=\"c\">".$lang['se_tag']."</th>
			<td class=\"c\">".$lang['se_id_owner']."</th><td class=\"c\">".$lang['se_input_register']."</th><td class=\"c\">".$lang['se_input_members']."</th></tr>";
			
			$parse['table2']	.=
			"<tr><th>".$id."</th><th>".$ally_name."</th><th>".$ally_tag."</th><th>".$ally_owner."</th><th>".date("d/M/y H:i:s",$reg_time_a)."</th>
			<th>".$ally_members."</th></tr>";
			
			$parse['table3']	 =	"<tr><th colspan=\"20\">".$lang['se_input_hay'].$cnt.$lang['se_input_allyy']."</th></tr></table>";
		}
	}
	display(parsetemplate(gettemplate('adm/SearchInDBBody'), $parse), false, '', true, false);
	break;
	
	
	// VACACIONES ####################################################################
	case 'vacation':
	$parse['selected_v']	=	'selected = "selected"';
	
	if ($_POST['key_order'] == 'username')
		$b	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'email_2')
		$c	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'authlevel')
		$d	=	'checked = "checked"';
	else 
		$a	=	'checked = "checked"';
		
	if ($_POST['key_acc']	==	'DESC')
		$y	=	'checked = "checked"';
	else
		$z	=	'checked = "checked"';
	
	$parse['orderby']	=	
				'<table width="65%">
				<tr>
					<td class="c">-</td>
					<td class="c">'.$lang['se_input_id'].'</td>
					<td class="c">'.$lang['se_input_name'].'</td>
					<td class="c">'.$lang['se_input_email'].'</td>
					<td class="c">'.$lang['se_input_authlevel'].'</td>
					<th><a href="#" title="'.$lang['se_input_asc'].'">'.$lang['se_input_a'].' </a> 
					<input type="radio" name="key_acc" value="ASC" '.$z.' title="'.$lang['se_input_asc'].'">&nbsp; 
					<a href="#" title="'.$lang['se_input_desc'].'">'.$lang['se_input_d'].' </a>
					<input type="radio" name="key_acc" value="DESC" '.$y.' title="'.$lang['se_input_desc'].'"></th>
				</tr><tr>
					<th width="15%">'.$lang['se_input_orderby'].'</th>
					<th width="20%"><input type="radio" name="key_order" value="id" '.$a.'></th>
					<th width="20%"><input type="radio" name="key_order" value="username" '.$b.'></th>
					<th width="20%"><input type="radio" name="key_order" value="email_2" '.$c.'></th>
					<th width="20%"><input type="radio" name="key_order" value="authlevel" '.$d.'></th>
					<th width="10%"><input type="submit" value="'.$lang['se_input_submit'].'"></th>
				</tr>
				</table>';
				
	$QueryFind	=	$db->fetch_array($db->query("SELECT * FROM ".USERS.";"));
	$ORDERBY	=	$_POST['key_order'];
	$ORDERBY2	=	$_POST['key_acc'];
	if (!$ORDERBY || !$QueryFind[$ORDERBY])
		$ORDER	=	"id";
	else
		$ORDER	=	$_POST['key_order'];
		
	if ($key_user	==	NULL)
	{
		$search	=	$db->query("SELECT * FROM ".USERS." WHERE `urlaubs_modus` = '1' ORDER BY `".$ORDER."` ".$ORDERBY2.";");
	}
	else
	{
		$search	=	$db->query("SELECT * FROM ".USERS." WHERE `username` LIKE '%{$key_user}%' AND `urlaubs_modus` = '1'  ORDER BY `".$ORDER."` ".$ORDERBY2.";");
	}
	
	$cnt	=	$db->num_rows($search);
	if ($cnt	==	NULL)
	{
		$parse['error']	=	$lang['se_no_data'];
	}
	else
	{
		while ($vacation	=	$db->fetch_array($search))
		{
			$id			=	$vacation['id'];
			$name		=	$vacation['username'];
			$email		=	$vacation['email_2'];
			$authlevel	=	$vacation['authlevel'];
			$suspended	=	$vacation['bana'];
			$vacations	=	$vacation['urlaubs_modus'];
		
			if ($suspended == '0' or $suspended == NULL){$suspended = $lang['se_no'];}else{$suspended = "<font color=lime>".$lang['se_yes']."</font>";}
			if ($vacations == '0'){$vacations = $lang['se_no'];}else{$vacations = "<font color=aqua>".$lang['se_yes']."</font>";}
			for ($i = 0; $i < 5; $i++)
			{
				if ($authlevel == $i){$authlevel = $lang['se_authlevel'][$i];}
			}
		
			
			$parse['table1']	 =
			"<table width=\"65%\">
			<tr><td class=\"c\">".$lang['se_id']."</th><td class=\"c\">".$lang['se_name']."</th><td class=\"c\">".$lang['se_email']."</th>
			<td class=\"c\">".$lang['se_auth']."</th><td class=\"c\">".$lang['se_ban']."</th><td class=\"c\">".$lang['se_vacat']."</th></tr>";
			
			$parse['table2']	.=
			"<tr><th>".$id."</th><th>".$name."</th><th>".$email."</th><th>".$authlevel."</th><th>".$suspended."</th><th>".$vacations."</th></tr>";
			
			$parse['table3']	 =	"<tr><th colspan=\"20\">".$lang['se_input_hay'].$cnt.$lang['se_input_vacatii']."</th></tr></table>";
		}
	}
	display(parsetemplate(gettemplate('adm/SearchInDBBody'), $parse), false, '', true, false);
	break;
	
	
	// SUSPENDIDOS ####################################################################
	case 'suspended':
	$parse['selected_b']	=	'selected = "selected"';
	
	if ($_POST['key_order'] == 'who')
		$b	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'time')
		$c	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'longer')
		$d	=	'checked = "checked"';
	else 
		$a	=	'checked = "checked"';
		
	if ($_POST['key_acc']	==	'DESC')
		$y	=	'checked = "checked"';
	else
		$z	=	'checked = "checked"';
	
	$parse['orderby']	=	
				'<table width="65%">
				<tr>
					<td class="c">-</td>
					<td class="c">'.$lang['se_input_id'].'</td>
					<td class="c">'.$lang['se_input_name'].'</td>
					<td class="c">'.$lang['se_input_time'].'</td>
					<td class="c">'.$lang['se_input_longer'].'</td>
					<th><a href="#" title="'.$lang['se_input_asc'].'">'.$lang['se_input_a'].' </a> 
					<input type="radio" name="key_acc" value="ASC" '.$z.' title="'.$lang['se_input_asc'].'">&nbsp; 
					<a href="#" title="'.$lang['se_input_desc'].'">'.$lang['se_input_d'].' </a>
					<input type="radio" name="key_acc" value="DESC" '.$y.' title="'.$lang['se_input_desc'].'"></th>
				</tr><tr>
					<th width="15%">'.$lang['se_input_orderby'].'</th>
					<th width="20%"><input type="radio" name="key_order" value="id" '.$a.'></th>
					<th width="20%"><input type="radio" name="key_order" value="who" '.$b.'></th>
					<th width="20%"><input type="radio" name="key_order" value="time" '.$c.'></th>
					<th width="20%"><input type="radio" name="key_order" value="longer" '.$d.'></th>
					<th width="10%"><input type="submit" value="'.$lang['se_input_submit'].'"></th>
				</tr>
				</table>';
				
	$QueryFind	=	$db->fetch_array($db->query("SELECT * FROM ".BANNED.";"));
	$ORDERBY	=	$_POST['key_order'];
	$ORDERBY2	=	$_POST['key_acc'];
	if (!$ORDERBY || !$QueryFind[$ORDERBY])
		$ORDER	=	"id";
	else
		$ORDER	=	$_POST['key_order'];
		
	if ($key_user	==	NULL)
	{
		$search	=	$db->query("SELECT * FROM ".BANNED." ORDER BY `".$ORDER."` ".$ORDERBY2."", "banned");
	}
	else
	{
		$search	=	$db->query("SELECT * FROM ".BANNED." WHERE `who` LIKE '%{$key_user}%' ORDER BY `".$ORDER."` ".$ORDERBY2."", "banned");
	}
	
	$cnt	=	$db->num_rows($search);
	if ($cnt	==	NULL)
	{
		$parse['error']	=	$lang['se_no_data'];
	}
	else
	{
		while ($suspended	=	$db->fetch_array($search))
		{
			$id			=	$suspended['id'];
			$name		=	$suspended['who'];
			$theme		=	$suspended['theme'];
			$time		=	$suspended['time'];
			$longer		=	$suspended['longer'];
			$author		=	$suspended['author'];	
			
			$date		=	date("d/M/y H:i:s", $time);
			$date_limit	=	date("d/M/y H:i:s", $longer);
			
			$parse['table1']	 =
			"<table width=\"90%\">
			<tr><td class=\"c\">".$lang['se_id']."</th><td class=\"c\">".$lang['se_name']."</th><td class=\"c\">".$lang['se_ban_reason']."</th>
			<td class=\"c\">".$lang['se_ban_time']."</th><td class=\"c\">".$lang['se_ban_limit']."</th><td class=\"c\">".$lang['se_ban_author']."</th></tr>";
			
			$parse['table2']	.=
			"<tr><th>".$id."</th><th>".$name."</th><th width=\"25%\"><font color=aqua>".$theme."</font></th><th>".$date."</th>
			<th>".$date_limit."</th><th>".$author."</th></tr>";
			
			$parse['table3']	 =	"<tr><th colspan=\"20\">".$lang['se_input_hay'].$cnt.$lang['se_input_susss']."</th></tr></table>";
		}
	}
	display(parsetemplate(gettemplate('adm/SearchInDBBody'), $parse), false, '', true, false);
	break;
	
	
	// ADMINISTRADORES ####################################################################
	case 'admin':
	$parse['selected_s']	=	'selected = "selected"';
	
	if ($_POST['key_order'] == 'username')
		$b	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'email_2')
		$c	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'authlevel')
		$d	=	'checked = "checked"';
	else 
		$a	=	'checked = "checked"';
		
	if ($_POST['key_acc']	==	'DESC')
		$y	=	'checked = "checked"';
	else
		$z	=	'checked = "checked"';
	
	$parse['orderby']	=	
				'<table width="60%">
				<tr>
					<td class="c">-</td>
					<td class="c">'.$lang['se_input_id'].'</td>
					<td class="c">'.$lang['se_input_name'].'</td>
					<td class="c">'.$lang['se_input_email'].'</td>
					<td class="c">'.$lang['se_input_authlevel'].'</td>
					<th><a href="#" title="'.$lang['se_input_asc'].'">'.$lang['se_input_a'].' </a> 
					<input type="radio" name="key_acc" value="ASC" '.$z.' title="'.$lang['se_input_asc'].'">&nbsp; 
					<a href="#" title="'.$lang['se_input_desc'].'">'.$lang['se_input_d'].' </a>
					<input type="radio" name="key_acc" value="DESC" '.$y.' title="'.$lang['se_input_desc'].'"></th>
				</tr><tr>
					<th width="15%">'.$lang['se_input_orderby'].'</th>
					<th width="20%"><input type="radio" name="key_order" value="id" '.$a.'></th>
					<th width="20%"><input type="radio" name="key_order" value="username" '.$b.'></th>
					<th width="20%"><input type="radio" name="key_order" value="email_2" '.$c.'></th>
					<th width="20%"><input type="radio" name="key_order" value="authlevel" '.$d.'></th>
					<th width="10%"><input type="submit" value="'.$lang['se_input_submit'].'"></th>
				</tr>
				</table>';
			
	$QueryFind	=	$db->fetch_array($db->query("SELECT * FROM ".USERS.";"));
	$ORDERBY	=	$_POST['key_order'];
	$ORDERBY2	=	$_POST['key_acc'];
	if (!$ORDERBY || !$QueryFind[$ORDERBY])
		$ORDER	=	"id";
	else
		$ORDER	=	$_POST['key_order'];
		
	if ($key_user	==	NULL)
	{
		$search	=	$db->query("SELECT * FROM ".USERS." WHERE `authlevel` > '0' ORDER BY `".$ORDER."` ".$ORDERBY2.";");
	}
	else
	{
		$search	=	$db->query("SELECT * FROM ".USERS." WHERE `username` LIKE '%{$key_user}%' AND `authlevel` > '0'  ORDER BY `".$ORDER."` ".$ORDERBY2.";");
	}
	
	$cnt	=	$db->num_rows($search);
	if ($cnt	==	NULL)
	{
		$parse['error']	=	$lang['se_no_data'];
	}
	else
	{
		while ($admin	=	$db->fetch_array($search))
		{
			$id			=	$admin['id'];
			$name		=	$admin['username'];
			$email		=	$admin['email_2'];
			$authlevel	=	$admin['authlevel'];
			$suspended	=	$admin['bana'];
			$vacations	=	$admin['urlaubs_modus'];
		
			if ($suspended == '0' or $suspended == NULL){$suspended = $lang['se_no'];}else{$suspended = "<font color=lime>".$lang['se_yes']."</font>";}
			if ($vacations == '0'){$vacations = $lang['se_no'];}else{$vacations = "<font color=aqua>".$lang['se_yes']."</font>";}
			for ($i = 0; $i < 5; $i++)
			{
				if ($authlevel == $i){$authlevel = $lang['se_authlevel'][$i];}
			}
		
			
			$parse['table1']	 =
			"<table width=\"75%\">
			<tr><td class=\"c\">".$lang['se_id']."</th><td class=\"c\">".$lang['se_name']."</th><td class=\"c\">".$lang['se_email']."</th>
			<td class=\"c\">".$lang['se_auth']."</th><td class=\"c\">".$lang['se_ban']."</th><td class=\"c\">".$lang['se_vacat']."</th></tr>";
			
			$parse['table2']	.=
			"<tr><th>".$id."</th><th>".$name."</th><th>".$email."</th><th>".$authlevel."</th><th>".$suspended."</th><th>".$vacations."</th></tr>";
			
			$parse['table3']	 =	"<tr><th colspan=\"20\">".$lang['se_input_hay'].$cnt.$lang['se_input_admm']."</th></tr></table>";
		}
	}
	display(parsetemplate(gettemplate('adm/SearchInDBBody'), $parse), false, '', true, false);
	break;
	
	
	// INACTIVOS ####################################################################
	case 'inactives':
	$parse['selected_i']	=	'selected = "selected"';
	$Time	=	time() - 604800;
	
	
	if ($_POST['key_order'] == 'username')
		$b	=	'checked = "checked"';
	elseif ($_POST['key_order'] == 'onlinetime')
		$c	=	'checked = "checked"';
	else 
		$a	=	'checked = "checked"';
		
	if ($_POST['key_acc']	==	'DESC')
		$y	=	'checked = "checked"';
	else
		$z	=	'checked = "checked"';
	
	$parse['orderby']	=	
				'<table width="60%">
				<tr>
					<td class="c">-</td>
					<td class="c">'.$lang['se_input_id'].'</td>
					<td class="c">'.$lang['se_input_name'].'</td>
					<td class="c">'.$lang['se_input_inacti'].'</td>
					<th><a href="#" title="'.$lang['se_input_asc'].'">'.$lang['se_input_a'].' </a> 
					<input type="radio" name="key_acc" value="ASC" '.$z.' title="'.$lang['se_input_asc'].'">&nbsp; 
					<a href="#" title="'.$lang['se_input_desc'].'">'.$lang['se_input_d'].' </a>
					<input type="radio" name="key_acc" value="DESC" '.$y.' title="'.$lang['se_input_desc'].'"></th>
				</tr><tr>
					<th width="15%">'.$lang['se_input_orderby'].'</th>
					<th width="20%"><input type="radio" name="key_order" value="id" '.$a.'></th>
					<th width="20%"><input type="radio" name="key_order" value="username" '.$b.'></th>
					<th width="20%"><input type="radio" name="key_order" value="onlinetime" '.$c.'></th>
					<th width="10%"><input type="submit" value="'.$lang['se_input_submit'].'"></th>
				</tr>
				</table>';
	
	$QueryFind	=	$db->fetch_array($db->query("SELECT * FROM ".USERS.";"));
	$ORDERBY	=	$_POST['key_order'];
	$ORDERBY2	=	$_POST['key_acc'];
	if (!$ORDERBY || !$QueryFind[$ORDERBY])
		$ORDER	=	"id";
	else
		$ORDER	=	$_POST['key_order'];
			
	if ($key_user	==	NULL)
	{
		$search	=	$db->query("SELECT * FROM ".USERS." WHERE `onlinetime` < '".$Time."' ORDER BY `".$ORDER."` ".$ORDERBY2.";");
	}
	else
	{
		$search	=	$db->query("SELECT * FROM ".USERS." WHERE `username` LIKE '%{$key_user}%' AND `onlinetime` < '".$Time."' ORDER BY `".$ORDER."` ".$ORDERBY2.";");
	}
	
	$cnt	=	$db->num_rows($search);
	if ($cnt	==	NULL)
	{
		$parse['error']	=	$lang['se_no_data'];
	}
	else
	{
		while ($inactives	=	$db->fetch_array($search))
		{
			$id			=	$inactives['id'];
			$name		=	$inactives['username'];
			$authlevel	=	$inactives['authlevel'];
			$inactive	=	$inactives['onlinetime'];
			$vacations	=	$inactives['urlaubs_modus'];
			$suspended	=	$inactives['bana'];
		
			if ($suspended == '0' or $suspended == NULL){$suspended = $lang['se_no'];}else{$suspended = "<font color=lime>".$lang['se_yes']."</font>";}
			if ($vacations == '0'){$vacations = $lang['se_no'];}else{$vacations = "<font color=aqua>".$lang['se_yes']."</font>";}
			for ($i = 0; $i < 5; $i++)
			{
				if ($authlevel == $i){$authlevel = $lang['se_authlevel'][$i];}
			}
		
			
			$inactives	=	date("d/M/y H:i:s", $inactive);
			$parse['table1']	 =
			"<table width=\"65%\">
			<tr><td class=\"c\">".$lang['se_id']."</td><td class=\"c\">".$lang['se_name']."</td>
			<td class=\"c\">".$lang['se_auth']."</td><td class=\"c\">".$lang['se_activity']."</td><td class=\"c\">".$lang['se_vacat']."</td>
			<td class=\"c\">".$lang['se_ban']."</td></tr>";
			
			$parse['table2']	.=
			"<tr><th>".$id."</th><th>".$name."</th><th>".$authlevel."</th><th>".$inactives."</th><th>".$vacations."</th><th>".$suspended."</th></tr>";
			
			$parse['table3']	 =	"<tr><th colspan=\"20\">".$lang['se_input_hay'].$cnt.$lang['se_input_inact']."</th></tr></table>";
			
		}
		
	}
	display(parsetemplate(gettemplate('adm/SearchInDBBody'), $parse), false, '', true, false);
	break;

	default:
	display(parsetemplate(gettemplate('adm/SearchInDBBody'), $parse), false, '', true, false);
}
?>