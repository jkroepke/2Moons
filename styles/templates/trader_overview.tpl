{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
    <table style="width:519px;">
    <tr>
        <th>{lang}tr_call_trader{/lang}</th>
    </tr><tr>
        <td>
			<div>{lang}tr_call_trader_who_buys{/lang}</div>
			<div id="trader">
				<div class="trader_col">
					<form action="game.php?page=trader" method="post">
					<input type="hidden" name="ress" value="metal">
					<input type="image" id="trader_metal" src="{$dpath}images/metall.gif" title="{$Metal}" border="0" height="32" width="52"><br>
					<label for="trader_metal">{$Metal}</label>
					</form>
				</div>
				<div class="trader_col">
					<form action="game.php?page=trader" method="post">
					<input type="hidden" name="ress" value="crystal">
					<input type="image" id="trader_crystal" src="{$dpath}images/kristall.gif" title="{$Crystal}" border="0" height="32" width="52"><br>
					<label for="trader_crystal">{$Crystal}</label>
					</form>
				</div>
				<div class="trader_col">
					<form action="game.php?page=trader" method="post">
					<input type="hidden" name="ress" value="deuterium">
					<input type="image" id="trader_deuterium" src="{$dpath}images/deuterium.gif" title="{$Deuterium}" border="0" height="32" width="52"><br>
					<label for="trader_deuterium">{$Deuterium}</label>
					</form>
				</div>
			</div>
			<div>{$tr_cost_dm_trader}<br><br>
			{lang}tr_exchange_quota{/lang}: {$charge}<br>
			</div>
		</td>
    </tr>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}