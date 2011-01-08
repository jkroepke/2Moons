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

function GetElementPrice ($USER, $PLANET, $Element, $USERfactor = true) { 
     global $pricelist, $resource, $LNG; 
		if ($USERfactor)
			$level = (isset($PLANET[$resource[$Element]])) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];

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
				$cost  = $USERfactor ? floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level)) : floor($pricelist[$Element][$ResType]);
				$text .= (isset($PLANET[$ResType]) && $cost > $PLANET[$ResType]) || (isset($USER[$ResType]) && $cost > $USER[$ResType]) ? "<b style=\"color:red;\" id=\"".$ResType."_".$Element."\">" . pretty_number($cost) . "</b> " : "<b style=\"color:lime;\" id=\"".$ResType."_".$Element."\">" . pretty_number($cost) . "</b> ";
			}
		}
    return $text; 
}  
?>