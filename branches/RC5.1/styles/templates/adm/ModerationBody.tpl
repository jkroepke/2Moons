<script>document.body.style.overflow = "auto";</script> 
<body>
<form action="" method="post">
<table width="30%">
<tr><td class="c" colspan="6">{mod_title}</td></tr>
<tr>
<th><img title="{mod_range}" src="../styles/images/arrow.gif" /></th>
<th><img title="{mod_power_config}" src="../styles/images/r4.png" /></th>
<th><img title="{mod_power_edit}" src="../styles/images/r3.png" /></th>
<th><img title="{mod_power_view}" src="../styles/images/r2.png" /></th>
<th><img title="{mod_power_tools}" src="../styles/images/r5.png" /></th>
<th><img title="{mod_power_loog}" src="../styles/images/r6.png" /></th>
</tr>

<tr>
<th>{mods}</th>
<th><input type="checkbox"{config_m} name="config_m"/></th>
<th><input type="checkbox"{edit_m} name="edit_m"/></th>
<th><input type="checkbox"{view_m} name="view_m"/></th>
<th><input type="checkbox"{tools_m} name="tools_m"/></th>
<th><input type="checkbox"{log_m} name="log_m"/></th>
</tr>

<tr>
<th>{oper}</th>
<th><input type="checkbox"{config_o} name="config_o"/></th>
<th><input type="checkbox"{edit_o} name="edit_o"/></th>
<th><input type="checkbox"{view_o} name="view_o"/></th>
<th><input type="checkbox"{tools_o} name="tools_o"/></th>
<th><input type="checkbox"{log_o} name="log_o"/></th>
</tr>

<tr>
<th>{adm}</th>
<th><input type="checkbox" checked="checked" disabled="disabled"/></th>
<th><input type="checkbox" checked="checked" disabled="disabled"/></th>
<th><input type="checkbox" checked="checked" disabled="disabled"/></th>
<th><input type="checkbox" checked="checked" disabled="disabled"/></th>
<th><input type="checkbox"{log_a} name="log_a"/></th>
</tr>
<tr><th colspan="6"><input type="submit" value="{button_submit}" name="mode" /></th></tr>
</table>

<br />
<table width="30%">
<tr><th><img src="../styles/images/r4.png" /></th><th>{mod_power_config}</th></tr>
<tr><th><img src="../styles/images/r3.png" /></th><th>{mod_power_edit}</th></tr>
<tr><th><img src="../styles/images/r2.png" /></th><th>{mod_power_view}</th></tr>
<tr><th><img src="../styles/images/r5.png" /></th><th>{mod_power_tools}</th></tr>
<tr><th><img src="../styles/images/r6.png" /></th><th>{mod_power_loog}</th></tr>
</table>
</form>
</body>