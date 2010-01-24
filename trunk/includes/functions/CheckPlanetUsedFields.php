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

	function CheckPlanetUsedFields (&$planet)
	{
		global $resource, $db, $reslist;
		
		$checkarray = $reslist['allow'][$planet['planet_type']];
		$cfc = 0;
		foreach($checkarray as $id => $gid){
			$cfc += $planet[$resource[$gid]];
		}
		if ($planet['field_current'] != $cfc)
		{
			$planet['field_current'] = $cfc;
			$db->query("UPDATE `".PLANETS."` SET `field_current`= ".$cfc." WHERE `id` = ".$planet['id'].";");
		}
	}

?>