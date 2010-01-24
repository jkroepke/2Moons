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

	function GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, $Incremental = true, $ForDestroy = false)
	{
		global $pricelist, $resource;

		if ($Incremental)
			$level = ($CurrentPlanet[$resource[$Element]]) ? $CurrentPlanet[$resource[$Element]] : $CurrentUser[$resource[$Element]];

		$array = array('metal', 'crystal', 'deuterium', 'energy_max');
		foreach ($array as $ResType)
		{
			if ($Incremental)
				$cost[$ResType] = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
			else
				$cost[$ResType] = floor($pricelist[$Element][$ResType]);

			if ($ForDestroy == true)
			{
				$cost[$ResType]  = floor($cost[$ResType]) / 2;
				$cost[$ResType] /= 2;
			}
		}

		return $cost;
	}
?>