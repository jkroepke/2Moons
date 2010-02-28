<?php

##############################################################################
# *																			 #
# * RN FRAMEWORK															 #
# *  																		 #
# * @copyright Copyright (C) 2009 By ShadoX from xnova-reloaded.de	    	 #
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

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.' . PHP_EXT);

if ($user['authlevel'] < 1) die();

$parse	=	$lang;

if ($user['authlevel'] == 3)
{
	$parse['moderation']	=	'<a href="Moderation.php?moderation=1" target="Hauptframe" class="topn">&nbsp;'.$lang['mu_moderation_page'].'&nbsp;</a>';
	$parse['authlevels']	=	'<a href="Moderation.php?moderation=2" target="Hauptframe" class="topn">&nbsp;'.$lang['ad_authlevel_title'].'&nbsp;</a>';
}
	
	
display( parsetemplate(gettemplate('adm/topnav'), $parse), false, '', true, false);
?>