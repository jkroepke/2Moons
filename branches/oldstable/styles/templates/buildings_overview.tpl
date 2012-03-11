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
					{$List@iteration}.: 
					{if !($isBusy.research && ($ID == 6 || $ID == 31)) && !($isBusy.shipyard && ($ID == 15 || $ID == 21)) && $RoomIsOk && $CanBuildElement && $BuildInfoList[$ID].buyable}
					<form class="build_form" action="game.php?page=buildings" method="post">
						<input type="hidden" name="cmd" value="insert">
						<input type="hidden" name="building" value="{$ID}">
						<button type="submit" class="build_submit onlist">{lang}tech.{$ID}{/lang} {$List.level} {if $List.destroy}{lang}bd_dismantle{/lang}{/if}</button>
					</form>
					{else}{lang}tech.{$ID}{/lang} {$List.level} {if $List.destroy}{lang}bd_dismantle{/lang}{/if}{/if}
					{if $List@first}
					<br><br><div id="progressbar" time="{$List.resttime}"></div>
				</td>
				<td>
					<div id="time" time="{$List.time}"><br></div>
					<form action="game.php?page=buildings" method="post" class="build_form">
						<input type="hidden" name="cmd" value="cancel">
						<button type="submit" class="build_submit onlist">{lang}bd_cancel{/lang}</button>
					</form>
					{else}
				</td>
				<td>
					<form action="game.php?page=buildings" method="post" class="build_form">
						<input type="hidden" name="cmd" value="remove">
						<input type="hidden" name="listid" value="{$List@iteration}">
						<button type="submit" class="build_submit onlist">{lang}bd_cancel{/lang}</button>
					</form>
					{/if}
					<br><span style="color:lime" time="{tz_date($List.endtime, 'U')}" class="timer">{tz_date($List.endtime)}</span>
				</td>
			</tr>
		{/foreach}
		</table>
	</div>
	{/if}
    <table style="width:760px">
		{foreach $BuildInfoList as $ID => $Element}
		<tr>
			<td rowspan="2" style="width:120px;">
				<a href="#" onclick="return Dialog.info({$ID})">
					<img src="{$dpath}gebaeude/{$ID}.gif" alt="{lang}tech.{$ID}{/lang}" width="120" height="120">
				</a>
			</td>
			<th>
				<a href="#" onclick="return Dialog.info({$ID})">{lang}tech.{$ID}{/lang}</a>{if $Element.level > 0} ({lang}bd_lvl{/lang} {$Element.level}{if $Element.maxLevel !== 255}/{$Element.maxLevel}{/if}){/if}
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
						{elseif ($isBusy.research && ($ID == 6 || $ID == 31)) || ($isBusy.shipyard && ($ID == 15 || $ID == 21))}
							<span style="color:red">{lang}bd_working{/lang}</span>
						{else}
							{if $RoomIsOk}
								{if $CanBuildElement && $Element.buyable}
								<form action="game.php?page=buildings" method="post" class="build_form">
									<input type="hidden" name="cmd" value="insert">
									<input type="hidden" name="building" value="{$ID}">
									<button type="submit" class="build_submit">{if $Element.level == 0}{lang}bd_build{/lang}{else}{lang}bd_build_next_level{/lang}{$Element.level + 1}{/if}</button>
								</form>
								{else}
								<span style="color:red">{if $Element.level == 0}{lang}bd_build{/lang}{else}{lang}bd_build_next_level{/lang}{$Element.level + 1}{/if}</span>
								{/if}
							{else}
							<span style="color:red">{lang}bd_no_more_fields{/lang}</span>
							{/if}
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
							{if !empty($Element.EnergyNeed)}
								{lang}bd_next_level{/lang}<br>
								{$Element.EnergyNeed}
							{/if}
							{if $Element.level > 0}
								<br>{if $ID == 43}<a href="#" onclick="return Dialog.info({$ID})">{$bd_jump_gate_action}</a>{/if}
								{if ($ID == 44 && !$HaveMissiles) ||  $ID != 44}<br><a class="tooltip_sticky" name="<table style='width:300px'><tr><th colspan='2'>{lang}bd_price_for_destroy{/lang} {lang}tech.{$ID}{/lang} {$Element.level}</th></tr>{foreach $Element.destroyRessources as $ResType => $ResCount}<tr><td>{lang}tech.{$ResType}{/lang}</td><td>{$ResCount|number}</td></tr>{/foreach}<tr><td>{lang}bd_destroy_time{/lang}</td><td>{$Element.destroyTime|time}</td></tr><tr><td colspan='2'><form action='game.php?page=buildings' method='post' class='build_form'><input type='hidden' name='cmd' value='destroy'><input type='hidden' name='building' value='{$ID}'><button type='submit' class='build_submit onlist'>{lang}bd_dismantle{/lang}</button></form></td></tr></table>">{lang}bd_dismantle{/lang}</a>{/if}
							{else}
								&nbsp;
							{/if}
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