{include file="overall_header.tpl"}
<table style="width:760px">
	<tr>
		<th>{$mip_ip}</th>
		<th>{$LNG.se_id_owner}</th>
		<th>{$LNG.se_name}</th>
		<th>{$LNG.se_email}</th>
		<th>{$LNG.ac_register_time}</th>
		<th>{$LNG.ac_act_time}</th>
	</tr>
	{foreach $IPs as $IP => $Users}
	<tr>
		<td rowspan="{count($Users)}">{$IP}</td>
		{foreach $Users as $ID => $User}
		<td class="left" style="padding:3px;">{$ID}</td>
		<td class="left" style="padding:3px;"><a href="admin.php?page=accountdata&id_u={$ID}">{$User.username} (?)</a></td>
		<td class="left" style="padding:3px;">{$User.email}</td>
		<td class="left" style="padding:3px;">{$User.register_time}</td>
		<td class="left" style="padding:3px;">{$User.onlinetime}</td>
		</tr>{if !$User@last}<tr>{/if}
		{/foreach}
	{/foreach}
</table>
{include file="overall_footer.tpl"}