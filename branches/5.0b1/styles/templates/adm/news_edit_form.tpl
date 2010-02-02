<form action="" method="post">
<input type="hidden" name="currid" value="{id}">
<table>
<tr>
	<td class="c" colspan="2">News {title} bearbeiten</td>
</tr>
<tr>
<th width="25%">User</th><th>{user}</th></tr>
<tr><th>Titel</th><th><input type="text" name="title" value="{title}"></th></tr>
<tr><th>Inhalt</th><th ><textarea cols="70" rows="10" name="text">{text}</textarea></th></tr>
<tr>
        <th colspan="2"><input type="Submit" name="submit" value="&Auml;nderungen speichern" /></th>
</tr>
</table>
</form>