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

function GetElementPrice ($USER, $planet, $Element, $USERfactor = true) { 
     global $pricelist, $resource, $LNG; 
		if ($USERfactor)
			$level = (isset($planet[$resource[$Element]])) ? $planet[$resource[$Element]] : $USER[$resource[$Element]];

		$is_buyeable = true;

		$array = array(
			'metal'      => $LNG['Metal'],
			'crystal'    => $LNG['Crystal'],
			'deuterium'  => $LNG['Deuterium'],
			'energy_max' => $LNG['Energy'],
		    'darkmatter' => $LNG['Darkmatter'],
		);
		$text = "";
		foreach ($array as $ResType => $ResTitle)
		{
			if ($pricelist[$Element][$ResType] != 0)
			{
				$text .= $ResTitle . ": ";
				if ($USERfactor)
					$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				else
					$cost = floor($pricelist[$Element][$ResType]);

				if ((isset($planet[$ResType]) && $cost > $planet[$ResType]) || (isset($USER[$ResType]) && $cost > $USER[$ResType]))
				{
					$text .= "<b style=\"color:red;\" id=\"".$ResType."_".$Element."\">" . pretty_number($cost) . "</b> ";
					$is_buyeable = false;
				}
				else
					$text .= "<b style=\"color:lime;\" id=\"".$ResType."_".$Element."\">" . pretty_number($cost) . "</b> ";
			}
		}
    return $text; 
}  
?>