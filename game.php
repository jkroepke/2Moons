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
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

define('INSIDE'  , true);
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');

require_once(ROOT_PATH.'includes/functions/GetBuildingPrice.php');
require_once(ROOT_PATH.'includes/functions/GetBuildingTime.php');
require_once(ROOT_PATH.'includes/functions/IsElementBuyable.php');
require_once(ROOT_PATH.'includes/functions/SortUserPlanets.php');
require_once(ROOT_PATH.'common.php');
	
$page = request_var('page','');
switch($page)
{
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'changelog':
		include_once(ROOT_PATH . 'includes/pages/ShowChangelogPage.php');
		ShowChangelogPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'galaxy':
		if(CheckModule(11))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowGalaxyPage.php');
		$ShowGalaxyPage = new ShowGalaxyPage();
	break;
	case 'phalanx':
		if(CheckModule(19))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowPhalanxPage.php');
		ShowPhalanxPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'imperium':
		if(CheckModule(15))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowImperiumPage.php');
		ShowImperiumPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'fleet':
		if(CheckModule(9))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.php');
		ShowFleetPages::ShowFleetPage();
	break;
	case 'fleet1':
		if(CheckModule(9))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.php');
		ShowFleetPages::ShowFleet1Page();
	break;
	case 'fleet2':
		if(CheckModule(9))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.php');
		ShowFleetPages::ShowFleet2Page();
	break;
	case 'fleet3':
		if(CheckModule(9))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.php');
		ShowFleetPages::ShowFleet3Page();
	break;
	case 'fleetajax':
		if(CheckModule(9) || CheckModule(24))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.php');
		ShowFleetPages::FleetAjax();
	break;
	case 'missiles':
		if(CheckModule(9) || CheckModule(1))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.php');
		ShowFleetPages::MissilesAjax();
	break;
	case 'shortcuts':
		if(CheckModule(40))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowFleetShortcuts.php');
		ShowFleetShortcuts();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'buildings':
		$mode = request_var('mode', '');
		switch ($mode)
		{
			case 'research':
				if(CheckModule(3))
					message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
				
				include_once(ROOT_PATH . 'includes/pages/class.ShowResearchPage.php');
				new ShowResearchPage();
			break;
			case 'fleet':
				if(CheckModule(4))
					message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
				
				include_once(ROOT_PATH . 'includes/pages/class.ShowShipyardPage.php');
				$FleetBuildingPage = new ShowShipyardPage();
				$FleetBuildingPage->FleetBuildingPage ();
			break;
			case 'defense':
				if(CheckModule(5))
					message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
				
				include_once(ROOT_PATH . 'includes/pages/class.ShowShipyardPage.php');
				$DefensesBuildingPage = new ShowShipyardPage();
				$DefensesBuildingPage->DefensesBuildingPage ();
			break;
			default:
				if(CheckModule(2))
					message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
				
				include_once(ROOT_PATH . 'includes/pages/class.ShowBuildingsPage.php');
				new ShowBuildingsPage();
			break;
		}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'resources':
		if(CheckModule(23))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowResourcesPage.php');
		ShowResourcesPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'officier':
		if(CheckModule(18) && CheckModule(8))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowOfficierPage.php');
		new ShowOfficierPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'trader':
		if(CheckModule(13))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowTraderPage.php');
		ShowTraderPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'techtree':
		if(CheckModule(28))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowTechTreePage.php');
		ShowTechTreePage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'infos':
		if(CheckModule(14))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowInfosPage.php');
		new ShowInfosPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'messages':
		if(CheckModule(16))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowMessagesPage.php');
		ShowMessagesPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'alliance':
		if(CheckModule(0))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
 
		include_once(ROOT_PATH . 'includes/pages/class.ShowAlliancePage.php');
		new ShowAlliancePage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'buddy':
		if(CheckModule(6))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
		
		include_once(ROOT_PATH . 'includes/pages/ShowBuddyPage.php');
		ShowBuddyPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'notes':
		if(CheckModule(17))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowNotesPage.php');
		new ShowNotesPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'fleettrader':
		if(CheckModule(38))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowFleetTraderPage.php');
		ShowFleetTraderPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'statistics':
		if(CheckModule(25))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowStatisticsPage.php');
		ShowStatisticsPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'search':
		if(CheckModule(26))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowSearchPage.php');
		ShowSearchPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'options':
		include_once(ROOT_PATH . 'includes/pages/class.ShowOptionsPage.php');
		new ShowOptionsPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'banned':
		if(CheckModule(21))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowBannedPage.php');
		ShowBannedPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'topkb':
		if(CheckModule(12))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowTopKB.php');
		ShowTopKB();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'records':
		if(CheckModule(22))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowRecordsPage.php');
		ShowRecordsPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'chat':
		if(CheckModule(7))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowChatPage.php');
		ShowChatPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
    case 'support':
		if(CheckModule(27))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowSupportPage.php');
        new ShowSupportPage();
    break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//	
    case 'playercard':
		if(CheckModule(20))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
					
        include_once(ROOT_PATH . 'includes/pages/ShowPlayerCard.php');
        ShowPlayerCard();
    break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//	
    case 'faq':
        include_once(ROOT_PATH . 'includes/pages/ShowFAQ.php');
        ShowFAQPage();
    break; 
// ----------------------------------------------------------------------------------------------------------------------------------------------//	
    case 'battlesim':
		if(CheckModule(39))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
        include_once(ROOT_PATH . 'includes/pages/ShowBattleSimPage.php');
        ShowBattleSimPage();
    break; 
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'logout':
	    include_once(ROOT_PATH . 'includes/pages/ShowLogoutPage.php');
		ShowLogoutPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'overview':
	default:
		include_once(ROOT_PATH . 'includes/pages/ShowOverviewPage.php');
		ShowOverviewPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//

}
?>