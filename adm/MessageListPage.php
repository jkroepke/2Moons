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


if ($Observation != 1) die(message ($LNG['404_page']));

	$parse		= $LNG;
	$Prev       = ( !empty($_POST['prev'])   ) ? true : false;
	$Next       = ( !empty($_POST['next'])   ) ? true : false;
	$DelSel     = ( !empty($_POST['delsel']) ) ? true : false;
	$DelDat     = ( !empty($_POST['deldat']) ) ? true : false;
	$CurrPage   = ( !empty($_POST['curr'])   ) ? $_POST['curr'] : 1;
	$Selected   = ( !empty($_POST['sele'])   ) ? $_POST['sele'] : 0;
	$SelType    = $_POST['type'];
	$SelPage    = $_POST['page'];

	$ViewPage = 1;
	if ( $Selected != $SelType )
	{
		$Selected = $SelType;
		$ViewPage = 1;
	}
	elseif ( $CurrPage != $SelPage )
	{
		$ViewPage = ( !empty($SelPage) ) ? $SelPage : 1;
	}

	if($Prev   == true)
	{
		$CurrPage -= 1;
		if ($CurrPage >= 1)
			$ViewPage = $CurrPage;
		else
			$ViewPage = 1;
	}
	elseif ($Next   == true && $_POST['page'])
	{
		if ($Selected < 100)
			$Mess      = $db->fetch_array($db->query("SELECT COUNT(*) AS `max` FROM ".MESSAGES." WHERE `message_type` = '". $Selected ."';"));
		elseif ($Selected == 100)
			$Mess      = $db->fetch_array($db->query("SELECT COUNT(*) AS `max` FROM ".MESSAGES.";"));
			
		$MaxPage   = ceil ( ($Mess['max'] / 25) );
		$CurrPage += 1;
		if ($CurrPage <= $MaxPage)
			$ViewPage = $CurrPage;
		else
			$ViewPage = $MaxPage;
	}
	
	if ($_POST['delsel'] && is_array($_POST['sele']) && $_POST['page'])
	{
		if ($DelSel == true)
		{
			foreach($_POST['sele'] as $MessId => $Value)
			{
				if ($Value = "on")
					$db->query ( "DELETE FROM ".MESSAGES." WHERE `message_id` = '". $MessId ."';");
			}
		}
	}
	
	if ($_POST['deldat'] && $_POST['sele'] >= 1 && is_numeric($_POST['selday']) && is_numeric($_POST['selmonth']) && is_numeric($_POST['selyear'])
		&& $_POST['page'])
	{
		if ($DelDat == true)
		{
			$SelDay    = $_POST['selday'];
			$SelMonth  = $_POST['selmonth'];
			$SelYear   = $_POST['selyear'];
			$LimitDate = mktime (0,0,0, $SelMonth, $SelDay, $SelYear );
			if ($LimitDate != false)
			{
				$db->query ( "DELETE FROM ".MESSAGES." WHERE `message_time` <= '". $LimitDate ."';");
				$db->query ( "DELETE FROM ".RW." WHERE `time` <= '". $LimitDate ."';");
			}
		}
	}

	if ($Selected < 100)
		$Mess      = $db->fetch_array($db->query("SELECT COUNT(*) AS `max` FROM ".MESSAGES." WHERE `message_type` = '". $Selected ."';"));
	elseif ($Selected == 100)
		$Mess      = $db->fetch_array($db->query("SELECT COUNT(*) AS `max` FROM ".MESSAGES.";"));
			
	$MaxPage  = ceil ( ($Mess['max'] / 25) );

	$parse['mlst_data_page']    = $ViewPage;
	$parse['mlst_data_pagemax'] = $MaxPage;
	$parse['mlst_data_sele']    = $Selected;
	$parse['mlst_data_types']   = "<option value=\"0\"".  (($Selected == "0")  ? " SELECTED" : "") .">".$LNG['mg_type'][0]."</option>";
	$parse['mlst_data_types']  .= "<option value=\"1\"".  (($Selected == "1")  ? " SELECTED" : "") .">".$LNG['mg_type'][1]."</option>";
	$parse['mlst_data_types']  .= "<option value=\"2\"".  (($Selected == "2")  ? " SELECTED" : "") .">".$LNG['mg_type'][2]."</option>";
	$parse['mlst_data_types']  .= "<option value=\"3\"".  (($Selected == "3")  ? " SELECTED" : "") .">".$LNG['mg_type'][3]."</option>";
	$parse['mlst_data_types']  .= "<option value=\"4\"".  (($Selected == "4")  ? " SELECTED" : "") .">".$LNG['mg_type'][4]."</option>";
	$parse['mlst_data_types']  .= "<option value=\"5\"".  (($Selected == "5")  ? " SELECTED" : "") .">".$LNG['mg_type'][5]."</option>";
	$parse['mlst_data_types']  .= "<option value=\"15\"". (($Selected == "15") ? " SELECTED" : "") .">".$LNG['mg_type'][15]."</option>";
	$parse['mlst_data_types']  .= "<option value=\"99\"". (($Selected == "99") ? " SELECTED" : "") .">".$LNG['mg_type'][99]."</option>";
	$parse['mlst_data_types']  .= "<option value=\"100\"". (($Selected == "100") ? " SELECTED" : "") .">".$LNG['ml_see_all_messages']."</option>";
	$parse['mlst_data_pages']   = "";

	for ( $cPage = 1; $cPage <= $MaxPage; $cPage++ )
	{
		$parse['mlst_data_pages'] .= "<option value=\"".$cPage."\"".  (($ViewPage == $cPage)  ? " SELECTED" : "") .">". $cPage ."/". $MaxPage ."</option>";
	}

	$StartRec            = (($ViewPage - 1) * 25);
	if ($Selected < 100)
		$Messages            = $db->query("SELECT * FROM ".MESSAGES." WHERE `message_type` = '". $Selected ."' ORDER BY `message_time` DESC LIMIT ". $StartRec .",25;");
	elseif ($Selected == 100)
		$Messages            = $db->query("SELECT * FROM ".MESSAGES." ORDER BY `message_time` DESC LIMIT ". $StartRec .",25;");

		while ($row = $db->fetch_array($Messages))
		{
			$OwnerData = $db->fetch_array($db->query ("SELECT `username` FROM ".USERS." WHERE `id` = '". $row['message_owner'] ."';"));
			$bloc['mlst_id']      = $row['message_id'];
			$bloc['mlst_from']    = $row['message_from'];
			$bloc['mlst_to']      = $OwnerData['username'] ." ".$LNG['input_id'].":". $row['message_owner'];
			$bloc['mlst_subject'] = $row['message_subject'];
			$bloc['mlst_text']    = $row['message_text'];
			$bloc['mlst_time']    = date ("d/M/y H:i:s", $row['message_time'] );
			
			$parse['mlst_data_rows'] .= parsetemplate(gettemplate('adm/MessageListRows'), $bloc);
		}
	display (parsetemplate(gettemplate('adm/MessageListBody'), $parse), false, '', true, false);
?>