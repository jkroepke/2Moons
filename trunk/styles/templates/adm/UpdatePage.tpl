{include file="adm/overall_header.tpl"}
<form action="" method="POST">
<table width="800">
<tr>
<th>Version</th>
</tr>
<tr>
<td>Version: <input type="text" name="version" size="8" value="{$version}"> <input type="submit" value="Send"></td>
</tr>
{$Update}
{$Info}
{$RevList}
<tr>
<td><a href="?page=update&amp;action=history">History</a></td>
</tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}