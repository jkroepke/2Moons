<?php

/*
//--------------------PARA TESTEO / FOR TESTING-----------------------------

$Attack = array(
array(23, array('military_tech' => 4, 'defence_tech' => 7, 'shield_tech' => 3), array('rpg_amiral' => 2), array(
201 => 2,
202 => 665,
203 => 400,
217 => 13,
)),
array(57, array('military_tech' => 6, 'defence_tech' => 4, 'shield_tech' => 5), array('rpg_amiral' => 3), array(
201 => 2,
213 => 665,
215 => 400,
220 => 13,
)),
);

$Defend = array(
array(23, array('military_tech' => 4, 'defence_tech' => 7, 'shield_tech' => 3), array('rpg_amiral' => 2), array(
201 => 2,
202 => 665,
203 => 400,
404 => 13,
)),
array(57, array('military_tech' => 6, 'defence_tech' => 4, 'shield_tech' => 5), array('rpg_amiral' => 3), array(
201 => 2,
213 => 665,
215 => 400,
407 => 13,
)),
);

*/
class BattleEngine
{
	public function __construct($Attackers, $Defenders, $MaxRounds = 6, $DefenseReg = 70)
	{
		$this->MaxRounds	= $MaxRounds;
		$this->CombatCaps	= $GLOBALS['CombatCaps'];
		$this->pricelist	= $GLOBALS['pricelist'];
		$this->IsDefense	= $GLOBALS['reslist']['defense'];
		$this->Debris		= array('metal'	=> 0, 'crystal'	=> 0);
		$this->LostUnits	= array(0, 0);
		$this->DieDef		= array();
		$this->DefRepFac	= $DefenseReg;
		$this->factor		= 10;
		$this->Attackers	= $Attackers;
		$this->Defenders	= $Defenders;
		$this->init();
	}

	private function init()
	{
		foreach($this->Attackers as $PlayerID => $Array)
		{
			$this->Techno[0][$PlayerID]	= array($Array[1]['military_tech'], $Array[1]['defence_tech'], $Array[1]['shield_tech'],$Array[2]['rpg_amiral']);
			foreach($Array[3] as $Ship => $Count){
				$Shield		= ($this->CombatCaps[$Ship]['shield'] * (1 + (0.1 * ($Array[1]['defence_tech']) + (0.05 * $Array[2]['rpg_amiral']))));
				$Integrity	= ((($this->pricelist[$Ship]['metal'] + $this->pricelist[$Ship]['crystal']) / 10) * (1 + (0.1 * ($Array[1]['shield_tech']) + (0.05 * $Array[2]['rpg_amiral']))));
				for($Pass = 1; $Pass <= $Count; $Pass++){
					$this->AttackersFleets[$PlayerID][] = array($Ship, $Shield, $Integrity);
				}		
			}
		}
		
		foreach($this->Defenders as $PlayerID => $Array)
		{
			$this->Techno[1][$PlayerID]	= array($Array[1]['military_tech'], $Array[1]['defence_tech'], $Array[1]['shield_tech'],$Array[2]['rpg_amiral']);
			foreach($Array[3] as $Ship => $Count){
				$Shield		= ($this->CombatCaps[$Ship]['shield'] * (1 + (0.1 * ($Array[1]['defence_tech']) + (0.05 * $Array[2]['rpg_amiral']))));
				$Integrity	= ((($this->pricelist[$Ship]['metal'] + $this->pricelist[$Ship]['crystal']) / 10) * (1 + (0.1 * ($Array[1]['shield_tech']) + (0.05 * $Array[2]['rpg_amiral']))));
				for($Pass = 1; $Pass <= $Count; $Pass++){
					$this->DefendersFleets[$PlayerID][] = array($Ship, $Shield, $Integrity);
				}
			}			
		}
	}

	public function Battle()
	{
		for($this->CurrentRound = 0; $this->CurrentRound <= $this->MaxRounds; $this->CurrentRound++)
		{
			$this->BattleRoundInfo();			
			
			$this->CheckDie();
			
			if(isset($this->BattleWin))
				break;
			
			$RoundInfo	= $this->CombatRound();
			$this->AddRoundInfo($RoundInfo);
			unset($RoundInfo);
		}
		$this->RepairDefenses();
		
		return array('attacker'	=> $this->AttackersFleets, 'defenders' => $this->DefendersFleets, 'battleinfo' => $this->BattleInfo, 'result' => $this->BattleWin, 'lost' => $this->LostUnits, 'derbis' => $this->Debris);
	}
	
