{include file="overall_header.tpl"}
<script type="text/javascript">

function check(){
	if($('#text').val().length == 0) {
		alert('{$mg_empty_text}');
		return false;
	} else {
		$.post('game.php?page=messages&mode=write&id={$id}&send=1&ajax=1', $('#message').serialize(), function(data) {
			alert(data);
			window.close();
			return true;
		});
	}
}
</script>
    <form name="message" id="message" action="">
    <table width="95%" align="center">
    <tr>
        <td class="c" colspan="2">{$mg_send_new}</td>
    </tr><tr>
        <th>{$mg_send_to}</th>
        <th><input type="text" name="to" size="40" value="{$username} [{$galaxy}:{$system}:{$planet}]"></th>
    </tr><tr>
        <th>{$mg_subject}</th>
        <th><input type="text" name="subject" id="subject" size="40" maxlength="40" value="{$subject}"></th>
    </tr><tr>
        <th>{$mg_message} (<span id="cntChars">0</span> / 5000 {$mg_characters})</th>
        <th><textarea name="text" id="text" cols="40" rows="10" onkeyup="$('#cntChars').text($('#text').val().length);"></textarea></th>
    </tr><tr>
        <th colspan="2"><input type="button" onClick="check();" name="button" value="{$mg_send}"></th>
	</tr>
</table>
</form>
{include file="overall_footer.tpl"}