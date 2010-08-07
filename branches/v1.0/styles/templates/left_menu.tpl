<div id='leftmenu'>
<div id='menu'>
<p class="p">
{$title}&nbsp;(<a href="?page=changelog">{$smarty.const.VERSION}</a>)
</p>
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
	<td>
		<img src="{$dpath}gfx/ogame-produktion.jpg" width="110" height="40" alt="">
	</td>

</tr>
{if $authlevel > 0}
<tr>
	<td>
		<div align="center">
			<a href="./admin.php"><font color="lime">{$lm_administration}</font></a>
		</div>
	</td>
</tr>
{/if}
<tr>
	<td>
		<div align="center">
			<a href="?page=overview">{$lm_overview}</a>
		</div>
	</td>
</tr>
<tr>
	<td>

		<div align="center">
			<a href="?page=imperium">{$lm_empire}</a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=buildings">{$lm_buildings}</a>

		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=resources">{$lm_resources}</a>
		</div>
	</td>

</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=trader">{$lm_trader}</a>
		</div>
	</td>
</tr>
<tr>
	<td>

		<div align="center">
			<a href="?page=buildings&amp;mode=research">{$lm_research}</a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=buildings&amp;mode=fleet">{$lm_shipshard}</a>

		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=fleet">{$lm_fleet}</a>
		</div>
	</td>

</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=techtree">{$lm_technology}</a>
		</div>
	</td>
</tr>
<tr>
	<td>

		<div align="center">
			<a href="?page=galaxy">{$lm_galaxy}</a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=buildings&amp;mode=defense">{$lm_defenses}</a>

		</div>
	</td>
</tr>
<tr>
	<td>
		<img src="{$dpath}gfx/user-menu.jpg" width="110" height="40" alt="">
	</td>
</tr>
<tr>
	<td>
		<div align="center">

			<a href="?page=alliance">{$lm_alliance}</a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="{$forum_url}" target="forum">{$lm_forums}</a>
		</div>

	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=officier">{$lm_officiers}</a>
		</div>
	</td>
</tr>
<tr>

	<td>
		<div align="center">
			<a href="?page=statistics">{$lm_statistics}</a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">

			<a href="?page=records">{$lm_records}</a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=topkb">{$lm_topkb}</a>
		</div>

	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=search">{$lm_search}</a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=battlesim">{$lm_battlesim}</a>
		</div>
	</td>
</tr>
<tr>

	<td>
		<img src="{$dpath}gfx/user-menu.jpg" width="110" height="40" alt="">
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=messages">{$lm_messages}{if $new_message > 0}<span id="newmes"> (<span id="newmesnum">{$new_message}</span>)</span>{/if}</a>
		</div>

	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="javascript:f('?page=notes','{$lm_notes}');">{$lm_notes}</a>
		</div>
	</td>
</tr>
<tr>

	<td>
		<div align="center">
			<a href="?page=buddy">{$lm_buddylist}</a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">

			<a href="?page=chat">{$lm_chat}</a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=support">{$lm_support}</a>
		</div>

	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=faq">{$lm_faq}</a>
		</div>
	</td>
</tr>
<tr>

	<td>
		<div align="center">
			<a href="?page=options">{$lm_options}</a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">

			<a href="?page=banned">{$lm_banned}</a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="./?page=rules" target="forum">{$lm_rules}</a>
		</div>

	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=logout">{$lm_logout}</a>
		</div>
	</td>
</tr>
</table>
</div>
</div>