{include file="overall_header.tpl"}
<form action="" method="post">
<table width="70%" cellpadding="2" cellspacing="2">
<tr>
	<th colspan="2">{$se_server_parameters}</th>
	<th>(?)</th>
</tr><tr>
	<td>{$se_disclamerAddress}</td>
	<td><textarea name="disclamerAddress" cols="80" rows="5">{$disclamerAddress}</textarea></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$se_disclamerPhone}</td>
	<td><input name="disclamerPhone" size="40" value="{$disclamerPhone}" type="text"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$se_disclamerMail}</td>
	<td><input name="disclamerMail" size="40" value="{$disclamerMail}" type="text"></td>
	<td>&nbsp;</td>
</tr><tr>
	<td>{$se_disclamerNotice}</td>
	<td><textarea name="disclamerNotice" cols="80" rows="5">{$disclamerNotice}</textarea></td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td colspan="3"><input value="{$se_save_parameters}" type="submit"></td>
</tr>
</table>
</form>
{include file="overall_footer.tpl"}