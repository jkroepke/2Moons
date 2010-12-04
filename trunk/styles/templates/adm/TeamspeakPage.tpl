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
	<td class="c" colspan="2">{$ts_settings}</td>
</tr><tr>
	<th>{$ts_active}<br></th>
	<th><input name="ts_on"{if $ts_on == 1} checked="checked"{/if} type="checkbox"></th>
</tr><tr>
	<th>{$ts_version}</th>
	<th><input type="radio" name="ts_v" value="2" onclick="change2();"> 2 
    <input type="radio" name="ts_v" value="3" onclick="change3();"> 3</th>
</tr><tr>
	<th>{$ts_serverip}:</th>
	<th><input name="ts_ip" maxlength="15" size="10" value="{$ts_ip}" type="text"></th>
</tr><tr>
	<th>{$ts_tcpport}:</th>
	<th><input name="ts_tcp" maxlength="5" size="10" value="{$ts_tcp}" type="text"></th>
</tr><tr>
	<th id="lang_udp">{$ts_udpport}:</th>
	<th><input name="ts_udp" maxlength="5" size="10" value="{$ts_udp}" type="text"></th>
</tr><tr class="v3only">
	<th>{$ts_sq_login}:</th>
	<th><input name="ts_login" size="10" value="{$ts_login}" type="text"></th>
</tr><tr class="v3only">
	<th>{$ts_sq_pass}:</th>
	<th><input name="ts_password" size="10" value="{$ts_password}" type="password"></th>
</tr><tr>
	<th>{$ts_timeout}:</th>
	<th><input name="ts_to" maxlength="2" size="10" value="{$ts_to}" type="text"></th>
</tr><tr>
	<th>{$ts_lng_cron}:</th>
	<th><input name="ts_cron" maxlength="2" size="10" value="{$ts_cron}" type="text"></th>
</tr><tr>
	<th colspan="3"><input value="{$se_save_parameters}" type="submit"></th>
</tr>
</table>
<script type="text/javascript">
change{$ts_v}();
</script>
</form>
{include file="adm/overall_footer.tpl"}