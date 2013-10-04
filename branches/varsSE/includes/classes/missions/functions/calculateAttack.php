<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.8.0 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */


function calculateAttack(&$attackers, &$defenders, $FleetTF, $DefTF)
{
	global $pricelist, $CombatCaps, $resource;

	$TRES 	= array('attacker' => 0, 'defender' => 0);
	$ARES 	= $DRES = array('metal' => 0, 'crystal' => 0);
	$ROUND	= array();
	$RF		= array();

	$attackAmount = array();
	$defenseAmount = array();
	$STARTDEF = array();

	foreach ($attackers as $fleetId => $attacker)
	{
		foreach ($attacker['unit'] as $element => $amount) 
		{
			$ARES['metal'] 		+= $pricelist[$element]['cost'][901] * $amount;
			$ARES['crystal'] 	+= $pricelist[$element]['cost'][902] * $amount;
		}
	}

	foreach($CombatCaps as $e => $arr) {
		if(!isset($arr['sd'])) continue;
		
		foreach($arr['sd'] as $t => $sd) {
			if($sd == 0) continue;
			$RF[$t][$e] = $sd;
		}
	}
	
	$TRES['attacker']	= $ARES['metal'] + $ARES['crystal'];

	foreach ($defenders as $fleetId => $defender)
	{
		foreach ($defender['unit'] as $element => $amount)
		{
			if ($element < 300) {
				$DRES['metal'] 		+= $pricelist[$element]['cost'][901] * $amount;
				$DRES['crystal'] 	+= $pricelist[$element]['cost'][902] * $amount ;

				$TRES['defender'] 	+= $pricelist[$element]['cost'][901] * $amount;
				$TRES['defender'] 	+= $pricelist[$element]['cost'][902] * $amount;
			} else {
				if (!isset($STARTDEF[$element])) 
					$STARTDEF[$element] = 0;
				
				$STARTDEF[$element] += $amount;

				$TRES['defender']	+= $pricelist[$element]['cost'][901] * $amount;
				$TRES['defender']	+= $pricelist[$element]['cost'][902] * $amount;
			}
		}
	}
	
	for ($ROUNDC = 0; $ROUNDC <= MAX_ATTACK_ROUNDS; $ROUNDC++) 
	{
		$attackDamage  = array('total' => 0);
		$attackShield  = array('total' => 0);
		$attackAmount  = array('total' => 0);
		$defenseDamage = array('total' => 0);
		$defenseShield = array('total' => 0);
		$defenseAmount = array('total' => 0);
		$attArray = array();
		$defArray = array();

		foreach ($attackers as $fleetId => $attacker) {
			$attackDamage[$fleetId] = 0;
			$attackShield[$fleetId] = 0;
			$attackAmount[$fleetId] = 0;

			$attTech	= (1 + (0.1 * $attacker['player']['military_tech']) + $attacker['player']['factor']['Attack']); //attaque
			$defTech	= (1 + (0.1 * $attacker['player']['defence_tech']) + $attacker['player']['factor']['Defensive']); //bouclier
			$shieldTech = (1 + (0.1 * $attacker['player']['shield_tech']) + $attacker['player']['factor']['Shield']); //coque
			$attackers[$fleetId]['techs'] = array($attTech, $defTech, $shieldTech);
				
			foreach ($attacker['unit'] as $element => $amount) {
				$thisAtt	= $amount * ($CombatCaps[$element]['attack']) * $attTech * (rand(80, 120) / 100); //attaque
				$thisDef	= $amount * ($CombatCaps[$element]['shield']) * $defTech ; //bouclier
				$thisShield	= $amount * ($pricelist[$element]['cost'][901] + $pricelist[$element]['cost'][902]) / 10 * $shieldTech; //coque

				$attArray[$fleetId][$element] = array('def' => $thisDef, 'shield' => $thisShield, 'att' => $thisAtt);

				$attackDamage[$fleetId] += $thisAtt;
				$attackDamage['total'] += $thisAtt;
				$attackShield[$fleetId] += $thisDef;
				$attackShield['total'] += $thisDef;
				$attackAmount[$fleetId] += $amount;
				$attackAmount['total'] += $amount;
			}
		}

		foreach ($defenders as $fleetId => $defender) {
			$defenseDamage[$fleetId] = 0;
			$defenseShield[$fleetId] = 0;
			$defenseAmount[$fleetId] = 0;

			$attTech	= (1 + (0.1 * $defender['player']['military_tech']) + $defender['player']['factor']['Attack']); //attaquue
			$defTech	= (1 + (0.1 * $defender['player']['defence_tech']) + $defender['player']['factor']['Defensive']); //bouclier
			$shieldTech = (1 + (0.1 * $defender['player']['shield_tech']) + $defender['player']['factor']['Shield']); //coque
			$defenders[$fleetId]['techs'] = array($attTech, $defTech, $shieldTech);

			foreach ($defender['unit'] as $element => $amount) {
				$thisAtt	= $amount * ($CombatCaps[$element]['attack']) * $attTech * (rand(80, 120) / 100); //attaque
				$thisDef	= $amount * ($CombatCaps[$element]['shield']) * $defTech ; //bouclier
				$thisShield	= $amount * ($pricelist[$element]['cost'][901] + $pricelist[$element]['cost'][902]) / 10 * $shieldTech; //coque

				if ($element == 407 || $element == 408 || $element == 409) $thisAtt = 0;

				$defArray[$fleetId][$element] = array('def' => $thisDef, 'shield' => $thisShield, 'att' => $thisAtt);

				$defenseDamage[$fleetId] += $thisAtt;
				$defenseDamage['total'] += $thisAtt;
				$defenseShield[$fleetId] += $thisDef;
				$defenseShield['total'] += $thisDef;
				$defenseAmount[$fleetId] += $amount;
				$defenseAmount['total'] += $amount;
			}
		}

		$ROUND[$ROUNDC] = array('attackers' => $attackers, 'defenders' => $defenders, 'attackA' => $attackAmount, 'defenseA' => $defenseAmount, 'infoA' => $attArray, 'infoD' => $defArray);

		if ($ROUNDC >= MAX_ATTACK_ROUNDS || $defenseAmount['total'] <= 0 || $attackAmount['total'] <= 0) {
			break;
		}

		// Calculate hit percentages (ACS only but ok)
		$attackPct = array();
		foreach ($attackAmount as $fleetId => $amount) {
			if (!is_numeric($fleetId)) continue;
				$attackPct[$fleetId] = $amount / $attackAmount['total'];
		}

		$defensePct = array();
		foreach ($defenseAmount as $fleetId => $amount) {
			if (!is_numeric($fleetId)) continue;
				$defensePct[$fleetId] = $amount / $defenseAmount['total'];
		}

		// CALCUL DES PERTES !!!
		$attacker_n = array();
		$attacker_shield = 0;
		$defenderAttack	= 0;
		foreach ($attackers as $fleetId => $attacker) {
			$attacker_n[$fleetId] = array();

			foreach($attacker['unit'] as $element => $amount) {
				if ($amount <= 0) {
					$attacker_n[$fleetId][$element] = 0;
					continue;
				}

				$defender_moc = $amount * ($defenseDamage['total'] * $attackPct[$fleetId]) / $attackAmount[$fleetId];
			
				if(isset($RF[$element])) {
					foreach($RF[$element] as $shooter => $shots) {
						foreach($defArray as $fID => $rfdef) {
							if(empty($rfdef[$shooter]['att']) || $attackAmount[$fleetId] <= 0) continue;

							$defender_moc += $rfdef[$shooter]['att'] * $shots / ($amount / $attackAmount[$fleetId] * $attackPct[$fleetId]);
							$defenseAmount['total'] += $defenders[$fID]['unit'][$shooter] * $shots;
						}
					}
				}
				
				$defenderAttack	+= $defender_moc;
				
				if (($attArray[$fleetId][$element]['def'] / $amount) >= $defender_moc) {
					$attacker_n[$fleetId][$element] = round($amount);
					$attacker_shield += $defender_moc;
					continue;
				}

				$max_removePoints = floor($amount * $defenseAmount['total'] / $attackAmount[$fleetId] * $attackPct[$fleetId]);

				$attacker_shield += min($attArray[$fleetId][$element]['def'], $defender_moc);
				$defender_moc 	 -= min($attArray[$fleetId][$element]['def'], $defender_moc);

				$ile_removePoints = max(min($max_removePoints, $amount * min($defender_moc / $attArray[$fleetId][$element]['shield'] * (rand(0, 200) / 100), 1)), 0);

				$attacker_n[$fleetId][$element] = max(ceil($amount - $ile_removePoints), 0);
			}
		}

		$defender_n = array();
		$defender_shield = 0;
		$attackerAttack	= 0;
		foreach ($defenders as $fleetId => $defender) {
			$defender_n[$fleetId] = array();

			foreach($defender['unit'] as $element => $amount) {
				if ($amount <= 0) {
					$defender_n[$fleetId][$element] = 0;
					continue;
				}

				$attacker_moc = $amount * ($attackDamage['total'] * $defensePct[$fleetId]) / $defenseAmount[$fleetId];
				if (isset($RF[$element])) {
					foreach($RF[$element] as $shooter => $shots) {
						foreach($attArray as $fID => $rfatt) {
							if (empty($rfatt[$shooter]['att']) || $defenseAmount[$fleetId] <= 0 ) continue;

							$attacker_moc += $rfatt[$shooter]['att'] * $shots / ($amount / $defenseAmount[$fleetId] * $defensePct[$fleetId]);
							$attackAmount['total'] += $attackers[$fID]['unit'][$shooter] * $shots;
						}
					}
				}
				
				$attackerAttack	+= $attacker_moc;
				
				if (($defArray[$fleetId][$element]['def'] / $amount) >= $attacker_moc) {
					$defender_n[$fleetId][$element] = round($amount);
					$defender_shield += $attacker_moc;
					continue;
				}
	
				$max_removePoints = floor($amount * $attackAmount['total'] / $defenseAmount[$fleetId] * $defensePct[$fleetId]);
				$defender_shield += min($defArray[$fleetId][$element]['def'], $attacker_moc);
				$attacker_moc 	 -= min($defArray[$fleetId][$element]['def'], $attacker_moc);
				
				$ile_removePoints = max(min($max_removePoints, $amount * min($attacker_moc / $defArray[$fleetId][$element]['shield'] * (rand(0, 200) / 100), 1)), 0);

				$defender_n[$fleetId][$element] = max(ceil($amount - $ile_removePoints), 0);
			}
		}
		
		$ROUND[$ROUNDC]['attack'] 		= $attackerAttack;
		$ROUND[$ROUNDC]['defense'] 		= $defenderAttack;
		$ROUND[$ROUNDC]['attackShield'] = $attacker_shield;
		$ROUND[$ROUNDC]['defShield'] 	= $defender_shield;
		foreach ($attackers as $fleetId => $attacker) {
			$attackers[$fleetId]['unit'] = array_map('round', $attacker_n[$fleetId]);
		}

		foreach ($defenders as $fleetId => $defender) {
			$defenders[$fleetId]['unit'] = array_map('round', $defender_n[$fleetId]);
		}
	}
	
	if ($attackAmount['total'] <= 0 && $defenseAmount['total'] > 0) {
		$won = "r"; // defender
	} elseif ($attackAmount['total'] > 0 && $defenseAmount['total'] <= 0) {
		$won = "a"; // attacker
	} else {
		$won = "w"; // draw
	}

	// CDR
	foreach ($attackers as $fleetId => $attacker) {					   // flotte attaquant en CDR
		foreach ($attacker['unit'] as $element => $amount) {
			$TRES['attacker'] -= $pricelist[$element]['cost'][901] * $amount ;
			$TRES['attacker'] -= $pricelist[$element]['cost'][902] * $amount ;

			$ARES['metal'] -= $pricelist[$element]['cost'][901] * $amount ;
			$ARES['crystal'] -= $pricelist[$element]['cost'][902] * $amount ;
		}
	}

	$DRESDefs = array('metal' => 0, 'crystal' => 0);

	foreach ($defenders as $fleetId => $defender) {
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
				$giveback = round($lost * (rand(56, 84) / 100));
				$defenders[$fleetId]['unit'][$element] += $giveback;
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