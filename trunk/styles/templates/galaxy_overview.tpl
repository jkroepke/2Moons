{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
	<form action="game.php?page=galaxy&amp;mode=1" method="post" id="galaxy_form">
	<input type="hidden" id="auto" value="dr">
	<table style="min-width:324px;width:324px;">
	  <tr>
		<td class="transparent">
		  <table>
			<tr>
			 <th colspan="3">{$gl_galaxy}</th>
			</tr>
			<tr>
			  <td><input type="button" name="galaxyLeft" value="&lt;-" onClick="galaxy_submit('galaxyLeft')"></td>
			  <td><input type="text" name="galaxy" value="{$galaxy}" size="5" maxlength="3" tabindex="1"></td>
			  <td><input type="button" name="galaxyRight" value="-&gt;" onClick="galaxy_submit('galaxyRight')"></td>
			</tr>
		   </table>
		  </td>
		  <td class="transparent">
		   <table>
			<tr>
			 <th colspan="3">{$gl_solar_system}</th>
			</tr>
			 <tr>
			  <td><input type="button" name="systemLeft" value="&lt;-" onClick="galaxy_submit('systemLeft')"></td>
			  <td><input type="text" name="system" value="{$system}" size="5" maxlength="3" tabindex="2"></td>
			  <td><input type="button" name="systemRight" value="-&gt;" onClick="galaxy_submit('systemRight')"></td>
			 </tr>
			</table>
		   </td>
		  </tr>
		  <tr>
			<td style="background-color:transparent;border:0px;" colspan="2"> 
				<input type="submit" value="{$gl_show}">
			</td>
		  </tr>
	</table>
	</form>
	{if $mode == 2}
    <form action="game.php?page=missiles&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}" metdod="POST">
	<tr>
		<table class="table569">
			<tr>
				<th colspan="2">{$gl_missil_launch} [{$galaxy}:{$system}:{$planet}]</th>
			</tr>
			<tr>

				<td>{$missile_count} <input type="text" name="SendMI" size="2" maxlength="7"></td>
				<td>{$gl_objective}: 
                	{html_options name=Target options=$MissleSelector}
                </td>
			</tr>
			<tr>
				<th colspan="2" style="text-align:center;"><input type="submit" name="aktion" value="{$gl_missil_launch_action}"></th>
			</tr>
		</table>
	</form>
    {/if}
	<table class="table569">
    <tr>
		<th colspan="8">{$gl_solar_system} {$galaxy}:{$system}</th>
	</tr>
	<tr>
		<th style="white-space: nowrap;">{$gl_pos}</th>
		<th style="white-space: nowrap;">{$gl_planet}</th>
		<th style="white-space: nowrap;">{$gl_name_activity}</th>
		<th style="white-space: nowrap;">{$gl_moon}</th>
		<th style="white-space: nowrap;">{$gl_debris}</th>
		<th style="white-space: nowrap;">{$gl_player_estate}</th>
		<th style="white-space: nowrap;">{$gl_alliance}</th>
		<th style="white-space: nowrap;">{$gl_actions}</th>
	</tr>
    {foreach key=planet item=GalaxyRow from=$GalaxyRows}
	<tr>
	<td width="30"><a href="game.php?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1">{$planet}</a></td>
	{if is_array($GalaxyRow)}
	<td width="30"><a style="cursor: pointer;" onmouseover="return overlib('<table width=240><tr><th colspan=2>{$gl_planet} {$GalaxyRow.planet.name} [{$galaxy}:{$system}:{$planet}]</th></tr><tr><td width=80><img src={$dpath}planeten/small/s_{$GalaxyRow.planet.image}.jpg height=75 width=75></td><td align=left>{if $GalaxyRow.planet.spionage}<a href=\'javascript:doit(6,{$galaxy},{$system},{$planet},1,{$spio_anz});\'>{$GalaxyRow.planet.spionage}</a><br><br>{/if}{if $GalaxyRow.planet.phalax}<a href=javascript:playercard(\'game.php?page=phalanx&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1\');>{$GalaxyRow.planet.phalax}</a><br>{/if}{if $GalaxyRow.planet.attack}<a href=game.php?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=1>{$GalaxyRow.planet.attack}</a><br>{/if}{if $GalaxyRow.planet.stayally}<a href=game.php?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=5>{$GalaxyRow.planet.stayally}</a><br>{/if}{if $GalaxyRow.planet.stay}<a href=game.php?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=4>{$GalaxyRow.planet.stay}</a><br>{/if}{if $GalaxyRow.planet.transport}<a href=game.php?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=3>{$GalaxyRow.planet.transport}</a><br>{/if}{if $GalaxyRow.planet.missile}<a href=game.php?page=galaxy&amp;mode=2&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}>{$GalaxyRow.planet.missile}</a><br>{/if}</td></tr></table>', STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );" onmouseout='return nd();'><img src="{$dpath}planeten/small/s_{$GalaxyRow.planet.image}.jpg" height="30" width="30" alt=""></a></td>
	<td style="white-space: nowrap;" width="130">{$GalaxyRow.planetname.name} {$GalaxyRow.planetname.activity}</td>
	<td style="white-space: nowrap;" width="30">{if $GalaxyRow.moon}<a style="cursor: pointer;" onmouseover="return overlib('<table width=240><tr><th colspan=2>{$gl_moon} {$GalaxyRow.moon.name} [{$galaxy}:{$system}:{$planet}]</th></tr><tr><td width=80><img src={$dpath}planeten/mond.jpg height=75 width=75></td><td><table width=100%><tr><td class=c colspan=2>{$gl_features}</td></tr><tr><td>{$gl_diameter}</td><td>{$GalaxyRow.moon.diameter}</td></tr><tr><td>{$gl_temperature}</td><td>{$GalaxyRow.moon.temp_min}</td></tr><tr><td class=c colspan=2>{$gl_actions}</td></tr><tr><td colspan=2>{if $GalaxyRow.moon.attack}<a href=game.php?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=1>{$GalaxyRow.moon.attack}</a><br>{/if}<a href=game.php?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=3>{$GalaxyRow.moon.transport}</a>{if $GalaxyRow.moon.stay}<br><a href=game.php?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=4>{$GalaxyRow.moon.stay}</a>{/if}{if $GalaxyRow.moon.stayally}<br><a href=game.php?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=5>{$GalaxyRow.moon.stayally}</a>{/if}{if $GalaxyRow.moon.spionage}<br><a href=\'javascript:doit(6,{$galaxy},{$system},{$planet},3,{$spio_anz});\'>{$GalaxyRow.moon.spionage}</a>{/if}{if $GalaxyRow.moon.destroy}<br><br><a href=game.php?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=9>{$GalaxyRow.moon.destroy}</a><br>{/if}</td></tr></table></td></tr></table>', STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );" onmouseout="return nd();"><img src="{$dpath}planeten/small/s_mond.jpg" height="22" width="22" alt="{$GalaxyRow.moon.name}"></a>{/if}</td>
	<td style="white-space: nowrap;" width="30">{if $GalaxyRow.derbis}<a style="cursor: pointer;" onmouseover="return overlib('<table width=240><tr><th colspan=2>{$gl_debris_field} [{$galaxy}:{$system}:{$planet}]</th></tr><tr><td width=80><img src={$dpath}planeten/debris.jpg height=75 width=75></td><td><table align=center width=100%><tr><td class=c colspan=2>{$gl_resources}:</td></tr><tr><td>{$Metal}: </td><td>{$GalaxyRow.derbis.metal}</td></tr><tr><td>{$Crystal}: </td><td>{$GalaxyRow.derbis.crystal}</td></tr><tr><td class=c colspan=2>{$gl_actions}</td></tr><tr><td colspan=2 align=left><a href=\'javascript:doit(8,{$galaxy},{$system},{$planet},2,&quot;{$GalaxyRow.derbis.GRecSended}|{$GalaxyRow.derbis.RecSended}&quot;);\'>{$gl_collect}</a></tr></table></td></tr></table>', STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );" onmouseout='return nd();'><img src="{$dpath}planeten/debris.jpg" height="22" width="22" alt=""></a>{/if}</td>
	<td width="150"><a style="cursor: pointer;" onmouseover="return overlib('<table width=190><tr><th colspan=2>{$GalaxyRow.user.playerrank}</th></tr><tr>{if $GalaxyRow.user.isown}<tr><td><a href=\'javascript:f(&quot;game.php?page=buddy&amp;mode=2&amp;u={$GalaxyRow.user.id}&quot;);\'>{$gl_buddy_request}</a></td></tr><td><a href=javascript:playercard(\'game.php?page=playercard&amp;id={$GalaxyRow.user.id}\')>{$gl_playercard}</a></td></tr>{/if}<tr><td><a href=game.php?page=statistics&amp;who=1&amp;start={$GalaxyRow.user.rank}>{$gl_see_on_stats}</a></td></tr></table>', STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );" onmouseout='return nd();'>{$GalaxyRow.user.Systemtatus}{$GalaxyRow.user.username}{if $GalaxyRow.user.Systemtatus}</span>{/if}{$GalaxyRow.user.Systemtatus2}</a></td>
	<td style="white-space: nowrap;" width="80">{if $GalaxyRow.ally}<a style="cursor: pointer;" onmouseover='return overlib("<table width=240><tr><th>{$gl_alliance} {$GalaxyRow.ally.name} {$gl_witd} {$GalaxyRow.ally.member}</th></tr><td><table align=center><tr><td><a href=game.php?page=alliance&amp;mode=ainfo&amp;a={$GalaxyRow.ally.id}>{$gl_alliance_page}</a></td></tr><tr><td><a href=game.php?page=statistics&amp;start={$GalaxyRow.ally.rank}&amp;who=2>{$gl_see_on_stats}</a></td></tr>{if $GalaxyRow.ally.web}<tr><td><a href={$GalaxyRow.ally.web} target=allyweb>{$gl_alliance_web_page}</td></tr>{/if}</table></td></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );' onmouseout='return nd();'>{if $GalaxyRow.ally.inally == 2}<font color="lime">{$GalaxyRow.ally.tag}</font>{elseif $GalaxyRow.ally.inally == 1}<span class="allymember">{$GalaxyRow.ally.tag}</span>{else}{$GalaxyRow.ally.tag}{/if}</a>{else}-{/if}</td>
	<td style="white-space: nowrap;" width="125">{if $GalaxyRow.action.esp}<a href="javascript:doit(6,{$galaxy},{$system},{$planet},1,{$spio_anz});"><img src="{$dpath}img/e.gif" title="{$gl_spy}" border="0" alt=""></a>&nbsp;{/if}{if $GalaxyRow.action.message}<a href="javascript:f('game.php?page=messages&amp;mode=write&amp;id={$GalaxyRow.user.id}');"><img src="{$dpath}img/m.gif" title="{$write_message}" border="0" alt=""></a>&nbsp;{/if}{if $GalaxyRow.action.buddy}<a href="javascript:f('game.php?page=buddy&amp;mode=2&amp;u={$GalaxyRow.user.id}');"><img src="{$dpath}img/b.gif" title="{$gl_buddy_request}" border="0" alt=""></a>&nbsp;{/if}{if $GalaxyRow.action.missle}<a href="?page=galaxy&amp;mode=2&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}"><img src="{$dpath}img/r.gif" title="{$gl_missile_attack}" border="0" alt=""></a>{/if}</td>
	{elseif !empty($GalaxyRow)}
	<td width="30"></td><td style="white-space: nowrap;" width="130">{$GalaxyRow}</td><td style="white-space: nowrap;" width="30"></td><td style="white-space: nowrap;" width="30"></td><td width="150"></td><td width="80"></td><td style="white-space: nowrap;" width="125"></td>
	{else}
	<td width="30"></td><td style="white-space: nowrap;" width="130"></td><td style="white-space: nowrap;" width="30"></td><td style="white-space: nowrap;" width="30"></td><td width="150"></td><td width="80"></td><td style="white-space: nowrap;" width="125"></td>
	{/if}
	</tr>
	{/foreach}
	<tr>
		<td width="30">{$smarty.const.MAX_PLANET_IN_SYSTEM + 1}</td>
		<td colspan="7"><a href="game.php?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$smarty.const.MAX_PLANET_IN_SYSTEM + 1}&amp;planettype=1&amp;target_mission=15">{$gl_out_space}</a></td>
	</tr>
	<tr>
		<td class="c" colspan="6">({$planetcount})</td>
		<td class="c" colspan="2">
			<a href="#" style="cursor: pointer;" onmouseover='return overlib("<table width=240><tr><td class=c colspan=2>{$gl_legend}</td></tr><tr><td width=220>{$gl_strong_player}</td><td><span class=strong>{$gl_s}</span></td></tr><tr><td width=220>{$gl_week_player}</td><td><span class=noob>{$gl_w}</span></td></tr><tr><td width=220>{$gl_vacation}</td><td><span class=vacation>{$gl_v}</span></td></tr><tr><td width=220>{$gl_banned}</td><td><span class=banned>{$gl_b}</span></td></tr><tr><td width=220>{$gl_inactive_seven}</td><td><span class=inactive>{$gl_i}</span></td></tr><tr><td width=220>{$gl_inactive_twentyeight}</td><td><span class=longinactive>{$gl_I}</span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -150, OFFSETY, -150 );' onmouseout='return nd();'>{$gl_legend}</a> 
		</td>
	</tr>
	<tr>
		<td class="c" colspan="3"><span id="missiles">{$currentmip}</span> {$gl_avaible_missiles}</td>
		<td class="c" colspan="5"><span id="slots">{$maxfleetcount}</span>/{$fleetmax} {$gl_fleets}</td>
	</tr>
	<tr>
		<td class="c" colspan="3">
			<span id="probes">{$spyprobes}</span> {$gl_avaible_spyprobes}
		</td>
		<td class="c" colspan="3">
			<span id="recyclers">{$recyclers}</span> {$gl_avaible_recyclers}
		</td>
		<td class="c" colspan="2">
			<span id="grecyclers">{$grecyclers}</span> {$gl_avaible_grecyclers}
		</td>
	</tr>
	<tr style="display: none;" id="fleetstatusrow">
		<td class="c" colspan="8">
			<table style="font-weight: bold" width="100%" id="fleetstatustable">
				<tr style="display:none;"><td colspan="3"></td></tr>
				<!-- will be filled witd content later on while processing ajax replys -->
			</table>
		</td>
	</tr>
	</table>
	<script type="text/javascript">
		status_ok		= '{$gl_ajax_status_ok}';
		status_fail		= '{$gl_ajax_status_fail}';
		MaxFleetSetting = {$settings_fleetactions} - 1;
	</script>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}