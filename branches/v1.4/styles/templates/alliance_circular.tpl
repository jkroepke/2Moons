{include file="overall_header.tpl"}
<script type="text/javascript">

function check(){
	if(document.message.text.value == '') {
		alert('{$mg_empty_text}');
		return false;
	} else {
		$.post('game.php?page=alliance&mode=circular&action=send&ajax=1', $('#message').serialize(), function(data){
			alert(data);
			window.close();
		});
		return true;
	}
}
</script>
<br>
    <form name="message" id="message">
      <table style="width:95%">
        <tr>
          <th colspan="2">{$al_circular_send_ciruclar}</th>
        </tr>
        <tr>
          <td>{$al_receiver}</td>
          <td>
            {html_options name=r options=$RangeList}
          </td>
        </tr><tr>
        <td>{$mg_subject}</td>
        <td><input type="text" name="subject" id="subject" size="40" maxlength="40" value="{$mg_no_subject}"></td>
		</tr>
        <tr>
          <td>{$al_message} (<span id="cntChars">0</span> / 5000 {$al_characters})</td>
          <td>
            <textarea name="text" cols="60" rows="10" onkeyup="$('#cntChars').text($(this).val().length);"></textarea>
          </td>
        </tr>
        <tr>
          <th colspan="2" style="text-align:center;">
            <input type="reset" value="{$al_circular_reset}">
            <input type="button" onClick="return check();" name="button" value="{$al_circular_send_submit}">
          </th>
        </tr>
      </table>
    </form>
{include file="overall_footer.tpl"}