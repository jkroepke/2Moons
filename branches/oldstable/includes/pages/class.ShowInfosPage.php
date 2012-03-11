<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
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
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */



class ShowInfosPage
{
	private function GetNextJumpWaitTime($CurMoon, $ReturnString = false)
	{
		global $resource, $CONF;

		$RestWait   = 0;
		$RestString = "";

		$NextJumpTime   = $CurMoon['last_jump_time'] + $CONF['gate_wait_time'];
		
		if ($CurMoon[$resource[43]] > 0 && $NextJumpTime >= TIMESTAMP) {
			$RestWait   = $NextJumpTime - TIMESTAMP;
			$RestString = pretty_time($RestWait);
		}

		return $ReturnString ? $RestString : $RestWait;
	}

	private function DoFleetJump()
	{
		global $USER, $PLANET, $resource, $LNG, $db, $reslist;

		$RestString   = $this->GetNextJumpWaitTime($PLANET, true);
		$NextJumpTime = $RestString;
		$JumpTime     = TIMESTAMP;

		if (!empty($NextJumpTime))
			return json_encode(array('message' => $LNG['in_jump_gate_already_used'].' '.pretty_time($NextJumpTime), 'error' => true));
			
		$TargetPlanet = request_var('jmpto', $PLANET['id']);
		$TargetGate   = $db->uniquequery("SELECT `id`, `last_jump_time` FROM ".PLANETS." WHERE `id` = ".$TargetPlanet." AND id_owner = ".$USER['id']." AND `sprungtor` > 0;");

		if (!isset($TargetGate) || $TargetPlanet == $PLANET['id'])
			return json_encode(array('message' =>  $LNG['in_jump_gate_doesnt_have_one'], 'error' => true));
			
		$RestString   = $this->GetNextJumpWaitTime($TargetGate, true);
		
		if (!empty($RestString))
			return json_encode(array('message' =>  $LNG['in_jump_gate_not_ready_target'].' '.$RestString, 'error' => true));
		
		$ShipArray   = array();
		$SubQueryOri = "";
		$SubQueryDes = "";

		foreach($reslist['fleet'] as $Ship)
		{
			$ShipArray[$Ship]	=	min(request_var('ship'.$Ship, 0.0), $PLANET[$resource[$Ship]]);
			if($Ship == 212 || $ShipArray[$Ship] <= 0)
				continue;
				
			$SubQueryOri 		.= "`".$resource[$Ship]."` = `".$resource[$Ship]."` - '". floattostring($ShipArray[$Ship])."', ";
			$SubQueryDes 		.= "`".$resource[$Ship]."` = `".$resource[$Ship]."` + '". floattostring($ShipArray[$Ship])."', ";
			$PLANET[$resource[$Ship]] -= $ShipArray[$Ship];
		}

		if (empty($SubQueryOri))
			return json_encode(array('message' =>  $LNG['in_jump_gate_error_data'], 'error' => true));

		$SQL  = "UPDATE ".PLANETS." SET ";
		$SQL .= $SubQueryOri;
		$SQL .= "`last_jump_time` = '". $JumpTime ."' ";
		$SQL .= "WHERE ";
		$SQL .= "`id` = '". $PLANET['id'] ."';";
		$SQL .= "UPDATE ".PLANETS." SET ";
		$SQL .= $SubQueryDes;
		$SQL .= "`last_jump_time` = '". $JumpTime ."' ";
		$SQL .= "WHERE ";
		$SQL .= "`id` = '".$TargetPlanet."';";
		$db->multi_query($SQL);

		$PLANET['last_jump_time'] 	= $JumpTime;
		return json_encode(array('message' =>  sprintf($LNG['in_jump_gate_done'], $this->GetNextJumpWaitTime($PLANET, true)), 'error' => false));
	}

	private function BuildFleetListRows ($PLANET)
	{
		global $reslist, $resource, $LNG;

		foreach($reslist['fleet'] as $Ship)
		{
			if ($Ship == 212 || $PLANET[$resource[$Ship]] <= 0)
				continue;
			
			$GateFleetList[]	= array(
				'id'        => $Ship,
				'name'      => $LNG['tech'][$Ship],
				'max'       => pretty_number($PLANET[$resource[$Ship]]),
			);
		}
		
		return $GateFleetList;
	}

	private function CancelMissiles()
	{
		global $resource, $PLANET, $db;
		$Missle502	= request_outofint('missile_502');
		$Missle503	= request_outofint('missile_503');
		$PLANET[$resource[502]]	-= min($Missle502, $PLANET[$resource[502]]);
		$PLANET[$resource[503]]	-= min($Missle503, $PLANET[$resource[503]]);
		$db->query("UPDATE ".PLANETS." SET `".$resource[502]."` = '".$PLANET[$resource[502]]."', `".$resource[503]."` = '".$PLANET[$resource[503]]."' WHERE `id` = ".$PLANET['id'].";");
		echo json_encode(array(pretty_number($PLANET[$resource[502]]), pretty_number($PLANET[$resource[503]])));
	}

