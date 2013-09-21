{block name="title" prepend}{$LNG.lm_fleettrader}{/block}
{block name="content"}
<form action="game.php?page=fleetDealer" method="post">
	<input type="hidden" name="mode" value="send">
	<table style="width:760px;">
        <tr>
			<th>{$LNG.ft_head}</th>
		</tr>
        <tr>
			<td>
				<div class="transparent" style="text-align:left;float:left;"><img id="img" alt="" data-src="{$dpath}gebaeude/"></div>
				<div class="transparent" style="text-align:right;float:right;padding:5px">
					<select name="shipId" id="shipId" onchange="changeDetail()">
						{foreach $elementsData as $elementId => $elementData}
						<option value="{$elementId}">{$LNG.tech.$elementId}</option>
						{/foreach}
					</select>
				</div>
				<div>
				{foreach $elementsData as $elementId => $elementData}
				<div class="elementData" id="element{$elementId}" style="clear:right;margin-top:20px;margin-left:125px;">
					<h2 id="traderHead">{$LNG.tech.$elementId}</h2>
					<p><label for="count">{$LNG.ft_count}</label>: <input type="text" id="count" name="count" onkeyup="calcTotalResource();"><button onclick="MaxShips();return false;">{$LNG.ft_max}</button></p>
					<p>{foreach $elementData.price as $resourceElementId => $resourceAmount}
						{$LNG.tech.$resourceElementId}: <span style="font-weight:800;" class="resourceAmount resource{$resourceElementId}" data-id="{$resourceElementId}">{$resourceAmount}</span>{if !$resourceAmount@last} &bull;{/if}
					{/foreach}</p>
					<p>{$LNG.ft_total}: {foreach $elementData.price as $resourceElementId => $resourceAmount}
						{$LNG.tech.$resourceElementId}: <span style="font-weight:800;" class="resourceTotal resource{$resourceElementId}" data-id="{$resourceElementId}">{$resourceAmount}</span>{if !$resourceAmount@last} &bull;{/if}
					{/foreach}</p>
					<p><input type="submit" value="{$LNG.ft_absenden}"></p>
					<p>{$LNG.ft_charge}: {$Charge}%</p>
				</div>
				{/foreach}
				</div>
			</td>
		</tr>
	</table>
</form>
{/block}
{block name="script" append}
<script src="scripts/game/fleetDealer.js"></script>
<script>
var elementData = {$elementsData|json};
var Charge = {$Charge};
$(function(){
	changeDetail();
})
</script>
{/block}