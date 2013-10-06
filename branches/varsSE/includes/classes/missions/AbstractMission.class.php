<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.8.0 (2013-03-18)
 * @info $Id: MissionCaseAttack.class.php 2779 2013-08-07 19:19:24Z slaver7 $
 * @link http://2moons.cc/
 */

class AbstractMission
{
	protected $fleetData;

	private $ships;
	private $resources;


	private $todoSave;
	private $nextEventTime;

	private $fleetKilled	= false;

	public function __construct($fleet)
	{
		$this->fleetData	= $fleet;
		$this->ships		= $fleet['elements'][Vars::CLASS_FLEET];
		$this->resources	= $fleet['elements'][Vars::CLASS_RESOURCE];
	}

	public function arrivalEndTargetEvent()
	{
		return true;
	}

	public function endStayTimeEvent()
	{
		return true;
	}

	public function arrivalStartTargetEvent()
	{
		return true;
	}

	public function saveFleet()
	{
		$db	= Database::get();

		if($this->fleetKilled === true)
		{
			$sql	= 'DELETE FROM %%FLEETS%%
						LEFT JOIN %%FLEETS_ELEMENTS%% ON fleetId = fleetId,
						LEFT JOIN %%FLEETS_EVENT%% ON fleetId = fleetId
				  	   WHERE fleetId = :fleetId';

			Database::get()->delete($sql, array(
				':fleetId'	=> $this->fleetData['fleetId']
			));

			return true;
		}

		$param	= array();

		$updateQuery	= array();

		foreach($this->todoSave as $key => $value)
		{
			$updateQuery[]	= "`".$key."` = :".$key;
			$param[':'.$key]	= $value;
			unset($this->todoSave[$key]);
		}

		if(!empty($updateQuery))
		{
			$sql	= 'UPDATE %%FLEETS%% SET '.implode(', ', $updateQuery).' WHERE `fleetId` = :fleetId;';
			$param[':fleetId']	= $this->fleetData['fleetId'];
			$db->update($sql, $param);
		}

		$db->update("UPDATE %%FLEETS_EVENT%% SET `lockToken` = NULL , `time` = :time;", array(
			':lockToken'	=> Database::formatDate($this->nextEventTime)
		));

		return false;
	}

	protected function updateData($key, $value)
	{
		$this->fleetData[$key]	= $value;
		$this->todoSave[$key]	= $value;
	}

	protected function setNextState($state)
	{
		$this->updateData('fleet_mess', $state);

		switch($state)
		{
			case FLEET_OUTWARD:
				$this->nextEventTime = $this->fleetData['fleet_start_time'];
			break;
			case FLEET_RETURN:
				$this->nextEventTime = $this->fleetData['fleet_end_time'];
			break;
			case FLEET_HOLD:
				$this->nextEventTime = $this->fleetData['fleet_end_stay'];
			break;
		}
	}

	protected function killFleet()
	{
		$this->fleetKilled	= true;
	}

	protected function getLanguage($languageId)
	{
		$LNG = new Language($languageId);
		$LNG->includeData(array('L18N', 'FLEET', 'TECH', 'CUSTOM'));

		return $LNG;
	}

	protected function getTplObj(Language $LNG)
	{
		require_once 'includes/classes/Template.class.php';

		$tplObj	= new Template;
		$tplObj->getSmartyObj()->compile_id	= $LNG->getLanguage();
		$tplObj->getSmartyObj()->loadFilter('output', 'trimwhitespace');
		$tplObj->assign_vars(array(
			'LNG'			=> $LNG
		), false);

		return $tplObj;
	}

	protected function arrivalTo($planetId, $fleetData, $resources)
	{
		$updateQuery	= array();

		$param	= array(
			':planetId'		=> $planetId
		);

		$fleetData	= array_filter($fleetData);
		$resources	= array_filter($resources);

		foreach($resources as $elementResourceId => $value)
		{
			$elementResourceObj	= Vars::getElement($elementResourceId);
			$shortKey	= $elementResourceObj->isUserResource() ? 'u' : 'p';

			$updateQuery[]	= sprintf('%1$s.`%2$s` = %1$s.`%2$s` + :%2$s', $shortKey, $elementResourceObj->name);
			$param[':'.$elementResourceObj->name]	= floattostring($value);

			$this->fleetData['elements'][Vars::CLASS_RESOURCE][$elementResourceId] = 0;
		}

		foreach($fleetData as $elementShipId => $value)
		{
			$elementShipObj	= Vars::getElement($elementShipId);
			$updateQuery[]	= sprintf('p.`%s` = p.`%s` + :%s', $elementShipObj->name);
			$param[':'.$elementShipObj->name]	= floattostring($value);

			$this->fleetData['elements'][Vars::CLASS_FLEET][$elementShipId] = 0;
		}

		$sql	= 'UPDATE %%PLANETS%% as p, %%USERS%% as u SET
		'.implode(', ', $updateQuery).',
		WHERE p.`id` = :planetId AND u.id = p.id_owner;';

		Database::get()->update($sql, $param);
	}
}