{include file="adm/overall_header.tpl"}
<script type="text/javascript" src="./scripts/animatedcollapse.js"></script>
<script type="text/javascript">
animatedcollapse.addDiv('pla', 'fade=1,height=auto')
animatedcollapse.addDiv('inves', 'fade=1,height=auto')
animatedcollapse.addDiv('info', 'fade=1,height=auto')
animatedcollapse.addDiv('recursos', 'fade=1,height=auto')
animatedcollapse.addDiv('edificios', 'fade=1,height=auto')
animatedcollapse.addDiv('especiales', 'fade=1,height=auto')
animatedcollapse.addDiv('naves', 'fade=1,height=auto')
animatedcollapse.addDiv('defensa', 'fade=1,height=auto')
animatedcollapse.addDiv('datos', 'fade=1,height=auto')
animatedcollapse.addDiv('destr', 'fade=1,height=auto')
animatedcollapse.addDiv('alianza', 'fade=1,height=auto')
animatedcollapse.addDiv('puntaje', 'fade=1,height=auto')

animatedcollapse.addDiv('imagen', 'fade=0,speed=400,group=pets')
animatedcollapse.addDiv('externo', 'fade=0,speed=400,group=pets')
animatedcollapse.addDiv('interno', 'fade=0,speed=400,group=pets')
animatedcollapse.addDiv('solicitud', 'fade=0,speed=400,group=pets')
animatedcollapse.addDiv('puntaje_ali', 'fade=0,speed=400,group=pets')
animatedcollapse.addDiv('banned', 'fade=0,speed=400,group=pets')

animatedcollapse.ontoggle=function($, divobj, state){
}

animatedcollapse.init()
</script>
<style type="text/css">
.image{
width:100%;height:100%;_height:auto;
}
a.link{
font-size:14px;font-variant:small-caps;margin-left:120px;
}
a.link:hover{
font-size:16px;font-variant:small-caps;margin-left:120px;
}
span.no_moon{
font-size:14px;font-variant:small-caps;margin-left:120px;font-family: Arial, Helvetica, sans-serif;
}
span.no_moon:hover{
font-size:14px;font-variant:small-caps;margin-left:120px;color:#FF0000;cursor:default;font-family: Arial, Helvetica, sans-serif;
}
a.ccc{
font-size:15px;
}
a.ccc:hover{
font-size:15px;color:aqua
;}
table.tableunique{
border:0px;background:url(./styles/images/Adm/blank.gif);width:100%;
}
td.unico{
border:0px;text-align:left;
}
td.unico2{
border:0px;text-align:center;
}
td{
color:#FFFFFF;font-size:10px;font-variant:normal;
}
td.blank{
border:0px;background:url(./styles/images/Adm/blank.gif);text-align:right;padding-right:80px;font-size:15px;
}
</style>


