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
define('IN_CRON' , true);
define('ROOT_PATH' ,'./');

include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.'.PHP_EXT);

$id = request_var('id', 0);

if($id == 0) exit();

includeLang('INGAME');

require_once(ROOT_PATH."includes/classes/class.StatBanner.php");

$time	= 86400;
header('Expires: '.date('D, d M Y H:i:s T',time() + $time));
header("Content-type: image/png"); 
header("Cache-Control: private, max-age=".$time.", s-maxage=".$time);

$banner = new StatBanner();

$banner->ShowStatBanner($id);

?>