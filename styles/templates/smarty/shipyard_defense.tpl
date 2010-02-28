{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
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
		{foreach name=DefenseList item=DefenseListRow from=$DefenseList}
		<tr>
			<th class="l" rowspan="2" width="120">
				<a href="javascript:info({$DefenseListRow.id});">
					<img border="0" src="{$dpath}gebaeude/{$DefenseListRow.id}.gif" alt="{$DefenseListRow.name}" align="top" width="120" height="120">
				</a>
			</th>
			<td class="c">
				<img src="./styles/images/transparent.gif" alt="" width="0" height="0">&nbsp;<a href="javascript:info({$DefenseListRow.id});">{$DefenseListRow.name}</a>{if $DefenseListRow.Available != 0} ({$bd_available} {$DefenseListRow.Available}){/if}
			</td>
		</tr>
		<tr>
			<td colspan="1" class="l">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td style="text-align:left;width:10px"><img src="./styles/images/transparent.gif" alt="" style="width:10px;height:100px"></td>
							<td style="text-align:left;width:90%">{$DefenseListRow.descriptions}<br><br>{$DefenseListRow.price}</td>
							<td style="text-align:center;vertical-align:middle;width:100px">
							{if $DefenseListRow.AlreadyBuild}<font color="red">{$bd_protection_shield_only_one}</font>{elseif $NotBuilding && $DefenseListRow.IsAvailable}<input type="text" name="fmenge[{$DefenseListRow.id}]" id="input_{$DefenseListRow.id}" size="7" maxlength="7" value="0" tabindex="{$smarty.foreach.DefenseList.iteration}">
							<br><br>
							<input type="button" value="Max" onclick="$('#input_{$DefenseListRow.id}').val(maxcount({$DefenseListRow.id}))">
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
								{foreach key=ResName item=ResCount from=$DefenseListRow.restprice}
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
								{$DefenseListRow.time}
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
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}