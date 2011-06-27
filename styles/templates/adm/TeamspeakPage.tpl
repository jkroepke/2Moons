{include file="adm/overall_header.tpl"}
<script type='text/javascript'>
function change2(){
	$("#lang_udp").text("{$ts_udpport}:");
	document.getElementsByName("ts_v")[0].checked = true;
	$(".v3only").hide();
}
function change3(){
	$("#lang_udp").text("{$ts_server_query}:");
	document.getElementsByName("ts_v")[1].checked = true;
	$(".v3only").show();
}
</script>

<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="519" cellpadding="2" cellspacing="2">
<tr>
	<th colspan="2">{$ts_settings}</th>
</tr><tr>
	<td>{$ts_active}<br></td>
	<td><input name="ts_on"{if $ts_on == 1} checked="checked"{/if} type="checkbox"></td>
</tr><tr>
	<td>{$ts_version}</td>
	<td><input type="radio" name="ts_v" value="2" onclick="change2();"> 2 
    <input type="radio" name="ts_v" value="3" onclick="change3();"> 3</td>
</tr><tr>
	<td>{$ts_serverip}:</td>
	<td><input name="ts_ip" maxlength="15" size="10" value="{$ts_ip}" type="text"></td>
</tr><tr>
	<td>{$ts_tcpport}:</td>
	<td><input name="ts_tcp" maxlength="5" size="10" value="{$ts_tcp}" type="text"></td>
</tr><tr>
	<td id="lang_udp">{$ts_udpport}:</td>
	<td><input name="ts_udp" maxlength="5" size="10" value="{$ts_udp}" type="text"></td>
</tr><tr class="v3only">
	<td>{$ts_sq_login}:</td>
	<td><input name="ts_login" size="10" value="{$ts_login}" type="text"></td>
</tr><tr class="v3only">
	<td>{$ts_sq_pass}:</td>
	<td><input name="ts_password" size="10" value="{$ts_password}" type="password"></td>
</tr><tr>
	<td>{$ts_timeout}:</td>
	<td><input name="ts_to" maxlength="2" size="10" value="{$ts_to}" type="text"></td>
</tr><tr>
	<td>{$ts_lng_cron}:</td>
	<td><input name="ts_cron" maxlength="2" size="10" value="{$ts_cron}" type="text"></td>
</tr><tr>
	<td colspan="3"><input value="{$se_save_parameters}" type="submit"></td>
</tr>
</table>
<script type="text/javascript">
change{$ts_v}();
</script>
</form>
{include file="adm/overall_footer.tpl"}