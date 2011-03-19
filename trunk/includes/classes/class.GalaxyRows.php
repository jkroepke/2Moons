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

 class GalaxyRows
{
	public function GetMissileRange($Level)
	{
		return max(($Level * 5) - 1, 0);
	}

	public function GetPhalanxRange($PhalanxLevel)
	{
		return ($PhalanxLevel == 1) ? 1 : pow($PhalanxLevel, 2) - 1;
	}

	public function GalaxyRowActions($GalaxyRowPlanet)
	{
		global $USER, $PLANET, $resource, $LNG;

		if ($PLANET[$resource[503]] > 0 && $GalaxyRowPlanet['galaxy'] == $PLANET['galaxy'])
		{
			$Range = $this->GetMissileRange($USER[$resource[117]]);
			$SystemLimitMin = max($PLANET['system'] - $Range, 1);
			$SystemLimitMax = $PLANET['system'] + $Range;
			$MissileBtn = $GalaxyRowPlanet['system'] <= $SystemLimitMax && $GalaxyRowPlanet['system'] >= $SystemLimitMin ? true : false;
		}

		$Result = array(
			'esp'		=> ($USER["settings_esp"] == 1) ? true : false,
			'message'	=> ($USER["settings_wri"] == 1) ? true : false,
			'buddy'		=> ($USER["settings_bud"] == 1) ? true : false,
			'missle'	=> ($USER["settings_mis"] == 1 && $MissileBtn == true) ? true : false,
		);

		return $Result;
	}

	public function GalaxyRowAlly($GalaxyRowPlanet)
	{
		global $USER, $LNG, $db;

		$Result = array(
			'id'		=> $GalaxyRowPlanet['allyid'],
			'name'		=> htmlspecialchars($GalaxyRowPlanet['ally_name'],ENT_QUOTES,"UTF-8"),
			'member'	=> sprintf(($GalaxyRowPlanet['ally_members'] == 1)?$LNG['gl_member_add']:$LNG['gl_member'], $GalaxyRowPlanet['ally_members']),
			'web'		=> $GalaxyRowPlanet['ally_web'],
			'inally'	=> ($USER['ally_id'] == $GalaxyRowPlanet['ally_id'])?2:(($USER['ally_id'] == $GalaxyRowPlanet['allyid'])?1:0),
			'tag'		=> $GalaxyRowPlanet['ally_tag'],
			'rank'		=> $GalaxyRowPlanet['ally_rank'],
		);
		
		return $Result;
	}

	public function GalaxyRowDebris($GalaxyRowPlanet)
	{
		global $USER, $PLANET, $pricelist, $resource;

		$GRecNeeded = min(ceil(($GalaxyRowPlanet['der_metal'] + $GalaxyRowPlanet['der_crystal']) / $pricelist[219]['capacity']), $PLANET[$resource[219]]);
		$RecNeeded 	= min(ceil(max($GalaxyRowPlanet['der_metal'] + $GalaxyRowPlanet['der_crystal'] - ($GRecNeeded * $pricelist[219]['capacity']), 0) / $pricelist[209]['capacity']), $PLANET[$resource[209]]);

		$Result = array(
			'metal'			=> pretty_number($GalaxyRowPlanet["der_metal"]),
			'crystal'		=> pretty_number($GalaxyRowPlanet["der_crystal"]),
			'RecSended'		=> $RecNeeded,			
			'GRecSended'	=> $GRecNeeded,			
		);

		return $Result;
	}

