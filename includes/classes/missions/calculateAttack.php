<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-05-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */


function calculateAttack(&$attackers, &$defenders, $UNI)
{
	global $uniAllConfig;
	
	$uniConfig	= $uniAllConfig[$UNI];
	
	$TRES 	= array('attacker' => 0, 'defender' => 0);
	$ARES 	= $DRES = array('metal' => 0, 'crystal' => 0);
	$ROUND	= array();
	$RF		= array();
	
	foreach ($attackers as $fleetID => $attacker) 
	{
		foreach ($attacker['detail'] as $elementID => $amount) 
		{
			$ARES['metal'] 		+= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][901] * $amount;
			$ARES['crystal'] 	+= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][902] * $amount;
		}
	}

	foreach(array_merge($GLOBALS['VARS']['LIST'][ELEMENT_FLEET], $GLOBALS['VARS']['LIST'][ELEMENT_DEFENSIVE]) as $elementID)
	{
		if(!isset($GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['rapidfire'])) 
		{
			continue;
		}
		
		foreach($GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['rapidfire'] as $elementVersusID => $shoots)
		{
			if($shoots == 0) 
			{
				continue;
			}
			
			$RF[$elementVersusID][$elementID] = $shoots;
		}
	}
	
	$TRES['attacker']	= $ARES['metal'] + $ARES['crystal'];

	foreach ($defenders as $fleetID => $defender) 
	{
		foreach ($defender['def'] as $elementID => $amount)
		{
			if ($elementID < 300) {
				$DRES['metal'] 		+= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][901] * $amount;
				$DRES['crystal'] 	+= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][902] * $amount ;

				$TRES['defender'] 	+= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][901] * $amount;
				$TRES['defender'] 	+= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][902] * $amount;
			} else {
				if (!isset($STARTDEF[$elementID])) 
					$STARTDEF[$elementID] = 0;
				
				$STARTDEF[$elementID] += $amount;

				$TRES['defender']	+= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][901] * $amount;
				$TRES['defender']	+= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][902] * $amount;
			}
		}
	}
	
	for ($ROUNDC = 0; $ROUNDC <= $uniConfig['attackMaxRounds']; $ROUNDC++) 
	{
		$attackDamage  = array('total' => 0);
		$attackShield  = array('total' => 0);
		$attackAmount  = array('total' => 0);
		$defenseDamage = array('total' => 0);
		$defenseShield = array('total' => 0);
		$defenseAmount = array('total' => 0);
		$attArray = array();
		$defArray = array();

		foreach ($attackers as $fleetID => $attacker) {
			$attackDamage[$fleetID] = 0;
			$attackShield[$fleetID] = 0;
			$attackAmount[$fleetID] = 0;

			$attTech	= (1 + (0.1 * $attacker['user']['military_tech']) + $attacker['user']['factor']['Attack']); //attaque
			$defTech	= (1 + (0.1 * $attacker['user']['defence_tech']) + $attacker['user']['factor']['Defensive']); //bouclier
			$shieldTech = (1 + (0.1 * $attacker['user']['shield_tech']) + $attacker['user']['factor']['Shield']); //coque
			$attackers[$fleetID]['techs'] = array($attTech, $defTech, $shieldTech);
				
			foreach ($attacker['detail'] as $elementID => $amount) {
				$thisAtt	= $amount * ($GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['attack']) * $attTech * (rand(80, 120) / 100); //attaque
				$thisDef	= $amount * ($GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['shield']) * $defTech ; //bouclier
				$thisShield	= $amount * ($GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][901] + $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][902]) / 10 * $shieldTech; //coque

				$attArray[$fleetID][$elementID] = array('def' => $thisDef, 'shield' => $thisShield, 'att' => $thisAtt);

				$attackDamage[$fleetID] += $thisAtt;
				$attackDamage['total'] += $thisAtt;
				$attackShield[$fleetID] += $thisDef;
				$attackShield['total'] += $thisDef;
				$attackAmount[$fleetID] += $amount;
				$attackAmount['total'] += $amount;
			}
			$temp1	= $attacker['detail'];
		}

		foreach ($defenders as $fleetID => $defender) {
			$defenseDamage[$fleetID] = 0;
			$defenseShield[$fleetID] = 0;
			$defenseAmount[$fleetID] = 0;

			$attTech	= (1 + (0.1 * $defender['user']['military_tech']) + $defender['user']['factor']['Attack']); //attaquue
			$defTech	= (1 + (0.1 * $defender['user']['defence_tech']) + $defender['user']['factor']['Defensive']); //bouclier
			$shieldTech = (1 + (0.1 * $defender['user']['shield_tech']) + $defender['user']['factor']['Shield']); //coque
			$defenders[$fleetID]['techs'] = array($attTech, $defTech, $shieldTech);

			foreach ($defender['def'] as $elementID => $amount) {
				$thisAtt	= $amount * ($GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['attack']) * $attTech * (rand(80, 120) / 100); //attaque
				$thisDef	= $amount * ($GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['shield']) * $defTech ; //bouclier
				$thisShield	= $amount * ($GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][901] + $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][902]) / 10 * $shieldTech; //coque

				if ($elementID == 407 || $elementID == 408 || $elementID == 409) $thisAtt = 0;

				$defArray[$fleetID][$elementID] = array('def' => $thisDef, 'shield' => $thisShield, 'att' => $thisAtt);

				$defenseDamage[$fleetID] += $thisAtt;
				$defenseDamage['total'] += $thisAtt;
				$defenseShield[$fleetID] += $thisDef;
				$defenseShield['total'] += $thisDef;
				$defenseAmount[$fleetID] += $amount;
				$defenseAmount['total'] += $amount;
			}
			$temp2	= $defender['def'];
		}

		$ROUND[$ROUNDC] = array('attackers' => $attackers, 'defenders' => $defenders, 'attackA' => $attackAmount, 'defenseA' => $defenseAmount, 'infoA' => $attArray, 'infoD' => $defArray);

		if ($ROUNDC >= $uniConfig['attackMaxRounds'] || $defenseAmount['total'] <= 0 || $attackAmount['total'] <= 0) {
			break;
		}

		// Calculate hit percentages (ACS only but ok)
		$attackPct = array();
		foreach ($attackAmount as $fleetID => $amount) {
			if (!is_numeric($fleetID)) continue;
				$attackPct[$fleetID] = $amount / $attackAmount['total'];
		}

		$defensePct = array();
		foreach ($defenseAmount as $fleetID => $amount) {
			if (!is_numeric($fleetID)) continue;
				$defensePct[$fleetID] = $amount / $defenseAmount['total'];
		}

		// CALCUL DES PERTES !!!
		$attacker_n = array();
		$attacker_shield = 0;
		$defenderAttack	= 0;
		foreach ($attackers as $fleetID => $attacker) {
			$attacker_n[$fleetID] = array();

			foreach($attacker['detail'] as $elementID => $amount) {
				if ($amount <= 0) {
					$attacker_n[$fleetID][$elementID] = 0;
					continue;
				}

				$defender_moc = $amount * ($defenseDamage['total'] * $attackPct[$fleetID]) / $attackAmount[$fleetID];
			
				if(isset($RF[$elementID])) {
					foreach($RF[$elementID] as $shooter => $shots) {
						foreach($defArray as $fID => $rfdef) {
							if(empty($rfdef[$shooter]['att']) || $attackAmount[$fleetID] <= 0) continue;

							$defender_moc += $rfdef[$shooter]['att'] * $shots / ($amount / $attackAmount[$fleetID] * $attackPct[$fleetID]);
							$defenseAmount['total'] += $defenders[$fID]['def'][$shooter] * $shots;
						}
					}
				}
				
				$defenderAttack	+= $defender_moc;
				
				if (($attArray[$fleetID][$elementID]['def'] / $amount) >= $defender_moc) {
					$attacker_n[$fleetID][$elementID] = round($amount);
					$attacker_shield += $defender_moc;
					continue;
				}

				$max_removePoints = floor($amount * $defenseAmount['total'] / $attackAmount[$fleetID] * $attackPct[$fleetID]);

				$attacker_shield += min($attArray[$fleetID][$elementID]['def'], $defender_moc);
				$defender_moc 	 -= min($attArray[$fleetID][$elementID]['def'], $defender_moc);

				$ile_removePoints = max(min($max_removePoints, $amount * min($defender_moc / $attArray[$fleetID][$elementID]['shield'] * (rand(0, 200) / 100), 1)), 0);

				$attacker_n[$fleetID][$elementID] = max(ceil($amount - $ile_removePoints), 0);
			}
		}

		$defender_n = array();
		$defender_shield = 0;
		$attackerAttack	= 0;
		foreach ($defenders as $fleetID => $defender) {
			$defender_n[$fleetID] = array();

			foreach($defender['def'] as $elementID => $amount) {
				if ($amount <= 0) {
					$defender_n[$fleetID][$elementID] = 0;
					continue;
				}

				$attacker_moc = $amount * ($attackDamage['total'] * $defensePct[$fleetID]) / $defenseAmount[$fleetID];
				if (isset($RF[$elementID])) {
					foreach($RF[$elementID] as $shooter => $shots) {
						foreach($attArray as $fID => $rfatt) {
							if (empty($rfatt[$shooter]['att']) || $defenseAmount[$fleetID] <= 0 ) continue;

							$attacker_moc += $rfatt[$shooter]['att'] * $shots / ($amount / $defenseAmount[$fleetID] * $defensePct[$fleetID]);
							$attackAmount['total'] += $attackers[$fID]['detail'][$shooter] * $shots;
						}
					}
				}
				
				$attackerAttack	+= $attacker_moc;
				
				if (($defArray[$fleetID][$elementID]['def'] / $amount) >= $attacker_moc) {
					$defender_n[$fleetID][$elementID] = round($amount);
					$defender_shield += $attacker_moc;
					continue;
				}
	
				$max_removePoints = floor($amount * $attackAmount['total'] / $defenseAmount[$fleetID] * $defensePct[$fleetID]);
				$defender_shield += min($defArray[$fleetID][$elementID]['def'], $attacker_moc);
				$attacker_moc 	 -= min($defArray[$fleetID][$elementID]['def'], $attacker_moc);
				
				$ile_removePoints = max(min($max_removePoints, $amount * min($attacker_moc / $defArray[$fleetID][$elementID]['shield'] * (rand(0, 200) / 100), 1)), 0);

				$defender_n[$fleetID][$elementID] = max(ceil($amount - $ile_removePoints), 0);
			}
		}
		
		$ROUND[$ROUNDC]['attack'] 		= $attackerAttack;
		$ROUND[$ROUNDC]['defense'] 		= $defenderAttack;
		$ROUND[$ROUNDC]['attackShield'] = $attacker_shield;
		$ROUND[$ROUNDC]['defShield'] 	= $defender_shield;
		foreach ($attackers as $fleetID => $attacker) {
			$attackers[$fleetID]['detail'] =  array_map('round', $attacker_n[$fleetID]);
		}

		foreach ($defenders as $fleetID => $defender) {
			$defenders[$fleetID]['def'] = array_map('round', $defender_n[$fleetID]);
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
	foreach ($attackers as $fleetID => $attacker) {					   // flotte attaquant en CDR
		foreach ($attacker['detail'] as $elementID => $amount) {
			$TRES['attacker'] -= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][901] * $amount ;
			$TRES['attacker'] -= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][902] * $amount ;

			$ARES['metal'] -= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][901] * $amount ;
			$ARES['crystal'] -= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][902] * $amount ;
		}
	}

	$DRESDefs = array('metal' => 0, 'crystal' => 0);

	foreach ($defenders as $fleetID => $defender) {
		foreach ($defender['def'] as $elementID => $amount) {
			if ($elementID < 300) {							// flotte defenseur en CDR
				$DRES['metal'] 	 -= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][901] * $amount ;
				$DRES['crystal'] -= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][902] * $amount ;

				$TRES['defender'] -= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][901] * $amount ;
				$TRES['defender'] -= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][902] * $amount ;
			} else {									// defs defenseur en CDR + reconstruction
				$TRES['defender'] -= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][901] * $amount ;
				$TRES['defender'] -= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][902] * $amount ;

				$lost = $STARTDEF[$elementID] - $amount;
				$giveback = round($lost * (rand(56, 84) / 100));
				$defenders[$fleetID]['def'][$elementID] += $giveback;
				$DRESDefs['metal'] 	 += $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][901] * ($lost - $giveback) ;
				$DRESDefs['crystal'] += $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][902] * ($lost - $giveback) ;
			}
		}
	}
	
	$ARES['metal']		= max($ARES['metal'], 0);
	$ARES['crystal']	= max($ARES['crystal'], 0);
	$DRES['metal']		= max($DRES['metal'], 0);
	$DRES['crystal']	= max($DRES['crystal'], 0);
	$TRES['attacker']	= max($TRES['attacker'], 0);
	$TRES['defender']	= max($TRES['defender'], 0);
	
	$totalLost = array('att' => $TRES['attacker'], 'def' => $TRES['defender']);
	$debAttMet = ($ARES['metal'] * ($uniConfig['fleetToDebris'] / 100));
	$debAttCry = ($ARES['crystal'] * ($uniConfig['fleetToDebris'] / 100));
	$debDefMet = ($DRES['metal'] * ($uniConfig['fleetToDebris'] / 100)) + ($DRESDefs['metal'] * ($uniConfig['defenseToDebris'] / 100));
	$debDefCry = ($DRES['crystal'] * ($uniConfig['fleetToDebris'] / 100)) + ($DRESDefs['crystal'] * ($uniConfig['defenseToDebris'] / 100));

	return array('won' => $won, 'debree' => array('att' => array($debAttMet, $debAttCry), 'def' => array($debDefMet, $debDefCry)), 'rw' => $ROUND, 'lost' => $totalLost);
}
