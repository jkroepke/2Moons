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

require_once(ROOT_PATH . 'includes/functions/SetNextQueueElementOnTop.' . PHP_EXT);
require_once(ROOT_PATH . 'includes/functions/CheckPlanetBuildingQueue.' . PHP_EXT);

function UpdatePlanetBatimentQueueList(&$CurrentPlanet, &$CurrentUser) 
{
	$return	= array();
	$RetValue	= false;
	while(!$RetValue)
	{	
		$Ready	= CheckPlanetBuildingQueue($CurrentPlanet, $CurrentUser);
		if ($Ready['isDone'])
		{
			$return[$Ready['Element']]	+=  $Ready['Count'];
			SetNextQueueElementOnTop($CurrentPlanet, $CurrentUser);
		} else {
			$RetValue	= true;
		}
	}
	return $return;
}

?>