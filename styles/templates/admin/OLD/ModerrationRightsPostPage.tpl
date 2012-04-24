<form action="" method="post">
<input name="action" type="hidden" value="send">
<input name="id_1" type="hidden" value="{$id}">
{include file="overall_header.tpl"}
<table width="55%">
<tr>
	<th colspan="2">{$ad_authlevel_title}</th>
</tr>
	<td>
		{$User}
	</td>
	<td>
		<a href="javascript:;" onclick="$('.yes').attr('checked', 'checked');">{$yesorno.1}</a> <a href="javascript:;" onclick="$('.no').attr('checked', 'checked');">{$yesorno.0}</a>
	</td>
</tr>
{foreach item=File from=$Files}
<tr>
	<td>
		{$File}
	</td>
	<td>
		{$yesorno.1} <input class="yes" name="rights[{$File}]" type="radio"{if $Rights.$File == 1} checked="checked"{/if} value="1"> {$yesorno.0} <input class="no" name="rights[{$File}]" type="radio"{if $Rights.$File != 1} checked="checked"{/if} value="0">
	</td>
</tr>
{/foreach}
<tr><td colspan="3"><input type="submit" value="{$button_submit}"></td></tr>
</table>
{include file="overall_footer.tpl"}