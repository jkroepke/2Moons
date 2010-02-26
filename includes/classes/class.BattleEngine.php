<?php

class Battle
{
	public function StartBattle($Attackers, $Defenders, $MaxRounds = 6, $DefenseReg = 70, $EMPmissileBlock = false) {
		global $lang, $resource, $reslist, $pricelist, $CombatCaps, $game_config;
		
		$Array = $this->GenerateCombatArray($Attackers, $Defenders, $EMPmissileBlock);	
		$AttackersFleets = $Array[0];
		$DefendersFleets = $Array[1];	
		unset($Array);
		$Battles = array();
		$TotalMetal = 0;
		$TotalCrystal = 0;
		$TotalAttackersLost = 0;
		$TotalDefendersLost = 0;	
		for($Round = 1; $Round <= $MaxRounds; $Round++){
			$Battles[$Round - 1] = array();
			$Battles[$Round - 1]['attackers'] = array();
			$Battles[$Round - 1]['defenders'] = array();
			$AttAny = false;
			$DefAny = false;
			foreach($AttackersFleets as $Order => $Player){
				$Battles[$Round - 1]['attackers'][$Order] = array();
				$Count = $this->RestShips($Player);
				if($Count['total'] == 0){
					$Battles[$Round - 1]['attackers'][$Order]['Ships'] = 0;
				}else{
					$Battles[$Round - 1]['attackers'][$Order]['Ships'] = $Count['all'];
					$AttAny = true;
				}		
			}
			foreach($DefendersFleets as $Order =>  $Player){
				$Battles[$Round - 1]['defenders'][$Order] = array();
				$Count = $this->RestShips($Player);
				if($Count['total'] == 0){
					$Battles[$Round - 1]['defenders'][$Order]['Ships'] = 0;
				}else{
					$Battles[$Round - 1]['defenders'][$Order]['Ships'] = $Count['all'];
					$DefAny = true;
				}		
			}
			$CurrentRound = $this->CombatRound($AttackersFleets, $DefendersFleets);
			$Battles[$Round - 1]['Materials'] = $this->RoundClean($AttackersFleets, $DefendersFleets);
			$Battles[$Round - 1]['Materials']['attack_a'] = $CurrentRound['attack_a'];
			$Battles[$Round - 1]['Materials']['shield_a'] = $CurrentRound['shield_a'];
			$Battles[$Round - 1]['Materials']['attack_b'] = $CurrentRound['attack_b'];
			$Battles[$Round - 1]['Materials']['shield_b'] = $CurrentRound['shield_b'];
			$Battles[$Round - 1]['Materials']['destroyed_a'] = $CurrentRound['destroyed_a'];
			$Battles[$Round - 1]['Materials']['destroyed_b'] = $CurrentRound['destroyed_b'];
			$TotalMetal += $Battles[$Round - 1]['Materials']['debris']['metal'];
			$TotalCrystal += $Battles[$Round - 1]['Materials']['debris']['crystal'];
			$TotalAttackersLost += $Battles[$Round - 1]['Materials']['lostunits'][0];
			$TotalDefendersLost += $Battles[$Round - 1]['Materials']['lostunits'][1];	
			if($AttAny == false or $DefAny == false){
				break;
			}
		}
		
		$Result = array();
		foreach($AttackersFleets as $Order => $Player){
			$Result['attackers'][$Order] = array();
			$Count = $this->RestShips($Player);
			if($Count['total'] == 0){
				$Result['attackers'][$Order]['Ships'] = 0;
			}else{
				$Result['attackers'][$Order]['Ships'] = $Count['all'];
				$AttAny = true;
			}		
		}
		foreach($DefendersFleets as $Order =>  $Player){
			$Result['defenders'][$Order] = array();
			$Count = $this->RestShips($Player);
			if($Count['total'] == 0){
				$Result['defenders'][$Order]['Ships'] = 0;
			}else{
				$Result['defenders'][$Order]['Ships'] = $Count['all'];
			}		
		}
		$Won = $this->WhoWonBattle($AttackersFleets, $DefendersFleets);
		$Repair = $this->RepairDefenses($DefendersFleets, $DefenseReg);
		return array('rounds' => $Battles, 'debris' => array('metal' => $TotalMetal, 'crystal' => $TotalCrystal), 'lostunits' => array('attackers' => $TotalAttackersLost, 'defenders' => $TotalDefendersLost), 'repair' => $Repair, 'attackers' => $AttackersFleets, 'defenders'=> $DefendersFleets, 'won' => $Won, 'last_round' => $Result);
	}

