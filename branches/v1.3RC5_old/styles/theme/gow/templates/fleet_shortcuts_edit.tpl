{include file="overall_header.tpl"}
<form method="POST" action="">
<table style="width:95%;">
<tr style="height: 20px;">
	<th>{$fl_shortcut_edition} {$name} [{$galaxy}:{$system}:{$planet}]</th></tr>
<tr style="height: 20px;">
	<td>
		<input type="hidden" name="a" value="{$id}">
		<input type="text" name="n" value="{$name}" size="32" maxlength="32">
		<input type="text" name="g" value="{$galaxy}" size="3" maxlength="1">
		<input type="text" name="s" value="{$system}" size="3" maxlength="3">
		<input type="text" name="p" value="{$planet}" size="3" maxlength="3">
		{html_options options=$typeselector selected=$type name=t}
	</td>
</tr><tr>
	<td><input type="reset" value="{$fl_reset_shortcut}"><input type=submit value="{$fl_register_shorcut}"><input type="submit" name="delete" value="{$fl_dlte_shortcut}"></td>
</tr>
<tr><th><a href="?page=shortcuts();">{$fl_back}</a></th></tr></table></form>
{include file="overall_footer.tpl"}