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

if(!defined('INSIDE')) die('Hacking attempt!');

	function IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element)
	{
		global $requeriments, $resource, $reslist;
		
		if(!isset($requeriments[$Element]))
			return true;		

		foreach($requeriments[$Element] as $ReqElement => $EleLevel)
		{
			if ((isset($CurrentPlanet[$resource[$ReqElement]]) && $CurrentPlanet[$resource[$ReqElement]] < $EleLevel) || (isset($CurrentUser[$resource[$ReqElement]]) && $CurrentUser[$resource[$ReqElement]] < $EleLevel))
				return false;
		}
		return true;
	}
?>