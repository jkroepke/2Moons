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

	function CheckPlanetBuildingQueue(&$CurrentPlanet, &$CurrentUser)
	{
		global $resource, $db;
		$RetValue     = false;
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
				if ($ForDestroy == false)
				{
					$CurrentPlanet['field_current']++;
					$CurrentPlanet[$resource[$Element]]++;
					$Count = 1;
				}
				else
				{
					$CurrentPlanet['field_current']--;
					$CurrentPlanet[$resource[$Element]]--;
					$Count = -1;
				}
				
				PlanetResourceUpdate($CurrentUser, $CurrentPlanet, $BuildEndTime, true);				
				array_shift($QueueArray);
				if (count($QueueArray) == 0) {
					$CurrentPlanet['b_building']    = 0;
					$CurrentPlanet['b_building_id'] = '';
				} else {
					$BuildArray   					= explode (",", $QueueArray[0]);
					$CurrentPlanet['b_building']    = $BuildArray[3];
					$CurrentPlanet['b_building_id'] = implode(";", $QueueArray);
				}
				$RetValue = true;
			}
			else
				$RetValue = false;
		}
		else
		{
			$CurrentPlanet['b_building']    = 0;
			$CurrentPlanet['b_building_id'] = '';
			$RetValue = $Element = $Count = false;
		}
		return array('isDone' => $RetValue, 'Element' => $Element, 'Count' => $Count);
	}
?>