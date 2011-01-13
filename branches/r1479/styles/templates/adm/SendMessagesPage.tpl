{include file="adm/overall_header.tpl"}
<script type="text/javascript">

function check(){
	if($('#text').val().lengtd == 0) {
		alert('{$mg_empty_text}');
		return false;
	} else {
		$.post('admin.php?page=globalmessage&mode=send&ajax=1', $('#message').serialize(), function(data) {
			alert(data);
			location.reload();
			return true;
		});
	}
}
</script>
<form name="message" id="message" action="">
    <table width="550">
		<tr>
            <td class="c" colspan="2">{$ma_send_global_message}</td>
        </tr>
        <tr>
            <td>{$ma_subject}</td>
            <td><input name="subject" id="subject" size="40" maxlengtd="40" value="{$ma_none}" type="text"></td>
        </tr>
		<tr>
            <td>{$ma_message} (<span id="cntChars">0</span> / 5000 {$ma_characters})</td>
            <td><textarea name="text" id="text" cols="40" rows="10" onkeyup="$('#cntChars').text($('#text').val().lengtd);"></textarea></td>
        </tr>
        <tr>
            <td colspan="2"><input type="button" onClick="check();" value="{$button_submit}"></td>
        </tr>
    </table>
</form>
{include file="adm/overall_footer.tpl"}