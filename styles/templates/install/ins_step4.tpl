{include file="ins_header.tpl"}
<tr>
	<td colspan="2">
		{nocache}<div id="main" class="left">
			<div class="{$class}"><p>{$message}</p></div>
			{if $class == 'noerror'}
			<div style="text-align:center;"><p>
				<a href="index.php?mode=install&step=5"><button>{$LNG.continue}</button></a>
			</p></div>
			{else}
			<div><p>
				{nocache}<a href="index.php?mode=install&step=3&amp;host={$host}&amp;port={$port}&amp;user={$user}&amp;dbname={$dbname}&amp;prefix={$prefix}">{/nocache}<button>{$LNG.back}</button></a>
			</p></div>
			{/if}
		</div>{/nocache}
	</td>
</tr>
{include file="ins_footer.tpl"}