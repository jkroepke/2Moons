{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <div id="buildlist" style="display:none;"></div>
	<br>
    <table>	
		{foreach item=BuildInfoRow from=$BuildInfoList}
		<tr>
			<td rowspan="2" style="width:120px;">
				<a href="#" onclick="return Dialog.info({$BuildInfoRow.id})">
					<img src="{$dpath}gebaeude/{$BuildInfoRow.id}.gif" alt="{$BuildInfoRow.name}" width="120" height="120">
				</a>
			</td>
			<th>
				<a href="#" onclick="return Dialog.info({$BuildInfoRow.id})">{$BuildInfoRow.name}</a>{if $BuildInfoRow.level > 0} ({$bd_lvl} {$BuildInfoRow.level}){/if}
			</th>
		</tr>
		<tr>
			<td>
				<table style="width:100%">
					<tr>
						<td class="transparent left" style="width:90%;padding:10px;">{$BuildInfoRow.descriptions}<br><br>{$BuildInfoRow.price}</td>
						<td class="transparent" style="vertical-align:middle;width:100px">
						{$BuildInfoRow.BuildLink}
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="margin-bottom:10px;">  
				<table style="width:100%">
					<tr>
						<td class="transparent left">
							{$bd_remaining}<br>
							{foreach key=ResName item=ResCount from=$BuildInfoRow.restprice}
							{$ResName}: <span style="font-weight:700">{$ResCount}</span><br>
							{/foreach}
							<br>
						</td>
						<td class="transparent right">
							{$fgf_time}
						</td>
					</tr>
					<tr>		
						<td class="transparent left" style="width:68%">
							{if $BuildInfoRow.EnergyNeed}
							{$bd_next_level}<br>
							{$BuildInfoRow.EnergyNeed}
							{/if}
							{if $BuildInfoRow.level > 0 && $BuildInfoRow.id != 33}
							<br>{if $BuildInfoRow.id == 43}<a href="javascript:OpenPopup('game.php?page=infos&gid=43', '', 720, 300);">{$bd_jump_gate_action}</a>{/if}<br>
							<a href="#" onmouseover="return overlib('<table style=\'width:100%;margin:0;padding:0\'><tr><th colspan=\'2\'>{$bd_price_for_destroy} {$BuildInfoRow.name} {$BuildInfoRow.level}</th></tr><tr><td class=\'transparent\'>{$Metal}</td><td class=\'transparent\'>{$BuildInfoRow.destroyress.metal}</td></tr><tr><td class=\'transparent\'>{$Crystal}</td><td class=\'transparent\'>{$BuildInfoRow.destroyress.crystal}</td></tr><tr><td class=\'transparent\'>{$Deuterium}</td><td class=\'transparent\'>{$BuildInfoRow.destroyress.deuterium}</td></tr><tr><td class=\'transparent\'>{$bd_destroy_time}</td><td class=\'transparent\'>{$BuildInfoRow.destroytime}</td></tr><tr><td colspan=\'2\' class=\'transparent\'><a href=game.php?page=buildings&amp;cmd=destroy&amp;building={$BuildInfoRow.id}>{$bd_dismantle}</a></td></tr></table>', STICKY, MOUSEOFF, DELAY, 50, CENTER, OFFSETX, 0, OFFSETY, -40, WIDTH, 265);" onmouseout="return nd();">{$bd_dismantle}</a>
							{/if}
							&nbsp;
						</td>
						<td class="transparent right" style="white-space:nowrap;">
							{$BuildInfoRow.time}
						</td>
					</tr>	
				</table>
			</td>
		</tr>
		{/foreach}
    </table>
</div>
{if $data}
<script type="text/javascript">
data	= {$data};
</script>
{/if}
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}