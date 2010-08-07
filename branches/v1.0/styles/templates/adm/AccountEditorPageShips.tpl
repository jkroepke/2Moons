{include file="adm/overall_header.tpl"}
<form action="" method="post">
<table width="45%">
<tr>
<th colspan="3" align="left"><a href="?page=accounteditor">
<img src="./styles/images/Adm/arrowright.png" width="16" height="10"> {$ad_back_to_menu}</a></th>
</tr><tr>
	<td class="c" colspan="7">{$ships_title}</td>
</tr><tr>
	<th colspan="2">{$input_id_p_m}</th>
	<th><input name="id" type="text" value="0" size="3"></th>
</tr><tr>
	<td class="c">{$ad_number}</td>
	<td class="c">{$ships_title}</td>
	<td class="c">{$ships_count}</td>
</tr>
{foreach key=id item=input from=$inputlist}
<tr><th>{$id}</th><th>{$input.name}</th><th><input name="{$input.type}" type="text" value="0"></th></tr>
{/foreach}
<tr>
	<th colspan="3">
	<input type="reset" value="{$button_reset}"><br><br>
	<input type="submit" value="{$button_add}" name="add">&nbsp;
	<input type="submit" value="{$button_delete}" name="delete"></th>
</tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}