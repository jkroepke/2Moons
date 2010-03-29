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
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($Observation != 1) die(message ($lang['404_page']));

$parse	= 	$lang;


if ($user['authlevel']	!=	3)
	$NOSUPERMI	=	"WHERE `authlevel` < '".$user['authlevel']."'";
	
$UserWhileLogin	=	$db->query("SELECT `id`, `username`, `authlevel` FROM ".USERS." ".$NOSUPERMI." ORDER BY `username` ASC;");
while($UserList	=	$db->fetch_array($UserWhileLogin))
{
	$parse['lista']	.=	"<option value=\"".$UserList['id']."\">".$UserList['username']."&nbsp;&nbsp; (".$lang['rank'][$UserList['authlevel']].")</option>";
}


if($_GET['id_u'] != NULL)
	$id_u	=	$_GET['id_u'];
else
	$id_u	=	$_GET['id_u2'];


$OnlyQueryLogin 	= 	$db->fetch_array($db->query("SELECT `id`, `authlevel` FROM ".USERS." WHERE `id` = '".$id_u."';"));

		
	if ($_GET)
	{
		if ($id_u == NULL)
		{
			$parse['error']	=	"<tr><th height=25 style=\"border: 2px red solid;\"><font color=red>".$lang['ac_user_id_required']."</font></th></tr>";
		}
		elseif($_GET['id_u'] != NULL && $_GET['id_u2'] != NULL)
		{
			$parse['error']	=	"<tr><th height=25 style=\"border: 2px red solid;\"><font color=red>".$lang['ac_select_one_id']."</font></th></tr>";
		}
		elseif(!is_numeric($id_u))
		{
			$parse['error']	=	"<tr><th height=25 style=\"border: 2px red solid;\"><font color=red>".$lang['ac_no_character']."</font></th></tr>";
		}
		elseif($OnlyQueryLogin == NULL or $OnlyQueryLogin == 0)
		{
			$parse['error']	=	"<tr><th height=25 style=\"border: 2px red solid;\"><font color=red>".$lang['ac_username_doesnt']."</font></th></tr>";
		}
		elseif($user['authlevel'] != 3 && $OnlyQueryLogin['authlevel'] > $user['authlevel'])
		{
			$parse['error']	=	"<tr><th height=25 style=\"border: 2px red solid;\"><font color=red>".$lang['ac_no_rank_level']."</font></th></tr>";
		}
		else
		{
			foreach(array_merge($reslist['officier'], $reslist['tech']) as $ID)
			{
				$SpecifyItemsUQ	.= "`".$resource[$ID]."`,";
			}
		
			// COMIENZA SAQUEO DE DATOS DE LA TABLA DE USUARIOS
			$SpecifyItemsU	=	
			"id,username,email,email_2,authlevel,id_planet,galaxy,system,planet,user_lastip,ip_at_reg,user_agent,darkmatter,register_time,onlinetime,noipcheck,urlaubs_modus,
			 urlaubs_until,ally_id,ally_name,ally_request,".$SpecifyItemsUQ."
			 ally_request_text,ally_register_time,ally_rank_id,bana,banaday";
			
			$UserQuery 	= 	$db->fetch_array($db->query("SELECT ".$SpecifyItemsU." FROM ".USERS." WHERE `id` = '".$id_u."';"));

			
			$parse['reg_time']		=	date("d-m-Y H:i:s", $UserQuery['register_time']);
			$parse['onlinetime']	=	date("d-m-Y H:i:s", $UserQuery['onlinetime']);
			$parse['id']			=	$UserQuery['id'];
			$parse['nombre']		=	$UserQuery['username'];
			$parse['email_1']		=	$UserQuery['email'];
			$parse['email_2']		=	$UserQuery['email_2'];
			$parse['ip']			=	$UserQuery['ip_at_reg'];
			$parse['ip2']			=	$UserQuery['user_lastip'];
			$parse['id_p']			=	$UserQuery['id_planet'];
			$parse['g']				=	$UserQuery['galaxy'];
			$parse['s']				=	$UserQuery['system'];
			$parse['p']				=	$UserQuery['planet'];
			$parse['info']			=	$UserQuery['user_agent'];
			$alianza				=	$UserQuery['ally_name'];
			$parse['nivel']			=	$lang['rank'][$UserQuery['authlevel']];
			$parse['ipcheck']		=	$lang['ac_checkip'][$UserQuery['noipcheck']];
			if($UserQuery['urlaubs_modus'] == 1) $parse['vacas'] = $lang['one_is_yes'][1]; else $parse['vacas'] = $lang['one_is_yes'][0];
			if($UserQuery['bana'] == 1) $parse['suspen'] = $lang['one_is_yes'][1]; else $parse['suspen'] = $lang['one_is_yes'][0];


			$parse['mo']	=	"<a title=\"".pretty_number($UserQuery['darkmatter'])."\">".shortly_number($UserQuery['darkmatter'])."</a>";
			
			$Log	.=	"\n".$lang['log_info_detail_title']."\n";
			$Log	.=	$lang['log_the_user'].$user['username'].$lang['log_searchto_1'].$UserQuery['username']."\n";				
			LogFunction($Log, "GeneralLog", $LogCanWork);

			foreach($reslist['officier'] as $ID)
			{
				$parse['officier'][]	= $ID;
			}
			
			foreach($reslist['tech'] as $ID)
			{
				$parse['techno'][]		= $ID;
			}
			$parse['techoffi']	= "";
			for($i = 0; $i < max(count($reslist['officier']), count($reslist['tech'])); $i++)
			{
				if(isset($parse['techno'][$i]))
					$parse['techoffi']	.= "<tr><th>".$lang['tech'][$parse['techno'][$i]].": <font color=aqua>".$UserQuery[$resource[$parse['techno'][$i]]]."</font></th>";
				else
					$parse['techoffi']	.= "<tr><th>&nbsp;</th>";
				
				if($parse['officier'][$i])
					$parse['techoffi']	.= "<th>".$lang['tech'][$parse['officier'][$i]].": <font color=aqua>".$UserQuery[$resource[$parse['officier'][$i]]]."</font></th></tr>";
				else
					$parse['techoffi']	.= "<th>&nbsp;</th></tr>";	
			}
			
			if ($UserQuery['bana'] != 0)
			{
				$parse['mas']			=	"<a href=\"javascript:animatedcollapse.toggle('banned')\">".$lang['ac_more']."</a>";
				
				$BannedQuery	=	$db->fetch_array($db->query("SELECT theme,time,longer,author FROM ".BANNED." WHERE `who` = '".$UserQuery['username']."';"));
				
				
				$parse['sus_longer']	=	date("d-m-Y H-i-s", $BannedQuery['longer']);
				$parse['sus_time']		=	date("d-m-Y H-i-s", $BannedQuery['time']);
				$parse['sus_reason']	=	$BannedQuery['theme'];
				$parse['sus_author']	=	$BannedQuery['author'];
				
			}
			
			
			// COMIENZA EL SAQUEO DE DATOS DE LA TABLA DE PUNTAJE
			$SpecifyItemsS	=	
			"tech_count,defs_count,fleet_count,build_count,build_points,tech_points,defs_points,fleet_points,tech_rank,build_rank,defs_rank,fleet_rank,total_points,
			stat_type";
			
			$StatQuery	=	$db->fetch_array($db->query("SELECT ".$SpecifyItemsS." FROM ".STATPOINTS." WHERE `id_owner` = '".$id_u."' AND `stat_type` = '1';"));

			$parse['count_tecno']	=	pretty_number($StatQuery['tech_count']);
			$parse['count_def']		=	pretty_number($StatQuery['defs_count']);
			$parse['count_fleet']	=	pretty_number($StatQuery['fleet_count']);
			$parse['count_builds']	=	pretty_number($StatQuery['build_count']);
				
			$parse['point_builds']	=	pretty_number($StatQuery['build_points']);
			$parse['point_tecno']	=	pretty_number($StatQuery['tech_points']);
			$parse['point_def']		=	pretty_number($StatQuery['defs_points']);
			$parse['point_fleet']	=	pretty_number($StatQuery['fleet_points']);
				
				
			$parse['ranking_tecno']		=	$StatQuery['tech_rank'];
			$parse['ranking_builds']	=	$StatQuery['build_rank'];
			$parse['ranking_def']		=	$StatQuery['defs_rank'];
			$parse['ranking_fleet']		=	$StatQuery['fleet_rank'];
				
			$parse['total_points']	=	pretty_number($StatQuery['total_points']);
			

			
			// COMIENZA EL SAQUEO DE DATOS DE LA ALIANZA
			$AliID	=	$UserQuery['ally_id'];
			
			
			if ($alianza == 0 && $AliID == 0)
			{
				$parse['alianza']	=	$lang['ac_no_ally'];
				$parse['AllianceHave']	=	"<span class=\"no_moon\"><img src=\"../styles/images/Adm/arrowright.png\" width=\"16\" height=\"10\"/> 
							".$lang['ac_alliance']."&nbsp;".$lang['ac_no_alliance']."</span>";	
			}
			elseif ($alianza != NULL && $AliID != 0)
			{
				include_once("AdminFunctions/BBCode-Panel-Adm.php");	
				$bbcode = new bbcode;
				
				$parse['AllianceHave']	=	"<a href=\"javascript:animatedcollapse.toggle('alianza')\" class=\"link\">
							<img src=\"../styles/images/Adm/arrowright.png\" width=\"16\" height=\"10\"/> ".$lang['ac_alliance']."</a>";
										
							
				
				$SpecifyItemsA	=	
				"ally_owner,id,ally_tag,ally_name,ally_web,ally_description,ally_text,ally_request,ally_image,ally_members,ally_register_time";
				
				$AllianceQuery		=	$db->fetch_array($db->query("SELECT ".$SpecifyItemsA." FROM ".ALLIANCE." WHERE `ally_name` = '".$alianza."';"));
				
				
				
				$parse['alianza']				=	$alianza;
				$parse['id_ali']				=	" (".$lang['ac_ali_idid']."&nbsp;".$AliID.")";	
				$parse['id_aliz']				=	$AllianceQuery['id'];
				$parse['tag']					=	$AllianceQuery['ally_tag'];
				$parse['ali_nom']				=	$AllianceQuery['ally_name'];
				$parse['ali_cant']				=	$AllianceQuery['ally_members'];
				$parse['ally_register_time']	=	date("d-m-Y H:i:s", $AllianceQuery['ally_register_time']);
				$ali_lider						=	$AllianceQuery['ally_owner'];
					
					
				if($AllianceQuery['ally_web'] != NULL)
					$parse['ali_web'] = "<a href=".$AllianceQuery['ally_web']." target=_blank>".$AllianceQuery['ally_web']."</a>";
				else
					$parse['ali_web'] = $lang['ac_no_web'];
					
					
				if($AllianceQuery['ally_description'] != NULL)
				{
					$parse['ali_ext2'] = $bbcode->reemplazo($AllianceQuery['ally_description']);
					$parse['ali_ext']  = "<a href=\"#\" rel=\"toggle[externo]\">".$lang['ac_view_text_ext']."</a>";
				}
				else
				{
					$parse['ali_ext'] = $lang['ac_no_text_ext'];
				}
					
					
				if($AllianceQuery['ally_text'] != NULL)
				{
					$parse['ali_int2'] = $bbcode->reemplazo($AllianceQuery['ally_text']);
					$parse['ali_int']  = "<a href=\"#\" rel=\"toggle[interno]\">".$lang['ac_view_text_int']."</a>";
				}
				else
				{
					$parse['ali_int'] = $lang['ac_no_text_int'];
				}
					
					
				if($AllianceQuery['ally_request'] != NULL)
				{
					$parse['ali_sol2'] = $bbcode->reemplazo($AllianceQuery['ally_request']);
					$parse['ali_sol']  = "<a href=\"#\" rel=\"toggle[solicitud]\">".$lang['ac_view_text_sol']."</a>";
				}
				else
				{
					$parse['ali_sol'] = $lang['ac_no_text_sol'];
				}
					
					
				if($AllianceQuery['ally_image'] != NULL)
				{
					$parse['ali_logo2'] = $AllianceQuery['ally_image'];
					$parse['ali_logo'] = "<a href=\"#\" rel=\"toggle[imagen]\">".$lang['ac_view_image2']."</a>";
				}
				else
				{
					$parse['ali_logo'] = $lang['ac_no_img'];
				}
				
				
				$SearchLeader		=	$db->fetch_array($db->query("SELECT `username` FROM ".USERS." WHERE `id` = '".$ali_lider."';"));
				$parse['ali_lider']	=	$SearchLeader['username'];



				$StatQueryAlly	=	$db->fetch_array($db->query("SELECT ".$SpecifyItemsS." FROM ".STATPOINTS." WHERE `id_owner` = '".$ali_lider."' AND 
									`stat_type` = '2';"));
						
				$parse['count_tecno_ali']	=	pretty_number($StatQueryAlly['tech_count']);
				$parse['count_def_ali']		=	pretty_number($StatQueryAlly['defs_count']);
				$parse['count_fleet_ali']	=	pretty_number($StatQueryAlly['fleet_count']);
				$parse['count_builds_ali']	=	pretty_number($StatQueryAlly['build_count']);
				
				$parse['point_builds_ali']	=	pretty_number($StatQueryAlly['build_points']);
				$parse['point_tecno_ali']	=	pretty_number($StatQueryAlly['tech_points']);
				$parse['point_def_ali']		=	pretty_number($StatQueryAlly['defs_points']);
				$parse['point_fleet_ali']	=	pretty_number($StatQueryAlly['fleet_points']);
				
				
				$parse['ranking_tecno_ali']		=	pretty_number($StatQueryAlly['tech_rank']);
				$parse['ranking_builds_ali']	=	pretty_number($StatQueryAlly['build_rank']);
				$parse['ranking_def_ali']		=	pretty_number($StatQueryAlly['defs_rank']);
				$parse['ranking_fleet_ali']		=	pretty_number($StatQueryAlly['fleet_rank']);
				
				$parse['total_points_ali']		=	pretty_number($StatQueryAlly['total_points']);
			}		
			
			foreach(array_merge($reslist['fleet'], $reslist['build'], $reslist['defense']) as $ID)
			{
				$SpecifyItemsPQ	.= "`".$resource[$ID]."`,";
				$parse[$resource[$ID]]	= "<tr><th width=\"150\">".$lang['tech'][$ID]."</th>";
				$parse['names']	= "<tr><th width=\"150\">&nbsp;</th>";
			}
			
			// COMIENZA EL SAQUEO DE DATOS DE LOS PLANETAS
			$SpecifyItemsP	=	
				"planet_type,id,name,galaxy,system,planet,destruyed,diameter,field_current,field_max,temp_min,temp_max,metal,crystal,deuterium,energy_max,
				".$SpecifyItemsPQ."
				energy_used";
				
			$PlanetsQuery	=	$db->query("SELECT ".$SpecifyItemsP." FROM ".PLANETS." WHERE `id_owner` = '".$id_u."';");
			
			while ($PlanetsWhile	=	$db->fetch_array($PlanetsQuery))
			{
				if ($PlanetsWhile['planet_type'] == 3)
				{
					$Planettt = $PlanetsWhile['name']."&nbsp;(".$lang['ac_moon'].")<br><font color=aqua>["
								.$PlanetsWhile['galaxy'].":".$PlanetsWhile['system'].":".$PlanetsWhile['planet']."]</font>";					
					
					$MoonZ	=	0;		
					$Moons = $PlanetsWhile['name']."&nbsp;(".$lang['ac_moon'].")<br><font color=aqua>["
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
					$parse['planets_moons']	.=	"
					<tr>
						<th>".$Planettt."</th>
						<th>".$PlanetsWhile['id']."</th>
						<th>".pretty_number($PlanetsWhile['diameter'])."</th>
						<th>".pretty_number($PlanetsWhile['field_current'])."/".pretty_number($PlanetsWhile['field_max'])."</th>
						<th>".pretty_number($PlanetsWhile['temp_min'])."/".pretty_number($PlanetsWhile['temp_max'])."</th>
					</tr>";
					
					
					$SumOfEnergy	=	($PlanetsWhile['energy_max'] + $PlanetsWhile['energy_used']);
					
					if ($SumOfEnergy < 0) 
						$Color	=	"<font color=#FF6600>".shortly_number($SumOfEnergy)."</font>";
					elseif ($SumOfEnergy > 0) 
						$Color	=	"<font color=lime>".shortly_number($SumOfEnergy)."</font>";
					else
						$Color	=	shortly_number($SumOfEnergy);
					
					
					$parse['resources']	.=	"
					<tr>
						<th>".$Planettt."</th>
						<th><a title=\"".pretty_number($PlanetsWhile['metal'])."\">".shortly_number($PlanetsWhile['metal'])."</a></th>
						<th><a title=\"".pretty_number($PlanetsWhile['crystal'])."\">".shortly_number($PlanetsWhile['crystal'])."</a></th>
						<th><a title=\"".pretty_number($PlanetsWhile['deuterium'])."\">".shortly_number($PlanetsWhile['deuterium'])."</a></th>
						<th><a title=\"".pretty_number($SumOfEnergy)."\">".$Color."</a>/<a title=\"".pretty_number($PlanetsWhile['energy_max'])."\">".shortly_number($PlanetsWhile['energy_max'])."</a></th>
					</tr>";
					$parse['names']	.= "<th width=\"60\">".$Planettt."</th>";
					foreach(array_merge($reslist['fleet'], $reslist['build'], $reslist['defense']) as $ID)
					{
						$parse[$resource[$ID]]	.= "<th width=\"60\"><a title=\"".pretty_number($PlanetsWhile[$resource[$ID]])."\">".shortly_number($PlanetsWhile[$resource[$ID]])."</a></th>";
					}
					
					
					if ($MoonZ != 0)
						$parse['MoonHave']	=	"<a href=\"javascript:animatedcollapse.toggle('especiales')\" class=\"link\">
							<img src=\"../styles/images/Adm/arrowright.png\" width=\"16\" height=\"10\"/> ".$lang['moon_build']."</a>";
					else
						$parse['MoonHave']	=	"<span class=\"no_moon\"><img src=\"../styles/images/Adm/arrowright.png\" width=\"16\" height=\"10\"/> 
							".$lang['moon_build']."&nbsp;".$lang['ac_moons_no']."</span>";	
					
				}
				
				$DestruyeD	=	0;
				if ($PlanetsWhile["destruyed"] > 0)
				{
					$parse['destroyed']	.=	"
						<tr>
							<th>".$PlanetsWhile['name']."</th>
							<th>".$PlanetsWhile['id']."</th>
							<th>[".$PlanetsWhile['galaxy'].":".$PlanetsWhile['system'].":".$PlanetsWhile['planet']."]</th>
							<th>".date("d-m-Y   H:i:s", $PlanetsWhile['destruyed'])."</th>
						</tr>";	
					$DestruyeD++;
				}
				
				
				if ($DestruyeD != 0)
					$parse['DestructionHave']	=	"<a href=\"javascript:animatedcollapse.toggle('destr')\" class=\"link\">
						<img src=\"../styles/images/Adm/arrowright.png\" width=\"16\" height=\"10\"/> ".$lang['ac_recent_destroyed_planets']."</a>";
				else
					$parse['DestructionHave']	=	"<span class=\"no_moon\"><img src=\"../styles/images/Adm/arrowright.png\" width=\"16\" height=\"10\"/> 
						".$lang['ac_recent_destroyed_planets']."&nbsp;".$lang['ac_isnodestruyed']."</span>";
			}
			$parse['names']	.= "</tr>";
			foreach(array_merge($reslist['fleet'], $reslist['build'], $reslist['defense']) as $ID)
			{
				$parse[$resource[$ID]]	.= "</tr>";
			}
			
			foreach($reslist['build'] as $ID)
			{
				$parse['build']	.=	$parse[$resource[$ID]];
			}
			
			foreach($reslist['fleet'] as $ID)
			{
				$parse['fleet']	.=	$parse[$resource[$ID]];
			}
			
			foreach($reslist['defense'] as $ID)
			{
				$parse['defense']	.=	$parse[$resource[$ID]];
			}
			display (parsetemplate(gettemplate("adm/AccountDataBody"), $parse), false, '', true, false);
		}
	}

display (parsetemplate(gettemplate("adm/AccountDataIntro"), $parse), false, '', true, false);
?>