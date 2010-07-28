{include file="overall_header.tpl"}
<script type="text/javascript">

function check(){
	if(document.message.text.value == '') {
		alert('Gebe einen Text ein!');
		return false;
	} else {
		$.post('game.php?page=alliance&mode=admin&edit=diplo&action=new', $('#message').serialize(), function(data){
			alert(data);
			opener.location.reload();
			window.close();
		});
		return true;
	}
}
</script>
    <form name="message" id="message" action="">
    <table width="95%" align="center">
    <tr>
        <td class="c" colspan="2">{$al_diplo_create}</td>
    </tr><tr>
        <th>{$al_diplo_ally}</th>
        <th>{html_options name=id options=$AllianceList}</th>
    </tr><tr>
        <th>{$al_diplo_level_des}</th>
        <th>{html_options name=level options=$al_diplo_level}</th>
    </tr><tr>
        <th>{$al_diplo_text}</th>
        <th><textarea name="text" id="text" cols="40" rows="10"></textarea></th>
    </tr><tr>
        <th colspan="2"><input type="button" onClick="check();" name="button" value="{$al_applyform_send}">
</th>
</tr>
</table>
</form>
{include file="overall_footer.tpl"}