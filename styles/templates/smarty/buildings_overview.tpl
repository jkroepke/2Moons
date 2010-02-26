{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
{$BuildListScript}
	{if $BuildList}
    <table width="80%" align="center">
        {$BuildList}
    </table>
	<br>
	{/if}
    <table width="80%" align="center">	
		{foreach item=BuildInfoRow from=$BuildInfoList}
		<tr>
			<th class="l" rowspan="2" width="120">
				<a href="javascript:info({$BuildInfoRow.id});">
					<img border="0" src="{$dpath}gebaeude/{$BuildInfoRow.id}.gif" alt="{$BuildInfoRow.name}" align="top" width="120" height="120">
				</a>
			</th>
			<td class="c">
				<img src="./styles/images/transparent.gif" alt="" width="0" height="0">&nbsp;<a href="javascript:info({$BuildInfoRow.id});">{$BuildInfoRow.name}</a>{if $BuildInfoRow.level > 0} ({$bd_lvl} {$BuildInfoRow.level}){/if}
			</td>
		</tr>
		<tr>
			<td colspan="1" class="l">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td style="text-align:left;width:10px"><img src="./styles/images/transparent.gif" alt="" width="0" height="100"></td>
							<td style="text-align:left;width:90%">{$BuildInfoRow.descriptions}<br><br>{$BuildInfoRow.price}</td>
							<td style="text-align:center;vertical-align:middle;width:100px">
							{$BuildInfoRow.BuildLink}
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding:0px;" class="b">  
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td style="text-align:left;">
								{$bd_remaining}<br>
								{foreach key=ResName item=ResCount from=$BuildInfoRow.restprice}
								{$ResName}: <b>{$ResCount}</b><br>
								{/foreach}
								<br>
							</td>
							<td colspan="2" style="text-align:right;">
								{$fgf_time}
							</td>
						</tr>
						<tr>		
							<td width="68%" rowspan="3" style="text-align:left;">
								{if $BuildInfoRow.EnergyNeed}
								{$bd_next_level}<br>
								{$BuildInfoRow.EnergyNeed}
								{/if}
								{if $BuildInfoRow.level > 0}
								<br>{if $BuildInfoRow.id == 43}<a href="javascript:f('game.php?page=infos&gid=43','');">{$bd_jump_gate_action}</a>{/if}<br>
								<a href="#" onmouseover='return overlib("<table width=100% cellpadding=2 cellspacing=0><tr><td class=c colspan=2 style=text-align:center;>Kosten f&uuml;r Abriss {$BuildInfoRow.name} {$BuildInfoRow.level}</td></tr><tr><th>{$Metal}</th><th>{$BuildInfoRow.destroyress.metal}</th></tr><tr><th>{$Crystal}</th><th>{$BuildInfoRow.destroyress.crystal}</th></tr><tr><th>{$Deuterium}:</th><th>{$BuildInfoRow.destroyress.deuterium}</th></tr><tr><th>Dauer:</th><th>{$BuildInfoRow.destroytime}</th></tr><tr><th colspan=2><a href=game.php?page=buildings&amp;cmd=destroy&amp;building={$BuildInfoRow.id}>{$bd_dismantle}</a></th></tr></table>", STICKY, MOUSEOFF, DELAY, 50, CENTER, OFFSETX, 0, OFFSETY, -40, WIDTH, 265);' onmouseout="return nd();">{$bd_dismantle}</a>
								{/if}
								&nbsp;
							</td>
							<td style="text-align:right;white-space:nowrap;">
								{$BuildInfoRow.time}
							</td>
						</tr>	
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2"><img src="./styles/images/transparent.gif" alt="" width="1" height="10"></td>
		</tr>
		{/foreach}
    </table>
</div>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}