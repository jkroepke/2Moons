<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
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

if(!defined('INSIDE')){ die(header("location:../../"));}

	function SetNewBuildTimes(&$CurrentPlanet)
	{
		return true;
	}

	function CheckPlanetBuildingQueue(&$CurrentPlanet, &$CurrentUser)
	{
		global $resource, $db;
		$RetValue     = false;
		$IfSelectedPlanet	= $CurrentUser['current_planet'] == $CurrentPlanet['id'] ? true : false;
		if (!empty($CurrentPlanet['b_building_id']))
		{
			$CurrentQueue  	= $CurrentPlanet['b_building_id'];
			$QueueArray    	= explode(";", $CurrentPlanet['b_building_id']);
			$ActualCount   	= count($QueueArray);

			$BuildArray   	= explode (",", $QueueArray[0]);
			$Element      	= $BuildArray[0];
			$Level      	= $BuildArray[1];
			$BuildEndTime 	= $BuildArray[3];
			$BuildMode    	= $BuildArray[4];
			
			if ($BuildEndTime <= time())
			{
				$ForDestroy = ($BuildMode == 'destroy') ? true : false;
				$CFields		= $CurrentPlanet['field_current'];
				$MFields     	= $CurrentPlanet['field_max'];
					
				PlanetResourceUpdate($CurrentUser, $CurrentPlanet, $CurrentPlanet['b_building'], true);
				if ($Element == 41)
				{
					$CurrentPlanet['field_max']	+= FIELDS_BY_MOONBASIS_LEVEL;
					$CurrentPlanet[$resource[$Element]]++;
				}
				
				if ($ForDestroy == false)
				{
					$CurrentPlanet['field_current']++;
					$CurrentPlanet[$resource[$Element]]++;
				}
				else
				{
					$CurrentPlanet['field_current']--;
					$CurrentPlanet[$resource[$Element]]--;
				}
				array_shift($QueueArray);
				if (count($QueueArray) == 0)
					$NewQueue = 0;
				else
					$NewQueue = implode (";", $QueueArray );

				$CurrentPlanet['b_building']    = 0;
				$CurrentPlanet['b_building_id'] = $NewQueue;
									
				$Build	= $Element;

				$RetValue = true;
				if(!$IfSelectedPlanet)
				{
                    $QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
                    $QryUpdatePlanet .= "`".$resource[$Element]."` = '".$CurrentPlanet[$resource[$Element]]."', ";
                    $QryUpdatePlanet .= "`b_building` = '". $CurrentPlanet['b_building'] ."' , ";
                    $QryUpdatePlanet .= "`b_building_id` = '". $CurrentPlanet['b_building_id'] ."' , ";
                    $QryUpdatePlanet .= "`field_current` = '" . $CurrentPlanet['field_current'] . "', ";
                    $QryUpdatePlanet .= "`field_max` = '" . $CurrentPlanet['field_max'] . "' ";
                    $QryUpdatePlanet .= "WHERE ";
                    $QryUpdatePlanet .= "`id` = '" . $CurrentPlanet['id'] . "';";
                    $db->query($QryUpdatePlanet);
				}
			}
			else
				$RetValue = false;
		}
		else
		{
			$CurrentPlanet['b_building']    = 0;
			$CurrentPlanet['b_building_id'] = 0;
			if(!$IfSelectedPlanet)
			{
                $QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
                $QryUpdatePlanet .= "`b_building` = '". $CurrentPlanet['b_building'] ."' , ";
                $QryUpdatePlanet .= "`b_building_id` = '". $CurrentPlanet['b_building_id'] ."' ";
                $QryUpdatePlanet .= "WHERE ";
                $QryUpdatePlanet .= "`id` = '" . $CurrentPlanet['id'] . "';";
                $db->query($QryUpdatePlanet);
			}
			$RetValue = false;
		}
		return array('isDone' => $RetValue, 'Element' => $Build);
	}
?>