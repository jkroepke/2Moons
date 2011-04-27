{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
<form action="game.php?page=trader" method="post">
    <table style="width:519px;">
    <tr>
        <th colspan="10">{$tr_call_trader}</th>
    </tr><tr>
        <td colspan="10">{$tr_call_trader_who_buys}
          <select name="ress">
            <option value="metal">{$Metal}</option>
            <option value="crystal">{$Crystal}</option>
            <option value="deuterium">{$Deuterium}</option>
        </select>
        <br><br>{$tr_cost_dm_trader}<br><br>
        {$tr_exchange_quota}<br>
        <input type="submit" value="{$tr_call_trader_submit}"></td>
    </tr>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}