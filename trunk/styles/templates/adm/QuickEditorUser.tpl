{include file="overall_header.tpl"}
<script type="text/javascript">
function check(){
	$.post('?page=qeditor&edit=player&id={$id}&action=send', $('#userform').serialize(), function(data){
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
<tr><td width="50%">{$LNG.qe_username}:</td><td width="50%"><input name="name" type="text" size="15" value="{$name}" autocomplete="off"></td></tr>
<tr style="height:26px;"><td width="50%">{$LNG.qe_hpcoords}:</td><td width="50%">{$planetname} [{$galaxy}:{$system}:{$planet}] ({$LNG.qe_id}: {$planetid})</td></tr>
{if $authlevl != $smarty.const.AUTH_USER}
<tr style="height:26px;"><td width="50%">{$LNG.qe_authattack}:</td><td width="50%"><input type="checkbox" name="authattack"{if $authattack != 0} checked{/if}></td></tr>
{/if}
{if $ChangePW}
<tr style="height:26px;"><td width="50%">{$LNG.qe_password}:</td><td width="50%"><a href="#" onclick="$('#password').css('display', '');$(this).css('display', 'none');return false">{$qe_change}</a><input style="display:none;" id="password" name="password" type="password" size="15" value="" autocomplete="off"></td></tr>
{/if}
</table>
<table width="100%" style="color:#FFFFFF">
<tr>
        <th colspan="3">{$LNG.qe_resources}</th>
</tr>
<tr>
        <td>{$LNG.qe_name}</td><td>{$LNG.qe_count}</td><td>{$LNG.qe_input}</td>
</tr>
<tr><td width="30%">{$LNG.tech.921}:</td><td width="30%">{$darkmatter_c}</td><td width="40%"><input name="darkmatter" type="text" value="{$darkmatter}"></td></tr>
</table>
<table width="100%" style="color:#FFFFFF">
<tr>
        <th colspan="3">{$LNG.qe_tech}</th>
</tr>
<tr>
        <td>{$LNG.qe_name}</td><td>{$LNG.qe_level}</td><td>{$LNG.qe_input}</td>
</tr>
{foreach item=Element from=$tech}
<tr><td width="30%">{$Element.name}:</td><td width="30%">{$Element.count}</td><td width="40%"><input name="{$Element.type}" type="text" value="{$Element.input}"></td>
{/foreach}
<tr>
        <th colspan="3">{$LNG.qe_officier}</th>
</tr>
<tr>
        <td>{$LNG.qe_name}</td><td>{$LNG.qe_level}</td><td>{$LNG.qe_input}</td>
</tr>
{foreach item=Element from=$officier}
<tr><td width="30%">{$Element.name}:</td><td width="30%">{$Element.count}</td><td width="40%"><input name="{$Element.type}" type="text" value="{$Element.input}"></td>
{/foreach}
<tr>
        <td colspan="3"><input type="submit" value="{$qe_send}"> <input type="reset" value="{$qe_reset}"></td>
</tr>
</table>
</form>
{include file="overall_footer.tpl"}