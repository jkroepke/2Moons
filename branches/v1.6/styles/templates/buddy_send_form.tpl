{include file="overall_header.tpl"}
<script type="text/javascript">

function check(){
	if(document.buddy.text.value == '') {
		alert('{lang}mg_empty_text{/lang}');
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
        <th colspan="2">{lang}bu_request_message{/lang}</th>
    </tr><tr>
        <td>{lang}bu_player{/lang}</td>
        <td>{$username}</td>
    </tr><tr>
        <td>{lang}bu_request_text{/lang}(<span id="cntChars">0</span> / 5000 {lang}bu_characters{/lang})</td>
        <td><textarea name="text" id="text" cols="40" rows="10" size="100" onkeyup="$('#cntChars').text($(this).val().length);"></textarea></td>
    </tr><tr>
        <td colspan="2"><input type="button" onclick="return check();" name="button" value="{lang}bu_send{/lang}"></td>
	</tr>
</table>
</form>
{include file="overall_footer.tpl"}
