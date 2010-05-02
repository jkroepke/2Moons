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

class GalaxyRows
{
	private function GetMissileRange()
	{
		global $resource, $user;
		return max(($user[$resource[117]] * 5) - 1, 0);
	}

	public function GetPhalanxRange($PhalanxLevel)
	{
		return ($PhalanxLevel == 1) ? 1 : pow($PhalanxLevel, 2) - 1;
	}

	public function GalaxyRowActions($GalaxyRowPlanet, $CurrentGalaxy, $CurrentSystem, $CurrentMIP)
	{
		global $user, $dpath, $lang;

		if ($CurrentMIP > 0 && $GalaxyRowPlanet['galaxy'] == $CurrentGalaxy)
		{
			$Range = $this->GetMissileRange();
			$SystemLimitMin = max($CurrentSystem - $Range, 1);
			$SystemLimitMax = $CurrentSystem + $Range;
			if ($GalaxyRowPlanet['system'] <= $SystemLimitMax && $GalaxyRowPlanet['system'] >= $SystemLimitMin)
				$MissileBtn = true;
			else
				$MissileBtn = false;
		}

		$Result = array(
			'esp'		=> ($user["settings_esp"] == 1) ? true : false,
			'message'	=> ($user["settings_wri"] == 1) ? true : false,
			'buddy'		=> ($user["settings_bud"] == 1) ? true : false,
			'missle'	=> ($user["settings_mis"] == 1 && $MissileBtn == true) ? true : false,
		);

		return $Result;
	}

	public function GalaxyRowAlly($GalaxyRowPlanet)
	{
		global $user, $lang, $db;

		$Result = array(
			'id'		=> $GalaxyRowPlanet['allyid'],
			'name'		=> htmlspecialchars($GalaxyRowPlanet['ally_name'],ENT_QUOTES,"UTF-8"),
			'member'	=> sprintf(($GalaxyRowPlanet['ally_members'] == 1)?$lang['gl_member_add']:$lang['gl_member'], $GalaxyRowPlanet['ally_members']),
			'web'		=> $GalaxyRowPlanet['ally_web'],
			'inally'	=> ($user['ally_id'] == $GalaxyRowPlanet['ally_id'])?2:(($user['ally_id'] == $GalaxyRowPlanet['allyid'])?1:0),
			'tag'		=> $GalaxyRowPlanet['ally_tag'],
			'rank'		=> $GalaxyRowPlanet['ally_rank'],
		);
		
		return $Result;
	}

	public function GalaxyRowDebris($GalaxyRowPlanet, $CurrentRC, $CurrentGRC)
	{
		global $user, $pricelist, $lang;

		$GRecNeeded = min(ceil(($GalaxyRowPlanet['der_metal'] + $GalaxyRowPlanet['der_crystal']) / $pricelist[219]['capacity']), $CurrentGRC);
		$RecNeeded 	= min(ceil(max($GalaxyRowPlanet['der_metal'] + $GalaxyRowPlanet['der_crystal'] - ($GRecNeeded * $pricelist[219]['capacity']), 0) / $pricelist[209]['capacity']), $CurrentRC);
				
		$Result = array(
			'metal'			=> pretty_number($GalaxyRowPlanet["der_metal"]),
			'crystal'		=> pretty_number($GalaxyRowPlanet["der_crystal"]),
			'RecSended'		=> $RecNeeded,			
			'GRecSended'	=> $GRecNeeded,			
		);

		return $Result;
	}

	public function GalaxyRowMoon($GalaxyRowUser, $GalaxyRowMoon, $CanDestroy)
	{
		global $user, $lang;

		$Result = array(
			'name'		=> htmlspecialchars($GalaxyRowMoon['name'], ENT_QUOTES, "UTF-8"),
			'temp_min'	=> number_format($GalaxyRowMoon['temp_min'], 0, '', '.'), 
			'diameter'	=> number_format($GalaxyRowMoon['diameter'], 0, '', '.'),
			'attack'	=> ($GalaxyRowUser['userid'] != $user['id']) ? $lang['type_mission'][1]:false,
			'transport'	=> $lang['type_mission'][3],
			'stay'		=> ($GalaxyRowUser['userid'] == $user['id']) ? $lang['type_mission'][4]:false,
			'stayally'	=> ($GalaxyRowUser['userid'] != $user['id']) ? $lang['type_mission'][5]:false,
			'spionage'	=> ($GalaxyRowUser['userid'] != $user['id']) ? $lang['type_mission'][6]:false,
			'destroy'	=> ($GalaxyRowUser['userid'] != $user['id'] && $CanDestroy > 0) ? $lang['type_mission'][9]:false,
		);

		return $Result;
	}

