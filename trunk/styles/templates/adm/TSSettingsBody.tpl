<br>
<script type='text/javascript'>
function change2(){
	document.getElementById("lang_udp").innerHTML	= "{ts_udpport}:";
	document.getElementById("lang_to").innerHTML	= "{ts_timeout}:";
	document.getElementsByName("ts_v")[0].checked = true;
}
function change3(){
	document.getElementById("lang_udp").innerHTML	= "{ts_server_query}:";
	document.getElementById("lang_to").innerHTML	= "{ts_server_id}:";
	document.getElementsByName("ts_v")[1].checked = true;
}
</script>

<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="519" cellpadding="2" cellspacing="2">
<tr>
	<td class="c" colspan="2">{ts_settings}</td>
</tr><tr>
	<th>{ts_active}<br></th>
	<th><input name="ts_on" {ts_on} type="checkbox"></th>
</tr><tr>
	<th>{ts_version}</th>
	<th><input type="radio" name="ts_v" value="2" onclick="change2();"> 2<br>
    <input type="radio" name="ts_v" value="3" onclick="change3();"> 3</th>
</tr><tr>
	<th>{ts_serverip}:</th>
	<th><input name="ts_ip" maxlength="15" size="10" value="{ts_ip}" type="text"></th>
</tr><tr>
	<th>{ts_tcpport}:</th>
	<th><input name="ts_tcp" maxlength="5" size="10" value="{ts_tcp}" type="text"></th>
</tr><tr>
	<th id="lang_udp">{ts_udpport}:</th>
	<th><input name="ts_udp" maxlength="5" size="10" value="{ts_udp}" type="text"></th>
</tr><tr>
	<th id="lang_to">{ts_timeout}:</th>
	<th><input name="ts_to" maxlength="2" size="10" value="{ts_to}" type="text"></th>
</tr></tr>
	<th colspan="3"><input value="{se_save_parameters}" type="submit"></th>
</tr>
</table>
<script type="text/javascript">
change{ts_v}();
</script>
</form>