<script type="text/javascript" src="scripts/flotten.js"></script>
<script type="text/javascript">
function getStorageFaktor() {
	return 1
}
</script>
<form action="game.php?page=fleet2" method="post" onsubmit='this.submit.disabled = true;'>
    <input type="hidden" name="speedallsmin"   	value="{speedallsmin}">
    <input type="hidden" name="usedfleet"      	value="{fleetarray}">
    <input type="hidden" name="thisgalaxy"     	value="{galaxy}">
    <input type="hidden" name="thissystem"     	value="{system}">
    <input type="hidden" name="thisplanet"     	value="{planet}">
    <input type="hidden" name="thisplanettype" 	value="{planet_type}">
    <input type="hidden" name="fleetroom" 		value="{fleetroom}">
    <input type="hidden" name="target_mission" 	value="{target_mission}">
    <input type="hidden" name="speedfactor" 	value="{speedfactor}">
    {inputs}
    <br>
    <div id="content">
    	<table width="519" border="0" cellpadding="0" cellspacing="1" align="center">
        	<tr height="20">
        		<td colspan="2" class="c">{fl_send_fleet}</td>
        	</tr>
            <tr height="20">
            	<th width="50%">{fl_destiny}</th>
            	<th>
                    <input name="galaxy" size="3" maxlength="2" onChange="shortInfo()" onKeyUp="shortInfo()" value="{galaxy_post}">
                    <input name="system" size="3" maxlength="3" onChange="shortInfo()" onKeyUp="shortInfo()" value="{system_post}">
                    <input name="planet" size="3" maxlength="2" onChange="shortInfo()" onKeyUp="shortInfo()" value="{planet_post}">
                    <select name="planettype" onChange="shortInfo()" onKeyUp="shortInfo()">
                    {options_planettype}
                    </select>
                    <input name="fleet_group" type="hidden" onChange="shortInfo()" onKeyUp="shortInfo()" value="0">
                    <input name="acs_target_mr" type="hidden" onChange="shortInfo()" onKeyUp="shortInfo()" value="0:0:0">
            	</th>
            </tr>
            <tr height="20">
            	<th>{fl_fleet_speed}</th>
            	<th>
                <select name="speed" onChange="shortInfo()" onKeyUp="shortInfo()">
                    {options}
                </select> %
                </th>
            </tr>
            <tr height="20">
            	<th>{fl_distance}</th>
            	<th><div id="distance">-</div></th>
            </tr>
            <tr height="20">
            	<th>{fl_flying_time}</th>
            	<th><div id="duration">-</div></th>
            </tr>
            <tr height="20">
                <th>{fl_fuel_consumption}</th>
                <th><div id="consumption">-</div></th>
            </tr>
            <tr height="20">
                <th>{fl_max_speed}</th>
                <th><div id="maxspeed">-</div></th>
            </tr>
            <tr height="20">
                <th>{fl_cargo_capacity}</th>
                <th><div id="storage">-</div></th>
            </tr>
            <tr height="20">
                <td colspan="2" class="c">{fl_shortcut} <a href="game.php?page=shortcuts">{fl_shortcut_add_edit}</a></td>
            </tr>
            {shortcut}
            <tr height="20">
            	<td colspan="2" class="c">{fl_my_planets}</td>
            </tr>
            {colonylist}
            </tr>
            <tr height="20">
                <td colspan="2" class="c">{fl_acs_title}</td>
            </tr>
            {asc}
            <tr height="20">
            	<th colspan="2"><input type="submit" name="submit" value="{fl_continue}"></th>
            </tr>
        </table>
    </div>
</form>
<script>javascript:shortInfo();</script>