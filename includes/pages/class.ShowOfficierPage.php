<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
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

	public function UpdateOfficier($CurrentUser)
	{
		global $db, $reslist, $resource, $phpEx;
		$Selected    = request_var('offi', 0);
		if ((floor($CurrentUser['darkmatter'] / DM_PRO_OFFICIER_LEVEL)) > 0 && in_array($Selected, $reslist['officier']) && $this->IsOfficierAccessible($CurrentUser, $Selected) == 1)
		{
			$CurrentUser[$resource[$Selected]] += 1;
			$CurrentUser['darkmatter']         -= DM_PRO_OFFICIER_LEVEL;
			$QryUpdateUser  = "UPDATE ".USERS." SET ";
			$QryUpdateUser .= "`darkmatter` = '". $CurrentUser['darkmatter'] ."', ";
			$QryUpdateUser .= "`".$resource[$Selected]."` = '". $CurrentUser[$resource[$Selected]] ."' ";
			$QryUpdateUser .= "WHERE ";
			$QryUpdateUser .= "`id` = '". $CurrentUser['id'] ."';";
			$db->query($QryUpdateUser);
		}
		
		header("Location:game.".$phpEx."?page=officier");
	}
	
	public function ShowOfficierPage($CurrentUser, $CurrentPlanet)
	{
		global $resource, $reslist, $lang, $db;
		
		$action    = request_var('action', '');
		
		if ($action == "send")
			$this->UpdateOfficier($CurrentUser);
		
		$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);

		$template	= new template();
		$template->set_vars($CurrentUser, $CurrentPlanet);
		$template->page_header();
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		

		foreach($reslist['officier'] as $Key => $Element)
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
			'OfficierList'			=> $OfficierList,
			'user_darkmatter'		=> floor($CurrentUser['darkmatter'] / DM_PRO_OFFICIER_LEVEL),
			'of_max_lvl'			=> $lang['of_max_lvl'],
			'of_recruit'			=> $lang['of_recruit'],
			'of_darkmatter' 		=> sprintf($lang['of_points_per_thousand_darkmatter'], DM_PRO_OFFICIER_LEVEL, $lang['Darkmatter']),
			'of_available_points'	=> $lang['of_available_points'],
			'alv_points'			=> $lang['alv_points'],
			'of_lvl'				=> $lang['of_lvl'],
		));
		
		$template->show("officier_overview.tpl");
		$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
	}
}
?>