<table class="tableunique">
	<tr>
		<td class="blank"><a onMouseOver='return overlib("{$ac_note_k}", CENTER, OFFSETX, -150, OFFSETY, 5, width, 250);' onMouseOut='return nd();'>{$ac_leyend}&nbsp; <img src="./styles/images/Adm/i.gif" height="12" width="12"></a></td>
	</tr>
	<tr>
		<td class="unico"><a href="javascript:animatedcollapse.toggle('datos')" class="link">
		<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$ac_account_data}</a></td>
	</tr><tr>
		<td class="unico">
			<div id="datos">
			<table align="center" width="60%">
			<tr><th colspan="2">&nbsp;</th></tr>
			<tr><td height="22px">{$input_id}</td><td>{$id}</td></tr>
			<tr><td height="22px">{$ac_name}</td><td>{$nombre}</td></tr>
			<tr><td height="22px">{$ac_mail}</td><td>{$email_1}</td></tr>
			<tr><td height="22px">{$ac_perm_mail}</td><td>{$email_2}</td></tr>
			<tr><td height="22px">{$ac_auth_level}</td><td>{$nivel}</td></tr>
			<tr><td height="22px">{$ac_on_vacation}</td><td>{$vacas}</td></tr>
			<tr><td height="22px">{$ac_banned}</td><td>{$suspen} {$mas}</td></tr>
			<tr><td height="22px">{$ac_alliance}</td><td>{$alianza}{$id_ali}</td></tr>
			<tr><td height="22px">{$ac_reg_ip}</td><td>{$ip}</td></tr>
			<tr><td height="22px">{$ac_last_ip}</td><td>{$ip2}</td></tr>
			<tr><td height="22px">{$ac_checkip_title}</td><td>{$ipcheck}</td></tr>
			<tr><td height="22px">{$ac_register_time}</td><td>{$reg_time}</td></tr>
			<tr><td height="22px">{$ac_act_time}</td><td>{$onlinetime}</td></tr>
			<tr><td height="22px">{$ac_home_planet_id}</td><td>{$id_p}</td></tr>
			<tr><td height="22px">{$ac_home_planet_coord}</td><td>[{$g}:{$s}:{$p}]</td></tr>
			{if $info}<tr><td height="22px">{$ac_user_system}</td><td>{$info}</td></tr>{/if}
			<tr><td height="22px">{$ac_ranking}</td><td><a href="javascript:animatedcollapse.toggle('puntaje')">{$ac_see_ranking}</a></td></tr>
			</table>
			<br>
			
			<!-- PUNTAJE DEL USUARIO -->
			<div id="puntaje" style="display:none">
			<table align="center" width="60%">
			<tr><th colspan="3" class="centrado2">{$ac_user_ranking}</th></tr>
			<td width="15%"></td><td width="40%" class="centrado">{$ac_points_count}</td><td width="5%" class="centrado">{$ac_ranking}</td>
			<tr><td width="15%" class="centrado">{$researchs_title}</td><td width="40%">{$point_tecno} ({$count_tecno} {$researchs_title})</td><td width="5%" class="ranking"># {$ranking_tecno}</td></tr>
			<tr><td width="15%" class="centrado">{$defenses_title}</td><td width="40%">{$point_def} ({$count_def} {$defenses_title})</td><td width="5%" class="ranking"># {$ranking_def}</td></tr>
			<tr><td width="15%" class="centrado">{$ships_title}</td><td width="40%">{$point_fleet} ({$count_fleet} {$ships_title})</td><td width="5%" class="ranking"># {$ranking_fleet}</td></tr>
			<tr><td width="15%" class="centrado">{$buildings_title}</td><td width="40%">{$point_builds} ({$count_builds} {$buildings_title})</td><td width="5%" class="ranking"># {$ranking_builds}</td></tr>
			<tr><td colspan="3" class="total">{$ac_total_points}<span style="color:#FF0000">{$total_points}</span></td></tr>
			</table>
			<br>
			</div>
			
			
			<div id="banned" style="display:none">
			<table align="center" width="60%">
			<tr><th colspan="4">{$ac_suspended_title}</th></tr>
			<tr><td>{$ac_suspended_time}</td><td>{$sus_time}</td></tr>
			<tr><td>{$ac_suspended_longer}</td><td>{$sus_longer}</td></tr>
			<tr><td>{$ac_suspended_reason}</td><td>{$sus_reason}</td></tr>
			<tr><td>{$ac_suspended_autor}</td><td>{$sus_author}</td></tr>
			</table>
			<br>
			</div>
			</div>
		</td>
	</tr><tr>
		<td class="unico">{$AllianceHave}</td>
	</tr><tr>
		<td class="unico">
			<div id="alianza" style="display:none">
			<table align="center" width="60%">
			<tr><th colspan="2">{$ac_info_ally}</th></tr>
			<tr><td width="25%" align="center" >{$input_id}</td><td>{$id_aliz}</td></tr>
			<tr><td>{$ac_leader}</td><td>{$ali_lider}</td></tr>
			<tr><td>{$ac_tag}</td><td>{$tag}</td></tr>
			<tr><td>{$ac_name_ali}</td><td>{$ali_nom}</td></tr>
			<tr><td>{$ac_ext_text}</td><td>{$ali_ext}</td></tr>
			<tr><td>{$ac_int_text}</td><td>{$ali_int}</td></tr>
			<tr><td>{$ac_sol_text}</td><td>{$ali_sol}</td></tr>
			<tr><td>{$ac_image}</td><td>{$ali_logo}</td></tr>
			<tr><td>{$ac_ally_web}</td><td>{$ali_web}</td></tr>
			<tr><td>{$ac_register_ally_time}</td><td>{$ally_register_time}</td></tr>
			<tr><td>{$ac_total_members}</td><td>{$ali_cant}</td></tr>
			<tr><td>{$ac_ranking}</td><td><a href="#" rel="toggle[puntaje_ali]">{$ac_see_ranking}</a></td></tr>
			</table>
			<br>

			<div id="imagen" style="display:none">
			<table align="center" width="60%">
			<tr><th>{$ac_ali_logo_11}</th></tr>
			<tr><td width="60%"><img src="{$ali_logo2}" class="image"></td></tr>
			<tr><td><a href="{$ali_logo2}" target="_blank">{$ac_view_image}</a></td></tr>
			<tr><td>{$ac_urlnow} <input type="text" size="50" value="{$ali_logo2}"></td></tr>
			</table>
			<br>
			</div>

			<div id="externo" style="display:none">
			<table align="center" width="60%">
			<tr><th>{$ac_ali_text_11}</th></tr>
			<tr><td width="60%">{$ali_ext2}</td></tr>
			</table>
			<br>
			</div>

			<div id="interno" style="display:none">
			<table align="center" width="60%">
			<tr><td class="c">{$ac_ali_text_22}</td></tr>
			<tr><td width="60%">{$ali_int2}</td></tr>
			</table>
			<br>
			</div>

			<div id="solicitud" style="display:none">
			<table align="center" width="60%">
			<tr><th>{$ac_ali_text_33}</th></tr>
			<tr><td width="60%">{$ali_sol2}</td></tr>
			</table>
			<br>
			</div>

			<!-- PUNTAJE DE LA ALIANZA DEL USUARIO -->
			<div id="puntaje_ali" style="display:none">
			<table align="center" width="60%">
			<tr><td class="c" colspan="3">{$ac_ally_ranking}</td></tr>
			<td width="15%"></td><td width="40%">{$ac_points_count}</td><td width="5%" class="centrado">{$ac_ranking}</td>
			<tr><td width="15%">{$researchs_title}</td><td width="40%">{$point_tecno_ali} ({$count_tecno_ali} {$researchs_title})</td><td width="5%"># {$ranking_tecno_ali}</td></tr>
			<tr><td width="15%">{$defenses_title}</td><td width="40%">{$point_def_ali} ({$count_def_ali} {$defenses_title})</td><td width="5%"># {$ranking_def_ali}</td></tr>
			<tr><td width="15%">{$ships_title}</td><td width="40%">{$point_fleet_ali} ({$count_fleet_ali} {$ships_title})</td><td width="5%"># {$ranking_fleet_ali}</td></tr>
			<tr><td width="15%">{$buildings_title}</td><td width="40%">{$point_builds_ali} ({$count_builds_ali} {$buildings_title})</td><td width="5%"># {$ranking_builds_ali}</td></tr>
			<tr><td colspan="3">{$ac_total_points}<span style="color:#FF0000">{$total_points_ali}</span></td></tr>
			</table>
			<br>
			</div>
			</div>
		</td>
	</tr><tr>
		<td class="unico"><a href="javascript:animatedcollapse.toggle('pla')" class="link">
		<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$ac_id_names_coords}</a></td>
	</tr><tr>
		<td class="unico">
			<div id="pla" style="display:none">
			<table width="70%" align="center">
			<tr>
				<th>{$ac_name}</th>
				<th>{$input_id}</th>
				<th>{$ac_diameter}</th>
				<th>{$ac_fields}</th>
				<th>{$ac_temperature}</th>
				{if $canedit == 1}<th>{$se_search_edit}</th>{/if}
			</tr>
				{$planets_moons}
			</table>
			<br>
			</div>
		</td>
	</tr><tr>
		<td class="unico"><a href="javascript:animatedcollapse.toggle('recursos')" class="link">
		<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$resources_title}</a></td>
	</tr><tr>
		<td class="unico">
			<div id="recursos" style="display:none">
			<table width="70%" align="center">
			<tr>
				<th>{$ac_name}</th>
				<th>{$Metal}</th>
				<th>{$Crystal}</th>
				<th>{$Deuterium}</th>
				<th>{$Energy}</th>
			</tr>
				{$resources}
			<tr>
				<td colspan="5" height="30px">{$Darkmatter}: &nbsp;&nbsp;{$mo}</td>
			</tr>
			</table>
			<br >
			</div>	
		</td>
	</tr><tr>
		<td class="unico"><a href="javascript:animatedcollapse.toggle('edificios')" class="link">
		<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$buildings_title}</a></td>
	</tr><tr>
		<td class="unico">
			<div id="edificios" style="display:none">
			<table width="100%" align="center">
				{$names}
				{$build}
			</table>
			<br >
			</div>
		</td>
	</tr><tr>
		<td class="unico"><a href="javascript:animatedcollapse.toggle('naves')" class="link">
		<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$ships_title}</a></td>
	</tr><tr>
		<td class="unico">
			<div id="naves" style="display:none">
			<table align="center" width="100%">
				{$names}
				{$fleet}
			</table>
			<br >
			</div>
		</td>
	</tr><tr>
		<td class="unico"><a href="javascript:animatedcollapse.toggle('defensa')" class="link">
		<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$defenses_title}</a></td>
	</tr><tr>
		<td class="unico">
			<div id="defensa" style="display:none">
			<table align="center" width="100%">
				{$names}
				{$defense}
			</table>
			<br >
			</div>
		</td>
	</tr><tr>
		<td class="unico"><a href="javascript:animatedcollapse.toggle('inves')" class="link">
		<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$ac_officier_research}</a></td>
	</tr><tr>
		<td class="unico">
			<div id="inves" style="display:none">
			<table align="center" width="60%">
			<tr>
			<th width="50%">{$researchs_title}</th>
			<th width="50%">{$officiers_title}</th>
			</tr>
			{$techoffi}
			</table>
			<br >
			</div>
		</td>
	</tr><tr>
		<td class="unico">
			{if $DestruyeD != 0}<a href="javascript:animatedcollapse.toggle('destr')" class="link">
			<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$ac_recent_destroyed_planets}</a>
			{else}<span class="no_moon"><img src="./styles/images/Adm/arrowright.png" width="16" height="10"> 
			{$ac_recent_destroyed_planets}&nbsp;{$ac_isnodestruyed}</span>{/if}
		</td>
	</tr><tr>
		<td class="unico">
			<div id="destr" style="display:none">
			<table align="center" width="60%">
			<tr>
				<th>{$ac_name}</th>
				<th>{$input_id}</th>
				<th>{$ac_coords}</th>
				<th>{$ac_time_destruyed}</th>
			</tr>
				{$destroyed}
			</table>
			<br>
			</div>
		</td>
	</tr>
</table>
{include file="adm/overall_footer.tpl"}