	private function WhoWonBattle($AttackersFleets, $DefendersFleets){
		$Attackers = 0;
		$Defenders = 0;
		foreach($AttackersFleets as $Order => $Player){
			$Count = $this->RestShips($Player);
			if($Count['total'] == 0){
				
			}else{
				$Attackers++;
			}		
		}
		foreach($DefendersFleets as $Order =>  $Player){
			$Count = $this->RestShips($Player);
			if($Count['total'] == 0){
				
			}else{
				$Defenders++;
			}		
		}
		if($Attackers > 0 && $Defenders > 0){
			return 'r';
		}elseif($Attackers == 0){	
			return 'w';
		}elseif($Defenders == 0){
			return 'a';
		}else{
			return 'r';
		}
	}
	
	private function RepairDefenses(&$DefendersFleets, $DefenseReg = 70){
		global $lang, $resource, $reslist, $pricelist, $CombatCaps, $game_config;
		$return = array();
		foreach($DefendersFleets as $Array){
			foreach($Array as $Pass){
					if(in_array($Pass['ship'], $reslist['defense']) and $Pass['destroyed'] == 0){
						$rand = mt_rand(0, 100);
						$rand2 = mt_rand(-10, 10);
						
						if($rand <= ($DefenseReg + $rand2)){
							$Pass['shield'] == 1;
							$Pass['integrity'] == 1;
							$Pass['destroyed'] == 0;
							if(!isset($return[$Pass['ship']])){
								$return[$Pass['ship']] = 0;
							}
							$return[$Pass['ship']]++;
						}
					}
							
			}	
		}	
	return $return;
	}
	
	private function RoundClean(&$AttackersFleets, &$DefendersFleets){
		global $lang, $resource, $reslist, $pricelist, $CombatCaps, $game_config;
		$Debris = array('metal' => 0, 'crystal' => 0);
		$LostUnits = array(0,0);
		foreach($AttackersFleets as $Array){
			foreach($Array as $Pass){
					$Pass['shield'] = $CombatCaps[$Pass['ship']]['shield'];
					if($Pass['integrity'] <= 0 and $Pass['destroyed'] == 0){
						if(in_array($Pass['ship'], $reslist['fleet'])){
							$Debris['metal'] += $pricelist[$Pass['ship']]['metal'] * 0.7;
							$Debris['crystal'] += $pricelist[$Pass['ship']]['crystal'] * 0.7;
						}
						$LostUnits[0] += ($pricelist[$Pass['ship']]['metal'] + $pricelist[$Pass['ship']]['crystal'] + $pricelist[$Pass['ship']]['deuterium'] + $pricelist[$Pass['ship']]['hidrogeno']);
						$Pass['destroyed'] = 1;				
					}
					
							
			}	
		}
		foreach($DefendersFleets as $Array){
			foreach($Array as $Pass){
					$Pass['shield'] = $CombatCaps[$Pass['ship']]['shield'];
					if($Pass['integrity'] <= 0 and $Pass['destroyed'] == 0){
						if(in_array($Pass['ship'], $reslist['fleet']) or defined('DEFENSE_TO_DEBRIS')){
							$Debris['metal'] += $pricelist[$Pass['ship']]['metal'] * 0.7;
							$Debris['crystal'] += $pricelist[$Pass['ship']]['crystal'] * 0.7;
						}
						$LostUnits[1] += ($pricelist[$Pass['ship']]['metal'] + $pricelist[$Pass['ship']]['crystal'] + $pricelist[$Pass['ship']]['deuterium'] + $pricelist[$Pass['ship']]['hidrogeno']);
						$Pass['destroyed'] = 1;
					}
							
			}	
		}
		return array('debris' => $Debris,'lostunits' => $LostUnits);
	}
	
