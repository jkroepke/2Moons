<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.org              #
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

class MissionCaseOldExpedition extends MissionFunctions
{
		
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		$this->UpdateFleet('fleet_mess', 2);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		global $resource, $pricelist;
		
		$LNG		= $this->GetUserLang($this->_fleet['fleet_owner']);
		
		$FleetOwner = $this->_fleet['fleet_owner'];
		$MessSender = $LNG['sys_mess_qg'];
		$MessTitle  = $LNG['sys_expe_report'];
		
		$PointsFlotte = array(
			202 => 1.0,
			203 => 1.5,
			204 => 0.5,
			205 => 1.5,
			206 => 2.0,
			207 => 2.5,
			208 => 0.5,
			209 => 1.0,
			210 => 0.01,
			211 => 3.0,
			212 => 0.0,
			213 => 3.5,
			214 => 5.0,
			215 => 3.2,
			216 => 6.0,				
			217 => 1.7,
			218 => 7.0,				
			219 => 1.3,
		);
		$RatioGain = array (
			202 => 0.1,
			203 => 0.1,
			204 => 0.1,
			205 => 0.5,
			206 => 0.25,
			207 => 0.125,
			208 => 0.5,
			209 => 0.1,
			210 => 0.1,
			211 => 0.0625,
			212 => 0.0,
			213 => 0.0625,
			214 => 0.03125,
			215 => 0.0625,
			216 => 0.03125,				
			217 => 0.09,				
			218 => 0.01025,				
			219 => 0.09,			
		);

		$FleetStayDuration 	= ($this->_fleet['fleet_end_stay'] - $this->_fleet['fleet_start_time']) / 3600;
		$farray 			= explode(";", $this->_fleet['fleet_array']);
		foreach ($farray as $Item => $Group)
		{
			if ($Group != '')
			{
				$Class 						= explode (",", $Group);
				$TypeVaisseau 				= $Class[0];
				$NbreVaisseau 				= $Class[1];
				$LaFlotte[$TypeVaisseau]	= $NbreVaisseau;
				$FleetCapacity 			   += $pricelist[$TypeVaisseau]['capacity'];
				$FleetPoints   			   += ($NbreVaisseau * $PointsFlotte[$TypeVaisseau]);
			}
		}
		
