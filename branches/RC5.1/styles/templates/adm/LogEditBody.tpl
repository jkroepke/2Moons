<script>document.body.style.overflow = "auto";</script>
<body>
<h2>{setarchive} {setsize}</h2>
<table>
<tr>
	<td class="c">
		<a href="LogToolPage.php?options=delete&file={setarchive}" onClick=" return confirm('{log_alert}');">{log_delete_link}</a>&nbsp;
		<a href="LogToolPage.php?options=edit&file={setarchive}">{log_edit_link}</a>&nbsp;
		<a href="LogToolPage.php?options=links&file={setarchive}">{log_go_back}</a>
	</td>
</tr>
<form action="" method="post">
<tr>
	<th>
		<textarea rows="25" cols="100" name="text">
		{display}
		</textarea>
	</th>
</tr><tr>
	<th>
	<input type="submit" value="{log_input_value}" name="editnow" onClick="LogToolPage.php?options=edit&file={setarchive}"/>
	</th>
</tr>
</form>
</table>
</body>