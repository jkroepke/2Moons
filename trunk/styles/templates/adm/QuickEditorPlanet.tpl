{include file="overall_header.tpl"}
<script type="text/javascript">
function check(){
	$.post('?page=qeditor&edit=planet&id={$id}&action=send', $('#userform').serialize(), function(data){
		Dialog.alert(data, function() {
			opener.location.reload();
			window.close();
		});
	});
	return false;
}
</script>
<form method="post" id="userform" action="" onsubmit="return check();">
<table width="100%" style="color:#FFFFFF"><tr>
        <th colspan="3">{$LNG.qe_info}</th>
</tr>
<tr style="height:26px;"><td width="50%">{$LNG.qe_id}:</td><td width="50%">{$id}</td></tr>
<tr><td width="50%">{$LNG.qe_planetname}:</td><td width="50%"><input name="name" type="text" size="15" value="{$name}"></td></tr>
<tr style="height:26px;"><td width="50%">{$LNG.qe_coords}:</td><td width="50%">[{$galaxy}:{$system}:{$planet}]</td></tr>
<tr style="height:26px;"><td width="50%">{$LNG.qe_owner}:</td><td width="50%">{$ownername} ({$LNG.qe_id}: {$ownerid})</td></tr>
<tr><td width="50%">{$LNG.qe_fields}:</td><td width="50%">{$field_min} / <input name="field_max" type="text" size="3" value="{$field_max}"></td></tr>
<tr style="height:26px;"><td width="50%">{$LNG.qe_temp}:</td><td width="50%">{$temp_min} / {$temp_max}</td></tr>
</table>
<table width="100%" style="color:#FFFFFF">
<tr>
        <th colspan="3">{$LNG.qe_resources}</th>
</tr>
<tr>
        <td></td><td>{$LNG.qe_count}</td><td>{$LNG.qe_input}</td>
</tr>
<tr><td width="30%">{$LNG.tech.901}:</td><td width="30%">{$metal_c}</td><td width="40%"><input name="metal" type="text" value="{$metal}"></td></tr>
<tr><td width="30%">{$LNG.tech.902}:</td><td width="30%">{$crystal_c}</td><td width="40%"><input name="crystal" type="text" value="{$crystal}"></td></tr>
<tr><td width="30%">{$LNG.tech.903}:</td><td width="30%">{$deuterium_c}</td><td width="40%"><input name="deuterium" type="text" value="{$deuterium}"></td></tr>
</table>
<table width="100%" style="color:#FFFFFF">
<tr>
        <th colspan="3">{$LNG.qe_build}</th>
</tr>
<tr>
        <td></td><td>{$LNG.qe_level}</td><td>{$LNG.qe_input}</td>
</tr>
{foreach item=Element from=$build}
<tr><td width="30%">{$Element.name}:</td><td width="30%">{$Element.count}</td><td width="40%"><input name="{$Element.type}" type="text" value="{$Element.input}"></td>
{/foreach}
</table>
<table width="100%" style="color:#FFFFFF">
<tr>
        <th colspan="3">{$LNG.qe_fleet}</th>
</tr>
<tr>
        <td></td><td>{$LNG.qe_count}</td><td>{$LNG.qe_input}</td>
</tr>
{foreach item=Element from=$fleet}
<tr><td width="30%">{$Element.name}:</td><td width="30%">{$Element.count}</td><td width="40%"><input name="{$Element.type}" type="text" value="{$Element.input}"></td>
{/foreach}
</table>
<table width="100%" style="color:#FFFFFF">
<tr>
        <th colspan="3">{$LNG.qe_defensive}</th>
</tr>
<tr>
        <td></td><td>{$LNG.qe_count}</td><td>{$LNG.qe_input}</td>
</tr>
{foreach item=Element from=$defense}
<tr><td width="30%">{$Element.name}:</td><td width="30%">{$Element.count}</td><td width="40%"><input name="{$Element.type}" type="text" value="{$Element.input}"></td>
{/foreach}
<tr>
        <td colspan="3"><input type="submit" value="{$qe_send}"> <input type="reset" value="{$qe_reset}"></td>
</tr>
</table>
</form>
{include file="overall_footer.tpl"}