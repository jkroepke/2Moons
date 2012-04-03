{include file="ins_header.tpl"}
<tr>
	<td colspan="2"><div id="lang" align="right">{$intro_lang}:&nbsp;<select id="lang" name="lang" onchange="document.location = '?lang='+$(this).val();">{html_options options=$Selector selected=$lang}</select></div>
	<div id="main" align="left">
		<h1>{$fcm_info}</h1>
		{$mes}
		</div></td>
</tr>
{include file="ins_footer.tpl"}