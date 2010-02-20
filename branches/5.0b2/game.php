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

define('INSIDE'  , true);
define('INSTALL' , false);

$xgp_root = './';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

include($xgp_root . 'includes/functions/CheckPlanetBuildingQueue.' . $phpEx);
include($xgp_root . 'includes/functions/GetBuildingPrice.' . $phpEx);
include($xgp_root . 'includes/functions/IsElementBuyable.' . $phpEx);
include($xgp_root . 'includes/functions/SetNextQueueElementOnTop.' . $phpEx);
include($xgp_root . 'includes/functions/SortUserPlanets.' . $phpEx);
include($xgp_root . 'includes/functions/UpdatePlanetBatimentQueueList.' . $phpEx);

$page = request_var('page','');
switch($page)
{
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'changelog':
		include_once($xgp_root . 'includes/pages/ShowChangelogPage.' . $phpEx);
		ShowChangelogPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'overview':
		include_once($xgp_root . 'includes/pages/ShowOverviewPage.' . $phpEx);
		ShowOverviewPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'galaxy':

		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Galaxie';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/class.ShowGalaxyPage.' . $phpEx);
		$ShowGalaxyPage = new ShowGalaxyPage($user, $planetrow);
	break;
	case 'phalanx':
		include_once($xgp_root . 'includes/pages/ShowPhalanxPage.' . $phpEx);
		ShowPhalanxPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'imperium':

		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Imperium';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/ShowImperiumPage.' . $phpEx);
		ShowImperiumPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'fleet':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/class.ShowFleetPages.' . $phpEx);
		ShowFleetPages::ShowFleetPage($user, $planetrow);
	break;
	case 'fleet1':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		
		include_once($xgp_root . 'includes/pages/class.ShowFleetPages.' . $phpEx);
		ShowFleetPages::ShowFleet1Page($user, $planetrow);
	break;
	case 'fleet2':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		
		include_once($xgp_root . 'includes/pages/class.ShowFleetPages.' . $phpEx);
		ShowFleetPages::ShowFleet2Page($user, $planetrow);
	break;
	case 'fleet3':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		
		include_once($xgp_root . 'includes/pages/class.ShowFleetPages.' . $phpEx);
		ShowFleetPages::ShowFleet3Page($user, $planetrow);
	break;
	case 'fleetajax':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		
		include_once($xgp_root . 'includes/pages/class.ShowFleetPages.' . $phpEx);
		ShowFleetPages::FleetAjax($user, $planetrow);
	break;
	case 'missiles':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		
		include_once($xgp_root . 'includes/pages/class.ShowFleetPages.' . $phpEx);
		ShowFleetPages::MissilesAjax($user, $planetrow);
	break;
	case 'fleetACS':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		
		include_once($xgp_root . 'includes/pages/ShowFleetACSPage.' . $phpEx);
		ShowFleetACSPage($user, $planetrow);
	break;
	case 'shortcuts':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		
		include_once($xgp_root . 'includes/pages/ShowFleetShortcuts.' . $phpEx);
		ShowFleetShortcuts($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'buildings':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Bauen';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/functions/HandleTechnologieBuild.' . $phpEx);
		UpdatePlanetBatimentQueueList ($planetrow, $user, $planetrow);
		$IsWorking = HandleTechnologieBuild($planetrow, $user, $planetrow);
		switch ($_GET['mode'])
		{
			case 'research':
				include_once($xgp_root . 'includes/pages/class.ShowResearchPage.' . $phpEx);
				new ShowResearchPage($planetrow, $user, $IsWorking['OnWork'], $IsWorking['WorkOn']);
			break;
			case 'fleet':
				include_once($xgp_root . 'includes/pages/class.ShowShipyardPage.' . $phpEx);
				$FleetBuildingPage = new ShowShipyardPage();
				$FleetBuildingPage->FleetBuildingPage ($planetrow, $user, $planetrow);
			break;
			case 'defense':
				include_once($xgp_root . 'includes/pages/class.ShowShipyardPage.' . $phpEx);
				$DefensesBuildingPage = new ShowShipyardPage();
				$DefensesBuildingPage->DefensesBuildingPage ($planetrow, $user, $planetrow);
			break;
			default:
				include_once($xgp_root . 'includes/pages/class.ShowBuildingsPage.' . $phpEx);
				new ShowBuildingsPage($planetrow, $user, $planetrow);
			break;
		}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'resources':
		include_once($xgp_root . 'includes/pages/ShowResourcesPage.' . $phpEx);
		ShowResourcesPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'officier':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Offiziere';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/class.ShowOfficierPage.' . $phpEx);
		new ShowOfficierPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'trader':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Trader';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/ShowTraderPage.' . $phpEx);
		ShowTraderPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'techtree':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Techtree';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/ShowTechTreePage.' . $phpEx);
		ShowTechTreePage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'infos':
		include_once($xgp_root . 'includes/pages/class.ShowInfosPage.' . $phpEx);
		new ShowInfosPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'messages':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Nachrichten';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/ShowMessagesPage.' . $phpEx);
		ShowMessagesPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'alliance':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Allianz';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/class.ShowAlliancePage.' . $phpEx);
		new ShowAlliancePage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'buddy':
		include_once($xgp_root . 'includes/pages/ShowBuddyPage.' . $phpEx);
		ShowBuddyPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'notes':
		include_once($xgp_root . 'includes/pages/class.ShowNotesPage.' . $phpEx);
		new ShowNotesPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'statistics':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Statistiken';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/ShowStatisticsPage.' . $phpEx);
		ShowStatisticsPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'search':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Suche';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }

		include_once($xgp_root . 'includes/pages/ShowSearchPage.' . $phpEx);
		ShowSearchPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'options':
		include_once($xgp_root . 'includes/pages/class.ShowOptionsPage.' . $phpEx);
		new ShowOptionsPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'banned':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Pranger';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }

		include_once($xgp_root . 'includes/pages/ShowBannedPage.' . $phpEx);
		ShowBannedPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'topkb':
		include_once($xgp_root . 'includes/pages/ShowTopKB.' . $phpEx);
		ShowTopKB($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'records':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Rekorde';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }


		include_once($xgp_root . 'includes/pages/ShowRecordsPage.' . $phpEx);
		ShowRecordsPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'chat':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Chat';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }

		include_once($xgp_root . 'includes/pages/class.ShowChatPage.' . $phpEx);
		new ShowChatPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
    case 'support':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Support';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }

		include_once($xnova_root . 'includes/pages/ShowSupportPage.' . $phpEx);
        new ShowSupportPage($user, $planetrow);
    break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//	
    case 'playercard':
        include_once($xgp_root . 'includes/pages/ShowPlayerCard.' . $phpEx);
        ShowPlayerCard($user, $planetrow);
    break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//	
    case 'faq':
        include_once($xgp_root . 'includes/pages/ShowFAQ.' . $phpEx);
        ShowFAQ($user, $planetrow);
    break; 
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'logout':
		$db->query("UPDATE ".USERS." SET `current_planet` = `id_planet` WHERE `id` = '". $user['id'] ."' LIMIT 1");
		setcookie($game_config['COOKIE_NAME'], "", time() - 100000);
		$template	= new template();
		$template->page_header();
		$template->page_footer();	
		$template->display("logout_overview.tpl");
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	default:
		die(message($lang['page_doesnt_exist']));
// ----------------------------------------------------------------------------------------------------------------------------------------------//
}
?>