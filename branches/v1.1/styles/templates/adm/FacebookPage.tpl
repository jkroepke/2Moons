{include file="adm/overall_header.tpl"}
<center>
<form action="" method="post">
<table width="519" cellpadding="2" cellspacing="2">
<tr>
	<td class="c" colspan="2">{$fb_settings}</td>
</tr><tr>
	<th colspan="2">{$fb_info}</th>
</tr><tr>
	<th>{$fb_active}</th>
	<th><input name="fb_on"{if $fb_on == 1} checked="checked"{/if} type="checkbox"></th>
</tr><tr>
	<th>{$fb_api_key}</th>
	<th><input name="fb_apikey" size="40" value="{$fb_apikey}" type="text"></th>
</tr><tr>
	<th>{$fb_secrectkey}</th>
	<th><input name="fb_skey" size="40" value="{$fb_skey}" type="text"></th>
</tr></tr>
	<th colspan="3"><input value="{$se_save_parameters}" type="submit"></th>
</tr>
</table>
</form>
</center>
{include file="adm/overall_footer.tpl"}