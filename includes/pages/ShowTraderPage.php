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

function ShowTraderPage($CurrentPlanet)
{
	global $phpEx, $lang, $db;

	$parse = $lang;
	$ress = request_var('ress','');
	if ( $ress != '')
	{
		switch ($ress) {
			case 'metal':
			{
				if ($_POST['cristal'] < 0 or $_POST['deut'] < 0)
				{
					message($lang['tr_only_positive_numbers'], "game." . $phpEx . "?page=trader",1);
				}
				else
				{
					$necessaire   = (($_POST['cristal'] * 2) + ($_POST['deut'] * 4));

					if ($CurrentPlanet['metal'] > $necessaire)
					{
						$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
						$QryUpdatePlanet .= "`metal` = `metal` - ".round($necessaire).", ";
						$QryUpdatePlanet .= "`crystal` = `crystal` + ".round($_POST['cristal']).", ";
						$QryUpdatePlanet .= "`deuterium` = `deuterium` + ".round($_POST['deut'])." ";
						$QryUpdatePlanet .= "WHERE ";
						$QryUpdatePlanet .= "`id` = '".$CurrentPlanet['id']."';";

						$db->query($QryUpdatePlanet , 'planets');

						$planetrow['metal']     -= $necessaire;
						$CurrentPlanet['cristal']   += $_POST['cristal'];
						$CurrentPlanet['deuterium'] += $_POST['deut'];

					}
					else
					{
						message($lang['tr_not_enought_metal'], "game." . $phpEx . "?page=trader",1);
					}
				}
				break;
			}
			case 'cristal':
			{
				if ($_POST['metal'] < 0 or $_POST['deut'] < 0)
				{
					message($lang['tr_only_positive_numbers'], "game." . $phpEx . "?page=trader",1);
				}
				else
				{
					$necessaire   = ((abs($_POST['metal']) * 0.5) + (abs($_POST['deut']) * 2));

					if ($CurrentPlanet['crystal'] > $necessaire)
					{
						$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
						$QryUpdatePlanet .= "`metal` = `metal` + ".round($_POST['metal']).", ";
						$QryUpdatePlanet .= "`crystal` = `crystal` - ".round($necessaire).", ";
						$QryUpdatePlanet .= "`deuterium` = `deuterium` + ".round($_POST['deut'])." ";
						$QryUpdatePlanet .= "WHERE ";
						$QryUpdatePlanet .= "`id` = '".$CurrentPlanet['id']."';";

						$db->query($QryUpdatePlanet);

						$CurrentPlanet['metal']     += $_POST['metal'];
						$CurrentPlanet['cristal']   -= $necessaire;
						$CurrentPlanet['deuterium'] += $_POST['deut'];
					}
					else
					{
						message($lang['tr_not_enought_crystal'], "game." . $phpEx . "?page=trader",1);
					}
				}
				break;
			}
			case 'deuterium':
			{
				if ($_POST['cristal'] < 0 or $_POST['metal'] < 0)
				{
					message($lang['tr_only_positive_numbers'], "game." . $phpEx . "?page=trader",1);
				}
				else
				{
					$necessaire   = ((abs($_POST['metal']) * 0.25) + (abs($_POST['cristal']) * 0.5));

					if ($CurrentPlanet['deuterium'] > $necessaire)
					{
						$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
						$QryUpdatePlanet .= "`metal` = `metal` + ".round($_POST['metal']).", ";
						$QryUpdatePlanet .= "`crystal` = `crystal` + ".round($_POST['cristal']).", ";
						$QryUpdatePlanet .= "`deuterium` = `deuterium` - ".round($necessaire)." ";
						$QryUpdatePlanet .= "WHERE ";
						$QryUpdatePlanet .= "`id` = '".$CurrentPlanet['id']."';";

						$db->query($QryUpdatePlanet);

						$CurrentPlanet['metal']     += $_POST['metal'];
						$CurrentPlanet['cristal']   += $_POST['cristal'];
						$CurrentPlanet['deuterium'] -= $necessaire;
					}
					else
					{
						message($lang['tr_not_enought_deuterium'], "game." . $phpEx . "?page=trader",1);
					}
				}
				break;
			}
		}

		message($lang['tr_exchange_done'],"game." . $phpEx . "?page=trader",1);
	}
	else
	{
		if ($_POST['action'] != 2)
		{
			$template = gettemplate('trader/trader_main');
		}
		else
		{
			$parse['mod_ma_res'] = '1';

			switch ($_POST['choix'])
			{
				case 'metal':
				$template = gettemplate('trader/trader_metal');
				$parse['mod_ma_res_a'] = '2';
				$parse['mod_ma_res_b'] = '4';
				break;
				case 'cristal':
				$template = gettemplate('trader/trader_cristal');
				$parse['mod_ma_res_a'] = '0.5';
				$parse['mod_ma_res_b'] = '2';
				break;
				case 'deut':
				$template = gettemplate('trader/trader_deuterium');
				$parse['mod_ma_res_a'] = '0.25';
				$parse['mod_ma_res_b'] = '0.5';
				break;
			}
		}
	}

	return display(parsetemplate($template,$parse));
}
?>