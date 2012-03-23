{block name="title" prepend}{$LNG.lm_trader}{/block}
{block name="content"}
<form id="trader" action="" method="post">
	<input type="hidden" name="mode" value="send">
	<input type="hidden" name="resource" value="{$resourceID}">
	<table class="table569">
	<tr>
		<th colspan="3">{$LNG.tr_sell} {$LNG.tech.$resourceID}</th>
	</tr>
	<tr>
		<td>{$LNG.tr_resource}</td>
		<td>{$LNG.tr_amount}</td>
		<td>{$LNG.tr_quota_exchange}</td>
	</tr>
	<tr>
		<td>{$LNG.tech.$resourceID}</td>
		<td><span id="ress">0</span></td>
		<td>1</td>
	</tr>
	<tr>
		<td><label for="resource{$tradeRessources.0}">{$LNG.tech[$tradeRessources.0]}</label></td>
		<td><input name="trade[{$tradeRessources.0}]" id="resource{$tradeRessources.0}" class="trade_input" type="text" value="0" size="30"></td>
		<td>{$charge[$tradeRessources.0]}</td>
	</tr>
	<tr>
		<td><label for="resource{$tradeRessources.1}">{$LNG.tech[$tradeRessources.1]}</label></td>
		<td><input name="trade[{$tradeRessources.1}]" id="resource{$tradeRessources.1}" class="trade_input" type="text" value="0" size="30"></td>
		<td>{$charge[$tradeRessources.1]}</td>
	</tr>
	<tr>
		<td colspan="3"><input type="submit" value="{$LNG.tr_exchange}"></td>
	</tr>
	</table>
</form>
{/block}
{block name="script" append}
<script type="text/javascript">
var ress1charge = {$charge[$tradeRessources.0]|default:'0'};
var ress2charge = {$charge[$tradeRessources.1]|default:'0'};
</script>
{/block}