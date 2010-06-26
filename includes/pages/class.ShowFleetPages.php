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

if(!defined('INSIDE')) die('Hacking attempt!');

require_once(ROOT_PATH . 'includes/classes/class.FleetFunctions.' . PHP_EXT);

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
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		
		if(!empty($FleetID))
		{
			switch($GetAction){
				case "sendfleetback":
					parent::SendFleetBack($USER, $FleetID);
				break;
				case "getakspage":
					$template->assign_vars(parent::GetAKSPage($USER, $PLANET, $FleetID));
					$template->assign_vars(array(
						'fl_invite_members'		=> $LNG['fl_invite_members'],
						'fl_members_invited'	=> $LNG['fl_members_invited'],
						'fl_modify_sac_name'	=> $LNG['fl_modify_sac_name'],
						'fl_sac_of_fleet'		=> $LNG['fl_sac_of_fleet'],
						'fl_continue'			=> $LNG['fl_continue'],
					));
					$AKSPage	= $template->fetch('fleetACS_table.tpl');
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
		
		$CurrentFleets 		= $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_owner` = '".$USER['id']."' AND `fleet_mission` <> 10;");
		$CountCurrentFleets	= $db->num_rows($CurrentFleets);

		while ($CurrentFleetsRow = $db->fetch_array($CurrentFleets))
		{
			$fleet = explode(";", $CurrentFleetsRow['fleet_array']);
			foreach ($fleet as $ShipID => $ShipCount)
			{
				if (!empty($ShipCount))
				{
					$a = explode(",", $ShipCount);
					$FleetList[$CurrentFleetsRow['fleet_id']][$LNG['tech'][$a[0]]] = pretty_number($a[1]);
				}
			}
			
			$FlyingFleetList[]	= array(
				'id'			=> $CurrentFleetsRow['fleet_id'],
				'mission'		=> $CurrentFleetsRow['fleet_mission'],
				'missionname'	=> $LNG['type_mission'][$CurrentFleetsRow['fleet_mission']],
				'way'			=> $CurrentFleetsRow['fleet_mess'],
				'start_galaxy'	=> $CurrentFleetsRow['fleet_start_galaxy'],
				'start_system'	=> $CurrentFleetsRow['fleet_start_system'],
				'start_planet'	=> $CurrentFleetsRow['fleet_start_planet'],
				'start_time'	=> date("d M Y H:i:s", $CurrentFleetsRow['fleet_start_time']),
				'end_galaxy'	=> $CurrentFleetsRow['fleet_end_galaxy'],
				'end_system'	=> $CurrentFleetsRow['fleet_end_system'],
				'end_planet'	=> $CurrentFleetsRow['fleet_end_planet'],
				'end_time'		=> date("d M Y H:i:s", $CurrentFleetsRow['fleet_end_time']),
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
			'bonus_attack'			=> $USER[$resource[109]] * 10 + $USER[$resource[602]] * 5 + ((TIMESTAMP - $USER[$resource[700]] <= 0) ? (100 * $ExtraDM[700]['add']) : 0),
			'bonus_defensive'		=> $USER[$resource[110]] * 10 + $USER[$resource[602]] * 5 + ((TIMESTAMP - $USER[$resource[701]] <= 0) ? (100 * $ExtraDM[701]['add']) : 0),
			'bonus_shield'			=> $USER[$resource[111]] * 10 + $USER[$resource[602]] * 5,
			'bonus_combustion'		=> $USER[$resource[115]] * 10 + ((TIMESTAMP - $USER[$resource[706]] <= 0) ? (100 * $ExtraDM[706]['add']) : 0),
			'bonus_impulse'			=> $USER[$resource[117]] * 20 + ((TIMESTAMP - $USER[$resource[706]] <= 0) ? (100 * $ExtraDM[706]['add']) : 0),
			'bonus_hyperspace'		=> $USER[$resource[118]] * 30 + ((TIMESTAMP - $USER[$resource[706]] <= 0) ? (100 * $ExtraDM[706]['add']) : 0),
		));
		$template->show('fleet_table.tpl');
	}

	public static function ShowFleet1Page()
	{
		global $USER, $PLANET, $resource, $pricelist, $reslist, $db, $LNG, $ExtraDM;

		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		$PlanetRess->SavePlanetToDB();
		
		$template	= new template();
		
		$template->loadscript('flotten.js');
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		$template->getplanets();

		$TargetGalaxy 					= request_var('galaxy', $PLANET['galaxy']);
		$TargetSystem 					= request_var('system', $PLANET['system']);
		$TargetPlanet					= request_var('planet', $PLANET['planet']);
		$TargetPlanettype 				= request_var('planet_type', $PLANET['planet_type']);

		foreach ($reslist['fleet'] as $id => $ShipID)
		{
			$amount		 				= min(request_var('ship'.$ShipID, '0') + 0, $PLANET[$resource[$ShipID]] + 0);
			
			if ($amount <= 0 || $ShipID == 212 || !is_numeric($amount)) continue;

			$Fleet[$ShipID]				= $amount;
			$FleetRoom			   	   += $pricelist[$ShipID]['capacity'] * $amount;
		}

		if (!is_array($Fleet))
			parent::GotoFleetPage();

		$template->assign_vars(array(
			'target_mission'		=> request_var('target_mission', 0),
			'speedfactor'			=> parent::GetGameSpeedFactor(),
			'speedallsmin' 			=> parent::GetFleetMaxSpeed($Fleet, $USER),
			'Shoutcutlist'			=> parent::GetUserShotcut($USER),
			'Colonylist' 			=> parent::GetColonyList($template->UserPlanets),
			'AKSList' 				=> parent::IsAKS($USER['id']),
			'inputs'				=> parent::GetExtraInputs($Fleet, $USER),
			'AvailableSpeeds'		=> parent::GetAvailableSpeeds(),
			'fleetarray'			=> parent::SetFleetArray($Fleet),
			'galaxy'				=> $PLANET['galaxy'],
			'system'				=> $PLANET['system'],
			'planet'				=> $PLANET['planet'],
			'planet_type' 			=> $PLANET['planet_type'],
			'galaxy_post' 			=> $TargetGalaxy,
			'system_post' 			=> $TargetSystem,
			'planet_post' 			=> $TargetPlanet,
			'fleetroom'				=> floattostring($FleetRoom),	
			'fleetspeedfactor'		=> number_format(((TIMESTAMP - $USER[$resource[706]] <= 0) ? (1 - $ExtraDM[706]['add']) : 1) - (GENERAL * $USER['rpg_general']), 1, '.', ','),
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
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		
		$TargetGalaxy  				= request_var('galaxy', 0);
		$TargetSystem   			= request_var('system', 0);
		$TargetPlanet   			= request_var('planet', 0);
		$TargetPlanettype 			= request_var('planettype', 0);
		$TargetMission 				= request_var('target_mission', 0);
		$GenFleetSpeed  			= request_var('speed', 0);		
		$acs_target_mr 				= request_var('acs_target_mr', '');
		$usedfleet					= request_var('usedfleet','', true);

		$FleetArray    				= parent::GetFleetArray($usedfleet);
		
		$MisInfo['galaxy']     		= $TargetGalaxy;		
		$MisInfo['system'] 	  		= $TargetSystem;	
		$MisInfo['planet'] 	  		= $TargetPlanet;		
		$MisInfo['planettype'] 		= $TargetPlanettype;	
		$MisInfo['IsAKS']			= $acs_target_mr;
		$MisInfo['Ship'] 			= $FleetArray;		
		$MisInfo['CurrentUser']		= $USER;
		
		$MissionOutput	 			= parent::GetFleetMissions($MisInfo);
		
		if(empty($MissionOutput))
		{
			$template->message("<font color=\"red\"><b>". $LNG['fl_empty_target']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
			exit;
		}
		
		$GameSpeedFactor   		 	= parent::GetGameSpeedFactor();		
		$FleetSpeed  				= parent::GetFleetMaxSpeed($FleetArray, $USER);
		$MaxFleetSpeed				= ($FleetSpeed / 10) * $GenFleetSpeed;
		$distance      				= parent::GetTargetDistance($PLANET['galaxy'], $TargetGalaxy, $PLANET['system'], $TargetSystem, $PLANET['planet'], $TargetPlanet);
		$duration      				= parent::GetMissionDuration($GenFleetSpeed, $MaxFleetSpeed, $distance, $GameSpeedFactor, $USER);
		$consumption				= parent::GetFleetConsumption($FleetArray, $duration, $distance, $MaxFleetSpeed, $USER, $GameSpeedFactor);
 		
		if($consumption > $PLANET['deuterium'])
		{
			$template->message("<font color=\"red\"><b>". sprintf($LNG['fl_no_enought_deuterium'], $LNG['Deuterium'], pretty_number($PLANET['deuterium'] - $consumption), $LNG['Deuterium'])."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
			exit;
		}
		
		$template->assign_vars(array(
			'consumption'					=> floattostring(floor($consumption)),
			'fleetroom'						=> floattostring(parent::GetFleetRoom($FleetArray)),
			'speedallsmin'					=> $MaxFleetSpeed,
			'speed'							=> $GenFleetSpeed,
			'speedfactor'					=> $GameSpeedFactor,
			'mission'						=> $TargetMission,
			'thisgalaxy'			 		=> $PLANET['galaxy'],
			'thissystem'			 		=> $PLANET['system'],
			'thisplanet'			 		=> $PLANET['planet'],
			'thisplanet_type'			 	=> $PLANET['planet_type'],
			'thismetal'						=> floattostring(floor($PLANET['metal'])),
			'thiscrystal'					=> floattostring(floor($PLANET['crystal'])),
			'thisdeuterium' 				=> floattostring(floor($PLANET['deuterium'])),
			'fl_planet'						=> $LNG['fl_planet'], 
			'fl_moon'						=> $LNG['fl_moon'],
			'MissionSelector' 				=> $MissionOutput['MissionSelector'],
			'StaySelector' 					=> $MissionOutput['StayBlock'],
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
			'galaxy'						=> $TargetGalaxy,
			'system'						=> $TargetSystem,
			'planet'						=> $TargetPlanet,
			'planettype'					=> $TargetPlanettype,
			'acs_target_mr'					=> $acs_target_mr,
			'fleet_group'					=> request_var('fleet_group', 0),
			'usedfleet' 					=> $usedfleet,
			'fl_continue'					=> $LNG['fl_continue'],
		));
		
		$template->show('fleet2_table.tpl');
	}

	public static function ShowFleet3Page()
	{
		global $USER, $PLANET, $resource, $pricelist, $reslist, $CONF, $db, $LNG;

		include_once(ROOT_PATH . 'includes/functions/IsVacationMode.' . PHP_EXT);

		$template	= new template();
		$template->loadscript('flotten.js');
		$template->loadscript('ocnt.js');
		$template->gotoside('?page=fleet');
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();

		
		$mission 				= request_var('mission', 0);
		$galaxy     			= request_var('galaxy', 0);
		$system     			= request_var('system', 0);
		$planet     			= request_var('planet', 0);
		$planettype 			= request_var('planettype', 0);
		$fleet_group		 	= request_var('fleet_group', 0);
		$GenFleetSpeed		 	= request_var('speed', 0);
		$TransportMetal			= round(request_var('resource1', 0.0), 0);
		$TransportCrystal		= round(request_var('resource2', 0.0), 0);
		$TransportDeuterium		= round(request_var('resource3', 0.0), 0);
		$holdingtime 			= request_var('holdingtime', 0);
		$acs_target_mr			= request_var('acs_target_mr', '');
		$rawfleetarray			= request_var('usedfleet','',true);

		$thisgalaxy			 	= $PLANET['galaxy'];
		$thissystem 			= $PLANET['system'];
		$thisplanet 			= $PLANET['planet'];
		$thisplanettype 		= $PLANET['planet_type'];
		
		if (IsVacationMode($USER))
		{
			$template->message($LNG['fl_vacation_mode_active'], 'game.php?page=overview', 2);
			exit;
		}
		
		if ($_SESSION['oldpath'] != 'game.php?page=fleet2')
			parent::GotoFleetPage();
	
		if (!($planettype >= 1 || $planettype <= 3))
			parent::GotoFleetPage();
			
		if ($PLANET['galaxy'] == $galaxy && $PLANET['system'] == $system && $PLANET['planet'] == $planet && $PLANET['planet_type'] == $planettype)
			parent::GotoFleetPage();

		if ($galaxy > MAX_GALAXY_IN_WORLD || $galaxy < 1)
			parent::GotoFleetPage();

		if ($system > MAX_SYSTEM_IN_GALAXY || $system < 1)
			parent::GotoFleetPage();

		if ($planet > (MAX_PLANET_IN_SYSTEM + 1) || $planet < 1)
			parent::GotoFleetPage();
			
		if (empty($mission))
			parent::GotoFleetPage();	
		
		if (!is_numeric($TransportMetal + 0) || !is_numeric($TransportCrystal + 0) || !is_numeric($TransportDeuterium + 0))
			parent::GotoFleetPage();

		if ($TransportMetal + $TransportCrystal + $TransportDeuterium < 1 && $mission == 3)
		{
			$template->message("<font color=\"lime\"><b>".$LNG['fl_empty_transport']."</b></font>", "game." . PHP_EXT . "?page=fleet", 1);
			exit;
		}
			
		$ActualFleets		= parent::GetCurrentFleets($USER['id']);
		
		if (parent::GetMaxFleetSlots($USER) <= $ActualFleets)
		{
			$template->message($LNG['fl_no_slots'], "game." . PHP_EXT . "?page=fleet", 1);
			exit;
		}
			
		$fleet_group_mr = 0;
		if($fleet_group > 0 && $mission == 2 & $acs_target_mr == 'g'.$galaxy.'s'.$system.'p'.$planet.'t'.$planettype)
		{
			$aks_count_mr = $db->uniquequery("SELECT COUNT(*) as state FROM ".AKS." WHERE `id` = '".$fleet_group."' AND `eingeladen` LIKE '%".$USER['id']."%';");
			if ($aks_count_mr['state'] > 0)
				$fleet_group_mr = $fleet_group;
		}

		if ($mission == 2 && $fleet_group_mr == 0)
			$mission = 1;

					
		$ActualFleets 		= parent::GetCurrentFleets($USER['id']);
		
		$TargetPlanet  		= $db->uniquequery("SELECT `id_owner`,`id_level`,`destruyed`,`ally_deposit` FROM ".PLANETS." WHERE `galaxy` = '". $db->sql_escape($galaxy) ."' AND `system` = '". $db->sql_escape($system) ."' AND `planet` = '". $db->sql_escape($planet) ."' AND `planet_type` = '". $db->sql_escape($planettype) ."';");

		if (($mission != 15 && $mission != 8 && $TargetPlanet["destruyed"] != 0) || ($mission != 15 && $mission != 7 && $mission != 8 && empty($TargetPlanet['id_owner'])))
			parent::GotoFleetPage();

		$MyDBRec       		= $USER;

		$FleetArray  		= parent::GetFleetArray($rawfleetarray);
		
		if (!is_array($FleetArray))
			parent::GotoFleetPage();
		
		if(!array_key_exists($mission, parent::GetAvailableMissions(array('CurrentUser' => $USER,'galaxy' => $galaxy, 'system' => $system,'planet' => $planet, 'planettype' => $planettype,'IsAKS' => $acs_target_mr, 'Ship' =>  $FleetArray))))
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

			if ($maxexpde >= MAX_DM_MISSIONS)
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_expedition_fleets_limit']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				exit;
			}
		}
		elseif ($mission == 15)
		{
			$MaxExpedition = $USER[$resource[124]];

			if ($MaxExpedition == 0)
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_expedition_tech_required']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				exit;
			}			
							
			$ExpeditionEnCours	= parent::GetCurrentFleets($USER['id'], 15);
			$EnvoiMaxExpedition = floor(sqrt($MaxExpedition));
			
			if ($ExpeditionEnCours >= $EnvoiMaxExpedition)
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_expedition_fleets_limit']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				exit;
			}
		}

		$YourPlanet 	= (isset($TargetPlanet['id_owner']) && $TargetPlanet['id_owner'] == $USER['id']) ? true : false;
		$UsedPlanet 	= (isset($TargetPlanet['id_owner'])) ? true : false;

		$HeDBRec 		= ($YourPlanet) ? $MyDBRec : GetUserByID($TargetPlanet['id_owner'], array('id','onlinetime','ally_id','urlaubs_modus'));

		if ($HeDBRec['urlaubs_modus'] && $mission != 8)
		{
			$template->message("<font color=\"lime\"><b>".$LNG['fl_in_vacation_player']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
			exit;
		}
		
		if(!$YourPlanet && ($mission == 1 || $mission == 2 || $mission == 5 || $mission == 6 || $mission == 9))
		{
			if($TargetPlanet['id_level'] > $USER['authlevel'] && $CONF['adm_attack'] == 0)
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_admins_cannot_be_attacked']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				exit;
			}
			
			$UserPoints    	= $USER;
			$User2Points  	= $db->uniquequery("SELECT `total_points` FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $HeDBRec['id'] ."';");
		
			$IsNoobProtec	= CheckNoobProtec($UserPoints, $User2Points, $HeDBRec['onlinetime']);
			
			if ($IsNoobProtec['NoobPlayer'])
			{
				$template->message("<font color=\"lime\"><b>".$LNG['fl_week_player']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				exit;
			}
			elseif ($IsNoobProtec['StrongPlayer'])
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_strong_player']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				exit;
			}
		}

		if ($mission == 5)
		{
			
			if ($TargetPlanet['ally_deposit'] < 1)
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_not_ally_deposit']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				exit;
			}
			
			$buddy	= $db->uniquequery("SELECT COUNT(*) as state FROM ".BUDDY." WHERE `active` = '1' AND (`owner` = '".$HeDBRec['id']."' AND `sender` = '".$MyDBRec['id']."') OR (`owner` = '".$MyDBRec['id']."' AND `sender` = '".$HeDBRec['id']."');");
						
			if($HeDBRec['ally_id'] != $MyDBRec['ally_id'] && $buddy['state'] == 0)
			{
				$template->message("<font color=\"red\"><b>".$LNG['fl_no_same_alliance']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				exit;
			}
			
			
			
		}
		
		if(parent::CheckUserSpeed())
			parent::GotoFleetPage();
	

		$FleetSpeed  	= parent::GetFleetMaxSpeed($FleetArray, $USER);
		$MaxFleetSpeed	= ($FleetSpeed / 10) * $GenFleetSpeed;
		$SpeedFactor    = parent::GetGameSpeedFactor();
		$distance      	= parent::GetTargetDistance($thisgalaxy, $galaxy, $thissystem, $system, $thisplanet, $planet);
		$duration      	= parent::GetMissionDuration($GenFleetSpeed, $MaxFleetSpeed, $distance, $SpeedFactor, $USER);
		$consumption   	= parent::GetFleetConsumption($FleetArray, $duration, $distance, $MaxFleetSpeed, $USER, $SpeedFactor);
			
		$fleet['start_time'] = $duration + TIMESTAMP;
		
		if ($mission == 15)
		{
			$StayDuration    = max($holdingtime, 1) * 3600;
			$StayTime        = $fleet['start_time'] + $StayDuration;
		}
		elseif ($mission == 5)
		{
			$StayDuration    = $holdingtime * 3600;
			$StayTime        = $fleet['start_time'] + $StayDuration;
		}
		elseif ($mission == 11)
		{
			$StayDuration    = 3600;
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
			$template->message("<font color=\"red\"><b>".sprintf($LNG['fl_no_enought_deuterium'], $LNG['Deuterium'], pretty_number($consumption - $PLANET['deuterium']), $LNG['Deuterium'])."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
			exit;
		}
		
		if ($StorageNeeded > $FleetStorage)
		{
			$template->message("<font color=\"red\"><b>". $LNG['fl_no_enought_cargo_capacity'] . pretty_number($StorageNeeded - $FleetStorage)."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
			exit;
		}

		if ($TargetPlanet['id_level'] > $USER['authlevel'] && $CONF['adm_attack'] == 0)
		{
			$template->message($LNG['fl_admins_cannot_be_attacked'], "game." . PHP_EXT . "?page=fleet",2);
			exit;
		}
				
		$PLANET['metal']		-= $TransportMetal;
		$PLANET['crystal']		-= $TransportCrystal;
		$PLANET['deuterium']	-= ($TransportDeuterium + $consumption);
		$PlanetRess->SavePlanetToDB();
		
		if ($fleet_group_mr != 0)
		{
			$AksStartTime = $db->uniquequery("SELECT MAX(`fleet_start_time`) AS Start FROM ".FLEETS." WHERE `fleet_group` = '". $fleet_group_mr . "';");

			if ($AksStartTime['Start'] >= $fleet['start_time'])
			{
				$fleet['end_time'] 	   += $AksStartTime['Start'] - $fleet['start_time'];
				$fleet['start_time'] 	= $AksStartTime['Start'];
			}
			else
			{
				$QryUpdateFleets = "UPDATE ".FLEETS." SET ";
				$QryUpdateFleets .= "`fleet_start_time` = '".$fleet['start_time']."', ";
				$QryUpdateFleets .= "`fleet_end_time` = fleet_end_time + '".($fleet['start_time'] - $AksStartTime['Start'])."' ";
				$QryUpdateFleets .= "WHERE ";
				$QryUpdateFleets .= "`fleet_group` = '". $fleet_group_mr ."';";
				$db->query($QryUpdateFleets);
				$fleet['end_time'] 	    += $fleet['start_time'] - $AksStartTime['Start'];
			}
		}
		
		$QryInsertFleet  = "LOCK TABLE ".FLEETS." WRITE, ".PLANETS." WRITE;
							INSERT INTO ".FLEETS." SET 
							`fleet_owner` = '". $USER['id'] ."', 
							`fleet_mission` = '". $mission ."',
							`fleet_amount` = '". $FleetShipCount ."',
						    `fleet_array` = '". $fleet_array ."',
							`fleet_start_time` = '". $fleet['start_time'] ."',
							`fleet_start_galaxy` = '". $thisgalaxy ."',
							`fleet_start_system` = '". $thissystem ."',
							`fleet_start_planet` = '". $thisplanet ."',
							`fleet_start_type` = '". $thisplanettype ."',
							`fleet_end_time` = '". $fleet['end_time'] ."',
							`fleet_end_stay` = '". $StayTime ."',
							`fleet_end_galaxy` = '". $galaxy ."',
							`fleet_end_system` = '". $system ."',
							`fleet_end_planet` = '". $planet ."',
							`fleet_end_type` = '". $planettype ."',
							`fleet_resource_metal` = '".floattostring($TransportMetal)."',
							`fleet_resource_crystal` = '".floattostring($TransportCrystal)."',
							`fleet_resource_deuterium` = '".floattostring($TransportDeuterium)."',
							`fleet_target_owner` = '". $TargetPlanet['id_owner'] ."',
							`fleet_group` = '". $fleet_group_mr ."',
							`start_time` = '". TIMESTAMP ."';
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
			'from' 					=> $thisgalaxy .":". $thissystem. ":". $thisplanet,
			'destination'			=> $galaxy .":". $system .":". $planet,
			'start_time' 			=> date("M D d H:i:s", $fleet['start_time']),
			'end_time' 				=> date("M D d H:i:s", $fleet['end_time']),
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
		global $USER, $PLANET, $db, $resource, $LNG;
		$UserSpyProbes  = $PLANET[$resource[210]];
		$UserRecycles   = $PLANET[$resource[209]];
		$UserGRecycles  = $PLANET[$resource[219]];
		$UserDeuterium  = $PLANET['deuterium'];
		$UserMissiles   = $PLANET['interplanetary_misil'];
		$thisgalaxy		= $PLANET['galaxy'];
		$thissystem		= $PLANET['system'];
		$thisplanet		= $PLANET['planet'];
		$thisplanettype = $PLANET['planet_type'];
		
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
		
		if ($galaxy > MAX_GALAXY_IN_WORLD || $galaxy < 1)
		{
			$ResultMessage = "602; ".$LNG['fa_galaxy_not_exist']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
			die($ResultMessage);
		}

		if ($system > MAX_SYSTEM_IN_GALAXY || $system < 1)
		{
			$ResultMessage = "602; ".$LNG['fa_system_not_exist']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
			die($ResultMessage);
		}

		if ($planet > MAX_PLANET_IN_SYSTEM || $planet < 1)
		{
			$ResultMessage = "602; ".$LNG['fa_planet_not_exist']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
			die($ResultMessage);
		}

		$QrySelectEnemy  = "SELECT id_level, id_owner FROM ".PLANETS." ";
		$QrySelectEnemy .= "WHERE ";
		$QrySelectEnemy .= "`galaxy` = '". $galaxy ."' AND ";
		$QrySelectEnemy .= "`system` = '". $system ."' AND ";
		$QrySelectEnemy .= "`planet` = '". $planet ."' AND ";
		$QrySelectEnemy .= "`planet_type` = '". $planettype ."';";
		$TargetRow	   = $db->uniquequery($QrySelectEnemy);

		if($TargetRow['id_level'] > $USER['authlevel'] && $mission == 6 && $CONF['adm_attack'] == 0)
			exit("619; ".$LNG['fa_action_not_allowed']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
		
		$TargetUser	   = GetUserByID($TargetRow['id_owner'], array('id','onlinetime','urlaubs_modus'));



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
			$User2Points  	= $db->uniquequery("SELECT `total_points` FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TargetRow['id_owner'] ."';");
		
			$IsNoobProtec	= CheckNoobProtec($UserPoints, $User2Points, $TargetUser['onlinetime']);
			
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
		$Distance    		 = parent::GetTargetDistance($thisgalaxy, $galaxy, $thissystem, $system, $thisplanet, $planet);
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


		$QryUpdate  = "LOCK TABLE ".FLEETS." WRITE, ".PLANETS." WRITE;";
		$QryUpdate .= "INSERT INTO ".FLEETS." SET ";
		$QryUpdate .= "`fleet_owner` = '". $USER['id'] ."', ";
		$QryUpdate .= "`fleet_mission` = '". $mission ."', ";
		$QryUpdate .= "`fleet_amount` = '". $FleetShipCount ."', ";
		$QryUpdate .= "`fleet_array` = '". $FleetDBArray ."', ";
		$QryUpdate .= "`fleet_start_time` = '". $fleet['start_time']. "', ";
		$QryUpdate .= "`fleet_start_galaxy` = '". $thisgalaxy ."', ";
		$QryUpdate .= "`fleet_start_system` = '". $thissystem ."', ";
		$QryUpdate .= "`fleet_start_planet` = '". $thisplanet ."', ";
		$QryUpdate .= "`fleet_start_type` = '". $thisplanettype ."', ";
		$QryUpdate .= "`fleet_end_time` = '". $fleet['end_time'] ."', ";
		$QryUpdate .= "`fleet_end_galaxy` = '". $galaxy ."', ";
		$QryUpdate .= "`fleet_end_system` = '". $system ."', ";
		$QryUpdate .= "`fleet_end_planet` = '". $planet ."', ";
		$QryUpdate .= "`fleet_end_type` = '". $planettype ."', ";
		$QryUpdate .= "`fleet_target_owner` = '". $TargetRow['id_owner'] ."', ";
		$QryUpdate .= "`start_time` = '" . TIMESTAMP . "';";
		$QryUpdate .= "UPDATE ".PLANETS." SET ";
		$QryUpdate .= $FleetSubQRY;
		$QryUpdate .= "`deuterium` = '".floattostring($UserDeuterium)."' " ;
		$QryUpdate .= "WHERE ";
		$QryUpdate .= "`id` = '". $PLANET['id'] ."';";
		$QryUpdate .= "UNLOCK TABLES;";
		$db->multi_query($QryUpdate);

		$CurrentFlyingFleets++;

		$ResultMessage  = "600; ".$LNG['fa_sending']." ".$FleetShipCount." ". $LNG['tech'][$Ship] ." a ". $galaxy .":". $system .":". $planet ."...|";
		$ResultMessage .= $CurrentFlyingFleets ." ".($UserSpyProbes - $SpyProbes)." ".($UserRecycles - $Recycles)." ".($UserGRecycles - $GRecycles)." ".$UserMissiles;

		die($ResultMessage);
	}

	public static function MissilesAjax()
	{	
		global $USER, $PLANET, $LNG, $CONF, $db, $reslist, $resource;
	
		include_once(ROOT_PATH . 'includes/functions/IsVacationMode.' . PHP_EXT);
		
		$iraks 				= $PLANET['interplanetary_misil'];
		$TargetGalaxy 		= request_var('galaxy',0);
		$TargetSystem 		= request_var('system',0);
		$TargetPlanet 		= request_var('planet',0);
		$anz 				= min(request_var('SendMI',0), $iraks);
		$pziel 				= request_var('Target',"");
		
		$PlanetRess 		= new ResourceUpdate($USER, $PLANET);
		$Target 			= $db->uniquequery("SELECT `id_owner`, `id_level` FROM ".PLANETS." WHERE `galaxy` = '".$TargetGalaxy."' AND `system` = '".$TargetSystem."' AND `planet` = '".$TargetPlanet."' AND `planet_type` = '1';");
		
		$Distance			= abs($TargetSystem - $PLANET['system']);
		
		require_once(ROOT_PATH.'includes/classes/class.GalaxyRows.'.PHP_EXT);
		
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
		elseif ($Target['id_level'] > $USER['authlevel'] && $CONF['adm_attack'] == 0)
			$error = $LNG['fl_admins_cannot_be_attacked'];
		
		$TargetUser	   	= GetUserByID($Target['id_owner'], array('onlinetime'));
		
		$UserPoints   	= $USER;
		$User2Points  	= $db->uniquequery("SELECT `total_points` FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $Target['id_owner'] ."';");
		
		$IsNoobProtec	= CheckNoobProtec($UserPoints, $User2Points, $TargetUser['onlinetime']);
			
		if ($IsNoobProtec['NoobPlayer'])
			$error = $LNG['fl_week_player'];
		elseif ($IsNoobProtec['StrongPlayer'])
			$error = $LNG['fl_strong_player'];		
				
		$template	= new template();

		$template->page_header();
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		if ($error != "")
		{
			$template->message($error);
			exit;
		}
		$SpeedFactor    	 = parent::GetGameSpeedFactor();
		$Duration 			 = max(round((30 + (60 * $Distance)/$SpeedFactor)),30);

		$DefenseLabel 		 = ($pziel == 0) ? $LNG['ma_all'] : $LNG['tech'][$pziel];

		$sql = "INSERT INTO ".FLEETS." SET
				fleet_owner = '".$USER['id']."',
				fleet_mission = '10',
				fleet_amount = '".$anz."',
				fleet_array = '503,".$anz."',
				fleet_start_time = '".(TIMESTAMP + $Duration)."',
				fleet_start_galaxy = '".$PLANET['galaxy']."',
				fleet_start_system = '".$PLANET['system']."',
				fleet_start_planet ='".$PLANET['planet']."',
				fleet_start_type = '1',
				fleet_end_time = '".(TIMESTAMP + $Duration + 50)."',
				fleet_end_stay = '0',
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