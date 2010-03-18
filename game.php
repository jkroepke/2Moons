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
define('ROOT_PATH', './');

include_once(ROOT_PATH . 'extension.inc');
include_once(ROOT_PATH . 'common.' . PHP_EXT);
include_once(ROOT_PATH . 'includes/functions/GetBuildingPrice.' . PHP_EXT);
include_once(ROOT_PATH . 'includes/functions/IsElementBuyable.' . PHP_EXT);

$page = request_var('page','');
switch($page)
{
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'changelog':
		include_once(ROOT_PATH . 'includes/pages/ShowChangelogPage.' . PHP_EXT);
		ShowChangelogPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'galaxy':

		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Galaxie';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once(ROOT_PATH . 'includes/pages/class.ShowGalaxyPage.' . PHP_EXT);
		$ShowGalaxyPage = new ShowGalaxyPage($user, $planetrow);
	break;
	case 'phalanx':
		include_once(ROOT_PATH . 'includes/pages/ShowPhalanxPage.' . PHP_EXT);
		ShowPhalanxPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'imperium':

		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Imperium';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once(ROOT_PATH . 'includes/pages/ShowImperiumPage.' . PHP_EXT);
		ShowImperiumPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'fleet':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.' . PHP_EXT);
		ShowFleetPages::ShowFleetPage($user, $planetrow);
	break;
	case 'fleet1':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.' . PHP_EXT);
		ShowFleetPages::ShowFleet1Page($user, $planetrow);
	break;
	case 'fleet2':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.' . PHP_EXT);
		ShowFleetPages::ShowFleet2Page($user, $planetrow);
	break;
	case 'fleet3':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.' . PHP_EXT);
		ShowFleetPages::ShowFleet3Page($user, $planetrow);
	break;
	case 'fleetajax':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.' . PHP_EXT);
		ShowFleetPages::FleetAjax($user, $planetrow);
	break;
	case 'missiles':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.' . PHP_EXT);
		ShowFleetPages::MissilesAjax($user, $planetrow);
	break;
	case 'fleetACS':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		
		include_once(ROOT_PATH . 'includes/pages/ShowFleetACSPage.' . PHP_EXT);
		ShowFleetACSPage($user, $planetrow);
	break;
	case 'shortcuts':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Flotte';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		
		include_once(ROOT_PATH . 'includes/pages/ShowFleetShortcuts.' . PHP_EXT);
		ShowFleetShortcuts($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'buildings':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Bauen';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
		$mode = request_var('mode', '');
		switch ($mode)
		{
			case 'research':
				include_once(ROOT_PATH . 'includes/pages/class.ShowResearchPage.' . PHP_EXT);
				new ShowResearchPage($planetrow, $user);
			break;
			case 'fleet':
				include_once(ROOT_PATH . 'includes/pages/class.ShowShipyardPage.' . PHP_EXT);
				$FleetBuildingPage = new ShowShipyardPage();
				$FleetBuildingPage->FleetBuildingPage ($planetrow, $user);
			break;
			case 'defense':
				include_once(ROOT_PATH . 'includes/pages/class.ShowShipyardPage.' . PHP_EXT);
				$DefensesBuildingPage = new ShowShipyardPage();
				$DefensesBuildingPage->DefensesBuildingPage ($planetrow, $user);
			break;
			default:
				include_once(ROOT_PATH . 'includes/pages/class.ShowBuildingsPage.' . PHP_EXT);
				new ShowBuildingsPage($planetrow, $user);
			break;
		}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'resources':
		include_once(ROOT_PATH . 'includes/pages/ShowResourcesPage.' . PHP_EXT);
		ShowResourcesPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'officier':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Offiziere';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once(ROOT_PATH . 'includes/pages/class.ShowOfficierPage.' . PHP_EXT);
		new ShowOfficierPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'trader':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Trader';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once(ROOT_PATH . 'includes/pages/ShowTraderPage.' . PHP_EXT);
		ShowTraderPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'techtree':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Techtree';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once(ROOT_PATH . 'includes/pages/ShowTechTreePage.' . PHP_EXT);
		ShowTechTreePage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'infos':
		include_once(ROOT_PATH . 'includes/pages/class.ShowInfosPage.' . PHP_EXT);
		new ShowInfosPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'messages':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Nachrichten';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once(ROOT_PATH . 'includes/pages/ShowMessagesPage.' . PHP_EXT);
		ShowMessagesPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'alliance':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Allianz';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once(ROOT_PATH . 'includes/pages/class.ShowAlliancePage.' . PHP_EXT);
		new ShowAlliancePage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'buddy':
		include_once(ROOT_PATH . 'includes/pages/ShowBuddyPage.' . PHP_EXT);
		ShowBuddyPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'notes':
		include_once(ROOT_PATH . 'includes/pages/class.ShowNotesPage.' . PHP_EXT);
		new ShowNotesPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'statistics':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Statistiken';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once(ROOT_PATH . 'includes/pages/ShowStatisticsPage.' . PHP_EXT);
		ShowStatisticsPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'search':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Suche';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }

		include_once(ROOT_PATH . 'includes/pages/ShowSearchPage.' . PHP_EXT);
		ShowSearchPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'options':
		include_once(ROOT_PATH . 'includes/pages/class.ShowOptionsPage.' . PHP_EXT);
		new ShowOptionsPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'banned':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Pranger';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }

		include_once(ROOT_PATH . 'includes/pages/ShowBannedPage.' . PHP_EXT);
		ShowBannedPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'topkb':
		include_once(ROOT_PATH . 'includes/pages/ShowTopKB.' . PHP_EXT);
		ShowTopKB($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'records':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Rekorde';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }


		include_once(ROOT_PATH . 'includes/pages/ShowRecordsPage.' . PHP_EXT);
		ShowRecordsPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'chat':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Chat';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }

		include_once(ROOT_PATH . 'includes/pages/class.ShowChatPage.' . PHP_EXT);
		new ShowChatPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
    case 'support':
		$query = $db->fetch_array($db->query("SELECT estado FROM ".MODULE." WHERE modulo='Support';"));
		if($query['estado'] == 0 && $user['authlevel'] == 0) { message("Modul inaktiv.","game.php?page=overview"); }

		include_once($xnova_root . 'includes/pages/ShowSupportPage.' . PHP_EXT);
        new ShowSupportPage($user, $planetrow);
    break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//	
    case 'playercard':
        include_once(ROOT_PATH . 'includes/pages/ShowPlayerCard.' . PHP_EXT);
        ShowPlayerCard($user, $planetrow);
    break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//	
    case 'faq':
        include_once(ROOT_PATH . 'includes/pages/ShowFAQ.' . PHP_EXT);
        ShowFAQ($user, $planetrow);
    break; 
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'logout':
		$db->query("UPDATE ".USERS." SET `current_planet` = `id_planet` WHERE `id` = '". $user['id'] ."' LIMIT 1");
		setcookie($game_config['COOKIE_NAME'], "", time() - 100000);
		$template	= new template();
		$template->page_header();
		$template->page_footer();	
		$template->show("logout_overview.tpl");
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'overview':
	default:
		if (isset($run_plug)) exit;
		
		include_once(ROOT_PATH . 'includes/pages/ShowOverviewPage.' . PHP_EXT);
		ShowOverviewPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
}
?>