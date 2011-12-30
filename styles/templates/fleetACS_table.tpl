<form action="?page=fleet&amp;action=getakspage" method="POST">
<input name="fleetID" value="{$fleetID}" type="hidden">
	<table class="table519">
		<tr style="height:20px;">
			<th colspan="2">{lang}fl_sac_of_fleet{/lang}</th>
		</tr>
		<tr style="height:20px;">
			<th colspan="2">{lang}fl_modify_sac_name{/lang} (<a href="javascript:Rename();">{lang}fl_acs_change{/lang}</a>)</th>
		</tr>
		<tr>
			<td colspan="2" id="acsName">{$acsName}</td>
		</tr>
		<tr style="height:20px;">
			<th style="width:50%;">{lang}fl_members_invited{/lang}</th>
            <th style="width:50%;">{lang}fl_invite_members{/lang}</th>
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
				<p><input type="submit" value="{lang}fl_continue{/lang}"></p>
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
function Rename(){
	var Name = prompt("{lang}fl_acs_change_name{/lang}", "{$acsName}");
	$.get('?page=fleet&action=getakspage&fleetID={$fleetID}&acsName='+Name, function(data) {
		if(data != "") {
			Dialog.alert(data);
			return;
		}
		$('#acsName').text(Name);
	});
}
</script>