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
		if(CheckModule(11))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowGalaxyPage.' . PHP_EXT);
		$ShowGalaxyPage = new ShowGalaxyPage($user, $planetrow);
	break;
	case 'phalanx':
		if(CheckModule(9))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowPhalanxPage.' . PHP_EXT);
		ShowPhalanxPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'imperium':
		if(CheckModule(15))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowImperiumPage.' . PHP_EXT);
		ShowImperiumPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'fleet':
		if(CheckModule(9))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.' . PHP_EXT);
		ShowFleetPages::ShowFleetPage($user, $planetrow);
	break;
	case 'fleet1':
		if(CheckModule(9))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.' . PHP_EXT);
		ShowFleetPages::ShowFleet1Page($user, $planetrow);
	break;
	case 'fleet2':
		if(CheckModule(9))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.' . PHP_EXT);
		ShowFleetPages::ShowFleet2Page($user, $planetrow);
	break;
	case 'fleet3':
		if(CheckModule(9))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.' . PHP_EXT);
		ShowFleetPages::ShowFleet3Page($user, $planetrow);
	break;
	case 'fleetajax':
		if(CheckModule(9) || CheckModule(24))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.' . PHP_EXT);
		ShowFleetPages::FleetAjax($user, $planetrow);
	break;
	case 'missiles':
		if(CheckModule(9) || CheckModule(1))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.' . PHP_EXT);
		ShowFleetPages::MissilesAjax($user, $planetrow);
	break;
	case 'shortcuts':
		include_once(ROOT_PATH . 'includes/pages/ShowFleetShortcuts.' . PHP_EXT);
		ShowFleetShortcuts($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'buildings':$mode = request_var('mode', '');
		switch ($mode)
		{
			case 'research':
				if(CheckModule(3))
					message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
				
				include_once(ROOT_PATH . 'includes/pages/class.ShowResearchPage.' . PHP_EXT);
				new ShowResearchPage($planetrow, $user);
			break;
			case 'fleet':
				if(CheckModule(4))
					message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
				
				include_once(ROOT_PATH . 'includes/pages/class.ShowShipyardPage.' . PHP_EXT);
				$FleetBuildingPage = new ShowShipyardPage();
				$FleetBuildingPage->FleetBuildingPage ($planetrow, $user);
			break;
			case 'defense':
				if(CheckModule(5))
					message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
				
				include_once(ROOT_PATH . 'includes/pages/class.ShowShipyardPage.' . PHP_EXT);
				$DefensesBuildingPage = new ShowShipyardPage();
				$DefensesBuildingPage->DefensesBuildingPage ($planetrow, $user);
			break;
			default:
				if(CheckModule(2))
					message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
				
				include_once(ROOT_PATH . 'includes/pages/class.ShowBuildingsPage.' . PHP_EXT);
				new ShowBuildingsPage($planetrow, $user);
			break;
		}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'resources':
		if(CheckModule(23))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowResourcesPage.' . PHP_EXT);
		ShowResourcesPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'officier':
		if(CheckModule(18) && CheckModule(8))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowOfficierPage.' . PHP_EXT);
		new ShowOfficierPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'trader':
		if(CheckModule(13))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowTraderPage.' . PHP_EXT);
		ShowTraderPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'techtree':
		if(CheckModule(28))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowTechTreePage.' . PHP_EXT);
		ShowTechTreePage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'infos':
		if(CheckModule(14))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowInfosPage.' . PHP_EXT);
		new ShowInfosPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'messages':
		if(CheckModule(16))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowMessagesPage.' . PHP_EXT);
		ShowMessagesPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'alliance':
		if(CheckModule(0))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
 
		include_once(ROOT_PATH . 'includes/pages/class.ShowAlliancePage.' . PHP_EXT);
		new ShowAlliancePage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'buddy':
		if(CheckModule(6))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
		
		include_once(ROOT_PATH . 'includes/pages/ShowBuddyPage.' . PHP_EXT);
		ShowBuddyPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'notes':
		if(CheckModule(17))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowNotesPage.' . PHP_EXT);
		new ShowNotesPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'statistics':
		if(CheckModule(25))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowStatisticsPage.' . PHP_EXT);
		ShowStatisticsPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'search':
		if(CheckModule(26))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
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
		if(CheckModule(21))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowBannedPage.' . PHP_EXT);
		ShowBannedPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'topkb':
		if(CheckModule(6))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowTopKB.' . PHP_EXT);
		ShowTopKB($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'records':
		if(CheckModule(22))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowRecordsPage.' . PHP_EXT);
		ShowRecordsPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'chat':
		if(CheckModule(7))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowChatPage.' . PHP_EXT);
		new ShowChatPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
    case 'support':
		if(CheckModule(27))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once($xnova_root . 'includes/pages/ShowSupportPage.' . PHP_EXT);
        new ShowSupportPage($user, $planetrow);
    break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//	
    case 'playercard':
		if(CheckModule(21))
			message($lang['sys_module_inactive'],"?page=overview", 3, true, true);
					
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
		setcookie($game_config['COOKIE_NAME'], '', 1, "/", "", 0);
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