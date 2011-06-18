<span id="head" style="display:none;">{lang}mg_send_new{/lang}</span>
<span id="send" style="display:none;">{lang}mg_send{/lang}</span>
<span id="empty" style="display:none;">{lang}mg_empty_text{/lang}</span>
<form name="message" id="message" action="">
    <table style="width:100%">
	<tr>
		<td class="transparent" colspan="2"><div id="old_mes"> </div></td>
    </tr>
	<tr>
		<td class="transparent"><label for="to">{lang}mg_send_to{/lang}</label></td>
        <td class="transparent"><input type="text" id="to" name="to" size="40" value="{$OwnerRecord.username} [{$OwnerRecord.galaxy}:{$OwnerRecord.system}:{$OwnerRecord.planet}]"></td>
    </tr><tr>
        <td class="transparent"><label for="subject">{lang}mg_subject{/lang}</label></td>
        <td class="transparent"><input type="text" name="subject" id="subject" size="40" maxlength="40" value="{if !empty($subject)}{$subject}{else}{lang}mg_no_subject{/lang}{/if}"></td>
    </tr><tr>
        <td class="transparent"><label for="text">{lang}mg_message{/lang}</label> (<span id="cntChars">0</span> / 5000 {lang}mg_characters{/lang})</th>
        <td class="transparent"><textarea name="text" id="text" cols="40" rows="10" onkeyup="$('#cntChars').text($(this).val().length);"></textarea></td>
    </tr>
</table>
</form>