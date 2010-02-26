<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

if (!defined('INSIDE')) die(header("location:../../"));

require_once("class.FlyingFleetMissions.".$phpEx);

class FlyingFleetHandler extends FlyingFleetMissions
{	
	function __construct($fleetquery)
	{
		global $db;
		while ($CurrentFleet = $db->fetch_array($fleetquery))
		{
			parent::CheckPlanet($CurrentFleet);

			switch ($CurrentFleet['fleet_mission'])
			{
				case 1:
					if(USE_NEW_BATTLE_ENGINE)
						parent::NewMissionCaseAttack($CurrentFleet);
					else
						parent::MissionCaseAttack($CurrentFleet);
				break;
				case 2:
					parent::MissionCaseACS($CurrentFleet);
				break;
				case 3:
					parent::MissionCaseTransport($CurrentFleet);
				break;
				case 4:
					parent::MissionCaseStay($CurrentFleet);
				break;
				case 5:
					parent::MissionCaseStayAlly($CurrentFleet);
				break;
				case 6:
					parent::MissionCaseSpy($CurrentFleet);
				break;
				case 7:
					parent::MissionCaseColonisation($CurrentFleet);
				break;
				case 8:
					parent::MissionCaseRecycling($CurrentFleet);
				break;
				case 9:
					parent::MissionCaseDestruction($CurrentFleet);
				break;
				case 10:
					parent::MissionCaseMIP($CurrentFleet);
				break;
				case 11:
					parent::MissionFoundDM($CurrentFleet);
				break;
				case 15:
					parent::MissionCaseExpedition($CurrentFleet);
				break;
				default: 
					$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = '". $CurrentFleet['fleet_id'] ."';");
				break;
			}
		}
	}
}
?>