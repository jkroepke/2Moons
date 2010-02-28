{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content"><!-- style="top: 91px; height: 504px;"-->
    <table width="519" align="center">
        <tr>
        	<td class="c" colspan="4"><a href="game.php?page=overview&amp;mode=renameplanet" title="{$ov_planetmenu}">{$ov_planet} "{$planetname}"</a> ({$username})</td>
        </tr>
        {if $messages}
		<tr><th colspan="4"><a href="?page=messages">{$messages}</a></th></tr>
		{/if}
        <tr>
        	<th>{$ov_server_time}</th>
        	<th colspan="4">{$date_time}</th>
        </tr>
		{if $is_news}
		<tr><th>{$ov_news}</th><th colspan="4">{$news}</th></tr>
		{/if}
        <tr>
        	<th>{$ov_admins_online}</th>
        	<th colspan="4">
			{foreach name=OnlineAdmins key=id item=Name from=$AdminsOnline}{if !$smarty.foreach.OnlineAdmins.first}&nbsp;&bull;&nbsp;{/if}<a href="javascript:f('game.php?page=messages&amp;mode=write&amp;id={$id}','');">{$Name}</a>{foreachelse}{$ov_no_admins_online}{/foreach}</th>
        </tr>		
		{if $Teamspeak}
		<tr>
		<th>{$ov_teamspeak}</th><th colspan="3">{$Teamspeak}</th>
		</tr>
		{/if}
        <tr>
        	<td colspan="4" class="c">{$ov_events}</td>
        </tr>
        {foreach item=FleetInfoRow from=$fleets}
		<tr class="{$FleetInfoRow.fleet_status}">
			<th>
			{$FleetInfoRow.fleet_javai}
				<div id="bxx{$FleetInfoRow.fleet_order}" class="z">-</div>
			</th><th colspan="3">
				<span class="{$FleetInfoRow.fleet_status} {$FleetInfoRow.fleet_prefix}{$FleetInfoRow.fleet_style}">{$FleetInfoRow.fleet_descr}</span>
			{$FleetInfoRow.fleet_javas}
			</th>
		</tr>
		{/foreach}
        <tr>
        	<th>{if $Moon}<a href="game.php?page=overview&amp;cp={$Moon.id}&amp;re=0" title="{$Moon.name}"><img src="{$dpath}planeten/mond.jpg" height="50" width="50" alt="{$Moon.name} ({$fcm_moon})"></a><br>{$Moon.name} ({$fcm_moon}){else}&nbsp;{/if}</th>
        	<th colspan="2"><img src="{$dpath}planeten/{$planetimage}.jpg" height="200" width="200" alt="{$planetname}"><br>{$build}</th>
        	<th>
            {if $AllPlanets}
			<table class="s" border="0" align="center">
			{foreach name=PlanetList item=PlanetRow from=$AllPlanets}
			{if $smarty.foreach.PlanetList.iteration is odd}<tr style="height:20px;">{/if}			
			<th class="s">{$PlanetRow.name}<br><a href="game.php?page=overview&amp;cp={$PlanetRow.id}&amp;re=0" title="{$PlanetRow.name}"><img src="styles/skins/darkness/planeten/small/s_{$PlanetRow.image}.jpg" alt="{$PlanetRow.name}"></a><br><center>{$PlanetRow.build}</center></th>
			{if $smarty.foreach.PlanetList.last && $smarty.foreach.PlanetList.total is odd && $smarty.foreach.PlanetList.total != 1}<th class="s">&nbsp;</th>{/if}
			{if $smarty.foreach.PlanetList.iteration is even}</tr>{/if}
			{/foreach}
			</table>
			{else}&nbsp;{/if}
            </th>
        </tr>
        <tr>
            <th>{$ov_diameter}</th>
            <th colspan="3">{$planet_diameter} {$ov_distance_unit} (<a title="{$ov_developed_fields}">{$planet_field_current}</a> / <a title="{$ov_max_developed_fields}">{$planet_field_max}</a> {$ov_fields})</th>
        </tr>
        <tr>
            <th>{$ov_temperature}</th>
            <th colspan="3">{$ov_aprox} {$planet_temp_min}{$ov_temp_unit} {$ov_to} {$planet_temp_max}{$ov_temp_unit}</th>
        </tr>
        <tr>
            <th>{$ov_position}</th>
            <th colspan="3"><a href="game.php?page=galaxy&amp;mode=0&amp;galaxy={$galaxy}&amp;system={$system}">[{$galaxy}:{$system}:{$planet}]</a></th>
        </tr>
        <tr>
            <th>{$ov_points}</th>
            <th colspan="3">{$user_rank}</th>
        </tr>
		<tr>
			<td class="c" colspan="4">{$ov_userbanner}</td>
		</tr>
		<tr>
			<th colspan="4"><img src="userpic.php?id={$userid}" alt="" height="80" width="450"><br><br><table><tr><td>HTML:</td><td><input type="text" value='<a href="http://{$smarty.server.SERVER_NAME}/"><img src="http://{$smarty.server.SERVER_NAME}/userpic.php?id={$userid}"></a>' readonly style="width:450px;"></td></tr><tr><td>BBCode:</td><td><input type="text" value="[url='http://{$smarty.server.SERVER_NAME}/'][img]http://{$smarty.server.SERVER_NAME}/userpic.php?id={$userid}[/img][/url]" readonly style="width:450px;"></td></tr></table></th></tr>
    </table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}