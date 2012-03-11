{include file="ins_header.tpl"}
<tr>
	<td colspan="2">
		<div id="lang" align="right">{$LNG.intro_lang}:&nbsp;<select id="lang" name="lang" onchange="document.location = '?lang='+$(this).val();">{html_options options=$Selector selected=$lang}</select></div>
		<div id="main" align="left">
			<h2>{$LNG.intro_welcome}</h2>
			<p>{$LNG.intro_text}</p>
		</div><br><a href="index.php?step=1"><button style="cursor: pointer;">{$LNG.continue}</button></a>
	</td>
</tr>
{include file="ins_footer.tpl"}