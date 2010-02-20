<script>document.body.style.overflow = "auto";</script> 
<body>
<form method="post" action="">
	<br />
	<table width="80%" border="0" cellpadding="1">
    <tr>
      <td colspan="2" class="c">{cs_title}</td>
    </tr>
	<tr>
      <th>{cs_point_per_resources_used} ({cs_resources})</th>
      <th><input type="text" name="stat_settings" id="stat_settings" value="{stat_settings}" /></th>
    </tr>
	<tr>
      <th>{cs_users_per_block}</th>
      <th><input type="text" name="stat_amount" id="stat_amount" value="{stat_amount}" /></th>
    </tr>
	<tr>
      <th>{cs_fleets_on_block}</th>
      <th><select name="stat_flying" id="stat_flying">
          <option value="1" {sel_sf1}>{cs_yes}</option>
          <option value="0" {sel_sf0}>{cs_no}</option>
      </select></th>
    </tr>
	<tr>
      <th>{cs_time_between_updates} ({cs_minutes})</th>
      <th><input type="text" name="stat_update_time" id="stat_update_time" value="{stat_update_time}" /></th>
    </tr>
    <tr>
      <th>{cs_points_to_zero}</th>
      <th><select name="stat" id="stat">
          <option value="0" {sel_sta1}>{cs_yes}</option>
          <option value="1" {sel_sta0}>{cs_no}</option>
      </select></th>
    </tr>
    <tr>
      <th>{cs_access_lvl}</th>
      <th><input type="text" name="stat_level" id="stat_level" value="{stat_level}" /></th>
    </tr>
	<tr>
      <th colspan="2">{cs_timeact_1} {timeact}</th>
    </tr>
	
    <tr>
      <th colspan="2"><input type="submit" name="save" value="{cs_save_changes}" /></th>
    </tr>
  </table>
</form>
</body>