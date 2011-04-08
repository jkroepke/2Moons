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
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

require_once(ROOT_PATH . 'includes/classes/class.FleetFunctions.php');

class ShowFleetPages extends FleetFunctions
{
	public static function ShowFleetPage()
	{
		global $USER, $PLANET, $reslist, $resource, $db, $LNG, $ExtraDM;

		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		$PlanetRess->SavePlanetToDB();
		
		$parse				= $LNG;
		$FleetID			= request_var('fleetid', 0);
		$GetAction			= request_var('action', "");
	
		$template	= new template();
		$template->loadscript('flotten.js');
		
		if(!empty($FleetID))
		{
			switch($GetAction){
				case "sendfleetback":
					parent::SendFleetBack($USER, $FleetID);
				break;
				case "getakspage":
					$template->assign_vars(parent::GetAKSPage($USER, $PLANET, $FleetID));
				break;
			}
		}
		

		$MaxExpedition      = $USER[$resource[124]];

		if ($MaxExpedition >= 1)
		{
			$ExpeditionEnCours  = parent::GetCurrentFleets($USER['id'], 15);
			$EnvoiMaxExpedition = floor(sqrt($MaxExpedition));
		}
		else
		{
			$ExpeditionEnCours 	= 0;
			$EnvoiMaxExpedition = 0;
		}

		$MaxFlottes     = parent::GetMaxFleetSlots($USER);

		$galaxy         = request_var('galaxy', $PLANET['galaxy']);
		$system         = request_var('system', $PLANET['system']);
		$planet         = request_var('planet', $PLANET['planet']);
		$planettype     = request_var('planettype', $PLANET['planet_type']);
		$target_mission = request_var('target_mission', 0);
		
		$CurrentFleets 		= $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_owner` = '".$USER['id']."' AND `fleet_mission` <> 10 ORDER BY `fleet_end_time` ASC;");
		$CountCurrentFleets	= $db->num_rows($CurrentFleets);

		while ($CurrentFleetsRow = $db->fetch_array($CurrentFleets))
		{
			$fleet = explode(";", $CurrentFleetsRow['fleet_array']);
			foreach ($fleet as $ShipID => $ShipCount)
			{
				if (empty($ShipCount))
					continue;

				$a = explode(",", $ShipCount);
				$FleetList[$CurrentFleetsRow['fleet_id']][$LNG['tech'][$a[0]]] = pretty_number($a[1]);
			}
			
			$FlyingFleetList[]	= array(
				'id'			=> $CurrentFleetsRow['fleet_id'],
				'mission'		=> $CurrentFleetsRow['fleet_mission'],
				'missionname'	=> $LNG['type_mission'][$CurrentFleetsRow['fleet_mission']],
				'way'			=> $CurrentFleetsRow['fleet_mess'],
				'start_galaxy'	=> $CurrentFleetsRow['fleet_start_galaxy'],
				'start_system'	=> $CurrentFleetsRow['fleet_start_system'],
				'start_planet'	=> $CurrentFleetsRow['fleet_start_planet'],
				'start_time'	=> date(TDFORMAT, $CurrentFleetsRow['fleet_start_time']),
				'end_galaxy'	=> $CurrentFleetsRow['fleet_end_galaxy'],
				'end_system'	=> $CurrentFleetsRow['fleet_end_system'],
				'end_planet'	=> $CurrentFleetsRow['fleet_end_planet'],
				'end_time'		=> date(TDFORMAT, $CurrentFleetsRow['fleet_end_time']),
				'amount'		=> pretty_number($CurrentFleetsRow['fleet_amount']),
				'backin'		=> pretty_time(floor($CurrentFleetsRow['fleet_end_time'] - TIMESTAMP)),
				'FleetList'		=> $FleetList[$CurrentFleetsRow['fleet_id']],
			);
		}

		$db->free_result($CurrentFleets);
		
		foreach($reslist['fleet'] as $FleetID)
		{
			if ($PLANET[$resource[$FleetID]] > 0)
			{
				$FleetsOnPlanet[]	= array(
					'id'	=> $FleetID,
					'name'	=> $LNG['tech'][$FleetID],
					'speed'	=> parent::GetFleetMaxSpeed($FleetID, $USER),
					'count'	=> pretty_number($PLANET[$resource[$FleetID]]),
				);
			}
		}
		
		$template->assign_vars(array(
			'FleetsOnPlanet'		=> $FleetsOnPlanet,
			'FlyingFleetList'		=> $FlyingFleetList,
			'fl_number'				=> $LNG['fl_number'],
			'fl_mission'			=> $LNG['fl_mission'],
			'fl_ammount'			=> $LNG['fl_ammount'],
			'fl_beginning'			=> $LNG['fl_beginning'],
			'fl_departure'			=> $LNG['fl_departure'],
			'fl_destiny'			=> $LNG['fl_destiny'],
			'fl_objective'			=> $LNG['fl_objective'],
			'fl_arrival'			=> $LNG['fl_arrival'],
			'fl_order'				=> $LNG['fl_order'],
			'fl_new_mission_title'	=> $LNG['fl_new_mission_title'],
			'fl_ship_type'			=> $LNG['fl_ship_type'],
			'fl_ship_available'		=> $LNG['fl_ship_available'],
			'fl_fleets'				=> $LNG['fl_fleets'],
			'fl_expeditions'		=> $LNG['fl_expeditions'],
			'fl_speed_title'		=> $LNG['fl_speed_title'],
			'fl_max'				=> $LNG['fl_max'],
			'fl_no_more_slots'		=> $LNG['fl_no_more_slots'],
			'fl_continue'			=> $LNG['fl_continue'],
			'fl_no_ships'			=> $LNG['fl_no_ships'],
			'fl_select_all_ships'	=> $LNG['fl_select_all_ships'],
			'fl_remove_all_ships'	=> $LNG['fl_remove_all_ships'],
			'fl_acs'				=> $LNG['fl_acs'],
			'fl_send_back'			=> $LNG['fl_send_back'],
			'fl_returning'			=> $LNG['fl_returning'],
			'fl_r'					=> $LNG['fl_r'],
			'fl_onway'				=> $LNG['fl_onway'],
			'fl_a'					=> $LNG['fl_a'],
			'fl_info_detail'		=> $LNG['fl_info_detail'],
			'fl_bonus'				=> $LNG['fl_bonus'],
			'fl_bonus_attack'		=> $LNG['fl_bonus_attack'],
			'fl_bonus_defensive'	=> $LNG['fl_bonus_defensive'],
			'fl_bonus_shield'		=> $LNG['fl_bonus_shield'],
			'bonus_comp'			=> $LNG['tech'][115],
			'bonus_impul'			=> $LNG['tech'][117],
			'bonus_hyper'			=> $LNG['tech'][118],
			'galaxy'				=> $galaxy,
			'system'				=> $system,
			'planet'				=> $planet,
			'planettype'			=> $planettype,
			'target_mission'		=> $target_mission,
			'envoimaxexpedition'	=> $EnvoiMaxExpedition,
			'expeditionencours'		=> $ExpeditionEnCours,
			'flyingfleets'			=> $CountCurrentFleets,
			'maxfleets'				=> $MaxFlottes,
			'target_mission'		=> $target_mission,
			'currentexpeditions' 	=> $ExpeditionEnCours,
			'maxexpeditions'		=> $EnvoiMaxExpedition,
			'slots_available'		=> ($MaxFlottes <= $MaxFlyingFleets - $MaxFlyingRaks) ? false : true,
			'AKSPage'				=> $AKSPage,
			'bonus_attack'			=> $USER[$resource[109]] * 10 + ($USER['factor']['attack'] * 100),
			'bonus_defensive'		=> $USER[$resource[110]] * 10 + ($USER['factor']['defensive'] * 100),
			'bonus_shield'			=> $USER[$resource[111]] * 10 + ($USER['factor']['shield'] * 100),
			'bonus_combustion'		=> $USER[$resource[115]] * 10 + ($USER['factor']['shipspeed'] * 100) - 100,
			'bonus_impulse'			=> $USER[$resource[117]] * 20 + ($USER['factor']['shipspeed'] * 100) - 100,
			'bonus_hyperspace'		=> $USER[$resource[118]] * 30 + ($USER['factor']['shipspeed'] * 100) - 100,
		));
		$template->show('fleet_table.tpl');
	}

	public static function ShowFleet1Page()
	{
		global $USER, $PLANET, $resource, $pricelist, $reslist, $db, $LNG, $ExtraDM, $OfficerInfo;
		$TargetGalaxy 					= request_var('galaxy', $PLANET['galaxy']);
		$TargetSystem 					= request_var('system', $PLANET['system']);
		$TargetPlanet					= request_var('planet', $PLANET['planet']);
		$TargetPlanettype 				= request_var('planet_type', $PLANET['planet_type']);
		
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		$PlanetRess->SavePlanetToDB();
		
		$template	= new template();
		$template->getplanets();
		
		$template->loadscript('flotten.js');

		foreach ($reslist['fleet'] as $id => $ShipID)
		{
			$amount		 				= min(request_var('ship'.$ShipID, '0') + 0, $PLANET[$resource[$ShipID]] + 0);
			
			if ($amount <= 0 || $ShipID == 212 || !is_numeric($amount)) continue;

			$Fleet[$ShipID]				= $amount;
			$FleetRoom			   	   += $pricelist[$ShipID]['capacity'] * $amount;
		}
		
		
		if (!is_array($Fleet))
			parent::GotoFleetPage();

		$template->execscript('updateVars();FleetTime();window.setInterval("FleetTime()", 1000);');
	
		$FleetData	= array(
			'fleetroom'			=> floattostring($FleetRoom),
			'gamespeed'			=> parent::GetGameSpeedFactor(),
			'fleetspeedfactor'	=> (1 - DMExtra($USER[$resource[706]], TIMESTAMP,$ExtraDM[706]['add'], 0) - ($OfficerInfo[613]['info'] * $USER['rpg_general'])),
			'planet'			=> array('galaxy' => $PLANET['galaxy'], 'system' => $PLANET['system'], 'planet' => $PLANET['planet'], 'planet_type' => $PLANET['planet_type']),
			'maxspeed'			=> parent::GetFleetMaxSpeed($Fleet, $USER),
			'ships'				=> parent::GetFleetShipInfo($Fleet, $USER),
		);
		
		$template->assign_vars(array(
			'mission'				=> request_var('target_mission', 0),
			'Shoutcutlist'			=> !CheckModule(40) ? parent::GetUserShotcut($USER) : array(),
			'Colonylist' 			=> parent::GetColonyList($template->UserPlanets),
			'AKSList' 				=> parent::IsAKS($USER['id']),
			'AvailableSpeeds'		=> parent::GetAvailableSpeeds(),
			'fleetarray'			=> parent::SetFleetArray($Fleet),
			'galaxy_post' 			=> $TargetGalaxy,
			'system_post' 			=> $TargetSystem,
			'planet_post' 			=> $TargetPlanet,
			'fleetdata'				=> json_encode($FleetData),
			'options_selector'    	=> array(1 => $LNG['fl_planet'], 2 => $LNG['fl_debris'], 3 => $LNG['fl_moon']),
			'options'				=> $TargetPlanettype,
			'fl_send_fleet'			=> $LNG['fl_send_fleet'],
			'fl_destiny'			=> $LNG['fl_destiny'],
			'fl_fleet_speed'		=> $LNG['fl_fleet_speed'],
			'fl_distance'			=> $LNG['fl_distance'],
			'fl_flying_time'		=> $LNG['fl_flying_time'],
			'fl_fuel_consumption'	=> $LNG['fl_fuel_consumption'],
			'fl_max_speed'			=> $LNG['fl_max_speed'],
			'fl_cargo_capacity'		=> $LNG['fl_cargo_capacity'],
			'fl_shortcut'			=> $LNG['fl_shortcut'],
			'fl_shortcut_add_edit'	=> $LNG['fl_shortcut_add_edit'],
			'fl_no_shortcuts'		=> $LNG['fl_no_shortcuts'],
			'fl_planet_shortcut'	=> $LNG['fl_planet_shortcut'],
			'fl_debris_shortcut'	=> $LNG['fl_debris_shortcut'],
			'fl_moon_shortcut'		=> $LNG['fl_moon_shortcut'],
			'fl_my_planets'			=> $LNG['fl_my_planets'],
			'fl_acs_title'			=> $LNG['fl_acs_title'],
			'fl_continue'			=> $LNG['fl_continue'],
			'fl_no_colony'			=> $LNG['fl_no_colony'],
			'fl_flying_arrival'		=> $LNG['fl_flying_arrival'],
			'fl_flying_return'		=> $LNG['fl_flying_return'],
		));
		
		$template->show('fleet1_table.tpl');
	}
	
	public static function ShowFleet2Page()
	{
		global $USER, $PLANET, $db, $LNG;
	
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		$PlanetRess->SavePlanetToDB();
		
		$template	= new template();
		$template->loadscript('flotten.js');
		
		$TargetGalaxy  				= request_var('galaxy', 0);
		$TargetSystem   			= request_var('system', 0);
		$TargetPlanet   			= request_var('planet', 0);
		$TargetPlanettype 			= request_var('planettype', 0);
		$TargetMission 				= request_var('mission', 0);
		$GenFleetSpeed  			= request_var('speed', 0);		
		$fleet_group 				= request_var('fleet_group', 0);
		$usedfleet					= request_var('usedfleet','', true);

		$FleetArray    				= parent::GetFleetArray($usedfleet);
		
		if($TargetPlanettype == 2)
		{
			$GetInfoPlanet 			= $db->uniquequery("SELECT `id_owner`, `der_metal`, `der_crystal` FROM `".PLANETS."` WHERE `galaxy` = ".$TargetGalaxy ." AND `system` = ".$TargetSystem." AND `planet` = ".$TargetPlanet." AND `planet_type` = '1';");
			if($GetInfoPlanet['der_metal'] == 0 && $GetInfoPlanet['der_crystal'] == 0)
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_no_empty_derbis']."</b></font>", "game.php?page=fleet", 2);
				exit;
			}	
		}
		
		$MisInfo['galaxy']     		= $TargetGalaxy;		
		$MisInfo['system'] 	  		= $TargetSystem;	
		$MisInfo['planet'] 	  		= $TargetPlanet;		
		$MisInfo['planettype'] 		= $TargetPlanettype;	
		$MisInfo['IsAKS']			= $fleet_group;
		$MisInfo['Ship'] 			= $FleetArray;		
		$MisInfo['CurrentUser']		= $USER;
		
		$MissionOutput	 			= parent::GetFleetMissions($MisInfo);
		
		if(empty($MissionOutput))
		{
			$template->message("<font color=\"red\"><b>". $LNG['fl_empty_target']."</b></font>", "game.php?page=fleet", 2);
			exit;
		}
		
		$GameSpeedFactor   		 	= parent::GetGameSpeedFactor();		
		$MaxFleetSpeed 				= parent::GetFleetMaxSpeed($FleetArray, $USER);
		$distance      				= parent::GetTargetDistance($PLANET['galaxy'], $TargetGalaxy, $PLANET['system'], $TargetSystem, $PLANET['planet'], $TargetPlanet);
		$duration      				= parent::GetMissionDuration($GenFleetSpeed, $MaxFleetSpeed, $distance, $GameSpeedFactor, $USER);
		$consumption				= parent::GetFleetConsumption($FleetArray, $duration, $distance, $MaxFleetSpeed, $USER, $GameSpeedFactor);
 		
		if($consumption > $PLANET['deuterium'])
		{
			$template->message("<font color=\"red\"><b>". sprintf($LNG['fl_no_enought_deuterium'], $LNG['Deuterium'], pretty_number($PLANET['deuterium'] - $consumption), $LNG['Deuterium'])."</b></font>", "game.php?page=fleet", 2);
			exit;
		}
		
		if(!empty($fleet_group))
			$TargetMission	= 2;

		$FleetData	= array(
			'fleetroom'			=> floattostring(parent::GetFleetRoom($FleetArray)),
			'consumption'		=> floattostring($consumption),
		);
			
		$template->execscript('calculateTransportCapacity();');
		$template->assign_vars(array(
			'fleetdata'						=> json_encode($FleetData),
			'consumption'					=> floattostring($consumption),
			'mission'						=> $TargetMission,
			'galaxy_post' 					=> $TargetGalaxy,
			'system_post' 					=> $TargetSystem,
			'thisgalaxy'			 		=> $PLANET['galaxy'],
			'thissystem'			 		=> $PLANET['system'],
			'thisplanet'			 		=> $PLANET['planet'],
			'thisplanet_type'			 	=> $PLANET['planet_type'],
			'MissionSelector' 				=> $MissionOutput['MissionSelector'],
			'StaySelector' 					=> $MissionOutput['StayBlock'],
			'fl_planet'						=> $LNG['fl_planet'], 
			'fl_moon'						=> $LNG['fl_moon'],
			'fl_mission'					=> $LNG['fl_mission'],
			'fl_resources'					=> $LNG['fl_resources'],
			'fl_max'						=> $LNG['fl_max'],
			'fl_resources_left'				=> $LNG['fl_resources_left'],
			'fl_all_resources'				=> $LNG['fl_all_resources'],
			'fl_fuel_consumption'			=> $LNG['fl_fuel_consumption'],
			'fl_hours'						=> $LNG['fl_hours'],
			'fl_hold_time'					=> $LNG['fl_hold_time'],
			'fl_expedition_alert_message'	=> $LNG['fl_expedition_alert_message'],
			'fl_dm_alert_message'			=> sprintf($LNG['fl_dm_alert_message'], $LNG['type_mission'][11], $LNG['Darkmatter']),
			'fl_continue'					=> $LNG['fl_continue'],
			'fleetarray'					=> $usedfleet,
			'galaxy'						=> $TargetGalaxy,
			'system'						=> $TargetSystem,
			'planet'						=> $TargetPlanet,
			'planettype'					=> $TargetPlanettype,
			'fleet_group'					=> $fleet_group,
			'speed' 						=> $GenFleetSpeed,
		));
		
		$template->show('fleet2_table.tpl');
	}

	public static function ShowFleet3Page()
	{
		global $USER, $PLANET, $resource, $pricelist, $reslist, $CONF, $db, $LNG, $UNI;

		include_once(ROOT_PATH . 'includes/functions/IsVacationMode.php');

		$template	= new template();
		$template->loadscript('flotten.js');
		$template->gotoside('?page=fleet');

		
		$mission 				= request_var('mission', 3);
		$galaxy     			= request_var('galaxy', 0);
		$system     			= request_var('system', 0);
		$planet     			= request_var('planet', 0);
		$planettype 			= request_var('planettype', 0);
		$fleet_group		 	= request_var('fleet_group', 0);
		$GenFleetSpeed		 	= request_var('speed', 0);
		$TransportMetal			= request_outofint('metal');
		$TransportCrystal		= request_outofint('crystal');
		$TransportDeuterium		= request_outofint('deuterium');
		$holdingtime 			= request_var('holdingtime', 0);
		$rawfleetarray			= request_var('usedfleet', '', true);

		if (IsVacationMode($USER))
			exit($template->message($LNG['fl_vacation_mode_active'], 'game.php?page=overview', 2));

		if ($_SESSION['last']['user_side'] != 'game.php?page=fleet2')
			parent::GotoFleetPage();
	
		if (!($planettype >= 1 || $planettype <= 3))
			parent::GotoFleetPage();
			
		if ($PLANET['galaxy'] == $galaxy && $PLANET['system'] == $system && $PLANET['planet'] == $planet && $PLANET['planet_type'] == $planettype)
			parent::GotoFleetPage();

		if ($galaxy > $CONF['max_galaxy'] || $galaxy < 1 || $system > $CONF['max_system'] || $system < 1 || $planet > ($CONF['max_planets'] + 1) || $planet < 1)
			parent::GotoFleetPage();
			
		if (empty($mission))
			parent::GotoFleetPage();	
		
		if (!is_numeric($TransportMetal) || !is_numeric($TransportCrystal) || !is_numeric($TransportDeuterium))
			parent::GotoFleetPage();

		if ($TransportMetal + $TransportCrystal + $TransportDeuterium < 1 && $mission == 3)
		{
			$template->message("<font color=\"lime\"><b>".$LNG['fl_empty_transport']."</b></font>", "game.php?page=fleet", 1);
			exit;
		}
			
		$ActualFleets		= parent::GetCurrentFleets($USER['id']);
		
		if (parent::GetMaxFleetSlots($USER) <= $ActualFleets)
		{
			$template->message($LNG['fl_no_slots'], "game.php?page=fleet", 1);
			exit;
		}
			
		$fleet_group_mr = 0;
		if(!empty($fleet_group) && $mission == 2)
		{
			$aks_count_mr = $db->uniquequery("SELECT COUNT(*) as state FROM ".AKS." WHERE `id` = '".$fleet_group."' AND `eingeladen` LIKE '%".$USER['id']."%';");
			if ($aks_count_mr['state'] > 0)
				$fleet_group_mr = $fleet_group;
			else
				$mission = 1;
		}
				
		$ActualFleets 		= parent::GetCurrentFleets($USER['id']);
		
		$TargetPlanet  		= $db->uniquequery("SELECT `id`, `id_owner`,`destruyed`,`ally_deposit` FROM ".PLANETS." WHERE `universe` = '".$UNI."' AND `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."' AND `planet_type` = '".($planettype == 2 ? 1 : $planettype)."';");

