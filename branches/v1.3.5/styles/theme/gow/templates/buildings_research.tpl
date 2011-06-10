{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
	<div id="buildlist" style="display:none;"></div>
    {if $IsLabinBuild}<table width="70%" id="infobox" style="border: 2px solid red; text-align:center;background:transparent"><tr><td>{$bd_building_lab}</td></tr></table><br><br>{/if}
    <table>	
		{foreach item=ResearchInfoRow from=$ResearchList}
		<tr>
			<td rowspan="2" style="width:120px;">
				<a href="#" onclick="return Dialog.info({$ResearchInfoRow.id})">
					<img src="{$dpath}gebaeude/{$ResearchInfoRow.id}.gif" alt="{$ResearchInfoRow.name}" class="top" width="120" height="120">
				</a>
			</td>
			<th>
				<a href="#" onclick="return Dialog.info({$ResearchInfoRow.id})">{$ResearchInfoRow.name}</a>{if $ResearchInfoRow.lvl != 0} ({$bd_lvl} {$ResearchInfoRow.lvl}){/if}{if $ResearchInfoRow.elvl > 0} <span style="color:lime;">+{$ResearchInfoRow.elvl}</span>{/if} {$ResearchInfoRow.maxinfo}
			</th>
		</tr>
		<tr>
			<td>
				<table style="width:100%">
					<tr>
						<td class="transparent left" style="width:90%;padding:10px;">{$ResearchInfoRow.descr}<br><br>{$ResearchInfoRow.price}</td>
						<td class="transparent" style="vertical-align:middle;width:100px">
						{$ResearchInfoRow.link}
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
							{foreach key=ResName item=ResCount from=$ResearchInfoRow.restprice}
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
							&nbsp;
						</td>
						<td class="transparent right" style="white-space:nowrap;">
							{$ResearchInfoRow.time}
						</td>
					</tr>	
				</table>
			</td>
		</tr>
		{/foreach}
    </table>
</div>
{if $ScriptInfo}
<script type="text/javascript">
data	= {$ScriptInfo};
</script>
{/if}
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}