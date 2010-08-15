{include file="overall_header.tpl"}
<script type="text/javascript" src="scripts/cntchar.js"></script>
<script type="text/javascript">

function check(){
	if(document.buddy.text.value == '') {
		alert('Gebe einen Text ein!');
		return false;
	} else {
		$.post('game.php?page=buddy&mode=1&sm=3&u={$id}&ajax=1', $('#buddy').serialize(), function(data){
			alert(data);
			window.close();
		});
		return true;
	}
}
</script>
<form name="buddy" id="buddy">
    <table style="width:95%">
    <tr>
        <th colspan="2">{$bu_request_message}</th>
    </tr><tr>
        <td>{$bu_player}</td>
        <td>{$username}</td>
    </tr><tr>
        <td>{$mg_message} (<span id="cntChars">0</span> / 5000 {$mg_characters})</td>
        <td><textarea name="text" id="text" cols="40" rows="10" size="100"></textarea></td>
    </tr><tr>
        <td colspan="2"><input type="button" onClick="return check();" name="button" value="{$bu_send}"></td>
	</tr>
</table>
</form>
{include file="overall_footer.tpl"}
