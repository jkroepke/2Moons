<form action="?page=fleetTable&amp;action=acs" method="post">
<input name="fleetID" value="{$fleetID}" type="hidden">
	<table class="table519">
		<tr style="height:20px;">
			<th colspan="2">{$LNG.fl_sac_of_fleet}</th>
		</tr>
		<tr style="height:20px;">
			<th colspan="2">{$LNG.fl_modify_sac_name} (<a href="javascript:Rename();">{$LNG.fl_acs_change}</a>)</th>
		</tr>
		<tr>
			<td colspan="2" id="acsName">{$acsName}</td>
		</tr>
		<tr style="height:20px;">
			<th style="width:50%;">{$LNG.fl_members_invited}</th>
            <th style="width:50%;">{$LNG.fl_invite_members}</th>
		</tr>
		{if !empty($statusMessage)}
		<tr>
			<td colspan="2">
				{$statusMessage}
			</td>
		</tr>
		{/if}
		<tr>
			<td>
				<select size="5" style="width:80%;">
					{html_options options=$invitedUsers}
                </select>
			</td>
			<td>
				<p><input name="username" type="text"></p>
				<p><input type="submit" value="{$LNG.fl_continue}"></p>
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
function Rename(){
	var Name = prompt("{$LNG.fl_acs_change_name}", "{$acsName}");
	$.get('?page=fleetTable&action=acs&fleetID={$fleetID}&acsName='+Name, function(data) {
		if(data != "") {
			alert(data);
			return;
		}
		$('#acsName').text(Name);
	});
}
</script>