	private function CombatRound(&$AttackersFleets, &$DefendersFleets){
		global $lang, $resource, $reslist, $pricelist, $CombatCaps, $game_config;
		$TotalAttack = 0;
		$TotalShield = 0;
		$TotalAttack2 = 0;
		$TotalShield2 = 0;
		$Destroyed = 0;
		$Destroyed2 = 0;
		$Counts = array();
		$Counts['attackers'] = array();
		$Counts['attackers']['total'] = 0;
		$Counts['defenders'] = array();
		$Counts['defenders']['total'] = 0;
		foreach($AttackersFleets as $Order => $Array){
			$Counts['attackers'][$Order] = 0;
			$Counts['attackers']['total']++;
			foreach($Array as $Pass){
				if($Pass['destroyed'] == 1){
					continue;
				}
				$Counts['attackers'][$Order]++;
			}
		
		}
		foreach($DefendersFleets as $Order => $Array){
			$Counts['defenders'][$Order] = 0;
			$Counts['defenders']['total']++;
			foreach($Array as $Pass){
				if($Pass['destroyed'] == 1){
					continue;
				}
				$Counts['defenders'][$Order]++;
			}
		
		}
		foreach($AttackersFleets as $Array){
			foreach($Array as $Pass){
					if($Pass['destroyed'] == 1){
						continue;
					}
					$now = true;
					while($now == true){
						$now = false;
						$Rand1 = mt_rand(0, ($Counts['defenders']['total'] - 1));
						$Rand2 = mt_rand(0, ($Counts['defenders'][$Rand1] - 1));
						$AttackTo =& $DefendersFleets[$Rand1][$Rand2];
						if($AttackTo['destroyed'] == 1){
							$now = true;
							continue;
						}
						if($CombatCaps[$Pass['ship']]['sd'][$AttackTo['ship']] > 1){
							$rand = mt_rand(0, $CombatCaps[$Pass['ship']]['sd'][$AttackTo['ship']]);
							if($rand <= ($CombatCaps[$Pass['ship']]['sd'][$AttackTo['ship']] - 1)){
								$now = true;
							}
						}
						$ShieldRest = $Pass['attack'] - $AttackTo['shield'];
						$TotalAttack += $Pass['attack'];
						$AttackIntegrityPercent = ($AttackTo['integrity'] * 30 / 100);
						if($ShieldRest > 0){
							$AttackTo['shield'] = 0;
							$AttackTo['integrity'] -= $ShieldRest;
							$TheAttack = $ShieldRest;
							$TotalShield2 += ($Pass['attack'] - $ShieldRest);
							$TotalAttack += $Pass['attack'];
						}else{
							$AttackTo['shield'] -= $Pass['attack'];
							$TheAttack = $Pass['attack'];
							$TotalAttack += $Pass['attack'];
						}
						
						if($AttackIntegrityPercent < $TheAttack){
							$rand = mt_rand(0, 100);
							if($rand <= 30){
								//BOOOOMM!!!!
								$AttackTo['shield'] = 0;
								$AttackTo['integrity'] = 0;
							}
						}
						if($AttackTo['integrity'] <= 0){
							$Destroyed++;
						}
					}
							
			}	
		}
		foreach($DefendersFleets as $Array){
			foreach($Array as $Pass){
					if($Pass['destroyed'] == 1){
						continue;
					}
					$now = true;
					while($now == true){
						$now = false;
						$Rand1 = mt_rand(0, ($Counts['attackers']['total'] - 1));
						$Rand2 = mt_rand(0, ($Counts['attackers'][$Rand1] - 1));
						$AttackTo =& $AttackersFleets[$Rand1][$Rand2];
						if($AttackTo['destroyed'] == 1){
							$now = true;
							continue;
						}
						if($CombatCaps[$Pass['ship']]['sd'][$AttackTo['ship']] > 1){
							$rand = mt_rand(0, $CombatCaps[$Pass['ship']]['sd'][$AttackTo['ship']]);
							if($rand <= ($CombatCaps[$Pass['ship']]['sd'][$AttackTo['ship']] - 1)){
								$now = true;
							}
						}
						$ShieldRest = $Pass['attack'] - $AttackTo['shield'];
						$AttackIntegrityPercent = ($AttackTo['integrity'] * 30 / 100);
						if($ShieldRest > 0){
							$AttackTo['shield'] = 0;
							$AttackTo['integrity'] -= $ShieldRest;
							$TheAttack = $ShieldRest;
							$TotalShield += ($Pass['attack'] - $ShieldRest);
							$TotalAttack2 += $Pass['attack'];
						}else{
							$AttackTo['shield'] -= $Pass['attack'];
							$TheAttack = $Pass['attack'];
							$TotalAttack2 += $Pass['attack'];
						}
						
						if($AttackIntegrityPercent < $TheAttack){
							$rand = mt_rand(0, 100);
							if($rand <= 30){
								//BOOOOMM!!!!
								$AttackTo['shield'] = 0;
								$AttackTo['integrity'] = 0;
							}
						}
						if($AttackTo['integrity'] <= 0){
							$Destroyed2++;
						}
					}
							
			}	
		}
		return array('attack_a' => $TotalAttack,'shield_a' => $TotalShield, 'attack_b' => $TotalAttack2, 'shield_b' => $TotalShield2, 'destroyed_a' => $Destroyed, 'destroyed_b' => $Destroyed2);
	}

