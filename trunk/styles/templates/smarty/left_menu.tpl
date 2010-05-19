<div id='leftmenu'>
<div id='menu'>
<p class="p">
{$title}&nbsp;(<a href="?page=changelog">{$smarty.const.VERSION}</a>)
</p>
<table width="100%" cellspacing="0" cellpadding="0">
{if $authlevel > 0}
<tr>
	<td>
		<div align="center">
			<a href="javascript:top.location.href='./adm/index.php';"><font color="lime">{$lm_administration}</font></a>
		</div>
	</td>
</tr>
{/if}
<tr>
	<td>
		<img src="styles/skins/darkness/gfx/ogame-produktion.jpg" width="110" height="40" alt="">
	</td>

</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=overview"><font color="white">{$lm_overview}</font></a>
		</div>
	</td>
</tr>
<tr>
	<td>

		<div align="center">
			<a href="?page=imperium"><font color="white">{$lm_empire}</font></a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=buildings"><font color="white">{$lm_buildings}</font></a>

		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=resources"><font color="white">{$lm_resources}</font></a>
		</div>
	</td>

</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=trader"><font color="white">{$lm_trader}</font></a>
		</div>
	</td>
</tr>
<tr>
	<td>

		<div align="center">
			<a href="?page=buildings&amp;mode=research"><font color="white">{$lm_research}</font></a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=buildings&amp;mode=fleet"><font color="white">{$lm_shipshard}</font></a>

		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=fleet"><font color="white">{$lm_fleet}</font></a>
		</div>
	</td>

</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=techtree"><font color="white">{$lm_technology}</font></a>
		</div>
	</td>
</tr>
<tr>
	<td>

		<div align="center">
			<a href="?page=galaxy"><font color="white">{$lm_galaxy}</font></a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=buildings&amp;mode=defense"><font color="white">{$lm_defenses}</font></a>

		</div>
	</td>
</tr>
<tr>
	<td>
		<img src="styles/skins/darkness/gfx/user-menu.jpg" width="110" height="40" alt="">
	</td>
</tr>
<tr>
	<td>
		<div align="center">

			<a href="?page=alliance"><font color="white">{$lm_alliance}</font></a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="{$forum_url}" target="forum"><font color="white">{$lm_forums}</font></a>
		</div>

	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=officier"><font color="white">{$lm_officiers}</font></a>
		</div>
	</td>
</tr>
<tr>

	<td>
		<div align="center">
			<a href="?page=statistics"><font color="white">{$lm_statistics}</font></a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">

			<a href="?page=records"><font color="white">{$lm_records}</font></a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=topkb"><font color="white">{$lm_topkb}</font></a>
		</div>

	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=search"><font color="white">{$lm_search}</font></a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=battlesim"><font color="white">{$lm_battlesim}</font></a>
		</div>
	</td>
</tr>
<tr>

	<td>
		<img src="styles/skins/darkness/gfx/user-menu.jpg" width="110" height="40" alt="">
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=messages"><font color="white">{$lm_messages}{if $new_message > 0} ({$new_message}){/if}</font></a>
		</div>

	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="javascript:f('?page=notes','{$lm_notes}');"><font color="white">{$lm_notes}</font></a>
		</div>
	</td>
</tr>
<tr>

	<td>
		<div align="center">
			<a href="?page=buddy"><font color="white">{$lm_buddylist}</font></a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">

			<a href="?page=chat"><font color="white">{$lm_chat}</font></a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=support"><font color="white">{$lm_support}</font></a>
		</div>

	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=faq"><font color="white">{$lm_faq}</font></a>
		</div>
	</td>
</tr>
<tr>

	<td>
		<div align="center">
			<a href="?page=options"><font color="white">{$lm_options}</font></a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">

			<a href="?page=banned"><font color="white">{$lm_banned}</font></a>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="./?page=rules" target="forum"><font color="white">{$lm_rules}</font></a>
		</div>

	</td>
</tr>
<tr>
	<td>
		<div align="center">
			<a href="?page=logout"><font color="white">{$lm_logout}</font></a>
		</div>
	</td>
</tr>
</table>
</div>
</div>