	private function CheckDie()
	{
		if($this->BattleInfo[$this->CurrentRound]['attacker']['total']['count']	== 0)
			$this->BattleWin	= 'lose';
		elseif($this->BattleInfo[$this->CurrentRound]['defender']['total']['count']	== 0)
			$this->BattleWin	= 'win';
		elseif($this->CurrentRound == $this->MaxRounds)
			$this->BattleWin	= 'draw';
	}
	
	private function AddRoundInfo($RoundInfo)
	{
		$this->BattleInfo[$this->CurrentRound]['attacker']['total']['attack']					= $RoundInfo['attack_a'];
		$this->BattleInfo[$this->CurrentRound]['attacker']['total']['defend']					= $RoundInfo['shield_a'];
		$this->BattleInfo[$this->CurrentRound]['defender']['total']['attack']					= $RoundInfo['attack_d'];
		$this->BattleInfo[$this->CurrentRound]['defender']['total']['defend']					= $RoundInfo['shield_d'];
		$this->BattleInfo[$this->CurrentRound]['attacker']['total']['count']					= $RoundInfo['count_a'];
		$this->BattleInfo[$this->CurrentRound]['defender']['total']['count']					= $RoundInfo['count_d'];
	}
	
	private function BattleRoundInfo()
	{
		foreach($this->AttackersFleets as $Order => $Array){
			foreach($Array as $ID => $Pass){
		
				$Pass['ship']			= $Pass[0];
				$Pass['attack']			= ($this->CombatCaps[$Pass[0]]['attack'] * (1 + (0.1 * ($this->Techno[0][$Order][0]) + (0.05 * $this->Techno[0][$Order][3]))));
				$Pass['shield']			= $Pass[1];
				$Pass['maxshield']		= ($this->CombatCaps[$Pass[0]]['shield'] * (1 + (0.1 * ($this->Techno[0][$Order][1]) + (0.05 * $this->Techno[0][$Order][3]))));
				$Pass['integrity']		= $Pass[2];
				$Pass['maxintegrity']	= ((($this->pricelist[$Pass[0]]['metal'] + $this->pricelist[$Pass[0]]['crystal']) / 10) * (1 + (0.1 * ($this->Techno[0][$Order][2]) + (0.05 * $this->Techno[0][$Order][3]))));
				
				if(!isset($this->BattleInfo[$this->CurrentRound]['attacker']))
				{	
					$this->BattleInfo[$this->CurrentRound]['attacker']['total']['count']					= 0;
					$this->BattleInfo[$this->CurrentRound]['attacker'][$Order][$Pass['ship']]['count']		= 0;
					$this->BattleInfo[$this->CurrentRound]['attacker'][$Order][$Pass['ship']]['attack']		= 0;
					$this->BattleInfo[$this->CurrentRound]['attacker'][$Order][$Pass['ship']]['shield']		= 0;
					$this->BattleInfo[$this->CurrentRound]['attacker'][$Order][$Pass['ship']]['integrity']	= 0;
				}
				$this->AttackersFleets[$Order][$ID]['shield'] 		= $Pass['shield'] 		= $Pass['maxshield'];
				$this->AttackersFleets[$Order][$ID]['integrity']	= $Pass['integrity']	= $Pass['maxintegrity'];
				
				$this->BattleInfo[$this->CurrentRound]['attacker']['total']['count']++;
				$this->BattleInfo[$this->CurrentRound]['attacker'][$Order][$Pass['ship']]['count']++;
				$this->BattleInfo[$this->CurrentRound]['attacker'][$Order][$Pass['ship']]['attack'] += $Pass['attack'];
				$this->BattleInfo[$this->CurrentRound]['attacker'][$Order][$Pass['ship']]['shield'] += $Pass['shield'];
				$this->BattleInfo[$this->CurrentRound]['attacker'][$Order][$Pass['ship']]['integrity'] += $Pass['integrity'];
			}
		}
		
		foreach($this->DefendersFleets as $Order => $Array){
			foreach($Array as $ID => $Pass){					
				
				$Pass['ship']		= $Pass[0];
				$Pass['attack']		= ($this->CombatCaps[$Pass[0]]['attack'] * (1 + (0.1 * ($this->Techno[1][$Order][0]) + (0.05 * $this->Techno[1][$Order][3]))));
				$Pass['shield']		= ($this->CombatCaps[$Pass[0]]['shield'] * (1 + (0.1 * ($this->Techno[1][$Order][1]) + (0.05 * $this->Techno[1][$Order][3]))));
				$Pass['integrity']	= ((($this->pricelist[$Pass[0]]['metal'] + $this->pricelist[$Pass[0]]['crystal']) / 10) * (1 + (0.1 * ($this->Techno[1][$Order][2]) + (0.05 * $this->Techno[1][$Order][3]))));
					
				if(!isset($this->BattleInfo[$this->CurrentRound]['defender']))
				{	
					$this->BattleInfo[$this->CurrentRound]['defender']['total']['count']					= 0;
					$this->BattleInfo[$this->CurrentRound]['defender'][$Order][$Pass['ship']]['count']		= 0;
					$this->BattleInfo[$this->CurrentRound]['defender'][$Order][$Pass['ship']]['attack']		= 0;
					$this->BattleInfo[$this->CurrentRound]['defender'][$Order][$Pass['ship']]['shield']		= 0;
					$this->BattleInfo[$this->CurrentRound]['defender'][$Order][$Pass['ship']]['integrity']	= 0;
				}	
				
				$this->DefendersFleets[$Order][$ID]['shield'] 		= $Pass['shield'];
				$this->DefendersFleets[$Order][$ID]['integrity']	= $Pass['integrity'];
				
				$this->BattleInfo[$this->CurrentRound]['defender']['total']['count']++;
				$this->BattleInfo[$this->CurrentRound]['defender'][$Order][$Pass['ship']]['count']++;
				$this->BattleInfo[$this->CurrentRound]['defender'][$Order][$Pass['ship']]['attack'] += $Pass['attack'];
				$this->BattleInfo[$this->CurrentRound]['defender'][$Order][$Pass['ship']]['shield'] += $Pass['shield'];
				$this->BattleInfo[$this->CurrentRound]['defender'][$Order][$Pass['ship']]['integrity'] += $Pass['integrity'];
			}
		}
	}
	
