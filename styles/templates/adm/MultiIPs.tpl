{include file="overall_header.tpl"}
<table style="width:760px">
	<tr>
		<th>{$mip_ip}</th>
		<th>{$LNG.se_id_owner}</th>
		<th>{$LNG.se_name}</th>
		<th>{$LNG.se_email}</th>
		<th>{$LNG.ac_register_time}</th>
		<th>{$LNG.ac_act_time}</th>
		<th>{$LNG.mip_known}</th>
	</tr>
	{foreach $multiGroups as $IP => $Users}
	<tr>
		<td rowspan="{count($Users)}">{$IP}</td>
		{foreach $Users as $ID => $User}
		<td class="left" style="padding:3px;">{$ID}</td>
		<td class="left" style="padding:3px;"><a href="admin.php?page=accountdata&id_u={$ID}">{$User.username} (?)</a></td>
		<td class="left" style="padding:3px;">{$User.email}</td>
		<td class="left" style="padding:3px;">{$User.register_time}</td>
		<td class="left" style="padding:3px;">{$User.onlinetime}</td>
		<td class="center" style="padding:3px;">{if ($User.isKnown != 0)}<a href="admin.php?page=multiips&amp;action=unknown&amp;id={$ID}"><img src="styles/images/true.png"></a>{else}<a href="admin.php?page=multiips&amp;action=known&amp;id={$ID}"><img src="styles/images/false.png"></a>{/if}</td>
		</tr>{if !$User@last}<tr>{/if}
		{/foreach}
	{/foreach}
</table>
{include file="overall_footer.tpl"}