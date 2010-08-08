<form action="?page=fleet&amp;action=getakspage" method="POST">
<input name="fleetid" value="{$fleetid}" type="hidden">
<input name="aks_invited_mr" value="{$aks_invited_mr}" type="hidden">
	<table width="519" border="0" cellpadding="0" cellspacing="1" align="center">
		<tr style="height:20px;">
			<td class="c" colspan="2">{$fl_sac_of_fleet}</td>
		</tr>
		<tr style="height:20px;">
			<td class="c" colspan="2">{$fl_modify_sac_name} (<a href="javascript:Rename();">{$fl_acs_change}</a>)</td>
		</tr>
		<tr>
			<th colspan="2"><span id="aks_name">{$aks_code_mr}</span></th>
		</tr>
		<tr style="height:20px;">
			<td class="c" style="width:50%;">{$fl_members_invited}</td>
            <td class="c" style="width:50%;">{$fl_invite_members}</td>
		</tr>
		<tr>
			<th>
				<select size="5" style="width:80%;">
                {$selector}
                </select>
			</th>
			<th>
				<input name="addtogroup" type="text"><br><input type="submit" value="{$fl_continue}">
			</th>
		</tr>
	</table>
</form>
<script type="text/javascript">
function Rename(){
	Name = prompt("{$fl_acs_change_name}", "{$aks_code_mr}");
	$.get('?page=fleet&action=getakspage&fleetid={$fleetid}&name='+Name, function(data) {
		if(data != "") {
			alert(data);
			return;
		}
		$('#aks_name').text(Name);
	});
}
</script>