{include file="overall_header.tpl"}
<center>
<form method="post" action="">
<table width="768">
<tr>
	<th colspan="2">{$et_md5_encripter}</th>
</tr>
<tr>
	<td>{$et_pass}</td>
	<td><input type="text" name="md5q" size="80" value="{$md5_md5}"></td>
</tr><tr>
	<td>{$et_result}</td>
	<td><input type="text" name="md5w" size="80" value="{$md5_enc}" readonly></td>
</tr><tr>
	<td colspan="2"><input type="submit" value="{$et_encript}"></td>
</tr>
</table>
</form>
</center>
{include file="overall_footer.tpl"}