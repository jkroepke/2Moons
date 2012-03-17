{include file="overall_header.tpl"}
<form action="" method="post">
<table width="45%">
<tr>
<td colspan="3" align="left"><a href="?page=accounteditor">
<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$LNG.ad_back_to_menu}</a></td>
</tr><tr>
	<th colspan="3">{$LNG.ad_research_title}</th>
</tr><tr>
	<td colspan="2">{$LNG.input_id_user}</td>
	<td><input name="id" type="text" value="0" size="3"></td>
</tr><tr>
	<th>{$LNG.ad_number}</th>
	<th>{$LNG.ad_research}</th>
	<th>{$LNG.ad_count}</th>
</tr>
{foreach key=id item=input from=$inputlist}
<tr><td>{$id}</td><td>{$LNG.tech.{$id}}</td><td><input name="{$input.type}" type="text" value="0"></td></tr>
{/foreach}
<tr>
	<td colspan="3">
	<input type="reset" value="{$LNG.button_reset}"><br><br>
	<input type="submit" value="{$LNG.button_add}" name="add">&nbsp;
	<input type="submit" value="{$LNG.button_delete}" name="delete"></td>
</tr>
</table>
</form>
{include file="overall_footer.tpl"}