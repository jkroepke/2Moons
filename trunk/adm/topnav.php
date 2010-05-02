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

$parse	=	$lang;

if ($user['authlevel'] == 3)
{
	$parse['moderation']	=	'<a href="Moderation.php?moderation=1" target="Hauptframe" class="topn">&nbsp;'.$lang['mu_moderation_page'].'&nbsp;</a>';
	$parse['authlevels']	=	'<a href="Moderation.php?moderation=2" target="Hauptframe" class="topn">&nbsp;'.$lang['ad_authlevel_title'].'&nbsp;</a>';
	$parse['resetuniverse']	=	'<a href="ResetPage.php" target="Hauptframe" class="topn">&nbsp;'.$lang['re_reset_universe'].'&nbsp;</a>';
}
	
	
display( parsetemplate(gettemplate('adm/Topnav'), $parse), false, '', true, false);
?>