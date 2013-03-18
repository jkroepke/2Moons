{include file="ins_header.tpl"}
<tr>
	<td colspan="2">
		<div id="main">
			<h2 class="left">{$LNG.upgrade_intro_welcome}</h2>
			{if $file_revision > $sql_revision}
				<form action="?mode=doupgrade" method="POST">
					<p class="left">{sprintf($LNG.upgrade_available,$sql_revision,$file_revision)}<select name="startrevision">{html_options values=$revisionlist output=$revisionlist}</select></p>
					<p><input type="submit" value="{$LNG.continue}"></p>
				</form>
			{else}
				<p class="left">{sprintf($LNG.upgrade_notavailable,$sql_revision)}</p>
				<p><a href="index.php"><button style="cursor: pointer;">{$LNG.upgrade_back}</button></a></p>
			{/if}
		</div>
	</td>
</tr>
{include file="ins_footer.tpl"}