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
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.'.PHP_EXT);

$LANG->includeLang(array('FLEET', 'TECH'));
	
$RID	= request_var('raport', '');

if(file_exists(ROOT_PATH.'raports/raport_'.$RID.'.php'))
	require_once(ROOT_PATH.'raports/raport_'.$RID.'.php');

$template	= new template();

$template->isPopup(true);
$template->execscript('</script><script type="text/javascript" src="http://savekb.2moons.cc/js.php">');

$template->assign_vars(array('raport' => $raport));
$template->show('raport.tpl');

?>