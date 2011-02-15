{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<script type="text/javascript">
res_a = {$mod_ma_res_a};
res_b = {$mod_ma_res_b};
</script>
<div id="content" class="content">
    <form id="trader" action="" method="post">
    <input type="hidden" name="ress" value="deuterium">
    <input type="hidden" name="action" value="trade">
    <table class="table569">
    <tr>
        <th colspan="3">{$tr_sell_deuterium}</th>
    </tr><tr>
        <td>{$tr_resource}</td>
        <td>{$tr_amount}</td>
        <td>{$tr_quota_exchange}</td>
    </tr><tr>
        <td>{$Deuterium}</td>
        <td id="deuterium">&nbsp;</td>
        <td>{$mod_ma_res}</td>
    </tr><tr>
        <td>{$Metal}</td>
        <td><input name="metal" id="metal" type="text" value="0" onkeyup="calcul('{$ress}')"></td>
        <td>{$mod_ma_res_a}</td>
    </tr><tr>
        <td>{$Crystal}</td>
        <td><input name="crystal" id="crystal" type="text" value="0" onkeyup="calcul('{$ress}')"></td>
        <td>{$mod_ma_res_b}</td>
    </tr><tr>
        <td colspan="3"><input type="submit" value="{$tr_exchange}"></td>
    </tr>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}