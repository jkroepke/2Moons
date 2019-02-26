<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */
 
function fight(&$attackers, &$defenders)
{
	$attack = new Ds\Map(['attack' => 0, 'shield' => 0]);
	$defense = new Ds\Map(['attack' => 0, 'shield' => 0]);
	// attackers shoot
	foreach ($attackers as $fleetID => $attacker)
	{
		foreach ($attacker['units'] as $element => $unit)
		{
			shoot($attackers, $fleetID, $element, $unit, $defenders, $attack);
		}
	}
	// defenders shoot
	foreach ($defenders as $fleetID => $defender)
	{
		foreach ($defender['units'] as $element => $unit)
		{
			shoot($defenders, $fleetID, $element, $unit, $attackers, $defense);
		}
	}
	return new Ds\Map(['attack' => $attack['attack'], 'defense' => $defense['attack'], 'attackShield' => $defense['shield'], 'defShield' => $attack['shield']]);
}

function explodeAndDestroy(&$attackers)
{
	global $pricelist;
	foreach ($attackers as $fleetID => &$attacker)
	{
		$armorTech = (1 + (0.1 * $attacker['player']['shield_tech']) + $attacker['player']['factor']['Shield']);
		// foreach ($attacker['units'] as $element => $unit)
		for ($i = 0; $i < count($attacker['units']); $i++)
		{
			$unit = $attacker['units'][$i];
			if ($unit['armor'] <= 0)
			{
				// destroy unit
				$attacker['unit'][$unit['unit']] -= 1;
				$attacker['units']->remove($i);
				$i--;
			}
			else
			{
				$initialArmor = ($pricelist[$unit['unit']]['cost'][901] + $pricelist[$unit['unit']]['cost'][902]) / 10 * $armorTech;
				if ($unit['armor'] < 0.7 * $initialArmor)
				{
					$ran = rand(0, $initialArmor);
					if ($ran > $unit['armor'])
					{
						// explode unit
						$attacker['unit'][$unit['unit']] -= 1;
						$attacker['units']->remove($i);
						$i--;
					}
				}
			}
		}
	}
}

function shoot(&$attackers, $fleetID, $element, $unit, &$defenders, &$ad)
{
	// SHOOT
	global $CombatCaps;
	$count = 0;
	foreach ($defenders as $fleetID => &$defender)
	{
		$count += count($defender['units']);
	}
	$ran = rand(0, $count-1);
	$count = 0;
	$victimShip;
	foreach ($defenders as $fleetID => &$defender)
	{
		$count += count($defender['units']);
		if ($ran < $count)
		{
			$victimShipId = rand(0, count($defender['units'])-1);
			$victimShip = &$defender['units'][$victimShipId];
			break;
		}
	}
	
	$ad['attack'] += $unit['att'];
	if ($unit['att'] * 100 > $victimShip['shield'])
	{
		$penetration = $unit['att'] - $victimShip['shield'];
		if ($penetration >= 0)
		{
			//+penetration
			$ad['shield'] += $victimShip['shield'];
			$victimShip['shield'] = 0;
			$victimShip['armor'] -= $penetration; // shoot at armor
		}
		else
		{
			//-penetration
			$ad['shield'] -= $penetration;
			$victimShip['shield'] += $penetration; // shoot at shield
		}
	}
	// else bounced hit (Weaponry of the shooting unit is less than 1% of the Shielding of the target unit)
	
	// Rapid fire
	if (isset($CombatCaps[$unit['unit']]['sd']))
	{
		foreach ($CombatCaps[$unit['unit']]['sd'] as $sdId => $count)
		{
			if ($victimShip['unit'] == $sdId)
			{
				$ran = rand(0, $count);
				if ($ran < $count)
				{
					shoot($attackers, $fleetID, $element, $unit, $defenders, $ad);
				}
			}
		}
	}
} 

