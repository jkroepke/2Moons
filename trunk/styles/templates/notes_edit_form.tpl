{include file="overall_header.tpl"}
<form action="?page=notes&amp;action=send&amp;id={$id}" method="POST">
  <table style="width:90%;">
    <tr>
      <th colspan="2">{$nt_edit_note}</th>
    </tr>
    <tr>
      <td>{$nt_priority}</td>
      <td>
		{html_options name=priority options=$PriorityList selected=$priority}
      </td>
    </tr>
    <tr>
      <td>{$nt_subject_note}</td>
      <td>
        <input type="text" name="title" size="30" maxlength="30" value="{$ntitle}">
      </td>
    </tr>
    <tr>
      <td>{$nt_note} (<span id="cntChars">0</span> / 5000 {$nt_characters})</td>
      <td>
        <textarea name="text" id="text" cols="60" rows="10" onkeyup="$('#cntChars').text($(this).val().length);">{$ntext}</textarea>
      </td>
    </tr>
    <tr>
      <th><a href="game.php?page=notes">{$nt_back}</a></th>
      <th>
        <input type="reset" value="{$nt_reset}">
        <input type="submit" value="{$nt_save}">
      </th>
    </tr>
  </table>
</form>
<script type="text/javascript">
$('#cntChars').text($('#text').val().length);
</script>
{include file="overall_footer.tpl"}