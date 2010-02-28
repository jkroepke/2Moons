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

class ShowOfficierPage
{
	private function IsOfficierAccessible ($CurrentUser, $Officier)
	{
		global $requeriments, $resource, $pricelist;

		if (isset($requeriments[$Officier]))
		{
			$enabled = true;
			foreach($requeriments[$Officier] as $ReqOfficier => $OfficierLevel)
			{
				if ($CurrentUser[$resource[$ReqOfficier]] && $CurrentUser[$resource[$ReqOfficier]] >= $OfficierLevel)
				{
					$enabled = 1;
				}
				else
				{
					return 0;
				}
			}
		}
		if ($CurrentUser[$resource[$Officier]] < $pricelist[$Officier]['max']  )
		{
			return 1;
		}
		else
		{
			return -1;
		}
	}

	public function UpdateExtra(&$CurrentUser, $Element)
	{
		global $db, $reslist, $resource, $ExtraDM;
		
		if ((floor($CurrentUser['darkmatter'] / $ExtraDM[$Element]['darkmatter'])) > 0 && in_array($Element, $reslist['dmfunc']))
		{
			$CurrentUser[$resource[$Element]] = time() + $ExtraDM[$Element]['time'] * 3600;
			$CurrentUser['darkmatter']         -= $ExtraDM[$Element]['darkmatter'];
			$QryUpdateUser  = "UPDATE ".USERS." SET ";
			$QryUpdateUser .= "`".$resource[$Element]."` = '". $CurrentUser[$resource[$Element]] ."' ";
			$QryUpdateUser .= "WHERE ";
			$QryUpdateUser .= "`id` = '". $CurrentUser['id'] ."';";
			$db->query($QryUpdateUser);
		}
	}

	public function UpdateOfficier(&$CurrentUser, $Selected)
	{
		global $db, $reslist, $resource;
		
		if ((floor($CurrentUser['darkmatter'] / DM_PRO_OFFICIER_LEVEL)) > 0 && in_array($Selected, $reslist['officier']) && $this->IsOfficierAccessible($CurrentUser, $Selected) == 1)
		{
			$CurrentUser[$resource[$Selected]] += 1;
			$CurrentUser['darkmatter']         -= DM_PRO_OFFICIER_LEVEL;
			$QryUpdateUser  = "UPDATE ".USERS." SET ";
			$QryUpdateUser .= "`".$resource[$Selected]."` = '". $CurrentUser[$resource[$Selected]] ."' ";
			$QryUpdateUser .= "WHERE ";
			$QryUpdateUser .= "`id` = '". $CurrentUser['id'] ."';";
			$db->query($QryUpdateUser);
		}
	}
	
	public function ShowOfficierPage($CurrentUser, $CurrentPlanet)
	{
		global $resource, $reslist, $lang, $db, $ExtraDM;
		
		$action   = request_var('action', '');
		$Offi	  = request_var('offi', 0);
		$Extra	  = request_var('extra', 0);
		
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='DM-Bank';"));
				
		if ($action == "send")
		{
			if(!empty($Offi))
				$this->UpdateOfficier($CurrentUser, $Offi);
			elseif(!empty($Extra) && $query['estado'] == 1)
				$this->UpdateExtra($CurrentUser, $Extra);		
		}
		
		
		$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);

		$template	= new template();
		$template->loadscript('time.js');
		$template->set_vars($CurrentUser, $CurrentPlanet);
		$template->page_header();
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		

		if($query['estado'] == 1) 
		{
			foreach($reslist['dmfunc'] as $Element)
			{
				$ExtraDMList[]	= array(
					'id' 	 	=> $Element,
					'active'  	=> $CurrentUser[$resource[$Element]] - time(),
					'price'		=> pretty_number($ExtraDM[$Element]['darkmatter']),
					'isok'		=> (($CurrentUser['darkmatter'] - $ExtraDM[$Element]['darkmatter']) >= 0) ? true : false,
					'time'		=> pretty_time($ExtraDM[$Element]['time'] * 3600),
					'name'		=> $lang['tech'][$Element],
					'desc'  	=> sprintf($lang['res']['descriptions'][$Element], $ExtraDM[$Element]['add'] * 100),	
				);
			}
		}
		
		foreach($reslist['officier'] as $Element)
		{
			if (($Result = $this->IsOfficierAccessible ($CurrentUser, $Element)) !== 0)
			{
				$OfficierList[]	= array(
					'id' 	 	=> $Element,
					'level'  	=> $CurrentUser[$resource[$Element]],
					'name'		=> $lang['tech'][$Element],
					'desc'  	=> $lang['res']['descriptions'][$Element],	
					'Result'	=> $Result,
				);
			}
		}

		$template->assign_vars(array(	
			'ExtraDMList'			=> $ExtraDMList,
			'OfficierList'			=> $OfficierList,
			'user_darkmatter'		=> floor($CurrentUser['darkmatter'] / DM_PRO_OFFICIER_LEVEL),
			'of_max_lvl'			=> $lang['of_max_lvl'],
			'of_recruit'			=> $lang['of_recruit'],
			'of_darkmatter' 		=> sprintf($lang['of_points_per_thousand_darkmatter'], DM_PRO_OFFICIER_LEVEL, $lang['Darkmatter']),
			'of_available_points'	=> $lang['of_available_points'],
			'alv_points'			=> $lang['alv_points'],
			'of_lvl'				=> $lang['of_lvl'],
			'in_dest_durati'		=> $lang['in_dest_durati'],
			'of_still'				=> $lang['of_still'],
			'of_active'				=> $lang['of_active'],
			'of_update'				=> $lang['of_update'],
			'in_dest_durati'		=> $lang['in_dest_durati'],
			'of_dm_trade'			=> sprintf($lang['of_dm_trade'],$lang['Darkmatter']),
		));
		
		$template->show("officier_overview.tpl");
		$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
	}
}
?>