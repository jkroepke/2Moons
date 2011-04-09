{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table class="table519">
        <tr>
        	<th colspan="3"><a href="#" onclick="$('#dialog').dialog('open');return false;" title="{$ov_planetmenu}">{$ov_planet} "<span class="planetname">{$planetname}</span>"</a> ({$username})</th>
        </tr>
        {if $messages}
		<tr>
			<td colspan="3"><a href="?page=messages">{$messages}</a></td>
		</tr>
		{/if}
        <tr>
        	<td>{$ov_server_time}</td>
        	<td colspan="2" id="servertime"></td>
        </tr>
		{if $is_news}
		<tr>
			<td>{$ov_news}</td><td colspan="2">{$news}</td>
		</tr>
		{/if}
        <tr>
        	<td style="white-space: nowrap;">{$ov_admins_online}</td>
        	<td colspan="2">{foreach name=OnlineAdmins key=id item=Name from=$AdminsOnline}{if !$smarty.foreach.OnlineAdmins.first}&nbsp;&bull;&nbsp;{/if}<a href="#" onclick="return Dialog.PM({$id})">{$Name}</a>{foreachelse}{$ov_no_admins_online}{/foreach}</td>
        </tr>		
		{if $Teamspeak}
		<tr>
			<td>{$ov_teamspeak}</td><td colspan="3">{$Teamspeak}</td>
		</tr>
		{/if}
        <tr>
        	<th colspan="3">{$ov_events}</th>
        </tr>
		<tr id="fleets" style="display:none;">
			<td colspan="3"></td>
		</tr>
        <tr>
        	<td>{if $Moon}<a href="game.php?page=overview&amp;cp={$Moon.id}&amp;re=0" title="{$Moon.name}"><img src="{$dpath}planeten/mond.jpg" height="50" width="50" alt="{$Moon.name} ({$fcm_moon})"></a><br>{$Moon.name} ({$fcm_moon}){else}&nbsp;{/if}</td>
        	<td><img src="{$dpath}planeten/{$planetimage}.jpg" height="200" width="200" alt="{$planetname}"><br>{$build}</td>
        	<td>
            {if $AllPlanets}
			<table>
				{foreach name=PlanetList item=PlanetRow from=$AllPlanets}
				{if $smarty.foreach.PlanetList.iteration is odd}<tr style="height:20px;">{/if}			
				<td class="transparent">{$PlanetRow.name}<br><a href="game.php?page=overview&amp;cp={$PlanetRow.id}&amp;re=0" title="{$PlanetRow.name}"><img src="{$dpath}planeten/small/s_{$PlanetRow.image}.jpg" alt="{$PlanetRow.name}"></a><br>{$PlanetRow.build}</td>
				{if $smarty.foreach.PlanetList.last && $smarty.foreach.PlanetList.total is odd && $smarty.foreach.PlanetList.total != 1}<td class="transparent">&nbsp;</td>{/if}
				{if $smarty.foreach.PlanetList.iteration is even}</tr>{/if}
				{/foreach}
			</table>
			{else}&nbsp;{/if}
            </td>
        </tr>
        <tr>
            <td>{$ov_diameter}</td>
            <td colspan="2">{$planet_diameter} {$ov_distance_unit} (<a title="{$ov_developed_fields}">{$planet_field_current}</a> / <a title="{$ov_max_developed_fields}">{$planet_field_max}</a> {$ov_fields})</td>
        </tr>
        <tr>
            <td>{$ov_temperature}</td>
            <td colspan="2">{$ov_aprox} {$planet_temp_min}{$ov_temp_unit} {$ov_to} {$planet_temp_max}{$ov_temp_unit}</td>
        </tr>
        <tr>
            <td>{$ov_position}</td>
            <td colspan="2"><a href="game.php?page=galaxy&amp;mode=0&amp;galaxy={$galaxy}&amp;system={$system}">[{$galaxy}:{$system}:{$planet}]</a></td>
        </tr>
        <tr>
            <td>{$ov_points}</td>
            <td colspan="2">{$user_rank}</td>
        </tr>
		{if $ref_active}
		<tr>
			<th colspan="3">{$ov_reflink}</th>
		</tr>
		<tr>
			<td colspan="3"><input type="text" value="{$path}index.php?ref={$userid}" readonly="readonly" style="width:450px;"></td>
		</tr>
		{/if}
		{if extension_loaded('gd') && !CheckModule(37)}
		<tr>
			<th colspan="3">{$ov_userbanner}</th>
		</tr>
		<tr>
			<td colspan="3"><img src="userpic.php?id={$userid}" alt="" height="80" width="450"><br><br><table><tr><td class="transparent">HTML:</td><td class="transparent"><input type="text" value='<a href="{$path}{if $ref_active}index.php?ref={$userid}{/if}"><img src="{$path}userpic.php?id={$userid}"></a>' readonly="readonly" style="width:450px;"></td></tr><tr><td class="transparent">BBCode:</td><td class="transparent"><input type="text" value="[url={$path}{if $ref_active}index.php?ref={$userid}{/if}][img]{$path}userpic.php?id={$userid}[/img][/url]" readonly="readonly" style="width:450px;"></td></tr></table></td>
		</tr>
		{/if}
   </table>

</div>
<form action="game.php" method="POST" onsubmit="return false">
<div id="dialog" title="{$ov_planetmenu}" style="display:none;">
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">{$ov_planet_rename}</a></li>
			<li><a href="#tabs-2">{$ov_delete_planet}</a></li>
		</ul>
		<div id="tabs-1">
			<label for="newname">{$ov_rename_label}: </label><input class="left" type="text" name="newname" id="newname" size="25" maxlength="20" autocomplete="off">
		</div>
		<div id="tabs-2"><h3 style="margin:0">{$ov_security_request}</h3>{$ov_security_confirm}<br>
			<label for="password">{$ov_password}: </label><input class="left" type="password" name="password" id="password" size="25" maxlength="20" autocomplete="off">
		</div>
	</div>
</div>

</form>
<script type="text/javascript">
buildtime	= {$buildtime} * 1000;
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}