{include file="overall_header.tpl"}
<script src="scripts/cntchar.js" type="text/javascript"></script>
<form action="?page=notes&amp;action=send&amp;id={$id}" method="POST">
  <table width="519" align="center">
    <tr>
      <td class="c" colspan="2">{$nt_edit_note}</td>
    </tr>
    <tr>
      <th>{$nt_priority}</th>
      <th>
        <select name="priority">
			{html_options options=$PriorityList selected=$priority}
        </select>
      </th>
    </tr>
    <tr>
      <th>{$nt_subject_note}</th>
      <th>
        <input type="text" name="title" size="30" maxlength="30" value="{$ntitle}">
      </th>
    </tr>
    <tr>
      <th>{$nt_note} (<span id="cntChars">0</span> / 5000 {$nt_characters})</th>
      <th>
        <textarea name="text" cols="60" rows="10" onkeyup="javascript:cntchar(5000)">{$ntext}</textarea>
      </th>
    </tr>
    <tr>
      <td class="c"><a href="game.php?page=notes">{$nt_back}</a></td>
      <td class="c">
        <input type="reset" value="{$nt_reset}">
        <input type="submit" value="{$nt_save}">
      </td>
    </tr>
  </table>
</form>
{include file="overall_footer.tpl"}