<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowAccountDataPage()
{
	global $USER, $reslist, $resource, $LNG;

	$template 	= new template();

	$id_u	= HTTP::_GP('id_u', 0);
	if (!empty($id_u))
	{
		$OnlyQueryLogin 	= $GLOBALS['DATABASE']->uniquequery("SELECT `id`, `authlevel` FROM ".USERS." WHERE `id` = '".$id_u."' AND `universe` = '".$_SESSION['adminuni']."';");

		if(!isset($OnlyQueryLogin))
		{
			exit($template->message($LNG['ac_username_doesnt'], '?page=accoutdata'));
		}
		else
		{
			foreach(array_merge($reslist['officier'], $reslist['tech']) as $ID)
			{
				$SpecifyItemsUQ	.= "u.`".$resource[$ID]."`,";
			}
		
			// COMIENZA SAQUEO DE DATOS DE LA TABLA DE USUARIOS
			$SpecifyItemsU	= 
			"u.id,u.username,u.email,u.email_2,u.authlevel,u.id_planet,u.galaxy,u.system,u.planet,u.user_lastip,u.ip_at_reg,u.darkmatter,u.register_time,u.onlinetime,u.urlaubs_modus,u.
			 urlaubs_until,u.ally_id,a.ally_name,".$SpecifyItemsUQ."
			 u.ally_register_time,u.ally_rank_id,u.bana,u.banaday";
			
			$UserQuery 	= 	$GLOBALS['DATABASE']->uniquequery("SELECT ".$SpecifyItemsU." FROM ".USERS." as u LEFT JOIN ".SESSION." as s ON s.userID = u.id LEFT JOIN ".ALLIANCE." a ON a.id = u.ally_id WHERE u.`id` = '".$id_u."';");

			
			$reg_time		= _date($LNG['php_tdformat'], $UserQuery['register_time'], $USER['timezone']);
			$onlinetime		= _date($LNG['php_tdformat'], $UserQuery['onlinetime'], $USER['timezone']);
			$id				= $UserQuery['id'];
			$nombre			= $UserQuery['username'];
			$email_1		= $UserQuery['email'];
			$email_2		= $UserQuery['email_2'];
			$ip				= $UserQuery['ip_at_reg'];
			$ip2			= $UserQuery['user_lastip'];
			$id_p			= $UserQuery['id_planet'];
			$g				= $UserQuery['galaxy'];
			$s				= $UserQuery['system'];
			$p				= $UserQuery['planet'];
			$info			= $UserQuery['user_ua'];
			$alianza		= $UserQuery['ally_name'];
			$nivel			= $LNG['rank'][$UserQuery['authlevel']];
			$vacas 			= $LNG['one_is_yes'][$UserQuery['urlaubs_modus']];
			$suspen 		= $LNG['one_is_yes'][$UserQuery['bana']]; 


			$mo	= "<a title=\"".pretty_number($UserQuery['darkmatter'])."\">".shortly_number($UserQuery['darkmatter'])."</a>";

			foreach($reslist['officier'] as $ID)
			{
				$officier[]	= $ID;
			}
			
			foreach($reslist['tech'] as $ID)
			{
				$techno[]		= $ID;
			}
			$techoffi	= "";
			for($i = 0; $i < max(count($reslist['officier']), count($reslist['tech'])); $i++)
			{
				$techoffi .= isset($techno[$i]) ? "<tr><td>".$LNG['tech'][$techno[$i]].": <font color=aqua>".$UserQuery[$resource[$techno[$i]]]."</font></td>" : "<tr><td>&nbsp;</td>";
				
				$techoffi .= isset($officier[$i]) ? "<td>".$LNG['tech'][$officier[$i]].": <font color=aqua>".$UserQuery[$resource[$officier[$i]]]."</font></td></tr>" : "<td>&nbsp;</td></tr>";				
			}
			
			if ($UserQuery['bana'] != 0)
			{
				$mas			= '<a ref="#" onclick="$(\'#banned\').slideToggle();return false"> '.$LNG['ac_more'].'</a>';
				
				$BannedQuery	= $GLOBALS['DATABASE']->uniquequery("SELECT theme,time,longer,author FROM ".BANNED." WHERE `who` = '".$UserQuery['username']."';");
				
				
				$sus_longer	= _date($LNG['php_tdformat'], $BannedQuery['longer'], $USER['timezone']);
				$sus_time	= _date($LNG['php_tdformat'], $BannedQuery['time'], $USER['timezone']);
				$sus_reason	= $BannedQuery['theme'];
				$sus_author	= $BannedQuery['author'];
				
			}
			
			
			// COMIENZA EL SAQUEO DE DATOS DE LA TABLA DE PUNTAJE
			$SpecifyItemsS	= 
			"tech_count,defs_count,fleet_count,build_count,build_points,tech_points,defs_points,fleet_points,tech_rank,build_rank,defs_rank,fleet_rank,total_points,
			stat_type";
			
			$StatQuery	= $GLOBALS['DATABASE']->uniquequery("SELECT ".$SpecifyItemsS." FROM ".STATPOINTS." WHERE `id_owner` = '".$id_u."' AND `stat_type` = '1';");

			$count_tecno	= pretty_number($StatQuery['tech_count']);
			$count_def		= pretty_number($StatQuery['defs_count']);
			$count_fleet	= pretty_number($StatQuery['fleet_count']);
			$count_builds	= pretty_number($StatQuery['build_count']);
				
			$point_builds	= pretty_number($StatQuery['build_points']);
			$point_tecno	= pretty_number($StatQuery['tech_points']);
			$point_def		= pretty_number($StatQuery['defs_points']);
			$point_fleet	= pretty_number($StatQuery['fleet_points']);
				
				
			$ranking_tecno		= $StatQuery['tech_rank'];
			$ranking_builds	= $StatQuery['build_rank'];
			$ranking_def		= $StatQuery['defs_rank'];
			$ranking_fleet		= $StatQuery['fleet_rank'];
				
			$total_points	= pretty_number($StatQuery['total_points']);
			

			
			// COMIENZA EL SAQUEO DE DATOS DE LA ALIANZA
			$AliID	= $UserQuery['ally_id'];
			
			
			if ($alianza == 0 && $AliID == 0)
			{
				$alianza	= $LNG['ac_no_ally'];
				$AllianceHave	= "<span class=\"no_moon\"><img src=\"./styles/images/Adm/arrowright.png\" width=\"16\" height=\"10\"/> 
							".$LNG['ac_alliance']."&nbsp;".$LNG['ac_no_alliance']."</span>";	
			}
			elseif ($alianza != NULL && $AliID != 0)
			{
				include_once(ROOT_PATH.'includes/functions/BBCode.php');	
				
				$AllianceHave	= '<a href="#" onclick="$(\'#alianza\').slideToggle();return false" class="link">
							<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> '.$LNG['ac_alliance'].'</a>';
										
							
				
				$SpecifyItemsA	= 
				"ally_owner,id,ally_tag,ally_name,ally_web,ally_description,ally_text,ally_request,ally_image,ally_members,ally_register_time";
				
				$AllianceQuery		= $GLOBALS['DATABASE']->uniquequery("SELECT ".$SpecifyItemsA." FROM ".ALLIANCE." WHERE `ally_name` = '".$alianza."';");
				
				
				$alianza				= $alianza;
				$id_ali					= " (".$LNG['ac_ali_idid']."&nbsp;".$AliID.")";	
				$id_aliz				= $AllianceQuery['id'];
				$tag					= $AllianceQuery['ally_tag'];
				$ali_nom				= $AllianceQuery['ally_name'];
				$ali_cant				= $AllianceQuery['ally_members'];
				$ally_register_time		= _date($LNG['php_tdformat'], $AllianceQuery['ally_register_time'], $USER['timezone']);
				$ali_lider				= $AllianceQuery['ally_owner'];
				$ali_web				= $AllianceQuery['ally_web'] != NULL ? "<a href=".$AllianceQuery['ally_web']." target=_blank>".$AllianceQuery['ally_web']."</a>" : $LNG['ac_no_web'];
										
					
				if($AllianceQuery['ally_description'] != NULL)
				{
					$ali_ext2 = bbcode($AllianceQuery['ally_description']);
					$ali_ext  = "<a href=\"#\" rel=\"toggle[externo]\">".$LNG['ac_view_text_ext']."</a>";
				}
				else
				{
					$ali_ext = $LNG['ac_no_text_ext'];
				}
					
					
				if($AllianceQuery['ally_text'] != NULL)
				{
					$ali_int2 = bbcode($AllianceQuery['ally_text']);
					$ali_int  = "<a href=\"#\" rel=\"toggle[interno]\">".$LNG['ac_view_text_int']."</a>";
				}
				else
				{
					$ali_int = $LNG['ac_no_text_int'];
				}
					
					
				if($AllianceQuery['ally_request'] != NULL)
				{
					$ali_sol2 = bbcode($AllianceQuery['ally_request']);
					$ali_sol  = "<a href=\"#\" rel=\"toggle[solicitud]\">".$LNG['ac_view_text_sol']."</a>";
				}
				else
				{
					$ali_sol = $LNG['ac_no_text_sol'];
				}
					
					
				if($AllianceQuery['ally_image'] != NULL)
				{
					$ali_logo2 = $AllianceQuery['ally_image'];
					$ali_logo = "<a href=\"#\" rel=\"toggle[imagen]\">".$LNG['ac_view_image2']."</a>";
				}
				else
				{
					$ali_logo = $LNG['ac_no_img'];
				}
				
				
				$SearchLeader		= $GLOBALS['DATABASE']->uniquequery("SELECT `username` FROM ".USERS." WHERE `id` = '".$ali_lider."';");
				$ali_lider	= $SearchLeader['username'];



				$StatQueryAlly	= $GLOBALS['DATABASE']->uniquequery("SELECT ".$SpecifyItemsS." FROM ".STATPOINTS." WHERE `id_owner` = '".$ali_lider."' AND `stat_type` = '2';");
						
				$count_tecno_ali	= pretty_number($StatQueryAlly['tech_count']);
				$count_def_ali		= pretty_number($StatQueryAlly['defs_count']);
				$count_fleet_ali	= pretty_number($StatQueryAlly['fleet_count']);
				$count_builds_ali	= pretty_number($StatQueryAlly['build_count']);
				
				$point_builds_ali	= pretty_number($StatQueryAlly['build_points']);
				$point_tecno_ali	= pretty_number($StatQueryAlly['tech_points']);
				$point_def_ali		= pretty_number($StatQueryAlly['defs_points']);
				$point_fleet_ali	= pretty_number($StatQueryAlly['fleet_points']);
				
				
				$ranking_tecno_ali		= pretty_number($StatQueryAlly['tech_rank']);
				$ranking_builds_ali	= pretty_number($StatQueryAlly['build_rank']);
				$ranking_def_ali		= pretty_number($StatQueryAlly['defs_rank']);
				$ranking_fleet_ali		= pretty_number($StatQueryAlly['fleet_rank']);
				
				$total_points_ali		= pretty_number($StatQueryAlly['total_points']);
			}		
			
			foreach(array_merge($reslist['fleet'], $reslist['build'], $reslist['defense']) as $ID)
			{
				$SpecifyItemsPQ	.= "`".$resource[$ID]."`,";
				$RES[$resource[$ID]]	= "<tr><td width=\"150\">".$LNG['tech'][$ID]."</td>";
			}
			$names	= "<tr><th class=\"center\" width=\"150\">&nbsp;</th>";
			
			// COMIENZA EL SAQUEO DE DATOS DE LOS PLANETAS
			$SpecifyItemsP	= "planet_type,id,name,galaxy,system,planet,destruyed,diameter,field_current,field_max,temp_min,temp_max,metal,crystal,deuterium,energy,".$SpecifyItemsPQ."energy_used";
				
			$PlanetsQuery	= $GLOBALS['DATABASE']->query("SELECT ".$SpecifyItemsP." FROM ".PLANETS." WHERE `id_owner` = '".$id_u."';");
			
			while ($PlanetsWhile	= $GLOBALS['DATABASE']->fetch_array($PlanetsQuery))
			{
				if ($PlanetsWhile['planet_type'] == 3)
				{
					$Planettt = $PlanetsWhile['name']."&nbsp;(".$LNG['ac_moon'].")<br><font color=aqua>["
								.$PlanetsWhile['galaxy'].":".$PlanetsWhile['system'].":".$PlanetsWhile['planet']."]</font>";					
					
					$MoonZ	= 0;		
					$Moons = $PlanetsWhile['name']."&nbsp;(".$LNG['ac_moon'].")<br><font color=aqua>["
								.$PlanetsWhile['galaxy'].":".$PlanetsWhile['system'].":".$PlanetsWhile['planet']."]</font>";
					$MoonZ++;
				}
				else
				{
					$Planettt = $PlanetsWhile['name']."<br><font color=aqua>[".$PlanetsWhile['galaxy'].":".$PlanetsWhile['system'].":"
								.$PlanetsWhile['planet']."]</font>";
				}
					
					
					
				if ($PlanetsWhile["destruyed"] == 0)
				{	
					$planets_moons	.= "
					<tr>
						<td>".$Planettt."</td>
						<td>".$PlanetsWhile['id']."</td>
						<td>".pretty_number($PlanetsWhile['diameter'])."</td>
						<td>".pretty_number($PlanetsWhile['field_current'])." / ".pretty_number(CalculateMaxPlanetFields($PlanetsWhile))." (".pretty_number($PlanetsWhile['field_current'])." / ".pretty_number($PlanetsWhile['field_max']).")</td>
						<td>".pretty_number($PlanetsWhile['temp_min'])." / ".pretty_number($PlanetsWhile['temp_max'])."</td>"
						.(allowedTo('ShowQuickEditorPage') ? "<td><a href=\"javascript:openEdit('".$PlanetsWhile['id']."', 'planet');\" border=\"0\"><img src=\"./styles/images/Adm/GO.png\" title=".$LNG['se_search_edit']."></a></td>" : "").
					"</tr>";
					
					
					$SumOfEnergy	= ($PlanetsWhile['energy'] + $PlanetsWhile['energy_used']);
					
					if ($SumOfEnergy < 0) 
						$Color	= "<font color=#FF6600>".shortly_number($SumOfEnergy)."</font>";
					elseif ($SumOfEnergy > 0) 
						$Color	= "<font color=lime>".shortly_number($SumOfEnergy)."</font>";
					else
						$Color	= shortly_number($SumOfEnergy);
					
					
					$resources	.= "
					<tr>
						<td>".$Planettt."</td>
						<td><a title=\"".pretty_number($PlanetsWhile['metal'])."\">".shortly_number($PlanetsWhile['metal'])."</a></td>
						<td><a title=\"".pretty_number($PlanetsWhile['crystal'])."\">".shortly_number($PlanetsWhile['crystal'])."</a></td>
						<td><a title=\"".pretty_number($PlanetsWhile['deuterium'])."\">".shortly_number($PlanetsWhile['deuterium'])."</a></td>
						<td><a title=\"".pretty_number($SumOfEnergy)."\">".$Color."</a>/<a title=\"".pretty_number($PlanetsWhile['energy'])."\">".shortly_number($PlanetsWhile['energy'])."</a></td>
					</tr>";
					$names	.= "<th class=\"center\" width=\"60\">".$Planettt."</th>";
					foreach(array_merge($reslist['fleet'], $reslist['build'], $reslist['defense']) as $ID)
					{
						$RES[$resource[$ID]]	.= "<td width=\"60\"><a title=\"".pretty_number($PlanetsWhile[$resource[$ID]])."\">".shortly_number($PlanetsWhile[$resource[$ID]])."</a></td>";
					}
					
					$MoonHave = $MoonZ != 0 ? '<a href="#" onclick="$(\'#especiales\').slideToggle();return false" class="link"><img src="./styles/images/Adm/arrowright.png" width="16" height="10"/> '.$LNG['moon_build']."</a>" : "<span class=\"no_moon\"><img src=\"./styles/images/Adm/arrowright.png\" width=\"16\" height=\"10\"/>".$LNG['moon_build']."&nbsp;".$LNG['ac_moons_no']."</span>";					
				}
				
				$DestruyeD	= 0;
				if ($PlanetsWhile["destruyed"] > 0)
				{
					$destroyed	.= "
						<tr>
							<td>".$PlanetsWhile['name']."</td>
							<td>".$PlanetsWhile['id']."</td>
							<td>[".$PlanetsWhile['galaxy'].":".$PlanetsWhile['system'].":".$PlanetsWhile['planet']."]</td>
							<td>".date("d-m-Y   H:i:s", $PlanetsWhile['destruyed'])."</td>
						</tr>";	
					$DestruyeD++;
				}
			}
			$names	.= "</tr>";
			foreach(array_merge($reslist['fleet'], $reslist['build'], $reslist['defense']) as $ID)
			{
				$RES[$resource[$ID]]	.= "</tr>";
			}
			
			foreach($reslist['build'] as $ID)
			{
				$build	.= $RES[$resource[$ID]];
			}
			
			foreach($reslist['fleet'] as $ID)
			{
				$fleet	.= $RES[$resource[$ID]];
			}
			
			foreach($reslist['defense'] as $ID)
			{
				$defense	.= $RES[$resource[$ID]];
			}
			
			$template->assign_vars(array(
				'DestruyeD'						=> $DestruyeD,
				'destroyed'						=> $destroyed,
				'resources'						=> $resources,
				'mo'							=> $mo,
				'names'							=> $names,
				'build'							=> $build,
				'fleet'							=> $fleet,
				'defense'						=> $defense,
				'planets_moons'					=> $planets_moons,
				'ali_lider'						=> $ali_lider,
				'AllianceHave'					=> $AllianceHave,
				'point_tecno'					=> $point_tecno,
				'count_tecno'					=> $count_tecno,
				'ranking_tecno'					=> $ranking_tecno,
				'defenses_title'				=> $defenses_title,
				'point_def'						=> $point_def,
				'count_def'						=> $count_def,
				'ranking_def'					=> $ranking_def,
				'point_fleet'					=> $point_fleet,
				'count_fleet'					=> $count_fleet,
				'ranking_fleet'					=> $ranking_fleet,
				'point_builds'					=> $point_builds,
				'count_builds'					=> $count_builds,
				'ranking_builds'				=> $ranking_builds,
				'total_points'					=> $total_points,
				'point_tecno_ali'				=> $point_tecno_ali,
				'count_tecno_ali'				=> $count_tecno_ali,
				'ranking_tecno_ali'				=> $ranking_tecno_ali,
				'point_def_ali'					=> $point_def_ali,
				'count_def_ali'					=> $count_def_ali,
				'ranking_def_ali'				=> $ranking_def_ali,
				'point_fleet_ali'				=> $point_fleet_ali,
				'count_fleet_ali'				=> $count_fleet_ali,
				'ranking_fleet_ali'				=> $ranking_fleet_ali,
				'point_builds_ali'				=> $point_builds_ali,
				'count_builds_ali'				=> $count_builds_ali,
				'ranking_builds_ali'			=> $ranking_builds_ali,
				'total_points_ali'				=> $total_points_ali,
				'input_id'						=> $input_id,
				'id_aliz'						=> $id_aliz,
				'tag'							=> $tag,
				'ali_nom'						=> $ali_nom,
				'ali_ext'						=> $ali_ext,
				'ali_ext'						=> $ali_ext2,
				'ali_int'						=> $ali_int,
				'ali_int'						=> $ali_int2,
				'ali_sol2'						=> $ali_sol2,
				'ali_sol'						=> $ali_sol,
				'ali_logo'						=> $ali_logo,
				'ali_logo2'						=> $ali_logo2,
				'ali_web'						=> $ali_web,
				'ally_register_time'			=> $ally_register_time,
				'ali_cant'						=> $ali_cant,
				'alianza'						=> $alianza,
				'input_id'						=> $input_id,
				'id'							=> $id,
				'nombre'						=> $nombre,
				'nivel'							=> $nivel,
				'vacas'							=> $vacas,
				'suspen'						=> $suspen,
				'mas'							=> $mas,
				'id_ali'						=> $id_ali,
				'ip'							=> $ip,
				'ip2'							=> $ip2,
				'ipcheck'						=> true,
				'reg_time'						=> $reg_time,
				'onlinetime'					=> $onlinetime,
				'id_p'							=> $id_p,
				'g'								=> $g,
				's'								=> $s,
				'p'								=> $p,
				'info'							=> $info,
				'email_1'						=> $email_1,
				'email_2'						=> $email_2,
				'sus_time'						=> $sus_time,
				'sus_longer'					=> $sus_longer,
				'sus_reason'					=> $sus_reason,
				'sus_author'					=> $sus_author,
				'techoffi'						=> $techoffi,
				'canedit'						=> allowedTo('ShowQuickEditorPage'),
				
				'buildings_title'				=> $LNG['buildings_title'],
				'buildings_title'				=> $LNG['buildings_title'],
				'researchs_title	'			=> $LNG['researchs_title'],
				'ships_title'					=> $LNG['ships_title'],
				'defenses_title'				=> $LNG['defenses_title'],
				'ac_recent_destroyed_planets'	=> $LNG['ac_recent_destroyed_planets'],
				'ac_isnodestruyed'				=> $LNG['ac_isnodestruyed'],
				'ac_note_k'						=> $LNG['ac_note_k'],
				'ac_leyend'						=> $LNG['ac_leyend'],
				'ac_account_data'				=> $LNG['ac_account_data'],
				'ac_name'						=> $LNG['ac_name'],
				'ac_mail'						=> $LNG['ac_mail'],
				'ac_perm_mail'					=> $LNG['ac_perm_mail'],
				'ac_auth_level'					=> $LNG['ac_auth_level'],
				'ac_on_vacation'				=> $LNG['ac_on_vacation'],
				'ac_banned'						=> $LNG['ac_banned'],
				'ac_alliance'					=> $LNG['ac_alliance'],
				'ac_reg_ip'						=> $LNG['ac_reg_ip'],
				'ac_last_ip'					=> $LNG['ac_last_ip'],
				'ac_checkip_title'				=> $LNG['ac_checkip_title'],
				'ac_register_time'				=> $LNG['ac_register_time'],
				'ac_act_time'					=> $LNG['ac_act_time'],
				'ac_home_planet_id'				=> $LNG['ac_home_planet_id'],
				'ac_home_planet_coord'			=> $LNG['ac_home_planet_coord'],
				'ac_user_system'				=> $LNG['ac_user_system'],
				'ac_ranking'					=> $LNG['ac_ranking'],
				'ac_see_ranking'				=> $LNG['ac_see_ranking'],
				'ac_user_ranking'				=> $LNG['ac_user_ranking'],
				'ac_points_count'				=> $LNG['ac_points_count'],
				'ac_ranking'					=> $LNG['ac_ranking'],
				'ac_total_points'				=> $LNG['ac_total_points'],
				'ac_suspended_title'			=> $LNG['ac_suspended_title'],
				'ac_suspended_time'				=> $LNG['ac_suspended_time'],
				'ac_suspended_longer'			=> $LNG['ac_suspended_longer'],
				'ac_suspended_reason'			=> $LNG['ac_suspended_reason'],
				'ac_suspended_autor'			=> $LNG['ac_suspended_autor'],
				'ac_info_ally'					=> $LNG['ac_info_ally'],
				'ac_leader'						=> $LNG['ac_leader'],
				'ac_tag'						=> $LNG['ac_tag'],
				'ac_name_ali'					=> $LNG['ac_name_ali'],
				'ac_ext_text		'			=> $LNG['ac_ext_text'],
				'ac_int_text'					=> $LNG['ac_int_text'],
				'ac_sol_text'					=> $LNG['ac_sol_text'],
				'ac_image'						=> $LNG['ac_image'],
				'ac_ally_web'					=> $LNG['ac_ally_web'],
				'ac_total_members'				=> $LNG['ac_total_members'],
				'ac_ranking'					=> $LNG['ac_ranking'],
				'ac_see_ranking'				=> $LNG['ac_see_ranking'],
				'ac_view_image'					=> $LNG['ac_view_image'],
				'ac_urlnow'						=> $LNG['ac_urlnow'],
				'ac_ally_ranking'				=> $LNG['ac_ally_ranking'],
				'ac_points_count'				=> $LNG['ac_points_count'],
				'ac_ranking'					=> $LNG['ac_ranking'],
				'ac_total_points'				=> $LNG['ac_total_points'],
				'ac_id_names_coords'			=> $LNG['ac_id_names_coords'],
				'ac_name'						=> $LNG['ac_name'],
				'ac_diameter'					=> $LNG['ac_diameter'],
				'ac_fields'						=> $LNG['ac_fields'],
				'ac_temperature'				=> $LNG['ac_temperature'],
				'se_search_edit'				=> $LNG['se_search_edit'],
				'resources_title'				=> $LNG['resources_title'],
				'ac_name'						=> $LNG['ac_name'],
				'Metal'							=> $LNG['tech'][901],
				'Crystal'						=> $LNG['tech'][902],
				'Deuterium'						=> $LNG['tech'][903],
				'Energy'						=> $LNG['tech'][911],
				'Darkmatter'					=> $LNG['tech'][921],
				'buildings_title'				=> $LNG['buildings_title'],
				'ships_title'					=> $LNG['ships_title'],
				'defenses_title'				=> $LNG['defenses_title'],
				'ac_officier_research'			=> $LNG['ac_officier_research'],
				'researchs_title'				=> $LNG['researchs_title'],
				'officiers_title'				=> $LNG['officiers_title'],
				'ac_name'						=> $LNG['ac_name'],
				'input_id'						=> $LNG['input_id'],
				'ac_coords'						=> $LNG['ac_coords'],
				'ac_time_destruyed'				=> $LNG['ac_time_destruyed'],
			));					
			$template->show('AccountDataPageDetail.tpl');
		}
		exit;
	}
	$Userlist	= "";
	$UserWhileLogin	= $GLOBALS['DATABASE']->query("SELECT `id`, `username`, `authlevel` FROM ".USERS." WHERE `authlevel` <= '".$USER['authlevel']."' AND `universe` = '".$_SESSION['adminuni']."' ORDER BY `username` ASC;");
	while($UserList	= $GLOBALS['DATABASE']->fetch_array($UserWhileLogin))
	{
		$Userlist	.= "<option value=\"".$UserList['id']."\">".$UserList['username']."&nbsp;&nbsp;(".$LNG['rank'][$UserList['authlevel']].")</option>";
	}

	$template->loadscript('filterlist.js');
	$template->assign_vars(array(
		'Userlist'			=> $Userlist,
		'ac_enter_user_id'	=> $LNG['ac_enter_user_id'],
		'bo_select_title'	=> $LNG['bo_select_title'],
		'button_filter'		=> $LNG['button_filter'],
		'button_deselect'	=> $LNG['button_deselect'],
		'ac_select_id_num'	=> $LNG['ac_select_id_num'],
		'button_submit'		=> $LNG['button_submit'],
	));					
	$template->show('AccountDataPageIntro.tpl');
}
?>