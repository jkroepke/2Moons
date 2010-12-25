{include file="adm/overall_header.tpl"}
<center>
<form method="post" action="">
<table width="40%">
<tr>
	<td class="c" colspan="2">{$et_md5_encripter}</td>
</tr>
<tr>
	<th>{$et_pass}</th>
	<th><input type="text" name="md5q" size="45" value="{$md5_md5}"></th>
</tr><tr>
	<th>{$et_result}</th>
	<th><input type="text" name="md5w" size="45" value="{$md5_enc}"></th>
</tr><tr>
	<th colspan="2"><input type="submit" value="{$et_encript}"></th>
</tr>
</table>
</form>
</center>
{include file="adm/overall_footer.tpl"}