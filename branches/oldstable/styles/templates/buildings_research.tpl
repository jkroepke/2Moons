{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
	{if !empty($Queue)}
	<div id="buildlist" class="buildlist">
		<table style="width:760px">
			{foreach $Queue as $List}
			{$ID = $List.element}
			<tr>
				<td style="width:70%;vertical-align:top;" class="left">
					{$CQueue = $ResearchList[$List.element]}
					{$List@iteration}.: 
					{if $CQueue.maxLevel != $CQueue.level && !$IsFullQueue && $CQueue.buyable}
					<form action="game.php?page=buildings&amp;mode=research" method="post" class="build_form">
						<input type="hidden" name="cmd" value="insert">
						<input type="hidden" name="tech" value="{$ID}">
						<button type="submit" class="build_submit onlist">{lang}tech.{$ID}{/lang} {$List.level}{if !empty($List.planet)} @ {$List.planet}{/if}</button>
					</form>
					{else}
					{lang}tech.{$ID}{/lang} {$List.level}{if !empty($List.planet)} @ {$List.planet}{/if}
					{/if}
					{if $List@first}
					<br><br><div id="progressbar" time="{$List.resttime}"></div>
				</td>
				<td>
					<div id="time" time="{$List.time}"><br></div>
					<form action="game.php?page=buildings&amp;mode=research" method="post" class="build_form">
						<input type="hidden" name="cmd" value="cancel">
						<input type="hidden" name="mode" value="research">
						<button type="submit" class="build_submit onlist">{lang}bd_cancel{/lang}</button>
					</form>
					{else}
				</td>
				<td>
					<form action="game.php?page=buildings&amp;mode=research" method="post" class="build_form">
						<input type="hidden" name="cmd" value="remove">
						<input type="hidden" name="listid" value="{$List@iteration}">
						<button type="submit" class="build_submit onlist">{lang}bd_cancel{/lang}</button>
					</form>
					{/if}
					<br><span style="color:lime" time="{$List.endtime}" class="timer">{tz_date($List.endtime)}</span>
				</td>
			</tr>
		{/foreach}
		</table>
	</div>
	{/if}
    {if $IsLabinBuild}<table width="70%" id="infobox" style="border: 2px solid red; text-align:center;background:transparent"><tr><td>{lang}bd_building_lab{/lang}</td></tr></table><br><br>{/if}
    <table style="width:760px">
		{foreach $ResearchList as $ID => $Element}
		<tr>
			<td rowspan="2" style="width:120px;">
				<a href="#" onclick="return Dialog.info({$ID})">
					<img src="{$dpath}gebaeude/{$ID}.gif" alt="" class="top" width="120" height="120">
				</a>
			</td>
			<th>
				<a href="#" onclick="return Dialog.info({$ID})">{lang}tech.{$ID}{/lang}</a>{if $Element.level != 0} ({lang}bd_lvl{/lang} {$Element.level}{if $Element.maxLevel !== 255}/{$Element.maxLevel}{/if}){/if}{if !empty($Bonus.$ID)} <span style="color:lime;">(+ {$Bonus.$ID})</span>{/if} 
			</th>
		</tr>
		<tr>
			<td>
				<table style="width:100%">
					<tr>
						<td class="transparent left" style="width:90%;padding:10px;"><p>{lang}res.descriptions.{$ID}{/lang}</p>
						<p>{foreach $Element.costRessources as $RessID => $RessAmount}
						{lang}tech.{$RessID}{/lang}: <b><span style="color:{if $Element.costOverflow[$RessID] == 0}lime{else}red{/if}">{$RessAmount|number}</span></b>
						{/foreach}</p></td>
						<td class="transparent" style="vertical-align:middle;width:100px">
						{if $Element.maxLevel == $Element.level}
							<span style="color:red">{lang}bd_maxlevel{/lang}</span>
						{elseif $IsLabinBuild || $IsFullQueue || !$Element.buyable}
							<span style="color:red">{if $Element.level == 0}{lang}bd_tech{/lang}{else}{lang}bd_tech_next_level{/lang}{$Element.level + 1}{/if}</span>
						{else}
							<form action="game.php?page=buildings&amp;mode=research" method="post" class="build_form">
								<input type="hidden" name="cmd" value="insert">
								<input type="hidden" name="tech" value="{$ID}">
								<button type="submit" class="build_submit">{if $Element.level == 0}{lang}bd_tech{/lang}{else}{lang}bd_tech_next_level{/lang}{$Element.level + 1}{/if}</button>
							</form>
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
							&nbsp;
						</td>
						<td class="transparent right" style="white-space:nowrap;">
							{$Element.elementTime|time}
						</td>
					</tr>	
				</table>
			</td>
		</tr>
		{/foreach}
    </table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}