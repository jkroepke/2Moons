{include file="adm/overall_header.tpl"}
<form action="" method="post">
<table width="30%">
<tr><td class="c" colspan="6">{$mod_title}</td></tr>
<tr>
<th><img title="{$mod_range}" src="./styles/images/arrow.gif"></th>
<th><img title="{$mod_power_config}" src="./styles/images/r4.png"></th>
<th><img title="{$mod_power_edit}" src="./styles/images/r3.png"></th>
<th><img title="{$mod_power_view}" src="./styles/images/r2.png"></th>
<th><img title="{$mod_power_tools}" src="./styles/images/r5.png"></th>
<th><img title="{$mod_power_loog}" src="./styles/images/r6.png"></th>
</tr>

<tr>
<th>{$mods}</th>
<th><input type="checkbox"{if $config_m}checked="checked"{/if} name="config_m"></th>
<th><input type="checkbox"{if $edit_m}checked="checked"{/if} name="edit_m"></th>
<th><input type="checkbox"{if $view_m}checked="checked"{/if} name="view_m"></th>
<th><input type="checkbox"{if $tools_m}checked="checked"{/if} name="tools_m"></th>
<th><input type="checkbox" name="log_m" disabled="disabled"></th>
</tr>

<tr>
<th>{$oper}</th>
<th><input type="checkbox"{if $config_o}checked="checked"{/if} name="config_o"></th>
<th><input type="checkbox"{if $edit_o}checked="checked"{/if} name="edit_o"></th>
<th><input type="checkbox"{if $view_o}checked="checked"{/if} name="view_o"></th>
<th><input type="checkbox"{if $tools_o}checked="checked"{/if} name="tools_o"></th>
<th><input type="checkbox" name="log_o" disabled="disabled"></th>
</tr>

<tr>
<th>{$adm}</th>
<th><input type="checkbox" checked="checked" disabled="disabled"></th>
<th><input type="checkbox" checked="checked" disabled="disabled"></th>
<th><input type="checkbox" checked="checked" disabled="disabled"></th>
<th><input type="checkbox" checked="checked" disabled="disabled"></th>
<th><input type="checkbox" name="log_a" disabled="disabled"></th>
</tr>
<tr><th colspan="6"><input type="submit" value="{$button_submit}"></th></tr>
</table>
<br>
<table width="30%">
<tr><th><img src="./styles/images/r4.png"></th><th>{$mod_power_config}</th></tr>
<tr><th><img src="./styles/images/r3.png"></th><th>{$mod_power_edit}</th></tr>
<tr><th><img src="./styles/images/r2.png"></th><th>{$mod_power_view}</th></tr>
<tr><th><img src="./styles/images/r5.png"></th><th>{$mod_power_tools}</th></tr>
<tr><th><img src="./styles/images/r6.png"></th><th>{$mod_power_loog}</th></tr>
</table>
{include file="adm/overall_footer.tpl"}