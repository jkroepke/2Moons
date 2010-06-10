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
include(ROOT_PATH . 'common.' . PHP_EXT);


if ($Observation != 1) die();

$parse    	= $LNG;
$delete 	= request_var('delete',0);
$deleteall 	= request_var('deleteall',0);

if ($delete) {
    $db->query("DELETE FROM ".CHAT." WHERE `messageid`=".$delete.";");
} elseif($deleteall) {
	$db->query("TRUNCATE TABLE ".CHAT.";");
}

$query = $db->query("SELECT * FROM ".CHAT." ORDER BY messageid DESC");
$i = 0;

while ($e = $db->fetch_array($query)) {
    $i++;
	$replace = array("#\[url=(ft|https?://)(.+)\](.+)\[/url\]#isU",
					 "#\[b\](.+)\[/b\]#isU",
					 "#\[i\](.+)\[/i\]#isU",
					 "#\[u\](.+)\[/u\]#isU",
					 "#\[c=(white|blue|yellow|green|pink|red|orange)\](.+)\[/c\]#isU",
					 "#:agr:#isU",
					 "#:angel:#isU",
					 "#:bad:#isU",
					 "#:blink:#isU",
					 "#:blush:#isU",
					 "#:bomb:#isU",
					 "#:clap:#isU",
					 "#:cool:#isU",
					 "#:c:#isU",
					 "#:crz:#isU",
					 "#:diablo:#isU",
					 "#:cool2:#isU",
					 "#:fool:#isU",
					 "#:rose:#isU",
					 "#:good:#isU",
					 "#:huh:#isU",
					 "#:D:#isU",
					 "#:yu#isU",
					 "#:unknw:#isU",
					 "#:sad#isU",
					 "#:smile#isU",
					 "#:shok:#isU",
					 "#:rofl#isU",
					 "#:eye#isU",
					 "#:p#isU",
					 "#:wink:#isU",
					 "#:yahoo:#isU",
					 "#:tratata:#isU",
					 "#:fr#isU",
					 "#:dr#isU",
					 "#:tease:#isU");
						 
	$with = array("<a href=\"$1$2\" target=\"_blank\">$3</a>",
				  "<b>$1</b>",
				  "<i>$1</i>",
				  "<u>$1</u>",
				  "<font color=\"$1\">$2</font>",
				  "<img src=\"styles/images/smileys/aggressive.gif\" align=\"absmiddle\" title=\":agr:\" alt=\":agr:\">",
				  "<img src=\"styles/images/smileys/angel.gif\" align=\"absmiddle\" title=\":angel:\" alt=\":angel:\">",
				  "<img src=\"styles/images/smileys/bad.gif\" align=\"absmiddle\" title=\":bad:\" alt=\":bad:\">",
				  "<img src=\"styles/images/smileys/blink.gif\" align=\"absmiddle\" title=\":blink:\" alt=\":blink:\">",
				  "<img src=\"styles/images/smileys/blush.gif\" align=\"absmiddle\" title=\":blush:\" alt=\":blush:\">",
				  "<img src=\"styles/images/smileys/bomb.gif\" align=\"absmiddle\" title=\":bomb:\" alt=\":bomb:\">",
				  "<img src=\"styles/images/smileys/clapping.gif\" align=\"absmiddle\" title=\":clap:\" alt=\":clap:\"",
				  "<img src=\"styles/images/smileys/cool.gif\" align=\"absmiddle\" title=\":cool:\" alt=\":cool:\"",
				  "<img src=\"styles/images/smileys/cray.gif\" align=\"absmiddle\" title=\":c:\" alt=\":c:\"",
				  "<img src=\"styles/images/smileys/crazy.gif\" align=\"absmiddle\" title=\":crz:\" alt=\":crz:\"",
				  "<img src=\"styles/images/smileys/diablo.gif\" align=\"absmiddle\" title=\":diablo:\" alt=\":diablo:\"",
				  "<img src=\"styles/images/smileys/dirol.gif\" align=\"absmiddle\" title=\":cool2:\" alt=\":cool2:\"",
				  "<img src=\"styles/images/smileys/fool.gif\" align=\"absmiddle\" title=\":fool:\" alt=\":fool:\"",
				  "<img src=\"styles/images/smileys/give_rose.gif\" align=\"absmiddle\" title=\":rose:\" alt=\":rose:\"",
				  "<img src=\"styles/images/smileys/good.gif\" align=\"absmiddle\" title=\":good:\" alt=\":good:\"",
				  "<img src=\"styles/images/smileys/huh.gif\" align=\"absmiddle\" title=\":huh:\" alt=\":|\"",
				  "<img src=\"styles/images/smileys/lol.gif\" align=\"absmiddle\" title=\":D\" alt=\":D\"",
				  "<img src=\"styles/images/smileys/yu.gif\" align=\"absmiddle\" title=\":yu\" alt=\":yu\"",
				  "<img src=\"styles/images/smileys/unknw.gif\" align=\"absmiddle\" title=\":unknw:\" alt=\":unknw:\"",
				  "<img src=\"styles/images/smileys/sad.gif\" align=\"absmiddle\" title=\":(\" alt=\":(\"",
				  "<img src=\"styles/images/smileys/smile.gif\" align=\"absmiddle\" title=\":)\" alt=\":)\"",
				  "<img src=\"styles/images/smileys/shok.gif\" align=\"absmiddle\" title=\":shok:\" alt=\":shok:\"",
				  "<img src=\"styles/images/smileys/rofl.gif\" align=\"absmiddle\" title=\":rofl\" alt=\":rofl\"",
				  "<img src=\"styles/images/smileys/blackeye.gif\" align=\"absmiddle\" title=\":eye\" alt=\":eye\"",
				  "<img src=\"styles/images/smileys/tongue.gif\" align=\"absmiddle\" title=\":p\" alt=\":p\"",
				  "<img src=\"styles/images/smileys/wink.gif\" align=\"absmiddle\" title=\";)\" alt=\";)\"",
				  "<img src=\"styles/images/smileys/yahoo.gif\" align=\"absmiddle\" title=\":yahoo:\" alt=\":yahoo:\"",
				  "<img src=\"styles/images/smileys/mill.gif\" align=\"absmiddle\" title=\":tratata:\" alt=\":tratata:\"",
				  "<img src=\"styles/images/smileys/friends.gif\" align=\"absmiddle\" title=\":fr\" alt=\":fr\"",
				  "<img src=\"styles/images/smileys/drinks.gif\" align=\"absmiddle\" title=\":dr\" alt=\":dr\"",
				  "<img src=\"styles/images/smileys/tease.gif\" align=\"absmiddle\" title=\":tease:\" alt=\":tease:\">");
			
	$msg = preg_replace($replace, $with, $e['message']);
    $parse['msg_list'] .= stripslashes("<tr><th class=b rowspan=2>".$e['messageid']."</th>" .
    "<th class=b><center>[<a href=?delete=".$e['messageid'].">X</a>]</center></th>" .
    "<th class=b><center>".$e['user']."</center></th>" .
    "<th class=b><center>" . date('d. M Y - h:i:s', $e['timestamp']) . "</center></th></tr><tr>" .
    "<th class=b colspan=4 width=500>" . nl2br($msg) . "</th></tr>");
}
$parse['msg_list'] .= "<tr><th class=b colspan=4>".$i." ".$LNG['ch_nbs']."</th></tr>";

display(parsetemplate(gettemplate('adm/ChatPage'), $parse),false, '', true, false);

?>