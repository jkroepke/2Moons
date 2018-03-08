<?php

/**
 *  2Moons / Steemnova
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package Steemnova
 * @author Adam Jordanek <dotevo@gmail.com>
 * @licence MIT
 */

class MissionCaseTrade extends MissionFunctions implements Mission
{
	function __construct($fleet)
	{
		$this->_fleet	= $fleet;
	}

	function TargetEvent()
	{
		$this->setState(FLEET_HOLD);
		$this->SaveFleet();
	}

	function EndStayEvent()
	{
		$this->setState(FLEET_RETURN);
		$this->SaveFleet();
	}

	function ReturnEvent()
	{
		$LNG		= $this->getLanguage(NULL, $this->_fleet['fleet_owner']);
		$sql		= 'SELECT name FROM %%PLANETS%% WHERE id = :planetId;';
		$planetName	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->_fleet['fleet_start_id'],
		), 'name');

		$Message	= sprintf($LNG['sys_tran_mess_back'], $planetName, GetStartAddressLink($this->_fleet, ''));

		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_mess_tower'], 4, $LNG['sys_mess_fleetback'],
			$Message, $this->_fleet['fleet_end_time'], NULL, 1, $this->_fleet['fleet_universe']);

		$this->RestoreFleet();
	}
}
