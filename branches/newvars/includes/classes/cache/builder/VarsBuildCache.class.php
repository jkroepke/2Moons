<?php

class VarsBuildCache
{
	function buildCache()
	{
		$ELEMENT		= array();
		
		$reqResult		= $GLOBALS['DATABASE']->query("SELECT * FROM ".VARS_REQUIRE.";");
		while($reqRow = $GLOBALS['DATABASE']->fetch_array($reqResult)) {
			$ELEMENT[$reqRow['elementID']]['require'][$reqRow['requireID']]	= $reqRow['requireLevel'];
		}

		$varsResult		= $GLOBALS['DATABASE']->query("SELECT * FROM ".VARS.";");
		while($varsRow = $GLOBALS['DATABASE']->fetch_array($varsResult)) {
			$ELEMENT[$varsRow['elementID']]	= array(
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
				'fleetData'	=> array_filter(array(
					'consumption'	=> $varsRow['consumption1'],
					'consumption2'	=> $varsRow['consumption2'],
					'speed'			=> $varsRow['speed1'],
					'speed2'		=> $varsRow['speed2'],
					'capacity'		=> $varsRow['capacity'],
					'tech'			=> $varsRow['speedTech'],
					'time'			=> $varsRow['timeBonus'],
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
		}
		
		$rapidResult		= $GLOBALS['DATABASE']->query("SELECT * FROM ".VARS_RAPIDFIRE.";");
		while($rapidRow = $GLOBALS['DATABASE']->fetch_array($rapidResult)) {
			$ELEMENT[$rapidRow['elementID']]['combat']['rapidfire'][$rapidRow['rapidfireID']]	= $rapidRow['shoots'];
		}
		
		return $ELEMENT;
	}
}
?>