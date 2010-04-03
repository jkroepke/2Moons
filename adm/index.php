<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
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

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.'.PHP_EXT);


if ($user['authlevel'] < 1) die(message ($lang['404_page']));

	$page  = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Frameset//EN\" \"http://www.w3.org/TR/html4/frameset.dtd\">\n";
	$page  = "<html>\n";
	$page .= "<head>\n";
	$page .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\n";
	$page .= "<title>". $game_config['game_name'] ." - Admin CP</title>\n";
	$page .= "<link rel=\"shortcut icon\" href=\"./../favicon.ico\">\n";
	$page .= "</head>\n";
	$page .= "<frameset cols=\"180,*\" frameborder=\"no\" border=\"0\" framespacing=\"0\">\n";
	$page .= "<frame src=\"menu.php\" name=\"rightFrame\" id=\"rightFrame\"/>\n";
	$page .= "<frameset rows=\"85,*\" frameborder=\"no\" border=\"0\" framespacing=\"0\">\n";
	$page .= "<frame src=\"topnav.php\" name=\"topFrame\" scrolling=\"No\" noresize=\"noresize\" id=\"topFrame\"/>\n";
	$page .= "<frame src=\"OverviewPage.php\" name=\"Hauptframe\" scrolling=\"auto\" noresize=\"noresize\" id=\"mainFrame\"/>\n";
	$page .= "</frameset>\n";
	$page .= "<noframes><body>\n";
	$page .= "</body>\n";
	$page .= "</noframes></html>\n";
	echo $page;
?>