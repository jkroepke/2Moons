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
th.unico{
border:0px;text-align:left;
}
th.unico2{
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
		<td class="blank"><a onMouseOver='return overlib("{$ac_note_k}", CENTER, OFFSETX, -150, OFFSETY, 5, WIDTH, 250);' onMouseOut='return nd();'>{$ac_leyend}&nbsp; <img src="./styles/images/Adm/i.gif" height="12" width="12"></a></td>
	</tr>
	<tr>
		<td class="unico"><a href="javascript:animatedcollapse.toggle('datos')" class="link">
		<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$ac_account_data}</a></td>
	</tr><tr>
		<td class="unico">
			<div id="datos">
			<table align="center" width="60%">
			<tr><td class="c" colspan="2">&nbsp;</td></tr>
			<tr><th height="22px">{$input_id}</th><th>{$id}</th></tr>
			<tr><th height="22px">{$ac_name}</th><th>{$nombre}</th></tr>
			<tr><th height="22px">{$ac_mail}</th><th>{$email_1}</th></tr>
			<tr><th height="22px">{$ac_perm_mail}</th><th>{$email_2}</th></tr>
			<tr><th height="22px">{$ac_auth_level}</th><th>{$nivel}</th></tr>
			<tr><th height="22px">{$ac_on_vacation}</th><th>{$vacas}</th></tr>
			<tr><th height="22px">{$ac_banned}</th><th>{$suspen} {$mas}</th></tr>
			<tr><th height="22px">{$ac_alliance}</th><th>{$alianza}{$id_ali}</th></tr>
			<tr><th height="22px">{$ac_reg_ip}</th><th>{$ip}</th></tr>
			<tr><th height="22px">{$ac_last_ip}</th><th>{$ip2}</th></tr>
			<tr><th height="22px">{$ac_checkip_title}</th><th>{$ipcheck}</th></tr>
			<tr><th height="22px">{$ac_register_time}</th><th>{$reg_time}</th></tr>
			<tr><th height="22px">{$ac_act_time}</th><th>{$onlinetime}</th></tr>
			<tr><th height="22px">{$ac_home_planet_id}</th><th>{$id_p}</th></tr>
			<tr><th height="22px">{$ac_home_planet_coord}</th><th>[{$g}:{$s}:{$p}]</th></tr>
			{if $info}<tr><th height="22px">{$ac_user_system}</th><th>{$info}</th></tr>{/if}
			<tr><th height="22px">{$ac_ranking}</th><th><a href="javascript:animatedcollapse.toggle('puntaje')">{$ac_see_ranking}</a></th></tr>
			</table>
			<br>
			
			<!-- PUNTAJE DEL USUARIO -->
			<div id="puntaje" style="display:none">
			<table align="center" width="60%">
			<tr><td class="c" colspan="3" class="centrado2">{$ac_user_ranking}</td></tr>
			<td width="15%"></td><td width="40%" class="centrado">{$ac_points_count}</td><td width="5%" class="centrado">{$ac_ranking}</td>
			<tr><th width="15%" class="centrado">{$researchs_title}</th><th width="40%">{$point_tecno} ({$count_tecno} {$researchs_title})</th><th width="5%" class="ranking"># {$ranking_tecno}</th></tr>
			<tr><th width="15%" class="centrado">{$defenses_title}</th><th width="40%">{$point_def} ({$count_def} {$defenses_title})</th><th width="5%" class="ranking"># {$ranking_def}</th></tr>
			<tr><th width="15%" class="centrado">{$ships_title}</th><th width="40%">{$point_fleet} ({$count_fleet} {$ships_title})</th><th width="5%" class="ranking"># {$ranking_fleet}</th></tr>
			<tr><th width="15%" class="centrado">{$buildings_title}</th><th width="40%">{$point_builds} ({$count_builds} {$buildings_title})</th><th width="5%" class="ranking"># {$ranking_builds}</th></tr>
			<tr><th colspan="3" class="total">{$ac_total_points}<font color="#FF0000">{$total_points}</font></th></tr>
			</table>
			<br>
			</div>
			
			
			<div id="banned" style="display:none">
			<table align="center" width="60%">
			<tr><td class="c" colspan="4">{$ac_suspended_title}</td></tr>
			<tr><th>{$ac_suspended_time}</th><th>{$sus_time}</th></tr>
			<tr><th>{$ac_suspended_longer}</th><th>{$sus_longer}</th></tr>
			<tr><th>{$ac_suspended_reason}</th><th>{$sus_reason}</th></tr>
			<tr><th>{$ac_suspended_autor}</th><th>{$sus_author}</th></tr>
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
			<tr><td class="c" colspan="2">{$ac_info_ally}</td></tr>
			<tr><th width="25%" align="center" >{$input_id}</th><th>{$id_aliz}</th></tr>
			<tr><th>{$ac_leader}</th><th>{$ali_lider}</th></tr>
			<tr><th>{$ac_tag}</th><th>{$tag}</th></tr>
			<tr><th>{$ac_name_ali}</th><th>{$ali_nom}</th></tr>
			<tr><th>{$ac_ext_text}</th><th>{$ali_ext}</th></tr>
			<tr><th>{$ac_int_text}</th><th>{$ali_int}</th></tr>
			<tr><th>{$ac_sol_text}</th><th>{$ali_sol}</th></tr>
			<tr><th>{$ac_image}</th><th>{$ali_logo}</th></tr>
			<tr><th>{$ac_ally_web}</th><th>{$ali_web}</th></tr>
			<tr><th>{$ac_register_ally_time}</th><th>{$ally_register_time}</th></tr>
			<tr><th>{$ac_total_members}</th><th>{$ali_cant}</th></tr>
			<tr><th>{$ac_ranking}</th><th><a href="#" rel="toggle[puntaje_ali]">{$ac_see_ranking}</a></th></tr>
			</table>
			<br>

			<div id="imagen" style="display:none">
			<table align="center" width="60%">
			<tr><td class="c">{$ac_ali_logo_11}</td></tr>
			<tr><th width="60%"><img src="{$ali_logo2}" class="image"></th></tr>
			<tr><th><a href="{$ali_logo2}" target="_blank">{$ac_view_image}</a></th></tr>
			<tr><th>{$ac_urlnow} <input type="text" size="50" value="{$ali_logo2}"></th></tr>
			</table>
			<br>
			</div>

			<div id="externo" style="display:none">
			<table align="center" width="60%">
			<tr><td class="c">{$ac_ali_text_11}</td></tr>
			<tr><th width="60%">{$ali_ext2}</th></tr>
			</table>
			<br>
			</div>

			<div id="interno" style="display:none">
			<table align="center" width="60%">
			<tr><td class="c">{$ac_ali_text_22}</td></tr>
			<tr><th width="60%">{$ali_int2}</th></tr>
			</table>
			<br>
			</div>

			<div id="solicitud" style="display:none">
			<table align="center" width="60%">
			<tr><td class="c">{$ac_ali_text_33}</td></tr>
			<tr><th width="60%">{$ali_sol2}</th></tr>
			</table>
			<br>
			</div>

			<!-- PUNTAJE DE LA ALIANZA DEL USUARIO -->
			<div id="puntaje_ali" style="display:none">
			<table align="center" width="60%">
			<tr><td class="c" colspan="3">{$ac_ally_ranking}</td></tr>
			<td width="15%"></td><td width="40%">{$ac_points_count}</td><td width="5%" class="centrado">{$ac_ranking}</td>
			<tr><th width="15%">{$researchs_title}</th><th width="40%">{$point_tecno_ali} ({$count_tecno_ali} {$researchs_title})</th><th width="5%"># {$ranking_tecno_ali}</th></tr>
			<tr><th width="15%">{$defenses_title}</th><th width="40%">{$point_def_ali} ({$count_def_ali} {$defenses_title})</th><th width="5%"># {$ranking_def_ali}</th></tr>
			<tr><th width="15%">{$ships_title}</th><th width="40%">{$point_fleet_ali} ({$count_fleet_ali} {$ships_title})</th><th width="5%"># {$ranking_fleet_ali}</th></tr>
			<tr><th width="15%">{$buildings_title}</th><th width="40%">{$point_builds_ali} ({$count_builds_ali} {$buildings_title})</th><th width="5%"># {$ranking_builds_ali}</th></tr>
			<tr><th colspan="3">{$ac_total_points}<font color="#FF0000">{$total_points_ali}</font></th></tr>
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
				<td class="c">{$ac_name}</td>
				<td class="c">{$input_id}</td>
				<td class="c">{$ac_diameter}</td>
				<td class="c">{$ac_fields}</td>
				<td class="c">{$ac_temperature}</td>
				{if $canedit == 1}<td class="c">{$se_search_edit}</td>{/if}
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
				<td class="c">{$ac_name}</td>
				<td class="c">{$Metal}</td>
				<td class="c">{$Crystal}</td>
				<td class="c">{$Deuterium}</td>
				<td class="c">{$Energy}</td>
			</tr>
				{$resources}
			<tr>
				<th colspan="5" height="30px">{$Darkmatter}: &nbsp;&nbsp;{$mo}</th>
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
			<td class="c" width="50%">{$researchs_title}</td>
			<td class="c" width="50%">{$officiers_title}</td>
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
				<td class="c">{$ac_name}</td>
				<td class="c">{$input_id}</td>
				<td class="c">{$ac_coords}</td>
				<td class="c">{$ac_time_destruyed}</td>
			</tr>
				{$destroyed}
			</table>
			<br >
			</div>
		</td>
	</tr>
</table>
{include file="adm/overall_footer.tpl"}