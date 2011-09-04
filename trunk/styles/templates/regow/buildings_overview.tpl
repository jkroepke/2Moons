{include file="../overall_header.tpl"}
{include file="../left_menu.tpl"}
{include file="../overall_topnav.tpl"}
<div id="content">
	{if !empty($Queue)}
	<div id="buildlist" class="buildlist">
		<table style="width:80%">
			{foreach $Queue as $List}
			{$ID = $List.element}
			<tr>
				<td style="width:70%;vertical-align:top;" class="left">
					{$CanBuild = !($isBusy.research && ($ID == 6 || $ID == 31)) && !($isBusy.shipyard && ($ID == 15 || $ID == 21)) && $RoomIsOk && $CanBuildElement && $BuildInfoList[$ID].buyable}
					{$List@iteration}.: 
					{if $CanBuild}
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
					<br><span style="color:lime" time="{$List.endtime}" class="timer">{date($smarty.const.TDFORMAT, $List.endtime)}</span>
				</td>
			</tr>
		{/foreach}
		</table>
	</div>
	{/if}
	<div class="buildlist">
		{foreach $BuildInfoList as $Element}
		{$ID = $Element.id}
		<div class="buildrow">
			<div class="buildtitle"><a href="#" onclick="return Dialog.info({$ID})">{lang}tech.{$ID}{/lang}{if $Element.baselevel > 0} ({lang}bd_lvl{/lang} {$Element.baselevel}){/if}</a></div>
			<div class="buildimage">
				<img src="{$dpath}gebaeude/{$ID}.gif" alt="{lang}tech.{$ID}{/lang}" width="120" height="120">
			</div>
			<div class="buildinfo">
				<p class="buildprice">{$Element.price}</p>
				<p{if !empty($Element.EnergyNeed)} class="buildengery">{$Element.EnergyNeed}{else}>&nbsp;{/if}</p>
				
				{if ($isBusy.research && ($ID == 6 || $ID == 31)) || ($isBusy.shipyard && ($ID == 15 || $ID == 21))}
					<div class="buildbutton">{lang}bd_working{/lang}</div>
				{else}
					{if $RoomIsOk}
						{if $CanBuildElement && $Element.buyable}
						<form action="game.php?page=buildings" method="post" class="build_form">
							<input type="hidden" name="cmd" value="insert">
							<input type="hidden" name="building" value="{$ID}">
							<div class="buildbutton buildable">
								<input type="submit" value="{if $Element.level == 0}{lang}bd_build{/lang}{else}{lang}bd_build_next_level{/lang}{$Element.level + 1}{/if}">
							</div>
						</form>
						{else}
						<div class="buildbutton">{if $Element.level == 0}{lang}bd_build{/lang}{else}{lang}bd_build_next_level{/lang}{$Element.level + 1}{/if}</div>
						{/if}
					{else}
					<div class="buildbutton">{lang}bd_no_more_fields{/lang}</div>
					{/if}
				{/if}
			</div>
		</div>
	{/foreach}
	</div>
</div>
{include file="../planet_menu.tpl"}
{include file="../overall_footer.tpl"}