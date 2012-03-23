{extends file="index.tpl"}
{block name="title" prepend}{$LNG.screenshots}{/block}
{block name="content"}
<table>
	<tr>
		<td style="padding-top:13px;">
			<a class="gallery" href="./styles/images/screens/overview.jpg" target="_blank" rel="gallery">
				<img src="./styles/images/screens/thumb_overview.jpg" alt="">
			</a>
		</td>
		<td style="padding-top:13px;">
			<a class="gallery" href="./styles/images/screens/imperium.jpg" target="_blank" rel="gallery">
				<img src="./styles/images/screens/thumb_imperium.jpg" alt="">
			</a>
		</td>
	</tr>
	<tr>
		<td style="padding-top:13px;">
			<a class="gallery" href="./styles/images/screens/build.jpg" target="_blank" rel="gallery">
				<img src="./styles/images/screens/thumb_build.jpg" alt="">
			</a>
		</td>
		<td style="padding-top:13px;">
			<a class="gallery" href="./styles/images/screens/galaxy.jpg" target="_blank" rel="gallery">
				<img src="./styles/images/screens/thumb_galaxy.jpg" alt="">
			</a>
		</td>
	</tr>
	<tr>
		<td style="padding-top:13px;">
			<a class="gallery" href="./styles/images/screens/ally.jpg" target="_blank" rel="gallery">
				<img src="./styles/images/screens/thumb_ally.jpg" alt="">
			</a>
		</td>
		<td style="padding-top:13px;">
			<a class="gallery" href="./styles/images/screens/fleet.jpg" target="_blank" rel="gallery">
				<img src="./styles/images/screens/thumb_fleet.jpg" alt="">
			</a>
		</td>
	</tr>
</table>
{/block}
{block name="script"}
<script>
$(".gallery").fancybox();
</script>
{/block}