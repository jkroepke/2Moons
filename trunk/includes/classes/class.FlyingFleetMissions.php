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

class FlyingFleetMissions {

	public static function ZeroSteal($steal)
	{
		return ($steal['metal'] <= 0 && $steal['crystal'] <= 0 && $steal['deuterium'] <= 0) ? true : false;
	}

	public static function CheckPlanet(&$CurrentFleet)
	{
		global $db;
		if(!CheckPlanetIfExist($CurrentFleet['fleet_start_galaxy'], $CurrentFleet['fleet_start_system'], $CurrentFleet['fleet_start_planet'], $CurrentFleet['fleet_start_type']))
		{
			if($CurrentFleet['fleet_start_galaxy'] == 3)
				$CurrentFleet['fleet_start_galaxy']	= 1;
			else 
			{
				$UserMainPlanet	= $db->fetch_array($db->query("SELECT `galaxy`, `system`, `planet` FROM ".USERS." WHERE `id` = ".$CurrentFleet['fleet_owner'].";"));
				$CurrentFleet['fleet_start_galaxy']	= $UserMainPlanet['galaxy'];
				$CurrentFleet['fleet_start_system']	= $UserMainPlanet['system'];
				$CurrentFleet['fleet_start_planet']	= $UserMainPlanet['planet'];
				$CurrentFleet['fleet_start_type']	= 1;
			}
		}
	}
	
	public static function calculateAKSSteal($attackFleets, $FleetRow, $defenderPlanet, $ForSim = false)
	{
		//Beute-Math by WOT-Game based on http://www.owiki.de/Beute
		global $pricelist, $db;
		$SortFleets = array();
		foreach ($attackFleets as $FleetID => $Attacker)
		{
			$metal[$FleetID]		= $Attacker['fleet']['metal'];
			$crystal[$FleetID]		= $Attacker['fleet']['crystal'];
			$deuterium[$FleetID]	= $Attacker['fleet']['deuterium'];
			
			foreach ($Attacker['detail'] as $Element => $amount)	
			{
				$SortFleets[$FleetID]		= $pricelist[$Element]['capacity'] * $amount - $metal[$FleetID] - $crystal[$FleetID] - $deuterium[$FleetID];
			}
			
			if(!isset($SortFleets[$FleetID])) 
			{
				unset($SortFleets[$FleetID]);
				continue;
			}
		}
		
		$Sumcapacity	= array_sum($SortFleets);
		
		$Sumcapacity -= array_sum($metal) + array_sum($crystal) + array_sum($deuterium);
		 
		// Step 1
		if(($defenderPlanet['metal'] / 2) > ($Sumcapacity / 3)) $booty['metal'] = ($Sumcapacity / 3);
		else $booty['metal'] = ($defenderPlanet['metal'] / 2);
		$Sumcapacity -= $booty['metal'];
		 
		// Step 2
		if($defenderPlanet['crystal'] > $Sumcapacity) $booty['crystal'] = ($Sumcapacity / 2);
		else $booty['crystal'] = ($defenderPlanet['crystal'] / 2);
		$Sumcapacity -= $booty['crystal'];
		 
		// Step 3
		if(($defenderPlanet['deuterium'] / 2) > $Sumcapacity) $booty['deuterium'] = $Sumcapacity;
		else $booty['deuterium'] = ($defenderPlanet['deuterium'] / 2);
		$Sumcapacity -= $booty['deuterium'];
		 
		// Step 4
		$oldMetalBooty = $booty['metal'];
		if($defenderPlanet['metal'] > $Sumcapacity) $booty['metal'] += ($Sumcapacity / 2);
		else $booty['metal'] += ($defenderPlanet['metal'] / 2);
		$Sumcapacity -= $booty['metal'];
		$Sumcapacity += $oldMetalBooty;
		 
		// Step 5
		if(($defenderPlanet['crystal'] / 2) > $Sumcapacity) $booty['crystal'] += $Sumcapacity;
		else $booty['crystal'] += ($defenderPlanet['crystal'] / 2);
		 
		// Reset metal and crystal booty
		if($booty['metal'] > ($defenderPlanet['metal'] / 2)) $booty['metal'] = $defenderPlanet['metal'] / 2;
		if($booty['crystal'] > ($defenderPlanet['crystal'] / 2)) $booty['crystal'] = $defenderPlanet['crystal'] / 2;
		
		$steal 		= array_map('floor', $booty);
		$Amount		= count($SortFleets);
		
		if($ForSim)
			return $steal;
			
		while(self::ZeroSteal($steal) === false)
		{
			foreach ($SortFleets as $FleetID => $Capacity)
			{
				$MetalSteal[$FleetID]		= isset($MetalSteal[$FleetID]) ? $MetalSteal[$FleetID] : 0;
				$CrystalSteal[$FleetID]		= isset($CrystalSteal[$FleetID]) ? $CrystalSteal[$FleetID] : 0;
				$DeuteriumSteal[$FleetID]	= isset($DeuteriumSteal[$FleetID]) ? $DeuteriumSteal[$FleetID] : 0;
				
				
				$Metall						= round(min(($steal['metal'] / $Amount), ($Capacity / 3)));
				$Crystal					= round(min(($steal['crystal'] / $Amount), ($Capacity / 3)));
				$Deuterium					= round(min(($steal['deuterium'] / $Amount), ($Capacity / 3)));		
				
				if($Capacity - ($Metall + $Crystal + $Deuterium) < 0)
				{				
					$Metall		-= (($Metall + $Crystal + $Deuterium) - $Capacity) / 3;
					$Crystal	-= (($Metall + $Crystal + $Deuterium) - $Capacity) / 3;
					$Deuterium	-= (($Metall + $Crystal + $Deuterium) - $Capacity) / 3;
				}
				
				$Metall						= round($Metall);
				$Crystal					= round($Crystal);
				$Deuterium					= round($Deuterium);
				
				$steal['metal']			   -= $Metall;
				$steal['crystal']		   -= $Crystal;
				$steal['deuterium']		   -= $Deuterium;
					
				$MetalSteal[$FleetID]	   += $Metall;
				$CrystalSteal[$FleetID]	   += $Crystal;
				$DeuteriumSteal[$FleetID]  += $Deuterium;
				
				$SortFleets[$FleetID]	   -= $Metall + $Crystal + $Deuterium;
			}		
		}
		$QryUpdateFleet	= "";
		
		foreach($SortFleets as $FleetID => $Room)
		{
		
			$QryUpdateFleet .= 'UPDATE '.FLEETS.' SET ';
			$QryUpdateFleet .= '`fleet_resource_metal` = `fleet_resource_metal` + '.$MetalSteal[$FleetID].', ';
			$QryUpdateFleet .= '`fleet_resource_crystal` = `fleet_resource_crystal` +'.$CrystalSteal[$FleetID].', ';
			$QryUpdateFleet .= '`fleet_resource_deuterium` = `fleet_resource_deuterium` +'.$DeuteriumSteal[$FleetID].' ';
			$QryUpdateFleet .= 'WHERE fleet_id = '.$FleetID.' ';
			$QryUpdateFleet .= 'LIMIT 1;';		
		}
		
		$db->multi_query($QryUpdateFleet);
		return array_map('floor', $booty);
	}
	
	private static function calculateSoloSteal($attackFleets, $FleetRow, $defenderPlanet)
	{
		//Beute-Math by WOT-Game based on http://www.owiki.de/Beute
		global $pricelist, $db;
		$capacity = 0;

		foreach ($attackFleets[$FleetRow['fleet_id']]['detail'] as $Element => $amount)	{
			$capacity += $pricelist[$Element]['capacity'] * $amount;
		}
		
		$capacity -= $attackFleets['metal'] + $attackFleets['crystal'] + $attackFleets['deuterium'];
		 
		// Step 1
		if(($defenderPlanet['metal'] / 2) > ($capacity / 3)) $booty['metal'] = ($capacity / 3);
		else $booty['metal'] = ($defenderPlanet['metal'] / 2);
		$capacity -= $booty['metal'];
		 
		// Step 2
		if($defenderPlanet['crystal'] > $capacity) $booty['crystal'] = ($capacity / 2);
		else $booty['crystal'] = ($defenderPlanet['crystal'] / 2);
		$capacity -= $booty['crystal'];
		 
		// Step 3
		if(($defenderPlanet['deuterium'] / 2) > $capacity) $booty['deuterium'] = $capacity;
		else $booty['deuterium'] = ($defenderPlanet['deuterium'] / 2);
		$capacity -= $booty['deuterium'];
		 
		// Step 4
		$oldMetalBooty = $booty['metal'];
		if($defenderPlanet['metal'] > $capacity) $booty['metal'] += ($capacity / 2);
		else $booty['metal'] += ($defenderPlanet['metal'] / 2);
		$capacity -= $booty['metal'];
		$capacity += $oldMetalBooty;
		 
		// Step 5
		if(($defenderPlanet['crystal'] / 2) > $capacity) $booty['crystal'] += $capacity;
		else $booty['crystal'] += ($defenderPlanet['crystal'] / 2);
		 
		// Reset metal and crystal booty
		if($booty['metal'] > ($defenderPlanet['metal'] / 2)) $booty['metal'] = $defenderPlanet['metal'] / 2;
		if($booty['crystal'] > ($defenderPlanet['crystal'] / 2)) $booty['crystal'] = $defenderPlanet['crystal'] / 2;
		
		$steal = array_map('round', $booty);
		
		$QryUpdateFleet  = 'UPDATE '.FLEETS.' SET ';
		$QryUpdateFleet .= '`fleet_resource_metal` = `fleet_resource_metal` + '. $steal['metal'] .', ';
		$QryUpdateFleet .= '`fleet_resource_crystal` = `fleet_resource_crystal` +'. $steal['crystal'] .', ';
		$QryUpdateFleet .= '`fleet_resource_deuterium` = `fleet_resource_deuterium` +'. $steal['deuterium'] .' ';
		$QryUpdateFleet .= 'WHERE fleet_id = '. $FleetRow['fleet_id'] .' ';
		$QryUpdateFleet .= 'LIMIT 1;';
		$db->query($QryUpdateFleet);
		return $steal;
	}

