<br><br>
<script type="text/javascript">
	function ajax(url) {
		$.get(url, function(data){alert(data);parent.frames['Hauptframe'].location.reload()});
	}
</script>
{show_edit_form}
<h2>Userlist</h2>
<table width="450">
<tr>
	<td class="c" colspan="7">Nicht aktivierte User</td>
</tr>
<tr>
	<th>ID</th>
	<th>Username</th>
	<th>Datum</th>
	<th>E-Mail</th>
	<th>IP</th>
	<th>Akitvieren</th>
	<th>Del</th>
</tr>
{planetes}
</table>