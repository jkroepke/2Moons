{include file="adm/overall_header.tpl"}
<form action="" method="POST">
<table width="800">
<tr>
<td class="c">Version</td>
</tr>
<tr>
<th>Version: <input type="text" name="version" size="8" value="{$version}"> <input type="submit" value="Send"></th>
</tr>
{$Update}
{$Info}
{$RevList}
<tr>
<th><a href="?page=update&amp;action=history">History</a></th>
</tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}