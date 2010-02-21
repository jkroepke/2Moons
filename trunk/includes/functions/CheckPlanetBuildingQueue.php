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

	function CheckPlanetBuildingQueue ( &$CurrentPlanet, &$CurrentUser )
	{
		global $resource, $db;

		$RetValue     = false;
		if ($CurrentPlanet['b_building_id'] != 0)
		{
			$CurrentQueue  = $CurrentPlanet['b_building_id'];
			if ($CurrentQueue != 0)
			{
				$QueueArray    = explode ( ";", $CurrentQueue );
				$ActualCount   = count ( $QueueArray );
			}

			$BuildArray   = explode (",", $QueueArray[0]);
			$BuildEndTime = floor($BuildArray[3]);
			$BuildMode    = $BuildArray[4];
			$Element      = $BuildArray[0];
			array_shift ( $QueueArray );
			
			if ($BuildMode == 'destroy')
				$ForDestroy = true;
			else
				$ForDestroy = false;
			var_dump($BuildMode, $ForDestroy);
			if ($BuildEndTime <= time())
			{
				$current = intval($CurrentPlanet['field_current']);
				$max     = intval($CurrentPlanet['field_max']);

				if ($CurrentPlanet['planet_type'] == 3)
				{
					if ($Element == 41)
					{
						$current += 1;
						$max     += FIELDS_BY_MOONBASIS_LEVEL;
						$CurrentPlanet[$resource[$Element]]++;
					}
					elseif ($Element != 0)
					{
						if ($ForDestroy == false)
						{
							$current += 1;
							$CurrentPlanet[$resource[$Element]]++;
						}
						else
						{
							$current -= 1;
							$CurrentPlanet[$resource[$Element]]--;
						}
					}
				}
				elseif ($CurrentPlanet['planet_type'] == 1)
				{
					if ($ForDestroy == false)
					{
						$current += 1;
						$CurrentPlanet[$resource[$Element]]++;
					}
					else
					{
						$current -= 1;
						$CurrentPlanet[$resource[$Element]]--;
					}
				}
				if (count ( $QueueArray ) == 0)
					$NewQueue = 0;
				else
					$NewQueue = implode (";", $QueueArray );

				$CurrentPlanet['b_building']    = 0;
				$CurrentPlanet['b_building_id'] = $NewQueue;
				$CurrentPlanet['field_current'] = $current;
				$CurrentPlanet['field_max']     = $max;

				$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
				$QryUpdatePlanet .= "`".$resource[$Element]."` = '".$CurrentPlanet[$resource[$Element]]."', ";
				$QryUpdatePlanet .= "`b_building` = '". $CurrentPlanet['b_building'] ."' , ";
				$QryUpdatePlanet .= "`b_building_id` = '". $CurrentPlanet['b_building_id'] ."' , ";
				$QryUpdatePlanet .= "`field_current` = '" . $CurrentPlanet['field_current'] . "', ";
				$QryUpdatePlanet .= "`field_max` = '" . $CurrentPlanet['field_max'] . "' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '" . $CurrentPlanet['id'] . "';";
				$db->query($QryUpdatePlanet);

				$RetValue = true;
			}
			else
				$RetValue = false;
		}
		else
		{
			$CurrentPlanet['b_building']    = 0;
			$CurrentPlanet['b_building_id'] = 0;

			$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
			$QryUpdatePlanet .= "`b_building` = '". $CurrentPlanet['b_building'] ."' , ";
			$QryUpdatePlanet .= "`b_building_id` = '". $CurrentPlanet['b_building_id'] ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '" . $CurrentPlanet['id'] . "';";
			$db->query($QryUpdatePlanets);

			$RetValue = false;
		}
		return $RetValue;
	}
?>