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
		<div id="trader">
			<div class="trader_col">
				{if !$requiredDarkMatter}<form action="game.php?page=trader" method="post">
				<input type="hidden" name="mode" value="trade">
				<input type="hidden" name="resource" value="901">
				<input type="image" id="trader_metal" src="{$dpath}images/metall.gif" title="{$LNG.tech.901}" border="0" height="32" width="52"><br>
				<label for="trader_metal">{$LNG.tech.901}</label>
				</form>
				{else}<img src="{$dpath}images/metall.gif" title="{$LNG.tech.901}" border="0" height="32" width="52" style="margin: 3px;"><br>{$LNG.tech.901}{/if}
			</div>
			<div class="trader_col">
				{if !$requiredDarkMatter}<form action="game.php?page=trader" method="post">
				<input type="hidden" name="mode" value="trade">
				<input type="hidden" name="resource" value="902">
				<input type="image" id="trader_crystal" src="{$dpath}images/kristall.gif" title="{$LNG.tech.902}" border="0" height="32" width="52"><br>
				<label for="trader_crystal">{$LNG.tech.902}</label>
				</form>
				{else}<img src="{$dpath}images/kristall.gif" title="{$LNG.tech.902}" border="0" height="32" width="52" style="margin: 3px;"><br>{$LNG.tech.902}{/if}
			</div>
			<div class="trader_col">
				{if !$requiredDarkMatter}<form action="game.php?page=trader" method="post">
				<input type="hidden" name="mode" value="trade">
				<input type="hidden" name="resource" value="903">
				<input type="image" id="trader_deuterium" src="{$dpath}images/deuterium.gif" title="{$LNG.tech.903}" border="0" height="32" width="52"><br>
				<label for="trader_deuterium">{$LNG.tech.903}</label>
				</form>
				{else}<img src="{$dpath}images/deuterium.gif" title="{$LNG.tech.903}" border="0" height="32" width="52" style="margin: 3px;"><br>{$LNG.tech.903}{/if}
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