{block name="title" prepend}{$LNG.lm_officiers}{/block}
{block name="content"}
{if !empty($darkmatterList)}
	<table style="width:760px">
	<tr>
		<th colspan="2">{$of_dm_trade}</th>
	</tr>
	{foreach $darkmatterList as $elementId => $elementData}
	<tr>
		<td rowspan="2" style="width:120px;">
			<a href="#" onclick="return Dialog.info({$elementId});">
				<img src="{$dpath}gebaeude/{$elementId}.gif" alt="{$LNG.tech.{$elementId}}" width="120" height="120">
			</a>
		</td>
		<th>
			<a href="#" onclick="return Dialog.info({$elementId});">{$LNG.tech.{$elementId}}</a>
		</th>
	</tr>
	<tr>
		<td>
			<table style="width:100%">
				<tbody>
					<tr>
						<td class="transparent left" style="width:90%;padding:10px;">
							<p>{$LNG.shortDescription.{$elementId}}</p>
							<p>{foreach $elementData.elementBonus as $bonus}{$bonus}<br>{/foreach}</p>
							<p>{foreach $elementData.costResources as $resourceId => $value}{$LNG.tech.{$resourceId}}: <b><span style="color:{if $elementData.costOverflow[$resourceId] == 0}lime{else}red{/if}">{$value|number}</span></b> {/foreach} | {$LNG.in_dest_durati}: <span style="color:lime">{$elementData.time|time}</span></p>
						</td>
						<td class="transparent" style="vertical-align:middle;width:100px">
						{if $elementData.timeLeft > 0}<span class="timer" data-time="{$elementData.timeLeft}">-</span><br>{/if}
						{if $elementData.buyable}
						<form action="game.php?page=officier" method="post" class="build_form">
							<input type="hidden" name="elementId" value="{$elementId}">
							<input type="hidden" name="mode" value="upgrade">
							<button type="submit" class="build_submit">{if $elementData.timeLeft > 0}{$LNG.of_extend}{else}{$LNG.of_recruit}{/if}</button>
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
	{foreach $officierList as $elementId => $elementData}
	<tr>
		<td rowspan="2" style="width:120px;">
			<a href="#" onclick="return Dialog.info({$elementId})">
				<img src="{$dpath}gebaeude/{$elementId}.jpg" alt="{$LNG.tech.{$elementId}}" width="120" height="120">
			</a>
		</td>
		<th>
			<a href="#" onclick="return Dialog.info({$elementId})">{$LNG.tech.{$elementId}}</a> ({$LNG.of_lvl} {$elementData.level}{if $elementData.maxLevel != 0}/{$elementData.maxLevel}{/if})
		</th>
	</tr>
	<tr>
		<td>
			<table style="width:100%">
				<tbody>
					<tr>
						<td class="transparent left" style="width:90%;padding:0 10px 10px 10px;">
							<p>{$LNG.shortDescription.{$elementId}}</p>
							<p>{foreach $elementData.elementBonus as $bonus}{$bonus}<br>{/foreach}</p>
							<p>{foreach $elementData.costResources as $resourceId => $value}{$LNG.tech.{$resourceId}}: <b><span style="color:{if $elementData.costOverflow[$resourceId] == 0}lime{else}red{/if}">{$value|number}</span></b> {/foreach}</p>
						</td>
						<td class="transparent" style="vertical-align:middle;width:100px">
						{if $elementData.maxLevel <= $elementData.level}
							<span style="color:red">{$LNG.bd_maxlevel}</span>
						{elseif $elementData.buyable}
							<form action="game.php?page=officier" method="post" class="build_form">
								<input type="hidden" name="elementId" value="{$elementId}">
								<input type="hidden" name="mode" value="upgrade">
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
{block name="script"}
<script src="scripts/game/officier.js"></script>
{/block}