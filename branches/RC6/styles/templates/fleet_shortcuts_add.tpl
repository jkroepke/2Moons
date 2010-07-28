{include file="overall_header.tpl"}
<form method="POST" action="">
<table border="0" cellpadding="0" cellspacing="1" width="519" align="center">
<tr style="height: 20px;">
	<td colspan="2" class="c">{$fl_shortcut_add_title}</td></tr>
<tr style="height: 20px;">
	<th>
		<input type="text" name="n" value="{$name}" size="32" maxlength="32">
		<input type="text" name="g" value="{$galaxy}" size="3" maxlength="1">
		<input type="text" name="s" value="{$system}" size="3" maxlength="3">
		<input type="text" name="p" value="{$planet}" size="3" maxlength="3">
		{html_options options=$typeselector selected=$type name=t}
	</th>
</tr><tr>
	<th><input type="reset" value="{$fl_clean}"> <input type="submit" value="{$fl_register_shorcut}"></th>
</tr>
<tr><td class="c" colspan="2"><a href="?page=shortcuts();">{$fl_back}</a></td></tr></table></from>
{include file="overall_footer.tpl"}