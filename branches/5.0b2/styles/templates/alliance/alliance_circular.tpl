<script type="text/javascript" src="scripts/cntchar.js"></script>
<script type="text/javascript">

function check(){
	if(document.message.text.value == '') {
		alert('Gebe einen Text ein!');
		return false;
	} else {
		$.post('game.php?page=alliance&mode=circular&sendmail=1', $('#message').serialize(), function(data){
			alert(data);
			window.close();
		});
		return true;
	}
}
</script>
<br>
    <form name="message" id="message">
      <table width="530">
        <tr>
          <td class="c" colspan=2>{al_circular_send_ciruclar}</td>
        </tr>
        <tr>
          <th>{al_receiver}</th>
          <th>
            <select name="r">
              {r_list}
            </select>
          </th>
        </tr>
        <tr>
          <th>{al_message} (<span id="cntChars">0</span> / 5000 {al_characters})</th>
          <th>
            <textarea name="text" cols="60" rows="10" onkeyup="javascript:cntchar(5000)"></textarea>
          </th>
        </tr>
        <tr>
          <td class="c"><a href="game.php?page=alliance">{al_back}</a></td>
          <td align="center" class="c">
            <input type="reset" value="{al_circular_reset}">
            <input type="button" onClick="return check();" name="button" value="{al_circular_send_submit}">
          </td>
        </tr>
      </table>
    </form>