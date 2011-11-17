{include file="install/ins_header.tpl"}
<tr>
	<td colspan="3">[<a href="?mode=intro&amp;{$lang}">{$menu_intro}</a> &bull; <a href="?mode=req&amp;{$lang}">{$menu_install}</a> &bull; <a href="?mode=license&amp;{$lang}">{$menu_license}</a>]</td>
</tr>
<tr>
	<td colspan="2"><div id="lang" align="right">{$intro_lang}:&nbsp;<select id="lang" name="lang" onchange="document.location = '?lang='+$(this).val();">{html_options options=$Selector selected=$lang}</select></div><div id="main" align="left">
		<h1>{$intro_install}</h1>
		<h2>{$intro_welcome}</h2><br>
		{$intro_text}
		</div><br><a href="?mode=req&amp;lang={$lang}"><button style="cursor: pointer;" value="{$intro_instal}">{$intro_instal}</button></a></td>
</tr>
{include file="install/ins_footer.tpl"}