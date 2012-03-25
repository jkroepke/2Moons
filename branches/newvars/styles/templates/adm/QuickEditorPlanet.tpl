{include file="overall_header.tpl"}
<script type="text/javascript">
function check(){
	$.post('?page=qeditor&edit=planet', $('#userform').serialize(), function(data){
		Dialog.alert(data, function() {
			opener.location.reload();
			window.close();
		});
	});
	return false;
}
</script>

<form method="post" id="userform" action="" onsubmit="return check();">
	<input type="hidden" name="id" value="{$id}">
	<input type="hidden" name="action" value="send">
	<table width="100%">
	<tr>
        <th colspan="3">{$LNG.qe_info}</th>
	</tr>
	<tr style="height:26px;">
		<td width="50%">{$LNG.qe_id}:</td>
		<td width="50%">{$id}</td>
	</tr>
	<tr style="height:26px;">
		<td width="50%">{$LNG.qe_planetname}:</td>
		<td width="50%"><input name="name" type="text" size="15" value="{$planetData.name|escape:'html'}"></td>
	</tr>
	<tr style="height:26px;">
		<td width="50%">{$LNG.qe_coords}:</td>
		<td width="50%">[{$planetData.galaxy}:{$planetData.system}:{$planetData.planet}]</td>
	</tr>
	<tr style="height:26px;">
		<td width="50%">{$LNG.qe_owner}:</td>
		<td width="50%">{$planetData.username} ({$LNG.qe_id}: {$planetData.userid})</td>
	</tr>
	<tr style="height:26px;">
		<td width="50%">{$LNG.qe_fields}:</td>
		<td width="50%">{$planetData.field_current} / <input name="field_max" type="text" size="3" value="{$planetData.field_max}"></td>
	</tr>
	<tr style="height:26px;">
		<td width="50%">{$LNG.qe_temp}:</td>
		<td width="50%"><input name="temp_min" type="text" size="3" value="{$planetData.temp_min}"> / <input name="temp_max" type="text" size="3" value="{$planetData.temp_max}"></td>
	</tr>
</table>

<table width="100%" style="color:#FFFFFF">
	{foreach $elementData as $elementClass => $classData}
	<tr>
        <th colspan="3">{$LNG.tech.$elementClass}</th>
	</tr>
	<tr>
        <td>&nbsp;</td>
		<td>{$LNG.qe_count}</td>
		<td>{$LNG.qe_input}</td>
	</tr>
	{foreach $classData as $elementID => $elementName}
	<tr>
		<td width="30%">{$LNG.tech.$elementID}:</td>
		<td width="30%">{$planetData.$elementName|number}</td>
		<td width="40%"><input name="{$elementName}" type="text" value="{round($planetData.$elementName)}"></td>
	</tr>
	{/foreach}
	{/foreach}
	<tr>
        <td colspan="3"><input type="submit" value="{$qe_send}"> <input type="reset" value="{$qe_reset}"></td>
	</tr>
</table>
</form>
{include file="overall_footer.tpl"}