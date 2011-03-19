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
							<br>{if $BuildInfoRow.id == 43}<a href="#" onclick="return Dialog.info({$BuildInfoRow.id})">{$bd_jump_gate_action}</a>{/if}<br>
							<a class="tooltip_sticky" name="<table style='width:300px'><tr><th colspan='2'>{$bd_price_for_destroy} {$BuildInfoRow.name} {$BuildInfoRow.level}</th></tr><tr><td>{$Metal}</td><td>{$BuildInfoRow.destroyress.metal}</td></tr><tr><td>{$Crystal}</td><td>{$BuildInfoRow.destroyress.crystal}</td></tr><tr><td>{$Deuterium}</td><td>{$BuildInfoRow.destroyress.deuterium}</td></tr><tr><td>{$bd_destroy_time}</td><td>{$BuildInfoRow.destroytime}</td></tr><tr><td colspan='2'><a href='?page=buildings&amp;cmd=destroy&amp;building={$BuildInfoRow.id}'>{$bd_dismantle}</a></td></tr></table>">{$bd_dismantle}</a>
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