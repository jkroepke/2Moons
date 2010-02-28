<?php

##############################################################################
# *																			 #
# * RN FRAMEWORK															 #
# *  																		 #
# * @copyright Copyright (C) 2009 By ShadoX from xnova-reloaded.de	    	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.' . PHP_EXT);
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($EditUsers != 1) die();

$parse	=	$lang;
     
	  
$mode      = $_POST['mode'];

if ($mode == 'agregar') 
{
   	$id            = $_POST['id'];
    $galaxy        = $_POST['galaxy'];
    $system        = $_POST['system'];
    $planet        = $_POST['planet'];
        
	$i	=	0;
	$QueryS	=	$db->fetch_array($db->query("SELECT id FROM ".PLANETS." WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."';"));
	$QueryS2	=	$db->fetch_array($db->query("SELECT id FROM ".USERS." WHERE `id` = '".$id."';"));
	if (is_numeric($_POST['id']) && isset($_POST['id']) && !$QueryS && $QueryS2)
	{
    	if ($galaxy < 1 or $system < 1 or $planet < 1 or !is_numeric($galaxy) or !is_numeric($system) or !is_numeric($planet)){      
    		$Error	.=	'<tr><th colspan="2"><font color=red>'.$lang['po_complete_all'].'</font></th></tr>';
			$i++;}
	
		if ($galaxy > MAX_GALAXY_IN_WORLD or $system > MAX_SYSTEM_IN_GALAXY or $planet > MAX_PLANET_IN_SYSTEM){
			$Error	.=	'<tr><th colspan="2"><font color=red>'.$lang['po_complete_all2'].'</font></th></tr>';
			$i++;}
	
		if ($i	==	0)
		{
			CreateOnePlanetRecord ($galaxy, $system, $planet, $id, '', '', false) ; 
			$QueryS3	= $db->fetch_array($db->query("SELECT id_level FROM ".PLANETS." WHERE `id_owner` = '".$id."';"));
			$db->query("UPDATE ".PLANETS." SET `id_level` = '".$QueryS3['id_level']."' WHERE 
			`galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."' AND `planet_type` = '1';");
    		$parse['display']	=	'<tr><th colspan="2"><font color=lime>'.$lang['po_complete_succes'].'</font></th></tr>';
		}
		else
		{
			$parse['display']	=	$Error;
		}
	}
	else
	{
		$parse['display']	=	'<tr><th colspan="2"><font color=red>'.$lang['po_complete_all'].'</font></th></tr>';
	}
}
elseif ($mode == 'borrar') 
{
	$id	=	$_POST['id'];
	if (is_numeric($id) && isset($id))
	{
		$QueryS	=	$db->fetch_array($db->query("SELECT galaxy, system, planet, planet_type, id_luna FROM ".PLANETS." WHERE `id` = '".$id."';"));
		
		if ($QueryS)
		{
			if ($QueryS['planet_type'] == '1')
			{
				if ($QueryS['id_luna'] > 0)
				{
					$db->query("DELETE FROM ".PLANETS." WHERE `galaxy` = '".$QueryS['galaxy']."' AND `system` = '".$QueryS['system']."' AND 
						`planet` = '".$QueryS['planet']."' AND `planet_type` = '3';");
				}
				$db->query("DELETE FROM ".PLANETS." WHERE `id` = '".$id."';");
				$Error	.=	'<tr><th colspan="2"><font color=lime>'.$lang['po_complete_succes2'].'</font></th></tr>';
			}
			else
			{
				$Error	.=	'<tr><th colspan="2"><font color=red>'.$lang['po_complete_invalid3'].'</font></th></tr>';
			}
		}
		else
		{
			$Error	.=	'<tr><th colspan="2"><font color=red>'.$lang['po_complete_invalid2'].'</font></th></tr>';
		}
	}
	else
	{
		$Error	.=	'<tr><th colspan="2"><font color=red>'.$lang['po_complete_invalid'].'</font></th></tr>';
	}
	
	$parse['display2']	=	$Error;
}
        

display (parsetemplate(gettemplate('adm/PlanetOptionsBody'),  $parse), false, '', true, false);
?>