function initCombatValues(&$fleets, $firstInit = false)
{
	// INIT COMBAT VALUES
	global $CombatCaps, $pricelist;
	$attackAmount  = array('total' => 0);
	$attArray = array();
	foreach ($fleets as $fleetID => $attacker)
	{
		$attackAmount[$fleetID] = 0;
		
		// init techs
		$attTech	= (1 + (0.1 * $attacker['player']['military_tech']) + $attacker['player']['factor']['Attack']);
		$shieldTech	= (1 + (0.1 * $attacker['player']['defence_tech']) + $attacker['player']['factor']['Defensive']);
		$armorTech = (1 + (0.1 * $attacker['player']['shield_tech']) + $attacker['player']['factor']['Shield']);
		
		if ($firstInit)
		{
			$fleets[$fleetID]['techs'] = array($attTech, $shieldTech, $armorTech);
			$fleets[$fleetID]['units'] = new Ds\Vector(); // array();
		}

		$iter = 0;
		// init single ships
		foreach ($attacker['unit'] as $element => $amount)
		{
			// dont randomize +/-20% of attack power. The random factor is high enough
			$thisAtt	= ($CombatCaps[$element]['attack']) * $attTech; // * (rand(80, 120) / 100);
			$thisShield	= ($CombatCaps[$element]['shield']) * $shieldTech;
			$thisArmor	= ($pricelist[$element]['cost'][901] + $pricelist[$element]['cost'][902]) / 10 * $armorTech;
			
			$attArray[$fleetID][$element]['def'] = 0;
			$attArray[$fleetID][$element]['shield'] = 0;
			$attArray[$fleetID][$element]['att'] = 0;
			for ($ship = 0; $ship < $amount; $ship++, $iter++)
			{
				if ($firstInit)
				{
					// create new array for EACH ship
					$fleets[$fleetID]['units'][] = array('unit' => $element, 'shield' => $thisShield, 'armor' => $thisArmor, 'att' => $thisAtt);
				}
				$attArray[$fleetID][$element]['def'] += $thisShield;
				$attArray[$fleetID][$element]['shield'] += $fleets[$fleetID]['units'][$iter]['armor'];
				$attArray[$fleetID][$element]['att'] += $thisAtt;
			}
			
			$attackAmount[$fleetID] += $amount;
			$attackAmount['total'] += $amount;
		}
	}
	
	return array('attackAmount' => $attackAmount, 'attArray' => $attArray);
}

function restoreShields(&$fleets)
{
	global $CombatCaps;
	foreach ($fleets as $fleetID => $attacker)
	{
		$shieldTech	= (1 + (0.1 * $attacker['player']['defence_tech']) + $attacker['player']['factor']['Defensive']);
		foreach ($attacker['units'] as $element => $unit)
		{
			$fleets[$fleetID]['units'][$element]['shield'] = ($CombatCaps[$unit['unit']]['shield']) * $shieldTech;
		}
	}
}
 
