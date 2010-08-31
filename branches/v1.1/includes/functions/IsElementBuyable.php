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

	function IsElementBuyable ($USER, $PLANET, $Element, $Incremental = true, $ForDestroy = false)
	{
		global $pricelist, $resource;

		include_once(ROOT_PATH . 'includes/functions/IsVacationMode.' . PHP_EXT);

	    if (IsVacationMode($USER))
	       return false;

		if ($Incremental)
			$level  = isset($PLANET[$resource[$Element]]) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];

		$array    = array('metal', 'crystal', 'deuterium', 'energy_max', 'darkmatter');

		foreach ($array as $ResType)
		{
			if (empty($pricelist[$Element][$ResType]))
				continue;

			if ($Incremental)
				$cost[$ResType]  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
			else
				$cost[$ResType]  = floor($pricelist[$Element][$ResType]);

			if ($ForDestroy)
				$cost[$ResType]  = floor($cost[$ResType] / 2);

			if ((isset($PLANET[$ResType]) && $cost[$ResType] > $PLANET[$ResType]) || (isset($USER[$ResType]) && $cost[$ResType] > $USER[$ResType]))
				return false;
		}
		return true;
	}

?>