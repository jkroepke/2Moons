{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    {if $IsLabinBuild}<font color="#ff0000">{$bd_building_lab}</font>{/if}
        <table width="80%" align="center">
		{foreach item=ResearchInfoRow from=$ResearchList}
	        <tr>
				<th class="l" rowspan="2" width="120">
					<a href="javascript:info('{$ResearchInfoRow.id}')">
						<img border="0" src="{$dpath}gebaeude/{$ResearchInfoRow.id}.gif" alt="{$ResearchInfoRow.name}" align="top" width="120" height="120">
					</a>
				</th>
				<td class="c">
					<img src="./styles/images/transparent.gif" alt="" width="0" height="0">&nbsp;<a href="javascript:info({$ResearchInfoRow.id})">{$ResearchInfoRow.name}</a>{if $ResearchInfoRow.lvl != 0} ({$bd_lvl} {$ResearchInfoRow.lvl}){/if}{if $ResearchInfoRow.elvl > 0} <span style="color:lime;">+{$ResearchInfoRow.elvl}</span>{/if} {$ResearchInfoRow.maxinfo}
				</td>
			</tr>
			<tr>
				<td colspan="1" class="l">
					<table border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td style="text-align:left;width:10px"><img src="./styles/images/transparent.gif" alt="" style="width:10px;height:100px"></td>
								<td style="text-align:left;width:90%">{$ResearchInfoRow.descr}<br><br>{$ResearchInfoRow.price}</td>
								<td style="text-align:center;vertical-align:middle;width:100px">
								{$ResearchInfoRow.link}
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
								<td>
									{$bd_remaining}<br>
									{foreach key=ResName item=ResCount from=$ResearchInfoRow.restprice}
									{$ResName}: <b>{$ResCount}</b><br>
									{/foreach}
								</td>
								<td colspan="2" style="text-align:right;white-space:nowrap;">
									<a class="b">{$fgf_time}</a><br><br>
								</td>
							</tr>
							<tr>		
								<td width="68%" rowspan="3">
								</td>
								<td style="text-align:right;white-space:nowrap;">
									{$ResearchInfoRow.time}
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
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}