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

if(!defined('INSIDE')){ die(header("location:../../"));}

require_once(ROOT_PATH . 'includes/classes/class.FleetFunctions.' . PHP_EXT);

class ShowFleetPages extends FleetFunctions
{

	public static function ShowFleetPage($CurrentUser, $CurrentPlanet)
	{
		global $reslist, $resource, $db, $lang, $ExtraDM;

		$parse				= $lang;
		$FleetID			= request_var('fleetid', 0);
		$GetAction			= request_var('action', "");

		$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
		$template	= new template();
		$template->set_vars($CurrentUser, $CurrentPlanet);
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
					parent::SendFleetBack($CurrentUser, $FleetID);
				break;
				case "getakspage":
					$template->assign_vars(parent::GetAKSPage($CurrentUser, $CurrentPlanet, $FleetID));
					$template->assign_vars(array(
						'fl_invite_members'		=> $lang['fl_invite_members'],
						'fl_members_invited'	=> $lang['fl_members_invited'],
						'fl_modify_sac_name'	=> $lang['fl_modify_sac_name'],
						'fl_sac_of_fleet'		=> $lang['fl_sac_of_fleet'],
						'fl_continue'			=> $lang['fl_continue'],
					));
					$AKSPage	= $template->fetch('fleetACS_table.tpl');
				break;
			}
		}
		

		$MaxExpedition      = $CurrentUser[$resource[124]];

		if ($MaxExpedition >= 1)
		{
			$ExpeditionEnCours  = parent::GetCurrentFleets($CurrentUser['id'], 15);
			$EnvoiMaxExpedition = floor(sqrt($MaxExpedition));
		}
		else
		{
			$ExpeditionEnCours 	= 0;
			$EnvoiMaxExpedition = 0;
		}

		$MaxFlottes     = parent::GetMaxFleetSlots($CurrentUser);

		$galaxy         = request_var('galaxy', $CurrentPlanet['galaxy']);
		$system         = request_var('system', $CurrentPlanet['system']);
		$planet         = request_var('planet', $CurrentPlanet['planet']);
		$planettype     = request_var('planettype', $CurrentPlanet['planet_type']);
		$target_mission = request_var('target_mission', 0);
		
		$CurrentFleets 		= $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_owner` = '".$CurrentUser['id']."' AND `fleet_mission` <> 10;");
		$CountCurrentFleets	= $db->num_rows($CurrentFleets);

		while ($CurrentFleetsRow = $db->fetch_array($CurrentFleets))
		{
			$fleet = explode(";", $CurrentFleetsRow['fleet_array']);
			foreach ($fleet as $ShipID => $ShipCount)
			{
				if (!empty($ShipCount))
				{
					$a = explode(",", $ShipCount);
					$FleetList[$CurrentFleetsRow['fleet_id']][$lang['tech'][$a[0]]] = pretty_number($a[1]);
				}
			}
			
			$FlyingFleetList[]	= array(
				'id'			=> $CurrentFleetsRow['fleet_id'],
				'mission'		=> $CurrentFleetsRow['fleet_mission'],
				'missionname'	=> $lang['type_mission'][$CurrentFleetsRow['fleet_mission']],
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
				'backin'		=> pretty_time(floor($CurrentFleetsRow['fleet_end_time'] - time())),
				'FleetList'		=> $FleetList[$CurrentFleetsRow['fleet_id']],
			);
		}

		foreach($reslist['fleet'] as $FleetID)
		{
			if ($CurrentPlanet[$resource[$FleetID]] > 0)
			{
				$FleetsOnPlanet[]	= array(
					'id'	=> $FleetID,
					'name'	=> $lang['tech'][$FleetID],
					'speed'	=> parent::GetFleetMaxSpeed($FleetID, $CurrentUser),
					'count'	=> pretty_number($CurrentPlanet[$resource[$FleetID]]),
				);
			}
		}
		
		$template->assign_vars(array(
			'FleetsOnPlanet'		=> $FleetsOnPlanet,
			'FlyingFleetList'		=> $FlyingFleetList,
			'fl_number'				=> $lang['fl_number'],
			'fl_mission'			=> $lang['fl_mission'],
			'fl_ammount'			=> $lang['fl_ammount'],
			'fl_beginning'			=> $lang['fl_beginning'],
			'fl_departure'			=> $lang['fl_departure'],
			'fl_destiny'			=> $lang['fl_destiny'],
			'fl_objective'			=> $lang['fl_objective'],
			'fl_arrival'			=> $lang['fl_arrival'],
			'fl_order'				=> $lang['fl_order'],
			'fl_new_mission_title'	=> $lang['fl_new_mission_title'],
			'fl_ship_type'			=> $lang['fl_ship_type'],
			'fl_ship_available'		=> $lang['fl_ship_available'],
			'fl_fleets'				=> $lang['fl_fleets'],
			'fl_expeditions'		=> $lang['fl_expeditions'],
			'fl_speed_title'		=> $lang['fl_speed_title'],
			'fl_max'				=> $lang['fl_max'],
			'fl_no_more_slots'		=> $lang['fl_no_more_slots'],
			'fl_continue'			=> $lang['fl_continue'],
			'fl_no_ships'			=> $lang['fl_no_ships'],
			'fl_select_all_ships'	=> $lang['fl_select_all_ships'],
			'fl_remove_all_ships'	=> $lang['fl_remove_all_ships'],
			'fl_acs'				=> $lang['fl_acs'],
			'fl_send_back'			=> $lang['fl_send_back'],
			'fl_returning'			=> $lang['fl_returning'],
			'fl_r'					=> $lang['fl_r'],
			'fl_onway'				=> $lang['fl_onway'],
			'fl_a'					=> $lang['fl_a'],
			'fl_info_detail'		=> $lang['fl_info_detail'],
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
			'bonus_attack'			=> $CurrentUser[$resource[109]] * 10 + $CurrentUser[$resource[602]] * 5 + ((time() - $CurrentUser[$resource[700]] <= 0) ? (100 * $ExtraDM[700]['add']) : 0),
			'bonus_defensive'		=> $CurrentUser[$resource[110]] * 10 + $CurrentUser[$resource[602]] * 5 + ((time() - $CurrentUser[$resource[701]] <= 0) ? (100 * $ExtraDM[701]['add']) : 0),
			'bonus_shield'			=> $CurrentUser[$resource[111]] * 10 + $CurrentUser[$resource[602]] * 5,
			'bonus_combustion'		=> $CurrentUser[$resource[115]] * 10 + ((time() - $CurrentUser[$resource[706]] <= 0) ? (100 * $ExtraDM[706]['add']) : 0),
			'bonus_impulse'			=> $CurrentUser[$resource[117]] * 20 + ((time() - $CurrentUser[$resource[706]] <= 0) ? (100 * $ExtraDM[706]['add']) : 0),
			'bonus_hyperspace'		=> $CurrentUser[$resource[118]] * 30 + ((time() - $CurrentUser[$resource[706]] <= 0) ? (100 * $ExtraDM[706]['add']) : 0),
		));
		$template->show('fleet_table.tpl');
		$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
	}

	public static function ShowFleet1Page($CurrentUser, $CurrentPlanet)
	{
		global $resource, $pricelist, $reslist, $db, $lang, $ExtraDM;

		$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
		$template	= new template();
		$template->set_vars($CurrentUser, $CurrentPlanet);
		$template->loadscript('flotten.js');
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		$template->getplanets();

		$TargetGalaxy 					= request_var('galaxy', $CurrentPlanet['galaxy']);
		$TargetSystem 					= request_var('system', $CurrentPlanet['system']);
		$TargetPlanet					= request_var('planet', $CurrentPlanet['planet']);
		$TargetPlanettype 				= request_var('planet_type', $CurrentPlanet['planet_type']);

		foreach ($reslist['fleet'] as $id => $ShipID)
		{
			$amount		 				= min(request_var('ship'.$ShipID, '0') + 0, $CurrentPlanet[$resource[$ShipID]] + 0);
			
			if ($amount <= 0 || $ShipID == 212 || !is_numeric($amount)) continue;

			$Fleet[$ShipID]				= $amount;
			$FleetRoom			   	   += $pricelist[$ShipID]['capacity'] * $amount;
		}

		if (!is_array($Fleet))
			parent::GotoFleetPage();

		$template->assign_vars(array(
			'target_mission'		=> request_var('target_mission', 0),
			'speedfactor'			=> parent::GetGameSpeedFactor(),
			'speedallsmin' 			=> parent::GetFleetMaxSpeed($Fleet, $CurrentUser),
			'Shoutcutlist'			=> parent::GetUserShotcut($CurrentUser),
			'Colonylist' 			=> parent::GetColonyList($template->playerplanets),
			'AKSList' 				=> parent::IsAKS($CurrentUser['id']),
			'inputs'				=> parent::GetExtraInputs($Fleet, $CurrentUser),
			'AvailableSpeeds'		=> parent::GetAvailableSpeeds(),
			'fleetarray'			=> parent::SetFleetArray($Fleet),
			'galaxy'				=> $CurrentPlanet['galaxy'],
			'system'				=> $CurrentPlanet['system'],
			'planet'				=> $CurrentPlanet['planet'],
			'planet_type' 			=> $CurrentPlanet['planet_type'],
			'galaxy_post' 			=> $TargetGalaxy,
			'system_post' 			=> $TargetSystem,
			'planet_post' 			=> $TargetPlanet,
			'fleetroom'				=> floattostring($FleetRoom),	
			'fleetspeedfactor'		=> number_format(((time() - $CurrentUser[$resource[706]] <= 0) ? (1 - $ExtraDM[706]['add']) : 1) - (GENERAL * $CurrentUser['rpg_general']), 1, '.', ','),
			'options_selector'    	=> array(1 => $lang['fl_planet'], 2 => $lang['fl_debris'], 3 => $lang['fl_moon']),
			'options'				=> $TargetPlanettype,
			'fl_send_fleet'			=> $lang['fl_send_fleet'],
			'fl_destiny'			=> $lang['fl_destiny'],
			'fl_fleet_speed'		=> $lang['fl_fleet_speed'],
			'fl_distance'			=> $lang['fl_distance'],
			'fl_flying_time'		=> $lang['fl_flying_time'],
			'fl_fuel_consumption'	=> $lang['fl_fuel_consumption'],
			'fl_max_speed'			=> $lang['fl_max_speed'],
			'fl_cargo_capacity'		=> $lang['fl_cargo_capacity'],
			'fl_shortcut'			=> $lang['fl_shortcut'],
			'fl_shortcut_add_edit'	=> $lang['fl_shortcut_add_edit'],
			'fl_no_shortcuts'		=> $lang['fl_no_shortcuts'],
			'fl_planet_shortcut'	=> $lang['fl_planet_shortcut'],
			'fl_debris_shortcut'	=> $lang['fl_debris_shortcut'],
			'fl_moon_shortcut'		=> $lang['fl_moon_shortcut'],
			'fl_my_planets'			=> $lang['fl_my_planets'],
			'fl_acs_title'			=> $lang['fl_acs_title'],
			'fl_continue'			=> $lang['fl_continue'],
			'fl_no_colony'			=> $lang['fl_no_colony'],
		));
		
		$template->show('fleet1_table.tpl');
		$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
	}
	
	public static function ShowFleet2Page($CurrentUser, $CurrentPlanet)
	{
		global $db, $lang;
	
		$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
		$template	= new template();
		$template->set_vars($CurrentUser, $CurrentPlanet);
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
		$MisInfo['CurrentUser']		= $CurrentUser;
		
		$MissionOutput	 			= parent::GetFleetMissions($MisInfo);
		if(empty($MissionOutput))
		{
			$template->message("<font color=\"red\"><b>". $lang['fl_empty_target']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
			exit;
		}
		$GameSpeedFactor   		 	= parent::GetGameSpeedFactor();		
		$FleetSpeed  				= parent::GetFleetMaxSpeed($FleetArray, $CurrentUser);
		$MaxFleetSpeed				= ($FleetSpeed / 10) * $GenFleetSpeed;
		$distance      				= parent::GetTargetDistance($CurrentPlanet['galaxy'], $TargetGalaxy, $CurrentPlanet['system'], $TargetSystem, $CurrentPlanet['planet'], $TargetPlanet);
		$duration      				= parent::GetMissionDuration($GenFleetSpeed, $MaxFleetSpeed, $distance, $GameSpeedFactor, $CurrentUser);
		$consumption				= parent::GetFleetConsumption($FleetArray, $duration, $distance, $MaxFleetSpeed, $CurrentUser, $GameSpeedFactor);
 		if($consumption > $CurrentPlanet['deuterium'])
		{
			$template->message("<font color=\"red\"><b>". sprintf($lang['fl_no_enought_deuterium'], $lang['Deuterium'], pretty_number($CurrentPlanet['deuterium'] - $consumption), $lang['Deuterium'])."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
			exit;
		}
		
		$template->assign_vars(array(
			'consumption'					=> floattostring(floor($consumption)),
			'fleetroom'						=> floattostring(parent::GetFleetRoom($FleetArray)),
			'speedallsmin'					=> $MaxFleetSpeed,
			'speed'							=> $GenFleetSpeed,
			'speedfactor'					=> $GameSpeedFactor,
			'mission'						=> $TargetMission,
			'thisgalaxy'			 		=> $CurrentPlanet['galaxy'],
			'thissystem'			 		=> $CurrentPlanet['system'],
			'thisplanet'			 		=> $CurrentPlanet['planet'],
			'thisplanet_type'			 	=> $CurrentPlanet['planet_type'],
			'thismetal'						=> floattostring(floor($CurrentPlanet['metal'])),
			'thiscrystal'					=> floattostring(floor($CurrentPlanet['crystal'])),
			'thisdeuterium' 				=> floattostring(floor($CurrentPlanet['deuterium'])),
			'fl_planet'						=> $lang['fl_planet'], 
			'fl_moon'						=> $lang['fl_moon'],
			'MissionSelector' 				=> $MissionOutput['MissionSelector'],
			'StaySelector' 					=> $MissionOutput['StayBlock'],
			'fl_mission'					=> $lang['fl_mission'],
			'fl_resources'					=> $lang['fl_resources'],
			'Metal'							=> $lang['Metal'],
			'Crystal'						=> $lang['Crystal'],
			'Deuterium'						=> $lang['Deuterium'],
			'fl_max'						=> $lang['fl_max'],
			'fl_resources_left'				=> $lang['fl_resources_left'],
			'fl_all_resources'				=> $lang['fl_all_resources'],
			'fl_fuel_consumption'			=> $lang['fl_fuel_consumption'],
			'fl_hours'						=> $lang['fl_hours'],
			'fl_hold_time'					=> $lang['fl_hold_time'],
			'fl_expedition_alert_message'	=> $lang['fl_expedition_alert_message'],
			'fl_dm_alert_message'			=> sprintf($lang['fl_dm_alert_message'], $lang['type_mission'][11], $lang['Darkmatter']),
			'galaxy'						=> $TargetGalaxy,
			'system'						=> $TargetSystem,
			'planet'						=> $TargetPlanet,
			'planettype'					=> $TargetPlanettype,
			'acs_target_mr'					=> $acs_target_mr,
			'fleet_group'					=> request_var('fleet_group', 0),
			'usedfleet' 					=> $usedfleet,
			'fl_continue'					=> $lang['fl_continue'],
		));
		
		$template->show('fleet2_table.tpl');
		$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
	}

	public static function ShowFleet3Page($CurrentUser, $CurrentPlanet)
	{
		global $resource, $pricelist, $reslist, $game_config, $db, $lang;

		include_once(ROOT_PATH . 'includes/functions/IsVacationMode.' . PHP_EXT);

		$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet, false);
		$template	= new template();
		$template->set_vars($CurrentUser, $CurrentPlanet);
		$template->loadscript('flotten.js');
		$template->loadscript('ocnt.js');
		$template->gotoside("game.php?page=fleet");
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		$template->getstats();

		
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

		$thisgalaxy			 	= $CurrentPlanet['galaxy'];
		$thissystem 			= $CurrentPlanet['system'];
		$thisplanet 			= $CurrentPlanet['planet'];
		$thisplanettype 		= $CurrentPlanet['planet_type'];
		
		if (IsVacationMode($CurrentUser))
		{
			$template->message($lang['fl_vacation_mode_active'],"game.php?page=overview",2);
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
			exit;
		}
	
		if (!($planettype >= 1 || $planettype <= 3))
			parent::GotoFleetPage();
			
		if ($CurrentPlanet['galaxy'] == $galaxy && $CurrentPlanet['system'] == $system && $CurrentPlanet['planet'] == $planet && $CurrentPlanet['planet_type'] == $planettype)
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
			$template->message("<font color=\"lime\"><b>".$lang['fl_empty_transport']."</b></font>", "game." . PHP_EXT . "?page=fleet", 1);
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
			exit;
		}
			
		$ActualFleets		= parent::GetCurrentFleets($CurrentUser['id']);

		if (parent::GetMaxFleetSlots($CurrentUser) <= $ActualFleets)
		{
			$template->message($lang['fl_no_slots'], "game." . PHP_EXT . "?page=fleet", 1);
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
			exit;
		}
			
		$fleet_group_mr = 0;
		if($fleet_group > 0 && $mission == 2)
		{
			$target = "g".$galaxy."s".$system."p".$planet."t".$planettype;
			if($acs_target_mr == $target)
			{
				$aks_count_mr = $db->query("SELECT * FROM ".AKS." WHERE `id` = '".$fleet_group."' AND `eingeladen` LIKE '%".$CurrentUser['id']."%' AND 'fleet_start_time' > '".time()."';");
				if ($db->num_rows($aks_count_mr) > 0)
					$fleet_group_mr = $fleet_group;
			}
		}

		if (($fleet_group == 0) && ($mission == 2))
			$mission = 1;

					
		$ActualFleets 		= parent::GetCurrentFleets($CurrentUser['id']);
		
		$TargetPlanet  		= $db->fetch_array($db->query("SELECT `id_owner`,`id_level`,`destruyed`,`ally_deposit` FROM ".PLANETS." WHERE `galaxy` = '". $db->sql_escape($galaxy) ."' AND `system` = '". $db->sql_escape($system) ."' AND `planet` = '". $db->sql_escape($planet) ."' AND `planet_type` = '". $db->sql_escape($planettype) ."';"));

		if (($mission != 15 && $mission != 8 && $TargetPlanet["destruyed"] != 0) || ($mission != 15 && $mission != 7 && $mission != 8 && empty($TargetPlanet['id_owner'])))
			parent::GotoFleetPage();

		$MyDBRec       		= $CurrentUser;

		$protection      	= $game_config['noobprotection'];
		$protectiontime  	= $game_config['noobprotectiontime'];
		$protectionmulti 	= $game_config['noobprotectionmulti'];

		$protectiontime		= ($protectiontime < 1) ? 9999999999999999 : 0;

		$FleetArray  		= parent::GetFleetArray($rawfleetarray);
		
		if (!is_array($FleetArray))
			parent::GotoFleetPage();

		$FleetStorage        = 0;
		$FleetShipCount      = 0;
		$fleet_array         = "";
		$FleetSubQRY         = "";
		
		foreach ($FleetArray as $Ship => $Count)
		{
			if ($Count > $CurrentPlanet[$resource[$Ship]] || $Count < 0)
				parent::GotoFleetPage();
				
			$FleetStorage    += $pricelist[$Ship]["capacity"] * $Count;
			$FleetShipCount  += $Count;
			$fleet_array     .= $Ship .",". $Count .";";
			$FleetSubQRY     .= "`".$resource[$Ship] . "` = ".$resource[$Ship]." - '".number_format($Count, 0, '', '')."', ";
		}

		$error              = 0;
		$fleetmission       = $mission;

		$YourPlanet = false;
		$UsedPlanet = false;
	
		if ($mission == 11)
		{
			$maxexpde = parent::GetCurrentFleets($CurrentUser['id'], 11);

			if ($maxexpde >= MAX_DM_MISSIONS)
			{
				$template->message("<font color=\"red\"><b>".$lang['fl_expedition_fleets_limit']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
				exit;
			}
		}
		elseif ($mission == 15)
		{
			$MaxExpedition = $CurrentUser[$resource[124]];

			if ($MaxExpedition == 0)
			{
				$template->message("<font color=\"red\"><b>".$lang['fl_expedition_tech_required']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
				exit;
			}			
							
			$ExpeditionEnCours	= parent::GetCurrentFleets($CurrentUser['id'], 15);
			$EnvoiMaxExpedition = floor(sqrt($MaxExpedition));
			
			if ($ExpeditionEnCours >= $EnvoiMaxExpedition)
			{
				$template->message("<font color=\"red\"><b>".$lang['fl_expedition_fleets_limit']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
				exit;
			}
		}

		$YourPlanet 	= (isset($TargetPlanet['id_owner']) && $TargetPlanet['id_owner'] == $CurrentUser['id']) ? true : false;
		$UsedPlanet 	= (isset($TargetPlanet['id_owner'])) ? true : false;

		$HeDBRec 		= ($YourPlanet) ? $MyDBRec : GetUserByID($TargetPlanet['id_owner'], array('id','onlinetime','ally_id','urlaubs_modus'));

		if ($HeDBRec['urlaubs_modus'] && $mission != 8)
		{
			$template->message("<font color=\"lime\"><b>".$lang['fl_in_vacation_player']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
			exit;
		}
		
		if(!$YourPlanet && ($mission == 1 || $mission == 2 || $mission == 5 || $mission == 6 || $mission == 9))
		{
			if($TargetPlanet['id_level'] > $CurrentUser['authlevel'] && $game_config['adm_attack'] == 0)
			{
				$template->message("<font color=\"red\"><b>".$lang['fl_admins_cannot_be_attacked']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
				exit;
			}
			
			$UserPoints    	= $template->player['rank'];
			$User2Points  	= $db->fetch_array($db->query("SELECT `total_points` FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $HeDBRec['id'] ."';"));
		
			$IsNoobProtec	= CheckNoobProtec($UserPoints, $User2Points, $HeDBRec['onlinetime']);
			
			if ($IsNoobProtec['NoobPlayer'])
			{
				$template->message("<font color=\"lime\"><b>".$lang['fl_week_player']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
				exit;
			}
			elseif ($IsNoobProtec['StrongPlayer'])
			{
				$template->message("<font color=\"red\"><b>".$lang['fl_strong_player']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
				exit;
			}
		}

		if (!($mission == 15 || $mission == 8))
		{
			if ($HeDBRec['ally_id'] != $MyDBRec['ally_id'] && $mission == 4)
			{
				$template->message("<font color=\"red\"><b>".$lang['fl_stay_not_on_enemy']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
				exit;
			}

			if ($TargetPlanet['ally_deposit'] < 1 && $HeDBRec != $MyDBRec && $mission == 5)
			{
				$template->message ("<font color=\"red\"><b>".$lang['fl_not_ally_deposit']."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
				$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
				exit;
			}

			if (($TargetPlanet["id_owner"] == $CurrentPlanet["id_owner"]) && (($mission == 1) || ($mission == 6)))
				parent::GotoFleetPage();

			if (($TargetPlanet["id_owner"] != $CurrentPlanet["id_owner"]) && ($mission == 4))
			{
				$template->message ("<font color=\"red\"><b>".$lang['fl_deploy_only_your_planets']."</b></font>","game." . PHP_EXT . "?page=fleet", 2);
				$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
				exit;
			}
		}

		if(parent::CheckUserSpeed())
			parent::GotoFleetPage();
	

		$FleetSpeed  	= parent::GetFleetMaxSpeed($FleetArray, $CurrentUser);
		$MaxFleetSpeed	= ($FleetSpeed / 10) * $GenFleetSpeed;
		$SpeedFactor    = parent::GetGameSpeedFactor();
		$distance      	= parent::GetTargetDistance($thisgalaxy, $galaxy, $thissystem, $system, $thisplanet, $planet);
		$duration      	= parent::GetMissionDuration($GenFleetSpeed, $MaxFleetSpeed, $distance, $SpeedFactor, $CurrentUser);
		$consumption   	= parent::GetFleetConsumption($FleetArray, $duration, $distance, $MaxFleetSpeed, $CurrentUser, $SpeedFactor);
			
		$fleet['start_time'] = $duration + time();
		
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

		$fleet['end_time']   = $StayDuration + (2 * $duration) + time();


		$FleetStorage       -= $consumption;
		
		$TransportMetal		 = min($TransportMetal, $CurrentPlanet['metal']);
		$TransportCrystal 	 = min($TransportCrystal, $CurrentPlanet['crystal']);
		$TransportDeuterium  = min($TransportDeuterium, ($CurrentPlanet['deuterium'] - $consumption));

		$StorageNeeded   	 = $TransportMetal + $TransportCrystal + $TransportDeuterium;
		
		$StockMetal      	 = $CurrentPlanet['metal'];
		$StockCrystal    	 = $CurrentPlanet['crystal'];
		$StockDeuterium  	 = $CurrentPlanet['deuterium'];
		$StockDeuterium 	-= $consumption;

		if ($CurrentPlanet['deuterium'] < $consumption)
		{
			$template->message("<font color=\"red\"><b>".sprintf($lang['fl_no_enought_deuterium'], $lang['Deuterium'], pretty_number($consumption - $CurrentPlanet['deuterium']), $lang['Deuterium'])."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
			exit;
		}
		
		if ($StorageNeeded > $FleetStorage)
		{
			$template->message("<font color=\"red\"><b>". $lang['fl_no_enought_cargo_capacity'] . pretty_number($StorageNeeded - $FleetStorage)."</b></font>", "game." . PHP_EXT . "?page=fleet", 2);
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
			exit;
		}

		if ($TargetPlanet['id_level'] > $CurrentUser['authlevel'] && $game_config['adm_attack'] == 0)
		{
			$template->message($lang['fl_admins_cannot_be_attacked'], "game." . PHP_EXT . "?page=fleet",2);
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
			exit;
		}
		if ($fleet_group_mr != 0)
		{
			$AksStartTime = $db->fetch_array($db->query("SELECT MAX(`fleet_start_time`) AS Start FROM ".FLEETS." WHERE `fleet_group` = '". $fleet_group_mr . "';"));

			if ($AksStartTime['Start'] >= $fleet['start_time'])
			{
				$fleet['start_time'] 	= $AksStartTime['Start'];
				$fleet['end_time'] 	   += $AksStartTime['Start'] - $fleet['start_time'];
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
		
		$QryInsertFleet  = "INSERT INTO ".FLEETS." SET 
							`fleet_owner` = '". $CurrentUser['id'] ."', 
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
							`start_time` = '". time() ."';
							UPDATE `".PLANETS."` SET
							".substr($FleetSubQRY,0,-2)."
							WHERE
							`id` = ". $CurrentPlanet['id'] ." LIMIT 1;";

		$CurrentPlanet['metal']		-= $TransportMetal;
		$CurrentPlanet['crystal']	-= $TransportCrystal;
		$CurrentPlanet['deuterium']	-= ($TransportDeuterium + $consumption);
		$db->multi_query($QryInsertFleet);
	
		foreach ($FleetArray as $Ship => $Count)
		{
			$FleetList[$lang['tech'][$Ship]]	= pretty_number($Count);
		}
	
		$template->assign_vars(array(
			'mission' 				=> $lang['type_mission'][$mission],
			'distance' 				=> pretty_number($distance),
			'consumption' 			=> pretty_number($consumption),
			'from' 					=> $thisgalaxy .":". $thissystem. ":". $thisplanet,
			'destination'			=> $galaxy .":". $system .":". $planet,
			'start_time' 			=> date("M D d H:i:s", $fleet['start_time']),
			'end_time' 				=> date("M D d H:i:s", $fleet['end_time']),
			'speedallsmin'		 	=> $MaxFleetSpeed,
			'FleetList'				=> $FleetList,
			'fl_fleet_sended'		=> $lang['fl_fleet_sended'],
			'fl_mission'			=> $lang['fl_mission'],
			'fl_from'				=> $lang['fl_from'],
			'fl_destiny'			=> $lang['fl_destiny'],
			'fl_distance'			=> $lang['fl_distance'],
			'fl_fleet_speed'		=> $lang['fl_fleet_speed'],
			'fl_fuel_consumption'	=> $lang['fl_fuel_consumption'],
			'fl_fromfl_destiny'		=> $lang['fl_fromfl_destiny'],
			'fl_arrival_time'		=> $lang['fl_arrival_time'],
			'fl_return_time'		=> $lang['fl_return_time'],
			'fl_fleet'				=> $lang['fl_fleet'],
		));
		
		$template->show('fleet3_table.tpl');
		$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
		
	}

	public static function FleetAjax($CurrentUser, $CurrentPlanet)
	{
		global $db, $resource, $lang;
		$UserSpyProbes  = $CurrentPlanet[$resource[210]];
		$UserRecycles   = $CurrentPlanet[$resource[209]];
		$UserGRecycles  = $CurrentPlanet[$resource[219]];
		$UserDeuterium  = $CurrentPlanet['deuterium'];
		$UserMissiles   = $CurrentPlanet['interplanetary_misil'];
		$thisgalaxy		= $CurrentPlanet['galaxy'];
		$thissystem		= $CurrentPlanet['system'];
		$thisplanet		= $CurrentPlanet['planet'];
		$thisplanettype = $CurrentPlanet['planet_type'];
		
		$galaxy 		= request_var('galaxy',0);
		$system 		= request_var('system',0);
		$planet 		= request_var('planet',0);
		$planettype		= request_var('planettype',0);
		$mission		= request_var('mission',0);
		$fleet          = array();
		$speedalls      = array();
		$PartialFleet   = false;
		$PartialCount   = 0;
		
		$CurrentFlyingFleets = parent::GetCurrentFleets($CurrentUser['id']);	
		switch($mission)
		{
			case 6:
				$SpyProbes	= request_var('ships', 0);
				$SpyProbes	= min($SpyProbes, $CurrentPlanet[$resource[210]]);
				if(empty($SpyProbes))
					exit($ResultMessage = "611; ".$lang['fa_no_spios']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
					
				$FleetArray = array(210 => $SpyProbes);
			break;
			case 8:
				$SRecycles	= explode("|", request_var('ships', ""));
				$GRecycles	= min($SRecycles[0], $CurrentPlanet[$resource[219]]);
				$Recycles	= min($SRecycles[1], $CurrentPlanet[$resource[209]]);
				if(empty($Recycles) && empty($GRecycles))
					exit($ResultMessage = "611; ".$lang['fa_no_recyclers']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
					
				$FleetArray = array(219 => $GRecycles, 209 => $Recycles);
				break;
			default:
				exit("610; ".$lang['fa_not_enough_probes']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
			break;
		}
		
		parent::CleanFleetArray($FleetArray);
		
		if (parent::GetMaxFleetSlots($CurrentUser) <= $CurrentFlyingFleets)
		{
			$ResultMessage = "612; ".$lang['fa_no_more_slots']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
			die ($ResultMessage);
		}
		
		if ($galaxy > MAX_GALAXY_IN_WORLD || $galaxy < 1)
		{
			$ResultMessage = "602; ".$lang['fa_galaxy_not_exist']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
			die($ResultMessage);
		}

		if ($system > MAX_SYSTEM_IN_GALAXY || $system < 1)
		{
			$ResultMessage = "602; ".$lang['fa_system_not_exist']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
			die($ResultMessage);
		}

		if ($planet > MAX_PLANET_IN_SYSTEM || $planet < 1)
		{
			$ResultMessage = "602; ".$lang['fa_planet_not_exist']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
			die($ResultMessage);
		}

		$QrySelectEnemy  = "SELECT id_level, id_owner FROM ".PLANETS." ";
		$QrySelectEnemy .= "WHERE ";
		$QrySelectEnemy .= "`galaxy` = '". $galaxy ."' AND ";
		$QrySelectEnemy .= "`system` = '". $system ."' AND ";
		$QrySelectEnemy .= "`planet` = '". $planet ."' AND ";
		$QrySelectEnemy .= "`planet_type` = '". $planettype ."';";
		$TargetRow	   = $db->fetch_array($db->query($QrySelectEnemy));

		if($TargetRow['id_level'] > $CurrentUser['authlevel'] && $mission == 6 && $game_config['adm_attack'] == 0)
			exit("619; ".$lang['fa_action_not_allowed']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
		
		$TargetUser	   = GetUserByID($TargetRow['id_owner'], array('id','onlinetime','urlaubs_modus'));



		if($CurrentUser['urlaubs_modus'] == 1)
		{
			$ResultMessage = "620; ".$lang['fa_vacation_mode_current']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
			die ($ResultMessage);
		}

		if($mission == 6)
		{
			$TargetVacat   = $TargetUser['urlaubs_modus'];
			
			if ($TargetVacat)
			{
				$ResultMessage = "605; ".$lang['fa_vacation_mode']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
				die ($ResultMessage);
			}

			$UserPoints   	= $db->fetch_array($db->query("SELECT `total_points` FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $CurrentUser['id'] ."';"));
			$User2Points  	= $db->fetch_array($db->query("SELECT `total_points` FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TargetRow['id_owner'] ."';"));
		
			$IsNoobProtec	= CheckNoobProtec($UserPoints, $User2Points, $TargetUser['onlinetime']);
			
			if ($IsNoobProtec['NoobPlayer'])
				exit("603; ".$lang['fa_week_player']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
			elseif ($IsNoobProtec['StrongPlayer'])
				exit("604; ".$lang['fa_strong_player']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);

			if (empty($TargetRow['id_owner']))
			{
				$ResultMessage = "601; ".$lang['fa_planet_not_exist']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
				die($ResultMessage);
			}

			if ($TargetRow["id_owner"] == $CurrentPlanet["id_owner"])
			{
				$ResultMessage = "618; ".$lang['fa_not_spy_yourself']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles;
				die($ResultMessage);
			}
		}
		
		$SpeedFactor    	 = parent::GetGameSpeedFactor();
		$Distance    		 = parent::GetTargetDistance($thisgalaxy, $galaxy, $thissystem, $system, $thisplanet, $planet);
		$SpeedAllMin 		 = parent::GetFleetMaxSpeed($FleetArray, $CurrentUser);
		$Duration    		 = parent::GetMissionDuration(10, $SpeedAllMin, $Distance, $SpeedFactor, $CurrentUser);
		$consumption   		 = parent::GetFleetConsumption($FleetArray, $Duration, $Distance, $SpeedAllMin, $CurrentUser, $SpeedFactor);

		$UserDeuterium   	-= $consumption;

		if($UserDeuterium < 0)
			exit("613; ".$lang['fa_not_enough_fuel']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
		elseif($consumption > parent::GetFleetRoom($FleetArray))
			exit("613; ".$lang['fa_no_fleetroom']." |".$CurrentFlyingFleets." ".$UserSpyProbes." ".$UserRecycles." ".$UserGRecycles." ".$UserMissiles);
			
			
		$fleet['fly_time']   = $Duration;
		$fleet['start_time'] = $Duration + time();
		$fleet['end_time']   = ($Duration * 2) + time();

		$FleetShipCount      = 0;
		$FleetDBArray        = "";
		$FleetSubQRY         = "";
		foreach ($FleetArray as $Ship => $Count)
		{
			$FleetShipCount  += $Count;
			$FleetDBArray    .= $Ship .",". $Count .";";
			$FleetSubQRY     .= "`".$resource[$Ship] . "` = `" . $resource[$Ship] . "` - " . $Count . " , ";
		}


		$QryUpdate  = "INSERT INTO ".FLEETS." SET ";
		$QryUpdate .= "`fleet_owner` = '". $CurrentUser['id'] ."', ";
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
		$QryUpdate .= "`start_time` = '" . time() . "';";
		$QryUpdate .= "UPDATE ".PLANETS." SET ";
		$QryUpdate .= $FleetSubQRY;
		$QryUpdate .= "`deuterium` = '".floattostring($UserDeuterium)."' " ;
		$QryUpdate .= "WHERE ";
		$QryUpdate .= "`id` = '". $CurrentPlanet['id'] ."';";
		$db->multi_query($QryUpdate);

		$CurrentFlyingFleets++;

		$ResultMessage  = "600; ".$lang['fa_sending']." ".$FleetShipCount." ". $lang['tech'][$Ship] ." a ". $galaxy .":". $system .":". $planet ."...|";
		$ResultMessage .= $CurrentFlyingFleets ." ".($UserSpyProbes - $SpyProbes)." ".($UserRecycles - $Recycles)." ".($UserGRecycles - $GRecycles)." ".$UserMissiles;

		die($ResultMessage);
	}

	public static function MissilesAjax($CurrentUser, $CurrentPlanet)
	{	
		global $lang, $game_config, $db, $reslist;
	
		include_once(ROOT_PATH . 'includes/functions/IsVacationMode.' . PHP_EXT);
		
		$TargetGalaxy 		= request_var('galaxy',0);
		$TargetSystem 		= request_var('system',0);
		$TargetPlanet 		= request_var('planet',0);
		$anz 				= request_var('SendMI',0);
		$pziel 				= request_var('Target',"");
		
		$PlanetRess 		= new ResourceUpdate($CurrentUser, $CurrentPlanet);

		$iraks 				= $CurrentPlanet['interplanetary_misil'];
		$Distance			= abs($TargetSystem - $CurrentPlanet['system']);
		$tempvar2 			= ($CurrentUser['impulse_motor_tech'] * 2) - 1;
		$Target 			= $db->fetch_array($db->query("SELECT id_owner, id_level FROM ".PLANETS." WHERE galaxy = ".$TargetGalaxy." AND system = ".$TargetSystem." AND planet = ".$TargetPlanet." AND planet_type = 1 limit 1;"));

		if (IsVacationMode($CurrentUser))
			$error = $lang['fl_vacation_mode_active'];
		elseif ($CurrentPlanet['silo'] < 4)
			$error = $lang['ma_silo_level'];
		elseif ($CurrentUser['impulse_motor_tech'] == 0)
			$error = $lang['ma_impulse_drive_required'];
		elseif ($Distance >= $tempvar2 || $TargetGalaxy != $CurrentPlanet['galaxy'])
			$error = $lang['ma_not_send_other_galaxy'];
		elseif (!$Target)
			$error = $lang['ma_planet_doesnt_exists'];
		elseif ($anz > $iraks)
			$error = $lang['ma_cant_send'] . $anz . $lang['ma_missile'] . $iraks;
		elseif (!in_array($pziel, $reslist['defense']) && $pziel != 0)
			$error = $lang['ma_wrong_target'];
		elseif ($iraks == 0)
			$error = $lang['ma_no_missiles'];
		elseif ($anz == 0)
			$error = $lang['ma_add_missile_number'];
		elseif ($Target['id_level'] > $CurrentUser['authlevel'] && $game_config['adm_attack'] == 0)
			$error = $lang['fl_admins_cannot_be_attacked'];
		
		$TargetUser	   	= GetUserByID($Target['id_owner'], array('onlinetime'));
		
		$UserPoints   	= $db->fetch_array($db->query("SELECT `total_points` FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $CurrentUser['id'] ."';"));
		$User2Points  	= $db->fetch_array($db->query("SELECT `total_points` FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $Target['id_owner'] ."';"));
		
		$IsNoobProtec	= CheckNoobProtec($UserPoints, $User2Points, $TargetUser['onlinetime']);
			
		if ($IsNoobProtec['NoobPlayer'])
			$error = $lang['fl_week_player'];
		elseif ($IsNoobProtec['StrongPlayer'])
			$error = $lang['fl_strong_player'];		
				
		$template	= new template();

		$template->set_vars($CurrentUser, $CurrentPlanet);
		$template->page_header();
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		if ($error != "")
		{
			$template->message($error);
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
			exit;
		}
		$SpeedFactor    	 = parent::GetGameSpeedFactor();
		$Duration 			 = max(round((30 + (60 * $Distance)/$SpeedFactor)),30);

		$DefenseLabel = ($pziel == 0) ? $lang['ma_all'] : $lang['tech'][$pziel];

		$sql = "INSERT INTO ".FLEETS." SET
				fleet_owner = ".$CurrentUser['id'].",
				fleet_mission = 10,
				fleet_amount = ".$anz.",
				fleet_array = '503,".$anz."',
				fleet_start_time = '".(time() + $Duration)."',
				fleet_start_galaxy = '".$CurrentPlanet['galaxy']."',
				fleet_start_system = '".$CurrentPlanet['system']."',
				fleet_start_planet ='".$CurrentPlanet['planet']."',
				fleet_start_type = 1,
				fleet_end_time = '".(time() + $Duration + 50)."',
				fleet_end_stay = 0,
				fleet_end_galaxy = '".$TargetGalaxy."',
				fleet_end_system = '".$TargetSystem."',
				fleet_end_planet = '".$TargetPlanet."',
				fleet_end_type = 1,
				fleet_target_obj = '".$db->sql_escape($pziel)."',
				fleet_resource_metal = 0,
				fleet_resource_crystal = 0,
				fleet_resource_deuterium = 0,
				fleet_target_owner = '".$Target["id_owner"]."',
				fleet_group = 0,
				fleet_mess = 0,
				start_time = ".time().";
				UPDATE ".PLANETS." SET 
				interplanetary_misil = (interplanetary_misil - ".$anz.") WHERE id = '".$CurrentPlanet['id']."';";

		$db->multi_query($sql);
		
		$template->message("<b>".$anz."</b>". $lang['ma_missiles_sended'] .$DefenseLabel, "game.php?page=overview", 3);
		$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);

	}
}
?>