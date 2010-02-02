<script language="JavaScript" src="scripts/flotten.js"></script>
<script language="JavaScript" src="scripts/ocnt.js"></script>
<br />
<div id="content">
    <table width="519" border="0" cellpadding="0" cellspacing="1" align="center">
        <tr height="20">
        	<td colspan="9" class="c">
                <table border="0" width="100%">
                    <tr>
                        <td style="background-color: transparent;">{fl_fleets} {flyingfleets} / {maxfleets}</td>
                        <td style="background-color: transparent;" align="right">{currentexpeditions} / {maxexpeditions} {fl_expeditions}</td>
                    </tr>
                </table>
        	</td>
        </tr>
        <tr height="20">
            <th>{fl_number}</th>
            <th>{fl_mission}</th>
            <th>{fl_ammount}</th>
            <th>{fl_beginning}</th>
            <th>{fl_departure}</th>
            <th>{fl_destiny}</th>
            <th>{fl_objective}</th>
            <th>{fl_arrival}</th>
            <th>{fl_order}</th>
        </tr>
            {fleetpagerow}
            {message_nofreeslot}
        </table>
		{AKSTable}
        <form action="game.php?page=fleet1" method="POST">
        <table width="519" border="0" cellpadding="0" cellspacing="1" align="center">
            <tr height="20">
            	<td colspan="4" class="c">{fl_new_mission_title}</td>
            </tr>
            <tr height="20">
                <th>{fl_ship_type}</th>
                <th>{fl_ship_available}</th>
                <th>-</th>
                <th>-</th>
            </tr>
            	{body}
            </tr>
    	</table>
        	{shipdata}
            <input type="hidden" name="galaxy" value="{galaxy}" />
            <input type="hidden" name="system" value="{system}" />
            <input type="hidden" name="planet" value="{planet}" />
            <input type="hidden" name="planet_type" value="{planettype}" />
            <input type="hidden" name="mission" value="{target_mission}" />
            <input type="hidden" name="maxepedition" value="{envoimaxexpedition}" />
            <input type="hidden" name="curepedition" value="{expeditionencours}" />
            <input type="hidden" name="target_mission" value="{target_mission}" />	
        </form>
</div>