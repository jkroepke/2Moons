<br>
<script type='text/javascript'>
function change2(){
	document.getElementById("lang_tcp").innerHTML	= "TCP-Port:";
	document.getElementById("lang_udp").innerHTML	= "UDP-Port:";
	document.getElementById("lang_to").innerHTML	= "Server Timeout:";
	document.getElementsByName("ts_v")[0].checked = true;
}
function change3(){
	document.getElementById("lang_tcp").innerHTML	= "Server-Port:";
	document.getElementById("lang_udp").innerHTML	= "Server-Telnet-Port:";
	document.getElementById("lang_to").innerHTML	= "Server ID:";
	document.getElementsByName("ts_v")[1].checked = true;
}
</script>

<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="519" cellpadding="2" cellspacing="2">
<tr>
	<td class="c" colspan="2">{se_server_parameters}</td>
</tr><tr>
	<th>Teamspeak-Mod aktivieren?<br /></th>
	<th><input name="ts_on" {ts_on} type="checkbox"></th>
</tr><tr>
	<th>Server-Version:</th>
	<th><input type="radio" name="ts_v" value="2" onclick="change2();"> 2<br>
    <input type="radio" name="ts_v" value="3" onclick="change3();"> 3</th>
</tr><tr>
	<th>Server-IP:</th>
	<th><input name="ts_ip" maxlength="15" size="10" value="{ts_ip}" type="text"></th>
</tr><tr>
	<th id="lang_tcp">TCP-Port:</th>
	<th><input name="ts_tcp" maxlength="5" size="10" value="{ts_tcp}" type="text"></th>
</tr><tr>
	<th id="lang_udp">UDP-Port:</th>
	<th><input name="ts_udp" maxlength="5" size="10" value="{ts_udp}" type="text"></th>
</tr><tr>
	<th id="lang_to">Server Timeout:</th>
	<th><input name="ts_to" maxlength="2" size="10" value="{ts_to}" type="text"></th>
</tr></tr>
	<th colspan="3"><input value="{se_save_parameters}" type="submit"></th>
</tr>
</table>
<script type="text/javascript">
change{ts_v}();
</script>
</form>