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


if ($EditUsers != 1) die(message ($LNG['404_page']));

$parse	= $LNG;

$action	= request_var('action', '');
$edit	= request_var('edit', '');
$id 	= request_var('id', 0);

switch($edit)
{
	case 'planet':
		$DataIDs	= array_merge($reslist['fleet'], $reslist['build'], $reslist['defense']);
		foreach($DataIDs as $ID)
		{
			$SpecifyItemsPQ	.= "`".$resource[$ID]."`,";
		}
		$PlanetData	= $db->fetch_array($db->query("SELECT ".$SpecifyItemsPQ." `name`, `id_owner`, `planet_type`, `galaxy`, `system`, `planet`, `destruyed`, `diameter`, `field_current`, `field_current`, `field_max`, `temp_min`, `temp_max`, `metal`, `crystal`, `deuterium` FROM ".PLANETS." WHERE `id` = '".$id."';"));
		
		$reslist['build']	= $reslist['allow'][$PlanetData['planet_type']];
		
		if($action == 'send'){
			$QryUpdateString	= "UPDATE ".PLANETS." SET ";
			foreach($DataIDs as $ID)
			{
				$QryUpdateString	.= "`".$resource[$ID]."` = '".floattostring(round(abs(request_var($resource[$ID], 0.0)), 0))."', ";
			}
			$QryUpdateString	.= "`metal` = '".floattostring(round(abs(request_var('metal', 0.0)), 0))."', ";
			$QryUpdateString	.= "`crystal` = '".floattostring(round(abs(request_var('crystal', 0.0)), 0))."', ";
			$QryUpdateString	.= "`deuterium` = '".floattostring(round(abs(request_var('deuterium', 0.0)), 0))."', ";
			$QryUpdateString	.= "`field_max` = '".request_var('field_max', 0)."', ";
			$QryUpdateString	.= "`name` = '".$db->sql_escape(request_var('name', ''))."' ";
			$QryUpdateString	.= "WHERE `id` = '".$id."' LIMIT 1;";
			$db->query($QryUpdateString);
			exit(sprintf($LNG['qe_edit_sucess'] , $PlanetData['name'], $PlanetData['galaxy'], $PlanetData['system'], $PlanetData['planet']));
		}
		$UserInfo				= $db->fetch_array($db->query("SELECT `username` FROM ".USERS." WHERE `id` = '".$PlanetData['id_owner']."'"));
		$parse['id']			= $id;
		$parse['ownerid']		= $PlanetData['id_owner'];
		$parse['ownername']		= $UserInfo['username'];
		$parse['name']			= $PlanetData['name'];
		$parse['galaxy']		= $PlanetData['galaxy'];
		$parse['system']		= $PlanetData['system'];
		$parse['planet']		= $PlanetData['planet'];
		$parse['field_min']		= $PlanetData['field_current'];
		$parse['field_max']		= $PlanetData['field_max'];
		$parse['temp_min']		= $PlanetData['temp_min'];
		$parse['temp_max']		= $PlanetData['temp_max'];
		$parse['metal']			= floattostring($PlanetData['metal']);
		$parse['crystal']		= floattostring($PlanetData['crystal']);
		$parse['deuterium']		= floattostring($PlanetData['deuterium']);
		$parse['metal_c']		= pretty_number($PlanetData['metal']);
		$parse['crystal_c']		= pretty_number($PlanetData['crystal']);
		$parse['deuterium_c']	= pretty_number($PlanetData['deuterium']);
		$parse['build']			= "";
		$parse['defense']		= "";
		$parse['fleet']			= "";
		foreach($reslist['build'] as $ID)
		{
			$parse['build']		.=	"<tr><th width=\"30%\">".$LNG['tech'][$ID].":</th><th width=\"30%\">".pretty_number($PlanetData[$resource[$ID]])."</th><th width=\"40%\"><input name=\"".$resource[$ID]."\" type=\"text\" value=\"".$PlanetData[$resource[$ID]]."\"></th>";
		}
		
		foreach($reslist['fleet'] as $ID)
		{
			$parse['fleet']		.=	"<tr><th width=\"30%\">".$LNG['tech'][$ID].":</th><th width=\"30%\">".pretty_number($PlanetData[$resource[$ID]])."</th><th width=\"40%\"><input name=\"".$resource[$ID]."\" type=\"text\" value=\"".$PlanetData[$resource[$ID]]."\"></th>";
		}
		
		foreach($reslist['defense'] as $ID)
		{
			$parse['defense']	.=	"<tr><th width=\"30%\">".$LNG['tech'][$ID].":</th><th width=\"30%\">".pretty_number($PlanetData[$resource[$ID]])."</th><th width=\"40%\"><input name=\"".$resource[$ID]."\" type=\"text\" value=\"".$PlanetData[$resource[$ID]]."\"></th>";
		}
		display(parsetemplate(gettemplate('adm/QuickEditPlanet'), $parse), false, '', true, false);
	break;
	case 'player':
	break;
}
?>