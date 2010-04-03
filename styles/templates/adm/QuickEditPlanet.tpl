<script type="text/javascript">

function check(){
	$.post('QuickEditor.php?edit=planet&id={id}&action=send', $('#userform').serialize(), function(data){
		alert(data);
		opener.location.reload();
		window.close();
	});
	return true;
}
</script>
<form method="post" id="userform">
<table width="100%" style="color:#FFFFFF"><tr>
        <td class="c" colspan="3">{qe_info}</td>
</tr>
<tr><th width="50%">{qe_id}:</th><th width="50%">{id}</th></tr>
<tr><th width="50%">{qe_name}:</th><th width="50%"><input name="name" type="text" size="15" value="{name}"></th></tr>
<tr><th width="50%">{qe_coords}:</th><th width="50%">[{galaxy}:{system}:{planet}]</th></tr>
<tr><th width="50%">{qe_owner}:</th><th width="50%">{ownername} ({qe_id}: {ownerid})</th></tr>
<tr><th width="50%">{qe_fields}:</th><th width="50%">{field_min} / <input name="field_max" type="text" size="3" value="{field_max}"></th></tr>
<tr><th width="50%">{qe_temp}:</th><th width="50%">{temp_min} / {temp_max}</th></tr>
</table>
<table width="100%" style="color:#FFFFFF">
<tr>
        <td class="c" colspan="3">{qe_resources}</td>
</tr>
<tr>
        <th>{qe_name}</th><th>{qe_count}</th><th>{qe_input}</th>
</tr>
<tr><th width="30%">{Metal}:</th><th width="30%">{metal_c}</th><th width="40%"><input name="metal" type="text" value="{metal}"></th></tr>
<tr><th width="30%">{Crystal}:</th><th width="30%">{crystal_c}</th><th width="40%"><input name="crytsal" type="text" value="{crystal}"></th></tr>
<tr><th width="30%">{Deuterium}:</th><th width="30%">{deuterium_c}</th><th width="40%"><input name="deuterium" type="text" value="{deuterium}"></th></tr>
</table>
<table width="100%" style="color:#FFFFFF">
<tr>
        <td class="c" colspan="3">{qe_build}</td>
</tr>
<tr>
        <th>{qe_name}</th><th>{qe_count}</th><th>{qe_input}</th>
</tr>
{build}
</table>
<table width="100%" style="color:#FFFFFF">
<tr>
        <td class="c" colspan="3">{qe_fleet}</td>
</tr>
<tr>
        <th>{qe_name}</th><th>{qe_count}</th><th>{qe_input}</th>
</tr>
{fleet}
</table>
<table width="100%" style="color:#FFFFFF">
<tr>
        <td class="c" colspan="3">{qe_defensive}</td>
</tr>
<tr>
        <th>{qe_name}</th><th>{qe_count}</th><th>{qe_input}</th>
</tr>
{defense}
<tr>
        <th colspan="3"><input type="button" onClick="return check();" value="{qe_send}"> <input type="reset" value="{qe_reset}"></th>
</tr>
</table>
</form>