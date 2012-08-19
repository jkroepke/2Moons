{block name="title" prepend}{$LNG.lm_overview}{/block}
{block name="script" append}
<script type="text/javascript">
buildEndTime	= {$buildtime};
</script>
{/block}
{block name="content"}
<table class="table519">
	<tr>
		<th colspan="3"><a href="#" onclick="return Dialog.PlanetAction();" title="{$LNG.ov_planetmenu}">{$LNG.ov_planet} "<span class="planetname">{$planetname}</span>"</a> ({$username})</th>
	</tr>
	{if $messages}
	<tr>
		<td colspan="3"><a href="?page=messages">{$messages}</a></td>
	</tr>
	{/if}
	<tr>
		<td>{$LNG.ov_server_time}</td>
		<td colspan="2" class="servertime">{$servertime}</td>
	</tr>
	{if $is_news}
	<tr>
		<td>{$LNG.ov_news}</td><td colspan="2">{$news}</td>
	</tr>
	{/if}
	<tr>
		<td style="white-space: nowrap;">{$LNG.ov_admins_online}</td>
		<td colspan="2">{foreach $AdminsOnline as $ID => $Name}{if !$Name@first}&nbsp;&bull;&nbsp;{/if}<a href="#" onclick="return Dialog.PM({$ID})">{$Name}</a>{foreachelse}{$LNG.ov_no_admins_online}{/foreach}</td>
	</tr>
	{if !empty($chatOnline)}
	<tr>
		<td style="white-space: nowrap;">{$LNG.ov_chat_online}</td>
		<td colspan="2">{foreach $chatOnline as $Name}{if !$Name@first},&nbsp;{/if}<a href="?page=chat">{$Name}</a>{/foreach}</td>
	</tr>
	{/if}
	{if $Teamspeak}
	<tr>
		<td>{$LNG.ov_teamspeak}</td><td colspan="3">{$Teamspeak}</td>
	</tr>
	{/if}
	<tr>
		<th colspan="3">{$LNG.ov_events}</th>
	</tr>
	{foreach $fleets as $index => $fleet}
	<tr>
		<td id="fleettime_{$index}" class="fleets" data-fleet-end-time="{$fleet.returntime}" data-fleet-time="{$fleet.resttime}">-</td>
		<td colspan="2">{$fleet.text}</td>
	</tr>
	{/foreach}
	<tr>
		<td>{if $Moon}<a href="game.php?page=overview&amp;cp={$Moon.id}&amp;re=0" title="{$Moon.name}"><img src="{$dpath}planeten/mond.jpg" height="50" width="50" alt="{$Moon.name} ({$LNG.fcm_moon})"></a><br>{$Moon.name} ({$LNG.fcm_moon}){else}&nbsp;{/if}</td>
		<td><img src="{$dpath}planeten/{$planetimage}.jpg" height="200" width="200" alt="{$planetname}"><br>{$build}</td>
		<td>
		{if $AllPlanets}
		<table>
			{foreach $AllPlanets as $PlanetRow}
			{if ($PlanetRow@iteration % $themeSettings.PLANET_ROWS_ON_OVERVIEW) === 1}<tr style="height:20px;">{/if}
			<td class="transparent">{$PlanetRow.name}<br><a href="game.php?page=overview&amp;cp={$PlanetRow.id}" title="{$PlanetRow.name}"><img src="{$dpath}planeten/small/s_{$PlanetRow.image}.jpg" alt="{$PlanetRow.name}"></a><br>{$PlanetRow.build}</td>
			{if $PlanetRow@last && $PlanetRow@total > 1 && ($PlanetRow@iteration % $themeSettings.PLANET_ROWS_ON_OVERVIEW) !== 0}
			{$to = $themeSettings.PLANET_ROWS_ON_OVERVIEW - ($PlanetRow@iteration % $themeSettings.PLANET_ROWS_ON_OVERVIEW)}
			{for $foo=1 to $to}
			<td class="transparent">&nbsp;</td>
			{/for}
			{/if}
			{if ($PlanetRow@iteration % $themeSettings.PLANET_ROWS_ON_OVERVIEW) === 0}</tr>{/if}
			{/foreach}
		</table>
		{else}&nbsp;{/if}
		</td>
	</tr>
	<tr>
		<td>{$LNG.ov_diameter}</td>
		<td colspan="2">{$planet_diameter} {$LNG.ov_distance_unit} (<a title="{$LNG.ov_developed_fields}">{$planet_field_current}</a> / <a title="{$LNG.ov_max_developed_fields}">{$planet_field_max}</a> {$LNG.ov_fields})</td>
	</tr>
	<tr>
		<td>{$LNG.ov_temperature}</td>
		<td colspan="2">{$LNG.ov_aprox} {$planet_temp_min}{$LNG.ov_temp_unit} {$LNG.ov_to} {$planet_temp_max}{$LNG.ov_temp_unit}</td>
	</tr>
	<tr>
		<td>{$LNG.ov_position}</td>
		<td colspan="2"><a href="game.php?page=galaxy&amp;galaxy={$galaxy}&amp;system={$system}">[{$galaxy}:{$system}:{$planet}]</a></td>
	</tr>
	<tr>
		<td>{$LNG.ov_points}</td>
		<td colspan="2">{$rankInfo}</td>
	</tr>
	{if $ref_active}
	<tr>
		<th colspan="3">{$LNG.ov_reflink}</th>
	</tr>
	<tr>
		<td colspan="3"><input type="text" value="{$path}index.php?ref={$userid}" readonly="readonly" style="width:450px;"></td>
	</tr>
	{foreach $RefLinks as $RefID => $RefLink}
	<tr>
		<td colspan="2"><a href="#" onclick="return Dialog.Playercard({$RefID}, '{$RefLink.username}');">{$RefLink.username}</a></td>
		<td>{{$RefLink.points|number}} / {$ref_minpoints|number}</td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="3">{$LNG.ov_noreflink}</td>
	</tr>
	{/foreach}
	{/if}
</table>
{/block}