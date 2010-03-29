<script>document.body.style.overflow = "auto";</script>
<style>
th{text-align:left;}
.grand{font-size:14px;}
</style> 
<body>
<form action="" method="post">
<table width="40%">
{good}
<tr><td colspan="2" class="c">{re_defenses_and_ships}</td></tr>
<tr><th>{re_defenses}</th><td><input type="checkbox" name="defenses" /></td></tr>
<tr><th>{re_ships}</th><td><input type="checkbox" name="ships" /></td></tr>
<tr><th>{re_reset_hangar}</th><td><input type="checkbox" name="h_d" /></td></tr>

<tr><td colspan="2" class="c">{re_buldings}</td></tr>
<tr><th>{re_buildings_pl}</th><td><input type="checkbox" name="edif_p" /></td></tr>
<tr><th>{re_buildings_lu}</th><td><input type="checkbox" name="edif_l" /></td></tr>
<tr><th>{re_reset_buldings}</th><td><input type="checkbox" name="edif" /></td></tr>

<tr><td colspan="2" class="c">{re_inve_ofis}</td></tr>
<tr><th>{re_ofici}</th><td><input type="checkbox" name="ofis" /></td></tr>
<tr><th>{re_investigations}</th><td><input type="checkbox" name="inves" /></td></tr>
<tr><th>{re_reset_invest}</th><td><input type="checkbox" name="inves_c" /></td></tr>

<tr><td colspan="2" class="c">{re_resources}</td></tr>
<tr><th>{re_resources_dark}</th><td><input type="checkbox" name="dark" /></td></tr>
<tr><th>{re_resources_met_cry}</th><td><input type="checkbox" name="resources" /></td></tr>

<tr><td colspan="2" class="c">{re_general}</td></tr>
<tr><th>{re_reset_moons}</th><td><input type="checkbox" name="moons" /></td></tr>
<tr><th>{re_reset_notes}</th><td><input type="checkbox" name="notes" /></td></tr>
<tr><th>{re_reset_rw}</th><td><input type="checkbox" name="rw" /></td></tr>
<tr><th>{re_reset_buddies}</th><td><input type="checkbox" name="friends" /></td></tr>
<tr><th>{re_reset_allys}</th><td><input type="checkbox" name="alliances" /></td></tr>
<tr><th>{re_reset_fleets}</th><td><input type="checkbox" name="fleets" /></td></tr>
<tr><th>{re_reset_errors}</th><td><input type="checkbox" name="errors" /></td></tr>
<tr><th>{re_reset_banned}</th><td><input type="checkbox" name="banneds" /></td></tr>
<tr><th>{re_reset_messages}</th><td><input type="checkbox" name="messages" /></td></tr>
<tr><th>{re_reset_statpoints}</th><td><input type="checkbox" name="statpoints" /></td></tr>

<tr><td class="c" style="text-align:left;color:#FF0000;">{re_reset_all}</td><td><input type="checkbox" name="resetall" /></td></tr>


<tr><td colspan="2" height="60"><input type="submit" value="{button_submit}" onClick="return confirm('{re_reset_universe_confirmation}');"/></td></tr>
</table>
</form>
</body>