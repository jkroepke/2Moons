{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
    <table class="table519">
        <tr>
        	<th colspan="3"><a href="#" onclick="$('#dialog').dialog('open');return false;" title="{lang}ov_planetmenu{/lang}">{lang}ov_planet{/lang} "<span class="planetname">{$planetname}</span>"</a> ({$username})</th>
        </tr>
        {if $messages}
		<tr>
			<td colspan="3"><a href="?page=messages">{$messages}</a></td>
		</tr>
		{/if}
        <tr>
        	<td>{lang}ov_server_time{/lang}</td>
        	<td colspan="2" id="servertime">{tz_date($smarty.const.TIMESTAMP)}</td>
        </tr>
		{if $is_news}
		<tr>
			<td>{lang}ov_news{/lang}</td><td colspan="2">{$news}</td>
		</tr>
		{/if}
        <tr>
        	<td style="white-space: nowrap;">{lang}ov_admins_online{/lang}</td>
        	<td colspan="2">{foreach $AdminsOnline as $ID => $Name}{if !$Name@first}&nbsp;&bull;&nbsp;{/if}<a href="#" onclick="return Dialog.PM({$ID})">{$Name}</a>{foreachelse}{lang}ov_no_admins_online{/lang}{/foreach}</td>
        </tr>		
		{if $Teamspeak}
		<tr>
			<td>{lang}ov_teamspeak{/lang}</td><td colspan="3">{$Teamspeak}</td>
		</tr>
		{/if}
        <tr>
        	<th colspan="3">{lang}ov_events{/lang}</th>
        </tr>
		<tr id="fleets" style="display:none;">
			<td colspan="3"></td>
		</tr>
        <tr>
        	<td>{if $Moon}<a href="game.php?page=overview&amp;cp={$Moon.id}&amp;re=0" title="{$Moon.name}"><img src="{$dpath}planeten/mond.jpg" height="50" width="50" alt="{$Moon.name} ({lang}fcm_moon{/lang})"></a><br>{$Moon.name} ({$fcm_moon}){else}&nbsp;{/if}</td>
        	<td><img src="{$dpath}planeten/{$planetimage}.jpg" height="200" width="200" alt="{$planetname}"><br>{$build}</td>
        	<td>
            {if $AllPlanets}
			<table>
				{foreach name=PlanetList item=PlanetRow from=$AllPlanets}
				{if ($smarty.foreach.PlanetList.iteration % $smarty.const.PLANET_ROWS_ON_OVERVIEW) === 1}<tr style="height:20px;">{/if}			
				<td class="transparent">{$PlanetRow.name}<br><a href="game.php?page=overview&amp;cp={$PlanetRow.id}&amp;re=0" title="{$PlanetRow.name}"><img src="{$dpath}planeten/small/s_{$PlanetRow.image}.jpg" alt="{$PlanetRow.name}"></a><br>{$PlanetRow.build}</td>
				{if $smarty.foreach.PlanetList.last && ($smarty.foreach.PlanetList.iteration % $smarty.const.PLANET_ROWS_ON_OVERVIEW) === 1 && $smarty.foreach.PlanetList.total != 1}<td class="transparent">&nbsp;</td>{/if}
				{if ($smarty.foreach.PlanetList.iteration % $smarty.const.PLANET_ROWS_ON_OVERVIEW) === 0}</tr>{/if}
				{/foreach}
			</table>
			{else}&nbsp;{/if}
            </td>
        </tr>
        <tr>
            <td>{lang}ov_diameter{/lang}</td>
            <td colspan="2">{$planet_diameter} {lang}ov_distance_unit{/lang} (<a title="{lang}ov_developed_fields{/lang}">{$planet_field_current}</a> / <a title="{lang}ov_max_developed_fields{/lang}">{$planet_field_max}</a> {lang}ov_fields{/lang})</td>
        </tr>
        <tr>
            <td>{lang}ov_temperature{/lang}</td>
            <td colspan="2">{lang}ov_aprox{/lang} {$planet_temp_min}{lang}ov_temp_unit{/lang} {lang}ov_to{/lang} {$planet_temp_max}{lang}ov_temp_unit{/lang}</td>
        </tr>
        <tr>
            <td>{lang}ov_position{/lang}</td>
            <td colspan="2"><a href="game.php?page=galaxy&amp;mode=0&amp;galaxy={$galaxy}&amp;system={$system}">[{$galaxy}:{$system}:{$planet}]</a></td>
        </tr>
        <tr>
            <td>{lang}ov_points{/lang}</td>
            <td colspan="2">{$user_rank}</td>
        </tr>
		{if $ref_active}
		<tr>
			<th colspan="3">{lang}ov_reflink{/lang}</th>
		</tr>
		<tr>
			<td colspan="3"><input type="text" value="{$path}index.php?ref={$userid}" readonly="readonly" style="width:450px;"></td>
		</tr>
		{/if}
		{if extension_loaded('gd') && !CheckModule(37)}
		<tr>
			<th colspan="3">{lang}ov_userbanner{/lang}</th>
		</tr>
		<tr>
			<td colspan="3"><img src="userpic.php?id={$userid}" alt="" height="80" width="450"><br><br><table><tr><td class="transparent">HTML:</td><td class="transparent"><input type="text" value='<a href="{$path}{if $ref_active}index.php?ref={$userid}{/if}"><img src="{$path}userpic.php?id={$userid}"></a>' readonly="readonly" style="width:450px;"></td></tr><tr><td class="transparent">BBCode:</td><td class="transparent"><input type="text" value="[url={$path}{if $ref_active}index.php?ref={$userid}{/if}][img]{$path}userpic.php?id={$userid}[/img][/url]" readonly="readonly" style="width:450px;"></td></tr></table></td>
		</tr>
		{/if}
   </table>

</div>
<div id="dialog" title="{lang}ov_planetmenu{/lang}" style="display:none;">
<form action="game.php" method="POST" onsubmit="return false">
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">{lang}ov_planet_rename{/lang}</a></li>
			<li><a href="#tabs-2">{lang}ov_delete_planet{/lang}</a></li>
		</ul>
		<div id="tabs-1">
			<label for="newname">{lang}ov_rename_label{/lang}: </label><input class="left" type="text" name="newname" id="newname" size="25" maxlength="20" autocomplete="off">
		</div>
		<div id="tabs-2"><h3 style="margin:0">{lang}ov_security_request{/lang}</h3>{$ov_security_confirm}<br>
			<label for="password">{lang}ov_password{/lang}: </label><input class="left" type="password" name="password" id="password" size="25" maxlength="20" autocomplete="off">
		</div>
	</div>
</form>
</div>
<script type="text/javascript">
buildtime	= {$buildtime} * 1000;
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}