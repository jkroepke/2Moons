<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
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

if(!defined('INSIDE')){ die(header("location:../../"));}

class ShowChatPage
{
	private $page_limit = 30; // Chat rows Limit

	private function BBCodeMSG($msg){
	
		$replace = array("#\[url=(ft|https?://)(.+)\](.+)\[/url\]#isU","#\[b\](.+)\[/b\]#isU","#\[i\](.+)\[/i\]#isU","#\[u\](.+)\[/u\]#isU","#\[c=(white|blue|yellow|green|pink|red|orange)\](.+)\[/c\]#isU","#:agr:#isU","#:angel:#isU","#:bad:#isU","#:blink:#isU","#:blush:#isU","#:bomb:#isU","#:clap:#isU","#:cool:#isU","#:c:#isU","#:crz:#isU","#:diablo:#isU","#:cool2:#isU","#:fool:#isU","#:rose:#isU","#:good:#isU","#:huh:#isU","#:D:#isU","#:yu#isU","#:unknw:#isU","#:sad#isU","#:smile#isU","#:shok:#isU","#:rofl#isU","#:eye#isU","#:p#isU","#:wink:#isU","#:yahoo:#isU", "#:tratata:#isU", "#:fr#isU","#:dr#isU","#:tease:#isU");
		$with 	 = array("<a href=\"$1$2\" target=\"_blank\">$3</a>","<b>$1</b>","<i>$1</i>","<u>$1</u>","<font color=\"$1\">$2</font>","<img src=\"styles/images/smileys/aggressive.gif\" align=\"absmiddle\" title=\":agr:\" alt=\":agr:\">","<img src=\"styles/images/smileys/angel.gif\" align=\"absmiddle\" title=\":angel:\" alt=\":angel:\">","<img src=\"styles/images/smileys/bad.gif\" align=\"absmiddle\" title=\":bad:\" alt=\":bad:\">","<img src=\"styles/images/smileys/blink.gif\" align=\"absmiddle\" title=\":blink:\" alt=\":blink:\">","<img src=\"styles/images/smileys/blush.gif\" align=\"absmiddle\" title=\":blush:\" alt=\":blush:\">","<img src=\"styles/images/smileys/bomb.gif\" align=\"absmiddle\" title=\":bomb:\" alt=\":bomb:\">","<img src=\"styles/images/smileys/clapping.gif\" align=\"absmiddle\" title=\":clap:\" alt=\":clap:\"","<img src=\"styles/images/smileys/cool.gif\" align=\"absmiddle\" title=\":cool:\" alt=\":cool:\"","<img src=\"styles/images/smileys/cray.gif\" align=\"absmiddle\" title=\":c:\" alt=\":c:\"","<img src=\"styles/images/smileys/crazy.gif\" align=\"absmiddle\" title=\":crz:\" alt=\":crz:\"","<img src=\"styles/images/smileys/diablo.gif\" align=\"absmiddle\" title=\":diablo:\" alt=\":diablo:\"","<img src=\"styles/images/smileys/dirol.gif\" align=\"absmiddle\" title=\":cool2:\" alt=\":cool2:\"","<img src=\"styles/images/smileys/fool.gif\" align=\"absmiddle\" title=\":fool:\" alt=\":fool:\"","<img src=\"styles/images/smileys/give_rose.gif\" align=\"absmiddle\" title=\":rose:\" alt=\":rose:\"","<img src=\"styles/images/smileys/good.gif\" align=\"absmiddle\" title=\":good:\" alt=\":good:\"","<img src=\"styles/images/smileys/huh.gif\" align=\"absmiddle\" title=\":huh:\" alt=\":|\"","<img src=\"styles/images/smileys/lol.gif\" align=\"absmiddle\" title=\":D\" alt=\":D\"","<img src=\"styles/images/smileys/yu.gif\" align=\"absmiddle\" title=\":yu\" alt=\":yu\"","<img src=\"styles/images/smileys/unknw.gif\" align=\"absmiddle\" title=\":unknw:\" alt=\":unknw:\"","<img src=\"styles/images/smileys/sad.gif\" align=\"absmiddle\" title=\":(\" alt=\":(\"","<img src=\"styles/images/smileys/smile.gif\" align=\"absmiddle\" title=\":)\" alt=\":)\"","<img src=\"styles/images/smileys/shok.gif\" align=\"absmiddle\" title=\":shok:\" alt=\":shok:\"","<img src=\"styles/images/smileys/rofl.gif\" align=\"absmiddle\" title=\":rofl\" alt=\":rofl\"","<img src=\"styles/images/smileys/blackeye.gif\" align=\"absmiddle\" title=\":eye\" alt=\":eye\"","<img src=\"styles/images/smileys/tongue.gif\" align=\"absmiddle\" title=\":p\" alt=\":p\"","<img src=\"styles/images/smileys/wink.gif\" align=\"absmiddle\" title=\";)\" alt=\";)\"","<img src=\"styles/images/smileys/yahoo.gif\" align=\"absmiddle\" title=\":yahoo:\" alt=\":yahoo:\"","<img src=\"styles/images/smileys/mill.gif\" align=\"absmiddle\" title=\":tratata:\" alt=\":tratata:\"","<img src=\"styles/images/smileys/friends.gif\" align=\"absmiddle\" title=\":fr\" alt=\":fr\"","<img src=\"styles/images/smileys/drinks.gif\" align=\"absmiddle\" title=\":dr\" alt=\":dr\"","<img src=\"styles/images/smileys/tease.gif\" align=\"absmiddle\" title=\":tease:\" alt=\":tease:\">");	

		return preg_replace($replace, $with, $msg);
	}
	