	public function GalaxyRowPlanet($GalaxyRowPlanet, $HavePhalanx, $CurrentGalaxy, $CurrentSystem, $CurrentMIP)
	{
		global $dpath, $user, $game_config, $lang;
		
		if($HavePhalanx > 0 && $GalaxyRowPlanet['userid'] != $user['id'] && $GalaxyRowPlanet["galaxy"] == $CurrentGalaxy)
		{
			$PhRange 		 = $this->GetPhalanxRange ( $HavePhalanx );
			$SystemLimitMin  = max(1, $CurrentSystem - $PhRange);
			$SystemLimitMax  = $CurrentSystem + $PhRange;
			$PhalanxTypeLink = ($GalaxyRowPlanet['system'] <= $SystemLimitMax && $GalaxyRowPlanet['system'] >= $SystemLimitMin) ? $lang['gl_phalanx']:false;
		}

		if ($CurrentMIP > 0 && $GalaxyRowPlanet['userid'] != $user['id'] && $GalaxyRowPlanet["galaxy"] == $CurrentGalaxy)
		{
			$MiRange 		= $this->GetMissileRange();
			$SystemLimitMin = max(1, $CurrentSystem - $MiRange);
			$SystemLimitMax = $CurrentSystem + $MiRange;
			$MissileBtn 	= ($GalaxyRowPlanet['system'] <= $SystemLimitMax && $GalaxyRowPlanet['system'] >= $SystemLimitMin) ? true : false;
		}

		$Result = array(
			'name'			=> htmlspecialchars($GalaxyRowPlanet['name'],ENT_QUOTES,"UTF-8"),
			'image'			=> $GalaxyRowPlanet['image'],
			'phalax'		=> $PhalanxTypeLink,
			'transport'		=> $lang['type_mission'][3],
			'spionage'		=> ($GalaxyRowPlanet['userid'] != $user['id']) ? $lang['type_mission'][6]:false,
			'attack'		=> ($GalaxyRowPlanet['userid'] != $user['id']) ? $lang['type_mission'][1]:false,
			'missile'		=> ($user["settings_mis"] == "1" && $MissileBtn === true && $GalaxyRowPlanet['userid'] != $user['id']) ? $lang['gl_missile_attack']:false,
			'stay'			=> ($GalaxyRowPlanet['userid'] == $user['id']) ? $lang['type_mission'][4]:false,
			'stayally'		=> ($GalaxyRowPlanet['userid'] != $user['id']) ? $lang['type_mission'][5]:false,
		);
		
		return $Result;
	}

	public function GalaxyRowPlanetName($GalaxyRowPlanet)
	{
		global $user, $lang;

		$Onlinetime			= floor((time() - $GalaxyRowPlanet['last_update']) / 60);
		
		$Result = array(
			'name'			=> htmlspecialchars($GalaxyRowPlanet['name'],ENT_QUOTES,"UTF-8"),
			'activity'		=> ($Onlinetime < 4) ? $lang['gl_activity'] : (($Onlinetime < 15) ? sprintf($lang['gl_activity_inactive'], $Onlinetime) : ''),
		);
		
		return $Result;
	}

	public function GalaxyRowUser($GalaxyRowPlanet, $UserPoints)
	{
		global $game_config, $user, $lang, $db;

		$protection      	= $game_config['noobprotection'];
		$protectiontime  	= $game_config['noobprotectiontime'];
		$protectionmulti 	= $game_config['noobprotectionmulti'];
		$CurrentPoints 		= $GalaxyRowPlanet['total_points'];
		$RowUserPoints 		= $GalaxyRowPlanet['total_points'];
		$IsNoobProtec		= CheckNoobProtec($UserPoints, $GalaxyRowPlanet, $GalaxyRowPlanet['onlinetime']);
				
		if ($GalaxyRowPlanet['bana'] == 1 && $GalaxyRowPlanet['urlaubs_modus'] == 1)
		{
			$Systemtatus2 	= $lang['gl_v']." <a href=\"game.php?page=banned\"><span class=\"banned\">".$lang['gl_b']."</span></a>";
			$Systemtatus 	= "<span class=\"vacation\">";
		}
		elseif ($GalaxyRowPlanet['bana'] == 1)
		{
			$Systemtatus2 	= "<span class=\"banned\">".$lang['gl_b']."</span>";
			$Systemtatus 	= "";
		}
		elseif ($GalaxyRowPlanet['urlaubs_modus'] == 1)
		{
			$Systemtatus2 	= "<span class=\"vacation\">".$lang['gl_v']."</span>";
			$Systemtatus 	= "<span class=\"vacation\">";
		}
		elseif ($GalaxyRowPlanet['onlinetime'] < (time()-60 * 60 * 24 * 7) && $GalaxyRowPlanet['onlinetime'] > (time()-60 * 60 * 24 * 28))
		{
			$Systemtatus2 	= "<span class=\"inactive\">".$lang['gl_i']."</span>";
			$Systemtatus 	= "<span class=\"inactive\">";
		}
		elseif ($GalaxyRowPlanet['onlinetime'] < (time()-60 * 60 * 24 * 28))
		{
			$Systemtatus2 	= "<span class=\"inactive\">".$lang['gl_i']."</span><span class=\"longinactive\">".$lang['gl_I']."</span>";
			$Systemtatus 	= "<span class=\"longinactive\">";
		}
		elseif ($IsNoobProtec['NoobPlayer'])
		{
			$Systemtatus2 	= "<span class=\"noob\">".$lang['gl_w']."</span>";
			$Systemtatus 	= "<span class=\"noob\">";
		}
		elseif ($IsNoobProtec['StrongPlayer'])
		{
			$Systemtatus2 	= $lang['gl_s'];
			$Systemtatus 	= "<span class=\"strong\">";
		}
		else
		{
			$Systemtatus2 	= "";
			$Systemtatus 	= "";
		}

		if ($Systemtatus2 != '')
		{
			$Systemtatus2 	= "<font color=\"white\">(</font>".$Systemtatus2."<font color=\"white\">)</font>";
		}

		$Result	= array(
			'id'			=> $GalaxyRowPlanet['userid'],
			'username'		=> htmlspecialchars($GalaxyRowPlanet['username'],ENT_QUOTES,"UTF-8"),
			'rank'			=> $GalaxyRowPlanet['total_rank'],
			'playerrank'	=> sprintf($lang['gl_in_the_rank'], htmlspecialchars($GalaxyRowPlanet['username'],ENT_QUOTES,"UTF-8"), $GalaxyRowPlanet['total_rank']),
			'Systemtatus'	=> $Systemtatus,
			'Systemtatus2'	=> $Systemtatus2,
			'isown'			=> ($GalaxyRowPlanet['userid'] != $user['id']) ? true : false,
		);
		return $Result;
	}
}
?>