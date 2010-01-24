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

	public function ShowOfficierPage ( &$CurrentUser )
	{
		global $resource, $reslist, $lang, $db;
		$parse 	= $lang;
		$bloc	= $lang;
		$parse['of_points_per_thousand_darkmatter'] = sprintf($lang['of_points_per_thousand_darkmatter'], $lang['Darkmatter']);
		if ($_GET['mode'] == 2)
		{
			if ((floor($CurrentUser['darkmatter'] / 500)) > 0)
			{
				$Selected    = request_var('offi',0);
				if ( in_array($Selected, $reslist['officier']) )
				{
					$Result = $this->IsOfficierAccessible ( $CurrentUser, $Selected );

					if ( $Result == 1 )
					{
						$CurrentUser[$resource[$Selected]] += 1;
						$CurrentUser['darkmatter']         -= 500;

						$QryUpdateUser  = "UPDATE ".USERS." SET ";
						$QryUpdateUser .= "`darkmatter` = '". $CurrentUser['darkmatter'] ."', ";
						$QryUpdateUser .= "`".$resource[$Selected]."` = '". $CurrentUser[$resource[$Selected]] ."' ";
						$QryUpdateUser .= "WHERE ";
						$QryUpdateUser .= "`id` = '". $CurrentUser['id'] ."';";
						$db->query($QryUpdateUser);
					}
					else
					{
						header("location:game.php?page=officier");
					}
				}
			}
			else
			{
				header("location:game.php?page=officier");
			}

			header("location:game.php?page=officier");

		}
		else
		{
			$parse['alv_points']   	= floor($CurrentUser['darkmatter'] / 500);
			foreach($lang['tech'] as $Element => $ElementName)
			{
				$Result = $this->IsOfficierAccessible ($CurrentUser, $Element);
				if ($Result != 0 && $Element >= 601)
				{
					$bloc['off_id']       = $Element;
					$bloc['off_lvl']      = ($CurrentUser[$resource[$Element]]==0) ? 0 : $CurrentUser[$resource[$Element]];
					$bloc['off_name']	  = $ElementName;
					$bloc['off_desc']     = $lang['res']['descriptions'][$Element];

					if ($Result == 1 && $parse['alv_points'] >= 1)
					{
						$bloc['off_link'] = "<a href=\"game.php?page=officier&mode=2&offi=".$Element."\"><font color=\"#00ff00\">".$lang['of_recruit']."</font>";
					}
					elseif($Result == 1 && $parse['alv_points'] == 0)
					{
						$bloc['off_link'] = "<font color=\"red\">".$lang['of_recruit']."</font>";
					}
					else
					{
						$bloc['off_link'] = "<font color=\"red\">".$lang['of_max_lvl']."</font>";
					}

					$parse['disp_off_tbl'] .= parsetemplate( gettemplate('officier/officier_row'), $bloc );
				}
			}
			$page = parsetemplate( gettemplate('officier/officier_table'), $parse);
		}

		display($page);
	}
}
?>