	private function SetMeassageInChat($CurrentUser, $chat_type, $msg) {
		global $db, $lang;
		$db->query("INSERT INTO ".CHAT." (user, ally_id, message, timestamp) VALUES ('".(($CurrentUser['authlevel'] == 3) ? sprintf($lang['chat_admin'], $CurrentUser['username']) : $CurrentUser['username'])."','".(($chat_type == "ally") ? $CurrentUser['ally_id'] : 0)."','".$msg."', '".time()."');");
	}

	private function GetMessages($CurrentUser, $chat_type) {
		global $db;
		$query 	= $db->query("SELECT * FROM ".CHAT." WHERE ally_id = '".(($chat_type == "ally") ? $CurrentUser['ally_id'] : 0)."' ORDER BY messageid DESC LIMIT ".$this->page_limit.";");
		$msg 	= "";
		while($v = $db->fetch_array($query)){
			$nick = "<a href='#' onmousedown=\"addSmiley('[ ".(strstr($v["user"],"<font")?substr($v["user"], 24, 6):$v["user"])." ]')\">".$v["user"]."</a>";
			$msgtimestamp = date("m/d H:i:s", $v["timestamp"]);
			$mess = $this->BBCodeMSG($v["message"]);
			$msg .= "<div align=\"left\" style='color:white;'><span style='font:menu;'>[".$msgtimestamp."]</span> <span style='width:50px;font:menu;'><b>".$nick."</b></span> : ".$mess."<br></div>";
		}
		print $msg;
	}
	
	public function ShowChatPage($CurrentUser, $CurrentPlanet){
		global $game_config, $dpath, $lang, $db;

		$mode 	= request_var('mode', '');
		$msg 	= request_var('msg', '', true);		
		$ctype	= request_var('chat_type', '');
		
		if($mode == "send" && $msg != ''){
			$this->SetMeassageInChat($CurrentUser, $ctype, $msg);
		} elseif($mode == "call") {
			$this->GetMessages($CurrentUser, $ctype);
		} else {
			$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
			$template	= new template();
			
				$template->set_vars($CurrentUser, $CurrentPlanet);
			$template->page_header();
			$template->page_footer();
			
			if (empty($ctype)) {
				$template->page_topnav();
				$template->page_leftmenu();
				$template->page_planetmenu();
			}

				
			$template->assign_vars(array(
				'ctype'			=> $ctype,
				'chat_send'		=> $lang['chat_send'],
				'chat_disc'		=> $lang['chat_disc'],
				'chat_message'	=> $lang['chat_message'],
			));
			
			$template->show("chat_overview.tpl");
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
		}
	}

}

?>