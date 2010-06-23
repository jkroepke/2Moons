<form action="" method="post">
<table width="40%">
{good}
<tr><td colspan="2" class="c">{re_defenses_and_ships}</td></tr>
<tr><th class="b">{re_defenses}</th><td><input type="checkbox" name="defenses"></td></tr>
<tr><th class="b">{re_ships}</th><td><input type="checkbox" name="ships"></td></tr>
<tr><th class="b">{re_reset_hangar}</th><td><input type="checkbox" name="h_d"></td></tr>

<tr><td colspan="2" class="c">{re_buldings}</td></tr>
<tr><th class="b">{re_buildings_pl}</th><td><input type="checkbox" name="edif_p"></td></tr>
<tr><th class="b">{re_buildings_lu}</th><td><input type="checkbox" name="edif_l"></td></tr>
<tr><th class="b">{re_reset_buldings}</th><td><input type="checkbox" name="edif"></td></tr>

<tr><td colspan="2" class="c">{re_inve_ofis}</td></tr>
<tr><th class="b">{re_ofici}</th><td><input type="checkbox" name="ofis"></td></tr>
<tr><th class="b">{re_investigations}</th><td><input type="checkbox" name="inves"></td></tr>
<tr><th class="b">{re_reset_invest}</th><td><input type="checkbox" name="inves_c"></td></tr>

<tr><td colspan="2" class="c">{re_resources}</td></tr>
<tr><th class="b">{re_resources_dark}</th><td><input type="checkbox" name="dark"></td></tr>
<tr><th class="b">{re_resources_met_cry}</th><td><input type="checkbox" name="resources"></td></tr>

<tr><td colspan="2" class="c">{re_general}</td></tr>
<tr><th class="b">{re_reset_moons}</th><td><input type="checkbox" name="moons"></td></tr>
<tr><th class="b">{re_reset_notes}</th><td><input type="checkbox" name="notes"></td></tr>
<tr><th class="b">{re_reset_rw}</th><td><input type="checkbox" name="rw"></td></tr>
<tr><th class="b">{re_reset_buddies}</th><td><input type="checkbox" name="friends"></td></tr>
<tr><th class="b">{re_reset_allys}</th><td><input type="checkbox" name="alliances"></td></tr>
<tr><th class="b">{re_reset_fleets}</th><td><input type="checkbox" name="fleets"></td></tr>
<tr><th class="b">{re_reset_errors}</th><td><input type="checkbox" name="errors"></td></tr>
<tr><th class="b">{re_reset_banned}</th><td><input type="checkbox" name="banneds"></td></tr>
<tr><th class="b">{re_reset_messages}</th><td><input type="checkbox" name="messages"></td></tr>
<tr><th class="b">{re_reset_statpoints}</th><td><input type="checkbox" name="statpoints"></td></tr>

<tr><td class="c" style="text-align:left;color:#FF0000;">{re_reset_all}</td><td><input type="checkbox" name="resetall"></td></tr>


<tr><td colspan="2" height="60"><input type="button" value="{button_submit}" onclick="$('.containerPlus').mb_open();$('.containerPlus').mb_centerOnWindow(true);"></td></tr>
</table>
<div id="demoContainer" class="containerPlus draggable resizable { buttons:'c', skin:'black', width:'580', height:'50',dock:'dock',closed:'true'}" style="position:absolute;top:250px;left:400px; height:50%">
    <div class="no"><div class="ne"><div class="n">{adm_password}</div></div>
      <div class="o"><div class="e"><div class="c">
        <div class="mbcontainercontent"><center>{adm_password_info}<br>
		{adm_password}: <input type="password" name="password"><br><br>
		<input type="submit" value="{button_submit}" onClick="return confirm('{re_reset_universe_confirmation}');"/></center>
        </div>
      </div></div></div>
      <div >
        <div class="so"><div class="se"><div class="s"> </div></div></div>
      </div>
    </div>
  </div>
</form>

<script type="text/javascript">
	$(function(){
      $(".containerPlus").buildContainers({
        containment: 'document',
        elementsPath: '../styles/css/mbContainer/',
        onClose:function(o){void(0);},
        effectDuration:500,
		slideTimer:300,
        autoscroll:true,
      });
	});
</script>