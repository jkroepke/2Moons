{include file="overall_header.tpl"}
<script type="text/javascript">

function check(){
	if($('#text').val().length == 0) {
		Dialog.alert('{$mg_empty_text}');
		return false;
	} else {
		$.post('admin.php?page=globalmessage&action=send&ajax=1', $('#message').serialize(), function(data) {
			Dialog.alert(data, function() {
				location.reload();
			});
		});
		return true;
	}
}
</script>
<form name="message" id="message" action="admin.php?page=globalmessage&action=send&ajax=1">
<table class="table569">
		<tr>
            <th colspan="2">{lang}ma_send_global_message{/lang}</th>
        </tr>
        <tr>
            <td>{lang}ma_mode{/lang}</td>
            <td>{html_options name=mode options=$modes}</td>
		</tr>
        <tr>
            <td>{lang}se_lang{/lang}</td>
            <td>{html_options name=lang options=$lang}</td>
        </tr>
        <tr>
            <td>{lang}ma_subject{/lang}</td>
            <td><input name="subject" id="subject" size="40" maxlength="40" value="{lang}ma_none{/lang}" type="text"></td>
        </tr>
		<tr>
            <td>{lang}ma_message{/lang} (<span id="cntChars">0</span> / 5000 {lang}ma_characters{/lang})</td>
            <td><textarea name="text" id="text" cols="40" rows="10" onkeyup="$('#cntChars').text($('#text').val().length);"></textarea></td>
        </tr>
        <tr>
            <td colspan="2"><input type="button" onclick="check();" value="{lang}button_submit{/lang}"></td>
        </tr>
    </table>
</form>
{include file="overall_footer.tpl"}