	private function BuildJumpableMoonCombo($USER, $PLANET)
	{
		global $resource, $db;
				
		$Order = $USER['planet_sort_order'] == 1 ? "DESC" : "ASC" ;
		$Sort  = $USER['planet_sort'];

		if($Sort == 0)
			$OrderBy	= "`id` ". $Order;
		elseif($Sort == 1)
			$OrderBy	= "`galaxy`, `system`, `planet`, `planet_type` ". $Order;
		elseif ($Sort == 2)
			$OrderBy	= "`name` ". $Order;
		
		
		$MoonList        = $db->query("SELECT `id`, `galaxy`, `system`, `planet`, `last_jump_time`, `".$resource[43]."` FROM ".PLANETS." WHERE `id` != '".$PLANET['id']."' AND `planet_type` = '3' AND `id_owner` = '". $USER['id'] ."' AND `".$resource[43]."` > '0' ORDER BY ".$OrderBy.";");
		$Combo           = array();
		while($CurMoon = $db->fetch_array($MoonList)) {
			$Time	= $this->GetNextJumpWaitTime($CurMoon, true);
			$Selector[$CurMoon['id']]	= '['.$CurMoon['galaxy'].':'.$CurMoon['system'].':'.$CurMoon['planet'].'] '.$CurMoon['name'].(!empty($Time) ? ' ('.$Time.')':'');
		}
		return $Selector;
	}