function calculateAttack(&$attackers, &$defenders, $FleetTF, $DefTF)
{
	global $pricelist, $CombatCaps, $resource;
	
	$TRES 	= array('attacker' => 0, 'defender' => 0);
	$ARES 	= $DRES = array('metal' => 0, 'crystal' => 0);
	$ROUND	= array();
	$RF		= array();

	$attackAmount = array();
	$defenseAmount = array();
	
	// $STARTDEF - snapshot of defense amount. Needed for 70% restore
	$STARTDEF = array();

	// calculate attackers fleet metal+crystal value
	foreach ($attackers as $fleetID => $attacker) 
	{
		foreach ($attacker['unit'] as $element => $amount) 
		{
			$ARES['metal'] 		+= $pricelist[$element]['cost'][901] * $amount;
			$ARES['crystal'] 	+= $pricelist[$element]['cost'][902] * $amount;
		}
	}
	$TRES['attacker']	= $ARES['metal'] + $ARES['crystal'];

	//calculate defenders fleet metal+crystal value
	foreach ($defenders as $fleetID => $defender) 
	{
		foreach ($defender['unit'] as $element => $amount)
		{
			if ($element < 300) {
				// ships
				$DRES['metal'] 		+= $pricelist[$element]['cost'][901] * $amount;
				$DRES['crystal'] 	+= $pricelist[$element]['cost'][902] * $amount ;
			} else {
				// defense
				if (!isset($STARTDEF[$element])) 
					$STARTDEF[$element] = 0;
					
				$STARTDEF[$element] += $amount;
			}
			$TRES['defender']	+= $pricelist[$element]['cost'][901] * $amount;
			$TRES['defender']	+= $pricelist[$element]['cost'][902] * $amount;
		}
	}
	
	for ($ROUNDC = 0; $ROUNDC <= MAX_ATTACK_ROUNDS; $ROUNDC++) 
	{
		$attArray = array();
		$defArray = array();
	
		$att = initCombatValues($attackers, $ROUNDC == 0);
		$def = initCombatValues($defenders, $ROUNDC == 0);
		
		$ROUND[$ROUNDC] = array('attackers' => $attackers, 'defenders' => $defenders, 'attackA' => $att['attackAmount'], 'defenseA' => $def['attackAmount'], 'infoA' => $att['attArray'], 'infoD' => $def['attArray']);
		
		if ($att['attackAmount']['total'] > 0 && $def['attackAmount']['total'] > 0)
		{
			// FIGHT
			$fightResults = fight($attackers, $defenders);
			
			explodeAndDestroy($attackers);
			explodeAndDestroy($defenders);

			restoreShields($attackers);
			restoreShields($defenders);
			
			$ROUND[$ROUNDC]['attack'] 		= $fightResults['attack'];
			$ROUND[$ROUNDC]['defense'] 		= $fightResults['defense'];
			$ROUND[$ROUNDC]['attackShield'] = $fightResults['attackShield'];
			$ROUND[$ROUNDC]['defShield'] 	= $fightResults['defShield'];
		}
		else
		{
			break;
		}
	}
	
	if ($att['attackAmount']['total'] <= 0 && $def['attackAmount']['total'] > 0) {
		$won = "r"; // defender
	} elseif ($att['attackAmount']['total'] > 0 && $def['attackAmount']['total'] <= 0) {
		$won = "a"; // attacker
	} else {
		$won = "w"; // draw
	}

	// CDR
	foreach ($attackers as $fleetID => $attacker) {					   // flotte attaquant en CDR
		foreach ($attacker['unit'] as $element => $amount) {
			$TRES['attacker'] -= $pricelist[$element]['cost'][901] * $amount ;
			$TRES['attacker'] -= $pricelist[$element]['cost'][902] * $amount ;

			$ARES['metal'] -= $pricelist[$element]['cost'][901] * $amount ;
			$ARES['crystal'] -= $pricelist[$element]['cost'][902] * $amount ;
		}
	}

	$DRESDefs = array('metal' => 0, 'crystal' => 0);

	// restore defense (70% +/- 20%)
	foreach ($defenders as $fleetID => $defender) {
		foreach ($defender['unit'] as $element => $amount) {
			if ($element < 300) {							// flotte defenseur en CDR
				$DRES['metal'] 	 -= $pricelist[$element]['cost'][901] * $amount ;
				$DRES['crystal'] -= $pricelist[$element]['cost'][902] * $amount ;

				$TRES['defender'] -= $pricelist[$element]['cost'][901] * $amount ;
				$TRES['defender'] -= $pricelist[$element]['cost'][902] * $amount ;
			} else {									// defs defenseur en CDR + reconstruction
				$TRES['defender'] -= $pricelist[$element]['cost'][901] * $amount ;
				$TRES['defender'] -= $pricelist[$element]['cost'][902] * $amount ;

				$lost = $STARTDEF[$element] - $amount;
				$giveback = 0;
				for ($i = 0; $i < $lost; $i++) {
					if (rand(1, 100) <= 70)
						$giveback += 1;
				}
				$defenders[$fleetID]['unit'][$element] += $giveback;
				$DRESDefs['metal'] 	 += $pricelist[$element]['cost'][901] * ($lost - $giveback) ;
				$DRESDefs['crystal'] += $pricelist[$element]['cost'][902] * ($lost - $giveback) ;
			}
		}
	}
	
	$ARES['metal']		= max($ARES['metal'], 0);
	$ARES['crystal']	= max($ARES['crystal'], 0);
	$DRES['metal']		= max($DRES['metal'], 0);
	$DRES['crystal']	= max($DRES['crystal'], 0);
	$TRES['attacker']	= max($TRES['attacker'], 0);
	$TRES['defender']	= max($TRES['defender'], 0);
	
	$totalLost = array('attacker' => $TRES['attacker'], 'defender' => $TRES['defender']);
	$debAttMet = ($ARES['metal'] * ($FleetTF / 100));
	$debAttCry = ($ARES['crystal'] * ($FleetTF / 100));
	$debDefMet = ($DRES['metal'] * ($FleetTF / 100)) + ($DRESDefs['metal'] * ($DefTF / 100));
	$debDefCry = ($DRES['crystal'] * ($FleetTF / 100)) + ($DRESDefs['crystal'] * ($DefTF / 100));

	return array('won' => $won, 'debris' => array('attacker' => array(901 => $debAttMet, 902 => $debAttCry), 'defender' => array(901 => $debDefMet, 902 => $debDefCry)), 'rw' => $ROUND, 'unitLost' => $totalLost);
}
