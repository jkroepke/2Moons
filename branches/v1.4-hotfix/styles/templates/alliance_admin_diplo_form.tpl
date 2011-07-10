{include file="overall_header.tpl"}
<script type="text/javascript">

function check(){
	if(document.message.text.value == '') {
		alert('{$mg_empty_text}');
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
    <table style="widtd:95%">
    <tr>
        <th colspan="2">{$al_diplo_create}</th>
    </tr><tr>
        <td>{$al_diplo_ally}</td>
        <td>{html_options name=id options=$AllianceList}</td>
    </tr><tr>
        <td>{$al_diplo_level_des}</td>
        <td>{html_options name=level options=$al_diplo_level}</td>
    </tr><tr>
        <td>{$al_diplo_text}</td>
        <td><textarea name="text" id="text" cols="40" rows="10"></textarea></td>
    </tr><tr>
        <td colspan="2"><input type="button" onClick="check();" name="button" value="{$al_applyform_send}"</td>
	</tr>
</table>
</form>
{include file="overall_footer.tpl"}