<?php

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
		$message = "";
		$db = Database::get();

		if($GetAction == "buy") {
			$sql = "SELECT * FROM %%FLEETS%% WHERE fleet_id = :fleet_id AND fleet_mess = 2;";
			$fleetResult = $db->select($sql, array(
				':fleet_id' => $FleetID,
			));
			if ($db->rowCount() == 0) {
				$message = "Not found";
			} elseif($fleetResult[0]['fleet_wanted_resource_amount'] == 4 ||
								$fleetResult[0]['fleet_wanted_resource_amount'] == 0) {
			} else {
				$fleetResult = $fleetResult[0];
				$amount = $fleetResult['fleet_wanted_resource_amount'];
				$message = $PLANET[$resource[202]];
				// How many 203? (Heavy Cargo )
				$HCcapacity = 25000; // TODO officers
				$HCs = min($PLANET[$resource[203]], ceil($amount / $HCcapacity)); // How many needed
				$LCs = 0;
				$amountTMP = $amount - $HCs * $HCcapacity;
				if ($amountTMP > 0) {
						$LCcapacity = 5000;  //TODO officers
						$LCs = min($PLANET[$resource[202]], ceil($amount / $LCcapacity));
						$amountTMP -= $LCs * $LCcapacity;
				}
				if($amountTMP > 0) {
					$message = "Fleet is to small :-(";
				} else {
					$fleetArray = array();
					$fleetArray = array(203 => $HCs, 202 => $LCs);
					$fleetArray						= array_filter($fleetArray);
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
						$message = "Not enough resources";
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

						/*$fleetArray						= array_filter($fleetArray2);
						$SpeedFactor    	= FleetFunctions::GetGameSpeedFactor();
						$Distance    		= FleetFunctions::GetTargetDistance(array($PLANET['galaxy'], $PLANET['system'], $PLANET['planet']), array($fleetResult['fleet_end_galaxy'], $fleetResult['fleet_end_system'], $fleetResult['fleet_end_planet']));
						$SpeedAllMin		= FleetFunctions::GetFleetMaxSpeed($fleetArray, $USER);
						$Duration			= FleetFunctions::GetMissionDuration(10, $SpeedAllMin, $Distance, $SpeedFactor, $USER);
						$consumption		= FleetFunctions::GetFleetConsumption($fleetArray, $Duration, $Distance, $USER, $SpeedFactor);
*/
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
						$message = 'Sent';
				}}
			}
		}

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
					$resourceN = "Metal";
					$ratioN = 1;
					break;
				case 2:
					$resourceN = "Crystal";
					$ratioN = 2;
					break;
				case 3:
					$resourceN = "Deuterium";
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
