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
 * @info $Id$
 * @link http://2moons.cc/
 */

class ShowFleetMissilePage extends AbstractGamePage
{
	public static $requireModule = MODULE_MISSILEATTACK;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function show()
	{	
		global $USER, $PLANET, $LNG;

		$targetGalaxy 		= HTTP::_GP('galaxy', 0);
		$targetSystem 		= HTTP::_GP('system', 0);
		$targetPlanet 		= HTTP::_GP('planet', 0);
		$targetType 		= HTTP::_GP('type', 0);
		$missileCount   	= HTTP::_GP('missile', array());
		$primaryTarget 		= HTTP::_GP('primaryTarget', 0);

        $fleetData          = array();

        $db					= Database::get();

        $sql				= "SELECT id, id_owner FROM %%PLANETS%%
        WHERE universe = :universe AND galaxy = :targetGalaxy
        AND system = :targetSystem AND planet = :targetPlanet AND planet_type = :targetType;";

        $target = $db->selectSingle($sql, array(
            ':universe' => Universe::current(),
            ':targetGalaxy' => $targetGalaxy,
            ':targetSystem' => $targetSystem,
            ':targetPlanet' => $targetPlanet,
            ':targetType'   => $targetType
        ));

        $Range				= FleetUtil::GetMissileRange($USER);
		$systemMin			= $PLANET['system'] - $Range;
		$systemMax			= $PLANET['system'] + $Range;
		
		$error				= "";

        foreach($missileCount as $elementId => $amount)
        {
            $elementObj = Vars::getElement($elementId);
            if($amount != 0 && $elementObj->hasFlag(Vars::FLAG_ATTACK_MISSILE))
            {
                $fleetData[$elementId]  = min($amount, $PLANET[$elementObj->name]);
            }
        }

        $primaryElements    = array_merge(Vars::getElements(Vars::CLASS_DEFENSE), Vars::getElements(NULL, Vars::FLAG_ATTACK_MISSILE));
		
		if (IsVacationMode($USER))
        {
            $error = $LNG['fl_vacation_mode_active'];
        }
		elseif ($PLANET['silo'] < 4)
        {
            $error = $LNG['ma_silo_level'];
        }
		elseif ($USER['impulse_motor_tech'] == 0)
        {
            $error = $LNG['ma_impulse_drive_required'];
        }
		elseif ($targetGalaxy != $PLANET['galaxy'] || $targetSystem < $systemMin || $targetSystem > $systemMax)
        {
            $error = $LNG['ma_not_send_other_galaxy'];
        }
		elseif (!$target)
        {
            $error = $LNG['ma_planet_doesnt_exists'];
        }
		elseif ($primaryTarget != 0 && !in_array($primaryTarget, $primaryElements))
        {

            $error = $LNG['ma_wrong_target'];
        }
		elseif ($missileCount == 0)
        {
            $error = $LNG['ma_no_missiles'];
        }

		$targetUser	   	= GetUserByID($target['id_owner'], array('onlinetime', 'banaday', 'urlaubs_modus', 'authattack'));
		
		if (Config::get()->adm_attack == 1 && $targetUser['authattack'] > $USER['authlevel'])
        {
            $error = $LNG['fl_admin_attack'];
        }
		elseif($targetUser['urlaubs_modus'])
        {
            $error = $LNG['fl_in_vacation_player'];
        }
			
		$sql = "SELECT total_points FROM %%STATPOINTS%% WHERE stat_type = '1' AND id_owner = :ownerId;";
        $User2Points = $db->selectSingle($sql, array(
            ':ownerId'  => $target['id_owner']
        ));

		$sql	= 'SELECT total_points
		FROM %%STATPOINTS%%
		WHERE id_owner = :userId AND stat_type = :statType';

		$USER	+= Database::get()->selectSingle($sql, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		));

        $IsNoobProtec	= CheckNoobProtec($USER, $User2Points, $targetUser);
			
		if ($IsNoobProtec['NoobPlayer'])
        {
            $error = $LNG['fl_week_player'];
        }
		elseif ($IsNoobProtec['StrongPlayer'])
        {
            $error = $LNG['fl_strong_player'];
        }
				
		if ($error != "")
		{
			$this->printMessage($error);
		}
		
		$Duration		= FleetUtil::getMissileDuration($PLANET['system'], $targetSystem);

		$DefenseLabel 	= ($primaryTarget == 0) ? $LNG['ma_all'] : $LNG['tech'][$primaryTarget];
		
		$fleetStartTime	= TIMESTAMP + $Duration;
		$fleetStayTime	= $fleetStartTime;
		$fleetEndTime	= $fleetStartTime;
		
		$fleetResource	= ArrayUtil::combineArrayWithSingleElement(array_keys(Vars::getElements(NULL, Vars::FLAG_TRANSPORT)), 0);
		
		FleetUtil::sendFleet($fleetData, 10, $USER['id'], $PLANET['id'], $PLANET['galaxy'], $PLANET['system'],
			$PLANET['planet'], $PLANET['planet_type'], $target['id_owner'], $target['id'], $targetGalaxy, $targetSystem,
			$targetPlanet, $targetType, $fleetResource, $fleetStartTime, $fleetStayTime, $fleetEndTime, 0, $primaryTarget);

		$this->printMessage("<b>".array_sum($fleetData)."</b>". $LNG['ma_missiles_sended'].$DefenseLabel);
	}
}