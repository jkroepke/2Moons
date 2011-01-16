{include file="overall_header.tpl"}
<script type="text/javascript">

function check(){
	if($('#text').val().length == 0) {
		alert('{$mg_empty_text}');
		return false;
	} else {
		$('submit').attr('disabled','disabled');
		$.post('game.php?page=messages&mode=write&id={$id}&send=1&ajax=1', $('#message').serialize(), function(data) {
			alert(data);
			window.close();
			return true;
		});
	}
}
</script>
    <form name="message" id="message" action="">
    <table style="width:95%">
    <tr>
        <th colspan="2">{$mg_send_new}</th>
    </tr><tr>
        <td>{$mg_send_to}</td>
        <td><input type="text" name="to" size="40" value="{$username} [{$galaxy}:{$system}:{$planet}]"></td>
    </tr><tr>
        <td>{$mg_subject}</td>
        <td><input type="text" name="subject" id="subject" size="40" maxlength="40" value="{$subject}"></td>
    </tr><tr>
        <td>{$mg_message} (<span id="cntChars">0</span> / 5000 {$mg_characters})</th>
        <td><textarea name="text" id="text" cols="40" rows="10" onkeyup="$('#cntChars').text($(this).val().length);"></textarea></td>
    </tr><tr>
        <td colspan="2"><input id="submit" type="button" onClick="check();" name="button" value="{$mg_send}"></td>
	</tr>
</table>
</form>
{include file="overall_footer.tpl"}