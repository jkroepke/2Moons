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
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.' . PHP_EXT);
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($EditUsers != 1) die();

$parse = $lang;	
			
switch($_GET['page'])
{
	case 'resources':
					
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
				$db->query( $QryUpdatePlanet);


				if ($id_dark != NULL)
				{
					$QryUpdateUser  = "UPDATE ".USERS." SET ";
					$QryUpdateUser .= "`darkmatter` = `darkmatter` + '". $dark ."' ";
					$QryUpdateUser .= "WHERE ";
					$QryUpdateUser .= "`id` = '". $id_dark ."' ";
					$db->query( $QryUpdateUser);
				}

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
				$db->query($QryUpdatePlanet);


				if ($id_dark != NULL)
				{
					$QryUpdateUser  = "UPDATE ".USERS." SET ";
					$QryUpdateUser .= "`darkmatter` = `darkmatter` - '". $dark ."' ";
					$QryUpdateUser .= "WHERE ";
					$QryUpdateUser .= "`id` = '". $id_dark ."' ";
					$db->query($QryUpdateUser);
				}

				$parse['display']	=	'<tr><th colspan="2"><font color=lime>'.$lang['ad_delete_sucess'].'</font></th></tr>';
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
			$id          		= $_POST['id'];
			$light_hunter       = $_POST['light_hunter'];
			$heavy_hunter    	= $_POST['heavy_hunter'];
			$small_ship_cargo	= $_POST['small_ship_cargo'];
			$big_ship_cargo     = $_POST['big_ship_cargo'];
			$crusher    		= $_POST['crusher'];
			$battle_ship        = $_POST['battle_ship'];
			$colonizer      	= $_POST['colonizer'];
			$recycler        	= $_POST['recycler'];
			$spy_sonde       	= $_POST['spy_sonde'];
			$bomber_ship      	= $_POST['bomber_ship'];
			$solar_satelit     	= $_POST['solar_satelit'];
			$destructor       	= $_POST['destructor'];
			$dearth_star       	= $_POST['dearth_star'];
			$battleship      	= $_POST['battleship'];
			$supernova      	= $_POST['supernova'];
			
			
			if(is_numeric($id) && is_numeric($light_hunter) && is_numeric($heavy_hunter) && is_numeric($small_ship_cargo) && is_numeric($big_ship_cargo) && 
				is_numeric($crusher) && is_numeric($battle_ship) && is_numeric($colonizer) && is_numeric($recycler) && is_numeric($spy_sonde) && 
				is_numeric($bomber_ship) && is_numeric($solar_satelit) && is_numeric($destructor) && is_numeric($dearth_star) && 
				is_numeric($battleship) && is_numeric($supernova))
			{
				if ($_POST['add'])
				{
					$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
					$QryUpdatePlanet .= "`small_ship_cargo` = `small_ship_cargo` + '". $small_ship_cargo ."', ";
					$QryUpdatePlanet .= "`battleship` = `battleship` + '". $battleship ."', ";
					$QryUpdatePlanet .= "`dearth_star` = `dearth_star` + '". $dearth_star ."', ";
					$QryUpdatePlanet .= "`destructor` = `destructor` + '". $destructor ."', ";
					$QryUpdatePlanet .= "`solar_satelit` = `solar_satelit` + '". $solar_satelit ."', ";
					$QryUpdatePlanet .= "`bomber_ship` = `bomber_ship` + '". $bomber_ship ."', ";
					$QryUpdatePlanet .= "`spy_sonde` = `spy_sonde` + '". $spy_sonde ."', ";
					$QryUpdatePlanet .= "`recycler` = `recycler` + '". $recycler ."', ";
					$QryUpdatePlanet .= "`colonizer` = `colonizer` + '". $colonizer ."', ";
					$QryUpdatePlanet .= "`battle_ship` = `battle_ship` + '". $battle_ship ."', ";
					$QryUpdatePlanet .= "`crusher` = `crusher` + '". $crusher ."', ";
					$QryUpdatePlanet .= "`heavy_hunter` = `heavy_hunter` + '". $heavy_hunter ."', ";
					$QryUpdatePlanet .= "`big_ship_cargo` = `big_ship_cargo` + '". $big_ship_cargo ."', ";
					$QryUpdatePlanet .= "`supernova` = `supernova` + '". $supernova ."', ";
					$QryUpdatePlanet .= "`light_hunter` = `light_hunter` + '". $light_hunter ."' ";
					$QryUpdatePlanet .= "WHERE ";
					$QryUpdatePlanet .= "`id` = '". $id ."' ";
					$db->query( $QryUpdatePlanet);

					$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_add_sucess_ships'].'</font></th></tr>';
				}
				elseif ($_POST['delete'])
				{
					$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
					$QryUpdatePlanet .= "`small_ship_cargo` = `small_ship_cargo` - '". $small_ship_cargo ."', ";
					$QryUpdatePlanet .= "`battleship` = `battleship` - '". $battleship ."', ";
					$QryUpdatePlanet .= "`dearth_star` = `dearth_star` - '". $dearth_star ."', ";
					$QryUpdatePlanet .= "`destructor` = `destructor` - '". $destructor ."', ";
					$QryUpdatePlanet .= "`solar_satelit` = `solar_satelit` - '". $solar_satelit ."', ";
					$QryUpdatePlanet .= "`bomber_ship` = `bomber_ship` - '". $bomber_ship ."', ";
					$QryUpdatePlanet .= "`spy_sonde` = `spy_sonde` - '". $spy_sonde ."', ";
					$QryUpdatePlanet .= "`recycler` = `recycler` - '". $recycler ."', ";
					$QryUpdatePlanet .= "`colonizer` = `colonizer` - '". $colonizer ."', ";
					$QryUpdatePlanet .= "`battle_ship` = `battle_ship` - '". $battle_ship ."', ";
					$QryUpdatePlanet .= "`crusher` = `crusher` - '". $crusher ."', ";
					$QryUpdatePlanet .= "`heavy_hunter` = `heavy_hunter` - '". $heavy_hunter ."', ";
					$QryUpdatePlanet .= "`big_ship_cargo` = `big_ship_cargo` - '". $big_ship_cargo ."', ";
					$QryUpdatePlanet .= "`supernova` = `supernova` - '". $supernova ."', ";
					$QryUpdatePlanet .= "`light_hunter` = `light_hunter` - '". $light_hunter ."' ";
					$QryUpdatePlanet .= "WHERE ";
					$QryUpdatePlanet .= "`id` = '". $id ."' ";
					$db->query( $QryUpdatePlanet, "planets");

					$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_delete_sucess_ships'].'</font></th></tr>';
				}
			}
			else
			{
				$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_only_numbers'].'</font></th></tr>';
			}
		}
			
		display (parsetemplate(gettemplate("adm/EditorTPL/ShipsBody"), $parse), false, '', true, false);
	break;
		
	case'defenses':
		if ($_POST)
		{
			$id          				= $_POST['id'];
			$misil_launcher       		= $_POST['misil_launcher'];
			$small_laser    			= $_POST['small_laser'];
			$big_laser        			= $_POST['big_laser'];
			$gauss_canyon        		= $_POST['gauss_canyon'];
			$ionic_canyon    			= $_POST['ionic_canyon'];
			$buster_canyon        		= $_POST['buster_canyon'];
			$small_protection_shield	= $_POST['small_protection_shield'];
			$big_protection_shield      = $_POST['big_protection_shield'];
			$planet_protector      		= $_POST['planet_protector'];
			$interceptor_misil       	= $_POST['interceptor_misil'];
			$interplanetary_misil      	= $_POST['interplanetary_misil'];
			
			if(is_numeric($id) && is_numeric($misil_launcher) && is_numeric($small_laser) && is_numeric($big_laser) && is_numeric($gauss_canyon) && 
				is_numeric($ionic_canyon) && is_numeric($buster_canyon) && is_numeric($small_protection_shield) && is_numeric($big_protection_shield) && 
				is_numeric($interceptor_misil) && is_numeric($interplanetary_misil) && is_numeric($planet_protector))
			{
				if ($_POST['add'])
				{
					$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
					$QryUpdatePlanet .= "`misil_launcher` = `misil_launcher` + '". $misil_launcher ."', ";
					$QryUpdatePlanet .= "`small_laser` = `small_laser` + '". $small_laser ."', ";
					$QryUpdatePlanet .= "`big_laser` = `big_laser` + '". $big_laser ."', ";
					$QryUpdatePlanet .= "`gauss_canyon` = `gauss_canyon` + '". $gauss_canyon ."', ";
					$QryUpdatePlanet .= "`ionic_canyon` = `ionic_canyon` + '". $ionic_canyon ."', ";
					$QryUpdatePlanet .= "`buster_canyon` = `buster_canyon` + '". $buster_canyon ."', ";
					$QryUpdatePlanet .= "`small_protection_shield` = `small_protection_shield` + '". $small_protection_shield ."', ";
					$QryUpdatePlanet .= "`big_protection_shield` = `big_protection_shield` + '". $big_protection_shield ."', ";
					$QryUpdatePlanet .= "`planet_protector` = `planet_protector` + '". $planet_protector ."', ";
					$QryUpdatePlanet .= "`interceptor_misil` = `interceptor_misil` + '". $interceptor_misil ."', ";
					$QryUpdatePlanet .= "`interplanetary_misil` = `interplanetary_misil` + '". $interplanetary_misil ."' ";
					$QryUpdatePlanet .= "WHERE ";
					$QryUpdatePlanet .= "`id` = '". $id ."' ";
					$db->query( $QryUpdatePlanet);

					$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_add_defenses_succes'].'</font></th></tr>';
				}
				elseif ($_POST['delete'])
				{
					$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
					$QryUpdatePlanet .= "`misil_launcher` = `misil_launcher` - '". $misil_launcher ."', ";
					$QryUpdatePlanet .= "`small_laser` = `small_laser` - '". $small_laser ."', ";
					$QryUpdatePlanet .= "`big_laser` = `big_laser` - '". $big_laser ."', ";
					$QryUpdatePlanet .= "`gauss_canyon` = `gauss_canyon` - '". $gauss_canyon ."', ";
					$QryUpdatePlanet .= "`ionic_canyon` = `ionic_canyon` - '". $ionic_canyon ."', ";
					$QryUpdatePlanet .= "`buster_canyon` = `buster_canyon` - '". $buster_canyon ."', ";
					$QryUpdatePlanet .= "`small_protection_shield` = `small_protection_shield` - '". $small_protection_shield ."', ";
					$QryUpdatePlanet .= "`big_protection_shield` = `big_protection_shield` - '". $big_protection_shield ."', ";
					$QryUpdatePlanet .= "`planet_protector` = `planet_protector` - '". $planet_protector ."', ";
					$QryUpdatePlanet .= "`interceptor_misil` = `interceptor_misil` - '". $interceptor_misil ."', ";
					$QryUpdatePlanet .= "`interplanetary_misil` = `interplanetary_misil` - '". $interplanetary_misil ."' ";
					$QryUpdatePlanet .= "WHERE ";
					$QryUpdatePlanet .= "`id` = '". $id ."' ";
					$db->query( $QryUpdatePlanet);

					$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_delete_defenses_succes'].'</font></th></tr>';
				}
			}
			else
			{
				$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_only_numbers'].'</font></th></tr>';
			}
		}
		
		display (parsetemplate(gettemplate("adm/EditorTPL/DefensesBody"), $parse), false, '', true, false);
	break;

	case'buildings':
		if ($_POST)
		{
			$id          			= $_POST['id'];
			$metal_mine       		= $_POST['metal_mine'];
			$crystal_mine    		= $_POST['crystal_mine'];
			$deuterium_sintetizer	= $_POST['deuterium_sintetizer'];
			$solar_plant        	= $_POST['solar_plant'];
			$fusion_plant    		= $_POST['fusion_plant'];
			$robot_factory        	= $_POST['robot_factory'];
			$nano_factory      		= $_POST['nano_factory'];
			$hangar        			= $_POST['hangar'];
			$metal_store       		= $_POST['metal_store'];
			$crystal_store      	= $_POST['crystal_store'];
			$deuterium_store     	= $_POST['deuterium_store'];
			$laboratory       		= $_POST['laboratory'];
			$terraformer       		= $_POST['terraformer'];
			$ally_deposit      		= $_POST['ally_deposit'];
			$silo      				= $_POST['silo'];
			$mondbasis       		= $_POST['mondbasis'];
			$phalanx      			= $_POST['phalanx'];
			$sprungtor      		= $_POST['sprungtor'];

			if(is_numeric($id) && is_numeric($metal_mine) && is_numeric($crystal_mine) && is_numeric($deuterium_sintetizer) && is_numeric($solar_plant) && 
				is_numeric($fusion_plant) && is_numeric($robot_factory) && is_numeric($nano_factory) && is_numeric($hangar) && 
				is_numeric($metal_store) && is_numeric($crystal_store) && is_numeric($deuterium_store) && is_numeric($laboratory) && 
				is_numeric($terraformer)&& is_numeric($ally_deposit) && is_numeric($silo) && is_numeric($mondbasis) && 
				is_numeric($phalanx) && is_numeric($sprungtor))
			{
				$QueryFind	=	$db->fetch_array($db->query("SELECT `planet_type` FROM ".PLANETS." WHERE `id` = '".$id."';"));
				
				if ($_POST['add'])
				{
					$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
					$QryUpdatePlanet .= "`metal_mine` = `metal_mine` + '". $metal_mine ."', ";
					$QryUpdatePlanet .= "`crystal_mine` = `crystal_mine` + '". $crystal_mine ."', ";
					$QryUpdatePlanet .= "`deuterium_sintetizer` = `deuterium_sintetizer` + '". $deuterium_sintetizer ."', ";
					$QryUpdatePlanet .= "`solar_plant` = `solar_plant` + '". $solar_plant ."', ";
					$QryUpdatePlanet .= "`fusion_plant` = `fusion_plant` + '". $fusion_plant ."', ";
					$QryUpdatePlanet .= "`robot_factory` = `robot_factory` + '". $robot_factory ."', ";
					$QryUpdatePlanet .= "`nano_factory` = `nano_factory` + '". $nano_factory ."', ";
					$QryUpdatePlanet .= "`hangar` = `hangar` + '". $hangar ."', ";
					$QryUpdatePlanet .= "`metal_store` = `metal_store` + '". $metal_store ."', ";
					$QryUpdatePlanet .= "`crystal_store` = `crystal_store` + '". $crystal_store ."', ";
					$QryUpdatePlanet .= "`deuterium_store` = `deuterium_store` + '". $deuterium_store ."', ";
					$QryUpdatePlanet .= "`laboratory` = `laboratory` + '". $laboratory ."', ";
					$QryUpdatePlanet .= "`terraformer` = `terraformer` + '". $terraformer ."', ";
					$QryUpdatePlanet .= "`ally_deposit` = `ally_deposit` + '". $ally_deposit ."', ";
					$QryUpdatePlanet .= "`silo` = `silo` + '". $silo ."' ";
					$QryUpdatePlanet .= "WHERE ";
					$QryUpdatePlanet .= "`id` = '". $id ."' ";
					$db->query( $QryUpdatePlanet);
					
					if ($mondbasis or $phalanx or $sprungtor)
					{
						if ($QueryFind['planet_type']	==	'3')
						{
							$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
							$QryUpdatePlanet .= "`mondbasis` = `mondbasis` + '". $mondbasis ."', ";
							$QryUpdatePlanet .= "`phalanx` = `phalanx` + '". $phalanx ."', ";
							$QryUpdatePlanet .= "`sprungtor` = `sprungtor` + '". $sprungtor ."' ";
							$QryUpdatePlanet .= "WHERE ";
							$QryUpdatePlanet .= "`id` = '". $id ."' ";
							$db->query( $QryUpdatePlanet);
							
							if ($mondbasis > 0)
							{
								$Sum	=	$mondbasis * FIELDS_BY_MOONBASIS_LEVEL;
								$db->query("UPDATE ".PLANETS." SET `field_max` = field_max + '".$Sum."', `field_current` = field_current + '".$mondbasis."';");
							}
						}
						else
						{
							$parse['display2']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_error_moon_only'].'</font></th></tr>';
						}
					}

					$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_add_succes'].'</font></th></tr>';
				}
				elseif ($_POST['delete'])
				{
					$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
					$QryUpdatePlanet .= "`metal_mine` = `metal_mine` - '". $metal_mine ."', ";
					$QryUpdatePlanet .= "`crystal_mine` = `crystal_mine` - '". $crystal_mine ."', ";
					$QryUpdatePlanet .= "`deuterium_sintetizer` = `deuterium_sintetizer` - '". $deuterium_sintetizer ."', ";
					$QryUpdatePlanet .= "`solar_plant` = `solar_plant` - '". $solar_plant ."', ";
					$QryUpdatePlanet .= "`fusion_plant` = `fusion_plant` - '". $fusion_plant ."', ";
					$QryUpdatePlanet .= "`robot_factory` = `robot_factory` - '". $robot_factory ."', ";
					$QryUpdatePlanet .= "`nano_factory` = `nano_factory` - '". $nano_factory ."', ";
					$QryUpdatePlanet .= "`hangar` = `hangar` - '". $hangar ."', ";
					$QryUpdatePlanet .= "`metal_store` = `metal_store` - '". $metal_store ."', ";
					$QryUpdatePlanet .= "`crystal_store` = `crystal_store` - '". $crystal_store ."', ";
					$QryUpdatePlanet .= "`deuterium_store` = `deuterium_store` - '". $deuterium_store ."', ";
					$QryUpdatePlanet .= "`laboratory` = `laboratory` - '". $laboratory ."', ";
					$QryUpdatePlanet .= "`terraformer` = `terraformer` - '". $terraformer ."', ";
					$QryUpdatePlanet .= "`ally_deposit` = `ally_deposit` - '". $ally_deposit ."', ";
					$QryUpdatePlanet .= "`silo` = `silo` - '". $silo ."' ";
					$QryUpdatePlanet .= "WHERE ";
					$QryUpdatePlanet .= "`id` = '". $id ."' ";
					$db->query( $QryUpdatePlanet);
					
					
					if ($mondbasis or $phalanx or $sprungtor)
					{
						if ($QueryFind['planet_type']	==	'3')
						{
							$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
							$QryUpdatePlanet .= "`mondbasis` = `mondbasis` - '". $mondbasis ."', ";
							$QryUpdatePlanet .= "`phalanx` = `phalanx` - '". $phalanx ."', ";
							$QryUpdatePlanet .= "`sprungtor` = `sprungtor` - '". $sprungtor ."' ";
							$QryUpdatePlanet .= "WHERE ";
							$QryUpdatePlanet .= "`id` = '". $id ."' ";
							$db->query( $QryUpdatePlanet);
							
							if ($mondbasis > 0)
							{
								$Sum	=	$mondbasis * FIELDS_BY_MOONBASIS_LEVEL;
								$db->query("UPDATE ".PLANETS." SET `field_max` = field_max - '".$Sum."', `field_current` = field_current - '".$mondbasis."';");
							}
						}
						else
						{
							$parse['display2']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_error_moon_only'].'</font></th></tr>';
						}
					}

					$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_delete_succes'].'</font></th></tr>';
				}
			}
			else
			{
				$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_only_numbers'].'</font></th></tr>';
			}
		}
			
		display (parsetemplate(gettemplate("adm/EditorTPL/BuildingsBody"), $parse), false, '', true, false);
	break;
		
	case'researchs':
		if ($_POST)
		{
			$id          			= $_POST['id'];
			$spy_tech       		= $_POST['spy_tech'];
			$computer_tech    		= $_POST['computer_tech'];
			$military_tech        	= $_POST['military_tech'];
			$defence_tech        	= $_POST['defence_tech'];
			$shield_tech    		= $_POST['shield_tech'];
			$energy_tech        	= $_POST['energy_tech'];
			$hyperspace_tech      	= $_POST['hyperspace_tech'];
			$combustion_tech        = $_POST['combustion_tech'];
			$impulse_motor_tech     = $_POST['impulse_motor_tech'];
			$hyperspace_motor_tech  = $_POST['hyperspace_motor_tech'];
			$laser_tech     		= $_POST['laser_tech'];
			$ionic_tech       		= $_POST['ionic_tech'];
			$buster_tech       		= $_POST['buster_tech'];
			$intergalactic_tech     = $_POST['intergalactic_tech'];
			$expedition_tech     	= $_POST['expedition_tech'];
			$graviton_tech     		= $_POST['graviton_tech'];
			
			if(is_numeric($id) && is_numeric($spy_tech) && is_numeric($computer_tech) && is_numeric($military_tech) && is_numeric($defence_tech) && 
				is_numeric($shield_tech) && is_numeric($energy_tech) && is_numeric($hyperspace_tech) && is_numeric($combustion_tech) && 
				is_numeric($impulse_motor_tech) && is_numeric($hyperspace_motor_tech) && is_numeric($laser_tech) && is_numeric($ionic_tech) && 
				is_numeric($buster_tech)&& is_numeric($intergalactic_tech) && is_numeric($expedition_tech) && is_numeric($graviton_tech))
			{

				if ($_POST['add'])
				{
					$QryUpdatePlanet  = "UPDATE ".USERS." SET ";
					$QryUpdatePlanet .= "`spy_tech` = `spy_tech` + '". $spy_tech ."', ";
					$QryUpdatePlanet .= "`computer_tech` = `computer_tech` + '". $computer_tech ."', ";
					$QryUpdatePlanet .= "`military_tech` = `military_tech` + '". $military_tech ."', ";
					$QryUpdatePlanet .= "`defence_tech` = `defence_tech` + '". $defence_tech ."', ";
					$QryUpdatePlanet .= "`shield_tech` = `shield_tech` + '". $shield_tech ."', ";
					$QryUpdatePlanet .= "`energy_tech` = `energy_tech` + '". $energy_tech ."', ";
					$QryUpdatePlanet .= "`hyperspace_tech` = `hyperspace_tech` + '". $hyperspace_tech ."', ";
					$QryUpdatePlanet .= "`combustion_tech` = `combustion_tech` + '". $combustion_tech ."', ";
					$QryUpdatePlanet .= "`impulse_motor_tech` = `impulse_motor_tech` + '". $impulse_motor_tech ."', ";
					$QryUpdatePlanet .= "`hyperspace_motor_tech` = `hyperspace_motor_tech` + '". $hyperspace_motor_tech ."', ";
					$QryUpdatePlanet .= "`laser_tech` = `laser_tech` + '". $laser_tech ."', ";
					$QryUpdatePlanet .= "`ionic_tech` = `ionic_tech` + '". $ionic_tech ."', ";
					$QryUpdatePlanet .= "`buster_tech` = `buster_tech` + '". $buster_tech ."', ";
					$QryUpdatePlanet .= "`intergalactic_tech` = `intergalactic_tech` + '". $intergalactic_tech ."', ";
					$QryUpdatePlanet .= "`expedition_tech` = `expedition_tech` + '". $expedition_tech ."', ";
					$QryUpdatePlanet .= "`graviton_tech` = `graviton_tech` + '". $graviton_tech ."' ";
					$QryUpdatePlanet .= "WHERE ";
					$QryUpdatePlanet .= "`id` = '". $id ."' ";
					$db->query( $QryUpdatePlanet);

					$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_add_succes'].'</font></th></tr>';
				}
				elseif ($_POST['delete'])
				{
					$QryUpdatePlanet  = "UPDATE ".USERS." SET ";
					$QryUpdatePlanet .= "`spy_tech` = `spy_tech` - '". $spy_tech ."', ";
					$QryUpdatePlanet .= "`computer_tech` = `computer_tech` - '". $computer_tech ."', ";
					$QryUpdatePlanet .= "`military_tech` = `military_tech` - '". $military_tech ."', ";
					$QryUpdatePlanet .= "`defence_tech` = `defence_tech` - '". $defence_tech ."', ";
					$QryUpdatePlanet .= "`shield_tech` = `shield_tech` - '". $shield_tech ."', ";
					$QryUpdatePlanet .= "`energy_tech` = `energy_tech` - '". $energy_tech ."', ";
					$QryUpdatePlanet .= "`hyperspace_tech` = `hyperspace_tech` - '". $hyperspace_tech ."', ";
					$QryUpdatePlanet .= "`combustion_tech` = `combustion_tech` - '". $combustion_tech ."', ";
					$QryUpdatePlanet .= "`impulse_motor_tech` = `impulse_motor_tech` - '". $impulse_motor_tech ."', ";
					$QryUpdatePlanet .= "`hyperspace_motor_tech` = `hyperspace_motor_tech` - '". $hyperspace_motor_tech ."', ";
					$QryUpdatePlanet .= "`laser_tech` = `laser_tech` - '". $laser_tech ."', ";
					$QryUpdatePlanet .= "`ionic_tech` = `ionic_tech` - '". $ionic_tech ."', ";
					$QryUpdatePlanet .= "`buster_tech` = `buster_tech` - '". $buster_tech ."', ";
					$QryUpdatePlanet .= "`intergalactic_tech` = `intergalactic_tech` - '". $intergalactic_tech ."', ";
					$QryUpdatePlanet .= "`expedition_tech` = `expedition_tech` - '". $expedition_tech ."', ";
					$QryUpdatePlanet .= "`graviton_tech` = `graviton_tech` - '". $graviton_tech ."' ";
					$QryUpdatePlanet .= "WHERE ";
					$QryUpdatePlanet .= "`id` = '". $id ."' ";
					$db->query( $QryUpdatePlanet);

					$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_delete_succes'].'</font></th></tr>';
				}
			}
			else
			{
				$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_only_numbers'].'</font></th></tr>';
			}
		}

		display (parsetemplate(gettemplate("adm/EditorTPL/ResearchBody"), $parse), false, '', true, false);
	break;
	
	case 'personal':		
		if ($_POST)
		{
			if(!$_POST['id'])
			{
				$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_forgiven_id'].'</font></th></tr>';
			}
			else
			{					
				if($_POST['username'] != NULL)
					$db->query("UPDATE ".USERS." SET `username` = '".$_POST['username']."' WHERE `id` = '".$_POST['id']."';");
				
				if($_POST['email'] != NULL)
					$db->query("UPDATE ".USERS." SET `email` = '".$_POST['email']."' WHERE `id` = '".$_POST['id']."';");
					
				if($_POST['email_2'] != NULL)
					$db->query("UPDATE ".USERS." SET `email_2` = '".$_POST['email_2']."' WHERE `id` = '".$_POST['id']."';");
					
				if($_POST['password'] != NULL)
					$db->query("UPDATE ".USERS." SET `password` = '".md5($_POST['password'])."' WHERE `id` = '".$_POST['id']."';");
					
			
				$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_personal_succes'].'</font></th></tr>';
			}
		}
		display (parsetemplate(gettemplate("adm/EditorTPL/PersonalBody"), $parse), false, '', true, false);
	break;
	
	case'officiers':
		if ($_POST)
		{
			$id          		= $_POST['id'];
			$rpg_geologue       = $_POST['rpg_geologue'];
			$rpg_amiral    		= $_POST['rpg_amiral'];
			$rpg_ingenieur      = $_POST['rpg_ingenieur'];
			$rpg_technocrate    = $_POST['rpg_technocrate'];
			$rpg_espion    		= $_POST['rpg_espion'];
			$rpg_constructeur   = $_POST['rpg_constructeur'];
			$rpg_scientifique   = $_POST['rpg_scientifique'];
			$rpg_commandant     = $_POST['rpg_commandant'];
			$rpg_stockeur     	= $_POST['rpg_stockeur'];
			$rpg_defenseur  	= $_POST['rpg_defenseur'];
			$rpg_destructeur    = $_POST['rpg_destructeur'];
			$rpg_general       	= $_POST['rpg_general'];
			$rpg_bunker       	= $_POST['rpg_bunker'];
			$rpg_raideur     	= $_POST['rpg_raideur'];
			$rpg_empereur     	= $_POST['rpg_empereur'];
			
			if(is_numeric($id) && is_numeric($rpg_geologue) && is_numeric($rpg_amiral) && is_numeric($rpg_ingenieur) && is_numeric($rpg_technocrate) && 
				is_numeric($rpg_espion) && is_numeric($rpg_constructeur) && is_numeric($rpg_scientifique) && is_numeric($rpg_commandant) && 
				is_numeric($rpg_stockeur) && is_numeric($rpg_defenseur) && is_numeric($rpg_destructeur) && is_numeric($rpg_general) && 
				is_numeric($rpg_bunker)&& is_numeric($rpg_raideur) && is_numeric($rpg_empereur))
			{

				if ($_POST['add'])
				{
					$QryUpdatePlanet  = "UPDATE ".USERS." SET ";
					$QryUpdatePlanet .= "`rpg_geologue` = `rpg_geologue` + '". $rpg_geologue ."', ";
					$QryUpdatePlanet .= "`rpg_amiral` = `rpg_amiral` + '". $rpg_amiral ."', ";
					$QryUpdatePlanet .= "`rpg_ingenieur` = `rpg_ingenieur` + '". $rpg_ingenieur ."', ";
					$QryUpdatePlanet .= "`rpg_technocrate` = `rpg_technocrate` + '". $rpg_technocrate ."', ";
					$QryUpdatePlanet .= "`rpg_espion` = `rpg_espion` + '". $rpg_espion ."', ";
					$QryUpdatePlanet .= "`rpg_constructeur` = `rpg_constructeur` + '". $rpg_constructeur ."', ";
					$QryUpdatePlanet .= "`rpg_scientifique` = `rpg_scientifique` + '". $rpg_scientifique ."', ";
					$QryUpdatePlanet .= "`rpg_commandant` = `rpg_commandant` + '". $rpg_commandant ."', ";
					$QryUpdatePlanet .= "`rpg_stockeur` = `rpg_stockeur` + '". $rpg_stockeur ."', ";
					$QryUpdatePlanet .= "`rpg_defenseur` = `rpg_defenseur` + '". $rpg_defenseur ."', ";
					$QryUpdatePlanet .= "`rpg_destructeur` = `rpg_destructeur` + '". $rpg_destructeur ."', ";
					$QryUpdatePlanet .= "`rpg_general` = `rpg_general` + '". $rpg_general ."', ";
					$QryUpdatePlanet .= "`rpg_bunker` = `rpg_bunker` + '". $rpg_bunker ."', ";
					$QryUpdatePlanet .= "`rpg_raideur` = `rpg_raideur` + '". $rpg_raideur ."', ";
					$QryUpdatePlanet .= "`rpg_empereur` = `rpg_empereur` + '". $rpg_empereur ."' ";
					$QryUpdatePlanet .= "WHERE ";
					$QryUpdatePlanet .= "`id` = '". $id ."' ";
					$db->query( $QryUpdatePlanet);

					$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_offi_succes_add'].'</font></th></tr>';
				}
				elseif ($_POST['delete'])
				{
					$QryUpdatePlanet  = "UPDATE ".USERS." SET ";
					$QryUpdatePlanet .= "`rpg_geologue` = `rpg_geologue` - '". $rpg_geologue ."', ";
					$QryUpdatePlanet .= "`rpg_amiral` = `rpg_amiral` - '". $rpg_amiral ."', ";
					$QryUpdatePlanet .= "`rpg_ingenieur` = `rpg_ingenieur` - '". $rpg_ingenieur ."', ";
					$QryUpdatePlanet .= "`rpg_technocrate` = `rpg_technocrate` - '". $rpg_technocrate ."', ";
					$QryUpdatePlanet .= "`rpg_espion` = `rpg_espion` - '". $rpg_espion ."', ";
					$QryUpdatePlanet .= "`rpg_constructeur` = `rpg_constructeur` - '". $rpg_constructeur ."', ";
					$QryUpdatePlanet .= "`rpg_scientifique` = `rpg_scientifique` - '". $rpg_scientifique ."', ";
					$QryUpdatePlanet .= "`rpg_commandant` = `rpg_commandant` - '". $rpg_commandant ."', ";
					$QryUpdatePlanet .= "`rpg_stockeur` = `rpg_stockeur` - '". $rpg_stockeur ."', ";
					$QryUpdatePlanet .= "`rpg_defenseur` = `rpg_defenseur` - '". $rpg_defenseur ."', ";
					$QryUpdatePlanet .= "`rpg_destructeur` = `rpg_destructeur` - '". $rpg_destructeur ."', ";
					$QryUpdatePlanet .= "`rpg_general` = `rpg_general` - '". $rpg_general ."', ";
					$QryUpdatePlanet .= "`rpg_bunker` = `rpg_bunker` - '". $rpg_bunker ."', ";
					$QryUpdatePlanet .= "`rpg_raideur` = `rpg_raideur` - '". $rpg_raideur ."', ";
					$QryUpdatePlanet .= "`rpg_empereur` = `rpg_empereur` - '". $rpg_empereur ."' ";
					$QryUpdatePlanet .= "WHERE ";
					$QryUpdatePlanet .= "`id` = '". $id ."' ";
					$db->query( $QryUpdatePlanet);

					$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_offi_succes_delete'].'</font></th></tr>';
				}
			}
			else
			{
				$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_only_numbers'].'</font></th></tr>';
			}
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
			
			if ($id != NULL)
			{
			 	if (is_numeric($id))
			 	{
					if ($name != NULL)
						$db->query("UPDATE ".PLANETS." SET `name` = '".$name."' WHERE `id` = '".$id."'", "planets");					
					
					if ($buildings == 'on')
						$db->query("UPDATE ".PLANETS." SET `metal_mine` = '0', `crystal_mine` = '0', `deuterium_sintetizer` = '0',
									`solar_plant` = '0', `fusion_plant` = '0', `robot_factory` = '0',
									`nano_factory` = '0', `hangar` = '0', `metal_store` = '0',
									`crystal_store` = '0', `deuterium_store` = '0', `laboratory` = '0',
									`terraformer` = '0', `ally_deposit` = '0', `silo` = '0', `mondbasis` = '0', 
									`phalanx` = '0', `sprungtor` = '0', `last_jump_time` = '0' WHERE `id` = '".$id."';");
									
					if ($ships == 'on')
						$db->query("UPDATE ".PLANETS." SET `small_ship_cargo` = '0', `big_ship_cargo` = '0', `light_hunter` = '0',
									`heavy_hunter` = '0', `crusher` = '0', `battle_ship` = '0',
									`colonizer` = '0', `recycler` = '0', `spy_sonde` = '0',
									`bomber_ship` = '0', `solar_satelit` = '0', `destructor` = '0',
									`dearth_star` = '0', `battleship` = '0', `supernova` = '0' WHERE `id` = '".$id."';");	
									
					if ($defenses == 'on')
						$db->query("UPDATE ".PLANETS." SET `misil_launcher` = '0', `small_laser` = '0', `big_laser` = '0',
									`gauss_canyon` = '0', `ionic_canyon` = '0', `buster_canyon` = '0',
									`small_protection_shield` = '0', `planet_protector` = '0', `big_protection_shield` = '0',
									`interceptor_misil` = '0', `interplanetary_misil` = '0' WHERE `id` = '".$id."';");
									
					if ($c_hangar == 'on')
						$db->query("UPDATE ".PLANETS." SET `b_hangar` = '0', `b_hangar_plus` = '0', `b_hangar_id` = '' WHERE `id` = '".$id."';");
						
						
					if ($c_buildings == 'on')
						$db->query("UPDATE ".PLANETS." SET `b_building` = '0', `b_building_id` = '' WHERE `id` = '".$id."';");
						
						
					$P	=	$db->fetch_array($db->query("SELECT * FROM ".PLANETS." WHERE `id` = '".$id."';"));
					
					if ($diameter != NULL && is_numeric($diameter) && $diameter > 0)
						$db->query("UPDATE ".PLANETS." SET `diameter` = '".$diameter."' WHERE `id` = '".$id."';");
						
					if ($fields != NULL && is_numeric($fields) && $fields > 0)
						$db->query("UPDATE ".PLANETS." SET `field_max` = '".$fields."' WHERE `id` = '".$id."';");
						
					if ($change_pos == 'on')
					{
						if (is_numeric($galaxy) && is_numeric($system) && is_numeric($planet) && $galaxy > 0 && $system > 0 && $planet > 0 &&
							$galaxy <= MAX_GALAXY_IN_WORLD && $system <= MAX_SYSTEM_IN_GALAXY && $planet <= MAX_PLANET_IN_SYSTEM)
						{
							$Queryyy	=	$db->fetch_array($db->query("SELECT id_luna FROM ".PLANETS." WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND 
											`planet` = '".$planet."';"));
									
							if ($P['planet_type'] == '1')
							{
								if (!$Queryyy)
								{					
									if ($Queryyy['id_luna'] != '0')
									{									
										$db->query ("UPDATE ".PLANETS." SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."' WHERE
										`galaxy` = '".$P['galaxy']."' AND `system` = '".$P['system']."' AND `planet` = '".$P['planet']."' AND `planet_type` = '3';");
									}
								
									$db->query ("UPDATE ".PLANETS." SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."' WHERE
										`id` = '".$id."';");
										
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
											
										$db->query ("UPDATE ".PLANETS." SET `id_luna` = '".$id."' WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND 
											`planet` = '".$planet."' AND `planet_type` = '1';");
											
								
										$QMOON2	=	$db->fetch_array($db->query("SELECT id_owner,id_level FROM ".PLANETS." WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND 
										`planet` = '".$planet."';"));
										
										$db->query ("UPDATE ".PLANETS." SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."', 
										`id_owner` = '".$QMOON2['id_owner']."', `id_level` = '".$QMOON2['id_level']."' WHERE `id` = '".$id."' AND `planet_type` = '3';");
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
					$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_only_numbers'].'</font></th></tr>';
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
					if ($name != NULL){
						$db->query("UPDATE ".ALLIANCE." SET `ally_name` = '".$name."' WHERE `id` = '".$id."';");
						$db->query("UPDATE ".USERS." SET `ally_name` = '".$name."' WHERE `ally_id` = '".$id."';");}
						
					if ($tag != NULL)
						$db->query("UPDATE ".ALLIANCE." SET `ally_tag` = '".$tag."' WHERE `id` = '".$id."';");
						
						
					$i	=	0;
					$QueryF2	=	$db->fetch_array($db->query("SELECT * FROM ".USERS." WHERE `id` = '".$changeleader."';"));
					if ($QueryF2 && $changeleader != NULL && $QueryF2['ally_id'] == $id){
						$db->query("UPDATE ".ALLIANCE." SET `ally_owner` = '".$changeleader."' WHERE `id` = '".$id."';");
						$db->query("UPDATE ".USERS." SET `ally_rank_id` = '0' WHERE `id` = '".$changeleader."';");}
					elseif (!$QueryF2 && $changeleader != NULL){
						$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_ally_not_exist3'].'</font></th></tr>';
						$i++;}
						
					if ($externo != NULL)
						$db->query("UPDATE ".ALLIANCE." SET `ally_description` = '".$externo."' WHERE `id` = '".$id."';");
						
					if ($interno != NULL)
						$db->query("UPDATE ".ALLIANCE." SET `ally_text` = '".$interno."' WHERE `id` = '".$id."';");
						
					if ($solicitud != NULL)
						$db->query("UPDATE ".ALLIANCE." SET `ally_request` = '".$solicitud."' WHERE `id` = '".$id."';");
						
					if ($delete == 'on'){
						$db->query("DELETE FROM ".ALLIANCE." WHERE `id` = '".$id."';");
						$db->query("UPDATE ".USERS." SET `ally_id` = '0', `ally_name` = '', `ally_request` = '0', `ally_rank_id` = '0', `ally_register_time` = '0',
							`ally_request` = '0' WHERE `ally_id` = '".$id."';");}
						
						
						
					$QueryF3	=	$db->fetch_array($db->query("SELECT * FROM ".USERS." WHERE `id` = '".$delete_u."';"));
					if ($QueryF3 && $delete_u != NULL){
						$db->query("UPDATE ".ALLIANCE." SET `ally_members` = ally_members - 1 WHERE `id` = '".$id."';");
						$db->query("UPDATE ".USERS." SET `ally_id` = '0', `ally_name` = '', `ally_request` = '0', `ally_rank_id` = '0', `ally_register_time` = '0',
							`ally_request` = '0' WHERE `id` = '".$delete_u."' AND `ally_id` = '".$id."';");}
					elseif (!$QueryF3 && $delete_u != NULL){
						$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_ally_not_exist2'].'</font></th></tr>';
						$i++;}						
					
					if ($i == 0)
						$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_ally_succes'].'</font></th></tr>';
					else
						$parse['display']	=	$Error;
					
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
	display(parsetemplate(gettemplate('adm/EditorTPL/EditorBody'), $parse), false, '', true, false);
}
?>