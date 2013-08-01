{block name="title" prepend}{$LNG.lm_trader}{/block}
{block name="content"}
{if $requiredDarkMatter}
<table style="width:519px;">
<tr>
	<th>{$LNG.fcm_info}</th>
</tr>
<tr>
	<td><span style="color:red;">{$requiredDarkMatter}</span></td>
</tr>
</table>
<br>
<br>
{/if}
<table style="width:519px;">
<tr>
	<th>{$LNG.tr_call_trader}</th>
</tr>
<tr>
	<td>
		<div>{$LNG.tr_call_trader_who_buys}</div>
		<div id="traderContainer" class="centerContainer">
			<div class="outer">
				<div class="inner">
					{foreach $elementData as $elementId => $elementObj}
					<div class="trader_col">
						{if !$requiredDarkMatter}
                            <form action="game.php?page=trader" method="post">
                            <input type="hidden" name="mode" value="trade">
                            <input type="hidden" name="resource" value="{$elementId}">
                            <input type="image" id="trader_{$elementObj->name}" src="{$dpath}images/{$elementObj->name}.gif" title="{$LNG.tech.$elementId}" height="32" width="52"><br>
                            <label for="trader_{$elementObj->name}">{$LNG.tech.$elementId}</label>
                            </form>
						{else}
                            <img src="{$dpath}images/{$elementObj->name}.gif" title="{$LNG.tech.$elementId}" border="0" height="32" width="52" style="margin: 3px;"><br>{$LNG.tech.$elementId}
                        {/if}
					</div>
					{/foreach}
				</div>
			</div>
			<div class="clear"></div>
		</div>
		</div>
		<div>
			<p>{$tr_cost_dm_trader}</p>
			<p>{$LNG.tr_exchange_quota}: {$charge.901.903}/{$charge.902.903}/{$charge.903.903}</p>
		</div>
	</td>
</tr>
</table>
{/block}