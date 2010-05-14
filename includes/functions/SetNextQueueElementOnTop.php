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

		if (!empty($CurrentPlanet['b_building_id']))
		{
			$QueueArray 	= explode ( ";", $CurrentPlanet['b_building_id']);
			$Loop       	= true;
			$BuildEndTime	= time();
			while ($Loop == true)
			{
			
				$ListIDArray         = explode ( ",", $QueueArray[0]);
				$Element             = $ListIDArray[0];
				$Level               = $ListIDArray[1];
				$BuildTime  	     = $ListIDArray[2];
				$BuildEndTime        = $ListIDArray[3];
				$BuildMode           = $ListIDArray[4];
				$ForDestroy 		 = ($BuildMode == 'destroy') ? true : false;

				$HaveNoMoreLevel     = false;
								
				$HaveRessources 	 = IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, $ForDestroy);
				
				if($ForDestroy && $CurrentPlanet[$resource[$Element]] == 0) {
					$HaveRessources  = false;
					$HaveNoMoreLevel = true;
				}

				if($HaveRessources == true) {
					$Needed                        = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, true, $ForDestroy);
					$CurrentPlanet['metal']       -= $Needed['metal'];
					$CurrentPlanet['crystal']     -= $Needed['crystal'];
					$CurrentPlanet['deuterium']   -= $Needed['deuterium'];
					$CurrentUser['darkmatter']    -= $Needed['darkmatter'];					
					$NewQueue                      = implode( ";", $QueueArray);
					$Loop                          = false;
				} else {
					if($CurrentUser['hof'] == 1) {
						if ($HaveNoMoreLevel == true)
							$Message     = sprintf ($lang['sys_nomore_level'], $lang['tech'][$Element]);
						else
						{
							$Needed      = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, true, $ForDestroy);
							$Message     = sprintf ($lang['sys_notenough_money'], $CurrentPlanet['name'], $CurrentPlanet['id'], $CurrentPlanet['galaxy'], $CurrentPlanet['system'], $CurrentPlanet['planet'], $lang['tech'][$Element], pretty_number ($CurrentPlanet['metal']), $lang['Metal'], pretty_number ($CurrentPlanet['crystal']), $lang['Crystal'], pretty_number ($CurrentPlanet['deuterium']), $lang['Deuterium'], pretty_number ($Needed['metal']), $lang['Metal'], pretty_number ($Needed['crystal']), $lang['Crystal'], pretty_number ($Needed['deuterium']), $lang['Deuterium']);
						}
						SendSimpleMessage($CurrentUser['id'], '', '', 99, $lang['sys_buildlist'], $lang['sys_buildlist_fail'], $Message);
					}

					array_shift($QueueArray);
					
						
					if (count($QueueArray) == 0) {
						$BuildEndTime  = 0;
						$NewQueue      = '';
						$Loop          = false;
					} else {
						$BaseTime			= $BuildEndTime - $BuildTime;
						foreach($QueueArray as $ID => $QueueInfo)
						{
							$ListIDArray        = explode(",", $QueueInfo);
							$BaseTime			+= $ListIDArray[2];
							$ListIDArray[3]		= $BaseTime;
							$QueueArray[$ID]	= implode(",", $ListIDArray);
						}
					}
				}
			}
		}
		else
		{
			$BuildEndTime  = 0;
			$NewQueue      = '';
		}
			
		$CurrentPlanet['b_building']    = $BuildEndTime;
		$CurrentPlanet['b_building_id'] = $NewQueue;
	}
?>