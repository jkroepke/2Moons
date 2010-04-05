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



if ($EditUsers != 1) die(message ($lang['404_page']));

$parse = $lang;

switch($_GET[page])
{
	case'resources':

		$id         = $_POST['id'];
		$id_dark    = $_POST['id_dark'];
		$metal      = $_POST['metal'];
		$cristal    = $_POST['cristal'];
		$deut       = $_POST['deut'];
		$dark		= $_POST['dark'];

		if ($_POST){
		if(is_numeric($id) && is_numeric($metal) && is_numeric($cristal) && is_numeric($deut) && is_numeric($dark) && is_numeric($id_dark))
		{
			if ($_POST['add'])
			{
				$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
				$QryUpdatePlanet .= "`metal` = `metal` + '". $metal ."', ";
				$QryUpdatePlanet .= "`crystal` = `crystal` + '". $cristal ."', ";
				$QryUpdatePlanet .= "`deuterium` = `deuterium` + '". $deut ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				$db->query($QryUpdatePlanet);


				if ($id_dark != NULL)
				{
					$QryUpdateUser  = "UPDATE ".USERS." SET ";
					$QryUpdateUser .= "`darkmatter` = `darkmatter` + '". $dark ."' ";
					$QryUpdateUser .= "WHERE ";
					$QryUpdateUser .= "`id` = '". $id_dark ."' ";
					$db->query($QryUpdateUser);
				}
				$Name	=	$lang['log_moree'];
				$parse['display']	=	'<tr><th colspan="2"><font color=lime>'.$lang['ad_add_sucess'].'</font></th></tr>';
			}
			elseif ($_POST['delete'])
			{
				$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
				$QryUpdatePlanet .= "`metal` = `metal` - '". $metal ."', ";
				$QryUpdatePlanet .= "`crystal` = `crystal` - '". $cristal ."', ";
				$QryUpdatePlanet .= "`deuterium` = `deuterium` - '". $deut ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				$db->query( $QryUpdatePlanet);


				if ($id_dark != NULL)
				{
					$QryUpdateUser  = "UPDATE ".USERS." SET ";
					$QryUpdateUser .= "`darkmatter` = `darkmatter` - '". $dark ."' ";
					$QryUpdateUser .= "WHERE ";
					$QryUpdateUser .= "`id` = '". $id_dark ."' ";
					$db->query( $QryUpdateUser);
				}
				$Name	=	$lang['log_nomoree'];
				$parse['display']	=	'<tr><th colspan="2"><font color=lime>'.$lang['ad_delete_sucess'].'</font></th></tr>';
			}

			if ($_POST['add'] || $_POST['delete'])
			{
				$Log	.=	"\n".$lang['log_the_user'].$user['username']." ".$Name.":\n";
				$Log	.=	$lang['metal'].": ".$metal."\n";
				$Log	.=	$lang['crystal'].": ".$cristal."\n";
				$Log	.=	$lang['deuterium'].": ".$deut."\n";
				$Log	.=	$lang['log_to_planet'].$id."\n";
				$Log	.=	$lang['log_and'].$lang['darkmatter'].": ".$dark."\n";
				$Log	.=	$lang['log_to_user'].$id_dark."\n";

				LogFunction($Log, "ResourcesLog", $LogCanWork);
			}
		}
		else
		{
			$parse['display']	=	'<tr><th colspan="2"><font color=red>'.$lang['ad_only_numbers'].'</font></th></tr>';
		}

	}

			display (parsetemplate(gettemplate("adm/EditorTPL/ResourcesBody"), $parse), false, '', true, false);
	break;

	case'ships':
		if($_POST)
		{
			if ($_POST['add'])
			{
				$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
				foreach($reslist['fleet'] as $ID)
				{
					$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` + '".round(abs(request_var($resource[$ID], 0.0)), 0)."'";
				}
				$QryUpdatePlanet .= implode(", ", $QryUpdate);
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '".request_var('id', 0)."';";
				$db->query($QryUpdatePlanet);

				$Name	=	$lang['log_moree'];
				$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_add_sucess_ships'].'</font></th></tr>';
			}
			elseif ($_POST['delete'])
			{
				$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
				foreach($reslist['fleet'] as $ID)
				{
					$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` - '".round(abs(request_var($resource[$ID], 0.0)), 0)."'";
				}
				$QryUpdatePlanet .= implode(", ", $QryUpdate);
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '".request_var('id', 0)."';";
				$db->query( $QryUpdatePlanet);
				$Name	=	$lang['log_nomoree'];
				$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_delete_sucess_ships'].'</font></th></tr>';
			}

			if ($_POST['add'] || $_POST['delete'])
			{
				$Log	.=	"\r\n".$lang['log_the_user'].$user['username']." ".$Name.":\n";
				foreach($reslist['fleet'] as $ID)
				{
					$Log	.=	$lang['tech'][$ID].": ".round(abs(request_var($resource[$ID], 0.0)), 0)."\r\n";
				}
				$Log	.=	$lang['log_to_planet'].$id."\r\n";

				LogFunction($Log, "ShipsLog", $LogCanWork);
			}
		}
		$parse['ships']	= "";
		foreach($reslist['fleet'] as $ID)
		{
			$parse['ships']	.= "<tr><th>".$ID."</th><th>".$lang['tech'][$ID]."</th><th><input name=\"".$resource[$ID]."\" type=\"text\" value=\"0\"></th></tr>";
		}
		display (parsetemplate(gettemplate("adm/EditorTPL/ShipsBody"), $parse), false, '', true, false);
	break;

	case'defenses':
		if($_POST)
		{
			if ($_POST['add'])
			{
				$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
				foreach($reslist['defense'] as $ID)
				{
					$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` + '".round(abs(request_var($resource[$ID], 0.0)), 0)."'";
				}
				$QryUpdatePlanet .= implode(", ", $QryUpdate);
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '".request_var('id', 0)."';";
				$db->query($QryUpdatePlanet);

				$Name	=	$lang['log_moree'];
				$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_add_sucess_ships'].'</font></th></tr>';
			}
			elseif ($_POST['delete'])
			{
				$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
				foreach($reslist['defense'] as $ID)
				{
					$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` - '".round(abs(request_var($resource[$ID], 0.0)), 0)."'";
				}
				$QryUpdatePlanet .= implode(", ", $QryUpdate);
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '".request_var('id', 0)."';";
				$db->query( $QryUpdatePlanet);
				$Name	=	$lang['log_nomoree'];
				$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_delete_sucess_ships'].'</font></th></tr>';
			}

			if ($_POST['add'] || $_POST['delete'])
			{
				$Log	.=	"\r\n".$lang['log_the_user'].$user['username']." ".$Name.":\n";
				foreach($reslist['defense'] as $ID)
				{
					$Log	.=	$lang['tech'][$ID].": ".round(abs(request_var($resource[$ID], 0.0)), 0)."\r\n";
				}
				$Log	.=	$lang['log_to_planet'].$id."\r\n";

				LogFunction($Log, "DefensesLog", $LogCanWork);
			}
		}
		$parse['defense']	= "";
		foreach($reslist['defense'] as $ID)
		{
			$parse['defense']	.= "<tr><th>".$ID."</th><th>".$lang['tech'][$ID]."</th><th><input name=\"".$resource[$ID]."\" type=\"text\" value=\"0\"></th></tr>";
		}
		display (parsetemplate(gettemplate("adm/EditorTPL/DefensesBody"), $parse), false, '', true, false);
	break;

	case'buildings':
		if($_POST)
		{
			$PlanetData	= $db->fetch_array($db->query("SELECT `planet_type` FROM ".PLANETS." WHERE `id` = '".request_var('id', 0)."';"));
			if ($_POST['add'])
			{
				$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
				foreach($reslist['allow'][$PlanetData['planet_type']] as $ID)
				{
					$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` + '".round(abs(request_var($resource[$ID], 0.0)), 0)."'";
				}
				$QryUpdatePlanet .= implode(", ", $QryUpdate);
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '".request_var('id', 0)."';";
				$db->query($QryUpdatePlanet);

				$Name	=	$lang['log_moree'];
				$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_add_sucess_ships'].'</font></th></tr>';
			}
			elseif ($_POST['delete'])
			{
				$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
				foreach($reslist['allow'][$PlanetData['planet_type']] as $ID)
				{
					$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` - '".round(abs(request_var($resource[$ID], 0.0)), 0)."'";
				}
				$QryUpdatePlanet .= implode(", ", $QryUpdate);
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '".request_var('id', 0)."';";
				$db->query( $QryUpdatePlanet);
				$Name	=	$lang['log_nomoree'];
				$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_delete_sucess_ships'].'</font></th></tr>';
			}

			if ($_POST['add'] || $_POST['delete'])
			{
				$Log	.=	"\r\n".$lang['log_the_user'].$user['username']." ".$Name.":\n";
				foreach($reslist['allow'][$PlanetData['planet_type']] as $ID)
				{
					$Log	.=	$lang['tech'][$ID].": ".round(abs(request_var($resource[$ID], 0.0)), 0)."\r\n";
				}
				$Log	.=	$lang['log_to_planet'].$id."\r\n";

				LogFunction($Log, "BuildingsLog", $LogCanWork);
			}
		}
		$parse['build']	= "";
		foreach($reslist['build'] as $ID)
		{
			$parse['build']	.= "<tr><th>".$ID."</th><th>".$lang['tech'][$ID]."</th><th><input name=\"".$resource[$ID]."\" type=\"text\" value=\"0\"></th></tr>";
		}

		display (parsetemplate(gettemplate("adm/EditorTPL/BuildingsBody"), $parse), false, '', true, false);
	break;

	case'researchs':
		if($_POST)
		{
			if ($_POST['add'])
			{
				$QryUpdatePlanet  = "UPDATE ".USERS." SET ";
				foreach($reslist['tech'] as $ID)
				{
					$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` + '".round(abs(request_var($resource[$ID], 0.0)), 0)."'";
				}
				$QryUpdatePlanet .= implode(", ", $QryUpdate);
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '".request_var('id', 0)."';";
				$db->query($QryUpdatePlanet);

				$Name	=	$lang['log_moree'];
				$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_add_sucess_ships'].'</font></th></tr>';
			}
			elseif ($_POST['delete'])
			{
				$QryUpdatePlanet  = "UPDATE ".USERS." SET ";
				foreach($reslist['tech'] as $ID)
				{
					$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` - '".round(abs(request_var($resource[$ID], 0.0)), 0)."'";
				}
				$QryUpdatePlanet .= implode(", ", $QryUpdate);
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '".request_var('id', 0)."';";
				$db->query( $QryUpdatePlanet);
				$Name	=	$lang['log_nomoree'];
				$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_delete_sucess_ships'].'</font></th></tr>';
			}

			if ($_POST['add'] || $_POST['delete'])
			{
				$Log	.=	"\r\n".$lang['log_the_user'].$user['username']." ".$Name.":\n";
				foreach($reslist['tech'] as $ID)
				{
					$Log	.=	$lang['tech'][$ID].": ".round(abs(request_var($resource[$ID], 0.0)), 0)."\r\n";
				}
				$Log	.=	$lang['log_to_planet'].$id."\r\n";

				LogFunction($Log, "ResearchLog", $LogCanWork);
			}
		}
		$parse['tech']	= "";
		foreach($reslist['tech'] as $ID)
		{
			$parse['tech']	.= "<tr><th>".$ID."</th><th>".$lang['tech'][$ID]." ".(($pricelist[$ID]['max'] != 255) ? sprintf($lang['ad_max'], $pricelist[$ID]['max']):"")."</th><th><input name=\"".$resource[$ID]."\" type=\"text\" value=\"0\"></th></tr>";
		}
		display (parsetemplate(gettemplate("adm/EditorTPL/ResearchBody"), $parse), false, '', true, false);
	break;

	case 'personal':
		$parse['yes']    =    $lang['one_is_yes'][1];
		$parse['no']    =    $lang['one_is_yes'][0];
		if ($user['authlevel'] != 3) $parse['Block']    =    "disabled='disabled'";
		if ($_POST)
		{
			if ($user['authlevel'] != 3 && $_POST['username'] != NULL && $_POST['password'] != NULL && $_POST['email_2'] != NULL &&
				$_POST['email'] != NULL ) die();

			if(!$_POST['id'])
			{
				$parse['display']    =    '<tr><th colspan="3"><font color=red>'.$lang['ad_forgiven_id'].'</font></th></tr>';
			}
			else
			{
				$Log    .=    "\n".$lang['log_the_user'].$user['username']." ".$lang['log_modify_personal'].":\n";

				$PersonalQuery    =    "UPDATE ".USERS." SET ";
				if($_POST['username'] != NULL){
					$PersonalQuery    .=    "`username` = '".$_POST['username']."', ";
					$Log    .=    $lang['ad_personal_name'].": ".$_POST['username']."\n";}

				if($_POST['email'] != NULL){
					$PersonalQuery    .=    "`email` = '".$_POST['email']."', ";
					$Log    .=    $lang['ad_personal_email'].": ".$_POST['email']."\n";}

				if($_POST['email_2'] != NULL){
					$PersonalQuery    .=    "`email_2` = '".$_POST['email_2']."', ";
					$Log    .=    $lang['ad_personal_email2'].": ".$_POST['email_2']."\n";}

				if($_POST['password'] != NULL)
					$PersonalQuery    .=    "`password` = '".md5($_POST['password'])."', ";

				if($_POST['vacation'] != '')
				{
					if ($_POST['vacation'] == 'no')
					{
						$Answer        =    0;
						$TimeAns    =    0;
					}
					elseif ($_POST['vacation'] == 'yes')
					{
						$Answer        =    1;
						$VTime        =     $_POST['d'] * 86400;
						$VTime        +=     $_POST['h'] * 3600;
						$VTime        +=     $_POST['m'] * 60;
						$VTime        +=     $_POST['s'];
						$TimeAns    =    $VTime + time();
					}

					$PersonalQuery    .=    "`urlaubs_modus` = '".$Answer."', `urlaubs_until` = '".$TimeAns."' ";
				}
				else
					$PersonalQuery    .=    "`onlinetime` = '".time()."' ";


				if ($_POST['username'] or $_POST['email'] or $_POST['email_2'] or $_POST['password'] or $_POST['vacation'] != '')
				{
					$PersonalQuery    .=    "WHERE `id` = '".$_POST['id']."'";
					$db->query($PersonalQuery);
					$Log    .=    $lang['log_to_user'].$_POST['id']."\n";
					LogFunction($Log, "PersonalLog", $LogCanWork);
				}

				$parse['display']    =    '<tr><th colspan="3"><font color=lime>'.$lang['ad_personal_succes'].'</font></th></tr>';
			}
		}
		display (parsetemplate(gettemplate("adm/EditorTPL/PersonalBody"), $parse), false, '', true, false);
	break;

	case'officiers':
		if($_POST)
		{
			if ($_POST['add'])
			{
				$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
				foreach($reslist['officier'] as $ID)
				{
					$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` + '".round(abs(request_var($resource[$ID], 0.0)), 0)."'";
				}
				$QryUpdatePlanet .= implode(", ", $QryUpdate);
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '".request_var('id', 0)."';";
				$db->query($QryUpdatePlanet);

				$Name	=	$lang['log_moree'];
				$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_add_sucess_ships'].'</font></th></tr>';
			}
			elseif ($_POST['delete'])
			{
				$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
				foreach($reslist['officier'] as $ID)
				{
					$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` - '".round(abs(request_var($resource[$ID], 0.0)), 0)."'";
				}
				$QryUpdatePlanet .= implode(", ", $QryUpdate);
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '".request_var('id', 0)."';";
				$db->query( $QryUpdatePlanet);
				$Name	=	$lang['log_nomoree'];
				$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_delete_sucess_ships'].'</font></th></tr>';
			}

			if ($_POST['add'] || $_POST['delete'])
			{
				$Log	.=	"\r\n".$lang['log_the_user'].$user['username']." ".$Name.":\n";
				foreach($reslist['officier'] as $ID)
				{
					$Log	.=	$lang['tech'][$ID].": ".round(abs(request_var($resource[$ID], 0.0)), 0)."\r\n";
				}
				$Log	.=	$lang['log_to_planet'].$id."\r\n";

				LogFunction($Log, "OfficierLog", $LogCanWork);
			}
		}
		$parse['officier']	= "";
		foreach($reslist['officier'] as $ID)
		{
			$parse['officier']	.= "<tr><th>".$ID."</th><th>".$lang['tech'][$ID]." ".sprintf($lang['ad_max'], $pricelist[$ID]['max'])."</th><th><input name=\"".$resource[$ID]."\" type=\"text\" value=\"0\"></th></tr>";
		}

		display (parsetemplate(gettemplate("adm/EditorTPL/OfficiersBody"), $parse), false, '', true, false);
	break;

	case 'planets':
		if ($_POST)
		{
			$id				=	$_POST['id'];
			$name			=	$_POST['name'];
			$change_id		=	$_POST['change_id'];
			$diameter		=	$_POST['diameter'];
			$fields			=	$_POST['fields'];
			$buildings		=	$_POST['0_buildings'];
			$ships			=	$_POST['0_ships'];
			$defenses		=	$_POST['0_defenses'];
			$c_hangar		=	$_POST['0_c_hangar'];
			$c_buildings	=	$_POST['0_c_buildings'];
			$change_pos		=	$_POST['change_position'];
			$galaxy			=	$_POST['g'];
			$system			=	$_POST['s'];
			$planet			=	$_POST['p'];
			$delete			=	$_POST['delete'];

			if ($id != NULL)
			{
			 	if (is_numeric($id))
			 	{
					$Log	.=	"\n".$lang['log_the_user'].$user['username']." ".$lang['log_modify_personal'].":\n";

				if ($delete != 'on')
				{
					if ($name != NULL){
						$db->query("UPDATE ".PLANETS." SET `name` = '".$name."' WHERE `id` = '".$id."';");
						$Log	.=	$lang['log_change_name_pla'].": ".$name."\n";}

					if ($buildings == 'on'){
						$db->query("UPDATE ".PLANETS." SET `metal_mine` = '0', `crystal_mine` = '0', `deuterium_sintetizer` = '0',
									`solar_plant` = '0', `fusion_plant` = '0', `robot_factory` = '0',
									`nano_factory` = '0', `hangar` = '0', `metal_store` = '0',
									`crystal_store` = '0', `deuterium_store` = '0', `laboratory` = '0',
									`terraformer` = '0', `ally_deposit` = '0', `silo` = '0', `mondbasis` = '0',
									`phalanx` = '0', `sprungtor` = '0', `last_jump_time` = '0' WHERE `id` = '".$id."';");
						$Log	.=	$lang['log_delete_all_edi']."\n";}

					if ($ships == 'on'){
						$db->query("UPDATE ".PLANETS." SET `small_ship_cargo` = '0', `big_ship_cargo` = '0', `light_hunter` = '0',
									`heavy_hunter` = '0', `crusher` = '0', `battle_ship` = '0',
									`colonizer` = '0', `recycler` = '0', `spy_sonde` = '0',
									`bomber_ship` = '0', `solar_satelit` = '0', `destructor` = '0',
									`dearth_star` = '0', `battleship` = '0', `supernova` = '0' WHERE `id` = '".$id."';");
						$Log	.=	$lang['log_delete_all_ships']."\n";}

					if ($defenses == 'on'){
						$db->query("UPDATE ".PLANETS." SET `misil_launcher` = '0', `small_laser` = '0', `big_laser` = '0',
									`gauss_canyon` = '0', `ionic_canyon` = '0', `buster_canyon` = '0',
									`small_protection_shield` = '0', `planet_protector` = '0', `big_protection_shield` = '0',
									`interceptor_misil` = '0', `interplanetary_misil` = '0' WHERE `id` = '".$id."';");
						$Log	.=	$lang['log_delete_all_def']."\n";}

					if ($c_hangar == 'on'){
						$db->query("UPDATE ".PLANETS." SET `b_hangar` = '0', `b_hangar_plus` = '0', `b_hangar_id` = '' WHERE `id` = '".$id."';");
						$Log	.=	$lang['log_delete_all_c_han']."\n";}


					if ($c_buildings == 'on'){
						$db->query("UPDATE ".PLANETS." SET `b_building` = '0', `b_building_id` = '' WHERE `id` = '".$id."';");
						$Log	.=	$lang['log_delete_all_c_edi']."\n";}


					$P	=	$db->fetch_array($db->query("SELECT * FROM ".PLANETS." WHERE `id` = '".$id."';"));

					if ($diameter != NULL && is_numeric($diameter) && $diameter > 0){
						$db->query("UPDATE ".PLANETS." SET `diameter` = '".$diameter."' WHERE `id` = '".$id."';");
						$Log	.=	$lang['log_change_diameter'].": ".$diameter."\n";}

					if ($fields != NULL && is_numeric($fields) && $fields > 0){
						$db->query("UPDATE ".PLANETS." SET `field_max` = '".$fields."' WHERE `id` = '".$id."';");
						$Log	.=	$lang['log_change_fields'].": ".$fields."\n";}

					if ($change_pos == 'on')
					{
						if (is_numeric($galaxy) && is_numeric($system) && is_numeric($planet) && $galaxy > 0 && $system > 0 && $planet > 0 &&
							$galaxy <= MAX_GALAXY_IN_WORLD && $system <= MAX_SYSTEM_IN_GALAXY && $planet <= MAX_PLANET_IN_SYSTEM)
						{
							$Queryyy	=	$db->fetch_array($db->query("SELECT id FROM ".PLANETS." WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND
											`planet` = '".$planet."' AND planet_type = '".$P['planet_type']."';"));

							if ($P['planet_type'] == '1')
							{
								if (!$Queryyy)
								{
									$db->query ("UPDATE ".PLANETS." SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."' WHERE
										`galaxy` = '".$P['galaxy']."' AND `system` = '".$P['system']."' AND `planet` = '".$P['planet']."';");

									$Name	=	$lang['log_planet_pos'];
								}
								else
								{
									$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_pla_error_planets3'].'</font></th></tr>';
								}
							}
							elseif ($P['planet_type'] == '3')
							{
								if ($Queryyy)
								{
									if ($Queryyy['id_luna'] == '0')
									{
										$db->query ("UPDATE ".PLANETS." SET `id_luna` = '0' WHERE `galaxy` = '".$P['galaxy']."' AND `system` = '".$P['system']."' AND
											`planet` = '".$P['planet']."' AND `planet_type` = '1';");
										$db->query ("UPDATE ".PLANETS." SET `id_luna` = '".$id."'  WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND
										`planet` = '".$planet."' AND planet_type = '1';");
										$db->query ("UPDATE ".PLANETS." SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."' 
										WHERE `id` = '".$id."';");

										$QMOON2	=	$db->fetch_array($db->query("SELECT id_level, id_owner FROM ".PLANETS." WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND
										`planet` = '".$planet."';"));

										$db->query ("UPDATE ".PLANETS." SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."',
										`id_owner` = '".$QMOON2['id_owner']."', `id_level` = '".$QMOON2['id_level']."' WHERE `id` = '".$id."' AND `planet_type` = '3';");
										$Name	=	$lang['log_moon_pos'];
									}
									else
									{
										$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_pla_error_planets4'].'</font></th></tr>';
									}
								}
								else
								{
									$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_pla_error_planets5'].'</font></th></tr>';
								}
							}

							$Log	.=	$lang['log_change_pla_pos'].$Name.": [".$galaxy.":".$system.":".$planet."]\n";
						}
						else
						{
							$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_only_numbers'].'</font></th></tr>';
						}
					}

					$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_pla_succes'].'</font></th></tr>';
					$parse['display2']	=	$Error;
				}
				else
				{
					$db->query("DELETE FROM ".PLANETS." WHERE id = '".$id."'", "planets");
					$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_pla_delete_planet_s'].'</font></th></tr>';
				}

					$Log	.=	$lang['log_to_planet'].$id."\n";

					LogFunction($Log, "PlanetsAndMoonsLog", $LogCanWork);
			 	}
			 	else
			 	{
					$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['only_numbers'].'</font></th></tr>';
			 	}
			}
			else
			{
				$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_forgiven_id'].'</font></th></tr>';
			}
		}

		display (parsetemplate(gettemplate("adm/EditorTPL/PlanetsMoonsBody"), $parse), false, '', true, false);
	break;

	case 'alliances':
		if ($_POST)
		{
			$id				=	$_POST['id'];
			$name			=	$_POST['name'];
			$changeleader	=	$_POST['changeleader'];
			$tag			=	$_POST['tag'];
			$externo		=	$_POST['externo'];
			$interno		=	$_POST['interno'];
			$solicitud		=	$_POST['solicitud'];
			$delete			=	$_POST['delete'];
			$delete_u		=	$_POST['delete_u'];

			if ($id != NULL)
			{
				$QueryF	=	$db->fetch_array($db->query("SELECT * FROM ".ALLIANCE." WHERE `id` = '".$id."';"));

			 	if ($QueryF)
			 	{
					$Log	.=	"\n".$lang['log_the_user'].$user['username']." ".$lang['log_modify_personal'].":\n";

					if ($name != NULL){
						$db->query("UPDATE ".ALLIANCE." SET `ally_name` = '".$name."' WHERE `id` = '".$id."';");
						$db->query("UPDATE ".USERS." SET `ally_name` = '".$name."' WHERE `ally_id` = '".$id."';");
						$Log	.=	$lang['log_name_of_ally'].": ".$name."\n";}

					if ($tag != NULL){
						$db->query("UPDATE ".ALLIANCE." SET `ally_tag` = '".$tag."' WHERE `id` = '".$id."';");
						$Log	.=	$lang['log_tag_of_ally'].": ".$tag."\n";}


					$i	=	0;
					$QueryF2	=	$db->fetch_array($db->query("SELECT * FROM ".USERS." WHERE `id` = '".$changeleader."';"));
					if ($QueryF2 && $changeleader != NULL && $QueryF2['ally_id'] == $id){
						$db->query("UPDATE ".ALLIANCE." SET `ally_owner` = '".$changeleader."' WHERE `id` = '".$id."';");
						$db->query("UPDATE ".USERS." SET `ally_rank_id` = '0' WHERE `id` = '".$changeleader."';");
						$Log	.=	$lang['log_idnewleader'].": ".$changeleader."\n";}
					elseif (!$QueryF2 && $changeleader != NULL){
						$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_ally_not_exist3'].'</font></th></tr>';
						$i++;}

					if ($externo != NULL){
						$db->query("UPDATE ".ALLIANCE." SET `ally_description` = '".$externo."' WHERE `id` = '".$id."';");
						$Log	.=	$lang['log_text_ext'].": ".$externo."\n";}

					if ($interno != NULL){
						$db->query("UPDATE ".ALLIANCE." SET `ally_text` = '".$interno."' WHERE `id` = '".$id."';");
						$Log	.=	$lang['log_text_int'].": ".$interno."\n";}

					if ($solicitud != NULL){
						$db->query("UPDATE ".ALLIANCE." SET `ally_request` = '".$solicitud."' WHERE `id` = '".$id."';");
						$Log	.=	$lang['log_text_sol'].": ".$solicitud."\n";}

					if ($delete == 'on'){
						$db->query("DELETE FROM ".ALLIANCE." WHERE `id` = '".$id."';");
						$db->query("UPDATE ".USERS." SET `ally_id` = '0', `ally_name` = '', `ally_request` = '0', `ally_rank_id` = '0', `ally_register_time` = '0',
							`ally_request` = '0' WHERE `ally_id` = '".$id."';");
						$Log	.=	$lang['log_ally_delete']."\n";}



					$QueryF3	=	$db->fetch_array($db->query("SELECT * FROM ".USERS." WHERE `id` = '".$delete_u."';"));
					if ($QueryF3 && $delete_u != NULL){
						$db->query("UPDATE ".ALLIANCE." SET `ally_members` = ally_members - 1 WHERE `id` = '".$id."';");
						$db->query("UPDATE ".USERS." SET `ally_id` = '0', `ally_name` = '', `ally_request` = '0', `ally_rank_id` = '0', `ally_register_time` = '0',
							`ally_request` = '0' WHERE `id` = '".$delete_u."' AND `ally_id` = '".$id."';");
						$Log	.=	$lang['log_id_user_expu'].": ".$delete_u."\n";}
					elseif (!$QueryF3 && $delete_u != NULL){
						$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_ally_not_exist2'].'</font></th></tr>';
						$i++;}

					if ($i == 0)
						$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_ally_succes'].'</font></th></tr>';
					else
						$parse['display']	=	$Error;


					$Log	.=	$lang['log_to_ally_whosid'].$id."\n";
					LogFunction($Log, "AllianceLog", $LogCanWork);

			 	}
			 	else
			 	{
					$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_ally_not_exist'].'</font></th></tr>';
			 	}
			}
			else
			{
				$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_forgiven_id'].'</font></th></tr>';
			}
		}

		display (parsetemplate(gettemplate("adm/EditorTPL/AllianceBody"), $parse), false, '', true, false);
	break;

	default:
	if ($user['authlevel'] == 3)
		$parse['changepersonal'] =
	'<tr>
		<th><a href="AccountEditorPage.php?page=personal'.$parse['getuser'].'"><img src="../styles/images/Adm/arrowright.png" width="16" height="10"/> '.$lang['ad_editor_personal'].'</a></th>
	</tr>';


	display(parsetemplate(gettemplate('adm/EditorTPL/EditorBody'), $parse), false, '', true, false);
}
?>