		$FleetUsedCapacity  = $this->_fleet['fleet_resource_metal'] + $this->_fleet['fleet_resource_crystal'] + $this->_fleet['fleet_resource_deuterium'] + $this->_fleet['fleet_resource_darkmatter'];
		$FleetCapacity     -= $FleetUsedCapacity;
		$FleetCount 		= $this->_fleet['fleet_amount'];
		$Hasard 			= rand(0, 10);
		$MessSender 		= $LNG['sys_mess_qg']. "(".$Hasard.")";
		if ($Hasard < 3)
		{
			$Hasard     += 1;
			$LostAmount  = (($Hasard * 33) + 1) / 100;
			if ($LostAmount == 100)
			{
				SendSimpleMessage ( $FleetOwner, '', $this->_fleet['fleet_end_stay'], 15, $MessSender, $MessTitle, $LNG['sys_expe_blackholl_2'] );
				$this->KillFleet();
			}
			else
			{
				foreach ($LaFlotte as $Ship => $Count)
				{
					$LostShips[$Ship] = intval($Count * $LostAmount);
					$NewFleetArray   .= $Ship.",". ($Count - $LostShips[$Ship]) .";";
				}

				$this->UpdateFleet('fleet_array', $NewFleetArray);
				SendSimpleMessage ( $FleetOwner, '', $this->_fleet['fleet_end_stay'], 15, $MessSender, $MessTitle, $LNG['sys_expe_blackholl_1'] );
			}
		}
		elseif ($Hasard == 3)
		{
			SendSimpleMessage ( $FleetOwner, '', $this->_fleet['fleet_end_stay'], 15, $MessSender, $MessTitle, $LNG['sys_expe_nothing_1'] );
		}
		elseif ($Hasard>= 4 && $Hasard < 7)
		{
			if ($FleetCapacity> 5000)
			{
				$MinCapacity = $FleetCapacity - 5000;
				$MaxCapacity = $FleetCapacity;
				$FoundGoods  = rand($MinCapacity, $MaxCapacity);
				$FoundMetal  = intval($FoundGoods / 2);
				$FoundCrist  = intval($FoundGoods / 4);
				$FoundDeute  = intval($FoundGoods / 6);
				$FoundDark   = rand(1, 486);
				$this->UpdateFleet('fleet_resource_metal', $this->_fleet['fleet_resource_metal'] + $FoundMetal);
				$this->UpdateFleet('fleet_resource_crystal', $this->_fleet['fleet_resource_crystal'] + $FoundCrist);
				$this->UpdateFleet('fleet_resource_deuterium', $this->_fleet['fleet_resource_deuterium'] + $FoundDeute);
				$this->UpdateFleet('fleet_resource_darkmatter', $this->_fleet['fleet_resource_darkmatter'] + $FoundDark);
				$Message = sprintf($LNG['sys_expe_found_goods'], pretty_number($FoundMetal), $LNG['Metal'], pretty_number($FoundCrist), $LNG['Crystal'], pretty_number($FoundDeute), $LNG['Deuterium'], pretty_number($FoundDark), $LNG['Darkmatter']);
				SendSimpleMessage ( $FleetOwner, '', $this->_fleet['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message );
			}
		}
		elseif ($Hasard == 7)
		{	
			SendSimpleMessage ( $FleetOwner, '', $this->_fleet['fleet_end_stay'], 15, $MessSender, $MessTitle, $LNG['sys_expe_nothing_2'] );
		}
		elseif ($Hasard>= 8 && $Hasard < 11)
		{
			$LNG			+= $this->GetUserLang($this->_fleet['fleet_owner'], 'TECH');
			$FoundChance 	= $FleetPoints / $FleetCount;
			$FoundShip		= array();
			for ($Ship = 202; $Ship < 220; $Ship++)
			{
				if ($LaFlotte[$Ship] == 0)
						continue;

				$FoundShip[$Ship] = round($LaFlotte[$Ship] * $RatioGain[$Ship]);
				if ($FoundShip[$Ship] > 0)
					$LaFlotte[$Ship] += $FoundShip[$Ship];
			}
			$NewFleetArray = "";
			$FoundShipMess = "";
			foreach ($LaFlotte as $Ship => $Count)
			{
				if ($Count> 0)
					$NewFleetArray   .= $Ship.",". $Count .";";
			}
			foreach ($FoundShip as $Ship => $Count)
			{	
				if ($Count != 0)
					$FoundShipMess   .= $Count." ".$LNG['tech'][$Ship].",<br>\n";
			}

			$this->UpdateFleet('fleet_array', $NewFleetArrays);
			
			$Message = $LNG['sys_expe_found_ships']. $FoundShipMess . "";
			SendSimpleMessage ( $FleetOwner, '', $this->_fleet['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message);
		}
		
		$this->UpdateFleet('fleet_mess', 1);
		$this->SaveFleet();
	}
	
	function ReturnEvent()
	{
		$LNG		= $this->GetUserLang($this->_fleet['fleet_owner']);
	
		$Message = sprintf($LNG['sys_expe_back_home'], $LNG['Metal'], pretty_number($this->_fleet['fleet_resource_metal']), $LNG['Crystal'], pretty_number($this->_fleet['fleet_resource_crystal']),  $LNG['Deuterium'], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['Darkmatter'], pretty_number($this->_fleet['fleet_resource_darkmatter']));
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_end_time'], 15, $LNG['sys_mess_tower'], $LNG['sys_expe_report'], $Message);
		
		$this->RestoreFleet();
	}
}

?>