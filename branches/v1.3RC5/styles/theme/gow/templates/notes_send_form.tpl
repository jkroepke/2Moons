{include file="overall_header.tpl"}
<form action="?page=notes&amp;action=send" method="POST">
  <table style="width:90%;">
    <tr>
      <th colspan="2">{$nt_create_note}</th>
    </tr>
    <tr>
      <td>{$nt_priority}</td>
      <td>
        <select name="priority">
			<option value="2">{$nt_important}</option>
			<option value="1" selected>{$nt_normal}</option>
			<option value="0">{$nt_unimportant}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>{$nt_subject_note}</td>
      <td>
        <input type="text" name="title" size="30" maxlength="30">
      </td>
    </tr>
    <tr>
      <td>{$nt_note} (<span id="cntChars">0</span> / 5000 {$nt_characters})</th>
      <td>
        <textarea name="text" cols="60" rows="10" onkeyup="$('#cntChars').text($(this).val().length);"></textarea>
      </td>
    </tr>
    <tr>
      <td><a href="game.php?page=notes">{$nt_back}</a></td>
      <td>
        <input type="reset" value="{$nt_reset}">
        <input type="submit" value="{$nt_save}">
      </td>
    </tr>
  </table>
</form>
{include file="overall_footer.tpl"}