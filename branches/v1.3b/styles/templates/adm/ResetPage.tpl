{include file="adm/overall_header.tpl"}
<form action="" method="post">
<table width="40%">
<tr><td colspan="2" class="c">{$re_defenses_and_ships}</td></tr>
<tr><th style="text-align:left">{$re_defenses}</th><th style="text-align:right"><input type="checkbox" name="defenses"></th></tr>
<tr><th style="text-align:left">{$re_ships}</th><th style="text-align:right"><input type="checkbox" name="ships"></th></tr>
<tr><th style="text-align:left">{$re_reset_hangar}</th><th style="text-align:right"><input type="checkbox" name="h_d"></th></tr>

<tr><td colspan="2" class="c">{$re_buldings}</td></tr>
<tr><th style="text-align:left">{$re_buildings_pl}</th><th style="text-align:right"><input type="checkbox" name="edif_p"></th></tr>
<tr><th style="text-align:left">{$re_buildings_lu}</th><th style="text-align:right"><input type="checkbox" name="edif_l"></th></tr>
<tr><th style="text-align:left">{$re_reset_buldings}</th><th style="text-align:right"><input type="checkbox" name="edif"></th></tr>

<tr><td colspan="2" class="c">{$re_inve_ofis}</td></tr>
<tr><th style="text-align:left">{$re_ofici}</th><th style="text-align:right"><input type="checkbox" name="ofis"></th></tr>
<tr><th style="text-align:left">{$re_investigations}</th><th style="text-align:right"><input type="checkbox" name="inves"></th></tr>
<tr><th style="text-align:left">{$re_reset_invest}</th><th style="text-align:right"><input type="checkbox" name="inves_c"></th></tr>

<tr><td colspan="2" class="c">{$re_resources}</td></tr>
<tr><th style="text-align:left">{$re_resources_dark}</th><th style="text-align:right"><input type="checkbox" name="dark"></th></tr>
<tr><th style="text-align:left">{$re_resources_met_cry}</th><th style="text-align:right"><input type="checkbox" name="resources"></th></tr>

<tr><td colspan="2" class="c">{$re_general}</td></tr>
<tr><th style="text-align:left">{$re_reset_moons}</th><th style="text-align:right"><input type="checkbox" name="moons"></th></tr>
<tr><th style="text-align:left">{$re_reset_notes}</th><th style="text-align:right"><input type="checkbox" name="notes"></th></tr>
<tr><th style="text-align:left">{$re_reset_rw}</th><th style="text-align:right"><input type="checkbox" name="rw"></th></tr>
<tr><th style="text-align:left">{$re_reset_buddies}</th><th style="text-align:right"><input type="checkbox" name="friends"></th></tr>
<tr><th style="text-align:left">{$re_reset_allys}</th><th style="text-align:right"><input type="checkbox" name="alliances"></th></tr>
<tr><th style="text-align:left">{$re_reset_fleets}</th><th style="text-align:right"><input type="checkbox" name="fleets"></th></tr>
<tr><th style="text-align:left">{$re_reset_errors}</th><th style="text-align:right"><input type="checkbox" name="errors"></th></tr>
<tr><th style="text-align:left">{$re_reset_banned}</th><th style="text-align:right"><input type="checkbox" name="banneds"></th></tr>
<tr><th style="text-align:left">{$re_reset_messages}</th><th style="text-align:right"><input type="checkbox" name="messages"></th></tr>
<tr><th style="text-align:left">{$re_reset_statpoints}</th><th style="text-align:right"><input type="checkbox" name="statpoints"></th></tr>

<tr><td class="c" style="text-align:left;color:#FF0000;">{$re_reset_all}</td><td class="c" style="text-align:right;margin-right:2px;padding-right:5px;width:10px;"><input type="checkbox" name="resetall" onclick="$('input').attr('checked', 'checked');"></td></tr>


<tr><th colspan="2" height="60"><input type="submit" value="{$button_submit}"></th></tr>
</table>
{include file="adm/overall_footer.tpl"}