	public function GalaxyRowMoon($GalaxyRowMoon)
	{
		global $USER, $PLANET, $LNG, $resource;

		$Result = array(
			'name'		=> htmlspecialchars($GalaxyRowMoon['name'], ENT_QUOTES, "UTF-8"),
			'temp_min'	=> number_format($GalaxyRowMoon['temp_min'], 0, '', '.'), 
			'diameter'	=> number_format($GalaxyRowMoon['diameter'], 0, '', '.'),
			'attack'	=> ($GalaxyRowMoon['id_owner'] != $USER['id']) ? $LNG['type_mission'][1]:false,
			'transport'	=> $LNG['type_mission'][3],
			'stay'		=> ($GalaxyRowMoon['id_owner'] == $USER['id']) ? $LNG['type_mission'][4]:false,
			'stayally'	=> ($GalaxyRowMoon['id_owner'] != $USER['id']) ? $LNG['type_mission'][5]:false,
			'spionage'	=> ($GalaxyRowMoon['id_owner'] != $USER['id']) ? $LNG['type_mission'][6]:false,
			'destroy'	=> ($GalaxyRowMoon['id_owner'] != $USER['id'] && $PLANET[$resource[214]] > 0) ? $LNG['type_mission'][9]:false,
		);

		return $Result;
	}

	public function GalaxyRowPlanet($GalaxyRowPlanet)
	{
		global $resource, $USER, $PLANET, $CONF, $LNG;
		
		if($PLANET[$resource[42]] > 0 && $GalaxyRowPlanet['userid'] != $USER['id'] && $GalaxyRowPlanet["galaxy"] == $PLANET['galaxy'] && !CheckModule(19))
		{
			$PhRange 		 = $this->GetPhalanxRange($PLANET[$resource[42]]);
			$SystemLimitMin  = max(1, $PLANET['system'] - $PhRange);
			$SystemLimitMax  = $PLANET['system'] + $PhRange;
			$PhalanxTypeLink = ($GalaxyRowPlanet['system'] <= $SystemLimitMax && $GalaxyRowPlanet['system'] >= $SystemLimitMin) ? $LNG['gl_phalanx']:false;
		} else {
			$PhalanxTypeLink = false;
		}

		if ($PLANET[$resource[503]] > 0 && $GalaxyRowPlanet['userid'] != $USER['id'] && $GalaxyRowPlanet["galaxy"] == $PLANET['galaxy'])
		{
			$MiRange 		= $this->GetMissileRange($USER[$resource[117]]);
			$SystemLimitMin = max(1, $PLANET['system'] - $MiRange);
			$SystemLimitMax = $PLANET['system'] + $MiRange;
			$MissileBtn 	= ($GalaxyRowPlanet['system'] <= $SystemLimitMax && $GalaxyRowPlanet['system'] >= $SystemLimitMin) ? true : false;
		} else {
			$MissileBtn 	= false;
		}

		$Result = array(
			'id'			=> $GalaxyRowPlanet['id'],
			'name'			=> htmlspecialchars($GalaxyRowPlanet['name'],ENT_QUOTES,"UTF-8"),
			'image'			=> $GalaxyRowPlanet['image'],
			'phalax'		=> $PhalanxTypeLink,
			'transport'		=> $LNG['type_mission'][3],
			'spionage'		=> ($GalaxyRowPlanet['userid'] != $USER['id']) ? $LNG['type_mission'][6]:false,
			'attack'		=> ($GalaxyRowPlanet['userid'] != $USER['id']) ? $LNG['type_mission'][1]:false,
			'missile'		=> ($USER["settings_mis"] == "1" && $MissileBtn === true && $GalaxyRowPlanet['userid'] != $USER['id']) ? $LNG['gl_missile_attack']:false,
			'stay'			=> ($GalaxyRowPlanet['userid'] == $USER['id']) ? $LNG['type_mission'][4]:false,
			'stayally'		=> ($GalaxyRowPlanet['userid'] != $USER['id']) ? $LNG['type_mission'][5]:false,
		);
		
		return $Result;
	}

	public function GalaxyRowPlanetName($GalaxyRowPlanet)
	{
		global $USER, $LNG;

		$Onlinetime			= floor((TIMESTAMP - $GalaxyRowPlanet['last_update']) / 60);
		
		$Result = array(
			'name'			=> htmlspecialchars($GalaxyRowPlanet['name'],ENT_QUOTES,"UTF-8"),
			'activity'		=> ($Onlinetime < 4) ? $LNG['gl_activity'] : (($Onlinetime < 15) ? sprintf($LNG['gl_activity_inactive'], $Onlinetime) : ''),
		);
		
		return $Result;
	}

