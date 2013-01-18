{block name="title" prepend}{$LNG.lm_officiers}{/block}
{block name="content"}
{if !empty($darkmatterList)}
	<table style="width:760px">
	<tr>
		<th colspan="2">{$of_dm_trade}</th>
	</tr>
	{foreach $darkmatterList as $ID => $Element}
	<tr>
		<td rowspan="2" style="width:120px;">
			<a href="#" onclick="return Dialog.info({$ID});">
				<img src="{$dpath}gebaeude/{$ID}.gif" alt="{$LNG.tech.{$ID}}" width="120" height="120">
			</a>
		</td>
		<th>
			<a href="#" onclick="return Dialog.info({$ID});">{$LNG.tech.{$ID}}</a>
		</th>
	</tr>
	<tr>
		<td>
			<table style="width:100%">
				<tbody>
					<tr>
						<td class="transparent left" style="width:90%;padding:10px;">
							<p>{$LNG.shortDescription.{$ID}}</p>
							{foreach $Element.elementBonus as $BonusName => $Bonus}{if $Bonus@iteration % 3 === 1}<p>{/if}{if $Bonus[0] < 0}-{else}+{/if}{if $Bonus[1] == 0}{abs($Bonus[0] * 100)}%{else}{$Bonus[0]}{/if} {$LNG.bonus.$BonusName}{if $Bonus@iteration % 3 === 0 || $Bonus@last}</p>{else}&nbsp;{/if}{/foreach}
							<p>{foreach $Element.costRessources as $RessID => $RessAmount}{$LNG.tech.{$RessID}}: <b><span style="color:{if $Element.costOverflow[$RessID] == 0}lime{else}red{/if}">{$RessAmount|number}</span></b>{/foreach} | {$LNG.in_dest_durati}: <span style="color:lime">{$Element.time|time}</span></p>
						</td>
						<td class="transparent" style="vertical-align:middle;width:100px">
						{if $Element.timeLeft > 0}
							{$LNG.of_still}<br>
							<span id="time_{$ID}">-</span>
							{$LNG.of_active}
							{if $Element.buyable}
							<form action="game.php?page=officier" method="post" class="build_form">
								<input type="hidden" name="id" value="{$ID}">
								<button type="submit" class="build_submit">{$LNG.of_recruit}</button>
							</form>
							{/if}
						{elseif $Element.buyable}
						<form action="game.php?page=officier" method="post" class="build_form">
							<input type="hidden" name="id" value="{$ID}">
							<button type="submit" class="build_submit">{$LNG.of_recruit}</button>
						</form>
						{else}
						<span style="color:#FF0000">{$LNG.of_recruit}</span>
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
		<th colspan="2">{$LNG.of_offi}</th>
	</tr>
	{foreach $officierList as $ID => $Element}
	<tr>
		<td rowspan="2" style="width:120px;">
			<a href="#" onclick="return Dialog.info({$ID})">
				<img src="{$dpath}gebaeude/{$ID}.jpg" alt="{$LNG.tech.{$ID}}" width="120" height="120">
			</a>
		</td>
		<th>
			<a href="#" onclick="return Dialog.info({$ID})">{$LNG.tech.{$ID}}</a> ({$LNG.of_lvl} {$Element.level}/{$Element.maxLevel})
		</th>
	</tr>
	<tr>
		<td>
			<table style="width:100%">
				<tbody>
					<tr>
						<td class="transparent left" style="width:90%;padding:0px 10px 10px 10px;">
							<p>{$LNG.shortDescription.{$ID}}</p>
							<p>{foreach $Element.elementBonus as $BonusName => $Bonus}{if $Bonus[0] < 0}-{else}+{/if}{if $Bonus[1] == 0}{abs($Bonus[0] * 100)}%{else}{floatval($Bonus[0])}{/if} {$LNG.bonus.$BonusName}<br>{/foreach}</p>
							<p>{foreach $Element.costRessources as $RessID => $RessAmount}{$LNG.tech.{$RessID}}: <b><span style="color:{if $Element.costOverflow[$RessID] == 0}lime{else}red{/if}">{$RessAmount|number}</span></b>{/foreach}</p>
						</td>
						<td class="transparent" style="vertical-align:middle;width:100px">
						{if $Element.maxLevel <= $Element.level}
							<span style="color:red">{$LNG.bd_maxlevel}</span>
						{elseif $Element.buyable}
							<form action="game.php?page=officier" method="post" class="build_form">
								<input type="hidden" name="id" value="{$ID}">
								<button type="submit" class="build_submit">{$LNG.of_recruit}</button>
							</form>
						{else}
							<span style="color:red">{$LNG.of_recruit}</span>
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
{/block}