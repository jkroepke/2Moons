{include file="overall_header.tpl"}
<table width="80%">
<tr>
	<th>{$LNG.cronjob_id}</th>
	<th>{$LNG.cronjob_name}</th>
	<th>{$LNG.cronjob_min}</th>
	<th>{$LNG.cronjob_hours}</th>
	<th>{$LNG.cronjob_dom}</th>
	<th>{$LNG.cronjob_month}</th>
	<th>{$LNG.cronjob_dow}</th>
	<th>{$LNG.cronjob_class}</th>
	<th>{$LNG.cronjob_nextTime}</th>
	<th>{$LNG.cronjob_inActive}</th>
	<th>{$LNG.cronjob_lock}</th>
	<th>{$LNG.cronjob_edit}</th>
	<th>{$LNG.cronjob_delete}</th>
</tr>
{foreach item=CronjobInfo from=$CronjobArray}
<tr>
	<td>{$CronjobInfo.id}</td>
	<td>{if isset($LNG.cronName[$CronjobInfo.name])}{$LNG.cronName[$CronjobInfo.name]}{else}{$CronjobInfo.name}{/if}</td>
	<td>{$CronjobInfo.min}</td>
	<td>{$CronjobInfo.hours}</td>
	<td>{$CronjobInfo.dom}</td>
	<td>{if $CronjobInfo.month == '*'}{$CronjobInfo.month}{else}{foreach item=month from=$CronjobInfo.month}{$LNG.months.{$month-1}}{/foreach}{/if}</td>
	<td>{if $CronjobInfo.dow == '*'}{$CronjobInfo.dow}{else}{foreach item=d from=$CronjobInfo.dow}{$LNG.week_day.{$d}} {/foreach}{/if}</td>
	<td>{$CronjobInfo.class}</td>
	<td>{if $CronjobInfo.isActive}{date($LNG.php_tdformat, $CronjobInfo.nextTime)}{else}-{/if}</td>
	<td><a href="admin.php?page=cronjob&amp;id={$CronjobInfo.id}&amp;active={if $CronjobInfo.isActive}0" style="color:lime">{$LNG.cronjob_inactive}{else}1" style="color:red">{$LNG.cronjob_active}{/if}</a></td>
	<td><a href="admin.php?page=cronjob&amp;id={$CronjobInfo.id}&amp;lock={if $CronjobInfo.lock}0" style="color:red">{$LNG.cronjob_is_lock}{else}1" style="color:lime">{$LNG.cronjob_is_unlock}{/if}</a></td>
	<td><a href="admin.php?page=cronjob&detail={$CronjobInfo.id}"><img src="./styles/resource/images/admin/GO.png"></a></td>
	<td><a href=""><img src="./styles/resource/images/false.png" width="16" height="16"></a></td>
</tr>
{/foreach}
<tr>
<td colspan="13"><a href="admin.php?page=cronjob&detail=add">{$LNG.cronjob_new}</a></td>
</tr>
</table>
</body>
{include file="overall_footer.tpl"}