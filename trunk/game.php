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
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

define('INSIDE'  , true);
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');

require(ROOT_PATH.'includes/classes/class.BuildFunctions.php');
require(ROOT_PATH.'includes/common.php');
	
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
		if(!isModulAvalible(MODUL_GALAXY))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowGalaxyPage.php');
		$ShowGalaxyPage = new ShowGalaxyPage();
	break;
	case 'phalanx':
		if(!isModulAvalible(MODUL_PHALANX))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowPhalanxPage.php');
		ShowPhalanxPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'imperium':
		if(!isModulAvalible(MODUL_IMPERIUM))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowImperiumPage.php');
		ShowImperiumPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'fleet':
		if(!isModulAvalible(MODUL_FLEET_TABLE))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetTablePage.php');
		$pageObj	= new ShowFleetTablePage;
		$pageObj->show();
	break;
	case 'fleet1':
		if(!isModulAvalible(MODUL_FLEET_TABLE))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetStep1Page.php');
		$pageObj	= new ShowFleetStep1Page;
		$pageObj->show();
	break;
	case 'fleet2':
		if(!isModulAvalible(MODUL_FLEET_TABLE))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetStep2Page.php');
		$pageObj	= new ShowFleetStep2Page;
		$pageObj->show();
	break;
	case 'fleet3':
		if(!isModulAvalible(MODUL_FLEET_TABLE))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetStep3Page.php');
		$pageObj	= new ShowFleetStep3Page;
		$pageObj->show();
	break;
	case 'fleetajax':
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetAjaxPage.php');
		$pageObj	= new ShowFleetAjaxPage;
		$pageObj->show();
	break;
	case 'missiles':
		if(!isModulAvalible(MODUL_FLEET_TABLE) || !isModulAvalible(MODUL_MISSION_ATTACK))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowFleetPages.php');
		ShowFleetPages::MissilesAjax();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'buildings':
		$mode = request_var('mode', '');
		switch ($mode)
		{
			case 'research':
				if(!isModulAvalible(MODUL_RESEARCH))
					message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
				
				include_once(ROOT_PATH . 'includes/pages/class.ShowResearchPage.php');
				$pageObj	= new ShowResearchPage;
				$pageObj->show();
			break;
			case 'fleet':
				if(!isModulAvalible(MODUL_SHIPYARD_FLEET))
					message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
				
				include_once(ROOT_PATH . 'includes/pages/class.ShowShipyardPage.php');
				$pageObj	= new ShowShipyardPage;
				$pageObj->FleetBuildingPage();
			break;
			case 'defense':
				if(!isModulAvalible(MODUL_SHIPYARD_DEFENSIVE))
					message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
				
				include_once(ROOT_PATH . 'includes/pages/class.ShowShipyardPage.php');
				$pageObj	= new ShowShipyardPage;
				$pageObj->DefensesBuildingPage();
			break;
			default:
				if(!isModulAvalible(MODUL_BUILDING))
					message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
				
				include_once(ROOT_PATH . 'includes/pages/class.ShowBuildingsPage.php');
				$pageObj	= new ShowBuildingsPage;
				$pageObj->show();
			break;
		}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'resources':
		if(!isModulAvalible(MODUL_RESSOURCE_LIST))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowResourcesPage.php');
		ShowResourcesPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'officier':
		if(!isModulAvalible(MODUL_OFFICIER) && !isModulAvalible(MODUL_DMEXTRAS))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowOfficierPage.php');
		$pageObj	= new ShowOfficierPage;
		$pageObj->show();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'trader':
		if(!isModulAvalible(MODUL_TRADER))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowTraderPage.php');
		ShowTraderPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'techtree':
		if(!isModulAvalible(MODUL_TECHTREE))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowTechTreePage.php');
		ShowTechTreePage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'infos':
		if(!isModulAvalible(MODUL_INFORMATION))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowInfosPage.php');
		new ShowInfosPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'messages':
		if(!isModulAvalible(MODUL_MESSAGES))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowMessagesPage.php');
		new ShowMessagesPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'alliance':
		if(!isModulAvalible(MODUL_ALLIANCE))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
				
		include_once(ROOT_PATH . 'includes/pages/class.ShowAlliancePage.php');
		$pageObj	= new ShowAlliancePage;
		$pageObj->show();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'buddy':
		if(!isModulAvalible(MODUL_BUDDYLIST))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
		
		include_once(ROOT_PATH . 'includes/pages/ShowBuddyPage.php');
		ShowBuddyPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'notes':
		if(!isModulAvalible(MODUL_NOTICE))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowNotesPage.php');
		new ShowNotesPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'fleettrader':
		if(!isModulAvalible(MODUL_FLEET_TRADER))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowFleetTraderPage.php');
		ShowFleetTraderPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'statistics':
		if(!isModulAvalible(MODUL_STATISTICS))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowStatisticsPage.php');
		ShowStatisticsPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'search':
		if(!isModulAvalible(MODUL_SEARCH))
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
		if(!isModulAvalible(MODUL_BANLIST))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowBannedPage.php');
		ShowBannedPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'topkb':
		if(!isModulAvalible(MODUL_BATTLEHALL))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowTopKB.php');
		ShowTopKB();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'records':
		if(!isModulAvalible(MODUL_RECORDS))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowRecordsPage.php');
		ShowRecordsPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'chat':
		if(!isModulAvalible(MODUL_CHAT))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowChatPage.php');
		ShowChatPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
    case 'support':
		if(!isModulAvalible(MODUL_SUPPORT))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/ShowSupportPage.php');
        new ShowSupportPage();
    break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//	
    case 'playercard':
		if(!isModulAvalible(MODUL_PLAYERCARD))
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
		if(!isModulAvalible(MODUL_SIMULATOR))
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