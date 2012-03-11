{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
	{if !empty($darkmatterList)}
		<table style="width:760px">
	    <tr>
			<th colspan="2">{$of_dm_trade}</th>
		</tr>
		{foreach $darkmatterList as $ID => $Element}
		<tr>
			<td rowspan="2" style="width:120px;">
				<a href="#" onclick="return Dialog.info({$ID});">
					<img src="{$dpath}gebaeude/{$ID}.gif" alt="{lang}tech.{$ID}{/lang}" width="120" height="120">
				</a>
			</td>
			<th>
				<a href="#" onclick="return Dialog.info({$ID});">{lang}tech.{$ID}{/lang}</a>
			</th>
		</tr>
		<tr>
			<td>
				<table style="width:100%">
					<tbody>
						<tr>
							<td class="transparent left" style="width:90%;padding:10px;"><p>{$Element.description}</p>
								<p>{foreach $Element.costRessources as $RessID => $RessAmount}{lang}tech.{$RessID}{/lang}: <b><span style="color:{if $Element.costOverflow[$RessID] == 0}lime{else}red{/if}">{$RessAmount|number}</span></b>{/foreach}</p>
								<p>{lang}in_dest_durati{/lang}: <span style="color:lime">{$Element.time|time}</span></p></td>
							<td class="transparent" style="vertical-align:middle;width:100px">
							{if $Element.timeLeft > 0}
								{lang}of_still{/lang}<br>
								<span id="time_{$ID}">-</span>
								{lang}of_active{/lang}
								{if $Element.buyable}
								<form action="game.php?page=officier" method="post" class="build_form">
									<input type="hidden" name="extra" value="{$ID}">
									<button type="submit" class="build_submit">{lang}of_recruit{/lang}</button>
								</form>
								{/if}
							{elseif $Element.buyable}
							<form action="game.php?page=officier" method="post" class="build_form">
								<input type="hidden" name="extra" value="{$ID}">
								<button type="submit" class="build_submit">{lang}of_recruit{/lang}</button>
							</form>
							{else}
							<span style="color:#FF0000">{lang}of_recruit{/lang}</span>
							{/if}
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		{/foreach}
    </table>
	<br><br>
	{/if}
	{if $officierList}
	<table style="width:760px">
		<tr>
			<th colspan="2">{lang}of_offi{/lang}</th>
		</tr>
		{foreach $officierList as $ID => $Element}
		<tr>
			<td rowspan="2" style="width:120px;">
				<a href="#" onclick="return Dialog.info({$ID})">
					<img src="{$dpath}gebaeude/{$ID}.jpg" alt="{lang}tech.{$ID}{/lang}" width="120" height="120">
				</a>
			</td>
			<th>
				<a href="#" onclick="return Dialog.info({$ID})">{lang}tech.{$ID}{/lang}</a> ({lang}of_lvl{/lang} {$Element.level}/{$Element.maxLevel})
			</th>
		</tr>
		<tr>
			<td>
				<table style="width:100%">
					<tbody>
						<tr>
							<td class="transparent left" style="width:90%;padding:0px 10px 10px 10px;"><p>{$Element.description}</p>
								<p>{foreach $Element.costRessources as $RessID => $RessAmount}{lang}tech.{$RessID}{/lang}: <b><span style="color:{if $Element.costOverflow[$RessID] == 0}lime{else}red{/if}">{$RessAmount|number}</span></b>{/foreach}</p></td>
							<td class="transparent" style="vertical-align:middle;width:100px">
							{if $Element.maxLevel == $Element.level}
								<span style="color:red">{lang}bd_maxlevel{/lang}</span>
							{elseif $Element.buyable}
								<form action="game.php?page=officier" method="post" class="build_form">
									<input type="hidden" name="offi" value="{$ID}">
									<button type="submit" class="build_submit">{lang}of_recruit{/lang}</button>
								</form>
							{else}
								<span style="color:red">{lang}of_recruit{/lang}</span>
							{/if}
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		{/foreach}
    </table>
	{/if}
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}