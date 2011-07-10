{include file="overall_header.tpl"}
<form action="game.php?page=notes&amp;action=delete" method="POST">
  <table style="width:90%;">
    <tr>
      <th colspan="4">{$nt_notes}</th>
    </tr>
    <tr>
      <td colspan="4"><a href="game.php?page=notes&amp;action=create">{$nt_create_new_note}</a></td>
    </tr>
    <tr>
      <th>{$nt_dlte_note}</th>
      <th>{$nt_date_note}</th>
      <th>{$nt_subject_note}</th>
      <th>{$nt_size_note}</th>
    </tr>
	{foreach item=NoteInfo name=NoteList from=$NoteList}
	<tr>
		<td style="width:20px;"><input name="delmes[{$NoteInfo.id}]" type="checkbox"></td>
		<td style="width:150px;">{$NoteInfo.time}</td>
		<td><a href="game.php?page=notes&amp;action=show&amp;id={$NoteInfo.id}">
		{if {$NoteInfo.priority} == 0}
		<span style="color:lime">{$NoteInfo.title}</span>
		{elseif {$NoteInfo.priority} == 2}
		<span style="color:red">{$NoteInfo.title}</span>
		{else}
		<span style="color:yellow">{$NoteInfo.title}</span>
		{/if}
		</a></td>
		<td style="width:40px;">{$NoteInfo.size}</td>
	</tr>
	{/foreach}
	{if {$smarty.foreach.NoteList.total} == 0}<tr><th colspan="4">{$nt_you_dont_have_notes}</th>{/if}
	<tr>
      <td colspan="4"><input value="{$nt_dlte_note}" type="submit"></td>
    </tr>
  </table>
</form>
{include file="overall_footer.tpl"}