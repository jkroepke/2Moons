{include file="overall_header.tpl"}
<form method="post" action="">
	<table width="80%" border="0" cellpadding="1">
    <tr>
      <th colspan="2">{$cs_title}</th>
    </tr>
	<tr>
      <td>{$cs_point_per_resources_used} ({$cs_resources})</td>
      <td><input type="text" name="stat_settings" value="{$stat_settings}"></td>
    </tr>
    <tr>
      <td>{$cs_points_to_zero}</td>
      <td>{html_options name=stat options=$Selector selected=$stat}</td>
    </tr>
    <tr>
      <td>{$cs_access_lvl}</td>
      <td><input type="text" name="stat_level" value="{$stat_level}"></td>
    </tr>
	<tr>
      <td colspan="2"><a href="admin.php?page=cronjob">{$cs_time_between_updates}</a></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="{$cs_save_changes}"></td>
    </tr>
  </table>
</form>
{include file="overall_footer.tpl"}