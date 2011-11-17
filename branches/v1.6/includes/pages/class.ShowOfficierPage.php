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
 * @version 1.6 (2011-11-17)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */



class ShowOfficierPage
{
	private function IsOfficierAccessible ($Officier)
	{
		global $USER, $requeriments, $resource, $pricelist;

		if (isset($requeriments[$Officier]))
		{
			$enabled = true;
			foreach($requeriments[$Officier] as $ReqOfficier => $OfficierLevel)
			{
				if ($USER[$resource[$ReqOfficier]] < $OfficierLevel)
					return 0;
			}
		}
		
		return ($USER[$resource[$Officier]] < $pricelist[$Officier]['max']) ? 1 : -1;
	}

	public function UpdateExtra($Element)
	{
		global $USER, $db, $reslist, $resource, $pricelist;
		
		if ((floor($USER['darkmatter'] / $pricelist[$Element]['darkmatter'])) > 0 && $USER[$resource[$Element]] == 0 || $USER[$resource[$Element]] < TIMESTAMP)
		{
			$USER[$resource[$Element]] 		= max($USER[$resource[$Element]], TIMESTAMP) + $pricelist[$Element]['time'] * 3600;
			$USER['darkmatter']         	-= $pricelist[$Element]['darkmatter'];
			$SQL  = "UPDATE ".USERS." SET ";
			$SQL .= "`".$resource[$Element]."` = '". $USER[$resource[$Element]] ."' ";
			$SQL .= "WHERE ";
			$SQL .= "`id` = '". $USER['id'] ."';";
			$db->query($SQL);
		}
	}

	public function UpdateOfficier($Selected)
	{
		global $USER, $PLANET, $db, $reslist, $resource;
		
		if (IsElementBuyable($USER, $PLANET, $Selected, true, false) && $this->IsOfficierAccessible($Selected) == 1)
		{
			$USER[$resource[$Selected]] += 1;
			$Resses						= GetBuildingPrice($USER, $PLANET, $Selected, true, false);
			$PLANET['metal']			-= $Resses['metal'];
			$PLANET['crystal']			-= $Resses['crystal'];
			$PLANET['deuterium']		-= $Resses['deuterium'];
			$USER['darkmatter']			-= $Resses['darkmatter'];
			$SQL  = "UPDATE ".USERS." SET ";
			$SQL .= "`".$resource[$Selected]."` = '". $USER[$resource[$Selected]] ."' ";
			$SQL .= "WHERE ";
			$SQL .= "`id` = '". $USER['id'] ."';";
			$db->query($SQL);
		}
	}
	
	public function __construct()
	{
		global $USER, $CONF, $PLANET, $resource, $reslist, $LNG, $db, $pricelist;
		
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.php');
		$action   = request_var('action', '');
		$Offi	  = request_var('offi', 0);
		$Extra	  = request_var('extra', 0);
				
		if ($action == "send" && $USER['urlaubs_modus'] == 0)
		{
			if(!empty($Offi) && !CheckModule(18) && in_array($Offi, $reslist['officier']))
				$this->UpdateOfficier($Offi);
			elseif(!empty($Extra) && !CheckModule(8) && in_array($Extra, $reslist['dmfunc']))
				$this->UpdateExtra($Extra);		
		}
		
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		$PlanetRess->SavePlanetToDB();
		
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			header('HTTP/1.0 204 No Content');
			exit;
		}
		
		$template	= new template();
		$template->loadscript('officier.js');		

		if(!CheckModule(8)) 
		{
			foreach($reslist['dmfunc'] as $Element)
			{
				if($USER[$resource[$Element]] > TIMESTAMP)
				{
					$template->execscript("GetOfficerTime(".$Element.", ".($USER[$resource[$Element]] - TIMESTAMP).");");
				}
				$pricelistList[]	= array(
					'id' 	 	=> $Element,
					'active'  	=> $USER[$resource[$Element]] - TIMESTAMP,
					'price'		=> pretty_number($pricelist[$Element]['darkmatter']),
					'isok'		=> (($USER['darkmatter'] - $pricelist[$Element]['darkmatter']) >= 0) ? true : false,
					'time'		=> pretty_time($pricelist[$Element]['time'] * 3600),
					'name'		=> $LNG['tech'][$Element],
					'desc'  	=> sprintf($LNG['res']['descriptions'][$Element], $pricelist[$Element]['add'] * 100),	
				);
			}
		}
		
		if(!CheckModule(18))
		{
			foreach($reslist['officier'] as $Element)
			{
				if (($Result = $this->IsOfficierAccessible($Element)) === 0)
					continue;
				
				$description = $pricelist[$Element]['info'] ? sprintf($LNG['info'][$Element]['description'], is_float($pricelist[$Element]['info']) ? $pricelist[$Element]['info'] * 100 : $pricelist[$Element]['info'], $pricelist[$Element]['max']) : sprintf($LNG['info'][$Element]['description'], $pricelist[$Element]['max']);
								
				$OfficierList[]	= array(
					'id' 		 	=> $Element,
					'level' 	 	=> $USER[$resource[$Element]],
					'name'			=> $LNG['tech'][$Element],
					'desc'  		=> $description,
					'Result'		=> $Result,
					'price'			=> GetElementPrice($USER, $PLANET, $Element),
					'isbuyable'		=> IsElementBuyable($USER, $PLANET, $Element, true, false)
				);
			}
		}
		
		$template->assign_vars(array(	
			'ExtraDMList'			=> $pricelistList,
			'OfficierList'			=> $OfficierList,
			'of_max_lvl'			=> $LNG['of_max_lvl'],
			'of_recruit'			=> $LNG['of_recruit'],
			'of_offi'				=> $LNG['of_offi'],
			'of_lvl'				=> $LNG['of_lvl'],
			'in_dest_durati'		=> $LNG['in_dest_durati'],
			'of_still'				=> $LNG['of_still'],
			'of_active'				=> $LNG['of_active'],
			'of_update'				=> $LNG['of_update'],
			'in_dest_durati'		=> $LNG['in_dest_durati'],
			'of_dm_trade'			=> sprintf($LNG['of_dm_trade'],$LNG['Darkmatter']),
		));
		
		$template->show("officier_overview.tpl");
	}
}
?>