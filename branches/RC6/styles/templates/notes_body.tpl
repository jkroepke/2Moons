{include file="overall_header.tpl"}
<form action="game.php?page=notes&amp;action=delete" method="POST">
  <table width="519" align="center">
    <tr>
      <td class="c" colspan="4">{$nt_notes}</td>
    </tr>
    <tr>
      <th colspan="4"><a href="game.php?page=notes&amp;action=create">{$nt_create_new_note}</a></th>
    </tr>
    <tr>
      <td class="c">{$nt_dlte_note}</td>
      <td class="c">{$nt_date_note}</td>
      <td class="c">{$nt_subject_note}</td>
      <td class="c">{$nt_size_note}</td>
    </tr>
	{foreach item=NoteInfo name=NoteList from=$NoteList}
	<tr>
		<th width="20"><input name="delmes[{$NoteInfo.id}]" type="checkbox"></th>
		<th width="150">{$NoteInfo.time}</th>
		<th><a href="game.php?page=notes&amp;action=show&amp;id={$NoteInfo.id}">
		{if {$NoteInfo.priority} == 0}
		<font color="lime">{$NoteInfo.title}</font>
		{elseif {$NoteInfo.priority} == 2}
		<font color="red">{$NoteInfo.title}</font>
		{else}
		<font color="yellow">{$NoteInfo.title}</font>
		{/if}
		</a></th>
		<th align="right" width="40">{$NoteInfo.size}</th>
	</tr>
	{/foreach}
	{if {$smarty.foreach.NoteList.total} == 0}<tr><th colspan="4">{$nt_you_dont_have_notes}</th>{/if}
	<tr>
      <td colspan="4"><input value="{$nt_dlte_note}" type="submit"></td>
    </tr>
  </table>
</form>
{include file="overall_footer.tpl"}