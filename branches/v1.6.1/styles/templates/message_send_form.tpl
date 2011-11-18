{include file="overall_header.tpl"}
<script type="text/javascript">

function check(){
	if($('#text').val().length == 0) {
		alert('{lang}mg_empty_text{/lang}');
		return false;
	} else {
		$('submit').attr('disabled','disabled');
		$.post('game.php?page=messages&mode=send&id={$id}&ajax=1', $('#message').serialize(), function(data) {
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
			<th colspan="2">{lang}mg_send_new{/lang}</th>
		</tr><tr>
			<td>{lang}mg_send_to{/lang}</td>
			<td><input type="text" name="to" size="40" value="{$OwnerRecord.username} [{$OwnerRecord.galaxy}:{$OwnerRecord.system}:{$OwnerRecord.planet}]"></td>
		</tr><tr>
			<td>{lang}mg_subject{/lang}</td>
			<td><input type="text" name="subject" id="subject" size="40" maxlength="40" value="{if !empty($subject)}{$subject}{else}{lang}mg_no_subject{/lang}{/if}"></td>
		</tr><tr>
			<td>{lang}mg_message{/lang} (<span id="cntChars">0</span> / 5000 {lang}mg_characters{/lang})</th>
			<td><textarea name="text" id="text" cols="40" rows="10" onkeyup="$('#cntChars').text($(this).val().length);"></textarea></td>
		</tr><tr>
			<td colspan="2"><input id="submit" type="button" onClick="check();" name="button" value="{lang}mg_send{/lang}"></td>
		</tr>
	</table>
</form>
{include file="overall_footer.tpl"}