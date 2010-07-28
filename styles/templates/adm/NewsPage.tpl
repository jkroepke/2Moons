{include file="adm/overall_header.tpl"}
{if isset($mode)}
<form method="POST" action="?page=news&amp;action=send&amp;mode={$mode}">
{if $news_id}<input name="id" type="hidden" value="{$news_id}">{/if}
<table>
<tr>
	<td class="c" colspan="2">{$nws_head}</td>
</tr>
<tr>
<tr>
	<th width="25%">{$nws_title}</th><th><input type="text" name="title" value="{$news_title}"></th>
</tr>
<tr>
	<th>{$nws_content}</th><th><textarea cols="70" rows="10" name="text">{$news_text}</textarea></th>
</tr>
<tr>
	<th colspan="2"><input type="submit" name="Submit" value="{$button_submit}"></th>
</tr>
</table>
</form>
{/if}
<table width="450">
<tr>
	<td class="c" colspan="5">{$nws_news}</td>
</tr>
<tr>
	<th>{$nws_id}</th>
	<th>{$nws_title}</th>
	<th>{$nws_date}</th>
	<th>{$nws_from}</th>
	<th>{$nws_del}</th>
</tr>
{foreach name=NewsList item=NewsRow from=$NewsList}<tr>"
<th><a href="?page=news&amp;action=edit&amp;id={$NewsRow.id}">{$NewsRow.id}</a></td>
<th><a href="?page=news&amp;action=edit&amp;id={$NewsRow.id}">{$NewsRow.title}</a></td>
<th><a href="?page=news&amp;action=edit&amp;id={$NewsRow.id}">{$NewsRow.date}</a></td>
<th><a href="?page=news&amp;action=edit&amp;id={$NewsRow.id}">{$NewsRow.user}</a></td>
<th><a href="?page=news&amp;action=delete&amp;id={$NewsRow.id}" onclick="return confirm('{$NewsRow.confirm}');"><img border="0" src="./styles/images/r1.png"></a></td>
</tr>
{/foreach}
<tr><th colspan="5>"<a href="?page=news&amp;action=create">{$nws_create}</a></th></tr>
<tr><th colspan="5">{$nws_total}</th></tr>
</table>
{include file="adm/overall_footer.tpl"}