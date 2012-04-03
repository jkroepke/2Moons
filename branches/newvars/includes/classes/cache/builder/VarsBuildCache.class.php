<?php

class VarsBuildCache
{
	function buildCache()
	{
		$flags	= array(ELEMENT_BUILD, ELEMENT_TECH, ELEMENT_FLEET, ELEMENT_DEFENSIVE, ELEMENT_OFFICIER, ELEMENT_BONUS, ELEMENT_RACE, ELEMENT_PLANET_RESOURCE, 
						ELEMENT_USER_RESOURCE, ELEMENT_ENERGY, ELEMENT_PRODUCTION, ELEMENT_STORAGE, ELEMENT_ONEPERPLANET, ELEMENT_BUILD_ON_PLANET, ELEMENT_BUILD_ON_MOONS, 
						ELEMENT_RESOURCE_ON_TF, ELEMENT_RESOURCE_ON_FLEET, ELEMENT_RESOURCE_ON_STEAL);

		foreach($flags as $flag)
		{
			$ELEMENT['LIST'][$flag][]	= array();
		}
		$ELEMENT		= array();

		$varsResult		= $GLOBALS['DATABASE']->query("SELECT * FROM ".VARS.";");
		while($varsRow = $GLOBALS['DATABASE']->fetchArray($varsResult)) {
			$ELEMENT['ELEMENT'][$varsRow['elementID']]	= array(
				'name'		=> $varsRow['name'],
				'flag'		=> $varsRow['class'],
				'combat'	=> array_filter(array(
					'attack'	=> $varsRow['attack'],
					'shield'	=> $varsRow['defend'],
				), 'is_numeric'),
				'cost'		=> array(
					901	=> $varsRow['cost901'],
					902	=> $varsRow['cost902'],
					903	=> $varsRow['cost903'],
					911	=> $varsRow['cost911'],
					921	=> $varsRow['cost921'],
				),
				'maxLevel'	=> $varsRow['maxLevel'],
				'factor'	=> $varsRow['factor'],
				'timeBonus'	=> $varsRow['timeBonus'],
				'fleetData'	=> array_filter(array(
					'consumption'	=> $varsRow['consumption1'],
					'consumption2'	=> $varsRow['consumption2'],
					'speed'			=> $varsRow['speed1'],
					'speed2'		=> $varsRow['speed2'],
					'capacity'		=> $varsRow['capacity'],
					'tech'			=> $varsRow['speedTech'],
				), 'is_null'),			
				'bonus'			=> array(
					'Attack'			=> $varsRow['bonusAttack'],
					'Defensive'			=> $varsRow['bonusDefensive'],
					'Shield'			=> $varsRow['bonusShield'],
					'BuildTime'			=> $varsRow['bonusBuildTime'],
					'ResearchTime'		=> $varsRow['bonusResearchTime'],
					'ShipTime'			=> $varsRow['bonusShipTime'],
					'DefensiveTime'		=> $varsRow['bonusDefensiveTime'],
					'Resource'			=> $varsRow['bonusResource'],
					'Energy'			=> $varsRow['bonusEnergy'],
					'ResourceStorage'	=> $varsRow['bonusResourceStorage'],
					'ShipStorage'		=> $varsRow['bonusShipStorage'],
					'FlyTime'			=> $varsRow['bonusFlyTime'],
					'FleetSlots'		=> $varsRow['bonusFleetSlots'],
					'Planets'			=> $varsRow['bonusPlanets'],
				),
				'production'	=> array_filter(array(
					901	=> $varsRow['production901'],
					902	=> $varsRow['production902'],
					903	=> $varsRow['production903'],
					911	=> $varsRow['production911'],
				), 'is_string'),
				'storage'	=> array_filter(array(
					901	=> $varsRow['storage901'],
					902	=> $varsRow['storage902'],
					903	=> $varsRow['storage903'],
				), 'is_string')
			);
			
			foreach($flags as $flag)
			{
				if(($varsRow['class'] & $flag) === $flag)
				{
					$ELEMENT['LIST'][$flag][$varsRow['elementID']]	= $varsRow['elementID'];
				}
			}
		}
		
		
		$reqResult		= $GLOBALS['DATABASE']->query("SELECT * FROM ".VARS_REQUIRE.";");
		while($reqRow = $GLOBALS['DATABASE']->fetchArray($reqResult)) {
			$ELEMENT['ELEMENT'][$reqRow['elementID']]['require'][$reqRow['requireID']]	= $reqRow['requireLevel'];
		}
		
		$rapidResult		= $GLOBALS['DATABASE']->query("SELECT * FROM ".VARS_RAPIDFIRE.";");
		while($rapidRow = $GLOBALS['DATABASE']->fetchArray($rapidResult)) {
			$ELEMENT['ELEMENT'][$rapidRow['elementID']]['combat']['rapidfire'][$rapidRow['rapidfireID']]	= $rapidRow['shoots'];
		}
		
		return $ELEMENT;
	}
}
