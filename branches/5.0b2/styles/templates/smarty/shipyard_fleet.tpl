{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content">
	{if !$NotBuilding}<font color="red">{$bd_building_shipyard}</font><br>{/if}
	{if $BuildList}
    <table width="80%" align="center">
		<tr>
			<td style="text-align: center;">
			{$BuildList}
			</td>
		</tr>
    </table>
	<br>
	{/if}
	<form action="" method="POST">
    <table width="80%" align="center">	
		{foreach name=FleetList item=FleetListRow from=$FleetList}
		<tr>
			<th class="l" rowspan="2" width="120">
				<a href="javascript:info({$FleetListRow.id});">
					<img border="0" src="{$dpath}gebaeude/{$FleetListRow.id}.gif" alt="{$FleetListRow.name}" align="top" width="120" height="120">
				</a>
			</th>
			<td class="c">
				<img src="./styles/images/transparent.gif" alt="" width="0" height="0">&nbsp;<a href="javascript:info({$FleetListRow.id});">{$FleetListRow.name}</a>{if $FleetListRow.Available != 0} ({$bd_available} {$FleetListRow.Available}){/if}
			</td>
		</tr>
		<tr>
			<td colspan="1" class="l">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td style="text-align:left;width:10px"><img src="./styles/images/transparent.gif" alt="" width="0" height="100"></td>
							<td style="text-align:left;width:90%">{$FleetListRow.descriptions}<br><br>{$FleetListRow.price}</td>
							<td style="text-align:center;vertical-align:middle;width:100px">
							{if $NotBuilding && $FleetListRow.IsAvailable}<input type="text" name="fmenge[{$FleetListRow.id}]" id="input_{$FleetListRow.id}" size="7" maxlength="7" value="0" tabindex="{$smarty.foreach.FleetList.iteration}">							<br><br>
							<input type="button" value="Max" onclick="$('#input_{$FleetListRow.id}').val(maxcount({$FleetListRow.id}))">
							{/if}
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
								{foreach key=ResName item=ResCount from=$FleetListRow.restprice}
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
								&nbsp;
							</td>
							<td style="text-align:right;white-space:nowrap;">
								{$FleetListRow.time}
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
		{if $NotBuilding}<tr><td class="c" colspan="2" style="text-align:center"><input type="submit" value="{$bd_build_ships}"></td></tr>{/if}
    </table>
	</form>
	<br>
	<br>
</div>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}