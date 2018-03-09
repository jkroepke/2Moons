v<?php

/**
 *  Steemnova
 *   by Adam "dotevo" Jordanek 2018
 *
 * For the full copyright and license information, please view the LICENSE
 *
 */

class ShowMarketPlacePage extends AbstractGamePage
{
	public static $requireModule = MODULE_BATTLEHALL;

	function __construct()
    {
		parent::__construct();
	}

	public function show()
	{
		global $USER, $PLANET, $reslist, $resource, $LNG;

		$acsData			= array();
		$FleetID			= HTTP::_GP('fleetID', 0);
		$GetAction		= HTTP::_GP('action', "");
		$shipType		= HTTP::_GP('shipType', "");

		$message = "";
		$db = Database::get();

		if($GetAction == "buy") {
			$ActualFleets		= FleetFunctions::GetCurrentFleets($USER['id']);

			if (FleetFunctions::GetMaxFleetSlots($USER) <= $ActualFleets)
			{
				$message = $LNG['fl_no_slots'];
			} else {

			$sql = "SELECT * FROM %%FLEETS%% WHERE fleet_id = :fleet_id AND fleet_mess = 2;";
			$fleetResult = $db->select($sql, array(
				':fleet_id' => $FleetID,
			));
			if ($db->rowCount() == 0) {
				$message = $LNG['market_p_msg_not_found'];
			} elseif($fleetResult[0]['fleet_wanted_resource_amount'] == 4 ||
								$fleetResult[0]['fleet_wanted_resource_amount'] == 0) {
			} else {
				$fleetResult = $fleetResult[0];
				$amount = $fleetResult['fleet_wanted_resource_amount'];

				$F1capacity = 0;
				$F1type = 0;
				//PRIO for LC
				if($shipType == 1) {
					$F1capacity = 5000;
					$F1type = 202;
				}
				// PRIO for HC
				else {
					$F1capacity = 25000;
					$F1type = 203;
				}

				$F1 = min($PLANET[$resource[$F1type]], ceil($amount / $F1capacity));

				//taken
				$amountTMP = $amount - $F1 * $F1capacity;
				// If still fleet needed
				$F2 = 0;
				$F2capacity = 0;
				$F2type = 0;
				if ($amountTMP > 0) {
					//We need HC
					if($shipType == 1) {
						$F2capacity = 25000;
						$F2type = 203;
					}
					//We need LC
					else{
						$F2capacity = 5000;
						$F2type = 202;
					}
					$F2 = min($PLANET[$resource[$F2type]], ceil($amountTMP / $F2capacity));
					$amountTMP -= $F2 * $F2capacity;
				}

				if($amountTMP > 0) {
					$message = $LNG['market_p_msg_more_ships_is_needed'];
				} else {
					$fleetArrayTMP = array();
					$fleetArrayTMP = array($F1type => $F1, $F2type => $F2);
					$fleetArray = $fleetArrayTMP;
					$fleetArray						= array_filter($fleetArrayTMP);
					$SpeedFactor    	= FleetFunctions::GetGameSpeedFactor();
					$Distance    		= FleetFunctions::GetTargetDistance(array($PLANET['galaxy'], $PLANET['system'], $PLANET['planet']), array($fleetResult['fleet_end_galaxy'], $fleetResult['fleet_end_system'], $fleetResult['fleet_end_planet']));
					$SpeedAllMin		= FleetFunctions::GetFleetMaxSpeed($fleetArray, $USER);
					$Duration			= FleetFunctions::GetMissionDuration(10, $SpeedAllMin, $Distance, $SpeedFactor, $USER);
					$consumption		= FleetFunctions::GetFleetConsumption($fleetArray, $Duration, $Distance, $USER, $SpeedFactor);

					$fleetStartTime		= $Duration + TIMESTAMP;
					$fleetStayTime		= $fleetStartTime;
					$fleetEndTime		= $fleetStayTime + $Duration;

					$met = 0;
					$cry = 0;
					$deu = 0;
					if ($fleetResult['fleet_wanted_resource'] == 1)
						$met = $amount;
					elseif ($fleetResult['fleet_wanted_resource'] == 2)
						$cry = $amount;
					elseif ($fleetResult['fleet_wanted_resource'] == 3)
						$deu = $amount;

					$fleetResource	= array(
						901	=> $met,
						902	=> $cry,
						903	=> $deu,
					);

					if($PLANET[$resource[901]]-$fleetResource[901] < 0 ||
						$PLANET[$resource[902]]	-$fleetResource[902] <0 ||
						$PLANET[$resource[903]]	-$fleetResource[903] - $consumption < 0) {
						$message = $LNG['market_p_msg_resources_error'];
					}else {
						$PLANET[$resource[901]]	-= $fleetResource[901];
						$PLANET[$resource[902]]	-= $fleetResource[902];
						$PLANET[$resource[903]]	-= $fleetResource[903] + $consumption;

						FleetFunctions::sendFleet($fleetArray, 3/*Transport*/, $USER['id'], $PLANET['id'], $PLANET['galaxy'],
							$PLANET['system'], $PLANET['planet'], $PLANET['planet_type'], $fleetResult['fleet_owner'], $fleetResult['fleet_start_id'],
							$fleetResult['fleet_start_galaxy'], $fleetResult['fleet_start_system'], $fleetResult['fleet_start_planet'], $fleetResult['fleet_start_type'],
							$fleetResource, $fleetStartTime, $fleetStayTime, $fleetEndTime,0,0,0,0,1);

						/////////////////////////////////////////////////////////////////////////////
						/// SEND/
						$sql = "SELECT * FROM %%USERS%% WHERE id = :userId;";
						$USER_2   = Database::get()->selectSingle($sql, array(
							':userId'       => $fleetResult['fleet_owner']
						));

						$fleetArray						= FleetFunctions::unserialize($fleetResult['fleet_array']);
						$SpeedFactor    	= FleetFunctions::GetGameSpeedFactor();
						$Distance    		= FleetFunctions::GetTargetDistance(array($PLANET['galaxy'], $PLANET['system'], $PLANET['planet']), array($fleetResult['fleet_end_galaxy'], $fleetResult['fleet_end_system'], $fleetResult['fleet_end_planet']));
						$SpeedAllMin		= FleetFunctions::GetFleetMaxSpeed($fleetArray, $USER_2);
						$Duration			= FleetFunctions::GetMissionDuration(10, $SpeedAllMin, $Distance, $SpeedFactor, $USER_2);
						//$consumption		= FleetFunctions::GetFleetConsumption($fleetArray, $Duration, $Distance, $fleetResult['fleet_owner'], $SpeedFactor);

						$fleetStartTime		= $Duration + TIMESTAMP;
						$fleetStayTime		= $fleetStartTime;
						$fleetEndTime		= $fleetStayTime + $Duration;


						$params = array(
							':fleetID' => $FleetID,
							':fleet_target_owner' => $USER['id'],
							':fleet_end_id' => $PLANET['id'],
							':fleet_end_planet' => $PLANET['planet'],
							':fleet_end_system' => $PLANET['system'],
							':fleet_end_galaxy' => $PLANET['galaxy'],
							':fleet_start_time' => $fleetStartTime,
							':fleet_end_stay' => $fleetStayTime,
							':fleet_end_time' => $fleetEndTime,
							':fleet_mission' => 3,
							':fleet_no_m_return' => 1,
							':fleet_mess'=> 0,
						);
						$sql = "UPDATE %%FLEETS%% SET `fleet_no_m_return` = :fleet_no_m_return, `fleet_end_id` = :fleet_end_id,`fleet_target_owner` = :fleet_target_owner, `fleet_mess` = :fleet_mess, `fleet_mission` = :fleet_mission, `fleet_end_stay` = :fleet_end_stay ,`fleet_end_time` = :fleet_end_time ,`fleet_start_time` = :fleet_start_time , `fleet_end_planet` = :fleet_end_planet, `fleet_end_system` = :fleet_end_system, `fleet_end_galaxy` = :fleet_end_galaxy WHERE fleet_id = :fleetID;";
						$fleetResult = $db->update($sql, $params);
						$sql = "UPDATE %%LOG_FLEETS%% SET `fleet_no_m_return` = :fleet_no_m_return, `fleet_end_id` = :fleet_end_id,`fleet_target_owner` = :fleet_target_owner, `fleet_mess` = :fleet_mess, `fleet_mission` = :fleet_mission, `fleet_end_stay` = :fleet_end_stay ,`fleet_end_time` = :fleet_end_time ,`fleet_start_time` = :fleet_start_time , `fleet_end_planet` = :fleet_end_planet, `fleet_end_system` = :fleet_end_system, `fleet_end_galaxy` = :fleet_end_galaxy WHERE fleet_id = :fleetID;";
						$fleetResult = $db->update($sql, $params);
						$sql	= 'UPDATE %%FLEETS_EVENT%% SET  `time` = :endTime WHERE fleetID	= :fleetId;';
						$db->update($sql, array(
							':fleetId'	=> $FleetID,
							':endTime'	=> $fleetStartTime
						));
						$LC = 0;
						$HC = 0;
						if(array_key_exists(202,$fleetArrayTMP))
							$LC = $fleetArrayTMP[202];
						if(array_key_exists(203,$fleetArrayTMP))
							$HC = $fleetArrayTMP[203];
						$message = sprintf($LNG['market_p_msg_sent'], $LC, $HC);
				}}
			}
		}}

		$sql = "SELECT * FROM %%FLEETS%% WHERE fleet_mission = 16 AND fleet_mess = 2 ORDER BY fleet_end_time ASC;";
		$fleetResult = $db->select($sql, array(
		));

		$activeFleetSlots	= $db->rowCount();

		$FlyingFleetList	= array();

		foreach ($fleetResult as $fleetsRow)
		{
			$FleetList[$fleetsRow['fleet_id']] = FleetFunctions::unserialize($fleetsRow['fleet_array']);
			$resourceN = " ";
			$ratioN = 1;
			//TODO TRANSLATION
			switch($fleetsRow['fleet_wanted_resource']) {
				case 1:
					$resourceN = $LNG['tech'][901];
					$ratioN = 1;
					break;
				case 2:
					$resourceN = $LNG['tech'][902];
					$ratioN = 2;
					break;
				case 3:
					$resourceN = $LNG['tech'][903];
					$ratioN = 4;
					break;
				default:
					break;
			}
			$totalValue = $fleetsRow['fleet_resource_metal'] + 2 * $fleetsRow['fleet_resource_crystal'] + 4*$fleetsRow['fleet_resource_deuterium'];
			$FlyingFleetList[]	= array(
				'id'			=> $fleetsRow['fleet_id'],
				'fleet_resource_metal'		=> $fleetsRow['fleet_resource_metal'],
				'fleet_resource_crystal'			=> $fleetsRow['fleet_resource_crystal'],
				'fleet_resource_deuterium'			=> $fleetsRow['fleet_resource_deuterium'],
				'total' => $fleetsRow['fleet_resource_metal'] + $fleetsRow['fleet_resource_crystal'] + $fleetsRow['fleet_resource_deuterium'],
				'total_value' => $totalValue,
				'fleet_wanted_resource'	=> $resourceN,
				'fleet_wanted_resource_amount'	=> $fleetsRow['fleet_wanted_resource_amount'],
				'ratio'	=> round($fleetsRow['fleet_wanted_resource_amount'] * $ratioN / $totalValue,2),
				'end'	=> $fleetsRow['fleet_end_stay'] - TIMESTAMP,
				'distance' => $Distance    		= FleetFunctions::GetTargetDistance(array($PLANET['galaxy'], $PLANET['system'], $PLANET['planet']), array($fleetsRow['fleet_end_galaxy'], $fleetsRow['fleet_end_system'], $fleetsRow['fleet_end_planet'])),
			);
		}


		$this->assign(array(
			'message' => $message,
			'FlyingFleetList'		=> $FlyingFleetList,
		));
		$this->tplObj->loadscript('marketplace.js');
		$this->display('page.marketPlace.default.tpl');
	}
}
