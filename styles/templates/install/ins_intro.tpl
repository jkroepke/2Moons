{include file="ins_header.tpl"}
<tr>
	<td colspan="2">
		<div id="lang" align="right">{lang}intro_lang{/lang}:&nbsp;<select id="lang" name="lang" onchange="document.location = '?lang='+$(this).val();">{html_options options=$Selector selected=$lang}</select></div>
		<div id="main" align="left">
			<h2>{lang}intro_welcome{/lang}</h2>
			<p>{lang}intro_text{/lang}</p>
		</div><br><a href="index.php?step=1"><button style="cursor: pointer;">{lang}continue{/lang}</button></a>
	</td>
</tr>
{include file="ins_footer.tpl"}