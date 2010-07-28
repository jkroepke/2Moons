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
define('IN_ADMIN', true);

define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');

require_once(ROOT_PATH . 'extension.inc');
require_once(ROOT_PATH . 'common.' . PHP_EXT);

if ($USER['authlevel'] < AUTH_MOD) exit;

require_once(ROOT_PATH . 'includes/adm_auth.' . PHP_EXT);

$page = request_var('page', '');
switch($page)
{
	case 'infos':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowInformationPage.' . PHP_EXT);
		ShowInformationPage();
	break;
	case 'rights':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowRightsPage.' . PHP_EXT);
		ShowRightsPage();
	break;
	case 'config':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowConfigPage.' . PHP_EXT);
		ShowConfigPage();
	break;
	case 'teamspeak':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowTeamspeakPage.' . PHP_EXT);
		ShowTeamspeakPage();
	break;
	case 'facebook':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowFacebookPage.' . PHP_EXT);
		ShowFacebookPage();
	break;
	case 'module':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowModulePage.' . PHP_EXT);
		ShowModulePage();
	break;
	case 'statsconf':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowStatsPage.' . PHP_EXT);
		ShowStatsPage();
	break;
	case 'update':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowUpdatePage.' . PHP_EXT);
		ShowUpdatePage();
	break;
	case 'create':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowCreatorPage.' . PHP_EXT);
		ShowCreatorPage();
	break;
	case 'accounteditor':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowAccountEditorPage.' . PHP_EXT);
		ShowAccountEditorPage();
	break;
	case 'active':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowActivePage.' . PHP_EXT);
		ShowActivePage();
	break;
	case 'bans':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowBanPage.' . PHP_EXT);
		ShowBanPage();
	break;
	case 'messagelist':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowMessageListPage.' . PHP_EXT);
		ShowMessageListPage();
	break;
	case 'globalmessage':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowSendMessagesPage.' . PHP_EXT);
		ShowSendMessagesPage();
	break;
	case 'fleets':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowFlyingFleetPage.' . PHP_EXT);
		ShowFlyingFleetPage();
	break;
	case 'accountdata':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowAccountDataPage.' . PHP_EXT);
		ShowAccountDataPage();
	break;
	case 'support':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowSupportPage.' . PHP_EXT);
		ShowSupportPage();
	break;
	case 'password':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowPassEncripterPage.' . PHP_EXT);
		ShowPassEncripterPage();
	break;
	case 'search':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowSearchPage.' . PHP_EXT);
		ShowSearchPage();
	break;
	case 'qeditor':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowQuickEditorPage.' . PHP_EXT);
		ShowQuickEditorPage();
	break;
	case 'statsupdate':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowStatUpdatePage.' . PHP_EXT);
		ShowStatUpdatePage();
	break;
	case 'reset':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowResetPage.' . PHP_EXT);
		ShowResetPage();
	break;
	case 'news':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowNewsPage.' . PHP_EXT);
		ShowNewsPage();
	break;
	case 'topnav':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowTopnavPage.' . PHP_EXT);
		ShowTopnavPage();
	break;
	case 'overview':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowOverviewPage.' . PHP_EXT);
		ShowOverviewPage();
	break;
	case 'menu':
		include_once(ROOT_PATH . 'includes/pages/adm/ShowMenuPage.' . PHP_EXT);
		ShowMenuPage();
	break;
	default:
		include_once(ROOT_PATH . 'includes/pages/adm/ShowIndexPage.' . PHP_EXT);
		ShowIndexPage();
	break;
}

?>