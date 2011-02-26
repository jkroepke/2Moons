{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
	{if !$NotBuilding}<table width="70%" id="infobox" style="border: 2px solid red; text-align:center;background:transparent"><tr><td>{$bd_building_shipyard}</td></tr></table><br><br>{/if}
	{if $BuildList != '[]'}
    <table>
		<tr>
			<td class="transparent">
				<div id="bx" class="z"></div>
				<br>
				<form method="POST" action="">
				<input type="hidden" name="mode" value="fleet">
				<input type="hidden" name="action" value="delete">
				<table>
				<tr>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td><select name="auftr[]" id="auftr" size="10" multiple><option>&nbsp;</option></select><br><br>{$bd_cancel_warning}<br><input type="Submit" value="{$bd_cancel_send}"></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
				</tr>
				</table>
				</form>
				<br><span id="timeleft"></span><br><br>
			</td>
		</tr>
    </table>
	<br>
	{/if}
	<form action="" method="POST">
    <table>	
		{foreach name=FleetList item=FleetListRow from=$FleetList}
		<tr>
			<td rowspan="2" style="width:120px;">
				<a href="javascript:OpenPopup('game.php?page=infos&gid={$FleetListRow.id}', '', 640, 510);">
					<img src="{$dpath}gebaeude/{$FleetListRow.id}.gif" alt="{$FleetListRow.name}" width="120" height="120">
				</a>
			</td>
			<th>
				<a href="javascript:OpenPopup('game.php?page=infos&gid={$FleetListRow.id}', '', 640, 510);">{$FleetListRow.name}</a>{if $FleetListRow.Available != 0} ({$bd_available} {$FleetListRow.Available}){/if}
			</th>
		</tr>
		<tr>
			<td>
				<table style="width:100%">
					<tr>
						<td class="transparent left" style="width:90%;padding:10px;">{$FleetListRow.descriptions}<br><br>{$FleetListRow.price}</td>
						<td class="transparent" style="vertical-align:middle;width:100px">
						{if $NotBuilding && $FleetListRow.IsAvailable}<input type="text" name="fmenge[{$FleetListRow.id}]" id="input_{$FleetListRow.id}" size="{$maxlength}" maxlength="{$maxlength}" value="0" tabindex="{$smarty.foreach.FleetList.iteration}">							<br><br>
						<input type="button" value="Max" onclick="$('#input_{$FleetListRow.id}').val(maxcount({$FleetListRow.id}))">
						{/if}
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
							{foreach key=ResName item=ResCount from=$FleetListRow.restprice}
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
							{$FleetListRow.time}
						</td>
					</tr>	
				</table>
			</td>
		</tr>
		{/foreach}
		{if $NotBuilding}<tr><th colspan="2" style="text-align:center"><input type="submit" value="{$bd_build_ships}"></th></tr>{/if}
    </table>
	</form>
</div>
<script type="text/javascript">
data			= {$BuildList};
bd_operating	= '{$bd_operating}';
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}