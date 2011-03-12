<span id="head" style="display:none;">{$mg_send_new}</span>
<span id="send" style="display:none;">{$mg_send}</span>
<span id="empty" style="display:none;">{$mg_empty_text}</span>
<form name="message" id="message" action="">
    <table style="width:100%">
	<tr>
		<td class="transparent" colspan="2"><div id="old_mes"> </div></td>
    </tr>
	<tr>
		<td class="transparent">{$mg_send_to}</td>
        <td class="transparent"><input type="text" name="to" size="40" value="{$username} [{$galaxy}:{$system}:{$planet}]"></td>
    </tr><tr>
        <td class="transparent">{$mg_subject}</td>
        <td class="transparent"><input type="text" name="subject" id="subject" size="40" maxlength="40" value="{$subject}"></td>
    </tr><tr>
        <td class="transparent">{$mg_message} (<span id="cntChars">0</span> / 5000 {$mg_characters})</th>
        <td class="transparent"><textarea name="text" id="text" cols="40" rows="10" onkeyup="$('#cntChars').text($(this).val().length);"></textarea></td>
    </tr>
</table>
</form>