	public static function calculateAttack (&$attackers, &$defenders) 
	{
        global $pricelist, $CombatCaps, $game_config, $resource, $ExtraDM;

		// generate new table for rapid fire
		// $rf[target] = array ( shooter1 => shots1, shooter2 => shots2 );

		foreach ($CombatCaps as $e => $arr) {
			if (!is_array($arr['sd'])){
				trigger_error("Failed to create Rapidfire for ID: ".$e,E_USER_WARNING);
				continue;
			}
			foreach($arr['sd'] as $t => $sd) {
				if ($sd == 1 || $sd == 0 ) continue;
				
				$rf[$t][$e] = $sd;
			}
		}
        
        $totalResourcePoints = array('attacker' => 0, 'defender' => 0);        
        $resourcePointsAttacker = array('metal' => 0, 'crystal' => 0);
        
        foreach ($attackers as $fleetID => $attacker) {
            foreach ($attacker['detail'] as $element => $amount) {
                $resourcePointsAttacker['metal'] += $pricelist[$element]['metal'] * $amount;
                $resourcePointsAttacker['crystal'] += $pricelist[$element]['crystal'] * $amount ;
                
                $totalResourcePoints['attacker'] += $pricelist[$element]['metal'] * $amount ;
                $totalResourcePoints['attacker'] += $pricelist[$element]['crystal'] * $amount ;
            }
        }
        
        $resourcePointsDefender = array('metal' => 0, 'crystal' => 0);
        foreach ($defenders as $fleetID => $defender) {
            foreach ($defender['def'] as $element => $amount) {                                //Line20
                if ($element < 300) {
                    $resourcePointsDefender['metal'] += $pricelist[$element]['metal'] * $amount ;
                    $resourcePointsDefender['crystal'] += $pricelist[$element]['crystal'] * $amount ;
                    
                    $totalResourcePoints['defender'] += $pricelist[$element]['metal'] * $amount ;
                    $totalResourcePoints['defender'] += $pricelist[$element]['crystal'] * $amount ;                    
                } else {
                    if (!isset($originalDef[$element])) $originalDef[$element] = 0;
                    $originalDef[$element] += $amount;
                    
                    $totalResourcePoints['defender'] += $pricelist[$element]['metal'] * $amount ;
                    $totalResourcePoints['defender'] += $pricelist[$element]['crystal'] * $amount ;
                }
            }
        }
        
        $max_rounds = MAX_ATTACK_ROUNDS;
        $max_rounds = 6;

        
        for ($round = 0, $rounds = array(); $round < $max_rounds; $round++) {
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
                
                foreach ($attacker['detail'] as $element => $amount) {
                    $attTech    = (1 + (0.1 * ($attacker['user']['military_tech']) + (0.05 * $attacker['user'][$resource[602]]) + ((time() - $attacker['user'][$resource[701]] <= 0) ? ($ExtraDM[700]['add']) : 0))); //attaque
                    $defTech    = (1 + (0.1 * ($attacker['user']['defence_tech']) + (0.05 * $attacker['user'][$resource[602]]) + ((time() - $attacker['user'][$resource[700]] <= 0) ? ($ExtraDM[701]['add']) : 0))); //bouclier
                    $shieldTech = (1 + (0.1 * ($attacker['user']['shield_tech']) + (0.05 * $attacker['user'][$resource[602]]))); //coque
                    
                    $attackers[$fleetID]['techs'] = array($shieldTech, $defTech, $attTech);
                    
                    $thisAtt    = $amount * $CombatCaps[$element]['attack'] * $attTech; //attaque
                    $thisShield = $amount * $CombatCaps[$element]['shield'] * $shieldTech ; //bouclier
                    $thisDef	= $amount * ($pricelist[$element]['metal'] + $pricelist[$element]['crystal']) / 10 * $defTech; //coque
                    
                    $attArray[$fleetID][$element] = array('def' => $thisDef, 'shield' => $thisShield, 'att' => $thisAtt);
                    
                    $attackDamage[$fleetID] += $thisAtt;
                    $attackDamage['total'] += $thisAtt;
                    $attackShield[$fleetID] += $thisShield;
                    $attackShield['total'] += $thisShield;
                    $attackAmount[$fleetID] += $amount;
                    $attackAmount['total'] += $amount;
                }
            }
            
            foreach ($defenders as $fleetID => $defender) {
                $defenseDamage[$fleetID] = 0;
                $defenseShield[$fleetID] = 0;
                $defenseAmount[$fleetID] = 0;
                
                foreach ($defender['def'] as $element => $amount) {
                    $attTech    = (1 + (0.1 * ($defender['user']['military_tech']) + (0.05 * $defender['user'][$resource[602]]) + ((time() - $attacker['user'][$resource[701]] <= 0) ? ($ExtraDM[700]['add']) : 0))); //attaquue
                    $defTech    = (1 + (0.1 * ($defender['user']['defence_tech']) + (0.05 * $defender['user'][$resource[602]]) + ((time() - $defender['user'][$resource[701]] <= 0) ? ($ExtraDM[701]['add']) : 0))); //bouclier
                    $shieldTech = (1 + (0.1 * ($defender['user']['shield_tech']) + (0.05 * $defender['user'][$resource[602]]))); //coque
                    
                    $defenders[$fleetID]['techs'] = array($shieldTech, $defTech, $attTech);
                    
                    $thisAtt    = $amount * $CombatCaps[$element]['attack'] * $attTech; //attaque
                    $thisShield = $amount * $CombatCaps[$element]['shield'] * $shieldTech ; //bouclier
                    $thisDef    = $amount * ($pricelist[$element]['metal'] + $pricelist[$element]['crystal']) / 10 * $defTech;; //coque
                    					
                    $defArray[$fleetID][$element] = array('def' => $thisDef, 'shield' => $thisShield, 'att' => $thisAtt);
                    
                    $defenseDamage[$fleetID] += $thisAtt;
                    $defenseDamage['total'] += $thisAtt;
                    $defenseShield[$fleetID] += $thisShield;
                    $defenseShield['total'] += $thisShield;
                    $defenseAmount[$fleetID] += $amount;
                    $defenseAmount['total'] += $amount;
                }
            }
            
            $rounds[$round] = array('attackers' => $attackers, 'defenders' => $defenders, 'attack' => $attackDamage, 'defense' => $defenseDamage, 'attackA' => $attackAmount, 'defenseA' => $defenseAmount, 'infoA' => $attArray, 'infoD' => $defArray);
            
            if ($defenseAmount['total'] <= 0 || $attackAmount['total'] <= 0) {
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
            foreach ($attackers as $fleetID => $attacker) {
                $attacker_n[$fleetID] = array();
                
                foreach($attacker['detail'] as $element => $amount) {
                    $defender_moc = $amount * ($defenseDamage['total'] * $attackPct[$fleetID]) / $attackAmount[$fleetID];
		    // rapid fire against this element
		    if ( is_array($rf[$element])  &&  $amount > 0  ) {
			foreach ( $rf[$element] as $shooter => $shots ) {
			    foreach ( $defArray as $fID => $rfdef ) {
				if ( $rfdef[$shooter]['att'] > 0  &&  $attackAmount[$fleetID] > 0 ) {
				    // add damage
				    $defender_moc += $rfdef[$shooter]['att'] * $shots / ( $amount/$attackAmount[$fleetID]*$attackPct[$fleetID] );
				    // increase total amount of hits
				    $defenseAmount['total'] += $defenders[$fID]['def'][$shooter] * $shots;
				}
			    }
			}
		    }
                    
                    if ($amount > 0 ) {
                        if ($attArray[$fleetID][$element]['shield']/$amount < $defender_moc) {
                            $max_removePoints = ceil($amount * $defenseAmount['total'] / $attackAmount[$fleetID] * $attackPct[$fleetID]);
                            
                            $defender_moc -= $attArray[$fleetID][$element]['shield'];
                            $attacker_shield += $attArray[$fleetID][$element]['shield'];
                            $ile_removePoints = ceil( $defender_moc / ($attArray[$fleetID][$element]['def']/$amount) );
                            
                            if ($max_removePoints < 0) $max_removePoints = 0;
                            if ($ile_removePoints < 0) $ile_removePoints = 0;
                            
                            if ($ile_removePoints > $max_removePoints) {
                                $ile_removePoints = $max_removePoints;
                            }
                            
                            $attacker_n[$fleetID][$element] = ceil($amount - $ile_removePoints);
                            if ($attacker_n[$fleetID][$element] <= 0) {
                                $attacker_n[$fleetID][$element] = 0;
                            }
                        } else {
                            $attacker_n[$fleetID][$element] = round($amount);
                            $attacker_shield += $defender_moc;
                        }
                    } else {
                        $attacker_n[$fleetID][$element] = round($amount);
                        $attacker_shield += $defender_moc;
                    }
                }
            }
            
            $defender_n = array();
            $defender_shield = 0;
            
            foreach ($defenders as $fleetID => $defender) {
                $defender_n[$fleetID] = array();
                
				foreach($defender['def'] as $element => $amount) {
					$attacker_moc = $amount * ($attackDamage['total'] * $defensePct[$fleetID]) / $defenseAmount[$fleetID];
					
                    // rapid fire against this element
					if ( is_array($rf[$element])  &&  $amount > 0  ) {
						foreach ( $rf[$element] as $shooter => $shots ) {
							foreach ( $attArray as $fID => $rfatt ) {
								if ( $rfatt[$shooter]['att'] > 0  &&  $defenseAmount[$fleetID] > 0 ) {
									// add damage
									$attacker_moc += $rfatt[$shooter]['att'] * $shots / ( $amount/$defenseAmount[$fleetID]*$defensePct[$fleetID] );
									// increase total amount of hits
									$attackAmount['total'] += $attackers[$fID]['detail'][$shooter] * $shots;
								}
							}
						}
					}

                    if ($amount > 0) {
                        if ($defArray[$fleetID][$element]['shield']/$amount < $attacker_moc) {
                            $max_removePoints = ceil($amount * $attackAmount['total'] / $defenseAmount[$fleetID] * $defensePct[$fleetID]);
                            $attacker_moc -= $defArray[$fleetID][$element]['shield'];
                            $defender_shield += $defArray[$fleetID][$element]['shield'];
                            $ile_removePoints = ceil( $attacker_moc / ($defArray[$fleetID][$element]['def']/$amount) );
                            
                            if ($max_removePoints < 0) $max_removePoints = 0;
                            if ($ile_removePoints < 0) $ile_removePoints = 0;
                            
                            if ($ile_removePoints > $max_removePoints) {
                                $ile_removePoints = $max_removePoints;
                            }
                            
                            $defender_n[$fleetID][$element] = ceil($amount - $ile_removePoints);
                            if ($defender_n[$fleetID][$element] <= 0) {
                                $defender_n[$fleetID][$element] = 0;
                            }
                        
                        } else {
                            $defender_n[$fleetID][$element] = round($amount);
                            $defender_shield += $attacker_moc;
                        }
                    } else {
                        $defender_n[$fleetID][$element] = round($amount);
                        $defender_shield += $attacker_moc;
                    }
                }
            }
            
            $rounds[$round]['attackShield'] = $attacker_shield;
            $rounds[$round]['defShield'] = $defender_shield;
            
            foreach ($attackers as $fleetID => $attacker) {
                $attackers[$fleetID]['detail'] = array_map('round', $attacker_n[$fleetID]);
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
            $rounds[count($rounds)] = array('attackers' => $attackers, 'defenders' => $defenders, 'attack' => $attackDamage, 'defense' => $defenseDamage, 'attackA' => $attackAmount, 'defenseA' => $defenseAmount);
        }
        
        // CDR
        foreach ($attackers as $fleetID => $attacker) {                                       // flotte attaquant en CDR
            foreach ($attacker['detail'] as $element => $amount) {
                $totalResourcePoints['attacker'] -= $pricelist[$element]['metal'] * $amount ;
                $totalResourcePoints['attacker'] -= $pricelist[$element]['crystal'] * $amount ;
                
                $resourcePointsAttacker['metal'] -= $pricelist[$element]['metal'] * $amount ;
                $resourcePointsAttacker['crystal'] -= $pricelist[$element]['crystal'] * $amount ;
            }
        }
        
        $resourcePointsDefenderDefs = array('metal' => 0, 'crystal' => 0);        
        foreach ($defenders as $fleetID => $defender) {
            foreach ($defender['def'] as $element => $amount) {                                
                if ($element < 300) {                                                        // flotte defenseur en CDR
                    $resourcePointsDefender['metal'] -= $pricelist[$element]['metal'] * $amount ;
                    $resourcePointsDefender['crystal'] -= $pricelist[$element]['crystal'] * $amount ;
                    
                    $totalResourcePoints['defender'] -= $pricelist[$element]['metal'] * $amount ;
                    $totalResourcePoints['defender'] -= $pricelist[$element]['crystal'] * $amount ;                
                } else {                                                                    // defs defenseur en CDR + reconstruction                    
                    $totalResourcePoints['defender'] -= $pricelist[$element]['metal'] * $amount ;
                    $totalResourcePoints['defender'] -= $pricelist[$element]['crystal'] * $amount ;
                                                                                    
                    $lost = $originalDef[$element] - $amount;
                    $giveback = round($lost * (rand(70*0.8, 70*1.2) / 100));
                    $defenders[$fleetID]['def'][$element] += $giveback;
                    $resourcePointsDefenderDefs['metal'] += $pricelist[$element]['metal'] * ($lost - $giveback) ;
                    $resourcePointsDefenderDefs['crystal'] += $pricelist[$element]['crystal'] * ($lost - $giveback) ;
                    
                }
            }
        }
        
        
        $totalLost = array('att' => $totalResourcePoints['attacker'], 'def' => $totalResourcePoints['defender']);
        $debAttMet = ($resourcePointsAttacker['metal'] * ($game_config['Fleet_Cdr'] / 100));
        $debAttCry = ($resourcePointsAttacker['crystal'] * ($game_config['Fleet_Cdr'] / 100));
        $debDefMet = ($resourcePointsDefender['metal'] * ($game_config['Fleet_Cdr'] / 100)) + ($resourcePointsDefenderDefs['metal'] * ($game_config['Defs_Cdr'] / 100));
        $debDefCry = ($resourcePointsDefender['crystal'] * ($game_config['Fleet_Cdr'] / 100)) + ($resourcePointsDefenderDefs['crystal'] * ($game_config['Defs_Cdr'] / 100));
                    
        return array('won' => $won, 'debree' => array('att' => array($debAttMet, $debAttCry), 'def' => array($debDefMet, $debDefCry)), 'rw' => $rounds, 'lost' => $totalLost);
    }

	private static function calculateMIPAttack($TargetDefTech, $OwnerAttTech, $ipm, $TargetDefensive, $pri_target, $adm)
	{
		global $pricelist, $reslist;
		// Based on http://websim.speedsim.net/ JS-IRak Simulation
		unset($TargetDefensive[503]);
		$GetTargetKeys	= array_keys($TargetDefensive);
		
		$life_fac		= $TargetDefTech / 10 + 1;
		$life_fac_a 	= 12000 * ($OwnerAttTech / 10 + 1);
		
		$ipm -= $abm;
		$abm = 0;
		$max_dam = $ipm * $life_fac_a;
		$i = 0;	

		$ship_res = array();
		foreach($TargetDefensive as $Element => $Count)
		{
			if($i == 0)
				$target = $pri_target;
			elseif($Element <= $pri_target)
				$target = $Element - 1;
			else
				$target = $Element;
			
			
			$Dam = $max_dam - ($pricelist[$target]['metal'] + $pricelist[$target]['crystal']) / 10 * $TargetDefensive[$target] * $life_fac;
			
			if($Dam > 0)
			{
				$dest = $TargetDefensive[$target];
				$ship_res[$target] = $dest;
			}
			else
			{
				// not enough damage for all items
				$dest = floor($max_dam / (($pricelist[$target]['metal'] + $pricelist[$target]['crystal']) / 10 * $life_fac));
				$ship_res[$target] = $dest;
			}
			$max_dam -= $dest * round(($pricelist[$target]['metal'] + $pricelist[$target]['crystal']) / 10 * $life_fac);
			$i++;
		}
		
		return $ship_res;
	}
	
	public static function GenerateReport (&$result_array, &$steal_array, &$moon_int, &$moon_string, &$time_float, $moondes = "")
	{
		global $lang;

		$html 		= "";
		$bbc 		= "";
		
		if($moondes)
		{
			$html 		.= $lang['sys_destruc_title']." ".date("D M j H:i:s", time()).".<br><br>";
		} else {
			$html 		.= $lang['sys_attack_title']." ".date("D M j H:i:s", time()).".<br><br>";
		}	
		$round_no 	= 1;
		$des = 0;
		foreach($result_array['rw'] as $round => $data1)
		{
			if($round_no <= 6)
			{
				$html 		.= $lang['sys_attack_round']." ".$round_no." :<br><br>";
				$attackers1 = $data1['attackers'];
				$attackers2 = $data1['infoA'];
				$attackers3 = $data1['attackA'];
				$defenders1 = $data1['defenders'];
				$defenders2 = $data1['infoD'];
				$defenders3 = $data1['defenseA'];
				$coord4 	= 0;
				$coord5 	= 0;
				$coord6 	= 0;
				$html		.= "<table><tr>";
				foreach( $attackers1 as $fleet_id1 => $data2)
				{
					$name 	= $data2['user']['username'];
					$coord1 = $data2['fleet']['fleet_start_galaxy'];
					$coord2 = $data2['fleet']['fleet_start_system'];
					$coord3 = $data2['fleet']['fleet_start_planet'];
					$weap 	= ($data2['user']['military_tech'] * 10);
					$shie 	= ($data2['user']['defence_tech'] * 10);
					$armr 	= ($data2['user']['shield_tech'] * 10);

					if($coord4 == 0){$coord4 += $data2['fleet']['fleet_end_galaxy'];}
					if($coord5 == 0){$coord5 += $data2['fleet']['fleet_end_system'];}
					if($coord6 == 0){$coord6 += $data2['fleet']['fleet_end_planet'];}

					$fl_info1  	= "<td><table><tr><th>";
					$fl_info1 	.= $lang['sys_attack_attacker_pos']." ".$name." ([".$coord1.":".$coord2.":".$coord3."])<br>";
					$fl_info1 	.= $lang['sys_ship_weapon']." ".$weap."% - ".$lang['sys_ship_shield']." ".$shie."% - ".$lang['sys_ship_armour']." ".$armr."%";
					$table1  	= "<table border=1 align=\"center\" width=\"100%\">";

					if ($data1['attack']['total'] > 0)
					{
						$ships1  = "<tr><th>".$lang['sys_ship_type']."</th>";
						$count1  = "<tr><th>".$lang['sys_ship_count']."</th>";

						foreach( $data2['detail'] as $ship_id1 => $ship_count1)
						{
							if ($ship_count1 > 0)
							{
								$ships1 .= "<th>[ship[".$ship_id1."]]</th>";
								$count1 .= "<th>".pretty_number($ship_count1)."</th>";
							}
						}

						$ships1 .= "</tr>";
						$count1 .= "</tr>";
					}
					else
					{
						$des = 1;
						$ships1 = "<tr><br><br>". $lang['sys_destroyed']."<br></tr>";
						$count1 = "";
					}

					$info_part1[$fleet_id1] = $fl_info1.$table1.$ships1.$count1;
				}



				foreach( $attackers2 as $fleet_id2 => $data3)
				{
					$weap1  = "<tr><th>".$lang['sys_ship_weapon']."</th>";
					$shields1  = "<tr><th>".$lang['sys_ship_shield']."</th>";
					$armour1  = "<tr><th>".$lang['sys_ship_armour']."</th>";

					foreach( $data3 as $ship_id2 => $ship_points1)
					{
						if($ship_points1['shield'] > 0)
						{
							$weap1 		.= "<th>".pretty_number($ship_points1['att'])."</th>";
							$shields1 	.= "<th>".pretty_number($ship_points1['def'])."</th>";
							$armour1 	.= "<th>".pretty_number($ship_points1['shield'])."</th>";
						}
					}

					$weap1 		.= "</tr>";
					$shields1 	.= "</tr>";
					$armour1 	.= "</tr>";
					$endtable1 	.= "</table></th></tr></table></td>";

					$info_part2[$fleet_id2] = $weap1.$shields1.$armour1.$endtable1;

					if ($data1['attack']['total'] > 0)
					{
						$html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
						
					}
					else
					{
						$html .= $info_part1[$fleet_id2];
						$html .= $endtable1;
					}
				}
				$html .= "</tr></table>";
				$html .= "<br><br>";
				foreach( $defenders1 as $fleet_id1 => $data2)
				{
					$name = $data2['user']['username'];
					$weap = ($data2['user']['military_tech'] * 10);
					$shie = ($data2['user']['defence_tech'] * 10);
					$armr = ($data2['user']['shield_tech'] * 10);

					$fl_info1  = "<table><tr><th>";
					$fl_info1 .= $lang['sys_attack_defender_pos']." ".$name." ([".$coord4.":".$coord5.":".$coord6."])<br>";
					$fl_info1 .= $lang['sys_ship_weapon']." ".$weap."% - ".$lang['sys_ship_shield']." ".$shie."% - ".$lang['sys_ship_armour']." ".$armr."%";

					$table1  = "<table border=1 align=\"center\">";

					if ($data1['defense']['total'] != 0)
					{
						$ships1  = "<tr><th>".$lang['sys_ship_type']."</th>";
						$count1  = "<tr><th>".$lang['sys_ship_count']."</th>";

						foreach( $data2['def'] as $ship_id1 => $ship_count1)
						{
							if ($ship_count1 != 0)
							{
								$ships1 .= "<th>[ship[".$ship_id1."]]</th>";
								$count1 .= "<th>".pretty_number($ship_count1)."</th>";
							}
						}

						$ships1 .= "</tr>";
						$count1 .= "</tr>";
					}
					else
					{
						$des = 1;
						$ships1 = "<tr><br><br>". $lang['sys_destroyed']."<br></tr>";
						$count1 = "";
					}

					$info_part1[$fleet_id1] = $fl_info1.$table1.$ships1.$count1;
				}



				foreach( $defenders2 as $fleet_id2 => $data3)
				{
					$weap1  	= "<tr><th>".$lang['sys_ship_weapon']."</th>";
					$shields1  	= "<tr><th>".$lang['sys_ship_shield']."</th>";
					$armour1  	= "<tr><th>".$lang['sys_ship_armour']."</th>";

					foreach( $data3 as $ship_id2 => $ship_points1)
					{
						if($ship_points1['shield'] > 0)
						{
							$weap1 .= "<th>".pretty_number($ship_points1['att'])."</th>";
							$shields1 .= "<th>".pretty_number($ship_points1['def'])."</th>";
							$armour1 .= "<th>".pretty_number($ship_points1['shield'])."</th>";
						}
					}

					$weap1 		.= "</tr>";
					$shields1 	.= "</tr>";
					$armour1 	.= "</tr>";
					$endtable1 	.= "</table></th></tr></table>";

					$info_part2[$fleet_id2] = $weap1.$shields1.$armour1.$endtable1;

					if ($data1['defense']['total'] > 0)
					{
						$html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
						$html .= "<br><br>";
					}
					else
					{
						$html .= $info_part1[$fleet_id2];
						$html .= "</table></th></tr></table><br><br>";
					}
				}
				if ($des) break;
				
				$html .=  $lang['fleet_attack_1']." ".pretty_number($data1['attack']['total'])." ".$lang['fleet_attack_2']." ".pretty_number(min($data1['defShield'], $data1['attack']['total']))." ".$lang['damage']."<br>";
				$html .= $lang['fleet_defs_1']." ".pretty_number($data1['defense']['total'])." ".$lang['fleet_defs_2']." ".pretty_number(min($data1['attackShield'], $data1['defense']['total']))." ".$lang['damage']."<br><br>";
				$round_no++;			
			}
		}

		if ($result_array['won'] == "r")
		{
			$result1  = $lang['sys_defender_won']."<br>";
		}
		elseif ($result_array['won'] == "a")
		{
			$result1  = $lang['sys_attacker_won']."<br>";
			$result1 .= $lang['sys_stealed_ressources']." ".pretty_number($steal_array['metal'])." ".$lang['Metal'].", ".pretty_number($steal_array['crystal'])." ".$lang['Crystal']." ".$lang['and']." ".pretty_number($steal_array['deuterium'])." ".$lang['Deuterium']."<br>";
		}
		else
		{
			$result1  = $lang['sys_both_won'].".<br>";
		}

		$html .= "<br><br>";
		$html .= $result1;
		$html .= "<br>";

		$debirs_meta = pretty_number($result_array['debree']['att'][0] + $result_array['debree']['def'][0]);
		$debirs_crys = pretty_number($result_array['debree']['att'][1] + $result_array['debree']['def'][1]);

		$html .= $lang['sys_attacker_lostunits']." ".pretty_number($result_array['lost']['att'])." ".$lang['sys_units']."<br>";
		$html .= $lang['sys_defender_lostunits']." ".pretty_number($result_array['lost']['def'])." ".$lang['sys_units']."<br>";
		$html .= $lang['debree_field_1']." ".$debirs_meta." ".$lang['Metal']." ".$lang['sys_and']." ".$debirs_crys." ".$lang['Crystal']." ".$lang['debree_field_2']."<br><br>";
		
		if($moondes)
		{
			$html .= $moondes;
		} else {
			$html .= $lang['sys_moonproba']." ".$moon_int." %<br>";
			$html .= $moon_string."<br><br>";
		}

		return array('html' => $html, 'bbc' => $bbc);
	}
	
	private static function SpyTarget ($TargetPlanet, $Mode, $TitleString, $FleetRow)
	{
		global $lang, $resource, $db;

		$LookAtLoop = true;
		if ($Mode == 0)
		{
			$String  = "<table width=\"100%\"><tr><td class=\"c\" colspan=\"5\">";
			$String .= $TitleString ." ". $TargetPlanet['name'];
			$String .= " <a href=\"game.php?page=galaxy&mode=3&galaxy=". $TargetPlanet["galaxy"] ."&system=". $TargetPlanet["system"]. "\">";
			$String .= "[". $TargetPlanet["galaxy"] .":". $TargetPlanet["system"] .":". $TargetPlanet["planet"] ."]</a>";
			$String .= " von ". date("d. M Y H:i:s", time() + 2 * 60 * 60) ."</td>";
			$String .= "</tr><tr>";
			$String .= "<td width=220>". $lang['Metal']     ."</td><td width=220 align=right>". pretty_number($TargetPlanet['metal'])      ."</td><td>&nbsp;</td>";
			$String .= "<td width=220>". $lang['Crystal']   ."</td></td><td width=220 align=right>". pretty_number($TargetPlanet['crystal'])    ."</td>";
			$String .= "</tr><tr>";
			$String .= "<td width=220>". $lang['Deuterium'] ."</td><td width=220 align=right>". pretty_number($TargetPlanet['deuterium'])  ."</td><td>&nbsp;</td>";
			$String .= "<td width=220>". $lang['Energy']    ."</td><td width=220 align=right>". pretty_number($TargetPlanet['energy_max']) ."</td>";
			$String .= "</tr>";
			$Array[1]	= $TargetPlanet['metal'];
			$Array[2]	= $TargetPlanet['crystal'];
			$Array[3]	= $TargetPlanet['deuterium'];
			
			$LookAtLoop = false;
		}
		elseif ($Mode == 1)
		{
			$ResFrom[0] = 200;
			$ResTo[0]   = 299;
			$Loops      = 1;
		}
		elseif ($Mode == 2)
		{
			$ResFrom[0] = 400;
			$ResTo[0]   = 499;
			$ResFrom[1] = 500;
			$ResTo[1]   = 599;
			$Loops      = 2;
		}
		elseif ($Mode == 3)
		{
			$ResFrom[0] = 1;
			$ResTo[0]   = 99;
			$Loops      = 1;
		}
		elseif ($Mode == 4)
		{
			$ResFrom[0] = 100;
			$ResTo[0]   = 199;
			$Loops      = 1;
		}
	
		if ($Mode == 1)
		{
			$def = $db->query('SELECT * FROM '.FLEETS.' WHERE `fleet_mission` = 5 AND `fleet_end_galaxy` = '. $FleetRow['fleet_end_galaxy'] .' AND `fleet_end_system` = '. $FleetRow['fleet_end_system'] .' AND `fleet_end_type` = '. $FleetRow['fleet_end_type'] .' AND `fleet_end_planet` = '. $FleetRow['fleet_end_planet'] .' AND fleet_start_time<'.time().' AND fleet_end_stay>='.time().';');
			while ($defRow = $db->fetch($def))
			{
				$defRowDef = explode(';', $defRow['fleet_array']);
				foreach ($defRowDef as $Element)
				{
					$Element = explode(',', $Element);

					if ($Element[0] < 100) continue;

					if (!isset($TargetPlanet[$resource[$Element[0]]]))
						$TargetPlanet[$resource[$Element[0]]] = 0;

					$TargetPlanet[$resource[$Element[0]]] += $Element[1];
				}
			}
		}
		if ($LookAtLoop == true)
		{
			$String  = "<table width=\"100%\" cellspacing=\"1\"><tr><td class=\"c\" colspan=\"". ((2 * SPY_REPORT_ROW) + (SPY_REPORT_ROW - 1))."\">". $TitleString ."</td></tr>";
			$Count       = 0;
			$CurrentLook = 0;
			while ($CurrentLook < $Loops)
			{
				$row     = 0;
				for ($Item = $ResFrom[$CurrentLook]; $Item <= $ResTo[$CurrentLook]; $Item++)
				{
					if ($TargetPlanet[$resource[$Item]] > 0)
					{
						if ($row == 0)
							$String  .= "<tr>";

						$String  .= "<td align=\"left\" width=\"25%\">".$lang['tech'][$Item]."</td><td align=\"right\" width=\"25%\">".$TargetPlanet[$resource[$Item]]."</td>";
						if ($row < SPY_REPORT_ROW - 1)
							

						$Array[$Item]	=  $TargetPlanet[$resource[$Item]];
						$Count	+=  $TargetPlanet[$resource[$Item]];
						$row++;
						if ($row == SPY_REPORT_ROW)
						{
							$String  .= "</tr>";
							$row      = 0;
						} else {
							$String  .= "<td>&nbsp;</td>";
						}
					}
				}

				while ($row != 0)
				{
					$String  .= "<td style=\"display:none;\">&nbsp;</td><td style=\"display:none;\">&nbsp;</td>";
					$row++;
					if ($row == SPY_REPORT_ROW)
					{
						$String  .= "</tr>";
						$row      = 0;
					}
				}
				$CurrentLook++;
			}
		}
		$String .= "</table>";

		$return['String'] = $String;
		$return['Array']  = (is_array($Array)?$Array:array());
		$return['Count']  = $Count;

		return $return;
	}

	private static function RestoreFleetToPlanet ($FleetRow, $Start = true)
	{
		global $resource, $db;

		$FleetRecord         = explode(";", $FleetRow['fleet_array']);
		$QryUpdFleet         = "";
		foreach ($FleetRecord as $Item => $Group)
		{
			if ($Group != '')
			{
				$Class        = explode (",", $Group);
				$QryUpdFleet .= "`". $resource[$Class[0]] ."` = `".$resource[$Class[0]]."` + '".$Class[1]."', \n";
			}
		}

		$QryUpdatePlanet   = "UPDATE ".PLANETS." SET ";
		if ($QryUpdFleet != "")
			$QryUpdatePlanet  .= $QryUpdFleet;

		$QryUpdatePlanet  .= "`metal` = `metal` + '". $FleetRow['fleet_resource_metal'] ."', ";
		$QryUpdatePlanet  .= "`crystal` = `crystal` + '". $FleetRow['fleet_resource_crystal'] ."', ";
		$QryUpdatePlanet  .= "`deuterium` = `deuterium` + '". $FleetRow['fleet_resource_deuterium'] ."' ";
		$QryUpdatePlanet  .= "WHERE ";

		if ($Start == true)
		{
			$QryUpdatePlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
			$QryUpdatePlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
			$QryUpdatePlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
			$QryUpdatePlanet  .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."' ";
		}
		else
		{
			$QryUpdatePlanet  .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
			$QryUpdatePlanet  .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
			$QryUpdatePlanet  .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
			$QryUpdatePlanet  .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
		}
		$QryUpdatePlanet  .= "LIMIT 1;";
		$db->query($QryUpdatePlanet);
	}

	private static function StoreGoodsToPlanet ($FleetRow, $Start = false)
	{
		global $db;
		$QryUpdatePlanet   = "UPDATE ".PLANETS." SET ";
		$QryUpdatePlanet  .= "`metal` = `metal` + '". $FleetRow['fleet_resource_metal'] ."', ";
		$QryUpdatePlanet  .= "`crystal` = `crystal` + '". $FleetRow['fleet_resource_crystal'] ."', ";
		$QryUpdatePlanet  .= "`deuterium` = `deuterium` + '". $FleetRow['fleet_resource_deuterium'] ."' ";
		$QryUpdatePlanet  .= "WHERE ";

		if ($Start == true)
		{
			$QryUpdatePlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
			$QryUpdatePlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
			$QryUpdatePlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
			$QryUpdatePlanet  .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."' ";
		}
		else
		{
			$QryUpdatePlanet  .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
			$QryUpdatePlanet  .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
			$QryUpdatePlanet  .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
			$QryUpdatePlanet  .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
		}

		$QryUpdatePlanet  .= "LIMIT 1;";
		$db->query($QryUpdatePlanet);
	}

	public static function MissionCaseAttack ($FleetRow)
	{
		global $pricelist, $lang, $resource, $CombatCaps, $game_config, $user, $db;

		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] <= time())
		{
			$targetPlanet = $db->fetch_array($db->query("SELECT * FROM ".PLANETS." WHERE `galaxy` = ". $FleetRow['fleet_end_galaxy'] ." AND `system` = ". $FleetRow['fleet_end_system'] ." AND `planet_type` = ". $FleetRow['fleet_end_type'] ." AND `planet` = ". $FleetRow['fleet_end_planet'] .";"));

			if ($FleetRow['fleet_group']> 0)
			{
				$db->query("DELETE FROM ".AKS." WHERE id =".$FleetRow['fleet_group']);
				$db->query("UPDATE ".FLEETS." SET fleet_mess=1 WHERE fleet_group=".$FleetRow['fleet_group'].";");
			}
			else
			{
				$db->query("UPDATE ".FLEETS." SET fleet_mess=1 WHERE fleet_id=".$FleetRow['fleet_id'].";");
			}

			$targetUser   = $db->fetch_array($db->query('SELECT * FROM '.USERS.' WHERE id='.$targetPlanet['id_owner'].";"));
			PlanetResourceUpdate($targetUser, $targetPlanet, time());
			$TargetUserID = $targetUser['id'];
			$attackFleets = array();
			$AttackerRow['id']		= array();
			$AttackerRow['name']	= array();
			$DefenderRow['id']		= array();
			$DefenderRow['name']	= array();

			if ($FleetRow['fleet_group'] != 0)
			{
				$fleets = $db->query('SELECT * FROM '.FLEETS.' WHERE fleet_group='.$FleetRow['fleet_group'].";");
				while ($fleet = $db->fetch($fleets))
				{
					$attackFleets[$fleet['fleet_id']]['fleet'] = $fleet;
					$attackFleets[$fleet['fleet_id']]['user'] = $db->fetch_array($db->query('SELECT id,username,military_tech,defence_tech,shield_tech,rpg_amiral,dm_defensive,dm_attack FROM '.USERS.' WHERE id ='.$fleet['fleet_owner'].";"));
					$attackFleets[$fleet['fleet_id']]['detail'] = array();
					$temp = explode(';', $fleet['fleet_array']);
					foreach ($temp as $temp2)
					{
						$temp2 = explode(',', $temp2);

						if ($temp2[0] < 100) continue;

						if (!isset($attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]]))
							$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] = 0;

						$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
					}
					$AttackerRow['id'][] 	= $attackFleets[$fleet['fleet_id']]['user']['id'];
					$AttackerRow['name'][]	= $attackFleets[$fleet['fleet_id']]['user']['username'];
				}

			}
			else
			{
				$attackFleets[$FleetRow['fleet_id']]['fleet'] = $FleetRow;
				$attackFleets[$FleetRow['fleet_id']]['user'] = $db->fetch_array($db->query('SELECT id,username,military_tech,defence_tech,shield_tech,rpg_amiral,dm_defensive,dm_attack FROM '.USERS.' WHERE id='.$FleetRow['fleet_owner'].";"));
				$attackFleets[$FleetRow['fleet_id']]['detail'] = array();
				$temp = explode(';', $FleetRow['fleet_array']);
				foreach ($temp as $temp2)
				{
					$temp2 = explode(',', $temp2);

					if ($temp2[0] < 100) continue;

					if (!isset($attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]]))
						$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] = 0;

					$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
				}
				$AttackerRow['id'][] 	= $attackFleets[$FleetRow['fleet_id']]['user']['id'];
				$AttackerRow['name'][]	= $attackFleets[$FleetRow['fleet_id']]['user']['username'];
			}
			$defense = array();

			$def = $db->query('SELECT * FROM '.FLEETS.' WHERE `fleet_mission` = 5 AND `fleet_end_galaxy` = '. $FleetRow['fleet_end_galaxy'] .' AND `fleet_end_system` = '. $FleetRow['fleet_end_system'] .' AND `fleet_end_type` = '. $FleetRow['fleet_end_type'] .' AND `fleet_end_planet` = '. $FleetRow['fleet_end_planet'] .' AND fleet_start_time<'.time().' AND fleet_end_stay>='.time().';');
			while ($defRow = $db->fetch($def))
			{
				$defRowDef = explode(';', $defRow['fleet_array']);
				foreach ($defRowDef as $Element)
				{
					$Element = explode(',', $Element);

					if ($Element[0] < 100) continue;

					if (!isset($defense[$defRow['fleet_id']]['def'][$Element[0]]))
						$defense[$defRow['fleet_id']][$Element[0]] = 0;

					$defense[$defRow['fleet_id']]['def'][$Element[0]] += $Element[1];
				}
				$defense[$defRow['fleet_id']]['user'] = $db->fetch_array($db->query('SELECT id,username,military_tech,defence_tech,shield_tech,rpg_amiral,dm_defensive,dm_attack FROM '.USERS.' WHERE id='.$defRow['fleet_owner'],";"));
				$DefenderRow['id'][] 	= $defense[$defRow['fleet_id']]['user']['id'];
				$DefenderRow['name'][]	= $defense[$defRow['fleet_id']]['user']['username'];
			}

			$defense[0]['def'] = array();
			$defense[0]['user'] = $targetUser;
			$DefenderRow['id'][] 	= $defense[0]['user']['id'];
			$DefenderRow['name'][]	= $defense[0]['user']['username'];
			for ($i = 200; $i < 500; $i++)
			{
				if (isset($resource[$i]) && isset($targetPlanet[$resource[$i]]))
				{
					$defense[0]['def'][$i] = $targetPlanet[$resource[$i]];
				}
			}

			$Attacker['id']		= array_unique($AttackerRow['id']);
			$Attacker['name']	= array_unique($AttackerRow['name']);
			$Defender['id']		= array_unique($DefenderRow['id']);
			$Defender['name']	= array_unique($DefenderRow['name']);


			$start 		= microtime(true);
			$result 	= self::calculateAttack($attackFleets, $defense);
			$totaltime 	= microtime(true) - $start;
			
			foreach ($attackFleets as $fleetID => $attacker)
			{
				$fleetArray = '';
				$totalCount = 0;
				foreach ($attacker['detail'] as $element => $amount)
				{
					if ($amount)
						$fleetArray .= $element.','.$amount.';';

					$totalCount += $amount;
				}

				if ($totalCount <= 0)
				{
					$db->query('DELETE FROM '.FLEETS.' WHERE `fleet_id`='.$fleetID.';');
				}
				else
				{	
					$db->query('UPDATE '.FLEETS.' SET fleet_array="'.substr($fleetArray, 0, -1).'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.$fleetID.';');
				}
			}
			if ($result['won'] == "a")
			{	
				if ($FleetRow['fleet_group'] != 0)
					$steal = self::calculateAKSSteal($attackFleets, $FleetRow, $targetPlanet);
				else
					$steal = self::calculateSoloSteal($attackFleets, $FleetRow, $targetPlanet);

			}
			foreach ($defense as $fleetID => $defender)
			{
				if ($fleetID != 0)
				{
					$fleetArray = '';
					$totalCount = 0;

					foreach ($defender['def'] as $element => $amount)
					{
						if ($amount) $fleetArray .= $element.','.$amount.';';
							$totalCount += $amount;
					}

					if ($totalCount <= 0)
					{
						$db->query('DELETE FROM '.FLEETS.' WHERE `fleet_id`='.$fleetID,'fleets');

					}
					else
					{
						$db->query('UPDATE '.FLEETS.' SET fleet_array="'.$fleetArray.'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.$fleetID.';');
					}

				}
				else
				{
					$fleetArray = '';
					$totalCount = 0;

					foreach ($defender['def'] as $element => $amount)
					{
						$fleetArray .= '`'.$resource[$element].'`='.$amount.', ';
					}

					$QryUpdateTarget  = "UPDATE ".PLANETS." SET ";
					$QryUpdateTarget .= $fleetArray;
					$QryUpdateTarget .= "`metal` = `metal` - '". $steal['metal'] ."', ";
					$QryUpdateTarget .= "`crystal` = `crystal` - '". $steal['crystal'] ."', ";
					$QryUpdateTarget .= "`deuterium` = `deuterium` - '". $steal['deuterium'] ."' ";
					$QryUpdateTarget .= "WHERE ";
					$QryUpdateTarget .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
					$QryUpdateTarget .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
					$QryUpdateTarget .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
					$QryUpdateTarget .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
					$QryUpdateTarget .= "LIMIT 1;";
					$db->query($QryUpdateTarget);
				}
			}

			$FleetDebris      = $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
			$StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], $result['lost']['att']);
			$StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], $result['lost']['def']);
			$StrRuins         = sprintf ($lang['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $lang['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $lang['Crystal']);
			$DebrisField      = $StrAttackerUnits ."<br>". $StrDefenderUnits ."<br>". $StrRuins;
			$MoonChance       = min(round($FleetDebris / 100000,0),20);

			$UserChance = ($MoonChance >= 20 || $MoonChance != 0) ? rand(1, 100) : 0;
			
			$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);

			if (($UserChance > 0) && ($UserChance <= $MoonChance) && ($targetPlanet['id_luna'] == 0) && ($targetPlanet['planet_type'] == 1))
			{
				$TargetPlanetName = CreateOneMoonRecord ( $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $TargetUserID, $FleetRow['fleet_start_time'], '', $MoonChance );
				$GottenMoon       = sprintf($lang['sys_moonbuilt'], $TargetPlanetName, $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
				$GottenMoon 	 .= "<br>";
				$DerbisMetal	  = 0;
				$DerbisCrystal	  = 0;
			}
			else
			{
				$GottenMoon 	  = "";
				$DerbisMetal	  = $targetPlanet['der_metal'] 	 + $result['debree']['att'][0] + $result['debree']['def'][0];
				$DerbisCrystal	  = $targetPlanet['der_crystal'] + $result['debree']['att'][1] + $result['debree']['def'][1];
			}

							
			$QryUpdateGalaxy = "UPDATE ".PLANETS." SET ";
			$QryUpdateGalaxy .= "`der_metal` = ".$DerbisMetal.", ";
			$QryUpdateGalaxy .= "`der_crystal` = ".$DerbisCrystal." ";
			$QryUpdateGalaxy .= "WHERE ";
			$QryUpdateGalaxy .= "`galaxy` = '" . $FleetRow['fleet_end_galaxy'] . "' AND ";
			$QryUpdateGalaxy .= "`system` = '" . $FleetRow['fleet_end_system'] . "' AND ";
			$QryUpdateGalaxy .= "`planet` = '" . $FleetRow['fleet_end_planet'] . "' AND ";
			$QryUpdateGalaxy .= "`planet_type` = '1' ";
			$QryUpdateGalaxy .= "LIMIT 1;";
			$db->query($QryUpdateGalaxy);

			$formatted_cr 	= self::GenerateReport($result, $steal, $MoonChance, $GottenMoon, $totaltime);
			
			$WhereAtt = "";
			$WhereDef = "";
			
			foreach($Attacker['id'] as $id)
			{
				$WhereAtt .= "`id` = '".$id."' OR ";
			}
			
			foreach($Defender['id'] as $id)
			{
				$WhereDef .= "`id` = '".$id."' OR ";
			}

			$Won = 0;
			$Lose = 0; 
			$Draw = 0;
			switch($result['won'])
			{
				case "a":
					$Won = 1;
				break;
				case "w":
					$Draw = 1;
				break;
				case "r":
					$Lose = 1;
				break;
			}

			$raport 		= $formatted_cr['html'];
			$rid   			= md5($raport);
			
			$SQLQuery  = "INSERT INTO ".RW." SET ";
			$SQLQuery .= "`time` = '".time()."', ";
			$SQLQuery .= "`owners` = '".implode(',', array_merge($Attacker['id'], $Defender['id']))."', ";
			$SQLQuery .= "`rid` = '". $rid ."', ";
			$SQLQuery .= "`a_zestrzelona` = '".count($result['rounds'])."', ";
			$SQLQuery .= "`raport` = '".$db->sql_escape($raport)."';";
			$SQLQuery .= "INSERT INTO ".TOPKB." SET ";
			$SQLQuery .= "`time` = '".time()."', ";
			$SQLQuery .= "`id_owner1` = '".implode(',', $Attacker['id'])."', ";
			$SQLQuery .= "`angreifer` = '".implode(' & ', $Attacker['name'])."', ";
			$SQLQuery .= "`id_owner2` = '".implode(',', $Defender['id'])."', ";
			$SQLQuery .= "`defender` = '".implode(' & ', $Defender['name'])."', ";
			$SQLQuery .= "`gesamtunits` = '".($result['lost']['att'] + $result['lost']['def'])."', ";
			$SQLQuery .= "`gesamttruemmer` = '".$FleetDebris."', ";
			$SQLQuery .= "`rid` = '". $rid ."', ";
			$SQLQuery .= "`a_zestrzelona` = '".count($result['rounds'])."', ";
			$SQLQuery .= "`raport` = '". $db->sql_escape(preg_replace("/\[(\d+)\:(\d+)\:(\d+)\]/i", "[X:X:X]", $raport)) ."',";
			$SQLQuery .= "`fleetresult` = '". $result['won'] ."';";		
			$SQLQuery .= "UPDATE ".USERS." SET ";
            $SQLQuery .= "`wons` = wons + ".$Won.", ";
            $SQLQuery .= "`loos` = loos + ".$Lose.", ";
            $SQLQuery .= "`draws` = draws + ".$Draw.", ";
            $SQLQuery .= "`kbmetal` = kbmetal + ".($result['debree']['att'][0]+$result['debree']['def'][0]).", ";
            $SQLQuery .= "`kbcrystal` = kbcrystal + ".($result['debree']['att'][1]+$result['debree']['def'][1]).", ";
            $SQLQuery .= "`lostunits` = lostunits + ".$result['lost']['att'].", ";
            $SQLQuery .= "`desunits` = desunits + ".$result['lost']['def']." ";
            $SQLQuery .= "WHERE ";
            $SQLQuery .= substr($WhereAtt, 0, -4).";";
			$SQLQuery .= "UPDATE ".USERS." SET ";
            $SQLQuery .= "`wons` = wons + ". $Lose .", ";
            $SQLQuery .= "`loos` = loos + ". $Won .", ";
            $SQLQuery .= "`draws` = draws + ". $Draw  .", ";
            $SQLQuery .= "`kbmetal` = kbmetal + ".($result['debree']['att'][0]+$result['debree']['def'][0]).", ";
            $SQLQuery .= "`kbcrystal` = kbcrystal + ".($result['debree']['att'][1]+$result['debree']['def'][1]).", ";
            $SQLQuery .= "`lostunits` = lostunits + ".$result['lost']['def'].", ";
            $SQLQuery .= "`desunits` = desunits + ".$result['lost']['att']." ";
            $SQLQuery .= "WHERE ";
            $SQLQuery .= substr($WhereDef, 0, -4).";";
			$db->multi_query($SQLQuery);
			
			switch($result['won'])
			{
				case "r":
					$ColorAtt = "red";
					$ColorDef = "green";
				break;
				case "w":
					$ColorAtt = "orange";
					$ColorDef = "orange";	
				case "a":
					$ColorAtt = "green";
					$ColorDef = "red";
				break;
			}
			
			$MessageAtt = sprintf($lang['sys_mess_attack_report_mess'], $rid, $ColorAtt, $lang['sys_mess_attack_report'], sprintf($lang['sys_adress_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']), $ColorAtt, $lang['sys_perte_attaquant'], pretty_number($result['lost']['att']), $ColorDef, $lang['sys_perte_defenseur'], pretty_number($result['lost']['def']), $lang['sys_gain'], $lang['Metal'], pretty_number($steal['metal']), $lang['Crystal'], pretty_number($steal['crystal']), $lang['Deuterium'], pretty_number($steal['deuterium']), $lang['sys_debris'], $lang['Metal'], pretty_number($result['debree']['att'][0]+$result['debree']['def'][0]), $lang['Crystal'], pretty_number($result['debree']['att'][1]+$result['debree']['def'][1]));
			$MessageDef = sprintf($lang['sys_mess_attack_report_mess'], $rid, $ColorDef, $lang['sys_mess_attack_report'], sprintf($lang['sys_adress_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']), $ColorDef, $lang['sys_perte_attaquant'], pretty_number($result['lost']['att']), $ColorAtt, $lang['sys_perte_defenseur'], pretty_number($result['lost']['def']), $lang['sys_gain'], $lang['Metal'], pretty_number($steal['metal']), $lang['Crystal'], pretty_number($steal['crystal']), $lang['Deuterium'], pretty_number($steal['deuterium']), $lang['sys_debris'], $lang['Metal'], pretty_number($result['debree']['att'][0]+$result['debree']['def'][0]), $lang['Crystal'], pretty_number($result['debree']['att'][1]+$result['debree']['def'][1]));
			
			foreach ($Attacker['id'] as $AttackersID)
			{
				SendSimpleMessage($AttackersID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $MessageAtt);
			}
			foreach ($Defender['id'] as $DefenderID)
			{
				SendSimpleMessage($DefenderID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $MessageDef);
			}
		}
		elseif ($FleetRow['fleet_end_time'] <= time())
		{
			$Message         = sprintf( $lang['sys_fleet_won'],
						$TargetName, GetTargetAdressLink($FleetRow, ''),
						pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],
						pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'],
						pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'] );
			SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
			self::RestoreFleetToPlanet($FleetRow);
			$db->query('DELETE FROM '.FLEETS.' WHERE `fleet_id`='.$FleetRow['fleet_id'].';');
		}
	}
	
	public static function MissionCaseACS($FleetRow)
	{
		global $pricelist, $lang, $resource, $CombatCaps, $game_config, $db;

		if ($FleetRow['fleet_end_time'] <= time())
		{
			$Message         = sprintf( $lang['sys_fleet_won'],
						$TargetName, GetTargetAdressLink($FleetRow, ''),
						pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],
						pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'],
						pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'] );
			SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
			
			self::RestoreFleetToPlanet($FleetRow);
			$db->query('DELETE FROM '.FLEETS.' WHERE `fleet_id`='.$FleetRow['fleet_id'].';');
		}
	}

	public static function MissionCaseTransport($FleetRow)
	{
		global $lang, $db;
		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] <= time())
		{
			$QryStartPlanet   = "SELECT name FROM ".PLANETS." ";
			$QryStartPlanet  .= "WHERE ";
			$QryStartPlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
			$QryStartPlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
			$QryStartPlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
			$QryStartPlanet  .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."';";
			$StartPlanet      = $db->fetch_array($db->query($QryStartPlanet, 'planets'));
			$StartName        = $StartPlanet['name'];
			$StartOwner       = $FleetRow['fleet_owner'];

			$QryTargetPlanet  = "SELECT name,id_owner FROM ".PLANETS." ";
			$QryTargetPlanet .= "WHERE ";
			$QryTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
			$QryTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
			$QryTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
			$QryTargetPlanet .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
			$TargetPlanet     = $db->fetch_array($db->query($QryTargetPlanet, 'planets'));
			$TargetName       = $TargetPlanet['name'];
			$TargetOwner      = $TargetPlanet['id_owner'];


			self::StoreGoodsToPlanet ($FleetRow, false);
			$Message         = sprintf( $lang['sys_tran_mess_owner'],
							$TargetName, GetTargetAdressLink($FleetRow, ''),
							pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],
							pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'],
							pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'] );

			SendSimpleMessage ( $StartOwner, '', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);
			if ($TargetOwner <> $StartOwner)
			{
				$Message         = sprintf( $lang['sys_tran_mess_user'],
									$StartName, GetStartAdressLink($FleetRow, ''),
									$TargetName, GetTargetAdressLink($FleetRow, ''),
									pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],
									pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'],
									pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'] );
				SendSimpleMessage ( $TargetOwner, '', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);
			}

			$QryUpdateFleet  = "UPDATE ".FLEETS." SET ";
			$QryUpdateFleet .= "`fleet_resource_metal` = '0' , ";
			$QryUpdateFleet .= "`fleet_resource_crystal` = '0' , ";
			$QryUpdateFleet .= "`fleet_resource_deuterium` = '0' , ";
			$QryUpdateFleet .= "`fleet_mess` = '1' ";
			$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow['fleet_id'] ."' ";
			$QryUpdateFleet .= "LIMIT 1 ;";
			$db->query($QryUpdateFleet);
		}
		elseif ($FleetRow['fleet_end_time'] <= time())
		{
			$Message           = sprintf ($lang['sys_tran_mess_back'], $StartName, GetStartAdressLink($FleetRow, ''));
			SendSimpleMessage ($FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
			self::RestoreFleetToPlanet($FleetRow);
			$db->query("DELETE FROM ".FLEETS." WHERE fleet_id=" . $FleetRow["fleet_id"].";");
		}
	}

	public static function MissionCaseStay($FleetRow)
	{
		global $lang, $resource, $db;

		if ($FleetRow['fleet_mess'] == 0)
		{
			if ($FleetRow['fleet_start_time'] <= time())
			{
				$QryGetTargetPlanet   = "SELECT * FROM ".PLANETS." ";
				$QryGetTargetPlanet  .= "WHERE ";
				$QryGetTargetPlanet  .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
				$QryGetTargetPlanet  .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
				$QryGetTargetPlanet  .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
				$QryGetTargetPlanet  .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
				$TargetPlanet         = $db->fetch_array($db->query($QryGetTargetPlanet));
				$TargetUserID         = $TargetPlanet['id_owner'];

				$TargetAdress         = sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
				$TargetAddedGoods     = sprintf ($lang['sys_stay_mess_goods'],
				$lang['Metal'], pretty_number($FleetRow['fleet_resource_metal']),
				$lang['Crystal'], pretty_number($FleetRow['fleet_resource_crystal']),
				$lang['Deuterium'], pretty_number($FleetRow['fleet_resource_deuterium']));

				$TargetMessage        = $lang['sys_stay_mess_start'] ."<a href=\"game.php?page=galaxy&mode=3&galaxy=". $FleetRow['fleet_end_galaxy'] ."&system=". $FleetRow['fleet_end_system'] ."\">";
				$TargetMessage       .= $TargetAdress. "</a>". $lang['sys_stay_mess_end'] ."<br>". $TargetAddedGoods;

				SendSimpleMessage($TargetUserID, '', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_qg'], $lang['sys_stay_mess_stay'], $TargetMessage);
				self::RestoreFleetToPlanet($FleetRow, false );
				$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';");
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] <= time())
			{
				$TargetAdress         = sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet']);
				$TargetAddedGoods     = sprintf ($lang['sys_stay_mess_goods'],
				$lang['Metal'], pretty_number($FleetRow['fleet_resource_metal']),
				$lang['Crystal'], pretty_number($FleetRow['fleet_resource_crystal']),
				$lang['Deuterium'], pretty_number($FleetRow['fleet_resource_deuterium']));

				$TargetMessage        = $lang['sys_stay_mess_back'] ."<a href=\"game.php?page=galaxy&mode=3&galaxy=". $FleetRow['fleet_start_galaxy'] ."&system=". $FleetRow['fleet_start_system'] ."\">";
				$TargetMessage       .= $TargetAdress. "</a>". $lang['sys_stay_mess_bend'] ."<br>". $TargetAddedGoods;

				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 5, $lang['sys_mess_qg'], $lang['sys_mess_fleetback'], $TargetMessage);
				self::RestoreFleetToPlanet($FleetRow, true );
				$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';");
			}
		}
	}

	public static function MissionCaseStayAlly($FleetRow)
	{
		global $lang, $db;

		$QryStartPlanet   = "SELECT * FROM ".PLANETS." ";
		$QryStartPlanet  .= "WHERE ";
		$QryStartPlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
		$QryStartPlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
		$QryStartPlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."';";
		$StartPlanet      = $db->fetch_array($db->query($QryStartPlanet));
		$StartName        = $StartPlanet['name'];
		$StartOwner       = $StartPlanet['id_owner'];

		$QryTargetPlanet  = "SELECT * FROM ".PLANETS." ";
		$QryTargetPlanet .= "WHERE ";
		$QryTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
		$QryTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
		$QryTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."';";
		$TargetPlanet     = $db->fetch_array($db->query($QryTargetPlanet));
		$TargetName       = $TargetPlanet['name'];
		$TargetOwner      = $TargetPlanet['id_owner'];

		if ($FleetRow['fleet_mess'] == 0)
		{
			if ($FleetRow['fleet_start_time'] <= time())
			{
				$Message = sprintf($lang['sys_tran_mess_owner'], $TargetName, GetTargetAdressLink($FleetRow, ''),
					$FleetRow['fleet_resource_metal'], $lang['Metal'],
					$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
					$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );

				SendSimpleMessage ($StartOwner, '',$FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);

				$Message = sprintf( $lang['sys_tran_mess_user'], $StartName, GetStartAdressLink($FleetRow, ''),
					$TargetName, GetTargetAdressLink($FleetRow, ''),
					$FleetRow['fleet_resource_metal'], $lang['Metal'],
					$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
					$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );

				SendSimpleMessage ($TargetOwner, '',$FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);

				$QryUpdateFleet  = "UPDATE ".FLEETS." SET ";
				$QryUpdateFleet .= "`fleet_mess` = 2 ";
				$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow['fleet_id'] ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				$db->query( $QryUpdateFleet);

			}
			elseif($FleetRow['fleet_end_stay'] <= time())
			{
				$QryUpdateFleet  = "UPDATE ".FLEETS." SET ";
				$QryUpdateFleet .= "`fleet_mess` = 1 ";
				$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow['fleet_id'] ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				$db->query( $QryUpdateFleet);
			}
		}
		elseif ($FleetRow['fleet_end_time'] < time())
		{
			$Message         = sprintf ($lang['sys_tran_mess_back'], $StartName, GetStartAdressLink($FleetRow, ''));
			SendSimpleMessage ( $StartOwner, '', $FleetRow['fleet_end_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
			self::RestoreFleetToPlanet ( $FleetRow, true );
			$db->query("DELETE FROM ".FLEETS." WHERE fleet_id=" . $FleetRow["fleet_id"]);
		}
	}

	public static function MissionCaseSpy($FleetRow)
	{
		global $lang, $resource, $db;

		if ($FleetRow['fleet_start_time'] <= time() && $FleetRow['fleet_mess'] == 0)
		{
			$CurrentUser         = $db->fetch_array($db->query("SELECT spy_tech,rpg_espion FROM ".USERS." WHERE `id` = '".$FleetRow['fleet_owner']."';"));
			$CurrentUserID       = $FleetRow['fleet_owner'];
			$QryGetTargetPlanet  = "SELECT * FROM ".PLANETS." ";
			$QryGetTargetPlanet .= "WHERE ";
			$QryGetTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
			$QryGetTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
			$QryGetTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
			$QryGetTargetPlanet .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
			$TargetPlanet        = $db->fetch_array($db->query($QryGetTargetPlanet));
			$TargetUserID        = $TargetPlanet['id_owner'];
			$CurrentPlanet       = $db->fetch_array($db->query("SELECT name,system,galaxy,planet FROM ".PLANETS." WHERE `galaxy` = '".$FleetRow['fleet_start_galaxy']."' AND `system` = '".$FleetRow['fleet_start_system']."' AND `planet` = '".$FleetRow['fleet_start_planet']."';"));
			$CurrentSpyLvl       = max(($CurrentUser['spy_tech'] + ($CurrentUser['rpg_espion'] * ESPION)), 1);
			$TargetUser          = $db->fetch_array($db->query("SELECT * FROM ".USERS." WHERE `id` = '".$TargetUserID."';"));
			$TargetSpyLvl        = max(($TargetUser['spy_tech'] + ($TargetUser['rpg_espion'] * ESPION)), 1);
			$fleet               = explode(";", $FleetRow['fleet_array']);
			$fquery              = "";
			
			PlanetResourceUpdate($TargetUser, $TargetPlanet, time());

			foreach ($fleet as $a => $b)
			{
				if ($b != '')
				{
					$a = explode(",", $b);
					if ($a[0] == "210")
					{
						$LS    			  = $a[1];
						$SpyToolDebris    = $LS * 300;
					}
				}
			}
			
			if($LS < 1)
				continue;
			
			$Diffence	 = abs($CurrentSpyLvl - $TargetSpyLvl);
			$MinAmount 	 = ($CurrentSpyLvl >= $TargetSpyLvl) ? (-(pow($Diffence, 2)) + 2) : pow($Diffence, 2) + 2;
			$SpyFleet	 = ($LS >= $MinAmount) ? true : false;
			$SpyDef		 = ($LS >= $MinAmount + 1) ? true : false;
			$SpyBuild	 = ($LS >= $MinAmount + 3) ? true : false;
			$SpyTechno	 = ($LS >= $MinAmount + 5) ? true : false;
			
			
			$MaterialsInfo    	= self::SpyTarget($TargetPlanet, 0, $lang['sys_spy_maretials'], $FleetRow);
			$GetSB	    		= $MaterialsInfo['String'];
			$Array				= $MaterialsInfo['Array'];
			if($SpyFleet){
				$PlanetFleetInfo  = self::SpyTarget($TargetPlanet, 1, $lang['sys_spy_fleet'], $FleetRow);
				$GetSB     		 .= $PlanetFleetInfo['String'];
				$Count['Fleet']	  = $PlanetFleetInfo['Count'];
				$Array			  = $Array + $PlanetFleetInfo['Array'];
			}
			if($SpyDef){
				$PlanetDefenInfo  = self::SpyTarget($TargetPlanet, 2, $lang['sys_spy_defenses'], $FleetRow);
				$GetSB	    	 .= $PlanetDefenInfo['String'];
				$Count['Def']	  = $PlanetDefenInfo['Count'];
				$Array			  = $Array + $PlanetDefenInfo['Array'];
			}
			if($SpyBuild){
				$PlanetBuildInfo  = self::SpyTarget($TargetPlanet, 3, $lang['tech'][0], $FleetRow);
				$GetSB	    	 .= $PlanetBuildInfo['String'];
			}
			if($SpyTechno){
				$TargetTechnInfo  = self::SpyTarget($TargetUser, 4, $lang['tech'][100], $FleetRow);
				$GetSB		  	 .= $TargetTechnInfo['String'];
				$Array			  = $Array + $TargetTechnInfo['Array'];
			}

			foreach($Array as $ID => $Count)
			{
				$string .= "&amp;im[".$ID."]=".$Count;
			}
			
			$TargetChances = rand(0, max(($LS/4) * ($TargetSpyLvl / $CurrentSpyLvl), 100));
			$SpyerChances  = rand(0, 100);
			
			if ($TargetChances >= $SpyerChances && (!empty($Count['Fleet']) && !empty($Count['Fleet'])))
				$DestProba = $lang['sys_mess_spy_destroyed'];
			else
				$DestProba = sprintf( $lang['sys_mess_spy_lostproba'], $TargetChances);

			$AttackLink  = "<center>";
			$AttackLink .= "<a href=\"game.php?page=fleet&amp;galaxy=". $FleetRow['fleet_end_galaxy'] ."&amp;system=". $FleetRow['fleet_end_system'] ."";
			$AttackLink .= "&amp;planet=".$FleetRow['fleet_end_planet']."&amp;planettype=".$FleetRow['fleet_end_type']."";
			$AttackLink .= "&amp;target_mission=1";
			$AttackLink .= " \">". $lang['type_mission'][1];
			$AttackLink .= "</a></center>";
			$MessageEnd  = "<center>".$DestProba."<br>";#<a href=\"game.php?page=battlesim&forbattlesim=".$string."\">Simulieren</a></center>";

			
			$SpyMessage = "<br>".$GetSB."<br>".$AttackLink.$MessageEnd;
			SendSimpleMessage($CurrentUserID, '', $FleetRow['fleet_start_time'], 0, $lang['sys_mess_qg'], $lang['sys_mess_spy_report'], $SpyMessage);

			$TargetMessage  = $lang['sys_mess_spy_ennemyfleet'] ." ". $CurrentPlanet['name'];

			if($FleetRow['fleet_start_type'] == 3)
				$TargetMessage .= $lang['sys_mess_spy_report_moon'] . " ";

			$TargetMessage .= "<a href=\"game.php?page=galaxy&mode=3&galaxy=". $CurrentPlanet["galaxy"] ."&system=". $CurrentPlanet["system"] ."\">";
			$TargetMessage .= "[". $CurrentPlanet["galaxy"] .":". $CurrentPlanet["system"] .":". $CurrentPlanet["planet"] ."]</a> ";
			$TargetMessage .= $lang['sys_mess_spy_seen_at'] ." ". $TargetPlanet['name'];
			$TargetMessage .= " [". $TargetPlanet["galaxy"] .":". $TargetPlanet["system"] .":". $TargetPlanet["planet"] ."] ". $lang['sys_mess_spy_seen_at2'] .".";

			SendSimpleMessage($TargetUserID, '', $FleetRow['fleet_start_time'], 0, $lang['sys_mess_spy_control'], $lang['sys_mess_spy_activity'], $TargetMessage);

			if ($TargetChances >= $SpyerChances)
			{
				$QryUpdateGalaxy  = "UPDATE ".PLANETS." SET ";
				$QryUpdateGalaxy .= "`der_crystal` = `der_crystal` + '". $SpyToolDebris ."' ";
				$QryUpdateGalaxy .= "WHERE `galaxy` = '". $TargetPlanet['galaxy'] ."' AND ";
				$QryUpdateGalaxy .= "`system` = '". $TargetPlanet['system'] ."' AND ";
				$QryUpdateGalaxy .= "`planet` = '". $TargetPlanet['planet'] ."' AND ";
				$QryUpdateGalaxy .= "`planet_type` = '1';";
				
				$db->query($QryUpdateGalaxy);
				$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';");
			}
			else
				$db->query("UPDATE ".FLEETS." SET `fleet_mess` = '1' WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';");
		}
		elseif ($FleetRow['fleet_end_time'] <= time())
		{
			self::RestoreFleetToPlanet ( $FleetRow, true );
			$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
		}
	}

	public static function MissionCaseRecycling ($FleetRow)
	{
		global $pricelist, $lang, $db;

		if ($FleetRow['fleet_start_time'] <= time() && $FleetRow["fleet_mess"] == 0)
		{
			$QrySelectGalaxy  = "SELECT der_metal as metal,der_crystal as crystal FROM ".PLANETS." ";
			$QrySelectGalaxy .= "WHERE ";
			$QrySelectGalaxy .= "`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND ";
			$QrySelectGalaxy .= "`system` = '".$FleetRow['fleet_end_system']."' AND ";
			$QrySelectGalaxy .= "`planet` = '".$FleetRow['fleet_end_planet']."' AND ";
			$QrySelectGalaxy .= "`planet_type` = '1' ";
			$QrySelectGalaxy .= "LIMIT 1;";
			$TargetGalaxy     = $db->fetch_array($db->query($QrySelectGalaxy));

			$FleetRecord         = explode(";", $FleetRow['fleet_array']);
			$RecyclerCapacity    = 0;
			$OtherFleetCapacity  = 0;
			foreach ($FleetRecord as $Item => $Group)
			{
				if ($Group != '')
				{
					$Class        = explode (",", $Group);
					if ($Class[0] == 209 || $Class[0] == 219)
						$RecyclerCapacity   += $pricelist[$Class[0]]["capacity"] * $Class[1];
					else
						$OtherFleetCapacity += $pricelist[$Class[0]]["capacity"] * $Class[1];
				}
			}

			$IncomingFleetGoods = $FleetRow["fleet_resource_metal"] + $FleetRow["fleet_resource_crystal"] + $FleetRow["fleet_resource_deuterium"];
			if ($IncomingFleetGoods> $OtherFleetCapacity)
				$RecyclerCapacity -= ($IncomingFleetGoods - $OtherFleetCapacity);

			if (($TargetGalaxy["metal"] + $TargetGalaxy["crystal"]) <= $RecyclerCapacity)
			{
				$RecycledGoods["metal"]   = $TargetGalaxy["metal"];
				$RecycledGoods["crystal"] = $TargetGalaxy["crystal"];
			}
			else
			{
				if (($TargetGalaxy["metal"]  > $RecyclerCapacity / 2) && ($TargetGalaxy["crystal"]> $RecyclerCapacity / 2))
				{
					$RecycledGoods["metal"]   = $RecyclerCapacity / 2;
					$RecycledGoods["crystal"] = $RecyclerCapacity / 2;
				}
				else
				{
					if ($TargetGalaxy["metal"]> $TargetGalaxy["crystal"])
					{
						$RecycledGoods["crystal"] = $TargetGalaxy["crystal"];
						if ($TargetGalaxy["metal"]> ($RecyclerCapacity - $RecycledGoods["crystal"]))
							$RecycledGoods["metal"] = $RecyclerCapacity - $RecycledGoods["crystal"];
						else
							$RecycledGoods["metal"] = $TargetGalaxy["metal"];
					}
					else
					{
						$RecycledGoods["metal"] = $TargetGalaxy["metal"];
						if ($TargetGalaxy["crystal"]> ($RecyclerCapacity - $RecycledGoods["metal"]))
							$RecycledGoods["crystal"] = $RecyclerCapacity - $RecycledGoods["metal"];
						else
							$RecycledGoods["crystal"] = $TargetGalaxy["crystal"];
					}
				}
			}

			$QryUpdateGalaxy  = "UPDATE ".PLANETS." SET ";
			$QryUpdateGalaxy .= "`der_metal` = `der_metal` - '".$RecycledGoods["metal"]."', ";
			$QryUpdateGalaxy .= "`der_crystal` = `der_crystal` - '".$RecycledGoods["crystal"]."' ";
			$QryUpdateGalaxy .= "WHERE ";
			$QryUpdateGalaxy .= "`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND ";
			$QryUpdateGalaxy .= "`system` = '".$FleetRow['fleet_end_system']."' AND ";
			$QryUpdateGalaxy .= "`planet` = '".$FleetRow['fleet_end_planet']."' AND ";
			$QryUpdateGalaxy .= "`planet_type` = '1' ";
			$QryUpdateGalaxy .= "LIMIT 1;";
			$QryUpdateGalaxy .= "UPDATE ".FLEETS." SET ";
			$QryUpdateGalaxy .= "`fleet_resource_metal` = `fleet_resource_metal` + '".$RecycledGoods["metal"]."', ";
			$QryUpdateGalaxy .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '".$RecycledGoods["crystal"]."', ";
			$QryUpdateGalaxy .= "`fleet_mess` = '1' ";
			$QryUpdateGalaxy .= "WHERE ";
			$QryUpdateGalaxy .= "`fleet_id` = '".$FleetRow['fleet_id']."' ";
			$QryUpdateGalaxy .= "LIMIT 1;";
			$db->multi_query($QryUpdateGalaxy);

			$Message = sprintf($lang['sys_recy_gotten'], pretty_number($RecycledGoods["metal"]), $lang['Metal'], pretty_number($RecycledGoods["crystal"]), $lang['Crystal']);
			SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 4, $lang['sys_mess_spy_control'], $lang['sys_recy_report'], $Message);
		}
		elseif($FleetRow['fleet_end_time'] <= time()) {
			$Message         = sprintf( $lang['sys_tran_mess_owner'], $TargetName, GetTargetAdressLink($FleetRow, ''), pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'], pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'], pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'] );
			SendSimpleMessage($FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 4, $lang['sys_mess_spy_control'], $lang['sys_mess_fleetback'], $Message);
			self::RestoreFleetToPlanet($FleetRow);
			$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';");
		}
	}

	public static function MissionCaseColonisation($FleetRow)
	{
		global $lang, $resource, $db;

		if ($FleetRow['fleet_start_time'] <= time() && $FleetRow["fleet_mess"] == 0)
		{
			$iPlanetCount 	= $db->fetch_array($db->query("SELECT count(*) as kolo FROM ".PLANETS." WHERE `id_owner` = '". $FleetRow['fleet_owner'] ."' AND `planet_type` = '1' AND `destruyed` = '0';"));
			$iGalaxyPlace 	= $db->fetch_array($db->query("SELECT count(*) AS plani FROM ".PLANETS." WHERE `galaxy` = '". $FleetRow['fleet_end_galaxy']."' AND `system` = '". $FleetRow['fleet_end_system']."' AND `planet` = '". $FleetRow['fleet_end_planet']."';"));
			$PlayerTech		= $db->fetch_array($db->query("SELECT ".$resource[124]." FROM ".USERS." WHERE `id` = '".$FleetRow['fleet_owner']."';"));
			$TargetAdress 	= sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
			if ($iGalaxyPlace['plani'] == 0)
			{
				if ($iPlanetCount['kolo'] >= STANDART_PLAYER_PLANETS + ceil($PlayerTech[$resource[124]] / 2))
				{
					$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_maxcolo'] . (STANDART_PLAYER_PLANETS + ceil($PlayerTech[$resource[124]] / 2)) . $lang['sys_colo_planet'];
					SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 4, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
					$db->query("UPDATE ".FLEETS." SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"].";");
				}
				else
				{
					$NewOwnerPlanet = CreateOnePlanetRecord($FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $FleetRow['fleet_owner'], $lang['sys_colo_defaultname'], false);
					if($NewOwnerPlanet == true )
					{
						$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_allisok'];
						SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 4, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
						self::StoreGoodsToPlanet($FleetRow);
						if ($FleetRow['fleet_amount'] == 1)
							$db->query("DELETE FROM ".FLEETS." WHERE fleet_id=" . $FleetRow["fleet_id"].";");
						else
						{
							$CurrentFleet = explode(";", $FleetRow['fleet_array']);
							$NewFleet     = "";
							foreach ($CurrentFleet as $Item => $Group)
							{
								if ($Group != '')
								{
									$Class = explode (",", $Group);
									if ($Class[0] == 208)
									{
										if ($Class[1]> 1)
										{
											$NewFleet  .= $Class[0].",".($Class[1] - 1).";";
										}
									}
									else
									{
										if ($Class[1] <> 0)
										{
											$NewFleet  .= $Class[0].",".$Class[1].";";
										}
									}
								}
							}
							$QryUpdateFleet  = "UPDATE ".FLEETS." SET ";
							$QryUpdateFleet .= "`fleet_array` = '". $NewFleet ."', ";			
							$QryUpdateFleet .= "`fleet_amount` = `fleet_amount` - 1, ";
							$QryUpdateFleet .= "`fleet_resource_metal` = '0' , ";
							$QryUpdateFleet .= "`fleet_resource_crystal` = '0' , ";
							$QryUpdateFleet .= "`fleet_resource_deuterium` = '0' , ";
							$QryUpdateFleet .= "`fleet_mess` = '1' ";
							$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow['fleet_id'] ."' ";
							$QryUpdateFleet .= "LIMIT 1 ;";
							$db->query($QryUpdateFleet);
						}
					}
					else
					{
						$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_badpos'];
						SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 4, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
						$db->query("UPDATE ".FLEETS." SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"].";");
					}
				}
			}
			else
			{
				$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_notfree'];
				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 4, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
				$db->query("UPDATE ".FLEETS." SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"].";");
			}
		}
		elseif ($FleetRow['fleet_end_time'] < time())
		{
			self::RestoreFleetToPlanet ( $FleetRow, true );
			$db->query("DELETE FROM ".FLEETS." WHERE fleet_id=" . $FleetRow["fleet_id"].";");
		}
	}
	
	public static function MissionCaseDestruction($FleetRow)
	{
		global $user, $pricelist, $lang, $resource, $CombatCaps, $db;

	    includeLang('INGAME');
		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] <= time())
		{
				$targetPlanet = $db->fetch_array($db->query("SELECT * FROM ".PLANETS." WHERE `galaxy` = ". $FleetRow['fleet_end_galaxy'] ." AND `system` = ". $FleetRow['fleet_end_system'] ." AND `planet_type` = ". $FleetRow['fleet_end_type'] ." AND `planet` = ". $FleetRow['fleet_end_planet'] .";"));
				$targetUser   = $db->fetch_array($db->query("SELECT * FROM ".USERS." WHERE `id` = '".$targetPlanet['id_owner']."';"));
				$TargetUserID = $targetUser['id'];
				$attackFleets = array();

				if ($FleetRow['fleet_group'] != 0)
				{
					$fleets = $db->query('SELECT * FROM '.FLEETS.' WHERE fleet_group='.$FleetRow['fleet_group'].';');
					while ($fleet = $db->fetch($fleets))
					{
						$attackFleets[$fleet['fleet_id']]['fleet'] = $fleet;
						$attackFleets[$fleet['fleet_id']]['user'] = $db->fetch_array($db->query('SELECT * FROM '.USERS.' WHERE id ='.$fleet['fleet_owner'].';'));
						$attackFleets[$fleet['fleet_id']]['detail'] = array();
						$temp = explode(';', $fleet['fleet_array']);
						foreach ($temp as $temp2)
						{
							$temp2 = explode(',', $temp2);

							if ($temp2[0] < 100) continue;

							if (!isset($attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]]))
								$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] = 0;

							$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
						}
					}

				}
				else
				{
					$attackFleets[$FleetRow['fleet_id']]['fleet'] = $FleetRow;
					$attackFleets[$FleetRow['fleet_id']]['user'] = $db->fetch_array($db->query('SELECT * FROM '.USERS.' WHERE id ='.$FleetRow['fleet_owner'].';'));
					$attackFleets[$FleetRow['fleet_id']]['detail'] = array();
					$temp = explode(';', $FleetRow['fleet_array']);
					foreach ($temp as $temp2)
					{
						$temp2 = explode(',', $temp2);

						if ($temp2[0] < 100) continue;

						if (!isset($attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]]))
							$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] = 0;

						$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
					}
				}
				$defense = array();

				$def = $db->query('SELECT * FROM '.FLEETS.' WHERE `fleet_end_galaxy` = '. $FleetRow['fleet_end_galaxy'] .' AND `fleet_end_system` = '. $FleetRow['fleet_end_system'] .' AND `fleet_end_type` = '. $FleetRow['fleet_end_type'] .' AND `fleet_end_planet` = '. $FleetRow['fleet_end_planet'] .' AND fleet_start_time<'.time().' AND fleet_end_stay>='.time().';');
				while ($defRow = $db->fetch($def))
				{
					$defRowDef = explode(';', $defRow['fleet_array']);
					foreach ($defRowDef as $Element)
					{
						$Element = explode(',', $Element);

						if ($Element[0] < 100) continue;

						if (!isset($defense[$defRow['fleet_id']]['def'][$Element[0]]))
							$defense[$defRow['fleet_id']][$Element[0]] = 0;

						$defense[$defRow['fleet_id']]['def'][$Element[0]] += $Element[1];
						$defense[$defRow['fleet_id']]['user'] = $db->fetch_array($db->query('SELECT * FROM '.USERS.' WHERE id='.$defRow['fleet_owner'].';'));
					}
				}

				$defense[0]['def'] = array();
				$defense[0]['user'] = $targetUser;
				for ($i = 200; $i < 500; $i++)
				{
					if (isset($resource[$i]) && isset($targetPlanet[$resource[$i]]))
					{
						$defense[0]['def'][$i] = $targetPlanet[$resource[$i]];
					}
				}
				$start 		= microtime(true);
				$result 	= self::calculateAttack($attackFleets, $defense);
				$totaltime 	= microtime(true) - $start;

				$QryUpdateGalaxy = "UPDATE ".PLANETS." SET ";
				$QryUpdateGalaxy .= "`der_metal` = `der_metal` +'".($result['debree']['att'][0]+$result['debree']['def'][0]) . "', ";
				$QryUpdateGalaxy .= "`der_crystal` = `der_crystal` + '" .($result['debree']['att'][1]+$result['debree']['def'][1]). "' ";
				$QryUpdateGalaxy .= "WHERE ";
				$QryUpdateGalaxy .= "`galaxy` = '" . $FleetRow['fleet_end_galaxy'] . "' AND ";
				$QryUpdateGalaxy .= "`system` = '" . $FleetRow['fleet_end_system'] . "' AND ";
				$QryUpdateGalaxy .= "`planet` = '" . $FleetRow['fleet_end_system'] . "' AND ";
				$QryUpdateGalaxy .= "`planet_type` = '1' ";
				$QryUpdateGalaxy .= "LIMIT 1;";
				$db->query($QryUpdateGalaxy);

				foreach ($attackFleets as $fleetID => $attacker)
				{
					$fleetArray = '';
					$totalCount = 0;
					foreach ($attacker['detail'] as $element => $amount)
					{
						if ($amount)
							$fleetArray .= $element.','.$amount.';';

						$totalCount += $amount;
					}

					if ($totalCount <= 0)
					{
						$db->query('DELETE FROM '.FLEETS.' WHERE `fleet_id`='.$fleetID.';');
					}
					else
					{
						$db->query('UPDATE '.FLEETS.' SET fleet_array="'.substr($fleetArray, 0, -1).'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.$fleetID.';');
					}
				}

				foreach ($defense as $fleetID => $defender)
				{
					if ($fleetID != 0)
					{
						$fleetArray = '';
						$totalCount = 0;

						foreach ($defender['def'] as $element => $amount)
						{
							if ($amount) $fleetArray .= $element.','.$amount.';';
								$totalCount += $amount;
						}

						if ($totalCount <= 0)
						{
							$db->query('DELETE FROM '.FLEETS.' WHERE `fleet_id`="'.$fleetID.'";');

						}
						else
						{
							$db->query('UPDATE '.FLEETS.' SET fleet_array="'.$fleetArray.'", fleet_amount="'.$totalCount.'", fleet_mess="1" WHERE fleet_id='.$fleetID.';');
						}

					}
					else
					{
						$fleetArray = '';
						$totalCount = 0;

						foreach ($defender['def'] as $element => $amount)
						{
							$fleetArray .= "`".$resource[$element]."` = '".$amount."', ";
						}
						$QryUpdateTarget  = "UPDATE ".PLANETS." SET ";
						$QryUpdateTarget .= substr($fleetArray, 0, -2);
						$QryUpdateTarget .= "WHERE ";
						$QryUpdateTarget .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
						$QryUpdateTarget .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
						$QryUpdateTarget .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
						$QryUpdateTarget .= "`planet_type` = '3' ";
						$QryUpdateTarget .= "LIMIT 1;";
						$db->query($QryUpdateTarget);
					}
				}

				$FleetDebris      = $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
				$StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], $result['lost']['att']);
				$StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], $result['lost']['def']);
				$StrRuins         = sprintf ($lang['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $lang['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $lang['Crystal']);
				$DebrisField      = $StrAttackerUnits ."<br>". $StrDefenderUnits ."<br>". $StrRuins;
				$steal 			  = array('metal' => 0, 'crystal' => 0, 'deuterium' => 0);
				switch ($result['won']) {
					case "a":
						$max_resources = 0;
						foreach ($attackFleets[$FleetRow['fleet_id']]['detail'] as $Element => $amount) {
							$max_resources += $pricelist[$Element]['capacity'] * $amount;
						}
						
						if ($max_resources> 0) {
							$metal   = $targetPlanet['metal'] / 2;
							$crystal = $targetPlanet['crystal'] / 2;
							$deuter  = $targetPlanet['deuterium'] / 2;
							if ($deuter> $max_resources / 3) {
								$steal['deuterium']     = $max_resources / 3;
								$max_resources        -= $steal['deuterium'];
							} else {
								$steal['deuterium']     = $deuter;
								$max_resources        -= $steal['deuterium'];
							}
							
							if ($crystal> $max_resources / 2) {
								$steal['crystal'] = $max_resources / 2;
								$max_resources   -= $steal['crystal'];
							} else {
								$steal['crystal'] = $crystal;
								$max_resources   -= $steal['crystal'];
							}
							
							if ($metal> $max_resources) {
								$steal['metal']         = $max_resources;
								$max_resources         = $max_resources - $steal['metal'];
							} else {
								$steal['metal']         = $metal;
								$max_resources        -= $steal['metal'];
							}            
						}
						
						$steal = array_map('round', $steal);

						$QryUpdateFleet  = 'UPDATE '.FLEETS.' SET ';
						$QryUpdateFleet .= '`fleet_resource_metal` = `fleet_resource_metal` + '. $steal['metal'] .', ';
						$QryUpdateFleet .= '`fleet_resource_crystal` = `fleet_resource_crystal` +'. $steal['crystal'] .', ';
						$QryUpdateFleet .= '`fleet_resource_deuterium` = `fleet_resource_deuterium` +'. $steal['deuterium'] .' ';
						$QryUpdateFleet .= 'WHERE fleet_id = '. $FleetRow['fleet_id'] .' ';
						$QryUpdateFleet .= 'LIMIT 1 ;';
						$db->query( $QryUpdateFleet);

						$QryUpdateTarget  = "UPDATE ".PLANETS." SET ";
						$QryUpdateTarget .= $fleetArray;
						$QryUpdateTarget .= "`metal` = `metal` - '". $steal['metal'] ."', ";
						$QryUpdateTarget .= "`crystal` = `crystal` - '". $steal['crystal'] ."', ";
						$QryUpdateTarget .= "`deuterium` = `deuterium` - '". $steal['deuterium'] ."' ";
						$QryUpdateTarget .= "WHERE ";
						$QryUpdateTarget .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
						$QryUpdateTarget .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
						$QryUpdateTarget .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
						$QryUpdateTarget .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
						$QryUpdateTarget .= "LIMIT 1;";
						$db->query($QryUpdateTarget);
						$destructionl2 	= round((100 - sqrt($targetPlanet['diameter'])) * sqrt($attackFleets[$FleetRow['fleet_id']]['detail'][214]), 1);
						$chance2  		= round(sqrt($TargetPlanet['diameter'])/2);                 
						
						if ($destructionl2 > 100) {
							$chance = 100;
						} elseif ($destructionl2 < 0) {
							$chance = 0;
						} else {
							$chance = $destructionl2;
						}
						$tirage 		= rand(0, 100);
						$tirage2  		= rand(0, 100);

						if($tirage <= $chance)   {
							$db->query("DELETE FROM ".PLANETS." WHERE `id` = '". $targetPlanet['id'] ."';");
							$Qrydestructionlune2  = "UPDATE ".PLANETS." SET ";
							$Qrydestructionlune2 .= "`id_luna` = '0' ";
							$Qrydestructionlune2 .= "WHERE ";
							$Qrydestructionlune2 .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
							$Qrydestructionlune2 .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
							$Qrydestructionlune2 .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' ";
							$Qrydestructionlune2 .= "LIMIT 1 ;";
							$db->query($Qrydestructionlune2);
							$destext .= sprintf ($lang['sys_destruc_mess'], $DepName , $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'])."<br>";
							$destext .= sprintf ($lang['sys_destruc_lune'], $chance) ."<br>";
							$destext .= $lang['sys_destruc_mess1'];
							$destext .= $lang['sys_destruc_reussi'];

							$probarip = sprintf ($lang['sys_destruc_rip'], $chance2);
							if($tirage2 <= $chance2) {
								$destext .= $lang['sys_destruc_echec'];
								$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';");
							}
						} else {
					        $destructionrip = sqrt($TargetPlanet['diameter'])/2;
							$chance2  = round($destructionrip);                 
							$tirage2  = rand(0, 100);
							$probarip = sprintf ($lang['sys_destruc_rip'], $chance2);
							$destext .= sprintf ($lang['sys_destruc_mess'], $DepName , $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'])."<br>";
							$destext .= $lang['sys_destruc_mess1'];
							$destext .= sprintf ($lang['sys_destruc_lune'], $chance) ."<br>";
							if($tirage2 <= $chance2) {
								$destext .= $lang['sys_destruc_echec'];
								$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';");
							} else {
								$destext .= $lang['sys_destruc_stop'];							
							}
						}
					break;
				case "r":
					$destext 		  .= sprintf ($lang['sys_destruc_mess'], $DepName , $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'])."<br>";
					$destext 		  .= $lang['sys_destruc_stop'] ."<br>";
					$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';");
					break;
				case "w":
					$destext 		  .= sprintf ($lang['sys_destruc_mess'], $DepName , $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'])."<br>";
					$destext 		  .= $lang['sys_destruc_stop'] ."<br>";
					break;
				default:
					break;
				}

				$MoonChance       = 0;
				$GottenMoon 	  = "";
				$formatted_cr 	  = self::GenerateReport($result,$steal,$MoonChance,$GottenMoon,$totaltime,$destext);
				$raport 		  = $formatted_cr['html'];
				$rid   = md5($raport);
				$QryInsertRapport  = 'INSERT INTO '.RW.' SET ';
				$QryInsertRapport .= '`time` = UNIX_TIMESTAMP(), ';
				foreach ($attackFleets as $fleetID => $attacker)
				{
					$users2[$attacker['user']['id']] = $attacker['user']['id'];
				}

				foreach ($defense as $fleetID => $defender)
				{
					$users2[$defender['user']['id']] = $defender['user']['id'];
				}
				$QryInsertRapport .= '`owners` = "'.implode(',', $users2).'", ';
				$QryInsertRapport .= '`rid` = "'. $rid .'", ';
				$QryInsertRapport .= '`raport` = "'. $db->sql_escape($raport) .'"';
				$db->query($QryInsertRapport);

				$raport  = '<a href # OnClick=\'f( "CombatReport.php?raport='. $rid .'", "");\'>';
				$raport .= '<center>';

				if     ($result['won'] == "a")
				{
					$raport .= '<font color=\'green\'>';
				}
				elseif ($result['won'] == "w")
				{
					$raport .= '<font color=\'orange\'>';
				}
				elseif ($result['won'] == "r")
				{
					$raport .= '<font color=\'red\'>';
				}

				$raport .= $lang['sys_mess_destruc_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."] </font></a><br><br>";
				$raport .= "<font color=\"red\">". $lang['sys_perte_attaquant'] .": ". $result['lost']['att'] ."</font>";
				$raport .= "<font color=\"green\">   ". $lang['sys_perte_defenseur'] .": ". $result['lost']['def'] ."</font><br>" ;
				$raport .= $lang['sys_debris'] ." ". $lang['Metal'] .":<font color=\"#adaead\">". ($result['debree']['att'][0]+$result['debree']['def'][0]) ."</font>   ". $lang['Crystal'] .":<font color=\"#ef51ef\">".( $result['debree']['att'][1]+$result['debree']['def'][1]) ."</font><br></center>";
				SendSimpleMessage($FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport );


				$raport2  = "<a href # OnClick=\"f( 'CombatReport.php?raport=". $rid ."', '');\">";
				$raport2 .= "<center>";

				if	   ($result['won'] == "a")
				{
					$raport2 .= '<font color=\'red\'>';
				}
				elseif ($result['won'] == "w")
				{
					$raport2 .= '<font color=\'orange\'>';
				}
				elseif ($result['won'] == "r")
				{
					$raport2 .= '<font color=\'green\'>';
				}

				$raport2 .= $lang['sys_mess_destruc_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."] </font></a><br><br>";

				SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_destruc_report'], $raport2 );
	    } elseif ($FleetRow['fleet_end_time'] <= time()) {
			$fquery 		= "";
			$Message		= sprintf( $lang['sys_fleet_won'], $TargetName, GetTargetAdressLink($FleetRow, ''),pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'],pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'] );
			SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
			self::RestoreFleetToPlanet($FleetRow);
			$db->query('DELETE FROM '.FLEETS.' WHERE `fleet_id`='.$FleetRow['fleet_id'].';');
		}

	}

	public static function MissionCaseMIP ($FleetRow)
	{
		global $user, $pricelist, $lang, $resource, $CombatCaps, $db, $reslist;

		if ($FleetRow['fleet_start_time'] <= time() && $FleetRow['fleet_mess'] == 0)
		{
			$SQL = "";
			foreach($reslist['defense'] as $Element)
			{
				$SQL	.= PLANETS.".".$resource[$Element].", ";
			}
			
			$QryTarget		 	= "SELECT ".USERS.".defence_tech, ".PLANETS.".id, ".PLANETS.".id_owner, ".substr($SQL, 0, -2)."
								   FROM ".PLANETS.", ".USERS."
								   WHERE ".PLANETS.".`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND 
								   ".PLANETS.".`system` = '".$FleetRow['fleet_end_system']."' AND 
								   ".PLANETS.".`planet` = '".$FleetRow['fleet_end_planet']."' AND 
								   ".PLANETS.".`planet_type` = '1' AND 
								   ".PLANETS.".id_owner = ".USERS.".id;";
								   
			$TargetInfo			= $db->fetch_array($db->query($QryTarget));					   
			$OwnerInfo			= $db->fetch_array($db->query("SELECT `military_tech` FROM ".USERS." WHERE `id` = '".$FleetRow['fleet_owner']."';"));					   
			$Target				= (!in_array($FleetRow['fleet_target_obj'], $reslist['defense']) || $FleetRow['fleet_target_obj'] == 502 || $FleetRow['fleet_target_obj'] == 0) ? 401 : $FleetRow['fleet_target_obj'];
			foreach($reslist['defense'] as $Element)		
			{
				$TargetDefensive[$Element]	= $TargetInfo[$resource[$Element]];
			}

			$message 			= "";
			$sql 				= "";
			
			if ($TargetInfo[$resource[502]] >= $FleetRow['fleet_amount'])
			{
				$message 	= $lang['sys_irak_no_att'];
				$x 		 	= $resource[502];
				$sql .= "UPDATE ".PLANETS." SET " . $x . " = " . $x . "-" . $FleetRow['fleet_amount'] . " WHERE id = " . $TargetInfo['id'].";";
			}
			else
			{
				if ($TargetInfo[$resource[502]] > 0)
				{
					$db->query("UPDATE ".PLANETS." SET " . $resource[502] . " = '0'  WHERE id = " . $TargetInfo['id'].";");
					$message .= sprintf($lang['sys_irak_def'], $TargetInfo[$resource[502]]);
				}
				
				$irak = self::calculateMIPAttack($TargetInfo["defence_tech"], $OwnerInfo["military_tech"], $FleetRow['fleet_amount'], $TargetDefensive, $Target, $TargetInfo[$resource[502]]);
				ksort($irak, SORT_NUMERIC);
				$Count = 0;
				foreach ($irak as $id => $destroy)
				{
					if ($id != 502)
						$message .= $lang['tech'][$id] . " (- " . $destroy . ")<br>";

					$x 		= $resource[$id];
					$x1 	= $x ."-". $destroy;
					$sql 	.= "UPDATE ".PLANETS." SET " . $x . " = " . $x1 . " WHERE id = " . $TargetInfo['id'].";";
				}
			}
				
			$UserPlanet 		= $db->fetch_array($db->query("SELECT name FROM ".PLANETS." WHERE id = '" . $FleetRow['fleet_owner'] . "';"));
			$OwnerLink			= $UserPlanet['name']."[".$FleetRow['fleet_start_galaxy'].":".$FleetRow['fleet_start_system'].":".$FleetRow['fleet_start_planet']."]";
			$TargetLink 		= $TargetInfo['name']."[".$FleetRow['fleet_end_galaxy'].":".$FleetRow['fleet_end_system'].":".$FleetRow['fleet_end_planet']."]";;
			$Message			= sprintf($lang['sys_irak_mess'], $FleetRow['fleet_amount'], $OwnerLink, $TargetLink).(empty($message) ? $lang['sys_irak_no_def'] : $message);
		
			SendSimpleMessage($FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_irak_subject'] , $Message);
			SendSimpleMessage($TargetInfo['id_owner'], '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_irak_subject'] , $Message);
			$sql				.= "DELETE FROM ".FLEETS." WHERE fleet_id = '" . $FleetRow['fleet_id'] . "';";
			$db->multi_query($sql);
		}
	}

	public static function MissionCaseExpedition($FleetRow)
	{
		// Rewrite on 28.02.10 by ShadoX for 2Moons (http://www.titanspace.org)
		global $lang, $resource, $pricelist, $db, $reslist, $game_config;

		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_end_stay'] < time())
		{
			foreach($reslist['fleet'] as $ID)
			{
				$Expowert[$ID]	= ($pricelist[$ID]['metal'] + $pricelist[$ID]['crystal']) / 1000;
			}
			
			$Expowert[202] = 12;
			$Expowert[203] = 47;
			$Expowert[204] = 12;
			$Expowert[205] = 110;
			$Expowert[206] = 47;
			$Expowert[207] = 160;
			
			$farray 			= explode(";", $FleetRow['fleet_array']);
			$FleetPoints 		= 0;
			$FleetCapacity		= 0;
			
			foreach ($farray as $Item => $Group)
			{
				if (empty($Group)) continue;
			
				$Class 						= explode (",", $Group);
				$FleetCount[$Class[0]]		= $Class[1];
				$FleetCapacity 			   += $Class[1] * $pricelist[$Class[0]]['capacity'];
				$FleetPoints   			   += $Class[1] * $Expowert[$Class[0]];			
			}
			
			$FleetCapacity     -= $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'] + $FleetRow['fleet_resource_darkmatter'];
					
			
			$GetEvent	= rand(1, 20);
			
			switch($GetEvent)
			{
				case 1:
				case 9:
				case 11:
				case 20:
					$WitchFound	= rand(1,3);
					
					$FindSize = rand(0, 100);
					if(10 < $FindSize) {
						$WitchSize	= 1;
						$Factor 	= (rand(10, 50) / $WitchFound) * $game_config['resource_multiplier'];
						$Message	= $lang['sys_expe_found_ress_1_'.rand(1,4)];
					} elseif(0 < $FindSize && 10 >= $FindSize) {
						$WitchSize	= 2;
						$Factor 	= (rand(52, 100) / $WitchFound) * $game_config['resource_multiplier'];
						$Message	= $lang['sys_expe_found_ress_2_'.rand(1,3)];
					} elseif(0 == $FindSize) {
						$WitchSize	= 3;
						$Factor 	= (rand(102, 200) / $WitchFound) * $game_config['resource_multiplier'];
						$Message	= $lang['sys_expe_found_ress_3_'.rand(1,2)];
					}	
					$StatFactor = $db->fetch_array($db->query("SELECT MAX(total_points) as total FROM `".STATPOINTS."` WHERE `stat_type` = 1;"));
					
					if($StatFactor['total'] < 5000000)
						$MaxPoints = 9000;
					else
						$MaxPoints = 12000;
					
				
					$Size			= min($Factor * MAX(MIN($FleetPoints / 1000, $MaxPoints), 200),$FleetCapacity);
					
					$QryUpdateFleet  = "UPDATE ".FLEETS." SET ";
					$QryUpdateFleet .= ($WitchFound == 1) ? "`fleet_resource_metal` = `fleet_resource_metal` + '".$Size."', ":"";
					$QryUpdateFleet .= ($WitchFound == 2) ? "`fleet_resource_crystal` = `fleet_resource_crystal` + '".$Size."', ":"";
					$QryUpdateFleet .= ($WitchFound == 3) ? "`fleet_resource_deuterium` = `fleet_resource_deuterium` + '".$Size."', ":"";
					$QryUpdateFleet .= "`fleet_mess` = '1' ";
					$QryUpdateFleet .= "WHERE ";
					$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
					$db->query($QryUpdateFleet);
				break;
				case 2:
				case 15:
				case 13:
					$FindSize = rand(0, 100);
					if(10 < $FindSize) {
						$Size		= rand(100, 300);
						$Message	= $lang['sys_expe_found_dm_1_'.rand(1,5)];
					} elseif(0 < $FindSize && 10 >= $FindSize) {
						$Size		= rand(301, 600);
						$Message	= $lang['sys_expe_found_dm_2_'.rand(1,4)];
					} elseif(0 == $FindSize) {
						$Size	 	= rand(601, 3000);
						$Message	= $lang['sys_expe_found_dm_3_'.rand(1,2)];
					}
					
					$QryUpdateFleet  = "UPDATE ".FLEETS." SET ";
					$QryUpdateFleet .= "`fleet_resource_darkmatter` = `fleet_resource_darkmatter` + '".$Size."', ";
					$QryUpdateFleet .= "`fleet_mess` = '1' ";
					$QryUpdateFleet .= "WHERE ";
					$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
					$db->query($QryUpdateFleet);
				break;
				case 3:
				case 10:
					unset($FleetCount[208]);
					unset($FleetCount[209]);
					unset($FleetCount[214]);
					$FindSize = rand(0, 100);
					if(10 < $FindSize) {
						$Size		= rand(2, 50);
						$Message	= $lang['sys_expe_found_ships_1_'.rand(1,4)];
						$MaxFound	= 300000;
					} elseif(0 < $FindSize && 10 >= $FindSize) {
						$Size		= rand(51, 100);
						$Message	= $lang['sys_expe_found_ships_2_'.rand(1,2)];
						$MaxFound	= 600000;
					} elseif(0 == $FindSize) {
						$Size	 	= rand(101, 200);
						$Message	= $lang['sys_expe_found_ships_3_'.rand(1,2)];
						$MaxFound	= 1200000;
					}
					
					$StatFactor = $db->fetch_array($db->query("SELECT MAX(total_points) as total FROM `".STATPOINTS."` WHERE `stat_type` = 1;"));
					
					if($StatFactor['total'] < 5000000)
						$MaxPoints = 4500;
					else
						$MaxPoints = 6000;
						
					$FoundPoints = 0;
					foreach($reslist['fleet'] as $ID)
					{
						if (!isset($FleetCount[$ID])) continue;
						$FoundShips		 = max(min(round($Size * $FleetPoints), $MaxPoints), 0);
						$FoundPoints	 += $FoundShips * ($pricelist[$ID]['metal'] + $pricelist[$ID]['crystal']);
					}
					
					$MinFound	= rand(7000, 10000);
					if($FoundPoints < $MinFound)
					{
						while($FoundPoints < $MinFound) {
							foreach($FoundShips as $ID => $Count) {
								$FoundShips[$ID]	+= 1;
								$FoundPoints	 	+= ($pricelist[$ID]['metal'] + $pricelist[$ID]['crystal']);
							}
						}
					} elseif($FoundPoints > $MaxFound) {
						while($FoundPoints > $MaxFound) {
							foreach($FoundShips as $ID => $Count) {
								$FoundShips[$ID]	-= 1;
								$FoundPoints	 	-= ($pricelist[$ID]['metal'] + $pricelist[$ID]['crystal']);
							}
						}					
					}
					
					$NewFleetArray = "";
					$FoundShipMess = "";

					foreach ($FleetCount as $ID => $Count)
					{
						if (empty($Count)) continue;
						
						$FleetCount		 += ($Count + $FoundShips[$ID]);
						$NewFleetArray   .= $ID.",".($Count + $FoundShips[$ID]).";";
						$FoundShipMess   .= "<br>". $lang['tech'][$Ship].": ".$Count;
					}
					$Message	.= $FoundShipMess;
					
					$QryUpdateFleet  = "UPDATE ".FLEETS." SET ";
					$QryUpdateFleet .= "`fleet_array` = '".$NewFleetArray."', ";
					$QryUpdateFleet .= "`fleet_amount` = '".$FleetCount."', ";
					$QryUpdateFleet .= "`fleet_mess` = '1'  ";
					$QryUpdateFleet .= "WHERE ";
					$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
					$db->query($QryUpdateFleet);
				break;
				case 4:
				case 12:
				case 16:
					$Chance	= rand(1,2);
					if($Chance) {
						$Points	= array(-3,-5,-8);
						$Which	= 1;
						$Def	= -3;
						$Name	= $lang['sys_expe_attackname_1'];
						$Add	= 0;
						$Rand	= array(5,3,2);	
						$DefenderFleetArray	= "204,5;206,3;207,2;";								
					} else { 
						$Points	= array(-4,-6,-9);
						$Which	= 2;
						$Def	= 3;
						$Name	= $lang['sys_expe_attackname_2'];
						$Add	= 0.1;
						$Rand	= array(4,3,2);
						$DefenderFleetArray	= "205,5;215,3;213,2;";
						}
					
					$FindSize = rand(0, 100);
					if(10 < $FindSize) {
						$Message			= $lang['sys_expe_attack_'.$Which.'_1_'.$Rand[0]];
						$MaxAttackerPoints	= 0.3 + $Add + (rand($Points[0], abs($Points[0])) * 0.01);
					} elseif(0 < $FindSize && 10 >= $FindSize) {
						$Message			= $lang['sys_expe_attack_'.$Which.'_2_'.$Rand[1]];
						$MaxAttackerPoints	= 0.3 + $Add + (rand($Points[1], abs($Points[1])) * 0.01);
					} elseif(0 == $FindSize) {
						$Message			= $lang['sys_expe_attack_'.$Which.'_3_'.$Rand[2]];
						$MaxAttackerPoints	= 0.3 + $Add + (rand($Points[2], abs($Points[2])) * 0.01);
					}
					
					foreach($FleetCount as $ID => $count)
					{
						$DefenderFleetArray	.= $ID.",".round($count * $MaxAttackerPoints).";";
					}

					$AttackerTechno	= $db->fetch_array($db->query('SELECT id,username,military_tech,defence_tech,shield_tech,rpg_amiral,dm_defensive,dm_attack FROM '.USERS.' WHERE id='.$FleetRow['fleet_owner'].";"));
					$DefenderTechno	= array('id' => 0, 'username' => $Name, 'military_tech' => ($AttackerTechno['military_tech'] + $Def), 'defence_tech' => ($AttackerTechno['defence_tech'] + $Def), 'shield_tech' => ($AttackerTechno['shield_tech'] + $Def), 'rpg_amiral' => 0, 'dm_defensive' => 0, 'dm_attack' => 0);
					
					$attackFleets[$FleetRow['fleet_id']]['fleet'] = $FleetRow;
					$attackFleets[$FleetRow['fleet_id']]['user'] = $AttackerTechno;
					$attackFleets[$FleetRow['fleet_id']]['detail'] = array();
					$temp = explode(';', $FleetRow['fleet_array']);
					foreach ($temp as $temp2)
					{
						$temp2 = explode(',', $temp2);

						if ($temp2[0] < 100) continue;

						if (!isset($attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]]))
							$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] = 0;

						$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
					}
					$defense = array();

					$defRowDef = explode(';', $DefenderFleetArray);
					foreach ($defRowDef as $Element)
					{
						$Element = explode(',', $Element);

						if ($Element[0] < 100) continue;

						if (!isset($defense[$defRow['fleet_id']]['def'][$Element[0]]))
							$defense[$defRow['fleet_id']][$Element[0]] = 0;

						$defense[$defRow['fleet_id']]['def'][$Element[0]] += $Element[1];
						$defense[$defRow['fleet_id']]['user'] = $DefenderTechno;
					}
					$start 		= microtime(true);
					$result 	= self::calculateAttack($attackFleets, $defense);
					$totaltime 	= microtime(true) - $start;


					foreach ($attackFleets as $fleetID => $attacker)
					{
						$fleetArray = '';
						$totalCount = 0;
						foreach ($attacker['detail'] as $element => $amount)
						{
							if ($amount)
								$fleetArray .= $element.','.$amount.';';

							$totalCount += $amount;
						}

						if ($totalCount <= 0)
						{
							$db->query('DELETE FROM '.FLEETS.' WHERE `fleet_id`='.$fleetID.';');
						}
						else
						{
							$db->query('UPDATE '.FLEETS.' SET fleet_array="'.substr($fleetArray, 0, -1).'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.$fleetID.';');
						}
					}
					
					$formatted_cr 	= self::GenerateReport($result, $steal, $MoonChance, $GottenMoon, $totaltime);

					$raport 		= $formatted_cr['html'];
					$rid   			= md5($raport);
					
					$SQLQuery  = "INSERT INTO ".RW." SET ";
					$SQLQuery .= "`time` = '".time()."', ";
					$SQLQuery .= "`owners` = '".$FleetRow['fleet_owner'].",0', ";
					$SQLQuery .= "`rid` = '". $rid ."', ";
					$SQLQuery .= "`a_zestrzelona` = '".count($result['rounds'])."', ";
					$SQLQuery .= "`raport` = '".$db->sql_escape($raport)."';";	
					$db->query($SQLQuery);
					$MessageAtt = sprintf($lang['sys_mess_attack_report_mess'], $rid, $ColorAtt, $lang['sys_mess_attack_report'], sprintf($lang['sys_adress_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']), $ColorAtt, $lang['sys_perte_attaquant'], pretty_number($result['lost']['att']), $ColorDef, $lang['sys_perte_defenseur'], pretty_number($result['lost']['def']), $lang['sys_gain'], $lang['Metal'], pretty_number($steal['metal']), $lang['Crystal'], pretty_number($steal['crystal']), $lang['Deuterium'], pretty_number($steal['deuterium']), $lang['sys_debris'], $lang['Metal'], pretty_number($result['debree']['att'][0]+$result['debree']['def'][0]), $lang['Crystal'], pretty_number($result['debree']['att'][1]+$result['debree']['def'][1]));
					SendSimpleMessage($FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $MessageAtt);

				break;
				case 5:
				case 17:
				case 19:
					$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = ". $FleetRow["fleet_id"].";");
					$Message	= $lang['sys_expe_lost_fleet_'.rand(1,4)];
				break;
				case 6:
					$MoreTime	= rand(0, 100);
					if($MoreTime < 75) {
						$FleetRow['fleet_end_time'] = round($FleetRow['fleet_end_stay'] + ($FleetRow['fleet_end_time'] - $FleetRow['fleet_end_stay']) + ((($FleetRow['fleet_end_stay'] - $FleetRow['fleet_start_time']) / 3600) * rand(1, 5)));
						$Message = $lang['sys_expe_time_slow_'.rand(1,6)];
					} else {
						$FleetRow['fleet_end_time'] = round($FleetRow['fleet_end_stay'] + ($FleetRow['fleet_end_time'] - $FleetRow['fleet_end_stay']) / 2);
						$Message = $lang['sys_expe_time_fast_'.rand(1,3)];
					}
					
					$QryUpdateFleet  = "UPDATE ".FLEETS." SET ";
					$QryUpdateFleet .= "`fleet_end_time` = '".$FleetRow['fleet_end_time']."', ";
					$QryUpdateFleet .= "`fleet_mess` = '1'  ";
					$QryUpdateFleet .= "WHERE ";
					$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
					$db->query($QryUpdateFleet);
				break;
				default:
					$Message	= $lang['sys_expe_nothing_'.rand(1,8)];
					$QryUpdateFleet  = "UPDATE ".FLEETS." SET ";
					$QryUpdateFleet .= "`fleet_mess` = '1'  ";
					$QryUpdateFleet .= "WHERE ";
					$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
					$db->query($QryUpdateFleet);
				break;
			}
			
			SendSimpleMessage($FleetRow['fleet_owner'], '', $FleetRow['fleet_end_stay'], 15, $lang['sys_mess_tower'], $lang['sys_expe_report'], $Message);	
		}
		else
		{
			if ($FleetRow['fleet_end_time'] < time())
			{
				self::RestoreFleetToPlanet($FleetRow, true);
				$db->multi_query("UPDATE `".USERS."` SET `darkmatter` = darkmatter + ".$FleetRow['fleet_resource_darkmatter']." WHERE `id` = '".$FleetRow['fleet_owner']."';DELETE FROM ".FLEETS." WHERE `fleet_id` = ". $FleetRow["fleet_id"].";");
				$Message = sprintf($lang['sys_expe_back_home'], $lang['Metal'], pretty_number($FleetRow['fleet_resource_metal']), $lang['Crystal'], pretty_number($FleetRow['fleet_resource_crystal']),  $lang['Deuterium'], pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Darkmatter'], pretty_number($FleetRow['fleet_resource_darkmatter']));
				SendSimpleMessage($FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 15, $lang['sys_mess_tower'], $lang['sys_expe_report'], $Message);
			}
		}
	}

	public static function MissionFoundDM($FleetRow)
	{
		global $lang, $db;
		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_end_stay'] < time())
		{
			$chance 		= rand(0, 100);
			if($chance <= (30 + $FleetRow['fleet_amount'] * 0.25)) {
				$FoundDark 	= rand(423, 1278);
				$Message 	= sprintf($lang['sys_expe_found_goods'], 0, $lang['Metal'], 0, $lang['Crystal'], 0, $lang['Deuterium'], pretty_number($FoundDark), $lang['Darkmatter']);
			} else {
				$FoundDark 	= 0;
				$Message 	= $lang['sys_expe_nothing_'.rand(1, 2)];
			}

			$db->query("UPDATE ".FLEETS." SET `fleet_mess` = '1',`fleet_resource_darkmatter` = `fleet_resource_darkmatter` + '". $FoundDark ."' WHERE `fleet_id` = '". $FleetRow['fleet_id'] ."';");			
			SendSimpleMessage($FleetRow['fleet_owner'], '', $FleetRow['fleet_end_stay'], 15, $lang['sys_mess_tower'], $lang['sys_expe_report'], $Message);
		}
		elseif ($FleetRow['fleet_end_time'] < time())
		{
			if($FleetRow['fleet_resource_darkmatter'] > 0) {
				SendSimpleMessage($FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 15, $lang['sys_mess_tower'], $lang['sys_expe_report'], sprintf($lang['sys_expe_back_home_with_dm'], $lang['Darkmatter'], pretty_number($FleetRow['fleet_resource_darkmatter']), $lang['Darkmatter']));
				$FleetRow['fleet_array'] = "220,0;";
			} else {
				SendSimpleMessage($FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 15, $lang['sys_mess_tower'], $lang['sys_expe_report'], $lang['sys_expe_back_home_without_dm']);
			}
			self::RestoreFleetToPlanet($FleetRow, true);
			
			$db->multi_query("UPDATE `".USERS."` SET `darkmatter` = darkmatter + ".$FleetRow['fleet_resource_darkmatter']." WHERE `id` = '".$FleetRow['fleet_owner']."';DELETE FROM ".FLEETS." WHERE `fleet_id` = ". $FleetRow["fleet_id"].";");
		}		
	}
}

?>