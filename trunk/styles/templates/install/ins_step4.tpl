{include file="ins_header.tpl"}
<tr>
	<td colspan="2">
		<div id="main" class="left">
			<div class="{$class}"><p>{$message}</p></div>
			{if $class == 'noerror'}
			<div style="text-align:center;"><p>
				<a href="index.php?step=5"><button>{lang}continue{/lang}</button></a>
			</p></div>
			{else}
			<div><p>
				<a href="index.php?step=3&amp;host={$host}&amp;port={$port}&amp;user={$user}&amp;dbname={$dbname}&amp;prefix={$prefix}"><button>{lang}back{/lang}</button></a>
			</p></div>
			{/if}
		</div>
	</td>
</tr>
{include file="ins_footer.tpl"}