	public function GalaxyRowUser($GalaxyRowPlanet)
	{
		global $CONF, $USER, $LNG, $db;

		$protection      	= $CONF['noobprotection'];
		$protectiontime  	= $CONF['noobprotectiontime'];
		$protectionmulti 	= $CONF['noobprotectionmulti'];
		$CurrentPoints 		= $USER['total_points'];
		$RowUserPoints 		= $GalaxyRowPlanet['total_points'];
		$IsNoobProtec		= CheckNoobProtec($USER, $GalaxyRowPlanet, $GalaxyRowPlanet);
		
		if ($GalaxyRowPlanet['banaday'] > TIMESTAMP && $GalaxyRowPlanet['urlaubs_modus'] == 1)
		{
			$Systemtatus2 	= $LNG['gl_v']." <a href=\"game.php?page=banned\"><span class=\"banned\">".$LNG['gl_b']."</span></a>";
			$Systemtatus 	= "<span class=\"vacation\">";
		}
		elseif ($GalaxyRowPlanet['banaday'] > TIMESTAMP)
		{
			$Systemtatus2 	= "<span class=\"banned\">".$LNG['gl_b']."</span>";
			$Systemtatus 	= "";
		}
		elseif ($GalaxyRowPlanet['urlaubs_modus'] == 1)
		{
			$Systemtatus2 	= "<span class=\"vacation\">".$LNG['gl_v']."</span>";
			$Systemtatus 	= "<span class=\"vacation\">";
		}
		elseif ($GalaxyRowPlanet['onlinetime'] < (TIMESTAMP-60 * 60 * 24 * 7) && $GalaxyRowPlanet['onlinetime'] > (TIMESTAMP-60 * 60 * 24 * 28))
		{
			$Systemtatus2 	= "<span class=\"inactive\">".$LNG['gl_i']."</span>";
			$Systemtatus 	= "<span class=\"inactive\">";
		}
		elseif ($GalaxyRowPlanet['onlinetime'] < (TIMESTAMP-60 * 60 * 24 * 28))
		{
			$Systemtatus2 	= "<span class=\"inactive\">".$LNG['gl_i']."</span><span class=\"longinactive\">".$LNG['gl_I']."</span>";
			$Systemtatus 	= "<span class=\"longinactive\">";
		}
		elseif ($IsNoobProtec['NoobPlayer'])
		{
			$Systemtatus2 	= "<span class=\"noob\">".$LNG['gl_w']."</span>";
			$Systemtatus 	= "<span class=\"noob\">";
		}
		elseif ($IsNoobProtec['StrongPlayer'])
		{
			$Systemtatus2 	= $LNG['gl_s'];
			$Systemtatus 	= "<span class=\"strong\">";
		}
		else
		{
			$Systemtatus2 	= "";
			$Systemtatus 	= "";
		}

		if (!empty($Systemtatus2))
		{
			$Systemtatus2 	= "<span style=\"color:white\">(</span>".$Systemtatus2."<span style=\"color:white\">)</span>";
		}

		$Result	= array(
			'id'			=> $GalaxyRowPlanet['userid'],
			'username'		=> htmlspecialchars($GalaxyRowPlanet['username'],ENT_QUOTES,"UTF-8"),
			'rank'			=> $GalaxyRowPlanet['total_rank'],
			'points'		=> pretty_number($GalaxyRowPlanet['total_points']),
			'playerrank'	=> sprintf($LNG['gl_in_the_rank'], htmlspecialchars($GalaxyRowPlanet['username'],ENT_QUOTES,"UTF-8"), $GalaxyRowPlanet['total_rank']),
			'Systemtatus'	=> $Systemtatus,
			'Systemtatus2'	=> $Systemtatus2,
			'isown'			=> ($GalaxyRowPlanet['userid'] != $USER['id']) ? true : false,
		);
		return $Result;
	}
}
?>