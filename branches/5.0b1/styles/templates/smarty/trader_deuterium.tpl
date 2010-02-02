{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<script type="text/javascript">
res_a = {$mod_ma_res_a};
res_b = {$mod_ma_res_b};
</script>
<div id="content">
    <form id="trader" action="" method="post">
    <input type="hidden" name="ress" value="deuterium">
    <input type="hidden" name="action" value="trade">
    <table width="569" align="center">
    <tr>
        <td class="c" colspan="5"><b>{$tr_sell_deuterium}</b></td>
    </tr><tr>
        <th>{$tr_resource}</th>
        <th>{$tr_amount}</th>
        <th>{$tr_quota_exchange}</th>
    </tr><tr>
        <th>{$Deuterium}</th>
        <th><span id="deuterium"></span></th>
        <th>{$mod_ma_res}</th>
    </tr><tr>
        <th>{$Metal}</th>
        <th><input name="metal" id="metal" type="text" value="0" onkeyup="calcul('{$ress}')"></th>
        <th>{$mod_ma_res_a}</th>
    </tr><tr>
        <th>{$Crystal}</th>
        <th><input name="crystal" id="crystal" type="text" value="0" onkeyup="calcul('{$ress}')"></th>
        <th>{$mod_ma_res_b}</th>
    </tr><tr>
        <th colspan="6"><input type="submit" value="{$tr_exchange}"></th>
    </tr>
    </table>
    </form>
</div>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}