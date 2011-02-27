<form action="?page=fleet&amp;action=getakspage" method="POST">
<input name="fleetid" value="{$fleetid}" type="hidden">
<input name="aks_invited_mr" value="{$aks_invited_mr}" type="hidden">
	<table class="table519">
		<tr style="height:20px;">
			<th colspan="2">{$fl_sac_of_fleet}</th>
		</tr>
		<tr style="height:20px;">
			<th colspan="2">{$fl_modify_sac_name} (<a href="javascript:Rename();">{$fl_acs_change}</a>)</th>
		</tr>
		<tr>
			<td colspan="2" id="aks_name">{$aks_code_mr}</td>
		</tr>
		<tr style="height:20px;">
			<th style="width:50%;">{$fl_members_invited}</th>
            <th style="width:50%;">{$fl_invite_members}</th>
		</tr>
		<tr>
			<td>
				<select size="5" style="width:80%;">
                {$selector}
                </select>
			</td>
			<td>
				<input name="addtogroup" type="text"><br><input type="submit" value="{$fl_continue}">
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
function Rename(){
	var Name = prompt("{$fl_acs_change_name}", "{$aks_code_mr}");
	$.get('?page=fleet&action=getakspage&fleetid={$fleetid}&name='+Name, function(data) {
		if(data != "") {
			alert(data);
			return;
		}
		$('#aks_name').text(Name);
	});
}
</script>