{include file="ins_header.tpl"}
<tr>
	<td colspan="2">
		<div id="main">
			<h2 class="left">{$LNG.upgrade_intro_welcome}</h2>
			{if !empty($updates)}
				<form action="?mode=doupgrade" method="POST">
					<p class="left">{sprintf($LNG.upgrade_available,$sql_revision,$file_revision)}</p>

					{foreach $updates as $file => $content}
						<div><p class="left">{$file}</p><div style="border: 1px solid #1C1F23; padding: 5px 10px; margin: 5px 10px;" class="left">{$content}</div></div>
					{/foreach}
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