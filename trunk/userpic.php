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
# *	                                                                         #
# *  You should have received a copy of the GNU General Public License       #
# *  along with this program.  If not, see <http://www.gnu.org/licenses/>    #
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

if(!isset($_GET['debug'])) {
	header('Expires: '.date('D, d M Y H:i:s T',$game_config['stat_last_db_update'] + (60 * 60 * 24)));
	header("Cache-Control: private, must-revalidate");
	header("Content-type: image/png"); 
}

$banner = new StatBanner();

$banner->ShowStatBanner($id);

?>