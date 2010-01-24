<br>
<div id="content" style="top: 91px; height: 504px;">
    <table width="519" align="center">
        <tr>
        	<td class="c" colspan="4"><a href="game.php?page=overview&amp;mode=renameplanet" title="{Planet_menu}">{ov_planet} "{planet_name}"</a> ({user_username})</td>
        </tr>
            {Have_new_message}
        <tr>
        	<th>{ov_server_time}</th>
        	<th colspan="3">{date_time}</th>
        </tr>
		{NewsFrame}
        <tr>
        	<th>Admins(Online):</th>
        	<th colspan="3">{OnlineAdmins}</th>
        </tr>		
		{ov_ts}
        <tr>
        	<td colspan="4" class="c">{ov_events}</td>
        </tr>
        	{fleet_list}
        <tr>
        	<th>{moon_img}<br>{moon}</th>
        	<th colspan="2"><img src="{dpath}planeten/{planet_image}.jpg" height="200" width="200" alt="{planet_name}"><br>{building}</th>
        	<th class="s">
            {anothers_planets} 
            </th>
        </tr>
        <tr>
            <th>{ov_diameter}</th>
            <th colspan="3">{planet_diameter} {ov_distance_unit} (<a title="{ov_developed_fields}">{planet_field_current}</a> / <a title="{max_eveloped_fields}">{planet_field_max}</a> {ov_fields})</th>
        </tr>
        <tr>
            <th>{ov_temperature}</th>
            <th colspan="3">{ov_aprox} {planet_temp_min}{ov_temp_unit} {ov_to} {planet_temp_max}{ov_temp_unit}</th>
        </tr>
        <tr>
            <th>{ov_position}</th>
            <th colspan="3"><a href="game.php?page=galaxy&amp;mode=0&amp;galaxy={galaxy_galaxy}&amp;system={galaxy_system}">[{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}]</a></th>
        </tr>
        <tr>
            <th>{ov_points}</th>
            <th colspan="3">{user_rank}</th>
        </tr>
		{ov_banner}
    </table>
</div>