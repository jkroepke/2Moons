<form action="" method="post">
<input name="action" type="hidden" value="send">
<input name="id_1" type="hidden" value="{$id}">
{include file="adm/overall_header.tpl"}
<table width="55%">
<tr>
	<td class="c" colspan="2">{$ad_authlevel_title}</td>
</tr>
	<th>
		{$User}
	</th>
	<th>
		<a href="javascript:;" onclick="$('.yes').attr('checked', 'checked');">{$yesorno.1}</a> <a href="javascript:;" onclick="$('.no').attr('checked', 'checked');">{$yesorno.0}</a>
	</th>
</tr>
{foreach item=File from=$Files}
<tr>
	<th>
		{$File}
	</th>
	<th>
		{$yesorno.1} <input class="yes" name="rights[{$File}]" type="radio"{if $Rights.$File == 1} checked="checked"{/if} value="1"> {$yesorno.0} <input class="no" name="rights[{$File}]" type="radio"{if $Rights.$File != 1} checked="checked"{/if} value="0">
	</th>
</tr>
{/foreach}
<tr><th colspan="3"><input type="submit" value="{$button_submit}"></th></tr>
</table>
{include file="adm/overall_footer.tpl"}