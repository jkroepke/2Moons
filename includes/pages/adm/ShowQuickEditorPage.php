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

if ($USER['rights'][str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__)] != 1) exit;

function ShowQuickEditorPage()
{
	global $LNG, $db, $reslist, $resource;
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
			$PlanetData	= $db->uniquequery("SELECT ".$SpecifyItemsPQ." `name`, `id_owner`, `planet_type`, `galaxy`, `system`, `planet`, `destruyed`, `diameter`, `field_current`, `field_current`, `field_max`, `temp_min`, `temp_max`, `metal`, `crystal`, `deuterium` FROM ".PLANETS." WHERE `id` = '".$id."';");
			
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
				$QryUpdateString	.= "WHERE `id` = '".$id."' AND `universe` = '".$_SESSION['adminuni']."';";
				$db->query($QryUpdateString);
				exit(sprintf($LNG['qe_edit_sucess'] , $PlanetData['name'], $PlanetData['galaxy'], $PlanetData['system'], $PlanetData['planet']));
			}
			$UserInfo				= $db->uniquequery("SELECT `username` FROM ".USERS." WHERE `id` = '".$PlanetData['id_owner']."' AND `universe` = '".$_SESSION['adminuni']."';");

			$build = $defense = $fleet	= array();
			
			foreach($reslist['build'] as $ID)
			{
				$build[]	= array(
					'type'	=> $resource[$ID],
					'name'	=> $LNG['tech'][$ID],
					'count'	=> pretty_number($PlanetData[$resource[$ID]]),
					'input'	=> $PlanetData[$resource[$ID]]
				);
			}
			
			foreach($reslist['fleet'] as $ID)
			{
				$fleet[]	= array(
					'type'	=> $resource[$ID],
					'name'	=> $LNG['tech'][$ID],
					'count'	=> pretty_number($PlanetData[$resource[$ID]]),
					'input'	=> $PlanetData[$resource[$ID]]
				);
			}
			
			foreach($reslist['defense'] as $ID)
			{
				$defense[]	= array(
					'type'	=> $resource[$ID],
					'name'	=> $LNG['tech'][$ID],
					'count'	=> pretty_number($PlanetData[$resource[$ID]]),
					'input'	=> $PlanetData[$resource[$ID]]
				);
			}

			$template	= new template();
			$template->page_header();
			$template->assign_vars(array(	
				'qe_resources'	=> $LNG['qe_resources'],
				'Metal'			=> $LNG['Metal'],
				'Crystal'		=> $LNG['Crystal'],
				'Deuterium'		=> $LNG['Deuterium'],
				'qe_defensive'	=> $LNG['qe_defensive'],
				'qe_fleet'		=> $LNG['qe_fleet'],
				'qe_build'		=> $LNG['qe_build'],
				'qe_input'		=> $LNG['qe_input'],
				'qe_count'		=> $LNG['qe_count'],
				'qe_name'		=> $LNG['qe_name'],
				'qe_reset'		=> $LNG['qe_reset'],
				'qe_send'		=> $LNG['qe_send'],
				'qe_temp'		=> $LNG['qe_temp'],
				'qe_fields'		=> $LNG['qe_fields'],
				'qe_owner'		=> $LNG['qe_owner'],
				'qe_coords'		=> $LNG['qe_coords'],
				'qe_id'			=> $LNG['qe_id'],
				'qe_info'		=> $LNG['qe_info'],
				'build'			=> $build,
				'fleet'			=> $fleet,
				'defense'		=> $defense,
				'id'			=> $id,
				'ownerid'		=> $PlanetData['id_owner'],
				'ownername'		=> $UserInfo['username'],
				'name'			=> $PlanetData['name'],
				'galaxy'		=> $PlanetData['galaxy'],
				'system'		=> $PlanetData['system'],
				'planet'		=> $PlanetData['planet'],
				'field_min'		=> $PlanetData['field_current'],
				'field_max'		=> $PlanetData['field_max'],
				'temp_min'		=> $PlanetData['temp_min'],
				'temp_max'		=> $PlanetData['temp_max'],
				'metal'			=> floattostring($PlanetData['metal']),
				'crystal'		=> floattostring($PlanetData['crystal']),
				'deuterium'		=> floattostring($PlanetData['deuterium']),
				'metal_c'		=> pretty_number($PlanetData['metal']),
				'crystal_c'		=> pretty_number($PlanetData['crystal']),
				'deuterium_c'	=> pretty_number($PlanetData['deuterium']),
				));
	
	$template->show('adm/QuickEditorPlanet.tpl');
		break;
		case 'player':
		break;
	}
}
?>