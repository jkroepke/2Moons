{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
	{if !$NotBuilding}<table width="70%" id="infobox" style="border: 2px solid red; text-align:center;background:transparent"><tr><td>{lang}bd_building_shipyard{/lang}</td></tr></table><br><br>{/if}
	{if !empty($BuildList)}
    <table style="width:760px">
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
					<td><select name="auftr[]" id="auftr" size="10" multiple><option>&nbsp;</option></select><br><br>{lang}bd_cancel_warning{/lang}<br><input type="submit" value="{lang}bd_cancel_send{/lang}"></td>
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
	<form action="game.php?page=buildings&amp;mode=fleet" method="POST">
    <table style="width:760px">
		{foreach $FleetList as $ID => $Element}
		<tr>
			<td rowspan="2" style="width:120px;">
				<a href="#" onclick="return Dialog.info({$ID})">
					<img src="{$dpath}gebaeude/{$ID}.gif" alt="{lang}tech.{$ID}{/lang}" width="120" height="120">
				</a>
			</td>
			<th>
				<a href="#" onclick="return Dialog.info({$ID})">{lang}tech.{$ID}{/lang}</a><span id="val_{$ID}">{if $Element.available != 0} ({lang}bd_available{/lang} {$Element.available}){/if}</span>
			</th>
		</tr>
		<tr>
			<td>
				<table style="width:100%">
					<tr>
						<td class="transparent left" style="width:90%;padding:10px;"><p>{lang}res.descriptions.{$ID}{/lang}</p><p>{foreach $Element.costRessources as $RessID => $RessAmount}
						{lang}tech.{$RessID}{/lang}: <b><span style="color:{if $Element.costOverflow[$RessID] == 0}lime{else}red{/if}">{$RessAmount|number}</span></b>
						{/foreach}</p></td>
						<td class="transparent" style="vertical-align:middle;width:100px">
						<p>{if $NotBuilding && $Element.buyable}<input type="text" name="fmenge[{$ID}]" id="input_{$ID}" size="{$maxlength}" maxlength="{$maxlength}" value="0" tabindex="{$smarty.foreach.FleetList.iteration}"></p><p>
						<input type="button" value="{lang}bd_max_ships{/lang}" onclick="$('#input_{$ID}').val('{$Element.maxBuildable}')"></p>
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
							{foreach $Element.costOverflow as $ResType => $ResCount}
							{lang}tech.{$ResType}{/lang}: <span style="font-weight:700">{$ResCount|number}</span><br>
							{/foreach}
							<br>
						</td>
						<td class="transparent right">
							{lang}fgf_time{/lang}
						</td>
					</tr>
					<tr>		
						<td class="transparent left" style="width:68%">
							{lang}bd_max_ships_long{/lang}:<br><span style="font-weight:700">{$Element.maxBuildable|number}</span>
						</td>
						<td class="transparent right" style="white-space:nowrap;">
							{$Element.elementTime|time}
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
data			= {$BuildList|json};
bd_operating	= '{lang}bd_operating{/lang}';
bd_available	= '{lang}bd_available{/lang}';
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}