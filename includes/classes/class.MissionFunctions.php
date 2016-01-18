<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class MissionFunctions
{	
	public $kill	= 0;
	public $_fleet	= array();
	public $_upd	= array();
	public $eventTime	= 0;
	
	function UpdateFleet($Option, $Value)
	{
		$this->_fleet[$Option] = $Value;
		$this->_upd[$Option] = $Value;
	}

	function setState($Value)
	{
		$this->_fleet['fleet_mess'] = $Value;
		$this->_upd['fleet_mess']	= $Value;
		
		switch($Value)
		{
			case FLEET_OUTWARD:
				$this->eventTime = $this->_fleet['fleet_start_time'];
			break;
			case FLEET_RETURN:
				$this->eventTime = $this->_fleet['fleet_end_time'];
			break;
			case FLEET_HOLD:
				$this->eventTime = $this->_fleet['fleet_end_stay'];
			break;
		}
	}
	
	function SaveFleet()
	{
		if($this->kill == 1)
			return;
			
		$param	= array();

		$updateQuery	= array();

		foreach($this->_upd as $Opt => $Val)
		{
			$updateQuery[]	= "`".$Opt."` = :".$Opt;
			$param[':'.$Opt]	= $Val;
		}
		
		if(!empty($updateQuery))
		{
			$sql	= 'UPDATE %%FLEETS%% SET '.implode(', ', $updateQuery).' WHERE `fleet_id` = :fleetId;';
			$param[':fleetId']	= $this->_fleet['fleet_id'];
			Database::get()->update($sql, $param);

			$sql	= 'UPDATE %%FLEETS_EVENT%% SET time = :time WHERE `fleetID` = :fleetId;';
			Database::get()->update($sql, array(
				':time'		=> $this->eventTime,
				':fleetId'	=> $this->_fleet['fleet_id']
			));
		}
	}
		
	function RestoreFleet($onStart = true)
	{
		global $resource;

		$fleetData		= FleetFunctions::unserialize($this->_fleet['fleet_array']);

		$updateQuery	= array();

		$param	= array(
			':metal'		=> $this->_fleet['fleet_resource_metal'],
			':crystal'		=> $this->_fleet['fleet_resource_crystal'],
			':deuterium'	=> $this->_fleet['fleet_resource_deuterium'],
			':darkmatter'	=> $this->_fleet['fleet_resource_darkmatter'],
			':planetId'		=> $onStart == true ? $this->_fleet['fleet_start_id'] : $this->_fleet['fleet_end_id']
		);

		foreach ($fleetData as $shipId => $shipAmount)
		{
			$updateQuery[]	= "p.`".$resource[$shipId]."` = p.`".$resource[$shipId]."` + :".$resource[$shipId];
			$param[':'.$resource[$shipId]]	= $shipAmount;
		}

		$sql	= 'UPDATE %%PLANETS%% as p, %%USERS%% as u SET
		'.implode(', ', $updateQuery).',
		p.`metal` = p.`metal` + :metal,
		p.`crystal` = p.`crystal` + :crystal,
		p.`deuterium` = p.`deuterium` + :deuterium,
		u.`darkmatter` = u.`darkmatter` + :darkmatter
		WHERE p.`id` = :planetId AND u.id = p.id_owner;';

		Database::get()->update($sql, $param);

		$this->KillFleet();
	}
	
	function StoreGoodsToPlanet($onStart = false)
	{
		$sql  = 'UPDATE %%PLANETS%% as p, %%USERS%% as u SET
		`metal`			= `metal` + :metal,
		`crystal`		= `crystal` + :crystal,
		`deuterium` 	= `deuterium` + :deuterium,
		`darkmatter`	= `darkmatter` + :darkmatter
		WHERE p.`id` = :planetId AND u.id = p.id_owner;';

		Database::get()->update($sql, array(
			':metal'		=> $this->_fleet['fleet_resource_metal'],
			':crystal'		=> $this->_fleet['fleet_resource_crystal'],
			':deuterium'	=> $this->_fleet['fleet_resource_deuterium'],
			':darkmatter'	=> $this->_fleet['fleet_resource_darkmatter'],
		 	':planetId'		=> ($onStart == true ? $this->_fleet['fleet_start_id'] : $this->_fleet['fleet_end_id'])
		));

		$this->UpdateFleet('fleet_resource_metal', '0');
		$this->UpdateFleet('fleet_resource_crystal', '0');
		$this->UpdateFleet('fleet_resource_deuterium', '0');
	}
	
	function KillFleet()
	{
		$this->kill	= 1;
		$sql	= 'DELETE %%FLEETS%%, %%FLEETS_EVENT%%
		FROM %%FLEETS%% LEFT JOIN %%FLEETS_EVENT%% on fleet_id = fleetId
		WHERE `fleet_id` = :fleetId';

		Database::get()->delete($sql, array(
			':fleetId'	=> $this->_fleet['fleet_id']
		));
	}
	
	function getLanguage($language = NULL, $userID = NULL)
	{
		if(is_null($language) && !is_null($userID))
		{
			$sql		= 'SELECT lang FROM %%USERS%% WHERE id = :userId;';
			$language	= Database::get()->selectSingle($sql, array(
				':userId' => $this->_fleet['fleet_owner']
			), 'lang');
		}
		
		$LNG		= new Language($language);
		$LNG->includeData(array('L18N', 'FLEET', 'TECH', 'CUSTOM'));
		return $LNG;
	}
}