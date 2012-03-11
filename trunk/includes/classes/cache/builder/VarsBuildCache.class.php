<?php

class VarsBuildCache
{
	function buildCache()
	{
		
		$resource		= array();
		$requeriments	= array();
		$pricelist		= array();
		$CombatCaps		= array();
		$reslist		= array();

		$reslist['prod']		= array();
		$reslist['storage']		= array();
		$reslist['bonus']		= array();
		$reslist['one']			= array();
		$reslist['build']		= array();
		$reslist['allow'][1]	= array();
		$reslist['allow'][3]	= array();
		$reslist['tech']		= array();
		$reslist['fleet']		= array();
		$reslist['defense']		= array();
		$reslist['officier']	= array();
		$reslist['dmfunc']		= array();
		
		$reqResult		= $GLOBALS['DATABASE']->query("SELECT * FROM ".VARS_REQUIRE.";");
		while($reqRow = $GLOBALS['DATABASE']->fetch_array($reqResult)) {
			$requeriments[$reqRow['elementID']][$reqRow['requireID']]	= $reqRow['requireLevel'];
		}

		$varsResult		= $GLOBALS['DATABASE']->query("SELECT * FROM ".VARS.";");
		while($varsRow = $GLOBALS['DATABASE']->fetch_array($varsResult)) {
			$resource[$varsRow['elementID']]	= $varsRow['name'];
			$CombatCaps[$varsRow['elementID']]	= array(
				'attack'	=> $varsRow['attack'],
				'shield'	=> $varsRow['defend'],
			);
			
			$pricelist[$varsRow['elementID']]	= array(
				'cost'		=> array(
					901	=> $varsRow['cost901'],
					902	=> $varsRow['cost902'],
					903	=> $varsRow['cost903'],
					911	=> $varsRow['cost911'],
					921	=> $varsRow['cost921'],
				),
				'factor'		=> $varsRow['factor'],
				'max'			=> $varsRow['maxLevel'],
				'consumption'	=> $varsRow['consumption1'],
				'consumption2'	=> $varsRow['consumption2'],
				'speed'			=> $varsRow['speed1'],
				'speed2'		=> $varsRow['speed2'],
				'capacity'		=> $varsRow['capacity'],
				'tech'			=> $varsRow['speedTech'],
				'time'			=> $varsRow['timeBonus'],
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
			);
			
			$ProdGrid[$varsRow['elementID']]['production']	= array(
				901	=> $varsRow['production901'],
				902	=> $varsRow['production902'],
				903	=> $varsRow['production903'],
				911	=> $varsRow['production911'],
			);
			
			$ProdGrid[$varsRow['elementID']]['storage']	= array(
				901	=> $varsRow['storage901'],
				902	=> $varsRow['storage902'],
				903	=> $varsRow['storage903'],
			);
			
			if(array_filter($ProdGrid[$varsRow['elementID']]['production']))
				$reslist['prod'][]		= $varsRow['elementID'];
				
			if(array_filter($ProdGrid[$varsRow['elementID']]['storage']))
				$reslist['storage'][]	= $varsRow['elementID'];
				
			if(array_filter($pricelist[$varsRow['elementID']]['bonus'], 'floatval'))
				$reslist['bonus'][]		= $varsRow['elementID'];
			
			if($varsRow['onePerPlanet'] == 1)
				$reslist['one'][]		= $varsRow['elementID'];
			
			switch($varsRow['class']) {
				case 0: 
					$reslist['build'][]	= $varsRow['elementID'];
					$tmp	= explode(',', $varsRow['onPlanetType']);
					foreach($tmp as $type) 
						$reslist['allow'][$type][]	= $varsRow['elementID'];
				break;
				case 100: 
					$reslist['tech'][]	= $varsRow['elementID'];
				break;
				case 200: 
					$reslist['fleet'][]	= $varsRow['elementID'];
				break;
				case 400: 
					$reslist['defense'][]	= $varsRow['elementID'];
				break;
				case 600: 
					$reslist['officier'][]	= $varsRow['elementID'];
				break;
				case 700: 
					$reslist['dmfunc'][]	= $varsRow['elementID'];
				break;
			}
		}

		$rapidResult		= $GLOBALS['DATABASE']->query("SELECT * FROM ".VARS_RAPIDFIRE.";");
		while($rapidRow = $GLOBALS['DATABASE']->fetch_array($rapidResult)) {
			$CombatCaps[$rapidRow['elementID']]['sd'][$rapidRow['rapidfireID']]	= $rapidRow['shoots'];
		}
		
		return array(
			'reslist'		=> $reslist,
			'ProdGrid'		=> $ProdGrid,
			'CombatCaps'	=> $CombatCaps,
			'resource'		=> $resource,
			'pricelist'		=> $pricelist,
			'requeriments'	=> $requeriments,
		);
	}
}
?>