	public function __construct()
	{
		global $USER, $PLANET, $dpath, $LNG, $resource, $pricelist, $reslist, $CombatCaps, $ProdGrid, $CONF;

		$BuildID 	= request_var('gid', 0);
		
		$template	= new template();
		$template->isDialog(true);
	
		$description = $LNG['info'][$BuildID]['description'];
	
		$CurrentBuildtLvl		= $PLANET[$resource[$BuildID]];
			
		if(in_array($BuildID, $reslist['prod']) && in_array($BuildID, $reslist['build']))
		{
			$BuildLevelFactor	= 10;
			$BuildTemp       	= $PLANET['temp_max'];
			$BuildEnergy		= $USER[$resource[113]];
			$BuildLevel     	= max($CurrentBuildtLvl, 0);
			$BuildStartLvl   	= max($CurrentBuildtLvl - 2, 0);
						
			for($BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 15; $BuildLevel++)
			{
				if(isset($ProdGrid[$BuildID][901]))
				{
					$Prod[1]	= round(eval($ProdGrid[$BuildID][901]) * $CONF['resource_multiplier']);
				} else {
					$Prod[1]	= 0;
				}
				
				if(isset($ProdGrid[$BuildID][902]))
				{
					$Prod[2]	= round(eval($ProdGrid[$BuildID][902]) * $CONF['resource_multiplier']);
				} else {
					$Prod[2]	= 0;
				}
				
				if(isset($ProdGrid[$BuildID][903]))
				{
					$Prod[3]	= round(eval($ProdGrid[$BuildID][903]) * $CONF['resource_multiplier']);
				} else {
					$Prod[3]	= 0;
				}
				
				if(isset($ProdGrid[$BuildID][911]))
				{
					$Prod[4]	= round(eval($ProdGrid[$BuildID][911]));
					$Prod[12]	= round(eval($ProdGrid[$BuildID][911]));
				} else {
					$Prod[4]	= 0;
					$Prod[12]	= 0;
				}
				
				$ProductionTable[$BuildLevel] = array(
					'production'	=> $Prod[$BuildID],
					'required'		=> $BuildID != 12 ? floor($Prod[4]) : floor($Prod[3]),
				);
			}
		}
		elseif(in_array($BuildID, $reslist['fleet']))
		{
			for ($Type = 200; $Type < 500; $Type++)
			{
				if ($CombatCaps[$BuildID]['sd'][$Type] > 1)
					$RapidFire['to'][$LNG['tech'][$Type]] = $CombatCaps[$BuildID]['sd'][$Type];
					
				if ($CombatCaps[$Type]['sd'][$BuildID] > 1)
					$RapidFire['from'][$LNG['tech'][$Type]] = $CombatCaps[$Type]['sd'][$BuildID];
			}

			$FleetInfo[$LNG['in_struct_pt']]		= pretty_number($pricelist[$BuildID]['cost'][901] + $pricelist[$BuildID]['cost'][902]);
			$FleetInfo[$LNG['in_shield_pt']]		= pretty_number($CombatCaps[$BuildID]['shield']);
			$FleetInfo[$LNG['in_attack_pt']]		= pretty_number($CombatCaps[$BuildID]['attack']);
			$FleetInfo[$LNG['in_capacity']]			= pretty_number($pricelist[$BuildID]['capacity']);
			$FleetInfo[$LNG['in_base_speed']][]		= pretty_number($pricelist[$BuildID]['speed']);
			$FleetInfo[$LNG['in_consumption']][]	= pretty_number($pricelist[$BuildID]['consumption']);
			$FleetInfo[$LNG['in_base_speed']][]		= pretty_number($pricelist[$BuildID]['speed2']);
			$FleetInfo[$LNG['in_consumption']][]	= pretty_number($pricelist[$BuildID]['consumption2']);
		}
		elseif (in_array($BuildID, $reslist['defense']))
		{
			for ($Type = 200; $Type < 500; $Type++)
			{
				if ($CombatCaps[$BuildID]['sd'][$Type] > 1)
					$RapidFire['to'][$LNG['tech'][$Type]] = $CombatCaps[$BuildID]['sd'][$Type];
					
				if ($CombatCaps[$Type]['sd'][$BuildID] > 1)
					$RapidFire['from'][$LNG['tech'][$Type]] = $CombatCaps[$Type]['sd'][$BuildID];
			}

			$FleetInfo[$LNG['in_struct_pt']]		= pretty_number($pricelist[$BuildID]['cost'][901] + $pricelist[$BuildID]['cost'][902]);
			$FleetInfo[$LNG['in_shield_pt']]		= pretty_number($CombatCaps[$BuildID]['shield']);
			$FleetInfo[$LNG['in_attack_pt']]		= pretty_number($CombatCaps[$BuildID]['attack']);
		}
		elseif($BuildID == 43 && $PLANET[$resource[43]] > 0)
		{
			if($_GET['action'] == 'send')
				exit($this->DoFleetJump());
				
			$template->assign_vars(array(
				'gate_rest_time'	=> $this->GetNextJumpWaitTime($PLANET),
				'gate_start_link'	=> BuildPlanetAdressLink($PLANET),
				'gate_moons'		=> $this->BuildJumpableMoonCombo($USER, $PLANET),
				'gate_fleets'		=> $this->BuildFleetListRows($PLANET),
			));
		}
		elseif($BuildID == 44 && $PLANET[$resource[44]] > 0)
		{
			if($_GET['action'] == 'send')
				exit($this->CancelMissiles());
				
			$template->assign_vars(array(
				'missiles'			=> array(pretty_number($PLANET[$resource[502]]), pretty_number($PLANET[$resource[503]])),
				'tech_502'			=> $LNG['tech'][502],
				'tech_503'			=> $LNG['tech'][503],
				'in_missilestype'	=> $LNG['in_missilestype'],
				'in_missilesamount'	=> $LNG['in_missilesamount'],
				'in_destroy'		=> $LNG['in_destroy'],
			));
		}
		elseif(in_array($BuildID, $reslist['officier']))
		{
			$description = $pricelist[$BuildID]['info'] ? sprintf($LNG['info'][$BuildID]['description'], ((is_float($pricelist[$BuildID]['info']))? $pricelist[$BuildID]['info'] * 100 : $pricelist[$BuildID]['info']), $pricelist[$BuildID]['max']) : sprintf($LNG['info'][$BuildID]['description'], $pricelist[$BuildID]['max']);
		}

		$template->assign_vars(array(		
			'id'							=> $BuildID,
			'name'							=> $LNG['info'][$BuildID]['name'],
			'image'							=> $BuildID,
			'description'					=> $description,
			'ProductionTable'				=> $ProductionTable,
			'RapidFire'						=> $RapidFire,
			'Level'							=> $CurrentBuildtLvl,
			'FleetInfo'						=> $FleetInfo,
			'dpath'							=> $USER['dpath'],
			'in_jump_gate_jump' 			=> $LNG['in_jump_gate_jump'],
			'gate_ship_dispo' 				=> $LNG['in_jump_gate_available'],
			'in_level'						=> $LNG['in_level'],
			'in_prod_p_hour'				=> $LNG['in_prod_p_hour'],
			'in_difference'					=> $LNG['in_difference'],
			'in_used_energy'				=> $LNG['in_used_energy'],
			'in_prod_energy'				=> $LNG['in_prod_energy'],
			'in_used_deuter'				=> $LNG['in_used_deuter'],
			'in_rf_again'					=> $LNG['in_rf_again'],
			'in_rf_from'					=> $LNG['in_rf_from'],
			'in_jump_gate_select_ships'		=> $LNG['in_jump_gate_select_ships'],
			'in_jump_gate_start_moon'		=> $LNG['in_jump_gate_start_moon'],
			'in_jump_gate_finish_moon'		=> $LNG['in_jump_gate_finish_moon'],
			'in_jump_gate_wait_time'		=> $LNG['in_jump_gate_wait_time'],
		));
		
		$template->show('info_overview.tpl');
	}
}
?>