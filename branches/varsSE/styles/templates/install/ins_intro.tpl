{include file="ins_header.tpl"}
<tr>
	<td colspan="2">
		<div id="lang" align="right">{$LNG.intro_lang}:&nbsp;<select id="lang" name="lang" onchange="document.location = '?lang='+$(this).val();">{html_options options=$Selector selected=$lang}</select></div>
		<div id="main" align="left">
			<h2>{$LNG.intro_welcome}</h2>
			<p>{$LNG.intro_text}</p>
		</div><br><a href="index.php?mode=install&step=1"><button style="cursor: pointer;">{$LNG.continue}</button></a>
	</td>
</tr>
{if $canUpgrade}
<tr>
	<th colspan="3">{$LNG.menu_upgrade}</th>
</tr>
<tr>
	<td colspan="2">
		<div id="main" align="left">
			<h2>{$LNG.intro_upgrade_head}</h2>
			<p>{$LNG.intro_upgrade_text}</p>
		</div><br><a href="index.php?mode=upgrade"><button style="cursor: pointer;">{$LNG.continueUpgrade}</button></a>
	</td>
</tr>
{/if}
{include file="ins_footer.tpl"}