		if (($mission != 15 && $TargetPlanet["destruyed"] != 0) || ($mission != 15 && $mission != 7 && empty($TargetPlanet['id_owner'])))
			parent::GotoFleetPage();

		$MyDBRec       		= $USER;

		$FleetArray  		= parent::GetFleetArray($rawfleetarray);
		
		if (!is_array($FleetArray))
			parent::GotoFleetPage();
				
		$FleetStorage        = 0;
		$FleetShipCount      = 0;
		$fleet_array         = "";
		$FleetSubQRY         = "";
		
		foreach ($FleetArray as $Ship => $Count)
		{
			if ($Count > $PLANET[$resource[$Ship]] || $Count < 0)
				parent::GotoFleetPage();
				
			$FleetStorage    += $pricelist[$Ship]["capacity"] * $Count;
			$FleetShipCount  += $Count;
			$fleet_array     .= $Ship .",". $Count .";";
			$FleetSubQRY     .= "`".$resource[$Ship] . "` = `".$resource[$Ship]."` - '".floattostring($Count)."', ";
		}

		$error              = 0;
		$fleetmission       = $mission;

		$YourPlanet = false;
		$UsedPlanet = false;
	
		if ($mission == 11)
		{
			$maxexpde = parent::GetCurrentFleets($USER['id'], 11);

			if ($maxexpde >= $CONF['max_dm_missions'])
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_expedition_fleets_limit']."</b></font>", "game.php?page=fleet", 2);
				exit;
			}
		}
		elseif ($mission == 15)
		{
			$MaxExpedition = $USER[$resource[124]];

			if ($MaxExpedition == 0)
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_expedition_tech_required']."</b></font>", "game.php?page=fleet", 2);
				exit;
			}			
							
			$ExpeditionEnCours	= parent::GetCurrentFleets($USER['id'], 15);
			$EnvoiMaxExpedition = floor(sqrt($MaxExpedition));
			
			if ($ExpeditionEnCours >= $EnvoiMaxExpedition)
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_expedition_fleets_limit']."</b></font>", "game.php?page=fleet", 2);
				exit;
			}
		}

		$YourPlanet 	= (isset($TargetPlanet['id_owner']) && $TargetPlanet['id_owner'] == $USER['id']) ? true : false;
		$UsedPlanet 	= (isset($TargetPlanet['id_owner'])) ? true : false;

		$HeDBRec 		= ($YourPlanet) ? $MyDBRec : GetUserByID($TargetPlanet['id_owner'], array('id','onlinetime','ally_id', 'urlaubs_modus', 'banaday', 'authattack'));

		if ($HeDBRec['urlaubs_modus'] && $mission != 8)
		{
			$template->message("<font color=\"lime\"><b>".$LNG['fl_in_vacation_player']."</b></font>", "game.php?page=fleet", 2);
			exit;
		}
		
		if(!$YourPlanet && ($mission == 1 || $mission == 2 || $mission == 5 || $mission == 6 || $mission == 9))
		{
			if($CONF['adm_attack'] == 1 && $UsedPlanet['authattack'] > $USER['authlevel'])
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_admins_cannot_be_attacked']."</b></font>", "game.php?page=fleet", 2);
				exit;
			}
			
			$UserPoints    	= $USER;
			$User2Points  	= $db->uniquequery("SELECT `total_points` FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `id_owner` = '".$HeDBRec['id']."';");
		
			$IsNoobProtec	= CheckNoobProtec($UserPoints, $User2Points, $HeDBRec);
			
			if ($IsNoobProtec['NoobPlayer'])
			{
				$template->message("<font color=\"lime\"><b>".$LNG['fl_week_player']."</b></font>", "game.php?page=fleet", 2);
				exit;
			}
			elseif ($IsNoobProtec['StrongPlayer'])
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_strong_player']."</b></font>", "game.php?page=fleet", 2);
				exit;
			}
		}

		if ($mission == 5)
		{
			
			if ($TargetPlanet['ally_deposit'] < 1)
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_not_ally_deposit']."</b></font>", "game.php?page=fleet", 2);
				exit;
			}
			
			$buddy	= $db->uniquequery("SELECT COUNT(*) as state FROM ".BUDDY." WHERE `active` = '1' AND (`owner` = '".$HeDBRec['id']."' AND `sender` = '".$MyDBRec['id']."') OR (`owner` = '".$MyDBRec['id']."' AND `sender` = '".$HeDBRec['id']."');");
						
			if($HeDBRec['ally_id'] != $MyDBRec['ally_id'] && $buddy['state'] == 0)
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_no_same_alliance']."</b></font>", "game.php?page=fleet", 2);
				exit;
			}		
		}
		if(!parent::CheckUserSpeed($GenFleetSpeed) || !array_key_exists($mission, parent::GetAvailableMissions(array('CurrentUser' => $USER,'galaxy' => $galaxy, 'system' => $system, 'planet' => $planet, 'planettype' => $planettype, 'IsAKS' => $fleet_group, 'Ship' => $FleetArray))))
			parent::GotoFleetPage();


		$MaxFleetSpeed 	= parent::GetFleetMaxSpeed($FleetArray, $USER);
		$SpeedFactor    = parent::GetGameSpeedFactor();
		$distance      	= parent::GetTargetDistance($PLANET['galaxy'], $galaxy, $PLANET['system'], $system, $PLANET['planet'], $planet);
		$duration      	= parent::GetMissionDuration($GenFleetSpeed, $MaxFleetSpeed, $distance, $SpeedFactor, $USER);
		$consumption   	= parent::GetFleetConsumption($FleetArray, $duration, $distance, $MaxFleetSpeed, $USER, $SpeedFactor);
			
		$fleet['start_time'] = $duration + TIMESTAMP;
		
		if ($mission == 15)
		{
			$StayDuration    = (max($holdingtime, 1) * 3600) / $CONF['halt_speed'];
			$StayTime        = $fleet['start_time'] + $StayDuration;
		}
		elseif ($mission == 5)
		{
			$StayDuration    = $holdingtime * 3600;
			$StayTime        = $fleet['start_time'] + $StayDuration;
		}
		elseif ($mission == 11)
		{
			$StayDuration    = 3600 / $CONF['halt_speed'];
			$StayTime        = $fleet['start_time'] + $StayDuration;
		}
		else
		{
			$StayDuration    = 0;
			$StayTime        = 0;
		}

		$fleet['end_time']   = $StayDuration + (2 * $duration) + TIMESTAMP;


		$FleetStorage       -= $consumption;
		
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		
		$TransportMetal		 = min($TransportMetal, $PLANET['metal']);
		$TransportCrystal 	 = min($TransportCrystal, $PLANET['crystal']);
		$TransportDeuterium  = min($TransportDeuterium, ($PLANET['deuterium'] - $consumption));

		$StorageNeeded   	 = $TransportMetal + $TransportCrystal + $TransportDeuterium;
		
		$StockMetal      	 = $PLANET['metal'];
		$StockCrystal    	 = $PLANET['crystal'];
		$StockDeuterium  	 = $PLANET['deuterium'];
		$StockDeuterium 	-= $consumption;

		if ($PLANET['deuterium'] < $consumption)
		{
			$template->message("<font color=\"red\"><b>".sprintf($LNG['fl_no_enought_deuterium'], $LNG['Deuterium'], pretty_number($consumption - $PLANET['deuterium']), $LNG['Deuterium'])."</b></font>", "game.php?page=fleet", 2);
			exit;
		}
		
		if ($StorageNeeded > $FleetStorage)
		{
			$template->message("<font color=\"red\"><b>". $LNG['fl_no_enought_cargo_capacity'] . pretty_number($StorageNeeded - $FleetStorage)."</b></font>", "game.php?page=fleet", 2);
			exit;
		}
				
		$PLANET['metal']		-= $TransportMetal;
		$PLANET['crystal']		-= $TransportCrystal;
		$PLANET['deuterium']	-= ($TransportDeuterium + $consumption);
		$PlanetRess->SavePlanetToDB();
		
		if(connection_aborted())
			exit;
		
		if ($fleet_group_mr != 0)
		{
			$AksStartTime = $db->uniquequery("SELECT MAX(`fleet_start_time`) AS Start FROM ".FLEETS." WHERE `fleet_group` = '".$fleet_group_mr."' AND '".$CONF['max_fleets_per_acs']."' > (SELECT COUNT(*) FROM ".FLEETS." WHERE `fleet_group` = '".$fleet_group_mr."');");
			if (isset($AksStartTime)) 
			{
				if ($AksStartTime['Start'] >= $fleet['start_time'])
				{
					$fleet['end_time'] 	   += $AksStartTime['Start'] - $fleet['start_time'];
					$fleet['start_time'] 	= $AksStartTime['Start'];
				}
				else
				{
					$SQLFleets = "UPDATE ".FLEETS." SET ";
					$SQLFleets .= "`fleet_start_time` = '".$fleet['start_time']."', ";
					$SQLFleets .= "`fleet_end_time` = fleet_end_time + '".($fleet['start_time'] - $AksStartTime['Start'])."' ";
					$SQLFleets .= "WHERE ";
					$SQLFleets .= "`fleet_group` = '".$fleet_group_mr."';";
					$db->query($SQLFleets);
					$fleet['end_time'] 	    += $fleet['start_time'] - $AksStartTime['Start'];
				}
			} else {
				$mission	= 1;
			}
		}
		
		$QryInsertFleet  = "LOCK TABLE ".FLEETS." WRITE, ".PLANETS." WRITE;
							INSERT INTO ".FLEETS." SET 
							`fleet_owner` = '".$USER['id']."', 
							`fleet_mission` = '".$mission."',
							`fleet_amount` = '".$FleetShipCount."',
						    `fleet_array` = '".$fleet_array."',
						    `fleet_universe` = '".$UNI."',
							`fleet_start_time` = '".$fleet['start_time']."',
							`fleet_start_id` = '".$PLANET['id']."',
							`fleet_start_galaxy` = '".$PLANET['galaxy']."',
							`fleet_start_system` = '".$PLANET['system']."',
							`fleet_start_planet` = '".$PLANET['planet']."',
							`fleet_start_type` = '".$PLANET['planet_type']."',
							`fleet_end_time` = '".$fleet['end_time']."',
							`fleet_end_stay` = '".$StayTime."',
							`fleet_end_id` = '".(int)$TargetPlanet['id']."',
							`fleet_end_galaxy` = '".$galaxy."',
							`fleet_end_system` = '".$system."',
							`fleet_end_planet` = '".$planet."',
							`fleet_end_type` = '".$planettype."',
							`fleet_resource_metal` = '".floattostring($TransportMetal)."',
							`fleet_resource_crystal` = '".floattostring($TransportCrystal)."',
							`fleet_resource_deuterium` = '".floattostring($TransportDeuterium)."',
							`fleet_target_owner` = '".(int)$TargetPlanet['id_owner']."',
							`fleet_group` = '".$fleet_group_mr."',
							`start_time` = '".TIMESTAMP."';
							UPDATE `".PLANETS."` SET
							".substr($FleetSubQRY,0,-2)."
							WHERE
							`id` = ". $PLANET['id'] ." LIMIT 1;
							UNLOCK TABLES;";


		$db->multi_query($QryInsertFleet);
	
		foreach ($FleetArray as $Ship => $Count)
		{
			$FleetList[$LNG['tech'][$Ship]]	= pretty_number($Count);
		}
	
		$template->assign_vars(array(
			'mission' 				=> $LNG['type_mission'][$mission],
			'distance' 				=> pretty_number($distance),
			'consumption' 			=> pretty_number($consumption),
			'from' 					=> $PLANET['galaxy'] .":". $PLANET['system']. ":". $PLANET['planet'],
			'destination'			=> $galaxy .":". $system .":". $planet,
			'start_time' 			=> date(TDFORMAT, $fleet['start_time']),
			'end_time' 				=> date(TDFORMAT, $fleet['end_time']),
			'speedallsmin'		 	=> $MaxFleetSpeed,
			'FleetList'				=> $FleetList,
			'fl_fleet_sended'		=> $LNG['fl_fleet_sended'],
			'fl_mission'			=> $LNG['fl_mission'],
			'fl_from'				=> $LNG['fl_from'],
			'fl_destiny'			=> $LNG['fl_destiny'],
			'fl_distance'			=> $LNG['fl_distance'],
			'fl_fleet_speed'		=> $LNG['fl_fleet_speed'],
			'fl_fuel_consumption'	=> $LNG['fl_fuel_consumption'],
			'fl_fromfl_destiny'		=> $LNG['fl_fromfl_destiny'],
			'fl_arrival_time'		=> $LNG['fl_arrival_time'],
			'fl_return_time'		=> $LNG['fl_return_time'],
			'fl_fleet'				=> $LNG['fl_fleet'],
		));
		
		$template->show('fleet3_table.tpl');
		
	}

	public static function FleetAjax()
	{
		global $USER, $PLANET, $db, $resource, $LNG, $CONF, $UNI;
		$UserSpyProbes  = $PLANET[$resource[210]];
		$UserRecycles   = $PLANET[$resource[209]];
		$UserGRecycles  = $PLANET[$resource[219]];
		$UserDeuterium  = $PLANET['deuterium'];
		$UserMissiles   = $PLANET['interplanetary_misil'];
		$PLANET['galaxy']		= $PLANET['galaxy'];
		$PLANET['system']		= $PLANET['system'];
		$PLANET['planet']		= $PLANET['planet'];
		$PLANET['planet_type'] = $PLANET['planet_type'];
		
		$galaxy 		= request_var('galaxy', 0);
		$system 		= request_var('system', 0);
		$planet 		= request_var('planet', 0);
		$planettype		= request_var('planettype', 0);
		$mission		= request_var('mission', 0);
		
		$CurrentFlyingFleets = parent::GetCurrentFleets($USER['id']);	
		switch($mission)
		{
			case 6:
				$SpyProbes	= request_var('ships', 0);
				$SpyProbes	= min($SpyProbes, $PLANET[$resource[210]]);
				if(empty($SpyProbes))
					exit($ResultMessage = "611; ".$LNG['fa_no_spios']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
					
				$FleetArray = array(210 => $SpyProbes);
			break;
			case 8:
				$SRecycles	= explode("|", request_var('ships', ''));
				$GRecycles	= min($SRecycles[0], $PLANET[$resource[219]]);
				$Recycles	= min($SRecycles[1], $PLANET[$resource[209]]);
				if(empty($Recycles) && empty($GRecycles))
					exit($ResultMessage = "611; ".$LNG['fa_no_recyclers']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
					
				$FleetArray = array(219 => $GRecycles, 209 => $Recycles);
				break;
			default:
				exit("610; ".$LNG['fa_not_enough_probes']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
			break;
		}
		
		parent::CleanFleetArray($FleetArray);
		
		if(empty($FleetArray))
			exit("610; ".$LNG['fa_not_enough_probes']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
		
		if (parent::GetMaxFleetSlots($USER) <= $CurrentFlyingFleets)
		{
			$ResultMessage = "612; ".$LNG['fa_no_more_slots']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
			die ($ResultMessage);
		}
		
		if ($galaxy > $CONF['max_galaxy'] || $galaxy < 1)
		{
			$ResultMessage = "602; ".$LNG['fa_galaxy_not_exist']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
			die($ResultMessage);
		}

		if ($system > $CONF['max_system'] || $system < 1)
		{
			$ResultMessage = "602; ".$LNG['fa_system_not_exist']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
			die($ResultMessage);
		}

		if ($planet > $CONF['max_planets'] || $planet < 1)
		{
			$ResultMessage = "602; ".$LNG['fa_planet_not_exist']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
			die($ResultMessage);
		}

		$SQL  = "SELECT id, id_owner FROM ".PLANETS." ";
		$SQL .= "WHERE ";
		$SQL .= "`universe` = '".$UNI."' AND ";
		$SQL .= "`galaxy` = '".$galaxy."' AND ";
		$SQL .= "`system` = '".$system."' AND ";
		$SQL .= "`planet` = '".$planet."' AND ";
		$SQL .= "`planet_type` = '".($planettype == 2 ? 1 : $planettype)."';";
		$TargetRow	   = $db->uniquequery($SQL);
	
		$TargetUser	   = GetUserByID($TargetRow['id_owner'], array('id', 'onlinetime', 'urlaubs_modus', 'banaday', 'authattack'));

		if($CONF['adm_attack'] == 1 && $mission == 6 && $TargetUser['authattack'] > $USER['authlevel'])
			exit("619; ".$LNG['fa_action_not_allowed']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);


		if($USER['urlaubs_modus'] == 1)
		{
			$ResultMessage = "620; ".$LNG['fa_vacation_mode_current']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
			die ($ResultMessage);
		}

		if($mission == 6)
		{
			$TargetVacat   = $TargetUser['urlaubs_modus'];
			
			if ($TargetVacat)
			{
				$ResultMessage = "605; ".$LNG['fa_vacation_mode']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
				die ($ResultMessage);
			}

			$UserPoints   	= $USER;
			$User2Points  	= $db->uniquequery("SELECT `total_points` FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `id_owner` = '".$TargetRow['id_owner']."';");
		
			$IsNoobProtec	= CheckNoobProtec($UserPoints, $User2Points, $TargetUser);
			
			if ($IsNoobProtec['NoobPlayer'])
				exit("603; ".$LNG['fa_week_player']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
			elseif ($IsNoobProtec['StrongPlayer'])
				exit("604; ".$LNG['fa_strong_player']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);

			if (empty($TargetRow['id_owner']))
			{
				$ResultMessage = "601; ".$LNG['fa_planet_not_exist']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
				die($ResultMessage);
			}

			if ($TargetRow["id_owner"] == $PLANET["id_owner"])
			{
				$ResultMessage = "618; ".$LNG['fa_not_spy_yourself']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
				die($ResultMessage);
			}
		}
		
		$SpeedFactor    	 = parent::GetGameSpeedFactor();
		$Distance    		 = parent::GetTargetDistance($PLANET['galaxy'], $galaxy, $PLANET['system'], $system, $PLANET['planet'], $planet);
		$SpeedAllMin 		 = parent::GetFleetMaxSpeed($FleetArray, $USER);
		$Duration    		 = parent::GetMissionDuration(10, $SpeedAllMin, $Distance, $SpeedFactor, $USER);
		$consumption   		 = parent::GetFleetConsumption($FleetArray, $Duration, $Distance, $SpeedAllMin, $USER, $SpeedFactor);

		$UserDeuterium   	-= $consumption;

		if($UserDeuterium < 0)
			exit("613; ".$LNG['fa_not_enough_fuel']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
		elseif($consumption > parent::GetFleetRoom($FleetArray))
			exit("613; ".$LNG['fa_no_fleetroom']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
			
			
		$fleet['fly_time']   = $Duration;
		$fleet['start_time'] = $Duration + TIMESTAMP;
		$fleet['end_time']   = ($Duration * 2) + TIMESTAMP;

		$FleetShipCount      = 0;
		$FleetDBArray        = "";
		$FleetSubQRY         = "";
		foreach ($FleetArray as $Ship => $Count)
		{
			$FleetShipCount  += $Count;
			$FleetDBArray    .= $Ship .",". $Count .";";
			$FleetSubQRY     .= "`".$resource[$Ship] . "` = `" . $resource[$Ship] . "` - " . $Count . " , ";
		}
	
		$SQL  = "LOCK TABLE ".FLEETS." WRITE, ".PLANETS." WRITE;";
		$SQL .= "INSERT INTO ".FLEETS." SET ";
		$SQL .= "`fleet_owner` = '".$USER['id']."', ";
		$SQL .= "`fleet_mission` = '".$mission."', ";
		$SQL .= "`fleet_amount` = '".$FleetShipCount."', ";
		$SQL .= "`fleet_array` = '".$FleetDBArray."', ";
		$SQL .= "`fleet_universe` = '".$UNI."', ";
		$SQL .= "`fleet_start_time` = '".$fleet['start_time']. "', ";
		$SQL .= "`fleet_start_id` = '".$PLANET['id']."', ";
		$SQL .= "`fleet_start_galaxy` = '".$PLANET['galaxy']."', ";
		$SQL .= "`fleet_start_system` = '".$PLANET['system']."', ";
		$SQL .= "`fleet_start_planet` = '".$PLANET['planet']."', ";
		$SQL .= "`fleet_start_type` = '".$PLANET['planet_type']."', ";
		$SQL .= "`fleet_end_time` = '".$fleet['end_time']."', ";
		$SQL .= "`fleet_end_id` = '".$TargetRow['id']."', ";
		$SQL .= "`fleet_end_galaxy` = '".$galaxy."', ";
		$SQL .= "`fleet_end_system` = '".$system."', ";
		$SQL .= "`fleet_end_planet` = '".$planet."', ";
		$SQL .= "`fleet_end_type` = '".$planettype."', ";
		$SQL .= "`fleet_target_owner` = '".$TargetRow['id_owner']."', ";
		$SQL .= "`start_time` = '".TIMESTAMP."';";
		$SQL .= "UPDATE ".PLANETS." SET ";
		$SQL .= $FleetSubQRY;
		$SQL .= "`deuterium` = '".floattostring($UserDeuterium)."' " ;
		$SQL .= "WHERE ";
		$SQL .= "`id` = '".$PLANET['id']."';";
		$SQL .= "UNLOCK TABLES;";
		
		if(connection_aborted())
			exit;
			
		$db->multi_query($SQL);

		$CurrentFlyingFleets++;

		$ResultMessage  = "600; ".$LNG['fa_sending']." ".$FleetShipCount." ". $LNG['tech'][$Ship] ." ".$LNG['gl_to']." ". $galaxy .":". $system .":". $planet ."...|";
		$ResultMessage .= $CurrentFlyingFleets ." ".($UserSpyProbes - $SpyProbes)." ".($UserRecycles - $Recycles)." ".($UserGRecycles - $GRecycles)." ".$UserMissiles;

		die($ResultMessage);
	}

	public static function MissilesAjax()
	{	
		global $USER, $PLANET, $LNG, $CONF, $db, $reslist, $resource, $UNI;
	
		include_once(ROOT_PATH . 'includes/functions/IsVacationMode.php');
		
		$iraks 				= $PLANET['interplanetary_misil'];
		$TargetGalaxy 		= request_var('galaxy',0);
		$TargetSystem 		= request_var('system',0);
		$TargetPlanet 		= request_var('planet',0);
		$anz 				= min(request_var('SendMI',0), $iraks);
		$pziel 				= request_var('Target',"");
		
		$PlanetRess 		= new ResourceUpdate($USER, $PLANET);
		$Target 			= $db->uniquequery("SELECT `id`, `id_owner` FROM ".PLANETS." WHERE `universe` = '".$UNI."' AND  `galaxy` = '".$TargetGalaxy."' AND `system` = '".$TargetSystem."' AND `planet` = '".$TargetPlanet."' AND `planet_type` = '1';");
		
		$Distance			= abs($TargetSystem - $PLANET['system']);
		
		require_once(ROOT_PATH.'includes/classes/class.GalaxyRows.php');
		
		$GalaxyRows	= new GalaxyRows();
		
		if (IsVacationMode($USER))
			$error = $LNG['fl_vacation_mode_active'];
		elseif ($PLANET['silo'] < 4)
			$error = $LNG['ma_silo_level'];
		elseif ($USER['impulse_motor_tech'] == 0)
			$error = $LNG['ma_impulse_drive_required'];
		elseif ($TargetGalaxy != $PLANET['galaxy'] || $Distance > $GalaxyRows->GetMissileRange($USER[$resource[117]]))
			$error = $LNG['ma_not_send_other_galaxy'];
		elseif (!$Target)
			$error = $LNG['ma_planet_doesnt_exists'];
		elseif (!in_array($pziel, $reslist['defense']) && $pziel != 0)
			$error = $LNG['ma_wrong_target'];
		elseif ($iraks == 0)
			$error = $LNG['ma_no_missiles'];
		elseif ($anz == 0)
			$error = $LNG['ma_add_missile_number'];

		$TargetUser	   	= GetUserByID($Target['id_owner'], array('onlinetime', 'banaday'));
		if ($CONF['adm_attack'] == 1 && $TargetUser['authattack'] > $USER['authlevel'])
			$error = $LNG['fl_admins_cannot_be_attacked'];	
			
		$UserPoints   	= $USER;
		$User2Points  	= $db->uniquequery("SELECT `total_points` FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `id_owner` = '".$Target['id_owner']."';");
		
		$IsNoobProtec	= CheckNoobProtec($UserPoints, $User2Points, $TargetUser);
			
		if ($IsNoobProtec['NoobPlayer'])
			$error = $LNG['fl_week_player'];
		elseif ($IsNoobProtec['StrongPlayer'])
			$error = $LNG['fl_strong_player'];		
				
		$template	= new template();
		if ($error != "")
		{
			$template->message($error);
			exit;
		}
		$SpeedFactor    	 = parent::GetGameSpeedFactor();
		$Duration 			 = max(round((30 + (60 * $Distance)/$SpeedFactor)),30);

		$DefenseLabel 		 = ($pziel == 0) ? $LNG['ma_all'] : $LNG['tech'][$pziel];
		
		if(connection_aborted())
			exit;
			
		$sql = "INSERT INTO ".FLEETS." SET
				fleet_owner = '".$USER['id']."',
				fleet_mission = '10',
				fleet_amount = '".$anz."',
				fleet_array = '503,".$anz."',
				fleet_universe = '".$UNI."',
				fleet_start_time = '".(TIMESTAMP + $Duration)."',
				fleet_start_id = '".$PLANET['id']."',
				fleet_start_galaxy = '".$PLANET['galaxy']."',
				fleet_start_system = '".$PLANET['system']."',
				fleet_start_planet ='".$PLANET['planet']."',
				fleet_start_type = '1',
				fleet_end_time = '".(TIMESTAMP + $Duration + 50)."',
				fleet_end_stay = '0',
				fleet_end_id = '".$Target['id']."',
				fleet_end_galaxy = '".$TargetGalaxy."',
				fleet_end_system = '".$TargetSystem."',
				fleet_end_planet = '".$TargetPlanet."',
				fleet_end_type = '1',
				fleet_target_obj = '".$db->sql_escape($pziel)."',
				fleet_resource_metal = '0',
				fleet_resource_crystal = '0',
				fleet_resource_deuterium = '0',
				fleet_target_owner = '".$Target["id_owner"]."',
				fleet_group = '0',
				fleet_mess = '0',
				start_time = ".TIMESTAMP.";
				UPDATE ".PLANETS." SET 
				interplanetary_misil = (interplanetary_misil - ".$anz.") WHERE id = '".$PLANET['id']."';";

		$db->multi_query($sql);
		
		$template->message("<b>".$anz."</b>". $LNG['ma_missiles_sended'] .$DefenseLabel, "game.php?page=overview", 3);
	}
}
?>