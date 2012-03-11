{include file="overall_header.tpl"}
<form action="" method="post" onsubmit="return confirm('{$re_reset_universe_confirmation}');">
<table width="40%">
<tr><th colspan="2">{$re_player_and_planets}</th></tr>
<tr><td style="text-align:left">{$re_reset_player}</td><td style="text-align:right"><input type="checkbox" name="players"></td></tr>
<tr><td style="text-align:left">{$re_reset_planets}</td><td style="text-align:right"><input type="checkbox" name="planets"></td></tr>
<tr><td style="text-align:left">{$re_reset_moons}</td><td style="text-align:right"><input type="checkbox" name="moons"></td></tr>

<tr><th colspan="2">{$re_defenses_and_ships}</th></tr>
<tr><td style="text-align:left">{$re_defenses}</td><td style="text-align:right"><input type="checkbox" name="defenses"></td></tr>
<tr><td style="text-align:left">{$re_ships}</td><td style="text-align:right"><input type="checkbox" name="ships"></td></tr>
<tr><td style="text-align:left">{$re_reset_hangar}</td><td style="text-align:right"><input type="checkbox" name="h_d"></td></tr>

<tr><th colspan="2">{$re_buldings}</th></tr>
<tr><td style="text-align:left">{$re_buildings_pl}</td><td style="text-align:right"><input type="checkbox" name="edif_p"></td></tr>
<tr><td style="text-align:left">{$re_buildings_lu}</td><td style="text-align:right"><input type="checkbox" name="edif_l"></td></tr>
<tr><td style="text-align:left">{$re_reset_buldings}</td><td style="text-align:right"><input type="checkbox" name="edif"></td></tr>

<tr><th colspan="2">{$re_inve_ofis}</th></tr>
<tr><td style="text-align:left">{$re_ofici}</td><td style="text-align:right"><input type="checkbox" name="ofis"></td></tr>
<tr><td style="text-align:left">{$re_investigations}</td><td style="text-align:right"><input type="checkbox" name="inves"></td></tr>
<tr><td style="text-align:left">{$re_reset_invest}</td><td style="text-align:right"><input type="checkbox" name="inves_c"></td></tr>

<tr><th colspan="2">{$re_resources}</th></tr>
<tr><td style="text-align:left">{$re_resources_dark}</td><td style="text-align:right"><input type="checkbox" name="dark"></td></tr>
<tr><td style="text-align:left">{$re_resources_met_cry}</td><td style="text-align:right"><input type="checkbox" name="resources"></td></tr>

<tr><th colspan="2">{$re_general}</th></tr>
<tr><td style="text-align:left">{$re_reset_notes}</td><td style="text-align:right"><input type="checkbox" name="notes"></td></tr>
<tr><td style="text-align:left">{$re_reset_rw}</td><td style="text-align:right"><input type="checkbox" name="rw"></td></tr>
<tr><td style="text-align:left">{$re_reset_buddies}</td><td style="text-align:right"><input type="checkbox" name="friends"></td></tr>
<tr><td style="text-align:left">{$re_reset_allys}</td><td style="text-align:right"><input type="checkbox" name="alliances"></td></tr>
<tr><td style="text-align:left">{$re_reset_fleets}</td><td style="text-align:right"><input type="checkbox" name="fleets"></td></tr>
<tr><td style="text-align:left">{$re_reset_errors}</td><td style="text-align:right"><input type="checkbox" name="errors"></td></tr>
<tr><td style="text-align:left">{$re_reset_banned}</td><td style="text-align:right"><input type="checkbox" name="banneds"></td></tr>
<tr><td style="text-align:left">{$re_reset_messages}</td><td style="text-align:right"><input type="checkbox" name="messages"></td></tr>
<tr><td style="text-align:left">{$re_reset_statpoints}</td><td style="text-align:right"><input type="checkbox" name="statpoints"></td></tr>

<tr><th style="text-align:left;">{$re_reset_all}</th><th style="text-align:right;margin-right:2px;padding-right:5px;width:10px;"><input type="checkbox" name="resetall" onclick="$('input').attr('checked', 'checked');"></th></tr>


<tr><td colspan="2" height="60"><input type="submit" value="{$button_submit}"></td></tr>
</table>
{include file="overall_footer.tpl"}