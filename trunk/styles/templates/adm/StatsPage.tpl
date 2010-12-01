{include file="adm/overall_header.tpl"}
<form method="post" action="">
	<table width="80%" border="0" cellpadding="1">
    <tr>
      <td colspan="2" class="c">{$cs_title}</td>
    </tr>
	<tr>
      <th>{$cs_point_per_resources_used} ({$cs_resources})</th>
      <th><input type="text" name="stat_settings" value="{$stat_settings}"></th>
    </tr>
	<tr>
      <th>{$cs_time_between_updates} ({$cs_minutes})</th>
      <th><input type="text" name="stat_update_time" value="{$stat_update_time}"></th>
    </tr>
    <tr>
      <th>{$cs_points_to_zero}</th>
      <th>{html_options name=stat options=$Selector selected=$stat}</th>
    </tr>
    <tr>
      <th>{$cs_access_lvl}</th>
      <th><input type="text" name="stat_level" value="{$stat_level}"></th>
    </tr>
	<tr>
      <th colspan="2">{$cs_timeact_1} {$timeact}</th>
    </tr>
    <tr>
      <th colspan="2"><input type="submit" value="{$cs_save_changes}"></th>
    </tr>
  </table>
</form>
{include file="adm/overall_footer.tpl"}