	private function RestShips($Player){
		global $lang, $resource, $reslist, $pricelist, $CombatCaps, $game_config;
		$Ships = array();
		$TotalShips = 0;
		foreach($Player as $Ship){
			if(!isset($Ships[$Ship['ship']])){
				$Ships[$Ship['ship']] = array();
				$Ships[$Ship['ship']]['count'] = 0;
				$Ships[$Ship['ship']]['attack'] = 0;
				$Ships[$Ship['ship']]['integrity'] = 0;
				$Ships[$Ship['ship']]['shield'] = 0;	
			}
			if($Ship['integrity'] > 0){
				$Ships[$Ship['ship']]['count']++;
				$Ships[$Ship['ship']]['attack'] += $Ship['attack'];
				$Ships[$Ship['ship']]['integrity'] += $Ship['integrity'];
				$Ships[$Ship['ship']]['shield'] += $Ship['shield'];	
				$TotalShips++;
			}
		}
		return array('total' => $TotalShips, 'all' => $Ships);
	}

	private function GenerateCombatArray($Attackers, $Defenders, $EMPmissileBlock = false){
		global $lang, $resource, $reslist, $pricelist, $CombatCaps, $game_config;
		$AttackersFleets = array();
		$DefendersFleets = array();
		foreach($Attackers as $Order => $Array){
			$AttackersFleets[$Order] = array();
			foreach($Array[3] as $Ship => $Count){
				$count = count($AttackersFleets[$Order]);
				for($Pass = $count; $Pass <= ($Count + $count); $Pass++){
					$AttackersFleets[$Order][$Pass] = array(
					'ship' => $Ship,
					'attack' => ($CombatCaps[$Ship]['attack'] * (1 + (0.1 * ($Array[1]['military_tech']) + (0.05 * $Array[2]['rpg_amiral'])))),
					'shield' => ($CombatCaps[$Ship]['shield'] * (1 + (0.1 * ($Array[1]['defence_tech']) + (0.05 * $Array[2]['rpg_amiral'])))),
					'integrity' => ((($pricelist[$Ship]['metal'] + $pricelist[$Ship]['crystal']) / 10) * (1 + (0.1 * ($Array[1]['shield_tech']) + (0.05 * $Array[2]['rpg_amiral'])))),
					'destroyed' => 0,
					);
				}
			}
		}
		foreach($Defenders as $Order => $Array){
			$DefendersFleets[$Order] = array();
			foreach($Array[3] as $Ship => $Count){
				$count = count($DefendersFleets[$Order]);
				for($Pass = $count; $Pass <= ($Count + $count); $Pass++){
					if(in_array($Ship, $reslist['fleet'])){
						$DefendersFleets[$Order][$Pass] = array(
						'ship' => $Ship,
						'attack' => ($CombatCaps[$Ship]['attack'] * (1 + (0.1 * ($Array[1]['military_tech']) + (0.05 * $Array[2]['rpg_amiral'])))),
						'shield' => ($CombatCaps[$Ship]['shield'] * (1 + (0.1 * ($Array[1]['defence_tech']) + (0.05 * $Array[2]['rpg_amiral'])))),
						'integrity' => ((($pricelist[$Ship]['metal'] + $pricelist[$Ship]['crystal']) / 10) * (1 + (0.1 * ($Array[1]['shield_tech']) + (0.05 * $Array[2]['rpg_amiral'])))),
						'destroyed' => 0,
						);
					}elseif(in_array($Ship, $reslist['defense']) and $EMPmissileBlock == false){
						$DefendersFleets[$Order][$Pass] = array(
						'ship' => $Ship,
						'attack' => ($CombatCaps[$Ship]['attack'] * (1 + (0.1 * ($Array[1]['military_tech']) + (0.05 * $Array[2]['rpg_amiral'])))),
						'shield' => ($CombatCaps[$Ship]['shield'] * (1 + (0.1 * ($Array[1]['defence_tech']) + (0.05 * $Array[2]['rpg_amiral'])))),
						'integrity' => ((($pricelist[$Ship]['metal'] + $pricelist[$Ship]['crystal']) / 10) * (1 + (0.1 * ($Array[1]['shield_tech']) + (0.05 * $Array[2]['rpg_amiral'])))),
						'destroyed' => 0,
						);					
					}else{
						$DefendersFleets[$Order][$Pass] = array(
						'ship' => $Ship,
						'attack' => 0,
						'shield' => ($CombatCaps[$Ship]['shield'] * (1 + (0.1 * ($Array[1]['defence_tech']) + (0.05 * $Array[2]['rpg_amiral'])))),
						'integrity' => ((($pricelist[$Ship]['metal'] + $pricelist[$Ship]['crystal']) / 10) * (1 + (0.1 * ($Array[1]['shield_tech']) + (0.05 * $Array[2]['rpg_amiral'])))),
						'destroyed' => 0,
						);				
					}
				}
			}
		}
		return array(0 => $AttackersFleets, 1 => $DefendersFleets);
	}
}
?>