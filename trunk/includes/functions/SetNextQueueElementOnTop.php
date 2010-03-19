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

	function SetNextQueueElementOnTop ( &$CurrentPlanet, &$CurrentUser )
	{
		global $lang, $resource, $db;

		if ($CurrentPlanet['b_building'] == 0)
		{
			$CurrentQueue  = $CurrentPlanet['b_building_id'];
			if (!empty($CurrentQueue))
			{
				$QueueArray 	= explode ( ";", $CurrentQueue );
				$Loop       	= true;
				$BuildEndTime	= time();
				while ($Loop == true)
				{
					$ListIDArray         = explode ( ",", $QueueArray[0]);
					$Element             = $ListIDArray[0];
					$Level               = $ListIDArray[1];
					$BuildMode           = $ListIDArray[4];
					
					if ($BuildMode == 'destroy')
						$ForDestroy = true;
					else
						$ForDestroy = false;

					$BuildTime           = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element, $Destroy = false);
					$BuildEndTime        = $BuildEndTime + $BuildTime;
					$HaveNoMoreLevel     = false;

					$HaveRessources = IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, $ForDestroy);
					if($ForDestroy && $CurrentPlanet[$resource[$Element]] == 0)
					{
						$HaveRessources  = false;
						$HaveNoMoreLevel = true;
					}

					if($HaveRessources == true)
					{
						$Needed                        = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, true, $ForDestroy);
						$CurrentPlanet['metal']       -= $Needed['metal'];
						$CurrentPlanet['crystal']     -= $Needed['crystal'];
						$CurrentPlanet['deuterium']   -= $Needed['deuterium'];
						$CurrentUser['darkmatter']    -= $Needed['darkmatter'];
						$NewQueue                      = implode( ";", $QueueArray);

						if (empty($NewQueue))
							$NewQueue                  = '0';

						$Loop                          = false;
					}
					else
					{
						$ElementName = $lang['tech'][$Element];

						if($CurrentUser['hof'] == 1)
						{
							if ($HaveNoMoreLevel == true)
								$Message     = sprintf ($lang['sys_nomore_level'], $ElementName );
							else
							{
								$Needed      = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, true, $ForDestroy);
								$Message     = sprintf ($lang['sys_notenough_money'], $CurrentPlanet['name'], $CurrentPlanet['id'], $CurrentPlanet['galaxy'], $CurrentPlanet['system'], $CurrentPlanet['planet'], $ElementName, pretty_number ($CurrentPlanet['metal']), $lang['Metal'], pretty_number ($CurrentPlanet['crystal']), $lang['Crystal'], pretty_number ($CurrentPlanet['deuterium']), $lang['Deuterium'], pretty_number ($Needed['metal']), $lang['Metal'], pretty_number ($Needed['crystal']), $lang['Crystal'], pretty_number ($Needed['deuterium']), $lang['Deuterium']);
							}
							
							SendSimpleMessage($CurrentUser['id'], '', '', 99, $lang['sys_buildlist'], $lang['sys_buildlist_fail'], $Message);
						}
						
						array_shift($QueueArray);
						if (count($QueueArray) == 0)
						{
							$BuildEndTime  = 0;
							$NewQueue      = 0;
							$Loop          = false;
						}
					}
				}
			}
			else
			{
				$BuildEndTime  = 0;
				$NewQueue      = 0;
			}

			$CurrentPlanet['b_building']    = $BuildEndTime;
			$CurrentPlanet['b_building_id'] = $NewQueue;

			$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
			$QryUpdatePlanet .= "`metal` = '".         $CurrentPlanet['metal']         ."' , ";
			$QryUpdatePlanet .= "`crystal` = '".       $CurrentPlanet['crystal']       ."' , ";
			$QryUpdatePlanet .= "`deuterium` = '".     $CurrentPlanet['deuterium']     ."' , ";
			$QryUpdatePlanet .= "`b_building` = '".    $CurrentPlanet['b_building']    ."' , ";
			$QryUpdatePlanet .= "`b_building_id` = '". $CurrentPlanet['b_building_id'] ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '" .           $CurrentPlanet['id']            . "';";
			$QryUpdatePlanet .= "UPDATE ".USERS." SET ";
			$QryUpdatePlanet .= "`darkmatter` = '".	   $CurrentUser['darkmatter']      ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '".            $CurrentUser['id']              ."';";
			$db->multi_query($QryUpdatePlanet);

		}
		return;
	}
?>