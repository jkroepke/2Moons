{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
	<form action="?page=galaxy&amp;mode=1" method="post" id="galaxy_form">
	<input type="hidden" id="auto" value="dr">
	<table style="min-width:324px;width:324px;">
		<tr>
			<td class="transparent">
				<table>
					<tr>
						<th colspan="3">{lang}gl_galaxy{/lang}</th>
					</tr>
					<tr>
						<td><input type="button" name="galaxyLeft" value="&lt;-" onclick="galaxy_submit('galaxyLeft')"></td>
						<td><input type="text" name="galaxy" value="{$galaxy}" size="5" maxlength="3" tabindex="1"></td>
						<td><input type="button" name="galaxyRight" value="-&gt;" onclick="galaxy_submit('galaxyRight')"></td>
					</tr>
				</table>
			</td>
			<td class="transparent">
				<table>
					<tr>
						<th colspan="3">{lang}gl_solar_system{/lang}</th>
					</tr>
					<tr>
						<td><input type="button" name="systemLeft" value="&lt;-" onclick="galaxy_submit('systemLeft')"></td>
						<td><input type="text" name="system" value="{$system}" size="5" maxlength="3" tabindex="2"></td>
						<td><input type="button" name="systemRight" value="-&gt;" onclick="galaxy_submit('systemRight')"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="background-color:transparent;border:0px;" colspan="2"> 
				<input type="submit" value="{lang}gl_show{/lang}">
			</td>
		</tr>
	</table>
	</form>
	{if $mode == 2}
    <form action="?page=missiles&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}" method="POST">
	<tr>
		<table class="table569">
			<tr>
				<th colspan="2">{lang}gl_missil_launch{/lang} [{$galaxy}:{$system}:{$planet}]</th>
			</tr>
			<tr>
				<td>{$missile_count} <input type="text" name="SendMI" size="2" maxlength="7"></td>
				<td>{lang}gl_objective{/lang}: 
                	{html_options name=Target options=$MissleSelector}
                </td>
			</tr>
			<tr>
				<th colspan="2" style="text-align:center;"><input type="submit" name="aktion" value="{lang}gl_missil_launch_action{/lang}"></th>
			</tr>
		</table>
	</form>
    {/if}
	<table class="table569">
    <tr>
		<th colspan="8">{lang}gl_solar_system{/lang} {$galaxy}:{$system}</th>
	</tr>
	<tr>
		<th style="white-space: nowrap">{lang}gl_pos{/lang}</th>
		<th style="white-space: nowrap">{lang}gl_planet{/lang}</th>
		<th style="white-space: nowrap">{lang}gl_name_activity{/lang}</th>
		<th style="white-space: nowrap">{lang}gl_moon{/lang}</th>
		<th style="white-space: nowrap">{lang}gl_debris{/lang}</th>
		<th style="white-space: nowrap">{lang}gl_player_estate{/lang}</th>
		<th style="white-space: nowrap">{lang}gl_alliance{/lang}</th>
		<th style="white-space: nowrap">{lang}gl_actions{/lang}</th>
	</tr>
    {foreach name=galaxy key=planet item=GalaxyRow from=$GalaxyRows}
	<tr>
	<td><a href="?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1">{$planet}</a></td>
	{if is_array($GalaxyRow)}
	<td><a class="tooltip_sticky" name="<table style='width:220px'><tr><th colspan='2'>{lang}gl_planet{/lang} {$GalaxyRow.planet.name} [{$galaxy}:{$system}:{$planet}]</th></tr><tr><td style='width:80'><img src='{$dpath}planeten/small/s_{$GalaxyRow.planet.image}.jpg' height='75' width=75></td><td>{if $GalaxyRow.planet.spionage}<a href='javascript:doit(6,{$galaxy},{$system},{$planet},1,{$spio_anz});'>{$GalaxyRow.planet.spionage}</a><br><br>{/if}{if $GalaxyRow.planet.phalax}<a href='javascript:OpenPopup(&quot;?page=phalanx&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&quot;, &quot;&quot;, 640, 510);'>{$GalaxyRow.planet.phalax}</a><br>{/if}{if $GalaxyRow.planet.attack}<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=1'>{$GalaxyRow.planet.attack}</a><br>{/if}{if $GalaxyRow.planet.stayally}<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=5'>{$GalaxyRow.planet.stayally}</a><br>{/if}{if $GalaxyRow.planet.stay}<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=4'>{$GalaxyRow.planet.stay}</a><br>{/if}{if $GalaxyRow.planet.transport}<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=3'>{$GalaxyRow.planet.transport}</a><br>{/if}{if $GalaxyRow.planet.missile}<a href='?page=galaxy&amp;mode=2&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}'>{$GalaxyRow.planet.missile}</a><br>{/if}</td></tr></table>"><img src="{$dpath}planeten/small/s_{$GalaxyRow.planet.image}.jpg" height="30" width="30" alt=""></a></td>
	<td style="white-space: nowrap;">{$GalaxyRow.planetname.name} {$GalaxyRow.planetname.activity}</td>
	<td style="white-space: nowrap;">{if $GalaxyRow.moon}<a class="tooltip_sticky" name="<table style='width:240px'><tr><th colspan='2'>{lang}gl_moon{/lang} {$GalaxyRow.moon.name} [{$galaxy}:{$system}:{$planet}]</th></tr><tr><td style='width:80'><img src='{$dpath}planeten/mond.jpg' height='75' style='width:75'></td><td><table style='width:100%'><tr><th colspan='2'>{lang}gl_features{/lang}</th></tr><tr><td>{lang}gl_diameter{/lang}</td><td>{$GalaxyRow.moon.diameter}</td></tr><tr><td>{lang}gl_temperature{/lang}</td><td>{$GalaxyRow.moon.temp_min}</td></tr><tr><th colspan=2>{lang}gl_actions{/lang}</th></tr><tr><td colspan='2'>{if $GalaxyRow.moon.attack}<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=1'>{$GalaxyRow.moon.attack}</a><br>{/if}<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=3'>{$GalaxyRow.moon.transport}</a>{if $GalaxyRow.moon.stay}<br><a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=4'>{$GalaxyRow.moon.stay}</a>{/if}{if $GalaxyRow.moon.stayally}<br><a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=5'>{$GalaxyRow.moon.stayally}</a>{/if}{if $GalaxyRow.moon.spionage}<br><a href='javascript:doit(6,{$galaxy},{$system},{$planet},3,{$spio_anz});'>{$GalaxyRow.moon.spionage}</a>{/if}{if $GalaxyRow.moon.destroy}<br><br><a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=9'>{$GalaxyRow.moon.destroy}</a><br>{/if}{if $GalaxyRow.action.missle}<a href='?page=galaxy&amp;mode=2&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;type=3'>{lang}gl_missile_attack{/lang}</a><br>{/if}</td></tr></table></td></tr></table>"><img src="{$dpath}planeten/small/s_mond.jpg" height="22" width="22" alt="{$GalaxyRow.moon.name}"></a>{/if}</td>
	<td style="white-space: nowrap;">{if $GalaxyRow.derbis}<a class="tooltip_sticky" name="<table style='width:240px'><tr><th colspan='2'>{lang}gl_debris_field{/lang} [{$galaxy}:{$system}:{$planet}]</th></tr><tr><td style='width:80'><img src='{$dpath}planeten/debris.jpg' height='75' style='width:75'></td><td><table style='width:100%'><tr><th colspan='2'>{lang}gl_resources{/lang}:</th></tr><tr><td>{$Metal}: </td><td>{$GalaxyRow.derbis.metal}</td></tr><tr><td>{$Crystal}: </td><td>{$GalaxyRow.derbis.crystal}</td></tr>{if $GalaxyRow.derbis.recycle}<tr><th colspan='2'>{lang}gl_actions{/lang}</th></tr><tr><td colspan='2'><a href='javascript:doit(8,{$galaxy},{$system},{$planet}, 2, &quot;{$GalaxyRow.derbis.GRecSended}|{$GalaxyRow.derbis.RecSended}&quot;);'>{$GalaxyRow.derbis.recycle}</a></td></tr>{/if}</table></td></tr></table>"><img src="{$dpath}planeten/debris.jpg" height="22" width="22" alt=""></a>{/if}</td>
	<td><a class="tooltip_sticky" name="<table style='width:240px'><tr><th colspan='2'>{$GalaxyRow.user.playerrank}</th></tr><tr>{if $GalaxyRow.user.isown}<tr><td><a href='javascript:OpenPopup(&quot;?page=buddy&amp;mode=2&amp;u={$GalaxyRow.user.id}&quot;, &quot;&quot;, 720, 300);'>{lang}gl_buddy_request{/lang}</a></td></tr><td><a href='#' onclick='return Dialog.Playercard({$GalaxyRow.user.id}, &quot;{$GalaxyRow.user.username}&quot;);'>{lang}gl_playercard{/lang}</a></td></tr>{/if}<tr><td><a href='?page=statistics&amp;who=1&amp;start={$GalaxyRow.user.rank}'>{lang}gl_see_on_stats{/lang}</a></td></tr></table>">{$GalaxyRow.user.Systemtatus}{$GalaxyRow.user.username}{if $GalaxyRow.user.Systemtatus}</span>{/if}{$GalaxyRow.user.Systemtatus2}</a></td>
	<td style="white-space: nowrap;">{if $GalaxyRow.ally}<a class="tooltip_sticky" name="<table style='width:240px'><tr><th>{lang}gl_alliance{/lang} {$GalaxyRow.ally.name} {$GalaxyRow.ally.member}</th></tr><td><table><tr><td><a href='?page=alliance&amp;mode=ainfo&amp;a={$GalaxyRow.ally.id}'>{lang}gl_alliance_page{/lang}</a></td></tr><tr><td><a href='?page=statistics&amp;start={$GalaxyRow.ally.rank}&amp;who=2'>{lang}gl_see_on_stats{/lang}</a></td></tr>{if $GalaxyRow.ally.web}<tr><td><a href='{$GalaxyRow.ally.web}' target='allyweb'>{lang}gl_alliance_web_page{/lang}</td></tr>{/if}</table></td></table>">{if $GalaxyRow.ally.inally == 2}<span style="color:lime">{$GalaxyRow.ally.tag}</span>{elseif $GalaxyRow.ally.inally == 1}<span class="allymember">{$GalaxyRow.ally.tag}</span>{else}{$GalaxyRow.ally.tag}{/if}</a>{else}-{/if}</td>
	<td style="white-space: nowrap;">{if $GalaxyRow.action}{if $GalaxyRow.action.esp}<a href="javascript:doit(6,{$galaxy},{$system},{$planet},1,{$spio_anz});"><img src="{$dpath}img/e.gif" title="{lang}gl_spy{/lang}" alt=""></a>&nbsp;{/if}{if $GalaxyRow.action.message}<a href="#" onclick="return Dialog.PM({$GalaxyRow.user.id});"><img src="{$dpath}img/m.gif" title="{lang}write_message{/lang}" alt=""></a>&nbsp;{/if}{if $GalaxyRow.action.buddy}<a href="javascript:OpenPopup('?page=buddy&amp;mode=2&amp;u={$GalaxyRow.user.id}', '', 720, 300);"><img src="{$dpath}img/b.gif" title="{lang}gl_buddy_request{/lang}" alt=""></a>&nbsp;{/if}{if $GalaxyRow.action.missle}<a href="?page=galaxy&amp;mode=2&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;type=1"><img src="{$dpath}img/r.gif" title="{lang}gl_missile_attack{/lang}" alt=""></a>{/if}{else}-{/if}</td>
	{elseif !empty($GalaxyRow)}
	<td></td><td style="white-space: nowrap;">{$GalaxyRow}</td><td style="white-space: nowrap;"></td><td style="white-space: nowrap;"></td><td></td><td></td><td style="white-space: nowrap;"></td>
	{else}
	<td></td><td style="white-space: nowrap;"></td><td style="white-space: nowrap;"></td><td style="white-space: nowrap;"></td><td></td><td></td><td style="white-space: nowrap;"></td>
	{/if}
	</tr>
	{/foreach}
	<tr>
		<td>{$smarty.foreach.galaxy.total + 1}</td>
		<td colspan="7"><a href="?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$smarty.foreach.galaxy.total + 1}&amp;planettype=1&amp;target_mission=15">{lang}gl_out_space{/lang}</a></td>
	</tr>
	<tr>
		<td colspan="6">({$planetcount})</td>
		<td colspan="2">
			<a class="tooltip" name="<table style='width:240px'><tr><th colspan='2'>{lang}gl_legend{/lang}</td></tr><tr><td style='width:220px'>{lang}gl_strong_player{/lang}</td><td><span class='strong'>{lang}gl_s{/lang}</span></td></tr><tr><td style='width:220px'>{lang}gl_week_player{/lang}</td><td><span class='noob'>{lang}gl_w{/lang}</span></td></tr><tr><td style='width:220px'>{lang}gl_vacation{/lang}</td><td><span class='vacation'>{lang}gl_v{/lang}</span></td></tr><tr><td style='width:220px'>{lang}gl_banned{/lang}</td><td><span class='banned'>{lang}gl_b{/lang}</span></td></tr><tr><td style='width:220px'>{lang}gl_inactive_seven{/lang}</td><td><span class='inactive'>{lang}gl_i{/lang}</span></td></tr><tr><td style='width:220px'>{lang}gl_inactive_twentyeight{/lang}</td><td><span class='longinactive'>{lang}gl_I{/lang}</span></td></tr></table>">{lang}gl_legend{/lang}</a> 
		</td>
	</tr>
	<tr>
		<td colspan="3"><span id="missiles">{$currentmip}</span> {lang}gl_avaible_missiles{/lang}</td>
		<td colspan="5"><span id="slots">{$maxfleetcount}</span>/{$fleetmax} {lang}gl_fleets{/lang}</td>
	</tr>
	<tr>
		<td colspan="3">
			<span id="probes">{$spyprobes}</span> {lang}gl_avaible_spyprobes{/lang}
		</td>
		<td colspan="3">
			<span id="recyclers">{$recyclers}</span> {lang}gl_avaible_recyclers{/lang}
		</td>
		<td colspan="2">
			<span id="grecyclers">{$grecyclers}</span> {lang}gl_avaible_grecyclers{/lang}
		</td>
	</tr>
	<tr style="display: none;" id="fleetstatusrow">
		<th colspan="8">{lang}cff_fleet_target{/lang}
	</tr>
	</table>
	<script type="text/javascript">
		status_ok		= '{lang}gl_ajax_status_ok{/lang}';
		status_fail		= '{lang}gl_ajax_status_fail{/lang}';
		MaxFleetSetting = {$settings_fleetactions};
	</script>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}