<script>document.body.style.overflow = "auto";</script>
<body>
<h2>{setarchive} {setsize}</h2>
<table width="50%">
<tr>
	<td class="c">
		{log_title}
	</td>
	<td class="c" width="2%">
		<a href="Moderation.php?moderation=1"><img src="../styles/images/Adm/i.gif" onMouseOver='return overlib("{log_search_advert_popup}", CENTER, OFFSETX, -150, OFFSETY, -10, WIDTH, 250);' onMouseOut='return nd();'></a>
	</td>
</tr><tr>
	<th align="left" colspan="2">
		<a href="LogToolPage.php?options=links&file=BuildingsLog">{log_log_body_build}</a>
	</th>
</tr><tr>
	<th align="left" colspan="2">
		<a href="LogToolPage.php?options=links&file=ResourcesLog">{log_log_body_resou}</a>
	</th>
</tr><tr>
	<th align="left" colspan="2">
		<a href="LogToolPage.php?options=links&file=DefensesLog">{log_log_body_def}</a>
	</th>
</tr><tr>
	<th align="left" colspan="2">
		<a href="LogToolPage.php?options=links&file=ShipsLog">{log_log_body_ships}</a>
	</th>
</tr><tr>
	<th align="left" colspan="2">
		<a href="LogToolPage.php?options=links&file=ResearchLog">{log_log_body_techs}</a>
	</th>
</tr><tr>
	<th align="left" colspan="2">
		<a href="LogToolPage.php?options=links&file=OfficierLog">{log_log_body_offi}</a>
	</th>
</tr><tr>
	<th align="left" colspan="2">
		<a href="LogToolPage.php?options=links&file=PersonalLog">{log_log_body_personal}</a>
	</th>
</tr><tr>
	<th align="left" colspan="2">
		<a href="LogToolPage.php?options=links&file=AllianceLog">{log_log_body_ally}</a>
	</th>
</tr><tr>
	<th align="left" colspan="2">
		<a href="LogToolPage.php?options=links&file=PlanetsAndMoonsLog">{log_log_body_p_m}</a>
	</th>
</tr><tr>
	<th align="left" colspan="2">
		<a href="LogToolPage.php?options=links&file=ResetLog">{log_log_body_reset}</a>
	</th>
</tr><tr>
	<th align="left" colspan="2">
		<a href="LogToolPage.php?options=links&file=ModerationLog">{log_log_body_mod}</a>
	</th>
</tr><tr>
	<th align="left" colspan="2">
		<a href="LogToolPage.php?options=links&file=GeneralLog">{log_log_body_gen}</a>
	</th>
</tr><tr>
	<th align="left" colspan="2">
		<a href="LogToolPage.php?options=links&file=ConfigLog">{log_log_body_config}</a>
	</th>
</tr>
	{display}
</table>
</form>
</body>