	private function CombatRound()
	{
		$TotalAttack = 0;
		$TotalShield = 0;
		$TotalAttack2 = 0;
		$TotalShield2 = 0;
		$Destroyed = 0;
		$Destroyed2 = 0;
		$Count = 0;
		$Count2 = 0;
		foreach($this->AttackersFleets as $Order => $Array)
		{
			foreach($Array as $Pass)
			{
				$Pass['ship']			= $Pass[0];
				$Pass['attack']			= ($this->CombatCaps[$Pass[0]]['attack'] * (1 + (0.1 * ($this->Techno[0][$Order][0]) + (0.05 * $this->Techno[0][$Order][3]))));
				$Pass['shield']			= $Pass[1];
				$Pass['maxshield']		= ($this->CombatCaps[$Pass[0]]['shield'] * (1 + (0.1 * ($this->Techno[0][$Order][1]) + (0.05 * $this->Techno[0][$Order][3]))));
				$Pass['integrity']		= $Pass[2];
				$Pass['maxintegrity']	= ((($this->pricelist[$Pass[0]]['metal'] + $this->pricelist[$Pass[0]]['crystal']) / 10) * (1 + (0.1 * ($this->Techno[0][$Order][2]) + (0.05 * $this->Techno[0][$Order][3]))));
				
				
				$Fire	= true;
				while ($Fire) {						
					$Player	= array_rand($this->DefendersFleets);
					if(count($this->DefendersFleets[$Player]) == 0)
						break;
						
					$Ship 	= array_rand($this->DefendersFleets[$Player]);
					$AttackTo = $this->DefendersFleets[$Player][$Ship];
					
					$AttackTo['ship']			= $AttackTo[0];
					$AttackTo['shield']			= $AttackTo[1];
					$AttackTo['maxshield']		= ($this->CombatCaps[$AttackTo[0]]['shield'] * (1 + (0.1 * ($this->Techno[1][$Player][1]) + (0.05 * $this->Techno[1][$Player][3]))));
					$AttackTo['integrity']		= $AttackTo[2];
					$AttackTo['maxintegrity']	= ((($this->pricelist[$AttackTo[0]]['metal'] + $this->pricelist[$AttackTo[0]]['crystal']) / 10) * (1 + (0.1 * ($this->Techno[1][$Player][2]) + (0.05 * $this->Techno[1][$Player][3]))));
					
					$Count++;
					if(($Pass['attack'] / $AttackTo['maxshield']) >= 0.01)
					{
						$ShieldRest = $Pass['attack'] - $AttackTo['shield'];
						if($ShieldRest > 0){
							$AttackTo['shield'] = 0;
							$AttackTo['integrity'] -= $ShieldRest;
							$TotalShield2 += ($Pass['attack'] - $ShieldRest);
													
							if(($AttackTo['integrity'] * 0.3) < $ShieldRest){
								if(mt_rand(0, 100) <= (($AttackTo['maxintegrity'] - $AttackTo['integrity']) / $AttackTo['maxintegrity'])){
									$AttackTo['integrity'] = 0;
									$Destroyed++;
									$this->Debris['metal'] += $this->pricelist[$AttackTo['ship']]['metal'] * 0.7;
									$this->Debris['crystal'] += $this->pricelist[$AttackTo['ship']]['crystal'] * 0.7;
									$this->LostUnits[1] += $this->pricelist[$AttackTo['ship']]['metal'] + $this->pricelist[$AttackTo['ship']]['crystal'] + $this->pricelist[$AttackTo['ship']]['deuterium'];
									unset($this->DefendersFleets[$Player][$Ship]);
									
									if(in_array($AttackTo['ship'], $this->IsDefense))
										if(isset($this->DieDef[$AttackTo['ship']]))
											$this->DieDef[$AttackTo['ship']]++;
										else
											$this->DieDef[$AttackTo['ship']]	= 1;
								}
							}
							
						} else {
							$AttackTo['shield'] -= $Pass['attack'];
							$TotalShield2 		+= $Pass['attack'];
						}
					} else {
						$TotalShield2  		+= $Pass['attack'];
					}
					$TotalAttack += $Pass['attack'];	
					
					if(isset($this->DefendersFleets[$Player][$Ship]))
					{
						$this->DefendersFleets[$Player][$Ship][1]	= $AttackTo['shield'];
						$this->DefendersFleets[$Player][$Ship][2]	= $AttackTo['integrity'];
					}
					
					if(isset($this->CombatCaps[$Pass['ship']]['sd'][$AttackTo['ship']])) {
						$Rapidfire = 100 * ($this->CombatCaps[$Pass['ship']]['sd'][$AttackTo['ship']] - 1) / $this->CombatCaps[$Pass['ship']]['sd'][$AttackTo['ship']];
						$rand	= mt_rand(1, 100);
						if($rand <= $Rapidfire)
							$Fire	= true;
						else
							$Fire	= false;
					} else
						$Fire	= false;
				}
			}	
		}
		
		foreach($this->DefendersFleets as $Order => $Array)
		{
			foreach($Array as $Pass)
			{
				$Pass['ship']			= $Pass[0];
				$Pass['attack']			= ($this->CombatCaps[$Pass[0]]['attack'] * (1 + (0.1 * ($this->Techno[1][$Order][0]) + (0.05 * $this->Techno[1][$Order][3]))));
				$Pass['shield']			= $Pass[1];
				$Pass['maxshield']		= ($this->CombatCaps[$Pass[0]]['shield'] * (1 + (0.1 * ($this->Techno[1][$Order][1]) + (0.05 * $this->Techno[1][$Order][3]))));
				$Pass['integrity']		= $Pass[2];
				$Pass['maxintegrity']	= ((($this->pricelist[$Pass[0]]['metal'] + $this->pricelist[$Pass[0]]['crystal']) / 10) * (1 + (0.1 * ($this->Techno[1][$Order][2]) + (0.05 * $this->Techno[1][$Order][3]))));
					
					
				$Fire	= true;
				while ($Fire) {
						
					$Player	= array_rand($this->AttackersFleets);

					if(count($this->AttackersFleets[$Player]) == 0)
						break;
					
					$Ship 	= array_rand($this->AttackersFleets[$Player]);
					$AttackTo = $this->AttackersFleets[$Player][$Ship];
				
					$AttackTo['ship']			= $AttackTo[0];
					$AttackTo['shield']			= $AttackTo[1];
					$AttackTo['maxshield']		= ($this->CombatCaps[$AttackTo[0]]['shield'] * (1 + (0.1 * ($this->Techno[0][$Player][1]) + (0.05 * $this->Techno[0][$Player][3]))));
					$AttackTo['integrity']		= $AttackTo[2];
					$AttackTo['maxintegrity']	= ((($this->pricelist[$AttackTo[0]]['metal'] + $this->pricelist[$AttackTo[0]]['crystal']) / 10) * (1 + (0.1 * ($this->Techno[0][$Player][2]) + (0.05 * $this->Techno[0][$Player][3]))));
					
					$Count2++;
		
					if(($Pass['attack'] / $AttackTo['maxshield']) >= 0.01)
					{
						$ShieldRest = $Pass['attack'] - $AttackTo['shield'];
						if($ShieldRest > 0){
							$AttackTo['shield'] = 0;
							$AttackTo['integrity'] -= $ShieldRest;
							$TotalShield += ($Pass['attack'] - $ShieldRest);
													
							if(($AttackTo['integrity'] * 0.3) < $ShieldRest){
								if(mt_rand(0, 100) <= (($AttackTo['maxintegrity'] - $AttackTo['integrity']) / $AttackTo['maxintegrity'])){
									$AttackTo['integrity'] = 0;
									$AttackTo['destroyed'] = 1;
									$Destroyed2++;
									$this->Debris['metal'] += $this->pricelist[$AttackTo['ship']]['metal'] * 0.7;
									$this->Debris['crystal'] += $this->pricelist[$AttackTo['ship']]['crystal'] * 0.7;
									$LostUnits[0] += $this->pricelist[$AttackTo['ship']]['metal'] + $this->pricelist[$AttackTo['ship']]['crystal'] + $this->pricelist[$AttackTo['ship']]['deuterium'];
									unset($this->AttackersFleets[$Player][$Ship]);
								}
							}
							
						} else {
							$AttackTo['shield'] -= $Pass['attack'];
							$TotalShield  		+= $Pass['attack'];
						}
					} else {
						$TotalShield  		+= $Pass['attack'];
					}
					$TotalAttack2 += $Pass['attack'];	

					if(isset($this->AttackersFleets[$Player][$Ship]))
					{
						$this->AttackersFleets[$Player][$Ship][1]	= $AttackTo['shield'];
						$this->AttackersFleets[$Player][$Ship][2]	= $AttackTo['integrity'];
					}
					
					if(isset($this->CombatCaps[$Pass['ship']]['sd'][$AttackTo['ship']])) {
						$Rapidfire = 100 * ($this->CombatCaps[$Pass['ship']]['sd'][$AttackTo['ship']] - 1) / $this->CombatCaps[$Pass['ship']]['sd'][$AttackTo['ship']];
						$rand	= mt_rand(1, 100);
						if($rand <= $Rapidfire)
							$Fire	= true;
						else
							$Fire	= false;
					} else
						$Fire	= false;
				}
			}	
		}
		return array('attack_a' => $TotalAttack,'shield_a' => $TotalShield, 'attack_d' => $TotalAttack2, 'shield_d' => $TotalShield2, 'destroyed_a' => $Destroyed, 'destroyed_d' => $Destroyed2, 'count_a' => $Count, 'count_d' => $Count2);
	}

	private function RepairDefenses()
	{
		global $lang, $resource, $reslist, $pricelist, $CombatCaps, $game_config;
		foreach($this->DieDef as $ShipID => $Count) {
			$this->RepairOK[$ShipID]	= 0;
			
			if($Count < 10) {
				for($i = 1; $i <= $Count; $i++){
					if(mt_rand(0, 100) <= $this->DefRepFac)
						$this->RepairDef[$ShipID]++;
				}
				
			} else {
				$this->RepairDef[$ShipID]	= round((($DefenseReg + mt_rand(-10, 10)) / 100) * $Count, 0);
			}			
		}
	}	
}
?>