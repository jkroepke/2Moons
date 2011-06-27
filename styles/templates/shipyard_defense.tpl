{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
	{if !$NotBuilding}<table width="70%" id="infobox" style="border: 2px solid red; text-align:center;background:transparent"><tr><td>{lang}bd_building_shipyard{/lang}</td></tr></table><br><br>{/if}
	{if $BuildList != '[]'}
    <table>
		<tr>
			<td class="transparent">
				<div id="bx" class="z"></div>
				<br>
				<form method="POST" action="">
				<input type="hidden" name="mode" value="defense">
				<input type="hidden" name="action" value="delete">
				<table>
				<tr>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td><select name="auftr[]" id="auftr" size="10" multiple><option>&nbsp;</option></select><br><br>{lang}bd_cancel_warning{/lang}<br><input type="Submit" value="{lang}bd_cancel_send{/lang}"></td>
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
		{foreach name=DefenseList item=DefenseListRow from=$DefenseList}
		{$ID = $DefenseListRow.id}
		<tr>
			<td rowspan="2" style="width:120px;">
				<a href="#" onclick="return Dialog.info({$ID})">
					<img src="{$dpath}gebaeude/{$ID}.gif" alt="{lang}tech.{$ID}{/lang}" width="120" height="120">
				</a>
			</td>
			<th>
				<a href="#" onclick="return Dialog.info({$ID})">{lang}tech.{$ID}{/lang}</a><span id="val_{$ID}">{if $DefenseListRow.Available != 0} ({lang}bd_available{/lang} {$DefenseListRow.Available}){/if}</span>
			</th>
		</tr>
		<tr>
			<td>
				<table style="width:100%">
					<tr>
						<td class="transparent left" style="width:90%;padding:10px;">{lang}res.descriptions.{$ID}{/lang}<br><br>{$DefenseListRow.price}</td>
						<td class="transparent" style="vertical-align:middle;width:100px">
						{if $DefenseListRow.AlreadyBuild}<span style="color:red">{lang}bd_protection_shield_only_one{/lang}</span>{elseif $NotBuilding && $DefenseListRow.IsAvailable}<input type="text" name="fmenge[{$ID}]" id="input_{$ID}" size="{$maxlength}" maxlength="{$maxlength}" value="0" tabindex="{$smarty.foreach.DefenseList.iteration}">
						<br><br>
						<input type="button" value="Max" onclick="$('#input_{$ID}').val('{$DefenseListRow.GetMaxAmount}')">
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
							{lang}bd_remaining{/lang}<br>
							{foreach key=ResName item=ResCount from=$DefenseListRow.restprice}
							{$ResName}: <span style="font-weight:700">{$ResCount}</span><br>
							{/foreach}
							<br>
						</td>
						<td class="transparent right">
							{lang}fgf_time{/lang}
						</td>
					</tr>
					<tr>		
						<td class="transparent left" style="width:68%">
							{lang}bd_max_ships_long{/lang}:<br><span style="font-weight:700">{pretty_number({$DefenseListRow.GetMaxAmount})}</span>
						</td>
						<td class="transparent right" style="white-space:nowrap;">
							{$DefenseListRow.time}
						</td>
					</tr>	
				</table>
			</td>
		</tr>
		{/foreach}
		{if $NotBuilding}<tr><th colspan="2" style="text-align:center"><input type="submit" value="{lang}bd_build_ships{/lang}"></th></tr>{/if}
    </table>
	</form>
</div>
<script type="text/javascript">
data			= {$BuildList};
bd_operating	= '{lang}bd_operating{/lang}';
bd_available	= '{lang}bd_available{/lang}';
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}